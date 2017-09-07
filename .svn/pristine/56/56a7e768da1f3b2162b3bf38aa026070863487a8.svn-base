<?php
// 本类由系统自动生成，仅供测试用途
class CallbackAction extends Action {
	
	//接收_智付
    public function receive()
    {
    	$fee = M('fee');
    	$fee_rs = $fee->field('str31,str32')->find();
    	$fee_rs17 = $fee_rs['str31'];//商户号
    	$fee_rs18 = $fee_rs['str32'];//密钥
    	unset($fee,$fee_rs);
    	
		$merchant_code	= $_POST["merchant_code"];

		//通知类型
		$notify_type = $_POST["notify_type"];
	
		//通知校验ID
		$notify_id = $_POST["notify_id"];
	
		//接口版本
		$interface_version = $_POST["interface_version"];
	
		//签名方式
		$sign_type = $_POST["sign_type"];
	
		//签名
		$dinpaySign = $_POST["sign"];
	
		//商家订单号
		$order_no = $_POST["order_no"];
	
		//商家订单时间
		$order_time = $_POST["order_time"];
	
		//商家订单金额
		$order_amount = $_POST["order_amount"];
	
		//回传参数
		$extra_return_param = $_POST["extra_return_param"];
	
		//智付交易定单号
		$trade_no = $_POST["trade_no"];
	
		//智付交易时间
		$trade_time = $_POST["trade_time"];
	
		//交易状态 SUCCESS 成功  FAILED 失败
		$trade_status = $_POST["trade_status"];
	
		//银行交易流水号
		$bank_seq_no = $_POST["bank_seq_no"];
	
		
		//组织订单信息
		$signStr = "";
		if($bank_seq_no != "") {
			$signStr = $signStr."bank_seq_no=".$bank_seq_no."&";
		}
		if($extra_return_param != "") {
			$signStr = $signStr."extra_return_param=".$extra_return_param."&";
		}
		$signStr = $signStr."interface_version=V3.0&";
		$signStr = $signStr."merchant_code=".$merchant_code."&";
		if($notify_id != "") {
			$signStr = $signStr."notify_id=".$notify_id."&notify_type=".$notify_type."&";
		}
		
		$signStr = $signStr."order_amount=".$order_amount."&";
		$signStr = $signStr."order_no=".$order_no."&";
		$signStr = $signStr."order_time=".$order_time."&";
		$signStr = $signStr."trade_no=".$trade_no."&";
		$signStr = $signStr."trade_status=".$trade_status."&";
		
		if($trade_time != "") {
			$signStr = $signStr."trade_time=".$trade_time."&";
		}
		$key = $fee_rs18;
		
		$signStr = $signStr."key=".$key;
		$signInfo = $signStr;
		//将组装好的信息MD5签名
		$sign = md5($signInfo);
		//echo "sign=".$sign."<br>";
		
		//比较智付返回的签名串与商家这边组装的签名串是否一致
		if($dinpaySign==$sign) {
			//验签成功
			
//			$order_no = "10020131203180056992";
			
			$remit = M('remit');
			$chongzhi = M('chongzhi');
			$history = M('history');
			$fck = M('fck');
			$where = array();
			$where['orderid'] = array('eq',$order_no);
			$where['is_pay'] = array('eq',0);
			$ors = $remit->where($where)->find();
			if($ors){
				$tid = $ors['id'];
				$uid = $ors['uid'];
				$usid = $ors['user_id'];
				$money = $ors['amount'];

				$oresult = $remit->execute("update __TABLE__ set is_pay=1,ok_time=".mktime()." where is_pay=0 and id=".$tid);
				if($oresult){

					$data = array();
					$data['uid']			= $uid;
					$data['user_id']		= $usid;
					$data['action_type']	= 21;
					$data['pdt']			= mktime();
					$data['epoints']		= $money;
					$data['did']			= 0;
					$data['allp']			= 0;
					$data['bz']				= '21';
					$history->add($data);
					unset($data);
					
					$data = array();
					$data['uid']	= $uid;
					$data['user_id']= $usid;
					$data['rdt']	= time();
					$data['pdt']	= time();
					$data['epoint']	= $money;
					$data['is_pay']	= 1;
					$data['stype']	= 0;
					$chongzhi->add($data);
					unset($data);

					$fck->query("update __TABLE__ set agent_cash=agent_cash+".$money." where id=".$uid);
				}
			}else{
				$whe = array();
				$whe['orderid'] = array('eq',$order_no);
				$urs = $remit->where($whe)->field('id')->find();
				if(!$urs){
					$ctdir = "./ErrorLog";
					$ctname = "zi_pay_".date("Y").date("m").date("d");
					$daytime = date("Y-m-d H:i:s");
					$errdata = "时间：".$daytime."。订单号：".$order_no."支付成功，支付金额：".$order_amount."，但充值失败。原因：没有对应充值订单号记录。";

					$this->create_txt($ctdir,$ctname,$errdata);
				}
				unset($urs);
			}
			unset($remit,$fck,$history,$chongzhi,$where,$ors);

			$zf_ok = 1;
			$zf_re = xstr('hint024');
			$zf_or = xstr('order_number')."：".$order_no;
			$zf_am = xstr('pay_amount')."：".$order_amount;
		}else
		{
			$zf_re = xstr('pay_failed');
		}
		$this->assign('zf_re',$zf_re);
		$this->assign('zf_or',$zf_or);
		$this->assign('zf_am',$zf_am);
		if($notify_type=="offline_notify"){
			echo "SUCCESS";
		}
		$this->display();
    }
    
