# 常用php类及方法
### autoload.php
```
//psr-4语法自动加载,了解即可
//推荐使用composer
```
### Captcha.php
```
//验证码类，不需要fonts
$captcha->config(98, 40, 4, $name);//配置验证码长，宽，多个字，session名字
$captcha->create();//生成验证码
```
### Curl.php
```
//简单curl的get，post方法
```
### registry.php
```
//单例注册模式代码，使用时候将类注入，保证这个类在流程中只被实例化一次
```

### runtime.php
```
//看代码运行的时间
```
### wechat.php
```
//微信access_token辅助类
```
### xml_utils.php
```
//xml与数组转换
```

### zip.php
```
//php解密zip压缩包
```
