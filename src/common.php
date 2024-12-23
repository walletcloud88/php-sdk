<?php
function getSignString($data){
    unset($data['sign']);
    ksort($data);
    reset($data);
    $pairs = array();
    foreach ($data as $k => $v) {
        if (is_array($v)) $v = self::arrayToString($v);
        $pairs[] = "$k=$v";
    }
    return implode('&', $pairs);
}

function arrayToString($data){
    $str = '';
    foreach ($data as $list) {
        if (is_array($list)) {
            $str .= self::arrayToString($list);
        } else {
            $str .= $list;
        }
    }
    return $str;
}

/**
 * 用自己私钥进行签名
 * @param array $data
 * @param string $private_key
 * @return string
 */
function encryption($data, $private_key){
    try {
        $signString = getSignString($data);
        $privKeyId = openssl_pkey_get_private($private_key);
        $signature = '';
        openssl_sign($signString, $signature, $privKeyId, OPENSSL_ALGO_MD5);
        openssl_free_key($privKeyId);
        return base64_encode($signature);
    }catch (\Exception $e){
        return false;
    }
}

/**
 * 使用对方的公钥验签，并且判断签名是否匹配
 * @param $data
 * @return bool
 */
function checkSignature($data, $platform_public_key){
    try {
        $sign = $data['sign'] ?? '';
        if (!$sign)
            return false;

        $toSign = getSignString($data);
        $publicKeyId = openssl_pkey_get_public($platform_public_key);
        $result = openssl_verify($toSign, base64_decode($sign), $publicKeyId, OPENSSL_ALGO_MD5);
        openssl_free_key($publicKeyId);
        return $result === 1 ? true : false;
    }catch (\Exception $e){
        return false;
    }
}

/**
 * URL请求
 * @param $url
 * @param array $data 参数
 * @param string $type 请求类型，POST、GET
 * @param array $header
 * @return false|array
 */
function curl($url, $data = [], $type = 'POST', $header = ["Content-Type:application/json;charset=utf-8"]){
    $type = strtoupper($type);
    $type = in_array($type, ['GET', 'POST']) ? $type : "GET";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //返回数据不直接输出
    curl_setopt($ch, CURLOPT_ENCODING, "gzip"); //指定gzip压缩

    if (!empty($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    //add ssl support
    if (substr($url, 0, 5) == 'https') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    }

    //add 302 support
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //curl_setopt($ch,CURLOPT_COOKIE,$cookie);

    //add type:get :post data support
    if ($type == 'POST') {
        //设置post方式提交
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    } else {
        if ($data) {
            $tmpData = [];
            foreach ($data as $key => $val) {
                $tmpData[] = $key . '=' . $val;
            }
            $url .= '?' . implode('&', $tmpData);
        }
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    // 执行 cURL 请求
    $response = curl_exec($ch);

    // 检查请求是否成功
    if (curl_errno($ch)) {
        throw new \Exception('cURL Error: ' . curl_error($ch));
    }

    // 关闭 cURL 会话
    curl_close($ch);
    return $response;
}