	//接收_环讯
    public function hx_receive()
    {
    	$fee = M('fee');
    	$fee_rs = $fee->field('str31,str32')->find();
    	$fee_rs17 = $fee_rs['str31'];//商户号
    	$fee_rs18 = $fee_rs['str32'];//密钥
    	unset($fee,$fee_rs);
    	
    	$billno = $_GET['billno'];
    	$order_no = $billno;//支付订单号
		$amount = $_GET['amount'];
		$order_amount = $amount;//支付金额
		$mydate = $_GET['date'];
		$succ = $_GET['succ'];
		$msg = $_GET['msg'];
		$attach = $_GET['attach'];
		$ipsbillno = $_GET['ipsbillno'];
		$retEncodeType = $_GET['retencodetype'];
		$currency_type = $_GET['Currency_type'];
		$signature = $_GET['signature'];
		
		$content = 'billno'.$billno.'currencytype'.$currency_type.'amount'.$amount.'date'.$mydate.'succ'.$succ.'ipsbillno'.$ipsbillno.'retencodetype'.$retEncodeType;
		
		$cert = $fee_rs18;//密钥
		$signature_1ocal = md5($content . $cert);
		
		//比较签名串是否一致
		if ($signature_1ocal == $signature){
			//验签成功
			if ($succ == 'Y'){//支付成功
			
//				$order_no = "10020131203180056992";
			
				$remit = M('remit');
				$chongzhi = M('chongzhi');
				$history = M('history');
				$fck = M('fck');
				$where = array();
				$where['orderid'] = array('eq',$order_no);
				$where['is_pay'] = array('eq',0);
				$ors = $remit->where($where)->find();
				if($ors){
					$tid = $ors['id'];
					$uid = $ors['uid'];
					$usid = $ors['user_id'];
					$money = $ors['amount'];
	
					$oresult = $remit->execute("update __TABLE__ set is_pay=1,ok_time=".mktime()." where is_pay=0 and id=".$tid);
					if($oresult){
	
						$data = array();
						$data['uid']			= $uid;
						$data['user_id']		= $usid;
						$data['action_type']	= 21;
						$data['pdt']			= mktime();
						$data['epoints']		= $money;
						$data['did']			= 0;
						$data['allp']			= 0;
						$data['bz']				= '21';
						$history->add($data);
						unset($data);
						
						$data = array();
						$data['uid']	= $uid;
						$data['user_id']= $usid;
						$data['rdt']	= time();
						$data['pdt']	= time();
						$data['epoint']	= $money;
						$data['is_pay']	= 1;
						$data['stype']	= 0;
						$chongzhi->add($data);
						unset($data);
	
						$fck->query("update __TABLE__ set agent_cash=agent_cash+".$money." where id=".$uid);
					}
				}else{
					$whe = array();
					$whe['orderid'] = array('eq',$order_no);
					$urs = $remit->where($whe)->field('id')->find();
					if(!$urs){
						$ctdir = "./ErrorLog";
						$ctname = "hx_pay_".date("Y").date("m").date("d");
						$daytime = date("Y-m-d H:i:s");
						$errdata = "时间：".$daytime."。订单号：".$order_no."支付成功，支付金额：".$order_amount."，但充值失败。原因：没有对应充值订单号记录。";
	
						$this->create_txt($ctdir,$ctname,$errdata);
					}
					unset($urs);
				}
				unset($remit,$fck,$history,$chongzhi,$where,$ors);
	
				$zf_ok = 1;
				$zf_re = xstr('hint024');
				$zf_or = xstr('order_number')."：".$order_no;
				$zf_am = xstr('pay_amount')."：".$order_amount;
			}else
			{
				$zf_re = xstr('pay_failed');
			}
		}else
		{
			$zf_re = xstr('pay_failed');
		}
		$this->assign('zf_re',$zf_re);
		$this->assign('zf_or',$zf_or);
		$this->assign('zf_am',$zf_am);
		
		$this->display("receive");
    }

