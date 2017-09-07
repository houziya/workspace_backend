<?php 

class CurrencyAction extends CommonAction {
	
	function _initialize() {
		parent::_initialize();
		ob_clean();
		$this->_inject_check(0);//调用过滤函数
		$this->_checkUser();
		$this->_Config_name();//调用参数
		header("Content-Type:text/html; charset=utf-8");
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
				$_SESSION['Urlszpass'] = 'MyssPaoYingTao';
				$bUrl = __URL__.'/frontCurrency';//
				$this->_boxx($bUrl);
				break;
		
			case 2;
				$_SESSION['Urlszpass'] = 'MyssGuanPaoYingTao';
				$bUrl = __URL__.'/adminCurrency';//
				$this->_boxx($bUrl);
				break;
			
			default;
				$this->error(xstr('second_password_error'));
				exit;
		}
	}

	//===================================================货币提现
	public function frontCurrency($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){
			$tiqu = M('tiqu');
			$fck = M('fck');
			$fee_rs = M ('fee')-> find(1);
			$str4=$fee_rs['str11'];
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];

			$field  = "*,money*{$str4} as chmoney,money_two*{$str4} as chmoney_two";
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $tiqu->where($map)->count();//总页数
    	    $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $Page = new ZQPage($count,$listrows,1);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $tiqu->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $ID;
			$field = '*';
			$rs = $fck ->where($where)->field($field)->find();

			$fee_rs = M ('fee') -> find();
			$this -> assign('str13',$fee_rs['str13']);
			$this -> assign('str14',$fee_rs['str14']);
			$this -> assign('str15',$fee_rs['str15']);
			$this->assign('fee_s16',$fee_rs['s16']);
			$this->assign('fee_s8',$fee_rs['s8']);
			$this->assign('rs',$rs);
			unset($tiqu,$fck,$where,$ID,$field,$rs);
			
			$v_title = $this->theme_title_value();
			$this->distheme('frontCurrency',$v_title[92]);
			return;
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}

	//=================================================提现提交
	public function frontCurrencyConfirm(){
		if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){  //提现权限session认证
			$ePoints = (int) trim($_POST['ePoints']);
			$ttype = (int) trim($_POST['ttype']);
			$remarks = $_POST['remarks'];
			$fck = M ('fck');
			if (empty($ePoints) || !is_numeric($ePoints)){
				$this->error(xstr('hint025'));
				exit;
			}
			if (strlen($ePoints) > 12){
				$this->error (xstr('hint026'));
				exit;
			}
			if ($ePoints <= 0){
				$this->error (xstr('hint027'));
				exit;
			}
//			$newWeek = date(w);
//			if($newWeek!=0||$newWeek!=6){
//				$this->error('只能星期六、星期日才能提现！');
//				exit;
//			}
			
			if(!($ttype == 1))
			{
				$this->error (xstr('hint071'));
				exit;
			}

			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];

			if($ID == 1){
				$inUserID =  $_POST['UserID'];           //要提现的会员帐号 800000登录时可以帮其它会员申请提现
			}else{
				$inUserID =  $_SESSION['loginUseracc'];  //登录的会员帐号 user_id
			}
			$tiqu = M ('tiqu');
			$where['user_id'] = $inUserID;
			$field ='*';
			$fck_rs = $fck ->where($where)->field($field)->find();
			if (!$fck_rs){
				$this->error(xstr('the_account_not_exists'));
				exit;
			}
			if($fck_rs['is_lockqd']==1){
				$this->error(xstr('hint072'));
				exit;
			}
//			$is_agent = $fck_rs['is_agent'];
//			if($fck_rs['id']==1){
//				$is_agent = 0;
//			}
//			if($is_agent==2){
//				$this->error(xstr('hint073'));
//				exit;
//			}
			$fee_rs = M ('fee') -> find();
			$subMoney = 0;
			/*
			if($ttype==1)
				$subMoney = floatval($fee_rs['s16']);
			else
				$subMoney = floatval($fee_rs['s8']);*/
			
			if($ttype==1){
				$AgentUse = $fck_rs['agent_cash'];
			}else{
				$AgentUse = $fck_rs['agent_use'];
			}
			if ($AgentUse < ($ePoints+$subMoney)){
				$this->error(xstr('account_not_sufficient_funds'));
				exit;
			}

			$s_nowd = strtotime(date("Y-m-d"));
			$e_nowd = $s_nowd+3600*24;

