<?php
         // +----------------------------------------------------------------------
         // | ThinkPHP
         // +----------------------------------------------------------------------
         // | Copyright (c) 2007 http://thinkphp.cn All rights reserved.
         // +----------------------------------------------------------------------
         // | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
         // +----------------------------------------------------------------------
         // | Author: liu21st <liu21st@gmail.com>
         // +----------------------------------------------------------------------

         /* --------------------公共函数----------------------*/
class XSTRMEMORY
{
   public static $xstrmem = NULL;
}
function xstr($strKey='')
{
   if(XSTRMEMORY::$xstrmem === NULL)
   {
      $fileName = C('LANGUAGE_FILE_NAME').'.php';
      $allPath = _ABS_APP_ROOT_.'Lang/'.$fileName;
      if(is_file($allPath))
      {
         $fileContent = require_once($allPath);
         if(is_array($fileContent))
            XSTRMEMORY::$xstrmem = $fileContent;
         unset($fileContent);
      }
      if(XSTRMEMORY::$xstrmem === NULL)
         XSTRMEMORY::$xstrmem = false;
   }
   $rtnStr = NULL;
   if(is_array(XSTRMEMORY::$xstrmem))
   {
      if(array_key_exists($strKey,XSTRMEMORY::$xstrmem))
         $rtnStr = XSTRMEMORY::$xstrmem[$strKey];
   }
   return $rtnStr;
}
         //通过玩家AutoId找到玩家编号user_id
function user_id($id){
   $rs = M ('fck') -> where('id ='.$id) -> field('user_id') -> find();
   return $rs['user_id'];
}

