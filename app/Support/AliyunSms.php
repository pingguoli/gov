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

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Log;

/**
 * 阿里云发送短信验证码
 * Class AliyunSms
 * @package App\Support
 */
class AliyunSms
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
     * @param $phone
     * @param $code
     * @return bool
     */
    public function send($phone, $code)
    {
        $accessKeyId = config('site.aliyun.sms.key');
        $accessSecret = config('site.aliyun.sms.key_secret');
        $signName = config('site.aliyun.sms.sign_name');
        $templateCode = config('site.aliyun.sms.template_code');
        $templateParam = json_encode(['code' => $code], JSON_UNESCAPED_UNICODE);
        AlibabaCloud::accessKeyClient($accessKeyId, $accessSecret)
            ->regionId('cn-hangzhou')// replace regionId as you need
            ->asGlobalClient();

        try {
            $result = AlibabaCloud::rpcRequest()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'PhoneNumbers' => $phone,
                        'SignName' => $signName,
                        'TemplateCode' => $templateCode,
                        'TemplateParam' => $templateParam
                    ],
                ])
                ->request();

            $this->_result = $result->toJson();
            $this->_message = $result->Message;

            if ($result->Code == 'OK') {
                return true;
            }

            Log::warning('Aliyun Sms Code: ' . $this->_message);
            Log::warning('Aliyun Sms Code: ' . $this->_result);
        } catch (ClientException $e) {
            Log::warning('Aliyun Sms Code: ' . $e->getErrorMessage());
        } catch (ServerException $e) {
            Log::warning('Aliyun Sms Code: ' . $e->getErrorMessage());
        }

        return false;
    }

    /**
     * 获取信息
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * 获取结果
     * @return string
     */
    public function getResult()
    {
        return $this->_result;
    }
}