//			$where2 = array();
//			$where2['uid'] = $fck_rs['id'];   //申请提现会员ID
//			$where2['rdt'] = array(array('egt',$s_nowd),array('lt',$e_nowd));
//			$field1 = 'id';
//			$vo5 = $tiqu ->where($where2)->count();
//			if ($vo5>0){
//				$this->error(xstr('hint074'));
//				exit;
//			}

			$where1 = array();
			$where1['uid'] = $fck_rs['id'];   //申请提现会员ID
			$where1['is_pay'] = 0;            //申请提现是否通过
			$where1['t_type'] = $ttype;
			$field1 = 'id';
			$vo3 = $tiqu ->where($where1)->field($field1)->find();
			if ($vo3){
				$this->error(xstr('hint075'));
				exit;
			}

			
/*
			$str15 = $fee_rs['str15'];  //手续费
			$str14 = $fee_rs['str14'];  //倍数
			$str13 = $fee_rs['str13'];  //最低金额

			if ($ePoints < $str13){
				$this->error (xstr('hint077').$str13);
				exit;
			}*/

			if ($ePoints % 100){
				$this->error (xstr('hint076'));
				exit;
			}

			$bank_name = $fck_rs['bank_name'];  //开户银行
			$bank_card = $fck_rs['bank_card'];  //银行卡号
			$user_name = $fck_rs['user_name'];   //开户姓名
			$bank_address = $fck_rs['bank_address'];   //开户地址
			$user_tel = $fck_rs['user_tel'];   //开户姓名

			$ePoints_two = $ePoints * (1-($fee_rs['s16']/100));  //提现扣税
			$ePoints += $subMoney;
