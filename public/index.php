<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
//服务器端解决跨域
//所有的域名都可以访问，*可以变成www
header("Access-Control-Allow-Origin:*");
//请求方式只有put...
header("Access-Control-Allow-Methods:PUT,POST,GET,DELETE,OPTIONS");
//头信息：允许带的信息
header("Access-Control-Allow-Headers:Origin,X-Requested-With,Authorization,Content-Type,RetryAfter,retry-after,Accept,token");
//嗅探
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){
    exit();
}
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../hotel-thinkphp/start.php';
