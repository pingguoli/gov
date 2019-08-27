<?php
/**
 * 常用函数
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/4 15:04
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

if (!function_exists('encryptStr')) {
    /**
     * 加密一个数据
     *
     * @param $inStr
     * @return null|string
     */
    function encryptStr($inStr)
    {
        if ($inStr === null || $inStr === '') {
            return null;
        }
        $key = config('site.encrypt.key');
        if (empty($key)) {
            $key = 'base64:TBeo8Pf2JbVX3fUYbMTYYxPhZ1xZ4j9nWKNQdEbUVH0=';
        }
        $iv = config('site.encrypt.iv');
        if (empty($iv)) {
            $iv = 'base64:FxQsVOSQmCEAzUCX87efoA==';
        }
        try {
            $encrypt = new \App\Support\Encrypter($key);
            $encrypt->setIv($iv);
            return $encrypt->encrypt($inStr);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('decryptStr')) {
    /**
     * 解密一个数据
     *
     * @param $inStr
     * @return null|string
     */
    function decryptStr($inStr)
    {
        if ($inStr === null || $inStr === '') {
            return null;
        }

        $key = config('site.encrypt.key');
        if (empty($key)) {
            $key = 'base64:TBeo8Pf2JbVX3fUYbMTYYxPhZ1xZ4j9nWKNQdEbUVH0=';
        }
        $iv = config('site.encrypt.iv');
        if (empty($iv)) {
            $iv = 'base64:FxQsVOSQmCEAzUCX87efoA==';
        }
        try {
            $encrypt = new \App\Support\Encrypter($key);
            $encrypt->setIv($iv);
            return $encrypt->decrypt($inStr);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('encryptTempStr')) {
    /**
     * 加密一个临时数据
     *
     * @param $inStr
     * @return null|string
     */
    function encryptTempStr($inStr)
    {
        if ($inStr === null || $inStr === '') {
            return null;
        }
        $key = config('site.encrypt.key');
        if (empty($key)) {
            $key = 'base64:TBeo8Pf2JbVX3fUYbMTYYxPhZ1xZ4j9nWKNQdEbUVH0=';
        }
        try {
            $encrypt = new \App\Support\Encrypter($key);
            return $encrypt->encrypt($inStr);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('decryptTempStr')) {
    /**
     * 解密一个临时数据
     *
     * @param $inStr
     * @return null|string
     */
    function decryptTempStr($inStr)
    {
        if ($inStr === null || $inStr === '') {
            return null;
        }

        $key = config('site.encrypt.key');
        if (empty($key)) {
            $key = 'base64:TBeo8Pf2JbVX3fUYbMTYYxPhZ1xZ4j9nWKNQdEbUVH0=';
        }
        try {
            $encrypt = new \App\Support\Encrypter($key);
            return $encrypt->decrypt($inStr);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('isMobile')) {

    /**
     * 判断是否是移动端访问
     * @return bool
     */
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;// 找不到为false,否则为true
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientKeywords = array(
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientKeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('byteToSize')) {

    /**
     * 文件大小转换
     * @param $byte
     * @return string
     */
    function byteToSize($byte)
    {
        if ($byte > pow(2, 40)) {
            $size = round($byte / pow(2, 40), 2) . ' TB';
        } elseif ($byte > pow(2, 30)) {
            $size = round($byte / pow(2, 30), 2) . ' GB';
        } elseif ($byte > pow(2, 20)) {
            $size = round($byte / pow(2, 20), 2) . ' MB';
        } elseif ($byte > pow(2, 10)) {
            $size = round($byte / pow(2, 10), 2) . ' KB';
        } else {
            $size = round($byte, 2) . ' B';
        }

        return $size;
    }
}

if (!function_exists("backendView")) {

    /**
     * 后台view加载函数
     *
     * @param null $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function backendView($view = null, $data = [], $mergeData = [])
    {
        $view = 'backend::' . $view;
        return view($view, $data, $mergeData);
    }
}

if (!function_exists("frontendView")) {
    /**
     * 前台view加载函数
     *
     * @param null $view
     * @param array $data
     * @param array $mergeData
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function frontendView($view = null, $data = [], $mergeData = [])
    {
        $view = 'frontend::' . $view;

        return view($view, $data, $mergeData);
    }
}

if (!function_exists('geneSmsCode')) {

    /**
     * 统一生成短信验证码
     *
     * @param int $length
     * @return string
     */
    function geneSmsCode($length = 6)
    {
        $length = is_numeric($length) && intval($length) > 0 ? intval($length) : 6;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= rand(0, 9);
        }

        return $code;
    }
}