<?php
class EasepayAction extends Action{
	
    /**
     * 简付宝第三方
     * str17 商户号参数
     * str18 密钥参数
     * 注意修改Zhuan文件夹内config配置
     * **/
    public function Ease_pay($orderid,$payamount)
    {
    	
    	$fee = M('fee');
    	$fee_rs = $fee->field('str17,str18')->find();
    	$fee_rs17 = $fee_rs['str17'];//商户号
    	$fee_rs18 = $fee_rs['str18'];//密钥
    	unset($fee,$fee_rs);

		//商户号（必填）
		$Mer_code = $fee_rs17;
		
		//密钥
		$Mer_key = $fee_rs18;

		//定单金额（必填）
		$payamount = number_format($payamount,2,".","");
		$Amount = $payamount;
		
		//显示金额（必填）
		$DispAmount = $payamount;

		//商家定单号(必填)
		$Billno = $orderid;

		//商家定单日期(必填)
		$Date = date('Ymd');
		
		//币种
		$Currency_Type = "RMB";
		
		//支付方式
		$Gateway_Type = "01";//01为借记卡
		
		//语言
		$Lang = "GB";//GB中文

		//订单支付加密方式
		$OrderEncodeType = '2';//MD5摘要;
		
		//交易返回加密方式
		$RetEncodeType = '12';//MD5摘要;
		
		//商户附加数据包
		$Attach = '';
		
		//是否提供Server返回方式
		$Rettype = '0';//0无Server to Server,1有Server to Server

		//Server to Server返回页面
		$ServerUrl = '';
		
		//订单支付接口的Md5摘要，原文=订单号+金额+日期+报单币种+商户证书
		$SignMD5 = md5($Billno . $Amount . $Date . $Currency_Type . $Mer_key);
		
// 		//订单支付接口的Md5摘要，原文=订单号+金额+日期+报单币种+商户证书 
// 		$SignStr = "billno".$Billno."currencytype".$Currency_Type."amount".$Amount."date".$Date."orderencodetype".$OrderEncodeType.$Mer_key;
// 		$SignMD5 = md5($SignStr);

		//中转地址
		$see = $_SERVER['HTTP_HOST'];
		$Https_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
		$Zhuan_url = $Https_url.$see."".__ROOT__."/Zhuan/redirect.asp";
		$Zhuan_url = "https://payment.easy8pay.com/gateway.aspx";
		
		//后台通知地址
		$Merchanturl = $Https_url.$see."".__APP__."/Callback/ease_receive/";

		$this->assign('Mer_code',$Mer_code);
		$this->assign('Billno',$Billno);
		$this->assign('Amount',$Amount);//商家号
		$this->assign('Date',$Date);
		$this->assign('Currency_Type',$Currency_Type);
		$this->assign('Gateway_Type',$Gateway_Type);
		$this->assign('Lang',$Lang);
		$this->assign('Attach',$Attach);
		$this->assign('DispAmount',$DispAmount);
		$this->assign('OrderEncodeType',$OrderEncodeType);
		$this->assign('RetEncodeType',$RetEncodeType);
		$this->assign('Rettype',$Rettype);
		$this->assign('ServerUrl',$ServerUrl);
		$this->assign('SignMD5',$SignMD5);
		$this->assign('Zhuan_url',$Zhuan_url);
		$this->assign('Merchanturl',$Merchanturl);
//		$this->assign('Merchanturl',$Merchanturl);
		$this->assign('Mer_key',$Mer_key);
    }
	

	
}


?>