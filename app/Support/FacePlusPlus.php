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


use App\Model\File;

/**
 * Face++人脸识别验证
 * Class Face
 * @package App\Support
 */
class FacePlusPlus
{
    /**
     * 消息
     * @var string
     */
    private $_message = '';

    /**
     * 返回结果(json)
     * @var string
     */
    private $_result = '';

    /**
     * API的API Key
     * @var string
     */
    private $_apiKey = '';

    /**
     * API的API Secret
     * @var string
     */
    private $_apiSecret = '';

    /**
     * 身份证识别
     */
    const FACE_ID_CARD_URL = 'https://api-cn.faceplusplus.com/cardpp/v1/ocridcard';

    /**
     * Face constructor.
     */
    public function __construct()
    {
        $this->_apiKey = config('site.face.key');

        $this->_apiSecret = config('site.face.key_secret');
    }

    /**
     * @param string $hash 文件表中的hash值
     * @return bool|array
     */
    public function verifyIdCard($hash)
    {
        if (!File::hasFile($hash)) {
            return false;
        }
        $image = File::getFilePathByHash($hash);
        if ($image === false) {
            return false;
        }
        $fp = fopen($image, 'rb');
        $content = fread($fp, filesize($image)); //二进制数据
        fclose($fp);

        $ch = curl_init();

        $url = self::FACE_ID_CARD_URL;
        $headers = array("cache-control: no-cache");
        $body = array(
            'image_base64' => base64_encode($content),
            'api_key' => "$this->_apiKey",
            'api_secret' => "$this->_apiSecret",
            'return_landmark' => "1",
            'return_attributes' => "gender,age,smiling,headpose,facequality,blur,eyestatus,emotion,ethnicity,beauty,mouthstatus,eyegaze,skinstatus"
        );

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        // Verification of the SSL cert
        if (true) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $hasError = false;
        if ($code === 0) {
            $err = curl_error($ch);
            $this->_message = $err;
            $hasError = true;
        }
        curl_close($ch);

        if ($hasError) {
            return false;
        }
        $this->_result = $response;

        $data = json_decode($response, true);
        if (empty($data) && !is_array($data)) {
            $this->_message = '返回格式错误';
            return false;
        }

        if (array_key_exists('error_message', $data)) {
            $this->_message = $data['error_message'];
            return false;
        }

        return array_key_exists('cards', $data) && is_array($data['cards']) ? $data['cards'] : [];
    }

    /**
     * 设置 API key
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;
        return $this;
    }

    /**
     * 设置API key secret
     * @param string $apiSecret
     * @return $this
     */
    public function setApiSecret($apiSecret)
    {
        $this->_apiSecret = $apiSecret;
        return $this;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * 获取返回结果
     * @return string
     */
    public function getResult()
    {
        return $this->_result;
    }
}