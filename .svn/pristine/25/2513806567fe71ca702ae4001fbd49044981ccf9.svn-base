<?php
class BaofooPayAction extends Action{
	
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
			$feeArr = M('Fee')->field('s13,str16,s4')->find();
			$payUrl="http://gw.baofoo.com/payindex";	//支付网关
			$MARK = "|";
			$Md5key = $feeArr['s4'];//md5密钥（KEY）
			$PageUrl = U('BaofooPay/returnPage','','',false,true);	//通知商户页面端地址
			$ReturnUrl = U('BaofooPay/recvQnygppgu','','',false,true);	//服务器底层通知地址
			
			$MemberID = $feeArr['s13'];//商户号
			$TerminalID = $feeArr['str16'];	//终端ID
			$TransID = $orderid;//订单号
			$PayID = '';//支付方式
			$TradeDate = date('YmdHis');	//订单时间
			$OrderMoney = $amount*100;	//订单金额
			//$ProductName = '';	//产品名称
			//$Amount = 0;	//商品数量
			//$Username = '';//支付用户名
			$AdditionalInfo = $rndStr;//订单附加消息
			$InterfaceVersion = "4.0";	//接口版本号
			$NoticeType = '1';//通知类型
			$KeyType = "1";	//加密类型	
			
			//MD5签名格式
			$Signature=md5($MemberID.$MARK.$PayID.$MARK.$TradeDate.$MARK.$TransID.$MARK.$OrderMoney.$MARK.$PageUrl.$MARK.$ReturnUrl.$MARK.$NoticeType.$MARK.$Md5key);
			
			$sendData = array();
			$sendData['payUrl']=$payUrl;
			$sendData['MemberID']=$MemberID;
			$sendData['TerminalID']=$TerminalID;
			$sendData['TransID']=$TransID;
			$sendData['PayID']=$PayID;
			$sendData['TradeDate']=$TradeDate;
			$sendData['OrderMoney']=$OrderMoney;
			$sendData['ReturnUrl']=$ReturnUrl;
			$sendData['InterfaceVersion']=$InterfaceVersion;
			$sendData['NoticeType']=$NoticeType;
			$sendData['KeyType']=$KeyType;
			$sendData['Signature']=$Signature;
			$sendData['PageUrl']=$PageUrl;
			$sendData['AdditionalInfo']=$AdditionalInfo;
			$this->assign('sendData',$sendData);
			C('TOKEN_ON',false);
			
			$_SESSION['BaofooPay_orderID'] = $orderid;
			$_SESSION['BaofooPay_amount'] = $amount*100;
			
			$this->display('Recharge:opJump');
		}
		else
		{
			$this->error(xstr('hint019'));
			exit;
		}
	}
	
	public function recvQnygppgu()
	{
		$feeArr = M('Fee')->field('s13,str16,s4')->find();
		$MemberID = $feeArr['s13'];//商户号
		$TerminalID = $feeArr['str16'];//商户终端号
		$TransID = $_REQUEST['TransID'];//流水号
		$FactMoney=$_REQUEST['FactMoney'];//实际成功金额
		$AdditionalInfo=$_REQUEST['AdditionalInfo'];//订单附加消息
		$SuccTime=$_REQUEST['SuccTime'];//支付完成时间
		$Md5Sign=$_REQUEST['Md5Sign'];//md5签名
		$Md5key = $feeArr['s4'];
		$MARK = "~|~";
		//MD5签名格式
		
		$Result=$_REQUEST['Result'];//支付结果
		$ResultDesc=$_REQUEST['ResultDesc'];//支付结果描述
		
		$WaitSign=md5('MemberID='.$MemberID.$MARK.'TerminalID='.$TerminalID.$MARK.'TransID='.$TransID.$MARK.'Result='.$Result.$MARK.'ResultDesc='.$ResultDesc.$MARK.'FactMoney='.$FactMoney.$MARK.'AdditionalInfo='.$AdditionalInfo.$MARK.'SuccTime='.$SuccTime.$MARK.'Md5Sign='.$Md5key);

		if($WaitSign == $Md5Sign)
		{
			if($Result != 0 && $ResultDesc == '01')
			{
				$order = M('Remit')->where(array('orderid'=>$TransID,'is_pay'=>0))->find();
				if($order)
				{
					if($AdditionalInfo == $order['ext_chk_str'])
						D('Recharge')->setOnlineOrderDown($TransID,$FactMoney/100,'Baofoo');
				}
			}
			echo 'ok';
		}
		else
			echo 'Md5CheckFail';
	}
	
	public function returnPage()
	{
		$feeArr = M('Fee')->field('s13,str16,s4')->find();
		$MemberID = $feeArr['s13'];//商户号
		$TerminalID = $feeArr['str16'];//商户终端号
		$TransID = $_REQUEST['TransID'];//流水号
		$FactMoney=$_REQUEST['FactMoney'];//实际成功金额
		$AdditionalInfo=$_REQUEST['AdditionalInfo'];//订单附加消息
		$SuccTime=$_REQUEST['SuccTime'];//支付完成时间
		$Md5Sign=$_REQUEST['Md5Sign'];//md5签名
		$Md5key = $feeArr['s4'];
		$MARK = "~|~";
		//MD5签名格式
		
		$Result=$_REQUEST['Result'];//支付结果
		$ResultDesc=$_REQUEST['ResultDesc'];//支付结果描述
		
		$WaitSign=md5('MemberID='.$MemberID.$MARK.'TerminalID='.$TerminalID.$MARK.'TransID='.$TransID.$MARK.'Result='.$Result.$MARK.'ResultDesc='.$ResultDesc.$MARK.'FactMoney='.$FactMoney.$MARK.'AdditionalInfo='.$AdditionalInfo.$MARK.'SuccTime='.$SuccTime.$MARK.'Md5Sign='.$Md5key);

		if($WaitSign == $Md5Sign)
		{
			if($Result != 0)
			{
				$hint = '';
				if($_SESSION['BaofooPay_amount'] == $FactMoney)
				{
					$hint = xstr('hint020').sprintf('%.2f',$FactMoney/100).xstr('yuan');
				}
				else
				{
					$hint = '<span style="color:#00F;">'.xstr('hint021').'</span>';
				}
			}
			else
			{
				$hint = '<span style="color:#F00;">'.xstr('pay_failed').'</span>';
			}
			
			$this->assign('hint',$hint);
			$this->display('Recharge:opRtnPage');
			unset($_SESSION['BaofooPay_orderID'],$_SESSION['BaofooPay_amount']);
		}
		
	}
}


?>