//			$ePoints_two = $ePoints - $fee_rs['s8'];  //提现扣税

			$nowdate = strtotime(date('c'));
			//开始事务处理
			$tiqu->startTrans();

			//插入提现表
			$data                 = array();
			$data['uid']          = $fck_rs['id'];
			$data['user_id']      = $inUserID;
			$data['rdt']          = $nowdate;
			$data['money']        = $ePoints;
			$data['money_two']    = $ePoints_two;
			$data['epoint']       = $ePoints;
			$data['is_pay']       = 0;
			$data['bank_name']    = $bank_name;  //银行名称
			$data['bank_card']    = $bank_card;  //银行地址
			$data['user_name']    = $user_name;  //开户名称
			$data['bank_address'] = $bank_address;
			$data['user_tel']	  = $user_tel;
			$data['t_type']		  = $ttype;
			$data['remarks']		  = $remarks;
			$rs2 = $tiqu->add($data);
			unset($data,$vo3,$where1);
			if ($rs2){
				//提交事务
				if($ttype==1){
					$fck->execute("UPDATE __TABLE__ SET agent_cash=agent_cash-{$ePoints} WHERE id={$fck_rs['id']}");
				}else{
					$fck->execute("UPDATE __TABLE__ SET agent_use=agent_use-{$ePoints} WHERE id={$fck_rs['id']}");
				}
				$tiqu->commit();
				$bUrl = __URL__.'/frontCurrency';
				$this->_box(1,xstr('hint078'),$bUrl,1);
				exit;
			}else{
				//事务回滚：
				$tiqu->rollback();
				$this->error(xstr('hint079'));
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	//=============撤销提现
	public function frontCurrencyDel(){
	    if ($_SESSION['Urlszpass'] == 'MyssPaoYingTao'){
			$tiqu = M ('tiqu');
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$id = (int) $_GET['id'];
	    	$where = array();
	    	$where['id']  = $id;
	        $where['uid'] = $uid;   //申请提现会员ID
	        $where['is_pay'] = 0;            //申请提现是否通过
	        $field = 'id,money,uid';
	        $trs = $tiqu ->where($where)->field($field)->find();
	        if ($trs){
	        	$ttype = $trs['t_type'];
	            $fck = M ('fck');
	            if($ttype==1){
	            	$fck->execute("UPDATE __TABLE__ SET agent_cash=agent_cash+{$trs['money']} WHERE id={$trs['uid']}");
	            }else{
	            	$fck->execute("UPDATE __TABLE__ SET agent_use=agent_use+{$trs['money']} WHERE id={$trs['uid']}");
	            }
	            $tiqu->where($where)->delete();
	            $bUrl = __URL__.'/frontCurrency';
                $this->_box(1,xstr('hint080'),$bUrl,1);
                exit;
	        }else{
	        	$this->error(xstr('record_not_exists'));
                exit;
	        }
	    }else{
            $this->error(xstr('error_signed'));
            exit;
        }
	}

	//===============================================提现管理
	public function adminCurrency(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M ('tiqu');
			$fck = M('fck');
			$fee_rs = M ('fee')->field('str11') -> find();
			$str4 = $fee_rs['str11'];
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}
            $field  = "*,money*{$str4} as chmoney,money_two*{$str4} as chmoney_two";
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $tiqu->where($map)->count();//总页数
//       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
       		$listrows = 20;	//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $tiqu->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
            $i=0;
            foreach($list as $vvv){
            	$uuid = $vvv['uid'];
            	$urs = $fck->where('id='.$uuid)->field('bank_address')->find();
            	if($urs){
            		$list[$i]['bank_address'] = $urs['bank_address'];
            	}
            	$i++;
            }
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			
			$v_title = $this->theme_title_value();
			$this->distheme('adminCurrency',$v_title[191]);
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	//处理提现
	public function adminCurrencyAC(){
		$this->_Admin_checkUser();//后台权限检测
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$fck = M ('fck');
		if (empty($PTid)){
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(0,xstr('please_select'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('confirm_2'):
				$this->_adminCurrencyConfirm($PTid);
				break;
			case xstr('delete'):
				$this->_adminCurrencyDel($PTid);
				break;
		default:
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(0, xstr('record_not_exists'), $bUrl,1);
			break;
		}
	}
	
	//====================================================确认提现
	private function _adminCurrencyConfirm($PTid){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M ('tiqu');
			$fck = M('fck');//
			$history = M('history');
			$where = array();
			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$rs = $tiqu->where($where)->select();
			
			$data = array();
			$fck_where = array();
			$nowdate = strtotime(date('c'));
			foreach($rs as $rss){
				$fck_where['id'] = $rss['uid'];
				$rsss = $fck->where($fck_where)->field('id,user_id,agent_use')->find();
				if ($rsss){
					$result = $tiqu->execute("UPDATE __TABLE__ set `is_pay`=1 where `id`=".$rss['id']);
					if($result){
						//插入历史表
						$data = array();
						$data['uid']			= $rsss['id'];//提现会员ID
						$data['user_id']		= $rsss['user_id'];
						$data['action_type']	= 18;
						$data['pdt']			= mktime();//提现时间
						$data['epoints']		= $rss['money'];//进出金额
						$data['allp']			= $rss['money_two'];
						$data['bz']				= '18';//备注
						$data['type']			= 2;//1 转帐  2 提现
						$history->add($data);
						unset($data);
						
						$fck->execute("UPDATE __TABLE__ set zsq=zsq+".$rss['money']." where `id`=".$rss['uid']);
					}
				}else{
					$tiqu->execute("UPDATE __TABLE__ set `is_pay`=1 where `id`=".$rss['id']);
				}
			}
			unset($tiqu,$fck,$where,$rs,$history,$data,$nowdate,$fck_where);
			$bUrl = __URL__.'/adminCurrency';
			$this->_box(1,xstr('hint081'),$bUrl,1);
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	//删除提现
	private function _adminCurrencyDel($PTid){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			$tiqu = M ('tiqu');
			$where = array();
//			$where['is_pay'] = 0;
			$where['id'] = array ('in',$PTid);
			$trs = $tiqu->where($where)->select();
			$fck = M ('fck');
			foreach ($trs as $vo){
				$isok = $vo['is_pay'];
				$money=$vo['money'];
				if($isok==0){
					$t_type = $vo['t_type'];
					if($t_type==1){
						$fck->execute("UPDATE __TABLE__ SET agent_cash=agent_cash+{$money} WHERE id={$vo['uid']}");
					}else{
						$fck->execute("UPDATE __TABLE__ SET agent_use=agent_use+{$money} WHERE id={$vo['uid']}");
					}
				}
			}
			$rs = $tiqu->where($where)->delete();
			if ($rs){
				$bUrl = __URL__.'/adminCurrency';
				$this->_box(1,xstr('delete_success'),$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminCurrency';
				$this->_box(0,xstr('delete_failed'),$bUrl,1);
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	//导出excel
	public function DaoChu(){
		if ($_SESSION['UrlPTPass'] == 'MyssGuanPaoYingTao'){
			set_time_limit(0);
			$title   =   "数据库名:Cash,   数据表:Cash,   备份日期:"   .   date("Y-m-d   H:i:s");
			header("Content-Type:   application/vnd.ms-excel");
			header("Content-Disposition:   attachment;   filename=Cash.xls");
			header("Pragma:   no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires:   0");
			echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
			//   输出标题
			echo   '<tr   bgcolor="#cccccc"><td   colspan="11"   align="center">'   .   $title   .   '</td></tr>';
			//   输出字段名
			echo   '<tr >';
			echo   "<td>会员编号</td>";
			echo   "<td>开户名</td>";
			echo   "<td>开户银行</td>";
			echo   "<td>银行帐号</td>";
			echo   "<td>开户省</td>";
			echo   "<td>开户市</td>";
			echo   "<td>详细开户地址</td>";
			echo   "<td>提现金额</td>";
			echo   "<td>实发金额</td>";
			echo   "<td>提现时间</td>";
			echo   "<td>状态</td>";
			echo   '</tr>';
			//   输出内容
			$tiqu = M ('tiqu');
			$everyo = 1000;
			$join = "zyrj_fck on zyrj_fck.id=zyrj_tiqu.uid";
			$field = "zyrj_tiqu.*,zyrj_fck.bank_province,zyrj_fck.bank_city";
			$tcount = $tiqu->join($join)->count();
			$str_l = floor($tcount/$everyo);
			$las_l = $str_l+1;
			for($i=0;$i<$las_l;$i++){
				$sta_l = $i*$everyo;
				$lim_l = $sta_l.",".$everyo;
				$trs = $tiqu->join($join)->field($field)->order('id asc')->limit($lim_l)->select();
				foreach($trs as $row){
					if ($row['is_pay']==0){
						$isPay = '未确认';
					}else{
						$isPay = '已确认';
					}
					echo   '<tr>';
					echo   '<td>'   .   $row['user_id']   .   '</td>';
					echo   '<td>'   .   $row['user_name']   .   '</td>';
					echo   '<td>'   .   $row['bank_name']   .   '</td>';
					echo   '<td>'   .   chr(28).$row['bank_card'] .  '</td>';
					echo   '<td>'   .   $row['bank_province']   .   '</td>';
					echo   '<td>'   .   $row['bank_city']   .   '</td>';
					echo   '<td>'   .   $row['bank_address']   .   '</td>';
					echo   '<td>'   .   $row['money']   .   '</td>';
					echo   '<td>'   .   $row['money_two']   .   '</td>';
					echo   '<td>'   .   date('Y-m-d',$row['rdt'])   .   '</td>';
					echo   '<td>'   .  $isPay    .   '</td>';
					echo   '</tr>';
				}
				unset($trs,$row);
			}
			echo   '</table>';
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

	public function DaoChu1(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'MyssGuanPaoYingTao'){
			set_time_limit(0);
			$title   =   "数据库名:test,   数据表:test,   备份日期:"   .   date("Y-m-d   H:i:s");
			header("Content-Type:   application/vnd.ms-excel");
			header("Content-Disposition:   attachment;   filename=test.xls");
			header("Pragma:   no-cache");
			header("Content-Type:text/html; charset=utf-8");
			header("Expires:   0");
			echo   '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
			//   输出标题
			echo   '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">'   .   $title   .   '</td></tr>';
			//   输出字段名
			echo   '<tr >';
			echo   "<td>会员编号</td>";
			echo   "<td>开户名</td>";
			echo   "<td>开户银行</td>";
			echo   "<td>银行帐号</td>";
			echo   "<td>提现金额</td>";
			echo   "<td>实发金额</td>";
			echo   "<td>提现时间</td>";
			echo   "<td>状态</td>";
			echo   '</tr>';
			//   输出内容
			$tiqu = M ('tiqu');
			$trs = $tiqu->select();
			foreach($trs as $row)   {
				if ($row['is_pay']==0){
				    $isPay = '未确认';
				}else{
				    $isPay = '已确认';
				}
				echo   '<tr>';
				echo   '<td>'   .   $row['user_id']   .   '</td>';
				echo   '<td>'   .   $row['user_name']   .   '</td>';
				echo   '<td>'   .   $row['bank_name']   .   '</td>';
				echo   "<td>,"  .  chr(28).$row['bank_card'] .  "</td>";
				echo   '<td>'   .   $row['money']   .   '</td>';
				echo   '<td>'   .   $row['money_two']   .   '</td>';
				echo   '<td>'   .   date('Y-m-d',$row['rdt'])   .   '</td>';
				echo   '<td>'   .  $isPay    .   '</td>';
				echo   '</tr>';
			}
			echo   '</table>';
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}


	

}
?>