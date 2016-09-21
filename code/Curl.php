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
            http_build_query($data);
            $url = $url . '?';
            foreach ($data as $key => $val) {
                $url .= '&' . $key . '=' . $val;
            }
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
}

