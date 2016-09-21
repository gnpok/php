<?php

//ini_set('error_reporting',E_ALL ^ E_NOTICE);//显示所有除了notice类型的错误信息
ini_set('error_reporting',E_ALL);//显示所有错误信息
ini_set('display_errors',off);//禁止将错误信息输出到输出端
ini_set('log_errors',On);//开启错误日志记录
ini_set('error_log','C:/cxyblog');//定义错误日志存储位置

//两句比较常用的排除错误信息的PHP语句：
@ini_set('memory_limit','500M');//设置程序可占用最大内存为500MB
@ini_set('max_execution_time','180');//设置允许程序最长的执行时间为180秒
