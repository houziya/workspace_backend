<?php
class NewsAction extends CommonAction{
	function _initialize() {
		parent::_initialize();
		$this->_inject_check(0);//调用过滤函数
		$this->_checkUser();
		header("Content-Type:text/html; charset=utf-8");
	}
	
	//二级密码验证
	public function cody(){
		$UrlID = (int)$_GET['c_id'];
		if (empty($UrlID)){
			$this->error(xstr('second_password_error'));
			exit;
		}
		if(!empty($_SESSION['user_pwd2'])){
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
		$fck   =  M ('cody');
        $list	=  $fck->where("c_id=$UrlID")->getField('c_id');
		if (!empty($list)){
			$this->assign('vo',$list);
			$v_title = $this->theme_title_value();
			$this->distheme('../Public/cody',$v_title[1]);
			exit;
		}else{
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	//二级验证后调转页面
	public function codys(){
		$Urlsz = $_POST['Urlsz'];
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

			$where =array();
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
			case 1:
				$_SESSION['Urlszpass'] = 'Myssadminnews';
				$bUrl = __URL__.'/adminnews';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error(xstr('second_password_error'));
				break;
		}
	}
	
	//新闻管理首页
	public function adminnews(){
		$this->_Admin_checkUser();//后台权限检测
		if ($_SESSION['Urlszpass'] == 'Myssadminnews'){
			$form = M ('form');
			$title = trim($_REQUEST['title']);
			if (!empty($title)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
				$KuoZhan = new KuoZhan();
				if ($KuoZhan->is_utf8($title) == false){
					$title = iconv('GB2312','UTF-8',$title);
				}
				unset($KuoZhan);
				$map['title'] = array('like',"%".$title."%");
				$title = urlencode($title);
			}
	
	        $field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $form->where($map)->count();//总页数
	   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
			$this_where = 'title='. $title;
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $form->where($map)->field($field)->order('baile desc,create_time desc,id desc')->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================
	        
	        $nclass = $this->news_class();
	        $this->assign('nclass',$nclass);

	        $v_title = $this->theme_title_value();
	        $this->distheme('adminnews',$v_title[14]);
		}else{
			$this->error (xstr('error_signed'));
			exit;
		}
	}

	public function NewsAC(){
		$this->_Admin_checkUser();//后台权限检测
		//处理提交按钮
		$action = trim($_POST['action']);
		//获取复选框的值
		$PTid = $_POST['tabledb'];
		if ($action == xstr('action001')){
			$nowtime = date("Y-m-d H:i:s");
			$this->assign('nowtime',$nowtime);
			// $this->us_fckeditor('content',"",400,"100%");
			$this->News_add();
			exit;
		}
		if (!isset($PTid) || empty($PTid)){
			$bUrl = __URL__.'/adminnews';
			$this->_box(0,xstr('hint149'),$bUrl,1);
			exit;
		}
		switch ($action){
			case xstr('action002');
				$this->News_Open($PTid);
				break;
			case xstr('action003');
				$this->News_Stop($PTid);
				break;
			case xstr('delete');
				$this->News_Del($PTid);
				break;
			case xstr('action004');
				$this->News_Top($PTid);
				break;
			case xstr('action005');
				$this->News_NoTop($PTid);
				break;
		default;
			$bUrl = __URL__.'/adminnews';
			$this->_box(0,xstr('hint150'),$bUrl,1);
			break;
		}
	}
	public function News_add(){
		$nclass = $this->news_class();
		$this->assign('nclass',$nclass);
		$v_title = $this->theme_title_value();
		$this->distheme('News_add',$v_title[15],1);
	}
	public function News_add_save(){
		$User = M ('form');
		$data = array();

		$content = stripslashes($_POST['content']);
		$title = $_POST['title'];
		$addtime = $_POST['addtime'];
		$ttime = strtotime($addtime);
		if($ttime==0){
			$ttime = mktime();
		}
		if(empty($title) or empty($content)){
			$this->error(xstr('hint151'));
		}
		//dump($_POST['select']);exit;
		$data['title'] = $title;
		$data['content'] = $content;
		$data['user_id'] = $_POST['user_id'];
		$data['create_time'] = $ttime;
		$data['status'] = 1;
		$data['type'] = $_POST['type'];

		$rs = $User->add($data);
		if (!$rs){
			$this->error(xstr('hint152'));
			exit;
		}
		$bUrl = __URL__.'/adminnews';
		$this->_box(0,xstr('hint153'),$bUrl,1);
		exit;
	}
	//启用
	private function News_Open($PTid=0){
		$User = M ('form');
		$where['id'] = array ('in',$PTid);
		$User->where($where)->setField('status',1);
		$bUrl = __URL__.'/adminnews';
		$this->_box(1,xstr('hint154'),$bUrl,1);
		exit;
	}
	//禁用
	private function News_Stop($PTid=0){
		$User = M ('form');
		$where['id'] = array ('in',$PTid);
		$User->where($where)->setField('status',0);
		$bUrl = __URL__.'/adminnews';
		$this->_box(1,xstr('hint155'),$bUrl,1);
		exit;
	}
	//删除
	private function News_Del($PTid=0){
		$User = M ('form');
		$where['id'] = array ('in',$PTid);
		$rs = $User->where($where)->delete();
		if ($rs){
			$bUrl = __URL__.'/adminnews';
			$this->_box(1,xstr('delete_success'),$bUrl,1);
			exit;
		}else{
			$bUrl = __URL__.'/adminnews';
			$this->_box(0,xstr('delete_failed'),$bUrl,1);
			exit;
		}
	}
	//置顶
	private function News_Top($PTid=0){
		$User = M ('form');
		$where['id'] = array ('in',$PTid);
		$User->where($where)->setField('baile',1);
		$bUrl = __URL__.'/adminnews';
		$this->_box(1,xstr('hint156'),$bUrl,1);
		exit;
	}
	//取消置顶
	private function News_NoTop($PTid=0){
		$User = M ('form');
		$where['id'] = array ('in',$PTid);
		$User->where($where)->setField('baile',0);
		$bUrl = __URL__.'/adminnews';
		$this->_box(1,xstr('hint157'),$bUrl,1);
		exit;
	}
	
	//编辑
	public function News_edit(){
		$this->_Admin_checkUser();//后台权限检测
		$EDid = $_GET['EDid'];
		$User = M ('form');
		$where = array();
		$where['id'] = $EDid;
		$rs = $User->where($where)->find();
		if ($rs){
			$nclass = $this->news_class();
			$this->assign('nclass',$nclass);
			
			$this->assign('vo',$rs);
			//$this->us_fckeditor('content',$rs['content'],400,"100%");
			
			$v_title = $this->theme_title_value();
			$this->distheme('News_edit',$v_title[16],1);
		}else{
			$this->error(xstr('hint150'));
			exit;
		}
	}
	public function News_editAc(){
		$this->_Admin_checkUser();//后台权限检测
		$User = M ('form');
		$data = array();
		//h 函数转换成安全html
		$content = $_POST['content'];
		$title = $_POST['title'];
		$type = $_POST['type'];
		$addtime = $_POST['addtime'];
		$ttime = strtotime($addtime);
		if($ttime==0){
			$ttime = mktime();
		}
		$data['title'] = $title;
		$data['type'] =$type;
		$data['content'] = $content;
		//$data['user_id'] = $_POST['user_id'];
		$data['create_time'] = $ttime;
		$data['update_time'] = mktime();
		$data['status'] = 1;
		$data['id'] = $_POST['ID'];

		//dump($data);
		//exit;
		$rs = $User->save($data);
		if (!$rs){
			$this->error(xstr('hint158'));
			exit;
		}
		$bUrl = __URL__.'/adminnews';
		$this->_box(1,xstr('hint159'),$bUrl,1);
		exit;
	}
	
	//前台新闻
	public function News() {
		$map = array();
		$map['status'] = 1;
		$map['type'] = array('eq','1');
		$form = M ('form');
        $field  = '*';
        //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $form->where($map)->count();//总页数
     	$listrows = C('ONE_PAGE_RE');//每页显示的记录数
     	$listrows = 20;//每页显示的记录数
        $Page = new ZQPage($count,$listrows,1);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $form->where($map)->field($field)->order('baile desc,id desc')->page($Page->getPage().','.$listrows)->select();
        $this->assign('list',$list);//数据输出到模板
        //=================================================
        
        $nclass = $this->news_class();
        $this->assign('nclass',$nclass);
        
        $v_title = $this->theme_title_value();
        $this->distheme('News',$v_title[11]);
    }
    
    //前台新闻
    public function News_b() {
    	$map = array();
    	$map['status'] = 1;
    	$map['type'] = array('eq','2');
    	$form = M ('form');
    	$field  = '*';
    	//=====================分页开始==============================================
    	import ( "@.ORG.ZQPage" );  //导入分页类
    	$count = $form->where($map)->count();//总页数
    	$listrows = C('ONE_PAGE_RE');//每页显示的记录数
    	$listrows = 20;//每页显示的记录数
    	$Page = new ZQPage($count,$listrows,1);
    	//===============(总页数,每页显示记录数,css样式 0-9)
    	$show = $Page->show();//分页变量
    	$this->assign('page',$show);//分页变量输出到模板
    	$list = $form->where($map)->field($field)->order('baile desc,id desc')->page($Page->getPage().','.$listrows)->select();
    	$this->assign('list',$list);//数据输出到模板
    	//=================================================
    
    	$nclass = $this->news_class();
    	$this->assign('nclass',$nclass);
    	
    	$v_title = $this->theme_title_value();
    	$this->distheme('News_b',$v_title[12]);
    }

	//查询返回一条记录
	public function News_show() {
		$model = M ('Form');
		$id = (int) $_GET['NewID'];
		$where = array();
		$where['id'] = $id;
		$where['status'] = 1;
		$vo = $model->where($where)->find();
		$vo['content'] = stripslashes($vo['content']);//去掉反斜杠
		$this->assign ( 'vo', $vo );
		
		$v_title = $this->theme_title_value();
    	$this->distheme('News_show',$v_title[13],1);
	}
	
	public function news_class(){
		$nclass = array();
		$nclass[1] = xstr('subWindowTitle_notype_001');
		// $nclass[2] = "学习乐园";
		return $nclass;
	}

}
?>