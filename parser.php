<?php

$url = 'https://www.olx.ua/obyavlenie/elektropila-makita-uc4051a-IDtMiOG.html';

$cookie_path = $_SERVER['DOCUMENT_ROOT'].'/cookie.dat';

preg_match('|-ID(.*).html|', $url, $id);

$olx = curl_init($url);
curl_setopt($olx, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($olx, CURLOPT_RETURNTRANSFER, true);
curl_setopt($olx, CURLOPT_HEADER, 1);
curl_setopt($olx, CURLOPT_COOKIEFILE, $cookie_path);
curl_setopt($olx, CURLOPT_COOKIEJAR, $cookie_path);
$result = curl_exec($olx);
curl_close($olx);

preg_match("|phoneToken = '(.*)';|", $result, $token);

$olx_number = curl_init('https://www.olx.ua/ajax/misc/contact/phone/' . $id[1] . '/?pt=' . $token[1]);
    curl_setopt($olx_number, CURLOPT_HTTPHEADER, [
            'Host: www.olx.ua',
            'Accept: */*',
            'Accept-Language: uk,ru;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate, br',
            'Connection: keep-alive',
            'X-Requested-With: XMLHttpRequest'
        ]);
        curl_setopt($olx_number, CURLOPT_REFERER, $url);
        curl_setopt($olx_number, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($olx_number, CURLOPT_COOKIEFILE, $cookie_path);
        curl_setopt($olx_number, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($olx_number, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($olx_number);
        curl_close($olx_number);
        
        $json = json_decode($result);
        echo $json->value;
