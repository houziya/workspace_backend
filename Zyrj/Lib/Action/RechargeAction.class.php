<?php
class RechargeAction extends CommonAction{
	
	public function _initialize() {
		parent::_initialize();
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(0);//调用过滤函数
		$this->_Config_name();//调用参数
		$this->_checkUser();
	}
	
	public function cody(){
		//===================================二级验证
		$UrlID = (int) $_GET['c_id'];
		if (empty($UrlID)){
			$this->error(xstr('second_password_error'));
			exit;
		}
		if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$cody   =  M ('cody');
		$list	=  $cody->where("c_id=$UrlID")->field('c_id')->find();
		if ($list){
			$this->assign('vo',$list);
			$v_title = $this->theme_title_value();
			$this->distheme('../Public/cody',$v_title[1]);
			exit;
		}else{
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	public function codys(){
		//=============================二级验证后调转页面
		$Urlsz = (int) $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass  = $_POST['oldpassword'];
			$fck   =  M ('fck');
			if (!$fck->autoCheckToken($_POST)){
				$this->error(xstr('page_expire_please_reflush'));
				exit();
			}
			if (empty($pass)){
				$this->error(xstr('second_password_error'));
				exit();
			}
	
			$where = array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $fck->where($where)->field('id,is_agent')->find();
			if($list == false){
				$this->error(xstr('second_password_error'));
				exit();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz){
			case 1;
			$_SESSION['Urlszpass'] = 'MyssMangGuo';
			$bUrl = __URL__.'/currencyRecharge';//货币充值
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['UrlPTPass'] = 'MyssGuanMangGuo';
			$bUrl = __URL__.'/adminCurrencyRecharge';//后台充值管理
			$this->_boxx($bUrl);
			break;
			case 3;
			$_SESSION['Urlszpass'] = 'MyssonlineRecharge';
			$bUrl = __URL__.'/onlineRecharge';
			$this->_boxx($bUrl);
			break;
			case 4;
			$_SESSION['UrlPTPass'] = 'MyssadminonlineRecharge';
			$bUrl = __URL__.'/adminonlineRecharge';
			$this->_boxx($bUrl);
			break;
			
			default;
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	
	//==========================货币充值
	public function currencyRecharge(){
		if ($_SESSION['Urlszpass'] == 'MyssMangGuo'){
			$chongzhi = M('chongzhi');
			$fck = M('fck');
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
	
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $chongzhi->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$Page = new ZQPage($count,$listrows,1);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $chongzhi->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			
			$where = array();
			$fwhere = array();
			$where['id'] = 1;
			$fwhere['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field = '*';
			$rs = $fck ->where($where)->field($field)->find();
			$frs = $fck ->where($fwhere)->field($field)->find();
			$this->assign('rs',$rs);
			$this->assign('frs',$frs);
	
			$nowdate[] =array();
			$nowdate[0] = date('Y');
			$nowdate[1] =date('m');
			$nowdate[2] =date('d');
	
			$this->assign('nowdate',$nowdate);
	
			$fee_rs = M ('fee') -> find();
			$this -> assign('str26',$fee_rs['str26']);
			$this -> assign('str12',$fee_rs['str12']);
			$this -> assign('str6',$fee_rs['str6']);
			$v_title = $this->theme_title_value();
			$this->distheme('currencyRecharge',$v_title[93]);
			return;
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
	public function currencyRechargeAC(){
		if ($_SESSION['Urlszpass'] == 'MyssMangGuo'){
			$fck = M ('fck');
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$rs = $fck -> field('is_pay,user_id') -> find($ID);
			// if($rs['is_pay'] == 0){
			// 	$this->error('临时会员不能充值！');
			// 	exit;
			// }
			$fee_rs = M ('fee')-> find(1);
			$str4=$fee_rs['str10'];
			$str4=1;
			//$s7=$fee_rs['s7'];   //最低值
			//$s8=$fee_rs['s8'];   //倍数
			$inUserID=$rs['user_id'];
	
			$ePoints = trim($_POST['ePoints']);
			$stype = (int) trim($_POST['stype']);
			$chongzhi = M('chongzhi');
			if (!$chongzhi->autoCheckToken($_POST)){
				$this->error(xstr('page_expire_please_reflush'));
				exit;
			}
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error(xstr('hint025'));
				exit;
			}
			if (strlen($ePoints)>9){
				$this->error (xstr('hint026'));
				exit;
			}
			if ($ePoints<=0){
				$this->error (xstr('hint082'));
				exit;
			}
			/*
			if ($ePoints<$s7){
				$this->error ("金额不能小于最低值".$s7."!");
				exit;
			}

			if ($ePoints%$s8){
				$this->error ("金额必须为".$s8."的倍数!");
				exit;
			}*/

			if(!($stype==1||$stype==0)){
				$this->error(xstr('hint083'));
				exit;
			}
	
			$id =  $_SESSION[C('USER_AUTH_KEY')];
			$where = array();
			$where['uid'] = $id;
			$where['is_pay'] = 0;
			$field1 = 'id';
			$vo3 = $chongzhi ->where($where)->field($field1)->find();
			if ($vo3){
				$this->error(xstr('hint084'));
				exit;
			}
			
			
			
			//开始事务处理
			$chongzhi->startTrans();
	
			//充值表
//			$_money = trim($_POST['_money']);  //已汇款数额
			$_money = $ePoints*$str4;  //已汇款数额
			$_num = trim($_POST['_num']);  // 汇款到账号
			$_year = trim($_POST['_year']); // 年
			$_month = trim($_POST['_month']);  //月
			$_date = trim($_POST['_date']);  //日
			$_hour = trim($_POST['_hour']);  //小时
			$_min = trim($_POST['_min']);  //f
			$_sec = trim($_POST['_sec']);  //m
			$bz = trim($_POST['bz']);  //bz
	
			/*
			if (empty($bz)){
				$this->error(xstr('please_input_remark'));
				exit;
			}*/
			if (empty($_num)){
				$this->error(xstr('hint085'));
				exit;
			}
			if (empty($_year) || !is_numeric($_year)){
				$this->error(xstr('hint086'));
				exit;
			}
			if (empty($_month) || !is_numeric($_month)){
				$this->error(xstr('hint087'));
				exit;
			}
			if (empty($_date) || !is_numeric($_date)){
				$this->error(xstr('hint088'));
				exit;
			}
			if (empty($_hour) || !is_numeric($_hour)){
				$this->error(xstr('hint089'));
				exit;
			}
			if (empty($_min) || !is_numeric($_min)){
				$this->error(xstr('hint090'));
				exit;
			}
			if (empty($_sec) || !is_numeric($_sec)){
				$this->error(xstr('hint091'));
				exit;
			}
	
			
			//$nowdate = strtotime(date('c'));
			$nowdate = strtotime(date($_year.'-'. $_month.'-'.$_date.' '. $_hour.':'.$_min.':'.$_sec));
			if($nowdate==0){
				$this->error(xstr('hint092'));
				exit;
			}
	
			$data = array();
			$data['uid']     = $id;
			$data['user_id'] = $inUserID;
			$data['huikuan'] = $_money;
			$data['zhuanghao'] = $_num;
			$data['rdt']     = $nowdate;
			$data['epoint']  = $ePoints;
			$data['is_pay']  = 0;
			$data['stype']  = $stype;
			$data['bz']  = $bz;
	
			$rs2 = $chongzhi->add($data);
			unset($data,$id);
			if ($rs2){
				//提交事务
				$chongzhi->commit();
				$bUrl = __URL__.'/currencyRecharge';
				$this->_box(1,xstr('hint093'),$bUrl,1);
				exit;
			}else{
				//事务回滚：
				$chongzhi->rollback();
				$this->error(xstr('hint094'));
				exit;
			}
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
	
	//==============================充值管理
	public function adminCurrencyRecharge(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$chongzhi = M ('chongzhi');
			$UserID = $_REQUEST['UserID'];
			if (!empty($UserID)){
				//$UserID = strtolower($UserID);
// 				$map['user_id'] = array('like',"%".$UserID."%");
				$map['user_id'] = array('eq',$UserID);
			}
			
			$sdata = strtotime($_REQUEST['sNowDate']);
			$edata = strtotime($_REQUEST['endNowDate']);
			
			if(!empty($sdata) && empty($edata)){
				$map['pdt'] = array('gt',$sdata);
			}
			
			if(!empty($edata) && empty($sdata)){
				$enddata = $edata + 24*3600-1;
				$map['pdt'] = array('elt',$enddata);
			}
			
			
			
			if(!empty($sdata) &&  !empty($edata)){
				$enddatas = $edata + 24*3600-1;
				$map['_string'] = 'pdt >= '.$sdata.' and pdt <= '.$enddatas;
			}
			
			
	
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $chongzhi->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID=' . $UserID.'&sNowDate='.$_REQUEST['sNowDate'].'&endNowDate='.$_REQUEST['endNowDate'];//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $chongzhi->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			
			$m_count = $chongzhi->where($map)->sum('epoint');
			$this->assign('m_count',$m_count);
	
			$v_title = $this->theme_title_value();
			$this->distheme('adminCurrencyRecharge',$v_title[192]);
			exit();
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	
	
	
	//==============================充值管理
	public function OldCurrencyRecharge(){
		$this->_Admin_checkUser();
	//	if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$chongzhi = M ('chongzhi');
			$UserID = $_REQUEST['UserID'];
			if (!empty($UserID)){
				//$UserID = strtolower($UserID);
// 				$map['user_id'] = array('like',"%".$UserID."%");
				$map['user_id'] = array('eq',$UserID);
			}
			
		/*	$sdata = strtotime($_REQUEST['sNowDate']);
			$edata = strtotime($_REQUEST['endNowDate']);
			
			if(!empty($sdata) && empty($edata)){
				$map['pdt'] = array('gt',$sdata);
			}
			
			if(!empty($edata) && empty($sdata)){
				$enddata = $edata + 24*3600-1;
				$map['pdt'] = array('elt',$enddata);
			}
		*/	
			
			
			if(!empty($sdata) &&  !empty($edata)){
				$enddatas = $edata + 24*3600-1;
				$map['_string'] = 'pdt >= '.$sdata.' and pdt <= '.$enddatas;
			}
			
			
	
			$field  = '*';
		/*	//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $chongzhi->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID=' . $UserID.'&sNowDate='.$_REQUEST['sNowDate'].'&endNowDate='.$_REQUEST['endNowDate'];//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $chongzhi->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			
			$this->assign('list',$list);//数据输出到模板
			//=================================================
		*/	
			$m_count = $chongzhi->where($map)->sum('epoint');
			$this->assign('m_count',$m_count);
	
			$v_title = $this->theme_title_value();
			$this->distheme('OldCurrencyRecharge',$v_title[192]);
			exit();
		//}else{
			//$this->error(xstr('error_signed'));
			//exit;
		//}
	}
	
	
	
	public function adminCurrencyRechargeAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$fck = M ('fck');
		if (!$fck->autoCheckToken($_POST)){
			$this->error(xstr('page_expire_please_reflush'));
			exit;
		}
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminCurrencyRecharge';
			$this->_box(1,xstr('please_select'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('confirm_2');
			$this->_adminCurrencyRechargeOpen($PTid);
			break;
			case xstr('delete');
			$this->_adminCurrencyRechargeDel($PTid);
			break;
			default;
			$bUrl = __URL__.'/adminCurrencyRecharge';
			$this->_box(0,xstr('record_not_exists'),$bUrl,1);
			break;
		}
	}
	
	public function adminCurrencyRechargeAdd(){
		//为会员充值
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$fck = M ('fck');
			if (!$fck->autoCheckToken($_POST)){
				$this->error(xstr('page_expire_please_reflush'));
				exit;
			}
			$UserID = $_POST['UserID'];
			//$UserID = strtolower($UserID);
			$ePoints = $_POST['ePoints'];
			$content = $_POST['content'];
			$stype = (int)$_POST['stype'];
			$bz = trim($_POST['bz']);
			if (is_numeric($ePoints) == false){
				$this->error(xstr('hint095'));
				exit;
			}
			if (!empty($UserID) && !empty($ePoints)){
				$where = array();
				$where['user_id'] = $UserID;
				$where['is_pay'] = array('gt',0);
				$frs = $fck->where($where)->field('id,nickname,is_agent,user_id')->find();
				if ($frs){
					$chongzhi = M ('chongzhi');
					$data = array();
					$data['uid']     = $frs['id'];
					$data['user_id'] = $frs['user_id'];
					$data['rdt']     = strtotime(date('c'));
					$data['epoint']  = $ePoints;
					$data['is_pay']  = 0;
					$data['stype']  = $stype;
					$data['bz']  = $bz;
					$result = $chongzhi->add($data);
					$rearray[] = $result;
					unset($data,$chongzhi);
					$this->_adminCurrencyRechargeOpen($rearray);
				}else{
					$this->error(xstr('hint096'));
				}
				unset($fck,$frs,$where,$UserID,$ePoints);
			}else{
				$this->error(xstr('error_signed'));
			}
		}else{
			$this->error(xstr('error_signed'));
		}
	}
	
	
	public function OldCurrencyRechargeAdd(){
		//为会员充值
	//	if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$fck = M ('fck');
			if (!$fck->autoCheckToken($_POST)){
				$this->error(xstr('page_expire_please_reflush'));
				exit;
			}
			$UserID = $_POST['UserID'];
			//$UserID = strtolower($UserID);
			$ePoints = $_POST['ePoints'];
			$content = $_POST['content'];
			$stype = (int)$_POST['stype'];
			$bz = trim($_POST['bz']);
			if (is_numeric($ePoints) == false){
				$this->error(xstr('hint095'));
				exit;
			}
			if (!empty($UserID) && !empty($ePoints)){
				$where = array();
				$where['user_id'] = $UserID;
				$where['is_pay'] = array('gt',0);
				$frs = $fck->where($where)->field('*')->find();
				if ($frs){
					$fck = M ('fck');
					$fck_rs = $fck->where("user_id='".$UserID."'")->find();
					if ($stype==0){
					$data['oldjing']  = $ePoints + $fck_rs['oldjing'];
					$fck->where("user_id='".$UserID."'")->save($data);
					}
					if ($stype==1){
					$data['olddong']  = $ePoints + $fck_rs['olddong'];
					$fck->where("user_id='".$UserID."'")->save($data);
					}
					
				}else{
					$this->error(xstr('hint096'));
				}
				unset($fck,$frs,$where,$UserID,$ePoints);
			}else{
				$this->error(xstr('error_signed'));
			}
			echo "<script> alert('确认成功'); location.href = document.referrer; </script>";
		//}else{
			//$this->error(xstr('error_signed'));
		//}
	}
	
	private function _adminCurrencyRechargeOpen($PTid){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$chongzhi = M ('chongzhi');
			$fck = D('Fck');//
			$fee = M('fee');
			$fee_rs = $fee->field('s5,s12')->find();
			$systemRatio = floatval($fee_rs['s5']);
			$systemRatio /= 100;
			
			$now=strtotime(date('Y-m-d'));
			$where = array();
			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $chongzhi->where($where)->select();
			$fck_where = array();
			$nowdate = strtotime(date('c'));
			$history = M('history');
			$data = array();
			foreach($rs as $vo){
				$fck_where['id'] = $vo['uid'];
				// $fck_where['is_pay'] = array('gt',0);
				$stype = $vo['stype'];
				
					//开始事务处理

					$fck->startTrans();
					//明细表
					$data['uid']          = $vo['uid'];
					$data['user_id']      = $vo['user_id'];
					$data['action_type']  = 21;
					$data['pdt']          = $nowdate;
					$data['epoints']      = $vo['epoint'];
					$data['did']          = 0;
					$data['allp']         = 0;
					$data['bz']           = '21';
					//$history->create();
					$rs1 = $history->add($data);
					if ($rs1){
						
						//提交事务
						if($stype==0){
							//货币流向
                			$fck->addCashhistory($vo['uid'],$vo['epoint'],23,"后台充值",11);
							$fck->execute("UPDATE __TABLE__ set `agent_cash`=agent_cash+".$vo['epoint']. ",`cz_epoint`=cz_epoint+". $vo['epoint'] ." where `id`=". $vo['uid']);
						}elseif($stype==1){
							//货币流向
                			$fck->addCashhistory($vo['uid'],$vo['epoint'],23,"后台充值",22);
							$fck->execute("UPDATE __TABLE__ set `agent_use`=agent_use+". $vo['epoint']. ",`cz_epoint`=cz_epoint+". $vo['epoint'] ." where `id`=". $vo['uid']);
						}else{
							//$fck->execute("UPDATE __TABLE__ set `agent_kt`=agent_kt+". $cz_money. ",`cz_epoint`=cz_epoint+". $cz_money ." where `id`=". $vo['uid']);
						}
						$chongzhi->execute("UPDATE __TABLE__ set `is_pay`=1 ,`pdt`=$nowdate  where `id`=". $vo['id']);
						if($vo['epoint'] >= $fee_rs['s12'])
							M('Fck')->execute('UPDATE __TABLE__ SET b_apply_agent=1 WHERE id='.$vo['uid'].' AND b_apply_agent=0');
						$fck->commit();
					}else{
						//事务回滚：
						$fck->rollback();
					}
			}
			unset($chongzhi,$fck,$where,$rs,$fck_where,$nowdate,$history,$data);
			$bUrl = __URL__.'/adminCurrencyRecharge';
			$this->_box(1,xstr('hint097'),$bUrl,1);
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	private function _adminCurrencyRechargeDel($PTid){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanMangGuo'){
			$User = M ('chongzhi');
			$where = array();
			//			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $User->where($where)->delete();
			if ($rs){
				$bUrl = __URL__.'/adminCurrencyRecharge';
				$this->_box(1,xstr('delete_success'),$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminCurrencyRecharge';
				$this->_box(0,xstr('delete_failed'),$bUrl,1);
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	//在线充值
	public function onlineRecharge(){
		$this->error(xstr('feature_not_support'));exit;
		if ($_SESSION['Urlszpass'] == 'MyssonlineRecharge'){
			$remit = M('remit');
			$fck = M('fck');
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];
			$field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $remit->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $Page = new ZQPage($count,$listrows,1);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $remit->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$fwhere = array();
			$fwhere['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field = '*';
			$frs = $fck ->where($fwhere)->field($field)->find();
			$this->assign('frs',$frs);
			//$fee = M('fee');
			//$fee_rs = $fee ->field('str10')-> find();
			//$str4 = $fee_rs['str10'];//汇率
			// $str4 = 1;
			$this->assign('str4',1);
			$this->assign('bankCodeMap',C('BANK_CODE_MAP'));
			$this->assign('bankNameMap',C('BANK_NAME_MAP'));
			$this->assign('bankImgMap',C('BANK_IMG_MAP'));
			$feeArr = M('Fee')->field('str14')->find();
			$olPayURL = U('Public/olPay?muid='.$frs['user_id'],NULL,'',false,true);
			if(!empty($feeArr['str14']) && $feeArr['str14'] != 'close')
			{
				if(substr($feeArr['str14'],strlen($feeArr['str14'])-1,1) == '/')
					$feeArr['str14'] = substr($feeArr['str14'],0,strlen($feeArr['str14'])-1);
				$olPayURL = $feeArr['str14'].U('Public/olPay?muid='.$frs['user_id']);
			}
			$this->assign('olPayURL',$olPayURL);
			$plan = M('Plan')->field('content')->find(5);
			$this->assign('plan5',$plan['content']);
			$this->display ();
			return;
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
    
    //在线充值订单确认
	public function onlineRechargeAC(){
		$this->error(xstr('feature_not_support'));exit;
		if ($_SESSION['Urlszpass'] == 'MyssonlineRecharge'){
			$fck = M ('fck');
			$remit = M('remit');

			$fee = M('fee');
			$fee_rs = $fee -> find();
			//$str4 = $fee_rs['str10'];//汇率
 			$str4 = 1;
			//$s7=$fee_rs['s7'];   //最低值
			//$s8=$fee_rs['s8'];   //倍数
			$id =  $_SESSION[C('USER_AUTH_KEY')];
			$rs = $fck -> field('is_pay,user_id') -> find($id);
			if($rs['is_pay']==0){
				$this->error(xstr('hint098'));
				exit;
			}
			$inUserID=$rs['user_id'];

			$ePoints = trim($_POST['ePoints']);
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error(xstr('hint025'));
				exit;
			}
			if (strlen($ePoints)>9){
				$this->error (xstr('hint026'));
				exit;
			}
			if ($ePoints<=0){
				$this->error (xstr('hint082'));
				exit;
			}
			/*
			if ($ePoints<$s7){
				$this->error ("金额不能小于最低值".$s7."!");
				exit;
			}

			if ($ePoints%$s8){
				$this->error ("金额必须为".$s8."的倍数!");
				exit;
			}*/
			$ePoints = ((int)($ePoints*100))/100;
			// $inmoney = $ePoints*$str4;
			$inmoney = $ePoints;
			$inmoney = ((int)($inmoney*100))/100;

			$orok = 0;
			while($orok==0){
				$orderid = $this->makeOrder();

				$where = array();
				$where['orderid'] = array('eq',$orderid);
				$nn = $remit->where($where)->count();
				if($nn==0){
					$orok = 1;
				}
			}
			$payType = 0;
			if(array_key_exists('pay_type',$_POST))
			{
				$payType = intval($_POST['pay_type']);
			}
			else
			{
				$this->error(xstr('page_expire_please_reflush'));
				exit;
			}
			if($payType<1 || $payType >3)
			{
				$this->error(xstr('hint099'));
				exit;
			}
			/*
			$bank_code = '';
			if($payType == 3)
			{
				if(!array_key_exists('bank_code',$_POST))
				{
					$this->error(xstr('hint100'));
					exit;
				}
				$bank_code = trim($_POST['bank_code']);
				$bankCodeMap = C('BANK_CODE_MAP');
				if(!in_array($bank_code,$bankCodeMap))
				{
					$this->error(xstr('hint101'));
					exit;
				}
				else
				{
					$bankIndex = array_search($bank_code,$bankCodeMap);
					$bankNameMap = C('BANK_NAME_MAP');
					$this->assign('bankName',$bankNameMap[$bankIndex]);
				}
			}*/
			$this->assign('orderid',$orderid);
			$this->assign('ePoints',$ePoints);
			$this->assign('inmoney',$inmoney);
			$this->assign('bank_code',$bank_code);
			$this->assign('inUserID',$inUserID);
			$this->assign('payType',$payType);
			switch($payType)
			{
				case 1:
					$this->assign('payTypeName','宝付支付');
					break;
				case 2:
					$this->assign('payTypeName','汇潮支付');
					break;
				case 3:
					$this->assign('payTypeName','网银在线');
					break;
				default:
					$this->error(xstr('hint099'));
					exit;
			}
			$this->display();
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
	
	//提交在线充值
	public function onlineRechargeOK(){
		$this->error(xstr('feature_not_support'));exit;
		if ($_SESSION['Urlszpass'] == 'MyssonlineRecharge'){
			$fck = M ('fck');
			$remit = M('remit');
			$fee = M('fee');
			$fee_rs = $fee ->field('str10')-> find();
			//$str4 = $fee_rs['str10'];//汇率
 			$str4 = 1;

			$id =  $_SESSION[C('USER_AUTH_KEY')];
			$rs = $fck -> field('is_pay,user_id') -> find($id);
			if(!$rs){
				$this->error(xstr('hint102'));
				exit;
			}
			$inUserID = $rs['user_id'];

			$ePoints = trim($_POST['ePoints']);
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error(xstr('hint025'));
				exit;
			}
			if (strlen($ePoints)>9){
				$this->error (xstr('hint026'));
				exit;
			}
			if ($ePoints<=0){
				$this->error (xstr('hint082'));
				exit;
			}
			$ePoints = ((int)($ePoints*100))/100;
			// $inmoney = $ePoints*$str4;
			$inmoney = $ePoints;
			$amount = ((int)($inmoney*100))/100;
			
			$payType = intval(trim($_POST['pay_type']));
			$bankCode = '';
			if($payType<1 || $payType>3)
			{
				$this->_box(0,xstr('hint103'),U('onlineRecharge'),1);
				exit;
			}
			/*
			if($payType == 3)
			{
				$bankCode = trim($_POST['bank_code']);
				if(empty($bankCode))
				{
					$this->_box(0,xstr('hint104'),U('onlineRecharge'),1);
					exit;
				}
			}*/
			
			$orderid = trim($_POST['orderid']);

			$orok = 0;
			while($orok==0){
				if(empty($orderid)){
					$orderid = $this->makeOrder();
				}
				$where = array();
				$where['orderid'] = array('eq',$orderid);
				$nn = $remit->where($where)->count();
				if($nn==0){
					$orok = 1;
				}else{
					$orderid = $this->makeOrder();
				}
			}
			
			$data = array();
			$data['uid']     = $id;
			$data['user_id'] = $inUserID;
			$data['amount'] = $ePoints;
			$data['kh_money'] = $amount;
			$data['or_time'] = mktime();
			$data['orderid'] = $orderid;
			$result = $remit->add($data);
			unset($data);
			
			if ($result){
				
				$pAction = NULL;
				switch($payType)
				{
				case 1:
					$pAction = A('BaofooPay');
					break;
				case 2:
					$pAction = A('EcpssPay');
					break;
				case 3:
					$pAction = A('ChinabankPay');
					break;
				}
				$pAction->send($orderid,$amount);
				exit;
			}else{
				$this->error(xstr('hint105'));
				exit;
			}
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
	
	
	
	//后台管理在线充值
	public function adminonlineRecharge(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssadminonlineRecharge'){
			$remit = M('remit');
			$UserID = $_REQUEST['UserID'];
			$ss_type = (int) $_REQUEST['type'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$map['user_id'] = array('like',"%".$UserID."%");
				$UserID = urlencode($UserID);
			}
			if($ss_type==1){
				$map['is_pay'] = array('egt',0);
			}elseif($ss_type==2){
				$map['is_pay'] = array('egt',1);
			}
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $remit->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $remit->where($map)->field($field)->order('or_time desc,id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================


			$this->display ();
			return;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	//后台处理在线充值
	public function adminonlineRechargeAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminonlineRecharge';
			$this->_box(0,xstr('hint106'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('delete');
				$this->adminonlineRechargeDel($PTid);
				break;
		default;
			$bUrl = __URL__.'/adminonlineRecharge';
			$this->_box(0,xstr('hint107'),$bUrl,1);
			break;
		}
	}

	//后台处理在线充值-删除
	private function adminonlineRechargeDel($PTid=0){
		$this->_Admin_checkUser();
		if($_SESSION['UrlPTPass'] == 'MyssadminonlineRecharge'){
			$remit = M ('remit');
			$where['id'] = array ('in',$PTid);
			$where['is_pay'] = array ('eq',0);
			$trs = $remit->where($where)->delete();
			if ($trs){
				$bUrl = __URL__.'/adminonlineRecharge';
				$this->_box(1,xstr('delete_success'),$bUrl,1);
				exit;
			}else{
				$this->error(xstr('delete_failed'));
			}
		}else{
			$this->error(xstr('error_signed'));
		}
	}
	
	//生成订单号
	private function makeOrder(){
    	$Order_pre='100';
    	$Order = date("Y").date("m").date("d").date("H").date("i").date("s").rand(100,999);
    	return  $Order_pre.$Order;
    }
	

}
?>