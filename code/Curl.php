<?php

class Curl
{
    protected $ch;

    public function init($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 当设置为0时$ch没有返回值，直接输出请求的内容
        curl_setopt($ch, CURLOPT_HEADER, 0); //如果你想把一个头包含在输出中，设置这个选项为一个非零值
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); //设置3秒超时
        $this->ch = $ch;
    }
    
    public function get($url, $data = array())
    {
        if (!empty($data)) {
            $urlData = http_build_query($data);
            $sign = strpos($url, '?') === false ? '?' : '&';
            $url = $url . $sign . $urlData;
        }
        $this->init($url);
        $output = curl_exec($this->ch);
        $http_code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);//网站请求返回的状态码  如200
        return array($http_code, $output);
    }


    public function post($url, $data = array())
    {

        if (!empty($data)) {
            http_build_query($data);
        }
        $this->init($url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($this->ch);
        return $output;
    }
    
    public function __destruct()
    {
        curl_close($this->ch);
    }

    public static function request($url,$postData=array(),$header=array()){
        $options = array();
        $url = trim($url);
        $options[CURLOPT_URL] = $url;
        $options[CURLOPT_TIMEOUT] = 10;
        $options[CURLOPT_USERAGENT] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
        $options[CURLOPT_RETURNTRANSFER] = true;
       // $options[CURLOPT_PROXY] = '127.0.0.1:8888';
        foreach($header as $key=>$value){
            $options[$key] =$value;
        }
        if(!empty($postData) && is_array($postData)){
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = http_build_query($postData);
        }
        if(stripos($url,'https') === 0){
            $options[CURLOPT_SSL_VERIFYPEER] = false;
        }
        $ch = curl_init();
        curl_setopt_array($ch,$options);
        $rel = curl_exec($ch);
        if($rel == false){
            print_r(curl_getinfo($ch));
        }
        curl_close($ch);
        return $rel;
    }
}

