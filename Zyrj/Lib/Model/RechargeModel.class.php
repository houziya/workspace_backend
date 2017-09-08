<?php
class RechargeModel extends Model
{
	public function setOnlineOrderDown($orderID,$amount,$apiName='')
	{
		$order = M('Remit')->where(array('orderid'=>$orderID,'is_pay'=>0))->find();
		if($order)
		{
			$Result = M('Remit')->execute("update __TABLE__ set is_pay=1,ok_time=".mktime()." where is_pay=0 and id=".$order['id']);
			if($Result){
				
				
				$feeArr = M('Fee')->field('s5')->find();
				$systemRatio = floatval($feeArr['s5']);
				$systemRatio /= 100;
				$sysSubNum = $amount*$systemRatio;
				$recSubNum = 0;
				$curUser = M('Fck')->field('id,user_id,rech_ratio,re_id')->where(array('id'=>array('eq',$order['uid']),'is_pay'=>array('gt',0),'is_fenh'=>array('eq',0)))->find();
				if($curUser)
				{
					$recRatio = floatval($curUser['rech_ratio']);
					$recRatio /= 100;
					$recSubNum = $amount*$recRatio;
				}
				$realEPoint = $amount-$sysSubNum-$recSubNum;
				
				$data = array();
				$data['uid']			= $order['uid'];
				$data['user_id']		= $order['use_id'];
				$data['action_type']	= 21;
				$data['pdt']			= mktime();
				$data['epoints']		= $realEPoint;
				$data['did']			= 0;
				$data['allp']			= 0;
				$data['bz']				= '21';
				M('history')->add($data);
				unset($data);
				
				$data = array();
				$data['uid']	= $order['uid'];
				$data['user_id']= $order['use_id'];
				$data['rdt']	= time();
				$data['pdt']	= time();
				$data['epoint']	= $amount;
				$data['is_pay']	= 1;
				$data['stype']	= 0;
				M('Chongzhi')->add($data);
				unset($data);
				
				if($recSubNum >= 0.01)
					D('Fck')->rw_bonus($curUser['re_id'],$curUser['user_id'],5,$recSubNum);
				
				M('Fck')->query("update __TABLE__ set agent_use=agent_use+".$realEPoint." where id=".$order['uid']);
			}
		}
		else
		{
			$urs = M('Remit')->field('id')->where(array('orderid'=>$orderID))->find();
			if(!$urs)
			{
				$ctdir = "./ErrorLog";
				$ctname = $apiName.'_'.date("Ymd");
				$daytime = date("Y-m-d H:i:s");
				$errdata = "时间：".$daytime."。订单号：".$orderID."支付成功，支付金额：".$order_amount."，但充值失败。原因：没有对应充值订单号记录。";
				A('Recharge')->create_txt($ctdir,$ctname,$errdata);
			}
			unset($urs);
		}
	}
}
?>