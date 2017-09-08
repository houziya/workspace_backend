<?php
if(class_exists('MySQL')) {
    $redis = new Redis();
    $redis->connect(C("REDIS_HOST"), 63790);
    $ip = $_SERVER["REMOTE_ADDR"];
    $requestKey = "request_" . $ip;
    if ($redis->exists($requestKey)) {
        $redis->incr($requestKey);
        if ($redis->get($requestKey) > 150) {
            $redis->zAdd('request_black_ip_list', $redis->get($requestKey), $ip);
        }
    } else {
        $redis->set($requestKey, 1, 10);
    }
    $list = $redis->zRange('request_black_ip_list', 0, -1, true);
    if (array_key_exists($ip, $list)) {
        echo "file not found";
        exit;
    }
}
define('THINK_PATH', 'ThinkPHP/');
if(strstr(dirname(__FILE__),"\\"))
	define('_ABS_ROOT_',str_replace("\\","/",dirname(__FILE__))."/");
else
	define('_ABS_ROOT_',dirname(__FILE__)."/");
define('_ABS_APP_ROOT_',_ABS_ROOT_.'Zyrj/');
define('APP_NAME', './Zyrj');
define('APP_PATH', './Zyrj/');
define('APP_DEBUG', false);

require_once __DIR__ . '/autoload.php';
require(THINK_PATH."./ThinkPHP.php");

?>
