<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Support;

use App\Model\File as FileModel;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * 分片上传和普通上传
 * 同时数据库管理文件
 * Class ChunkUpload
 * @package App\Support
 */
class ChunkUpload
{
    /**
     * 上传时的分块大小（B），默认为1M，越大传输越快
     * @var float|int
     */
    private $_chunkSize = 1 * 1000 * 1000;

    /**
     * 资源文件目录的子目录生成规则
     * @var null|string
     */
    private $_fileSubDir = null;

    /**
     * 设置保存盘
     * @var string
     */
    private $_disk = 'public';

    /**
     * 计数头目录
     * @var string
     */
    private $_headDir = 'chunk';

    /**
     * 被允许的资源文件大小（MB），0为不限制
     * @var int|false
     */
    private $_maxSize = false;

    /**
     * 被允许的资源文件扩展名，空为不限制，多个值以逗号分隔
     * @var string|bool
     */
    private $_extensions = false;

    /**
     * 写文件失败
     * 重命名文件失败
     *
     * 返回错误信息
     * @var string
     */
    private $_message = '';

    /**
     * 计数头文件
     * @var string
     */
    private $_uploadHead = '';

    /**
     * 上传的部分文件
     * @var string
     */
    private $_uploadPartialFile = '';

    /**
     * 当前分片号
     * @var int
     */
    private $_chunkIndex = 0;

    /**
     * 分片总数
     * @var int
     */
    private $_chunkTotalCount = 0;

    /**
     * @var \Illuminate\Http\UploadedFile|array|null
     */
    private $_file = null;

    /**
     * 上传类型的文件
     * @var string
     */
    private $_type = '';

    /**
     * 上传扩展名
     * @var string
     */
    private $_uploadExt = '';

    /**
     * 文件临时名
     * @var string
     */
    private $_uploadBaseName = '';

    /**
     * 文件原名
     * @var string
     */
    private $_origName = '';

    /**
     * 保存的hash值
     * @var string
     */
    private $_saveHash = '';

    /**
     * 初始化配置
     * ChunkUpload constructor.
     */
    public function __construct()
    {
        /* 子目录以年月设置 */
        $this->_fileSubDir = date('Ym');

        /* 设置上传盘 */
        $this->_disk = config('filesystems.default');
    }

    /**
     * 文件上传预处理
     * @param string $fileName 上传文件的名称
     * @param int $fileSize 上传文件的大小
     * @param null $fileHash 上传文件的hash值(md5_file加密值)
     * @param null $type 上传的类型(不传时必须使用setType)
     * @return array|bool
     */
    public function preProcess($fileName, $fileSize, $fileHash = null, $type = null)
    {
        $type === null or $this->_type = $type;

        $result = [
            'error' => 0,
            'chunkSize' => $this->_chunkSize,
            'subDir' => $this->_fileSubDir,
            'uploadBaseName' => '',
            'uploadExt' => '',
            'hash' => '',
            'url' => '',
        ];

        if (!($fileName && $fileSize && $this->_type)) {
            $this->_message = '缺少必要的文件参数';
            return false;
        }

        if (!in_array($this->_type, FileModel::$types)) {
            $this->_message = '上传类型不允许';
            return false;
        }

        $this->_uploadExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // 验证文件大小
        if ($this->filterBySize($fileSize)) {
            return false;
        }

        // 验证文件后缀
        if ($this->filterByExt($this->_uploadExt)) {
            return false;
        }
        // 检测是否可以秒传
        if ($fileHash) {
            if (FileModel::hashExists($fileHash)) {
                $result['hash'] = $fileHash;
                $result['url'] = FileModel::getFileUrl($fileHash);
                return $result;
            }
        }
        // 预创建文件
        if ($this->filterCreateFile()) {
            return false;
        }

        $result['uploadExt'] = $this->_uploadExt;
        $result['uploadBaseName'] = $this->_uploadBaseName;

        return $result;
    }

