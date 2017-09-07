<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/18
 * Time: 22:55
 */

//echo md5("wxw83773878");
//echo md5(md5("wxw83773878")."6690");
$redis = new Redis();
$redis->connect('127.0.0.1', 63790);
$ip = @$_SERVER["REMOTE_ADDR"];
$requestKey = "request_" . $ip;
if($redis->exists($requestKey)){
    $redis->incr($requestKey);
    if($redis->get($requestKey) > 25){
        $redis->zAdd('request_black_ip_list', $redis->get($requestKey), $ip);
    }
}else{
    $redis->set($requestKey, 1, 10);
}
$list = $redis->zRange('request_black_ip_list', 0, -1, true);
if(array_key_exists($ip, $list)){
    $redis->zDelete('request_black_ip_list', $ip);
    echo "file not found";
    exit;
}
echo $redis->get($requestKey);
exit;
crontab::returnFund();
class crontab{
    static function  returnFund(){
        //查看权限
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, "http://www.mmobar.co/index.php?s=Crontab/returnFund");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        print_r($output);
    }
}
?>