function typename($id){
            // $fee_rs=M('fee')->field()->find();
   $bank=array("银行支付","支付宝支付","微信支付","财富通");
   $id=explode(",", $id);
   $str=" ";
   foreach ($id as $key => $value) {
      $str.=$bank[$value].",";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $newstr;
}

function cp_name($cid){
   $rs = M ('cptype') -> where('id ='.$cid) -> field('tpname') -> find();
   if($rs){
      return $rs['tpname'];
   }else{
      return "无";
   }
}

function mysubstr($string, $sublen, $start = 0, $code = 'UTF-8'){
            //字符串截取函数 默认UTF-8
   if($code == 'UTF-8'){
      $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
      preg_match_all($pa, $string, $t_string);

      if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
      return join('', array_slice($t_string[0], $start, $sublen));
   }else{
      $start = $start*2;
      $sublen = $sublen*2;
      $strlen = strlen($string);
      $tmpstr = '';

      for($i=0; $i< $strlen; $i++)
      {
         if($i>=$start && $i< ($start+$sublen))
         {
            if(ord(substr($string, $i, 1))>129)
            {
               $tmpstr.= substr($string, $i, 2);
            }
            else
            {
               $tmpstr.= substr($string, $i, 1);
            }
         }
         if(ord(substr($string, $i, 1))>129) $i++;
      }
      if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
      return $tmpstr;
   }
}

         //如果user_id等于800000就返回公司
function conname($n){
   $rs = M ('fck') -> where('id =1') -> field('user_id') -> find();
   if($n == $rs['user_id']){
      return '公司';
   }else{
      return $n;
   }
}

         //如果user_id等于800000就返回公司
function nickname($id){
   $rs = M ('fck') -> where('id ='.$id) -> field('nickname') -> find();
   return $rs['nickname'];
}

function pwdHash($password, $type = 'md5') {
   return hash ( $type, $password );
}
         //对密码进行加密
function pwdHash_pass($password, $type = 'md5') {
   return hash ( $type, $password );
}

function noHTML($content){
   $content = strip_tags($content);
   $content = preg_replace("/<a[^>]*>/i",'', $content);
   $content = preg_replace("/<\/a>/i", '', $content);
   $content = preg_replace("/<div[^>]*>/i",'', $content);
   $content = preg_replace("/<\/div>/i",'', $content);
   $content = preg_replace("/<font[^>]*>/i",'', $content);
   $content = preg_replace("/<\/font>/i",'', $content);
   $content = preg_replace("/<p[^>]*>/i",'', $content);
   $content = preg_replace("/<\/p>/i",'', $content);
   $content = preg_replace("/<span[^>]*>/i",'', $content);
   $content = preg_replace("/<\/span>/i",'', $content);
   $content = preg_replace("/<\?xml[^>]*>/i",'', $content);
   $content = preg_replace("/<\/\?xml>/i",'', $content);
   $content = preg_replace("/<o:p[^>]*>/i",'', $content);
   $content = preg_replace("/<\/o:p>/i",'', $content);
   $content = preg_replace("/<u[^>]*>/i",'', $content);
   $content = preg_replace("/<\/u>/i",'', $content);
   $content = preg_replace("/<b[^>]*>/i",'', $content);
   $content = preg_replace("/<\/b>/i",'', $content);
   $content = preg_replace("/<meta[^>]*>/i",'', $content);
   $content = preg_replace("/<\/meta>/i",'', $content);
   $content = preg_replace("/<!--[^>]*-->/i",'', $content);
   $content = preg_replace("/<p[^>]*-->/i",'', $content);
   $content = preg_replace("/style=.+?['|\"]/i",'',$content);
   $content = preg_replace("/class=.+?['|\"]/i",'',$content);
   $content = preg_replace("/id=.+?['|\"]/i",'',$content);
   $content = preg_replace("/lang=.+?['|\"]/i",'',$content);
   $content = preg_replace("/width=.+?['|\"]/i",'',$content);
   $content = preg_replace("/height=.+?['|\"]/i",'',$content);
   $content = preg_replace("/border=.+?['|\"]/i",'',$content);
   $content = preg_replace("/face=.+?['|\"]/i",'',$content);
   $content = preg_replace("/face=.+?['|\"]/",'',$content);
   $content = preg_replace("/face=.+?['|\"]/",'',$content);
   $content = str_replace( " ","",$content);
   $content = str_replace( "&nbsp;","",$content);
   return $content;
}

/**
 * 查询信誉
 **/
function cx_usrate($myid){
   $fck = M ('fck');
   $mrs = $fck->where('id='.$myid)->field('id,seller_rate')->find();
   $mrate = (int)$mrs['seller_rate'];
   $s_img = "";
   if($mrate>0){
      for($i=1;$i<=$mrate;$i++){
         $s_img .='<img src="__PUBLIC__/Images/star.gif" />';
      }
   }
   unset($fck,$mrs);
   return $s_img;
}

/**
 * 给出兑换货币
 * **/
function cx_cname($brmb){
   $fee = M ('fee');
   $fee_rs = $fee->field('str10,str11')->find();
   $prii = $fee_rs['str11'];
   $ormb = $brmb*$prii;
   $ormb = number_format($ormb,2);
   $out_r = "￥".$ormb;
   unset($fee,$fee_rs);
   return $out_r;
}

function bank_name($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('bank_province,bank_city,bank_name')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['bank_province']}{$value['bank_city']}{$value['bank_name']}<br/>";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function bank_user($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('user_name')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['user_name']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function bank_number($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('bank_card')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['bank_card']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function tel($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('user_tel')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['user_tel']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function tel1($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('user_tel')->select();

   foreach ($rs as $key => $value) {
      $str=$str." (".($key+1).") {$value['user_tel']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function qq($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('qq')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['qq']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function chat($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('chat')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['chat']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function zhifuPay($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('zhifuPay')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['zhifuPay']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function weixinWalet($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('weixinWalet')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['weixinWalet']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function caifuPay($id){
   $str="";
   $fck = M ('fck');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$fck->where($where)->field('caifuPay')->select();

   foreach ($rs as $key => $value) {
      $str=$str."{$value['caifuPay']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function t_money($id=""){
   $str="";
   $cash = M ('cash');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$cash->where($where)->field('money')->select();
   foreach ($rs as $key => $value) {
      $str=$str."{$value['money']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function is_done($id=""){
   $str="";
   $cash = M ('cash');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$cash->where($where)->field('is_done')->select();
   foreach ($rs as $key => $value) {
      $str=$str."{$value['is_done']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function viewImg($id=""){
   $str="";
   $cash = M ('cash');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$cash->where($where)->field('img')->select();
   foreach ($rs as $key => $value) {
      $str=$str."{$value['img']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function viewImg2($id=""){
   $str="";
   $cash = M ('cash');
   $uid=explode(",", $id);

   $where['id']=array('in',$uid);
   $rs=$cash->where($where)->field('ts_img')->select();
   foreach ($rs as $key => $value) {
      $str=$str."{$value['ts_img']}";
   }
   $newstr = substr($str,0,strlen($str)-1); 
   return $str;
}

function key_num($key){
   $temp_num = 10000;
   $new_num = $key + $temp_num+1;
   $real_num = substr($new_num,1,4); //即截取掉最前面的“1”
   return $real_num;
}
function re_id($id){
   $fck=M('fck');
   $fck_rs=$fck->where("id=".$id)->field('re_id')->find();
   return $fck_rs['re_id'];
}

function shop_id($id){
   $fck=M('fck');
   $fck_rs=$fck->where("id=".$id)->field('shop_id')->find();
   return $fck_rs['shop_id'];
}
function I($name,$default='',$filter=null,$datas=null) {
   static $_PUT	=	null;
   if(strpos($name,'/')){ // 指定修饰符
      list($name,$type) 	=	explode('/',$name,2);
   }elseif(C('VAR_AUTO_STRING')){ // 默认强制转换为字符串
      $type   =   's';
   }
   if(strpos($name,'.')) { // 指定参数来源
      list($method,$name) =   explode('.',$name,2);
   }else{ // 默认为自动判断
      $method =   'param';
   }
   switch(strtolower($method)) {
   case 'get'     :   
      $input =& $_GET;
      break;
   case 'post'    :   
      $input =& $_POST;
      break;
   case 'put'     :   
      if(is_null($_PUT)){
         parse_str(file_get_contents('php://input'), $_PUT);
      }
      $input 	=	$_PUT;        
      break;
   case 'param'   :
      switch($_SERVER['REQUEST_METHOD']) {
      case 'POST':
         $input  =  $_POST;
         break;
      case 'PUT':
         if(is_null($_PUT)){
            parse_str(file_get_contents('php://input'), $_PUT);
         }
         $input 	=	$_PUT;
         break;
      default:
         $input  =  $_GET;
      }
      break;
      case 'path'    :   
         $input  =   array();
         if(!empty($_SERVER['PATH_INFO'])){
            $depr   =   C('URL_PATHINFO_DEPR');
            $input  =   explode($depr,trim($_SERVER['PATH_INFO'],$depr));            
         }
         break;
      case 'request' :   
         $input =& $_REQUEST;   
         break;
      case 'session' :   
         $input =& $_SESSION;   
         break;
      case 'cookie'  :   
         $input =& $_COOKIE;    
         break;
      case 'server'  :   
         $input =& $_SERVER;    
         break;
      case 'globals' :   
         $input =& $GLOBALS;    
         break;
      case 'data'    :   
         $input =& $datas;      
         break;
      default:
         return null;
   }
   if(''==$name) { // 获取全部变量
      $data       =   $input;
      $filters    =   isset($filter)?$filter:C('DEFAULT_FILTER');
      if($filters) {
         if(is_string($filters)){
            $filters    =   explode(',',$filters);
         }
         foreach($filters as $filter){
            $data   =   array_map_recursive($filter,$data); // 参数过滤
         }
      }
   }elseif(isset($input[$name])) { // 取值操作
      $data       =   $input[$name];
      $filters    =   isset($filter)?$filter:C('DEFAULT_FILTER');
      if($filters) {
         if(is_string($filters)){
            if(0 === strpos($filters,'/')){
               if(1 !== preg_match($filters,(string)$data)){
                           // 支持正则验证
                  return   isset($default) ? $default : null;
               }
            }else{
               $filters    =   explode(',',$filters);                    
            }
         }elseif(is_int($filters)){
            $filters    =   array($filters);
         }

         if(is_array($filters)){
            foreach($filters as $filter){
               if(function_exists($filter)) {
                  $data   =   is_array($data) ? array_map_recursive($filter,$data) : $filter($data); // 参数过滤
               }else{
                  $data   =   filter_var($data,is_int($filter) ? $filter : filter_id($filter));
                  if(false === $data) {
                     return   isset($default) ? $default : null;
                  }
               }
            }
         }
      }
      if(!empty($type)){
         switch(strtolower($type)){
         case 'a':	// 数组
            $data 	=	(array)$data;
            break;
         case 'd':	// 数字
            $data 	=	(int)$data;
            break;
         case 'f':	// 浮点
            $data 	=	(float)$data;
            break;
         case 'b':	// 布尔
            $data 	=	(boolean)$data;
            break;
         case 's':   // 字符串
         default:
            $data   =   (string)$data;
         }
      }
   }else{ // 变量默认值
      $data       =    isset($default)?$default:null;
   }
   is_array($data) && array_walk_recursive($data,'think_filter');
   return $data;
}
         //在线交易订单支付处理函数
         //函数功能：根据支付接口传回的数据判断该订单是否已经支付成功；
         //返回值：如果订单已经成功支付，返回true，否则返回false；
function checkorderstatus($ordid){
   $Ord=M('Orderlist');
   $ordstatus=$Ord->where('ordid='.$ordid)->getField('ordstatus');
   if($ordstatus==1){
      return true;
   }else{
      return false;    
   }
}
         //更新订单状态，写入订单支付后返回的数据
function orderhandle($parameter){
   $ordid=$parameter['out_trade_no'];
   $data['payment_trade_no']      =$parameter['trade_no'];
   $data['payment_trade_status']  =$parameter['trade_status'];
   $data['payment_notify_id']     =$parameter['notify_id'];
   $data['payment_notify_time']   =$parameter['notify_time'];
   $data['payment_buyer_email']   =$parameter['buyer_email'];
   $data['ordstatus']             =1;
   $Ord=M('Orderlist');
   $map['id']=$ordid;
   $map['ordstatus']=0;
   if($Ord->where($map)->save($data)){
      $res=M('orderlist')->where('id='.$ordid)->field('userid,money,num')->find();
               //生成门票
      createActiveCode($res['userid'],$res['num']);
      return true;
   }
} 


function createActiveCode($userid,$num)
{
   $userUUID = $userid;
   $user = M('Fck')->field('user_id')->where(array('id'=>$userUUID))->find();
   $Num=$num;
   for ($i=0; $i < $Num; $i++) { 
      $card=M('card');
      $data = array();
      $data['bid'] = 0;
      $data['buser_id'] = $user['user_id'];
      $data['use_time'] = 0;
      $data['c_type'] = 0;
      $data['is_use'] = 0;
      $card->execute('LOCK TABLE __TABLE__ WRITE');
      $data['card_no'] =buildActiveCode();
      $data['c_time'] = time();
      $card->add($data);
      $card->execute('UNLOCK TABLES');
   }
   return true;
}
function buildActiveCode()
{
   $baseChar = '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
   $bit = 8;
   $tStr = '';
   do
   {
      $tStr = '';
      for($i=0;$i<$bit;$i++)
      {
         $rnd = rand(0,strlen($baseChar)-1);
         $tStr .= $baseChar[$rnd];
      }
    }while(M('Card')->field('id')->where(array('card_no'=>$tStr))->find());
  return $tStr;
}
function getRandChar($length=6){
   $str = null;
            //$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
   $strPol = "0123456789";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
      $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }
   return $str;
}
function get_real_ip(){
   $unknown = 'unknown';
   if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown) ) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
   } elseif ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown) ) {
      $ip = $_SERVER['REMOTE_ADDR'];
}
   if (false !== strpos($ip, ','))
      $ip = reset(explode(',', $ip));
   return $ip;

}

?>