    //接收_Ease
    public function ease_receive()
    {
    	$fee = M('fee');
    	$fee_rs = $fee->field('str17,str18')->find();
    	$fee_rs17 = $fee_rs['str17'];//商户号
    	$fee_rs18 = $fee_rs['str18'];//密钥
    	unset($fee,$fee_rs);
    	 
    	$billno = $_GET['MerOrderNo'];
    	$order_no = $billno;//支付订单号
    	$amount = $_GET['Amount'];
    	$order_amount = $amount;//支付金额
    	$mydate = $_GET['OrderDate'];
    	$succ = $_GET['Succ'];
    	$msg = $_GET['Msg'];
    	$attach = $_GET['GoodsInfo'];
    	$ipsbillno = $_GET['SysOrderNo'];
    	$retEncodeType = $_GET['RetencodeType'];
    	$currency_type = $_GET['Currency'];
    	$signature = $_GET['Signature'];
    
    
    	//'----------------------------------------------------
    	//'   Md5摘要认证
    	//'   verify  md5
    	//'----------------------------------------------------
    	$content = $billno . $amount . $mydate . $succ . $ipsbillno . $currency_type;
    	//请在该字段中放置商户登陆mer.easy8pay.com下载的证书
    	$cert = $fee_rs18;//密钥
    	$signature_1ocal = md5($content . $cert);
    
    	//比较签名串是否一致
    	if ($signature_1ocal == $signature){
    		//验签成功
    		if ($succ == 'Y'){//支付成功
    				
    			//				$order_no = "10020131203180056992";
    				
    			$remit = M('remit');
    			$chongzhi = M('chongzhi');
    			$history = M('history');
    			$fck = D('Fck');
    			$where = array();
    			$where['orderid'] = array('eq',$order_no);
    			$where['is_pay'] = array('eq',0);
    			$ors = $remit->where($where)->find();
    			if($ors){
    				$tid = $ors['id'];
    				$uid = $ors['uid'];
    				$b_uid = $ors['b_uid'];
    				$usid = $ors['user_id'];
    				$money = $ors['amount'];
    
    				$oresult = $remit->execute("update __TABLE__ set is_pay=1,ok_time=".mktime()." where is_pay=0 and id=".$tid);
    				if($oresult){
    					$data = array();
    					$data['uid']			= $uid;
    					$data['user_id']		= $usid;
    					$data['action_type']	= 21;
    					$data['pdt']			= mktime();
    					$data['epoints']		= $money;
    					$data['did']			= 0;
    					$data['allp']			= 0;
    					$data['bz']				= '21';
    					$history->add($data);
    					unset($data);
    
    					$data = array();
    					$data['uid']	= $uid;
    					$data['user_id']= $usid;
    					$data['rdt']	= time();
    					$data['pdt']	= time();
    					$data['epoint']	= $money;
    					$data['is_pay']	= 1;
    					$data['stype']	= 0;
    					$chongzhi->add($data);
    					unset($data);
	    
	    				$fck->query("update __TABLE__ set agent_xf=agent_xf+".$money." where id=".$uid);
    				}
    			}else{
    				$whe = array();
    				$whe['orderid'] = array('eq',$order_no);
    				$urs = $remit->where($whe)->field('id')->find();
    				if(!$urs){
    					$ctdir = "./ErrorLog";
    					$ctname = "hx_pay_".date("Y").date("m").date("d");
    					$daytime = date("Y-m-d H:i:s");
    					$errdata = "时间：".$daytime."。订单号：".$order_no."支付成功，支付金额：".$order_amount."，但充值失败。原因：没有对应充值订单号记录。";
    
    					$this->create_txt($ctdir,$ctname,$errdata);
    				}
    				unset($urs);
    			}
    			unset($remit,$fck,$history,$chongzhi,$where,$ors);
    
    			$zf_ok = 1;
    			$zf_re = xstr('hint024');
    			$zf_or = xstr('order_number')."：".$order_no;
    			$zf_am = xstr('pay_amount')."：".$order_amount;
    		}else
    		{
    			$zf_re = xstr('pay_failed');
    		}
    	}else
    	{
    		$zf_re = xstr('pay_failed');
    	}
    	$this->assign('zf_re',$zf_re);
    	$this->assign('zf_or',$zf_or);
    	$this->assign('zf_am',$zf_am);
    
    	$this->display("receive");
    }
    
	//建立文件
	private function create_txt($ctdir="./ErrorLog",$ctname="",$data="",$err){

		$hz = "txt";
		$dir = $ctdir."/".$ctname.".".$hz;
		$data = $data."\r\n";
		$sql=mb_convert_encoding($data, "UTF-8", "auto");//自动转码
		if(!is_dir($ctdir)){
			mkdir($ctdir, 0777);//创建文件夹
		}
		$oldsql = file_get_contents($dir);
		$newsql = $oldsql.$sql;
		$handle = fopen($dir, "w");
		if (!$handle){
			$err .= "<li>".$dir.xstr('open_failed')."!</li>";
		}
		if (!fwrite($handle, $newsql)){
			$err .= "<li>".$dir.xstr('write_failed')."!</li>";
		}
		fclose($handle);
	}
}
?>