    /**
     * 分片上传文件
     * @param \Illuminate\Http\UploadedFile|array|null $file 上传的文件
     * @param null $index 当前分片
     * @param null $total 总分片数
     * @param null $baseName 上传文件临时名称
     * @param null $ext 上传文件扩展名
     * @param null $type 上传的类型(不传时必须使用setType)
     * @param null $subDir 上传的子文件夹(不传时可以使用setFileSubDir)
     * @return array|bool
     */
    public function saveChunk($file, $index, $total, $baseName, $ext, $type = null, $subDir = null)
    {
        $subDir === null or $this->_fileSubDir = $subDir;// 子目录名
        $type === null or $this->_type = $type;

        $this->_file = $file;
        $this->_chunkTotalCount = intval($total) > 0 ? intval($total) : 1;
        $this->_chunkIndex = intval($index) > 0 ? intval($index) : 1;
        $this->_uploadBaseName = $baseName;
        $this->_uploadExt = $ext;

        $this->_uploadHead = $this->getUploadHeadPath();
        $this->_uploadPartialFile = $this->getUploadPartialFilePath();
        $result = [
            'error' => 0,
            'hash' => '',
            'url' => '',
        ];

        if (!($this->_chunkTotalCount && $this->_chunkIndex && $this->_uploadExt && $this->_uploadBaseName && $this->_fileSubDir && $this->_type)) {
            $this->deleteTempFile();
            $this->_message = '缺少必要的文件块参数';
            return false;
        }

        if (!in_array($this->_type, FileModel::$types)) {
            $this->_message = '上传类型不允许';
            return false;
        }

        // 防止被人为跳过验证过程直接调用保存方法，从而上传恶意文件
        if (!is_file($this->disk()->path($this->_uploadPartialFile))) {
            $this->deleteTempFile();
            $this->_message = '非法操作';
            return false;
        }

        if ($this->_file->getError() > 0) {
            $this->deleteTempFile();
            $this->_message = $this->_file->getErrorMessage();
            return false;
        }

        if (!$this->_file->isValid()) {
            $this->deleteTempFile();
            $this->_message = '文件必须通过HTTP POST上传';
            return false;
        }
        // 头文件指针验证，防止断线造成的重复传输某个文件块
        try {
            if (intval($this->disk()->get($this->_uploadHead)) != intval($this->_chunkIndex) - 1) {
                return $result;
            }
        } catch (FileNotFoundException $e) {
            $this->deleteTempFile();
            $this->_message = '读取文件失败';
            return false;
        }

        // 写入数据到预创建的文件
        if ($this->writeFile()) {
            $this->deleteTempFile();
            return false;
        }
        // 判断文件传输完成
        if ($this->_chunkIndex === $this->_chunkTotalCount) {
            $this->disk()->delete($this->_uploadHead);

            if (!($fileHash = $this->renameTempFile())) {
                $this->_message = '重命名文件失败';
                $this->deleteTempFile();
                return false;
            }

            $result['hash'] = $fileHash;
            $result['url'] = FileModel::getFileUrl($fileHash);
        }

        return $result;
    }

    /**
     * 上传普通文件
     * @param \Illuminate\Http\UploadedFile|array|null $file
     * @param null $type
     * @param null $subDir
     * @return bool|string
     */
    public function upload($file, $type = null, $subDir = null)
    {
        $subDir === null or $this->_fileSubDir = $subDir;// 子目录名
        $type === null or $this->_type = $type;

        $this->_file = $file;

        if (!($this->_fileSubDir && $this->_type)) {
            $this->_message = '缺少必要的文件块参数';
            return false;
        }

        if (!in_array($this->_type, FileModel::$types)) {
            $this->_message = '上传类型不允许';
            return false;
        }

        if ($this->_file->getError() > 0) {
            $this->_message = $this->_file->getErrorMessage();
            return false;
        }

        if (!$this->_file->isValid()) {
            $this->_message = '文件必须通过HTTP POST上传';
            return false;
        }

        $this->_uploadExt = $this->_file->getClientOriginalExtension();
        $this->_origName = $this->_file->getClientOriginalName();

        // 验证文件大小
        if ($this->filterBySize($this->_file->getSize())) {
            return false;
        }

        // 验证文件后缀
        if ($this->filterByExt($this->_uploadExt)) {
            return false;
        }

        // 判断文件传输完成
        if (!($fileHash = $this->saveUploadFile())) {
            $this->_message = '上传文件失败';
            return false;
        }

        return $fileHash;
    }

