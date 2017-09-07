<?php
class EcpssPayAction extends Action{
	
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
			$feeArr = M('Fee')->field('s14,str12')->find();
			$payUrl="https://pay.ecpss.com/sslpayment";	//支付网关
			
			$MD5key = $feeArr['str12'];		//MD5私钥
			$MerNo = $feeArr['s14'];					//商户号
			$BillNo = $orderid;		//[必填]订单号(商户自己产生：要求不重复)
			$Amount = $amount;				//[必填]订单金额
			$ReturnURL = U('EcpssPay/returnPage','','',false,true);	//通知商户页面端地址 			//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
			$Remark = $rndStr;  //[选填]订单随机验证字符串
			
			$md5src = $MerNo."&".$BillNo."&".$Amount."&".$ReturnURL."&".$MD5key;		//校验源字符串
			$SignInfo = strtoupper(md5($md5src));		//MD5检验结果
	
			$AdviceURL = U('EcpssPay/recvTfgqdyqpfl','','',false,true);   //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
			$orderTime = date('YmdHis');;   //[必填]交易时间YYYYMMDDHHMMSS
			$defaultBankNumber = "";   //[选填]银行代码s 
			$products = "";// 物品信息
			
			
			$sendData = array();
			$sendData['payUrl']=$payUrl;
			$sendData['MerNo']=$MerNo;
			$sendData['BillNo']=$BillNo;
			$sendData['Amount']=$Amount;
			$sendData['ReturnURL']=$ReturnURL;
			$sendData['Remark']=$Remark;
			$sendData['SignInfo']=$SignInfo;
			$sendData['AdviceURL']=$AdviceURL;
			$sendData['orderTime']=$orderTime;
			$sendData['defaultBankNumber']=$defaultBankNumber;
			$sendData['products']=$products;
			
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
	
	public function recvTfgqdyqpfl()
	{
		$feeArr = M('Fee')->field('s14,str12')->find();
		
		$MD5key = $feeArr['str12'];
		$BillNo = $_REQUEST["BillNo"];
		$Amount = $_REQUEST["Amount"];
		$Succeed = $_REQUEST["Succeed"];
		$Result = $_REQUEST["Result"];
		$SignMD5info = $_REQUEST["SignMD5info"]; 
		$Remark = $_REQUEST["Remark"];
	
	  	$md5src = $BillNo."&".$Amount."&".$Succeed."&".$MD5key;
		$md5sign = strtoupper(md5($md5src));
		
		if($SignMD5info == $md5sign)
		{
			if($Succeed == '88')
			{
				$order = M('Remit')->where(array('orderid'=>$BillNo,'is_pay'=>0))->find();
				if($order)
				{
					//if($Remark == $order['ext_chk_str'])
						D('Recharge')->setOnlineOrderDown($BillNo,$Amount,'Ecpss');
				}
			}
			echo 'ok';
		}
		else
			echo 'error';
	}
	
	public function returnPage()
	{
		$feeArr = M('Fee')->field('s14,str12')->find();
		
		$MD5key = $feeArr['str12'];
		$BillNo = $_REQUEST["BillNo"];
		$Amount = $_REQUEST["Amount"];
		$Succeed = $_REQUEST["Succeed"];
		$Result = $_REQUEST["Result"];
		$SignMD5info = $_REQUEST["SignMD5info"]; 
		$Remark = $_REQUEST["Remark"];
	
	  	$md5src = $BillNo."&".$Amount."&".$Succeed."&".$MD5key;
		$md5sign = strtoupper(md5($md5src));
		
		if($SignMD5info == $md5sign)
		{	
			$hint = '';
			if($Succeed == '88')
			{
				if($_SESSION['BaofooPay_amount'] == $Amount)
				{
					$hint = '充值成功，已向你的账户充值 '.sprintf('%.2f',$Amount).'元';
				}
				else
				{
					$hint = '<span style="color:#00F;">充值已完成，实际成交金额与您提交的订单金额不同，请仔细核对成交结果！</span>';
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