<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/8 10:10
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\File;
use App\Support\ChunkUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 公共类
 * Class CommonController
 * @package App\Http\Controllers\Admin
 */
class CommonController extends BaseController
{
    /**
     * 普通文件上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        if (Auth::guard('admin')->guest()) {
            /* 未登录页面跳转到登录页面 */
            return response()->json(['error' => '请先登录']);
        }

        $type = $request->input('type');
        $file = $request->file('file');

        $chunkUpload = new ChunkUpload();
        $fileHash = $chunkUpload->setType($type)
            ->upload($file);
        if ($fileHash === false) {
            return response()->json(['error' => $chunkUpload->getMessage()]);
        }
        $result = [
            'error' => 0,
            'hash' => $fileHash,
            'url' => File::getFileUrl($fileHash),
        ];

        return response()->json($result);
    }

    /**
     * 上传预处理
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function preProcess(Request $request)
    {
        if (Auth::guard('admin')->guest()) {
            /* 未登录页面跳转到登录页面 */
            return response()->json(['error' => '请先登录']);
        }

        $fileName = $request->input('file_name');
        $fileSize = $request->input('file_size');
        $fileHash = $request->input('file_hash');
        $type = $request->input('type');

        $chunkUpload = new ChunkUpload();
        $res = $chunkUpload->setType($type)
            ->preProcess($fileName, $fileSize, $fileHash);
        if ($res === false) {
            return response()->json(['error' => $chunkUpload->getMessage()]);
        }

        return response()->json($res);
    }

    /**
     * 分片上传图片
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveChunk(Request $request)
    {
        if (Auth::guard('admin')->guest()) {
            /* 未登录页面跳转到登录页面 */
            return response()->json(['error' => '请先登录']);
        }

        $fileName = $request->input('file_name');
        $subDir = $request->input('sub_dir');
        $uploadBasename = $request->input('upload_basename');
        $type = $request->input('type');
        $chunkIndex = $request->input('chunk_index');
        $chunkTotal = $request->input('chunk_total');
        $uploadExt = $request->input('upload_ext');
        $file = $request->file('file');

        $chunkUpload = new ChunkUpload();
        $res = $chunkUpload->setType($type)
            ->setFileSubDir($subDir)
            ->setOrigName($fileName)
            ->saveChunk($file, $chunkIndex, $chunkTotal, $uploadBasename, $uploadExt);
        if ($res === false) {
            return response()->json(['error' => $chunkUpload->getMessage()]);
        }

        return response()->json($res);
    }
}