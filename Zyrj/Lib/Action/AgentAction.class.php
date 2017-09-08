<?php
//注册模块
class AgentAction extends CommonAction{
	
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
				if($list['is_agent'] >=2){
					$this->error(xstr('you_are_already_agent'));
            		exit();
				}
				$_SESSION['Urlszpass'] = 'MyssXiGua';
				$bUrl = __URL__.'/agents';//申请代理
                $this->_boxx($bUrl);
			break;
				case 2;
				$_SESSION['Urlszpass'] = 'MyssShuiPuTao';
				$bUrl = __URL__.'/menber'; //未开通账户
				$this->_boxx($bUrl);
			break;
		
			case 3;
				$_SESSION['Urlszpass'] = 'Myssmenberok';
				$bUrl = __URL__.'/menberok'; //已开通账户
				$this->_boxx($bUrl);
			break;
			
			case 4;
				$_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
				$bUrl = __URL__.'/adminAgents'; //后台确认受理中心
				$this->_boxx($bUrl);
			break;
			default;
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	public function agents($Urlsz=0){
		//======================================申请账户中心/代理中心/受理中心
		if ($_SESSION['Urlszpass'] == 'MyssXiGua'){
			$fee_rs = M ('fee') -> find();
	
			$fck = M ('fck');
			$where = array();
			//查询条件
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$field ='*';
			$fck_rs = $fck ->where($where)->field($field)->find();
	
			if ($fck_rs){
				//账户级别
				switch($fck_rs['is_agent']){
					case 0:
						$agent_status = xstr('agent001');
						break;
					case 1:
						$agent_status = xstr('agent002');
						break;
					case 2:
						$agent_status = xstr('agent003');
						break;
				}
	
				$this->assign ( 'fee_s6',$fee_rs['i1']);
				$this->assign ( 'agent_level',0);
				$this->assign ( 'agent_status',$agent_status);
				$this->assign ( 'fck_rs', $fck_rs);
				
				$Agent_Us_Name = C('Agent_Us_Name');
				$Aname = explode("|",$Agent_Us_Name);
				$this->assign ( 'Aname', $Aname);
				
				$v_title = $this->theme_title_value();
				$this->distheme('agents',$v_title[41]);
			}else{
				$this->error (xstr('operation_failed'));
				exit;
			}
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}
	
	
	public function agentsAC(){
		//================================申请账户中心中转函数
		$content  = $_POST['content'];
		$agentMax = $_POST['agentMax'];
		$shoplx  = (int)$_POST['shoplx'];
		$shop_a  = $_POST['shop_a'];
		$shop_b  = $_POST['shop_b'];
		$fee=M('fee');
		$fee_rs=$fee->where('s9,s14,s12')->find(1);
		$s14=(int)$fee_rs['s14'];
    	$s9 = explode("|",$fee_rs['s9']);		//账户级别费用
//		$one_mm = $s9[0];
		$one_mm = 1;
		
		$fck = M ('fck');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$where = array();
		$where['id'] = $id;
	
		$fck_rs = $fck->where($where)->field('*')->find();
	
		if($fck_rs){
			if($fck_rs['is_pay']  == 0){
				$this->error (xstr('temp_use_can_not_apply'));
				exit;
			}
			if($fck_rs['is_agent']  == 1){
				$this->error(xstr('apply_is_checking'));
				exit;
			}
			//6000套餐，6个直推，30人团队
			$buy=M('cash')->where("uid=".$id." and type=0")->field("sum(money) as a")->find();
			$re_count=$fck->where("is_pay>0 and re_path like '%,".$id.",%'")->count();
			// dump($buy);dump($re_count);dump($fck_rs['re_nums']);exit;
			if($buy['a']>=6000&&$re_count>=30&&$fck_rs['re_nums']>=6){
				$this->error("业绩条件符合才可以申请资格！");
				exit;
			}
//			if(empty($shop_a)){
//				$this->error('请输入受理中心区域!');
//			}
			if(empty($content)){
 				$this->error (xstr('please_input_remark'));
 				exit;
			}
			/*
			if($fck_rs['u_level']<4){
				$this->error('未达到申请条件：级别达小店以上!');
				exit;
			}*/
//			$yj_m = 50000;
//			$dans = $yj_m/$one_mm;
//			$all_lr = $fck_rs['l']+$fck_rs['r'];
//			if($all_lr<$dans){
// 				$this->error ('未达到申请受理中心条件!受理中心条件：总业绩5万。');
// 				exit;
//			}
	
			if($fck_rs['is_agent'] == 0){
				$nowdate = time();
				$result = $fck -> query("update __TABLE__ set verify='".$content."',is_agent=1,shoplx=".$shoplx.",shop_a='".$shop_a."',shop_b='".$shop_b."',idt=$nowdate where id=".$id);
			}
	
			$bUrl = __URL__ .'/agents';
			$this->_box(1,xstr('apply_success'),$bUrl,2);
	
		}else{
			$this->error(xstr('illegal_operation'));
			exit;
		}
	}
	
	//未开通账户
	public function menber($Urlsz=0){
		//列表过滤器，生成查询Map对象
		if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao'){
			$fck = M('fck');
			$map = array();
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$gid = (int) $_GET['bj_id'];
// 			$map['shop_id'] = $id;
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
			$map['is_pay'] = array('eq',0);
			$map['_string'] = "shop_id=".$id." or re_id=".$id."";

            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
			$HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//账户级别
			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('*')->find();
			$this->assign('frs',$fck_rs);//报单币
			
			$feeArr = M('Fee')->field('s9')->find();
			$this->assign('regMoneyArr',explode('|',$feeArr['s9']));
			
			$v_title = $this->theme_title_value();
			$this->distheme('menber',$v_title[42]);
			exit;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	//未开通账户
	public function menberok($Urlsz=0){
		//列表过滤器，生成查询Map对象
		if ($_SESSION['Urlszpass'] == 'Myssmenberok'){
			$fck = M('fck');
			$map = array();
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$gid = (int) $_GET['bj_id'];
			$map['shop_id'] = $id;
			$map['is_pay'] = array('gt',0);
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}

            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID='.$UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
			$HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//账户级别
			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck->where($where)->field('*')->find();
			$this->assign('frs',$fck_rs);//报单币
			
			$feeArr = M('Fee')->field('s9')->find();
			$this->assign('regMoneyArr',explode('|',$feeArr['s9']));
			
			$v_title = $this->theme_title_value();
			$this->distheme('menberok',$v_title[43]);
			exit;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	public function Renew(){
		$this->_checkUser();
		$fck = M('fck');
		$fee = M('fee');
		$fee_rs = $fee->field('str10')->find();
		$_SESSION['Urlszpass'] = 'MyssShuiPuTao';
		$str10 = $fee_rs['str10'];
		$ID = $_SESSION[C('USER_AUTH_KEY')];
		$fck_rs = $fck->where('id='.$ID)->field('id,agent_use,is_pay,cpzj')->find();
		if($fck_rs['is_pay']>0){
			$this->error(xstr('account_is_opened'));
			exit;
		}
		if($fck_rs['agent_use']<$fck_rs['cpzj']){
			$this->error(xstr('account_not_sufficient_funds'));
			exit;
		}
		// $rs = $fck->execute('UPDATE __TABLE__ SET `agent_use`=agent_use-'.$str10.',is_pay=1 where id='.$ID);
		$rs = 1;
		$OpID = array($fck_rs['id']);
		// if($rs){
			$this->_menberOpenUse($OpID,0);
		// }else{
		// 	$this->error(xstr('error_signed'));
		// 	exit;
		// }
	}

	public function menberAC(){
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$OpID = $_POST['tabledb'];
		if (!isset($OpID) || empty($OpID)){
			$bUrl = __URL__.'/menber';
			$this->_box(0,xstr('account_not_exists'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('open_account'):
				$this->_menberOpenUse($OpID,0);
				break;
			case xstr('open_account_with_type2'):
				$this->_menberOpenUse($OpID,2);
				break;
			case xstr('open_account_with_type3'):
				$this->_menberOpenUse($OpID,3);
				break;
			case xstr('open_account_with_type1'):
				$this->_menberOpenUse($OpID,1);
				break;
			case xstr('delete_account'):
				$this->_menberDelUse($OpID);
				break;
			default:
				$bUrl = __URL__.'/menber';
				$this->_box(0,xstr('account_not_exists'),$bUrl,1);
				break;
		}
	}
	
	
	private function _menberOpenUse($OpID=0,$reg_money=0){
		//=============================================开通账户
		if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao'){
			$fck = D ('Fck');
			$fee = M ('fee');
			//$gouwu = M ('gouwu');
			$shouru = M ('shouru');
		    if (!$fck->autoCheckToken($_POST)){
                $this->error(xstr('page_expire_please_reflush'));
                exit;
            }

			//被开通账户参数
			$where = array();
			$where['id'] = array ('in',$OpID);  //被开通账户id数组
			$where['is_pay'] = 0;  //未开通的
			$field = '*';
			$vo = $fck ->where($where)->field($field)->select();
			$fee_rs = $fee->field('s4,s9,s2,s11')->find();
	    	$s4 = explode("|",$fee_rs['s4']);
			$regMoneyArr = explode('|',$fee_rs['s9']);
			$pvArr = explode('|',$fee_rs['s11']);
			//受理中心参数
			$where_two =array();
			$field_two = '*';
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$where_two['id'] = $ID;
			$where_two['is_agent'] = array('gt',1);
			$nowdate = strtotime(date('c'));
			$nowday=strtotime(date('Y-m-d'));
			$fck->emptyTime();
			foreach($vo as $voo){
				$rs = $fck->where($where_two)->field($field_two)->find();  //找出登录账户(必须为受理中心并且已经登录)
				if (!$rs){
					$this->error(xstr('account_error'));
					exit;
				}
				$ppath=$voo['p_path'];
				//上级未开通不能开通下级员工
				$frs_where['is_pay'] = array('eq',0);
				$frs_where['id'] = $voo['father_id'];
				$frs = $fck -> where($frs_where) -> find();
				if($frs){
					$this->error(xstr('hint007'));
					exit;
				}
				if($reg_money != 0)
				{
					$this->error(xstr('hint008'));
					exit;
				}
				if($reg_money==1){
					$us_money = $rs['agent_kt'];
					$money_a = $voo['cpzj'];
				}elseif($reg_money==2){
					$us_money = $rs['agent_xf'];
					$money_a = $voo['cpzj'];
				}elseif($reg_money==3){
					$us_money = $rs['agent_xf'];
					$us_money_b = $rs['agent_cash'];
					$money_a = $voo['cpzj']/2;
					$money_b = $voo['cpzj']-$money_a;
					if ($us_money_b < $money_b){
						$bUrl = __URL__.'/menber';
						$this->_box(0,xstr('account_not_sufficient_funds'),$bUrl,1);
						exit;
					}
				}else{
					$us_money = $rs['agent_use'];
					$money_a = $regMoneyArr[$voo['u_level']-1];
				}
				if ($us_money < $money_a){
					// $bUrl = __URL__.'/menber';
					// $this->_box(0,xstr('account_not_sufficient_funds'),$bUrl,1);
					$this->error(xstr('account_not_sufficient_funds'));
					exit;
				}
				if($reg_money==1){
					$result = $fck->execute("update __TABLE__ set `agent_kt`=agent_kt-".$money_a." where `id`=".$ID);
				}elseif($reg_money==2){
					$result = $fck->execute("update __TABLE__ set `agent_xf`=agent_xf-".$money_a." where `id`=".$ID);
				}elseif($reg_money==3){
					$result = $fck->execute("update __TABLE__ set `agent_xf`=agent_xf-".$money_a.",`agent_cash`=agent_cash-".$money_b." where `id`=".$ID);
				}else{
					$result = $fck->execute("update __TABLE__ set `agent_use`=agent_use-".$money_a." where `id`=".$ID);
				}
				if($result){
					if($reg_money==1){
						$kt_cont = '种子币开通账户';
					}elseif($reg_money==2){
						$kt_cont = '激活币开通账户';
					}elseif($reg_money==3){
						$kt_cont = '激活币+报单币开通账户';
					}else{
						$kt_cont = '报单币开通账户';
					}
					$fck->addencAdd($rs['id'], $voo['user_id'], -$money_a, 19,0,0,0,$kt_cont);//历史记录
					
					//给推荐人添加推广人数或单数
					$fck->execute("update __TABLE__ set `re_nums`=re_nums+1,re_cpzj=re_cpzj+".$voo['cpzj'].",re_money=re_money+".$money_a." where `id`=".$voo['re_id']);
					
					// $varray = $this->gongpaixtsmall($voo['re_id']);

					// $data['father_id']=$varray['father_id'];
					// $data['father_name']=$varray['father_name'];
					// $data['treeplace']=$varray['treeplace'];
					// $data['p_level']=$varray['p_level'];
					// $data['p_path']=$varray['p_path'];
					// $data['u_pai']=$varray['u_pai'];
					
					$gwArr = explode('|',$fee_rs['s2']);
					
					$data = array();
					$data['is_pay'] = 1;
					$data['pdt'] = $nowdate;
					$data['open'] = 0;
					$data['get_date'] = $nowday;
					$data['fanli_time'] = $nowday;//当天没有分红奖
					$data['agent_gp'] = floatval($gwArr[$voo['u_level']-1]);//注册送股点
// 					if($reg_money==2){
// 						$data['is_xf'] = 1;//
// 					}

					//开通账户
					$result = $fck->where('id='.$voo['id'])->save($data);
					unset($data,$varray);
					
					$data = array();
					$data['uid'] = $voo['id'];
					$data['user_id'] = $voo['user_id'];
					$data['in_money'] = $voo['cpzj'];
					$data['in_time'] = time();
					$data['in_bz'] = "新账户加入";
					$shouru->add($data);
					unset($data);
					
// 					//设置货物
// 					$gouwu->query("update __TABLE__ set lx=1 where uid=".$voo['id']);
					
					//统计单数
					$dan = intval($voo['cpzj']/$pvArr[0]);
					$fck->xiangJiao($voo['id'], $dan);
					
					//算出奖金
					$fck->getusjj($voo['id']);
				}
			}
			unset($fck,$where,$where_two,$rs);
			if ($vo){
				unset($vo);
				// $bUrl = __URL__.'/menber';
				// $this->_box(1,xstr('active_account_success'),$bUrl,2);
				$this->success(xstr('active_account_success'));
				exit;
			}else{
				unset($vo);
				// $bUrl = __URL__.'/menber';
				// $this->_box(0,xstr('active_account_failed'),$bUrl,1);
				$this->error(xstr('active_account_failed'));
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	private function _menberDelUse($OpID=0){
		//=========================================删除账户
		if ($_SESSION['Urlszpass'] == 'MyssShuiPuTao'){
			$fck = M ('fck');
			$where['is_pay'] = 0;
			foreach($OpID as $voo){
				$rs = $fck -> find($voo);
				if($rs){
					$whe['father_name'] = $rs['user_id'];
					$rss = $fck -> where($whe)->field('id') -> find();
					if($rss){
						$bUrl = __URL__.'/menber';
						$this -> error($rs['user_id'] .xstr('hint009'));
						exit;
					}else{
						$where['id'] = $voo;
						$fck -> where($where) -> delete();
					}
				}else{
					$this->error(xstr('error_signed'));
				}
			}
			$bUrl = __URL__.'/menber';
			$this->_box(1,xstr('delete_account'),$bUrl,1);
			exit;
		}else{
			$this->error(xstr('error_signed'));
		}
	}
	
	//已开通账户
	public function frontMenber($Urlsz=0){
		//列表过滤器，生成查询Map对象
		if ($_SESSION['Urlszpass'] == 'MyssDaShuiPuTao'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$map = array();
			$map['open'] = $id;
			$map['is_pay'] = array('gt',0);
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
				$KuoZhan = new KuoZhan();
				if ($KuoZhan->is_utf8($UserID) == false){
					$UserID = iconv('GB2312','UTF-8',$UserID);
				}
				unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
	
			//查询字段
			$field  = "*";
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'UserID='.$UserID;//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $fck->where($map)->field($field)->order('pdt desc')->page($Page->getPage().','.$listrows)->select();
	
			$HYJJ = '';
			$this->_levelConfirm($HYJJ,1);
			$this->assign('voo',$HYJJ);//账户级别
			$this->assign('list',$list);//数据输出到模板
			//=================================================
	
			$this->display ('frontMenber');
			exit;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	
	public function adminAgents(){
		//=====================================后台受理中心管理
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M('fck');
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
			//$map['is_del'] = array('eq',0);
			$map['is_agent'] = array('gt',0);
			if (method_exists ( $this, '_filter' )) {
				$this->_filter ( $map );
			}
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            $Agent_Us_Name = C('Agent_Us_Name');
			$Aname = explode("|",$Agent_Us_Name);
			$this->assign ( 'Aname', $Aname);
			
			$v_title = $this->theme_title_value();
			$this->distheme('adminAgents',$v_title[141]);

			return;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	public function adminAgentsShow(){
		//查看详细信息
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M('fck');
			$ID = (int) $_GET['Sid'];
			$where = array();
			$where['id'] = $ID;
			$srs = $fck->where($where)->field('user_id,verify')->find();
			$this->assign('srs',$srs);
			unset($fck,$where,$srs);
			$this->display ('adminAgentsShow');
			return;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	public function adminAgentsAC(){  //审核受理中心(受理中心)申请
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$XGid = $_POST['tabledb'];
		$fck = M ('fck');
//	    if (!$fck->autoCheckToken($_POST)){
//            $this->error(xstr('page_expire_please_reflush'));
//            exit;
//        }
        unset($fck);
		if (!isset($XGid) || empty($XGid)){
			$bUrl = __URL__.'/adminAgents';
			$this->_box(0,xstr('please_select_account'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('confirm_2');
				$this->_adminAgentsConfirm($XGid);
				break;
			case xstr('delete');
				$this->_adminAgentsDel($XGid);
				break;
		default;
			$bUrl = __URL__.'/adminAgents';
			$this->_box(0,xstr('account_not_exists'),$bUrl,1);
			break;
		}
	}
	
	
	private function _adminAgentsConfirm($XGid=0){
		//==========================================确认申请受理中心
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck  = D ('Fck');
			$where['id'] = array ('in',$XGid);
			$where['is_agent'] = 1;
			$rs = $fck->where($where)->field('*')->select();

			$data = array();
			$history = M ('history');
            $rewhere = array();
//          $nowdate = strtotime(date('c'));
            $nowdate = time();
            $jiesuan = 0;
			foreach($rs as $rss){

				$myreid = $rss['re_id'];
				$shoplx = $rss['shoplx'];

				$data['user_id'] = $rss['user_id'];
				$data['uid'] = $rss['uid'];
				$data['action_type'] = '申请成为受理中心';
				$data['pdt'] = $nowdate;
				$data['epoints'] = $rss['agent_no'];
				$data['bz'] = '申请成为受理中心';
				$data['did'] = 0;
				$data['allp'] = 0;
				$history ->add($data);

				$fck ->query("UPDATE __TABLE__ SET is_agent=2,adt=$nowdate,agent_max=0 where id=".$rss['id']);  //开通
				//检测是否互助大使
				$fck->check_is_aa($rss['re_path']);
			}
			unset($fck,$where,$rs,$history,$data,$rewhere);
			$bUrl = __URL__.'/adminAgents';
			$this->_box(1,xstr('confirm_apply'),$bUrl,1);
			exit;
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	public function adminAgentsCoirmAC(){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			//$this->_checkUser();
			$fck = M ('fck');
			$content  = $_POST['content'];
			$userid =trim($_POST['userid']);
			$where['user_id']=$userid;
			//$rs=$fck->where($where)->find();
			$fck_rs = $fck->where($where)->field('id,is_agent,is_pay,user_id,user_name,agent_max,is_agent')->find();
				
	
			if($fck_rs){
				if($fck_rs['is_pay']  == 0){
					$this->error (xstr('agent006'));
					exit;
				}
				if($fck_rs['is_agent']  == 1){
					$this->error(xstr('apply_is_checking'));
					exit;
				}
				if($fck_rs['is_agent']  == 2){
					$this->error(xstr('agent007'));
					exit;
				}
				if(empty($content)){
					$this->error (xstr('please_input_remark'));
					exit;
				}
					
				if($fck_rs['is_agent'] == 0){
					$nowdate = time();
					$result = $fck -> query("update __TABLE__ set verify='".$content."',is_agent=2,idt=$nowdate,adt={$nowdate} where id=".$fck_rs['id']);
				}
	
				$bUrl = __URL__ .'/adminAgents';
				$this->_box(1,xstr('hint010'),$bUrl,2);
			}else{
				$this->error(xstr('account_not_exists'));
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	
	}
	private function _adminAgentsDel($XGid=0){
		//=======================================删除申请受理中心信息
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M ('fck');
			$rewhere = array();
			$where['is_agent'] = array('gt',0);
			$where['id'] = array ('in',$XGid);
			$rs = $fck -> where($where) -> select();
			foreach ($rs as $rss){
				$fck ->query("UPDATE __TABLE__ SET is_agent=0,idt=0,adt=0,new_agent=0,shoplx=0,shop_a='',shop_b='' where id>1 and id = ".$rss['id']);
			}
	
			//			$shop->where($where)->delete();
			unset($fck,$where,$rs,$rewhere);
			$bUrl = __URL__.'/adminAgents';
			$this->_box(xstr('operation_success'),xstr('delete_apply'),$bUrl,1);
			exit;
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	//查看下属账户
	public function us_menber(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGua'){
			$fck = M('fck');
			$map = array();
	
			$id = $_REQUEST['id'];
			$this->assign('myid',$id);
	
			$map['shop_id'] = $id;
			$UserID = strtoupper(trim($_REQUEST['UserID']));
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
				$KuoZhan = new KuoZhan();
				if ($KuoZhan->is_utf8($UserID) == false){
					$UserID = iconv('GB2312','UTF-8',$UserID);
				}
				unset($KuoZhan);
				$where['nickname'] = array('like',"%".$UserID."%");
				$where['user_id'] = array('like',"%".$UserID."%");
				$where['_logic']    = 'or';
				$map['_complex']    = $where;
				$UserID = urlencode($UserID);
			}
	
			//查询字段
			$field  = '*';
			//=====================分页开始==============================================
			import ( "@.ORG.ZQPage" );  //导入分页类
			$count = $fck->where($map)->count();//总页数
			$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$page_where = 'id='.$id.'&UserID='.$UserID;//分页条件
			$Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $fck->where($map)->field($field)->order('is_pay asc,pdt desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			$HYJJ = '';
			$this->_levelConfirm($HYJJ,1);
			$this->assign('voo',$HYJJ);//账户级别
	
			$alus = $fck->where($map)->sum('cpzj');
			if(empty($alus))$alus=0;
			$this->assign('cpzj_all',$alus);
			
			$v_title = $this->theme_title_value();
			$this->distheme('us_menber',$v_title[142],1);
			exit;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	
	//受理中心表
	public function financeDaoChu_BD(){
		$this->_Admin_checkUser();
		//导出excel
		set_time_limit(0);
	
		header("Content-Type:   application/vnd.ms-excel");
		header("Content-Disposition:   attachment;   filename=Member-Agent.xls");
		header("Pragma:   no-cache");
		header("Content-Type:text/html; charset=utf-8");
		header("Expires:   0");
	
	
	
		$fck = M ('fck');  //奖金表
	
		$map = array();
		$map['id'] = array('gt',0);
		$map['is_agent'] = array('gt',0);
		$field   = '*';
		$list = $fck->where($map)->field($field)->order('idt asc,adt asc')->select();
	
		$title   =   "受理中心表 导出时间:".date("Y-m-d   H:i:s");
	
		echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
		//   输出标题
		echo   '<tr   bgcolor="#cccccc"><td   colspan="9"   align="center">'   .   $title   .   '</td></tr>';
		//   输出字段名
		echo   '<tr  align=center>';
		echo   "<td>序号</td>";
		echo   "<td>账户编号</td>";
		echo   "<td>姓名</td>";
		echo   "<td>联系电话</td>";
		echo   "<td>申请时间</td>";
		echo   "<td>确认时间</td>";
		echo   "<td>类型</td>";
		echo   "<td>受理中心区域</td>";
		echo   "<td>剩余报单币</td>";
		echo   '</tr>';
		//   输出内容
	
		//		dump($list);exit;
	
		$i = 0;
		foreach($list as $row)   {
			$i++;
			$num = strlen($i);
			if ($num == 1){
				$num = '000'.$i;
			}elseif ($num == 2){
				$num = '00'.$i;
			}elseif ($num == 3){
				$num = '0'.$i;
			}else{
				$num = $i;
			}
			if($row['shoplx']==1){
				$MMM = '受理中心';
			}elseif($row['shoplx']==2){
				$MMM = '县/区代理商';
			}else{
				$MMM = '市级代理商';
			}
	
	
			echo   '<tr align=center>';
			echo   '<td>'   .  chr(28).$num   .   '</td>';
			echo   "<td>"   .   $row['user_id'].  "</td>";
			echo   "<td>"   .   $row['user_name'].  "</td>";
			echo   "<td>"   .   $row['user_tel'].  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['idt']).  "</td>";
			echo   "<td>"   .   date("Y-m-d H:i:s",$row['adt']).  "</td>";
			echo   "<td>"   .   $MMM.  "</td>";
			echo   "<td>"   .   $row['shop_a'].  " / " . $row['shop_b']  .   "</td>";
			echo   "<td>"   .   $row['agent_cash'].  "</td>";
			echo   '</tr>';
		}
		echo   '</table>';
	}
	
}
?>