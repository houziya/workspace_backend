<?php
//注册模块
class TransferAction extends CommonAction{
	
	public function _initialize() {
		parent::_initialize();
		header("Content-Type:text/html; charset=utf-8");
		$this->_inject_check(0);//调用过滤函数
		$this->_Config_name();//调用参数
 		$this->_checkUser();
		//$this->_inject_check(1);//调用过滤函数
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
				$_SESSION['Urlszpass'] = 'MyssFenYingTao';
				$bUrl = __URL__.'/transferMoney';//货币转账
                $this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlPTPass'] = 'MyssTransfer';
				$bUrl = __URL__.'/adminTransferMoney';//货币转账
				$this->_boxx($bUrl);
				break;
			default;
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	
	//=============================================报单币转帐(会员之间的报单币转帐)
	public function transferMoney($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'MyssFenYingTao'){
			$zhuanj = M('zhuanj');
			$map['in_uid'] = $_SESSION[C('USER_AUTH_KEY')];
			$map['out_uid'] = $_SESSION[C('USER_AUTH_KEY')];
			$map['_logic'] = 'or';
	
	
	
			//			$id = $_SESSION[C('USER_AUTH_KEY')];
			//			$sql = "in_uid =".$id ." or out_uid = ".$id;
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $zhuanj->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$Page = new ZQPage($count,$listrows,1);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $zhuanj->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);//数据输出到模板
			//=================================================
	
			$fck = M ('fck');
			$where = array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field = '*';
			$rs = $fck->where($where)->field($field)->find();
			$this->assign('rs',$rs);
			
			$v_title = $this->theme_title_value();
			$this->distheme('transferMoney',$v_title[91]);
			return;
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
	
	
	public function transferMoneyAC(){
		$UserID = trim($_POST['UserID']);    //转入会员帐号(进帐的用户帐号)
		//	$ePoints = (int) $_POST['ePoints'];
		$ePoints = $_POST['ePoints'];  //转入金额
		$content = $_POST['content'];  //转帐说明
		$select = $_POST['select'];  //转帐类型
	
		$fck = M ('fck');
		$where = array();
		$where['id']= $_SESSION[C('USER_AUTH_KEY')];
	
		$f = $fck->where($where )->field('user_id')->find();
	
		if ($select==1||$select==6||$select==5)
		{
			if($select == 6 || $select == 5)
				$UserID = $_SESSION['loginUseracc'];
		}
		else
		{
			$this->error(xstr('hint061'));
			exit;
		}
	
		$fck = M ('fck');
		if (!$fck->autoCheckToken($_POST)){
			$this->error(xstr('page_expire_please_reflush'));
			exit;
		}
		if (empty($ePoints) || !is_numeric($ePoints) || empty($UserID)){
			$this->error(xstr('hint062'));
			exit;
		}
		if($ePoints <= 0){
			$this->error(xstr('hint063'));
			exit;
		}

		if($select==1 || $select==2 ){
			
			if($UserID == $f['user_id']){
				$this->error(xstr('hint064'));
				exit;
			}
		}
		$this->_transferMoneyConfirm($UserID,$ePoints,$content,$select);
	}
	
	private function _transferMoneyConfirm($UserID='0',$ePoints=0,$content=null,$select=0){
		if ($_SESSION['Urlszpass'] == 'MyssFenYingTao'){  //转帐权限session认证
			$fck = M ('fck');
			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];     //登录会员AutoId
			$inUserID =  $_SESSION['loginUseracc'];  //登录的会员帐号 user_id
			//转出
			$history = M ('history');  //明细表
			$zhuanj  = M ('zhuanj');   //转帐表
	
			$myww = array();
			$myww['id'] = array('eq',$ID);
			$mmrs = $fck->where($myww)->find();
			$mmid = $mmrs['id'];
			$mmisagent = $mmrs['is_agent'];
			if($mmid==1){
				$mmisagent = 0;
			}
			// if($mmrs['is_lockfh']==1){
			// 	$this->error(xstr('hint065'));
			// 	exit;
			// }
	
			//转入会员
			$fck_where = array();
			$fck_where['user_id'] =$UserID;// strtolower($UserID);
			$field = "id,user_id,is_agent,re_path";
			$vo = $fck ->where($fck_where)->field($field)->find();  //找出转入会员记录
			if (!$vo){
				$this->error(xstr('hint066'));
				exit;
			}
			$b_agent = $vo['is_agent'];
			if($select == 1)
			{
				$loginUser = M('Fck')->field('id,user_id,re_path')->find($ID);
				if(!$loginUser)
				{
					$this->error(xstr('hint067'));
					exit;
				}
				$outPathArr = explode(',',$loginUser['re_path']);
				array_shift($outPathArr);
				array_pop($outPathArr);
				$inPathArr = explode(',',$vo['re_path']);
				array_shift($inPathArr);
				array_pop($inPathArr);
				
				if(!(in_array($vo['id'],$outPathArr) || in_array($ID,$inPathArr)))
				{
					$this->error($vo['user_id'].xstr('hint068'));
					exit;
				}
			}
			
			// if($b_agent < 2 && $select==1){
			// 	$this->error('报单币只能转账给报单中心!');
			// 	exit;
			// }
//			if($a_agent == 2 && $select==1){
//				$this->error('报单中心之间不能互转!');
//				exit;
//			}

/*			$fee_rs = M ('fee') -> find();
			$str16 = $fee_rs['str16'];//倍数
			$str17 = $fee_rs['str17'];//最低额
	
			if($select==1){
				if($ePoints<$str16){
					$this->error ('转账最低额度必须为 '.$str16.' ！');
					exit;
				}
			}*/
			if ($ePoints % 100){
				$this->error (xstr('hint069'));
				exit;
			}
	
			$AgentUse = 0;
			if($select==1){
				$AgentUse = $mmrs['agent_use'];
				if ($AgentUse < $ePoints){            //判断报单币余额
					$this->error(xstr('coin001_not_sufficient_funds_2'));
					exit;
				}
			}
			/*
			else if($select==3){
				$AgentUse = $mmrs['agent_cash'];
				if ($AgentUse < $ePoints){            //判断报单币余额
					$this->error(xstr('coin002_not_sufficient_funds_2'));
					exit;
				}
			}
			else if($select==4){
				$AgentUse = $mmrs['agent_use'];
				if ($AgentUse < $ePoints){            //判断奖金余额
					$this->error(xstr('coin001_not_sufficient_funds_2'));
					exit;
				}
			}*/
			else if($select==5){
				$AgentUse = $mmrs['agent_kt'];
				
				if ($AgentUse < $ePoints){            //判断奖金余额
					$this->error(xstr('coin003_not_sufficient_funds_2'));
					exit;
				}
			}
			else if($select == 6)
			{
				$AgentUse = $mmrs['agent_cash'];
				if ($AgentUse < $ePoints){            //判断报单币余额
					$this->error(xstr('coin002_not_sufficient_funds_2'));
					exit;
				}
			}
			else
			{
				$this->error(xstr('hint061'));
				exit;
			}
			
			//if($select==3){
//				$AgentUseTwo = $mmrs['agent_xf'];
//				if ($AgentUseTwo < $ePoints){            //判断奖金余额
//					$this->error(xstr('coin002_not_sufficient_funds_2'));
//					exit;
//				}
//			}
//			
			$history->startTrans();//开始事物处理
			$zz_content = "转帐";
			if($select==1){
				$zz_content = "报单币 转给 其他会员";
				$fck->execute("update `zyrj_fck` Set `agent_use`=agent_use-".$ePoints." where `id`=".$ID);
				$fck->execute("update `zyrj_fck` Set `agent_use`=agent_use+".$ePoints." where `id`=".$vo['id']);
			}
			else if($select==2){
				$zz_content = "电子币 转 报单币";
				$fck->execute("update `zyrj_fck` Set `agent_use`=agent_use-".$ePoints." where `id`=".$ID);
				$fck->execute("update `zyrj_fck` Set `agent_cash`=agent_cash+".$ePoints." where `id`=".$vo['id']);
			}
			else if($select==3){
				$zz_content = "电子币 转入 理财钱包";
				$fck->execute("update `zyrj_fck` Set `agent_cash`=agent_cash-".$ePoints." where `id`=".$ID);
				$fck->execute("update `zyrj_fck` Set `agent_kt`=agent_kt+".$ePoints." where `id`=".$vo['id']);
			}
			else if($select==4){
				$zz_content = "报单币 转入 理财钱包";
				$fck->execute("update `zyrj_fck` Set `agent_use`=agent_use-".$ePoints." where `id`=".$ID);
				$fck->execute("update `zyrj_fck` Set `agent_kt`=agent_kt+".$ePoints." where `id`=".$vo['id']);
			}
			else if($select==5){
				$zz_content = "云顿币 转出 报单币";
				$fck->execute("update `zyrj_fck` Set `agent_kt`=agent_kt-".$ePoints." where `id`=".$ID);
				$fck->execute("update `zyrj_fck` Set `agent_use`=agent_use+".($ePoints/2)." where `id`=".$vo['id']);
			}
			else if($select==6){
				$zz_content = "电子币 转 报单币";
				$fck->execute("update `zyrj_fck` Set `agent_cash`=agent_cash-".$ePoints." where `id`=".$ID);
				$fck->execute("update `zyrj_fck` Set `agent_use`=agent_use+".$ePoints." where `id`=".$vo['id']);
			}
			else
			{
				$this->error(xstr('hint070'));
				exit;
			}
//			if($select==4){
//				$zz_content = "报单币 转 报单币";
//				$fck->execute("update `zyrj_fck` Set `agent_kt`=agent_kt-".$ePoints." where `id`=".$ID);
//				$fck->execute("update `zyrj_fck` Set `agent_cash`=agent_cash+".$ePoints." where `id`=".$vo['id']);
//			}
//			if($select==5){
//				$zz_content = "报单币 转 钻石币";
//				$fck->execute("update `zyrj_fck` Set `agent_kt`=agent_kt-".$ePoints." where `id`=".$ID);
//				$fck->execute("update `zyrj_fck` Set `agent_gp`=agent_gp+".$ePoints." where `id`=".$vo['id']);
//			}
	
			$nowdate = time();
			$data = array();
			$data['uid']           = $ID;          //转出会员ID
			$data['user_id']       = $UserID;
			$data['did']           = $vo['id'];    //转入会员ID
			$data['user_did']      = $vo['user_id'];
			$data['action_type']   = 20;    //转入还是转出
			$data['pdt']           = $nowdate;     //转帐时间
			$data['epoints']       = $ePoints;     //进出金额
			$data['allp']          = 0;
			$data['bz']            = $zz_content;     //备注
			$data['type']          = 1;   		   //1转帐
			$history->create();
			$rs2=$history->add($data);
			unset($data);
			//转账表
			$data = array();
			$data['in_uid']        = $vo['id'];           //转入会员ID
			$data['out_uid']       = $ID;
			$data['in_userid']     = $vo['user_id'];      //转入会员的登录帐号
			$data['out_userid']    = $inUserID;
			$data['epoint']        = $ePoints;            //进出金额
			$data['rdt']           = $nowdate;            //转帐时间
			$data['sm']            = $content;            //转帐说明
			//$data['type']          = 0;                 // 3为货币转为货币
			$data['type']   = $select;
			$zhuanj->create();
			$rs4=$zhuanj->add($data);
			unset($data);
	
			//无错误提交数据
			if ($rs2 && $rs4){
				$history->commit();//提交事务
				$bUrl = __URL__.'/transferMoney';
				$this->_box(1,xstr('operation_success'),$bUrl,1);
				exit;
			}else{
				$history->rollback();//事务回滚：
				$this->error(xstr('parameter_error_3'));
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	public function adminTransferMoney(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssTransfer'){
			$zhuanj = M('zhuanj');
				
			$UserID = $_REQUEST['UserID'];
			
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
				$KuoZhan = new KuoZhan();
				if ($KuoZhan->is_utf8($UserID) == false){
					$UserID = iconv('GB2312','UTF-8',$UserID);
				}
				unset($KuoZhan);
				//     		$map['in_userid'] = array('like',"%".$UserID."%");
				$map = "(in_userid like '%".$UserID."%') or (out_userid  like '%".$UserID."%') ";
				$UserID = urlencode($UserID);
			}
				
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $zhuanj->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID=' . $UserID;//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $zhuanj->where($map)->field('*')->order('rdt desc,id desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);
				
			$this->display('adminTransferMoney');
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
		 
	}
	
	
}
?>