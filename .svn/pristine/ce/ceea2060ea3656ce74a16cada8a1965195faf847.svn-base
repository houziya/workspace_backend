<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);

//网站根目录
$PHP_FILE = rtrim($_SERVER['SCRIPT_NAME'],'/');
$ff = explode("/", $PHP_FILE);
if(strstr($ff[1],".php")){
    $filename = "/Public/Uploads/";
}else{
    $filename = "/".$ff[1]."/Public/Uploads/";;
}

/* 上传图片配置项 */
$CONFIG['imagePathFormat'] = $filename."image/{yyyy}{mm}{dd}/{time}{rand:6}";
$CONFIG['imageMaxSize'] = 2048000; /* 上传大小限制，单位B */
/* 涂鸦图片上传配置项 */
$CONFIG['scrawlPathFormat'] = $filename."image/{yyyy}{mm}{dd}/{time}{rand:6}";
/* 截图工具上传 */
$CONFIG['snapscreenPathFormat'] = $filename."image/{yyyy}{mm}{dd}/{time}{rand:6}";
/* 抓取远程图片配置 */
$CONFIG['catcherPathFormat'] = $filename."image/{yyyy}{mm}{dd}/{time}{rand:6}";
/* 上传视频配置 */
$CONFIG['videoPathFormat'] = $filename."video/{yyyy}{mm}{dd}/{time}{rand:6}";
$CONFIG['videoMaxSize'] = 102400000;/* 上传大小限制，单位B，默认100MB */
/* 上传文件配置 */
$CONFIG['filePathFormat'] = $filename."file/{yyyy}{mm}{dd}/{time}{rand:6}";
$CONFIG['fileMaxSize'] = 51200000;/* 上传大小限制，单位B，默认50MB */
/* 列出指定目录下的图片 */
$CONFIG['imageManagerListPath'] = $filename."image/";
/* 列出指定目录下的文件 */
$CONFIG['fileManagerListPath'] = $filename."file/";


$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    echo $result;
}