    /**
     * 设置保存盘
     * @param string $disk
     * @return $this
     */
    public function setDisk($disk)
    {
        $this->_disk = $disk;
        return $this;
    }

    /**
     * 设置组
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->_type = $type;
        return $this;
    }

    /**
     * 设置子目录
     * @param string $fileSubDir
     * @return $this
     */
    public function setFileSubDir($fileSubDir)
    {
        $this->_fileSubDir = $fileSubDir;
        return $this;
    }

    /**
     * @param string $origName
     * @return $this
     */
    public function setOrigName($origName)
    {
        $this->_origName = $origName;
        return $this;
    }

    /**
     * 设置文件上传最大值
     * @param int $maxSize
     * @return $this
     */
    public function setMaxSize($maxSize)
    {
        $this->_maxSize = $maxSize;
        return $this;
    }

    /**
     * 设置运行上传的类型(多个以英文‘,’分隔)
     * @param string $extensions
     * @return $this
     */
    public function setExtensions($extensions)
    {
        $this->_extensions = $extensions;
        return $this;
    }

    /**
     * 返回错误信息
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * 获取文件盘
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    private function disk()
    {
        return Storage::disk($this->_disk);
    }

    /**
     * 删除临时文件
     */
    private function deleteTempFile()
    {
        $this->disk()->delete([
            $this->_uploadHead,
            $this->_uploadPartialFile
        ]);
    }

    /**
     * 判断是否超过上传大小限制
     * true 超过限制 false 允许上传
     * @param $fileSize
     * @return bool
     */
    private function filterBySize($fileSize)
    {
        // 如果_maxSize为false,读取配置
        if ($this->_maxSize === false) {
            $this->_maxSize = config('filesystems.uploader.' . $this->_type . '.size', 0);
        }

        $maxSize = $this->_maxSize * 1000 * 1000;
        // 文件大小过滤
        if ($fileSize > $maxSize && $maxSize != 0) {
            $this->_message = '文件大小超过限制';
            return true;
        }

        return false;
    }

    /**
     * 验证文件类型
     * true 不允许的类型 false 允许上传
     * @param $uploadExt
     * @return bool
     */
    private function filterByExt($uploadExt)
    {
        // 如果_extensions为false,读取配置
        if ($this->_extensions === false) {
            $this->_extensions = implode(',', config('filesystems.uploader.' . $this->_type . '.ext', []));
        }
        $extensions = $this->_extensions;
        // 文件类型过滤
        if (($extensions != '' && !in_array($uploadExt, explode(',', $extensions))) || in_array($uploadExt, static::getDangerousExtList())) {
            $this->_message = '文件类型不被支持';
            return true;
        }

        return false;
    }

    /**
     * get the extensions that may harm a server
     * @return array
     */
    private static function getDangerousExtList()
    {
        return ['php', 'part', 'html', 'shtml', 'htm', 'shtm', 'js', 'jsp', 'asp', 'java', 'py', 'sh', 'bat', 'exe', 'dll', 'cgi', 'htaccess', 'reg', 'aspx', 'vbs'];
    }

    /**
     * 验证创建文件
     * true 创建失败 false 创建成功
     * @return bool
     */
    private function filterCreateFile()
    {
        $this->_uploadBaseName = $this->generateTempFileName();
        $this->_uploadPartialFile = $this->getUploadPartialFilePath();
        $this->_uploadHead = $this->getUploadHeadPath();

        if (!($this->disk()->put($this->_uploadPartialFile, '') && $this->disk()->put($this->_uploadHead, 0))) {
            $this->_message = '创建文件失败';
            return true;
        }

        return false;
    }

