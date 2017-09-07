<?php
class PlanAction extends CommonAction{
	function _initialize() {
		parent::_initialize();
		//$this->_inject_check(1);//调用过滤函数
		header("Content-Type:text/html; charset=utf-8");
	}
	
	//================================================二级验证
	public function cody(){
		$UrlID  = (int) $_GET['c_id'];
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
	//====================================二级验证后调转页面
	public function codys(){
		$Urlsz	= $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass	= $_POST['oldpassword'];
			$fck   =  M ('fck');
		    if (!$fck->autoCheckToken($_POST)){
	            $this->error(xstr('page_expire_please_reflush'));
	            exit();
	        }
			if (empty($pass)){
				$this->error(xstr('second_password_error'));
				exit();
			}
			$where =  array();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $fck->where($where)->field('id')->find();
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
				$_SESSION['UrlPTPass'] = 'MyssPlanadmina';
				$bUrl = __URL__.'/admin_plan';
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlPTPass'] = 'MyssPlanadminb';
				$bUrl = __URL__.'/admin_planTwo';
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlPTPass'] = 'MyssPlanadminc';
				$bUrl = __URL__.'/admin_planThree';
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlPTPass'] = 'MyssPlanadmind';
				$bUrl = __URL__.'/admin_planFour';
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlPTPass'] = 'MyssPlanadmine';
				$bUrl = __URL__.'/admin_planFive';
				$this->_boxx($bUrl);
				break;
			case 6;
				$_SESSION['UrlPTPass'] = 'MyssPlanadmine';
				$bUrl = __URL__.'/admin_plan_gbl/pid/6';
				$this->_boxx($bUrl);
				break;
			case 7;
				$_SESSION['UrlPTPass'] = 'MyssPlanadmine';
				$bUrl = __URL__.'/admin_plan_gbl/pid/7';
				$this->_boxx($bUrl);
				break;
			case 8;
				$_SESSION['UrlPTPass'] = 'MyssPlanadmine';
				$bUrl = __URL__.'/admin_plan_gbl/pid/8';
				$this->_boxx($bUrl);
				break;
			case 9;
				$_SESSION['UrlPTPass'] = 'MyssPlanadmine';
				$bUrl = __URL__.'/admin_plan_gbl/pid/9';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error(xstr('second_password_error'));
				break;
		}
	}
	
	public function admin_plan_gbl(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$fid = intval($_REQUEST['pid']);
		$this->plan_find($fid);
		$this->assign('fid',$fid);
		$webtitle = $this->plan_class();
		
		$this->assign('title',xstr('menu_pan_'.$fid));
		
		$this->distheme('admin_plan',xstr('menu_pan_'.$fid));
	}
	
	public function admin_plan(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$fid = 1;
		$this->plan_find($fid);
		$this->assign('fid',$fid);
		$webtitle = $this->plan_class();
		$this->assign('title',$webtitle[$fid]);
		
		$this->distheme('admin_plan',$webtitle[$fid]);
	}
	public function admin_planTwo(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$fid = 2;
		$this->plan_find($fid);
		$this->assign('fid',$fid);
		$webtitle = $this->plan_class();
		$this->assign('title',$webtitle[$fid]);
		$this->display('admin_plan');
	}
	public function admin_planThree(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$fid = 3;
		$this->plan_find($fid);
		$this->assign('fid',$fid);
		$webtitle = $this->plan_class();
		$this->assign('title',$webtitle[$fid]);
		$this->display('admin_plan');
	}
	public function admin_planFour(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$fid = 4;
		$this->plan_find($fid);
		$this->assign('fid',$fid);
		$webtitle = $this->plan_class();
		$this->assign('title',$webtitle[$fid]);
		$this->display('admin_plan');
	}
	public function admin_planFive(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$fid = 5;
		$this->plan_find($fid);
		$this->assign('fid',$fid);
		$webtitle = $this->plan_class();
		$this->assign('title',$webtitle[$fid]);
		$this->display('admin_plan');
	}
	
	public function admin_planInsert(){
		$this->_Admin_checkUser();//后台权限检测
		$plan = M ('plan');
		$inid = (int)$_POST['id'];
		$content = stripslashes($_POST['content']);
		$data = array();
		$data['id'] = $inid;
		$data['content'] = $content;
		$rs = $plan->find($inid);
		if($rs){
			$list = $plan->save ($data);
		}else{
			$list = $plan->add ($data);
		}
		if ($list !== false) {
			$this->success (xstr('save_success'));
		} else {
			$this->error (xstr('save_failed'));
		}
	}
	
	//1
	public function plan(){
		$plan = M ('plan');
		$fid = 1;
		$vo = $plan->find($fid);
		$vo['content'] = stripslashes($vo['content']);//过滤掉反斜杠
		$this->assign ( 'vo', $vo );
		$webtitle = $this->plan_class();
		$this->assign('title',$webtitle[$fid]);
		
		$this->distheme('plan',$webtitle[$fid]);
	}
	//2
	public function planTwo(){
		$plan = M ('plan');
		$vo = $plan->find(2);
		$vo['content'] = stripslashes($vo['content']);//过滤掉反斜杠
		$this->assign ( 'vo', $vo );
		
		$see = $_SERVER['HTTP_HOST'].__APP__;
		$see = str_replace("//","/",$see);
        $this->assign ( 'server', $see );
        
        //会员级别
        $fck = M ('fck');
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $urs = $fck -> where('id='.$id)->field('*') -> find();
		$this -> assign('fck_rs',$urs);//总奖金
        
		$this->display ('planTwo');
	}

	//3
	public function planThree(){
		$plan = M ('plan');
		$vo = $plan->find(3);
		$vo['content'] = stripslashes($vo['content']);//过滤掉反斜杠
		$this->assign ( 'vo', $vo );
		$this->display ('planThree');
	}

	//4
	public function planFour($Fid=0){
		$plan = M ('plan');
		$vo = $plan->find(4);
		$vo['content'] = stripslashes($vo['content']);//过滤掉反斜杠
		$this->assign ( 'vo', $vo );
		$this->display ('planFour');
	}
	
	private function plan_find($fid){
		$plan = M ('plan');
        $list = $plan->find($fid);
		$this->assign('list',$list);
		$this->us_fckeditor('content',$list['content'],400,"100%");//FCK编辑器
	}
	
	private function plan_class(){
		$returnarray = array();
		$returnarray[1] = "市场计划";
		$returnarray[2] = "市场计划-英文";
		$returnarray[3] = "公司好消息";
		$returnarray[4] = "视频宣传";
		$returnarray[5] = "注意事项";
		return $returnarray;
	}

}
?>