# 常用php类及方法
###Captcha.php
验证码类，不需要fonts
$captcha->config(98, 40, 4, $name);//配置验证码长，宽，多个字，session名字
$captcha->create();//生成验证码

###Curl.php
简单curl的get，post方法

