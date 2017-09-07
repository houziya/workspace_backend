<?php 

class ConsumeAction extends CommonAction {
	
	function _initialize() {
		parent::_initialize();
		$this->_inject_check(0);//调用过滤函数
		$this->_checkUser();
		$this->_Config_name();//调用参数
		header("Content-Type:text/html; charset=utf-8");
		ob_clean();
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
			$this->display('../Public/cody');
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
				$_SESSION['Urlszpass'] = 'Myssconsume';
				$bUrl = __URL__.'/consume';//
				$this->_boxx($bUrl);
				break;
		
			case 2;
				$_SESSION['Urlszpass'] = 'Myssadminconsume';
				$bUrl = __URL__.'/adminconsume';//
				$this->_boxx($bUrl);
				break;
			
			default;
				$this->error(xstr('second_password_error'));
				exit;
		}
	}

	//消费
	public function consume($Urlsz=0){
		if ($_SESSION['Urlszpass'] == 'Myssconsume'){
			$tiqu = M('xiaof');
			$fck = M('fck');
			$map['uid'] = $_SESSION[C('USER_AUTH_KEY')];

			$field  = '*';
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
			$rs = $fck ->where($where)->find();
			$this->assign('rs',$rs);

			$fee = M('fee');
	    	$fee_rs = $fee->field('s7')->find();
	    	$s7 = explode("|",$fee_rs['s7']);
	    	$this->assign('s7',$s7);

			unset($tiqu,$fck,$where,$ID,$field,$rs);
			$this->display ();
			return;
		}else{
			$this->error ('错误1!');
			exit;
		}
	}

	//消费处理
	public function consumeAC(){
		if ($_SESSION['Urlszpass'] == 'Myssconsume'){
			$uplevel = (int)$_POST['uplevel'];
			$fck = M('fck');
			$xiaof = M('xiaof');
			if($uplevel<=0||$uplevel>2){
				$this->error ('申请封顶参数错误！');
				exit;
			}
			$where = array();
			$ID = $_SESSION[C('USER_AUTH_KEY')];
			//查询条件
			$where['id'] = $ID;
			$fck_rs = $fck ->where($where)->find();
			if (!$fck_rs){
				$this->error(xstr('the_account_not_exists'));
				exit;
			}
			$inUserID = $fck_rs['user_id'];
			$get_level = $fck_rs['get_level'];
			$x_num = $fck_rs['x_num'];
			if(($get_level==0&&$x_num>=6)||($get_level==1&&$x_num>=3)){//条件
			
				$fee = M('fee');
		    	$fee_rs = $fee->field('s7')->find();
		    	$s7 = explode("|",$fee_rs['s7']);
				
				if ($get_level >= $uplevel){
					$this->error('申请封顶参数错误！');
					exit;
				}
				
				$ccrs = $xiaof->where('uid='.$fck_rs['id'].' and is_pay=0')->count();
				if($ccrs){
					$this->error('您有封顶申请未确认！');
					exit;
				}
				
				$ePoints = $s7[$uplevel];
				
				$data				= array();
				$data['uid']		= $fck_rs['id'];
				$data['user_id']	= $inUserID;
				$data['rdt']		= time();
				$data['money']		= $ePoints;
				$data['money_two']	= $uplevel;
				$data['epoint']		= $ePoints;
				$data['is_pay']		= 0;
				$rs2 = $xiaof->add($data);
				unset($data);
				if ($rs2){
					$bUrl = __URL__.'/consume';
					$this->_box(1,xstr('apply_success'),$bUrl,1);
					exit;
				}else{
					$this->error('申请失败！');
					exit;
				}
			}else{
				$this->error('申请失败，条件未达成！');
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

	//封顶申请管理
	public function adminconsume(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'Myssadminconsume'){
			$xiaof = M ('xiaof');
			$UserID = $_POST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $xiaof->where($map)->count();//总页数
       		$listrows = 20;	//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $xiaof->where($map)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$list);//数据输出到模板
			//=================================================
			$this->display('adminconsume');
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}
	
	//封顶申请管理处理
	public function adminconsumeAC(){
		$this->_Admin_checkUser();//后台权限检测
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		$fck = M ('fck');
		if (empty($PTid)){
			$bUrl = __URL__.'/adminconsume';
			$this->_box(0,xstr('please_select'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('confirm_2'):
				$this->_adminconsumeConfirm($PTid);
				break;
			case xstr('delete'):
				$this->_adminconsumeDel($PTid);
				break;
		default:
			$bUrl = __URL__.'/adminconsume';
			$this->_box(0, xstr('record_not_exists'), $bUrl,1);
			break;
		}
	}
	

	
	//封顶申请管理删除
	private function _adminconsumeDel($PTid){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'Myssadminconsume'){
			$xiaof = M ('xiaof');
			$where = array();
			$where['id'] = array ('in',$PTid);
			$rs = $xiaof->where($where)->delete();
			if ($rs){
				$bUrl = __URL__.'/adminconsume';
				$this->_box(1,xstr('delete_success'),$bUrl,1);
				exit;
			}else{
				$bUrl = __URL__.'/adminconsume';
				$this->_box(0,xstr('delete_failed'),$bUrl,1);
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

}
?>