<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'libraries/Base.php';

class Wechat extends Base
{
    private $appid;
    private $secret;

    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('Curl');
        $this->appid = $this->CI->config->item('appid', 'wechat');
        $this->secret = $this->CI->config->item('secret', 'wechat');
    }


    //获取用户有没有关注,及其用户信息
    public function getUserInfo($access_token, $openid)
    {
        if ($access_token && $openid) {
            $subscribe_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $access_token . "&openid=" . $openid;
            $get = $this->CI->curl->get($subscribe_url);
            if ($get[0] == 200) {
                return json_decode($get[1], TRUE);
            }
        }

        return false;
    }

    //get access_token ;access_token要建立缓存
    public function getAccessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->secret;
        $get = $this->CI->curl->get($url);
        return $get[0] == 200 ? json_decode($get[1], true) : false;
    }

    //跳转获取code及用户的openid,unionid
    public function getCode()
    {
        $scope = 'snsapi_base';
        $state = rand(1000, 9999);
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . urlencode($_SERVER['SCRIPT_URI']) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
        header("Location:" . $url) && exit();
    }

    //get openid;接受从getCode跳转过来的code,获取用户openid
    public function getOpenid($code)
    {
        if (!empty($code)) {
            $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->secret . '&code=' . $code . '&grant_type=authorization_code';
            $get = $this->CI->curl->get($get_token_url);
            if ($get[0] == 200) {
                return json_decode($get[1], TRUE);
            }
        }

        return false;
    }

}

