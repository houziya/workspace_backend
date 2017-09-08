<?php
class ChinabankPayAction extends Action{
	
    public function send($orderid,$amount)
	{
		//$uid = $_SESSION[C('USER_AUTH_KEY')];
		$order = M('Remit')->where(array('orderid'=>$orderid,'is_pay'=>0))->find();
		if($order)
		{
			/*
			if($order['uid'] != $uid)
			{
				$this->error('您不可以支付该订单');
				exit;
			}*/
			$rndStr = md5(rand(11111,99999999));
			M('Remit')->save(array('id'=>$order['id'],'ext_chk_str'=>$rndStr));
			
			$feeArr = M('Fee')->field('str4,str5')->find();
			
			$payUrl="https://pay3.chinabank.com.cn/PayGate";	//支付网关
			
			$skey = $feeArr['str5'];	//私钥
			
			$v_mid = $feeArr['str4'];	//商户号
			$v_oid = $orderid;	//订单号
			$v_amount = sprintf('%.2f',$amount);	//订单金额
			$v_moneytype = 'CNY';
			$v_url = U('ChinabankPay/returnPage','','',false,true);	//通知商户页面端地址 			//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
			$remark1 = $rndStr;  //[备注1]订单随机验证字符串
			$remark2 = '';
			
			$md5src = $v_amount.$v_moneytype.$v_oid.$v_mid.$v_url.$skey;		//校验源字符串
			$v_md5info = strtoupper(md5($md5src));		//MD5检验结果
			
			$sendData = array();
			$sendData['payUrl']=$payUrl;
			$sendData['v_mid']=$v_mid;
			$sendData['v_oid']=$v_oid;
			$sendData['v_amount']=$v_amount;
			$sendData['v_moneytype']=$v_moneytype;
			$sendData['v_url']=$v_url;
			$sendData['remark1']=$remark1;
			$sendData['remark2']=$remark2;
			$sendData['v_md5info']=$v_md5info;
			
			
			$this->assign('sendData',$sendData);
			
			C('TOKEN_ON',false);
			
			$_SESSION['BaofooPay_orderID'] = $orderid;
			$_SESSION['BaofooPay_amount'] = $amount;
			
			$this->display('Recharge:opJump');
		}
		else
		{
			$this->error('没有该订单记录！');
			exit;
		}
	}
	
	public function recvZaqigygcez()
	{
		$feeArr = M('Fee')->field('str4,str5')->find();
		
		$skey = $feeArr['str5'];	//密钥
		
		$v_oid = $_REQUEST["v_oid"];	//订单ID
		$v_pstatus = $_REQUEST["v_pstatus"];	//状态，20为成功，30为失败
		$v_pstring = $_REQUEST["v_pstring"];	//支付完成或支付失败
		$v_pmode = $_REQUEST["v_pmode"];	//支付方式
		$v_md5str = $_REQUEST["v_md5str"];	//MD5验证串
		$v_amount = $_REQUEST["v_amount"];	//交易金额
		$v_moneytype = $_REQUEST["v_moneytype"];	//币种 人民币为CNY
		$remark1 = $_REQUEST["remark1"];	//备注1
		$remark2 = $_REQUEST["remark2"];	//备注2
		
	
	  	$md5src = $v_oid.$v_pstatus.$v_amount.$v_moneytype.$skey;
		$md5sign = strtoupper(md5($md5src));
		
		if($v_md5str == $md5sign)
		{
			if($v_pstatus == '20')
			{
				$order = M('Remit')->where(array('orderid'=>$v_oid,'is_pay'=>0))->find();
				if($order)
				{
					if($remark1 == $order['ext_chk_str'])
						D('Recharge')->setOnlineOrderDown($v_oid,$v_amount,'Chinabank');
				}
			}
			echo 'ok';
		}
		else
			echo 'error';
	}
	
	public function returnPage()
	{
		$feeArr = M('Fee')->field('str4,str5,i11')->find();
		
		$skey = $feeArr['str5'];	//密钥
		
		$v_oid = $_REQUEST["v_oid"];	//订单ID
		$v_pstatus = $_REQUEST["v_pstatus"];	//状态，20为成功，30为失败
		$v_pstring = $_REQUEST["v_pstring"];	//支付完成或支付失败
		$v_pmode = $_REQUEST["v_pmode"];	//支付方式
		$v_md5str = $_REQUEST["v_md5str"];	//MD5验证串
		$v_amount = $_REQUEST["v_amount"];	//交易金额
		$v_moneytype = $_REQUEST["v_moneytype"];	//币种 人民币为CNY
		$remark1 = $_REQUEST["remark1"];	//备注1
		$remark2 = $_REQUEST["remark2"];	//备注2
		
	
	  	$md5src = $v_oid.$v_pstatus.$v_amount.$v_moneytype.$skey;
		$md5sign = strtoupper(md5($md5src));
		
		if($v_md5str == $md5sign)
		{
			$hint = '';
			if($v_pstatus == '20')
			{
				if($_SESSION['BaofooPay_amount'] == $v_amount)
				{
					$hint = '充值成功，已向你的账户充值.'.sprintf('%.2f',$v_amount).'元';
				}
				else
				{
					if($v_amount > $_SESSION['BaofooPay_amount'])
						$v_amount = $_SESSION['BaofooPay_amount'];
					$hint = '<span style="color:#00F;">充值已完成，实际成交金额与您提交的订单金额不同，请仔细核对成交结果！</span>';
				}
				$switch = intval($feeArr['i11']);
				$switch &= 0x1;
				if(!$switch)
				{
					$order = M('Remit')->where(array('orderid'=>$v_oid,'is_pay'=>0))->find();
					if($order)
					{
						if($remark1 == $order['ext_chk_str'])
							D('Recharge')->setOnlineOrderDown($v_oid,$v_amount,'Chinabank');
					}
				}
			}
			else
			{
				$hint = '<span style="color:#F00;">支付失败！</span>';
			}
			
			$this->assign('hint',$hint);
			$this->display('Recharge:opRtnPage');
			unset($_SESSION['BaofooPay_orderID'],$_SESSION['BaofooPay_amount']);
		}
		
	}
}


?>