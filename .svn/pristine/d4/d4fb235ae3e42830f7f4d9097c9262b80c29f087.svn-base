<?php
class PayAction extends CommonAction{
   function _initialize() {
      parent::_initialize();
      $this->_inject_check(0);//调用过滤函数
      $this->_Config_name();
      header("Content-Type:text/html; charset=utf-8");
   }
   public function test(){
     // $id=$_GET('id');
      //echo $id;
    //  var_dump(VENDOR_PATH);
      var_dump($_SESSION);
    //  createActiveCode(1,10);
   }
   /**
    * 支付请求发送
    **/
   public function doalipay(){
               //生成订单
      $data['userid']= $_SESSION[C('USER_AUTH_KEY')];
      $data['num']=I('num',1);
      $price=C('CARD_PRICE');
      $data['money']=$price*$data['num'];
      $order_id=M('orderlist')->add($data);
      $alipay_config=C('alipay_config');  
      //var_dump($alipay_config);
     // $alipay_config['partner']=$alipay_config['partner'];
     // $alipay_config['key']=$alipay_config['key'];

               /**************************请求参数**************************/
      $payment_type = "1"; //支付类型 //必填，不能修改
      $domain= 'http://'.$_SERVER['SERVER_NAME'];
      $notify_url =$domain.C('alipay.notify_url'); //服务器异步通知页面路径
      $return_url =$domain.C('alipay.return_url'); //页面跳转同步通知页面路径
      $seller_email = C('alipay.seller_email');//卖家支付宝帐户必填
               //     $out_trade_no = $_POST['trade_no'];//商户订单号 通过支付页面的表单进行传递，注意要唯一！
               //   $subject = $_POST['subject'];  //订单名称 //必填 通过支付页面的表单进行传递
      $total_fee = $data['money'];   //付款金额  //必填 通过支付页面的表单进行传递
               //  $body = $_POST['ordbody'];  //订单描述 通过支付页面的表单进行传递
               //  $show_url = $_POST['ordshow_url'];  //商品展示地址 通过支付页面的表单进行传递
      $anti_phishing_key = "";//防钓鱼时间戳 //若要使用请调用类文件submit中的query_timestamp函数
      $exter_invoke_ip = get_client_ip(); //客户端的IP地址 
               /************************************************************/

               //构造要请求的参数数组，无需改动
      $parameter = array(
         "service" => "create_direct_pay_by_user",
         "partner" => trim($alipay_config['partner']),
         "payment_type"    =>$payment_type,
         "notify_url"    => $notify_url,
         "return_url"    => $return_url,
         "seller_email"    => $seller_email,
         "out_trade_no"    =>$order_id,
         "subject"    => '用户充值',
         "total_fee"    => $total_fee,
         "anti_phishing_key"    => $anti_phishing_key,
         "exter_invoke_ip"    => $exter_invoke_ip,
         "_input_charset"    => trim(strtolower($alipay_config['input_charset'])),
         "service"       => "create_direct_pay_by_user",
         "payment_type"      => "1"
      );
      //var_dump($parameter);die();
       Vendor('Alipay.Corefunction');
       Vendor('Alipay.Md5function');
       Vendor('Alipay.AlipaySubmit');
      $alipaySubmit = new AlipaySubmit($alipay_config);
      $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
      echo $html_text;
   }
       /*
        页面跳转处理方法；
        这里其实就是将return_url.php这个文件中的代码复制过来，进行处理； 
        */
   function returnurl(){
               //头部的处理跟上面两个方法一样，这里不罗嗦了！
       Vendor('Alipay.Corefunction');
       Vendor('Alipay.Md5function');
       Vendor('Alipay.AlipayNotify');
      $alipay_config=C('alipay_config');
       //var_dump($alipay_config);
      // die();
      $alipayNotify = new AlipayNotify($alipay_config);//计算得出通知验证结果
      $verify_result = $alipayNotify->verifyReturn();
      if($verify_result) {
                  //验证成功
                  //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
         $out_trade_no   = $_GET['out_trade_no'];      //商户订单号
         $trade_no       = $_GET['trade_no'];          //支付宝交易号
         $trade_status   = $_GET['trade_status'];      //交易状态
         $total_fee      = $_GET['total_fee'];         //交易金额
         $notify_id      = $_GET['notify_id'];         //通知校验ID。
         $notify_time    = $_GET['notify_time'];       //通知的发送时间。
         $buyer_email    = $_GET['buyer_email'];       //买家支付宝帐号；

         $parameter = array(
            "out_trade_no"     => $out_trade_no,      //商户订单编号；
            "trade_no"     => $trade_no,          //支付宝交易号；
            "total_fee"      => $total_fee,         //交易金额；
            "trade_status"     => $trade_status,      //交易状态
            "notify_id"      => $notify_id,         //通知校验ID。
            "notify_time"    => $notify_time,       //通知的发送时间。
            "buyer_email"    => $buyer_email,       //买家支付宝帐号
         );

         if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
            if(!checkorderstatus($out_trade_no)){
               orderhandle($parameter);  //进行订单处理，并传送从支付宝返回的参数；
            }
                     //$this->redirect(C('alipay.successpage'));//跳转到配置项中配置的支付成功页面；

                     //$this->success('支付成功',U('Home/Member/index'));
      //      redirect('/Home/Member/index', 0, '');
           header('location:'.U('/Change/FrontCode'));
         }else {
                     //echo "trade_status=".$_GET['trade_status'];
                     //$this->redirect(C('alipay.errorpage'));//跳转到配置项中配置的支付失败页面；
            $this->error('支付失败-2',U('Change/FrontCode'));
         }
      }else {
                  //验证失败
                  //如要调试，请看alipay_notify.php页面的verifyReturn函数
            $this->error('支付失败-1',U('Change/FrontCode'));
      }
   }
}
?>
