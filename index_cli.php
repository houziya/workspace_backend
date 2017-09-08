<?php
define('THINK_PATH', 'ThinkPHP/');
if(strstr(dirname(__FILE__),"\\"))
	define('_ABS_ROOT_',str_replace("\\","/",dirname(__FILE__))."/");
else
	define('_ABS_ROOT_',dirname(__FILE__)."/");
define('_ABS_APP_ROOT_',_ABS_ROOT_.'Zyrj/');
define('APP_NAME', './Zyrj');
//define('APP_PATH', './Zyrj/');
define('APP_PATH',dirname(__FILE__).'/Zyrj/');
define('APP_DEBUG', true);
define('MODE_NAME', 'cli');


$depr = '/';
$path   = isset($_SERVER['argv'][1])?$_SERVER['argv'][1]:'';
$params = [];
if(!empty($path)) {
    $params = explode($depr,trim($path,$depr));
}
!empty($params)?$_GET['g']=array_shift($params):"";

!empty($params)?$_GET['m']=array_shift($params):"";

!empty($params)?$_GET['a']=array_shift($params):"";

if(count($params)>1) {
    // 解析剩余参数 并采用GET方式获取
    echo 2222;
    preg_replace('@(\w+),([^,\/]+)@e', '$_GET[\'\\1\']="\\2";', implode(',',$params));
}
print_r($_REQUEST);
require(THINK_PATH."./ThinkPHP.php");

?>