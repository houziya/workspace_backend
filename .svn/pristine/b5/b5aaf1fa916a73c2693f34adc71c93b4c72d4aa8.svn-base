<?php
class UserAction extends CommonAction{
	
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
			$_SESSION['Urlszpass'] = 'MyssHuoLongGuo';
			$bUrl = __URL__.'/relations';
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['Urlszpass'] = 'Myssmemberx';
			$bUrl = __URL__.'/member_x';
			$this->_boxx($bUrl);
			break;
			case 3;
			$_SESSION['Urlszpass'] = 'Myssmemberz';
			$bUrl = __URL__.'/member_z';
			$this->_boxx($bUrl);
			break;
			
			default;
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	
	//推荐表
	public function relations($Urlsz=0){
		//推荐关系
		if ($_SESSION['Urlszpass'] == 'MyssHuoLongGuo'){
			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			if (!empty($UserID)){
				$map['user_id'] = array('like',"%".$UserID."%");
			}
			$map['re_id'] = $_SESSION[C('USER_AUTH_KEY')];
			// $map['is_pay'] = 1;

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
            $list = $fck->where($map)->field($field)->order('pdt desc')->page($Page->getPage().','.$listrows)->select();
            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$v_title = $this->theme_title_value();
			$this->distheme('relations',$v_title[55]);
			return;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	//前后5人
	public function member_x(){
		if ($_SESSION['Urlszpass'] == 'Myssmemberx'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$myrs = $fck->where('id='.$id)->field('id,user_id,n_pai')->find();
			$n_pai = $myrs['n_pai'];
			
			$field  = 'id,user_id,n_pai,pdt,user_tel,qq';
			//前面5个
    		$wherea = "is_pay>0 and n_pai<".$n_pai;
            $alist = $fck->where($wherea)->field($field)->order('n_pai desc')->limit(5)->select();
            $this->assign('alist',$alist);
            
            //后5个
    		$whereb = "is_pay>0 and n_pai>".$n_pai;
            $blist = $fck->where($whereb)->field($field)->order('n_pai asc')->limit(5)->select();
            $this->assign('blist',$blist);
//            dump($blist);exit;

			$this->display ('member_x');
			return;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	//一线排网
	public function member_z(){
		if ($_SESSION['Urlszpass'] == 'Myssmemberz'){
			$fck = M('fck');
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$myrs = $fck->where('id='.$id)->field('id,user_id,x_pai')->find();
			$x_pai = $myrs['x_pai'];
			
			$field  = 'id,user_id,x_pai,pdt,user_tel,qq,x_num,x_out';

    		$wherea = "is_pay>0 and x_pai>=".$x_pai;
    		//=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($wherea)->count();//总页数
       		$listrows = 20;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($wherea)->field($field)->order('x_pai asc,id asc')->page($Page->getPage().','.$listrows)->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            $nn = $fck->where("is_pay>0 and x_pai<".$x_pai." and x_out=0")->count();
            $this->assign('nn',$nn);

			$this->display ('member_z');
			return;
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	

}
?>