    /**
     * 写入文件
     * true 写入失败 false 写入成功
     * @return bool
     */
    private function writeFile()
    {
        // 写入上传文件内容
        $fp = fopen($this->disk()->path($this->_uploadPartialFile), "ab");
        if ($fp === false) {
            $this->_message = '写文件失败';
            return true;
        }
        $handle = fopen($this->_file->getRealPath(), "rb");
        if ($handle === false) {
            $this->_message = '写文件失败';
            fclose($fp);
            return true;
        }
        if (fwrite($fp, fread($handle, filesize($this->_file->getRealPath()))) === false) {
            $this->_message = '写文件失败';
            fclose($handle);
            fclose($fp);
            return true;
        }
        fclose($handle);
        fclose($fp);

        // 写入头文件内容
        if (!$this->disk()->put($this->_uploadHead, $this->_chunkIndex)) {
            $this->_message = '写头文件失败';
            return true;
        }

        return false;
    }

    /**
     * 重命名临时文件
     * @return bool|string
     */
    private function renameTempFile()
    {
        $this->_saveHash = $this->generateSavedFileHash($this->disk()->path($this->_uploadPartialFile));
        $savedPath = $this->_type . DIRECTORY_SEPARATOR . $this->_fileSubDir . DIRECTORY_SEPARATOR . $this->_saveHash . '.' . $this->_uploadExt;

        if (!FileModel::hashExists($this->_saveHash)) {
            if (!$this->disk()->exists($savedPath) && !$this->disk()->move($this->_uploadPartialFile, $savedPath)) {
                return false;
            }
            if (!$this->saveFile($savedPath)) {
                return false;
            }
        }

        return $this->_saveHash;
    }

    /**
     * 保存上传文件
     * @return bool|string
     */
    private function saveUploadFile()
    {
        $this->_saveHash = $this->generateSavedFileHash($this->_file->getRealPath());
        $savedDir = $this->_type . DIRECTORY_SEPARATOR . $this->_fileSubDir;
        $savedName = $this->_saveHash . '.' . $this->_uploadExt;
        $savedPath = $savedDir . DIRECTORY_SEPARATOR . $savedName;

        if (!FileModel::hashExists($this->_saveHash)) {
            if (!$this->disk()->exists($savedPath) && !$this->disk()->putFileAs($savedDir, $this->_file, $savedName)) {
                return false;
            }
            if (!$this->saveFile($savedPath)) {
                return false;
            }
        }

        return $this->_saveHash;
    }

    /**
     * 获取上传文件的分片目录
     * @return string
     */
    private function getUploadPartialFilePath()
    {
        return $this->_type . DIRECTORY_SEPARATOR . $this->_fileSubDir . DIRECTORY_SEPARATOR . $this->_uploadBaseName . '.' . $this->_uploadExt . '.part';
    }

    /**
     * 获取计数头目录
     * @return string
     */
    private function getUploadHeadPath()
    {
        return $this->_type . DIRECTORY_SEPARATOR . $this->_headDir . DIRECTORY_SEPARATOR . $this->_uploadBaseName . '.head';
    }

    /**
     * 保存时生成文件的hash文件名
     * @param $filePath
     * @return string
     */
    private function generateSavedFileHash($filePath)
    {
        return md5_file($filePath);
    }

    /**
     * 生成临时文件名
     * @return string
     */
    private function generateTempFileName()
    {
        return time() . mt_rand(100, 999);
    }

    /**
     * 保存文件
     *
     * @param $path
     * @return mixed
     */
    private function saveFile($path)
    {
        $file = new File($this->disk()->path($path));

        // 获取文件的 Mime
        $mimeType = $file->getMimeType();

        // 获取文件大小
        $size = $file->getSize();

        // 文件无宽度属性。默认 0
        $width = 0;
        $height = 0;

        return FileModel::create([
            'type' => $this->_type,
            'disk' => $this->_disk,
            'path' => $path,
            'mime' => $mimeType,
            'hash' => $this->_saveHash,
            'title' => $this->_origName,
            'size' => $size,
            'width' => $width,
            'height' => $height,
        ]);
    }
}