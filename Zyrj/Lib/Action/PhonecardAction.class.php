<?php
class PhonecardAction extends CommonAction{

    function _initialize() {
		parent::_initialize();
		$this->_inject_check(0); //调用过滤函数
		$this->_checkUser();
		header("Content-Type:text/html; charset=utf-8");
	}

    //二级验证
    public function Cody(){
        //$this->_checkUser();
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
		$list   =  $cody->where("c_id=$UrlID")->field('c_id')->find();
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
	public function Codys() {
		$Urlsz = $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass = $_POST['oldpassword'];
			$fck = M('fck');
			if (!$fck->autoCheckToken($_POST)) {
				$this->error(xstr('page_expire_please_reflush'));
				exit ();
			}
			if (empty ($pass)) {
				$this->error(xstr('second_password_error'));
				exit ();
			}
			$where = array ();
			$where['id'] = $_SESSION[C('USER_AUTH_KEY')];
			$where['passopen'] = md5($pass);
			$list = $fck->where($where)->field('id')->find();
			if ($list == false) {
				$this->error(xstr('second_password_error'));
				exit ();
			}
			$_SESSION['user_pwd2'] = 1;
		}else{
			$Urlsz = $_GET['Urlsz'];
		}
		switch ($Urlsz) {
			case 1;
				$_SESSION['UrlszUserpass'] = 'MyssGuanChanPin';
				$_SESSION['Phonectype'] = 0;
				$bUrl = __URL__ . '/card_index';
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlszUserpass'] = 'manlian';//求购代币
				$bUrl = __URL__ . '/card_list';
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlszUserpass'] = 'MyssGuanChanPin';
				$_SESSION['Phonectype'] = 1;
				$bUrl = __URL__ . '/card_index';
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlszUserpass'] = 'Myssbuycard';
				$_SESSION['Phonectype'] = 0;
				$bUrl = __URL__ . '/buy_card';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error(xstr('second_password_error'));
				break;
		}
	}

	//赠送信息
	public function card_list() {
		$card = M('card');
		$fck = M('fck');
		
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$map = array();
		$map['bid'] = array('eq',$id);
		$map['is_sell'] = array('eq',1);
		
		//=====================分页开始==============================================
		import ( "@.ORG.ZQPage" );  //导入分页类
		$count = $card->where($map)->count();//总页数
		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
		$Page = new ZQPage($count, $listrows, 1, 0, 3);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板
		$field = '*';
		$list = $card->where($map)->field($field)->order('b_time desc')->page($Page->getPage().','.$listrows)->select();
		$this->assign('list', $list);
		
		$where = array();
		$where['id'] = $id;
		$fck_rs = $fck ->where($where)->field($field)->find();
		$card_num = $fck_rs['ca_numb'];
		$this->assign('card_num', $card_num);
		
		$this->display();
	}
	
	//购买话卡
	public function buy_card(){
		if ($_SESSION['UrlszUserpass'] == 'Myssbuycard'){
			$fck = M('fck');
			$card = M('card');
			
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$where = array();
			$where['id'] = $id;
			$fck_rs = $fck ->where($where)->find();
			$this->assign('fck_rs', $fck_rs);
			
			$map="is_sell=0 and money=".$fck_rs['cpzj'];
			import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $card->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
       		$listrows = 20;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
			$c_rs = $card ->where($map)->order('id asc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('list',$c_rs);
			
			$this->display('buy_card');
		}else{
			$this->error(xstr('error_signed'));
		}
	}
	
//购买话卡AC
	public function buy_cardAC() {
		$card = M('card');
		$fck = D('Fck');
		$fee = M('fee');
		
		$fee_rs = $fee->field('s4')->find(1);
		$s4 = $fee_rs['s4'];
		$one_mm = $s4;
		if($one_mm<=0){
			$this->error('参数设置不正确，请联系管理员！');
			exit;
		}
	
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$where = array();
		$where['id'] = $id;
		$fck_rs = $fck ->where($where)->field("*")->find();
		if($fck_rs['is_pay']==0){
			$this->error('临时会员不能购买！');
			exit;
		}
		$cid = (int)$_GET['cid'];
		$gid = (int)$_GET['gid'];
		if($gid==1){
			$agent_us = $fck_rs['agent_cs'];
		}else{
			$agent_us = $fck_rs['agent_use'];
		}
		$where = array();
		$where['id'] = array('eq',$cid);
		$where['is_sell'] = array('eq',0);
		$c_rs = $card->where($where)->find();
		if(!$c_rs){
			$this->error("错误！请刷新页面在进行购买");
			exit;
		}
		$all_money = $c_rs['money'];
		if($agent_us<$all_money){
			$this->error('您的会员余额不足，请充值后购买！');
			exit;
		}
		if($gid==1){
			$result = $fck->execute("update __TABLE__ set agent_cs=agent_cs-".$all_money." where agent_cs=".$agent_us." and id=".$id);
		}else{
			$result = $fck->execute("update __TABLE__ set agent_use=agent_use-".$all_money." where agent_use=".$agent_us." and id=".$id);
		}
		if($result){
			$shouru = M ('shouru');
			//发放卡号
			$res = $this->fafang_card($fck_rs['id'],$fck_rs['user_id'],1,$cid);
			if($res>0){
				$data = array();
				$data['uid'] = $fck_rs['id'];
				$data['user_id'] = $fck_rs['user_id'];
				$data['in_money'] = $all_money;
				$data['in_time'] = time();
				$data['in_bz'] = "重复购买话卡";
				$shouru->add($data);
				unset($data);
				
				//历史记录
				$fck->addencAdd($fck_rs['id'], $fck_rs['user_id'], -$all_money, 24);
					
				$bUrl = __URL__.'/card_list';
				$this->_box(1,'成功提取'.$res.'张电话卡',$bUrl,1);
				exit;
			}else{
				//重新补回
				if($gid==1){
					$fck->execute("update __TABLE__ set agent_cs=agent_cs+".$all_money." where id=".$id);
				}else{
					$fck->execute("update __TABLE__ set agent_use=agent_use+".$all_money." where id=".$id);
				}
				$this->error('提取失败，没有剩余电话卡，请联系管理员！');
				exit;
			}
		}else{
			$this->error('提取失败！');
			exit;
		}
	}
	
	//赠送信息AC
	public function card_listAC() {
		$card = A('Phonecard');
		$fck = M('fck');
		
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$where = array();
		$where['id'] = $id;
		$fck_rs = $fck ->where($where)->field("*")->find();
		$card_num = $fck_rs['ca_numb'];
		if($card_num<=0){
			$this->error('您的电话卡已经领完，请续费！');
			exit;
		}
		$result = $fck->execute("update __TABLE__ set ca_numb=ca_numb-1 where ca_numb=".$card_num." and id=".$id);
		if($result){
			
			//发放卡号
			$res = $card->fafang_card($fck_rs['id'],$fck_rs['user_id'],1,0,0);
			if($res>0){
				$bUrl = __URL__.'/card_list';
				$this->_box(1,'成功提取'.$res.'张电话卡',$bUrl,1);
				exit;
			}else{
				$this->error('提取失败，没有剩余电话卡，请联系管理员！');
				exit;
			}
		}else{
			$this->error('提取失败！');
			exit;
		}
	}
	
	//表查询
	public function card_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$card = M('card');
			$title = $_REQUEST['stitle'];
			$map = array();
			if(strlen($title)>0){
				$map['card_no'] = array('like','%'. $title .'%');
			}
			$pctype = (int)$_SESSION['Phonectype'];
			$map['c_type'] = $pctype;
			
			$orderBy = 'id desc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $card->where($map)->count();//总页数
	   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
	   		$listrows = 20;//每页显示的记录数
	        $page_where = 'stitle=' . $title ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $card->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================
	        if($pctype==0){
	        	$title = "电话卡";
	        }else{
	        	$title = "体验卡";
	        }
	        $this->assign('viptitle',$title);

	        $this->display();
		}else{
            $this->error(xstr('error_signed'));
        }
	}

	//表显示修改
	public function card_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$card = M ('card');
		$where = array();
		$where['id'] = $EDid;
		$rs = $card->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
//			$this->us_fckeditor('content',$rs['content'],400,"96%");
			$pctype = (int)$_SESSION['Phonectype'];
			if($pctype==0){
	        	$title = "电话卡";
	        }else{
	        	$title = "体验卡";
	        }
	        $this->assign('viptitle',$title);
			$this->display();
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	//表修改保存
	public function card_edit_save(){
		$this->_Admin_checkUser();
		$card = M ('card');
		$data = array();
		$card_no = trim($_POST['card_no']);
		$card_pw = trim($_POST['card_pw']);
		$cid = (int)$_POST['id'];
		if (empty($card_no)){
			$this->error('电话卡号不能为空!');
			exit;
		}
		if (empty($card_pw)){
			$this->error('电话卡密码不能为空!');
			exit;
		}
		$cff = $this->check_cf_no($card_no,$cid);
		if($cff==1){
			$this->error('电话卡号重复!');
			exit;
		}
		$data['card_no'] = $card_no;
		$data['card_pw'] = $card_pw;
		$data['id'] = $cid;
		$rs = $card->save($data);
		if (!$rs){
			$this->error(xstr('hint158'));
			exit;
		}
		$bUrl = __URL__.'/card_index';
		$this->_box(1,xstr('operation_success'),$bUrl,1);
		exit;
	}

	//产品表操作（启用禁用删除）
	public function card_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){
//			$this->us_fckeditor('content',"",400,"96%");
			$pctype = (int)$_SESSION['Phonectype'];
			if($pctype==0){
	        	$title = "电话卡";
	        }else{
	        	$title = "体验卡";
	        }
	        $this->assign('viptitle',$title);
			$this->display('card_add');
			exit;
		}
		if ($action=='补发给会员'){
			$this->bf_card();
			exit;
		}
		$card = M ('card');
		switch ($action){
			case xstr('delete');
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $card->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/card_index';
					$this->_box(1,xstr('operation_success'),$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/card_index';
					$this->_box(0,xstr('operation_failed'),$bUrl,1);
				}
				break;
			default;
				$bUrl = __URL__.'/card_index';
				$this->_box(0,xstr('operation_failed'),$bUrl,1);
				break;
		}
	}

	//表添加保存
	public function card_inserts(){
		$this->_Admin_checkUser();
		$card = M('card');
		$data = array();
		$card_no = trim($_POST['card_no']);
		$card_pw = trim($_POST['card_pw']);
		$money = trim($_POST['money']);
		$is_use = (int)(trim($_POST['is_use']));
		if (empty($card_no)){
			$this->error('电话卡号不能为空!');
			exit;
		}
		if (empty($card_pw)){
			$this->error('电话卡密码不能为空!');
			exit;
		}
		if (empty($money) || !is_numeric($money)){
			$this->error(xstr('hint025'));
			exit;
		}
		if (strlen($money) > 12){
			$this->error (xstr('hint026'));
			exit;
		}
		if ($money <= 0){
			$this->error (xstr('hint027'));
			exit;
		}
		if ($is_use < 0){
			$this->error ('有效期输入不正确!');
			exit;
		}
		$cff = $this->check_cf_no($card_no,0);
		if($cff==1){
			$this->error('电话卡号重复!');
			exit;
		}
		
		$data['card_no'] = $card_no;
		$data['card_pw'] = $card_pw;
		$data['money'] = $money;
		$data['is_use'] = $is_use;
		$data['c_time'] = time();
		$data['f_time']=time();
		$data['c_type']=(int)$_SESSION['Phonectype'];
		$form_rs = $card->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/card_index';
		$this->_box(1,xstr('operation_success'),$bUrl,1);
		exit;
	}
	
	//补发给会员
	public function bf_card(){
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$card = M('card');
			$pctype = (int)$_SESSION['Phonectype'];
			if($pctype==0){
	        	$title = "电话卡";
	        }else{
	        	$title = "体验卡";
	        }
	        $this->assign('viptitle',$title);
			$map = array();
			$map['is_sell'] = array('eq',0);
			$map['c_type'] = array('eq',$pctype);
	        $count = $card->where($map)->count();//总页数
			$this->assign('cardc',$count);
			
			$map['money'] = array('eq',50);
			$ann = $card->where($map)->count();
			$this->assign('ann',$ann);
			
			$map['money'] = array('eq',15);
			$bnn = $card->where($map)->count();
			$this->assign('bnn',$bnn);
			
	        $this->display('bf_card');
		}else{
            $this->error(xstr('error_signed'));
        }
	}
	
	//补发给会员处理
	public function bf_cardAC(){
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$fck = M ('fck');
			$user_id = trim($_POST['userid']);
			$numb = trim($_POST['numb']);
			$ftype = (int)$_POST['ftype'];
			if (empty($user_id)){
				$this->error('会员编号不能为空!');
				exit;
			}
			if (empty($numb) || !is_numeric($numb)){
				$this->error('数量不能为空!');
				exit;
			}
			if ($numb<=0){
				$this->error ('数量不对!');
				exit;
			}
			
			$where = array();
			$where['user_id'] = array('eq',$user_id);
			$where['is_pay'] = array('gt',0);
			$rs = $fck->where($where)->field('id,user_id')->find();
			if(!$rs){
				$this->error('会员不存在，或未开通！');
				exit;
			}
			$myid = $rs['id'];
			$inUserID = $rs['user_id'];
			
			$pctype = (int)$_SESSION['Phonectype'];
			if($pctype==0){
	        	$title = "电话卡";
	        }else{
	        	$title = "体验卡";
	        }
			//发放卡号
			$res = $this->fafang_card($myid,$inUserID,$numb,0,$pctype,$ftype);
			
			unset($fck,$where,$rs);
			$bUrl = __URL__.'/card_index';
			$this->_box(1,'成功补发'.$res.'张'.$title.'！',$bUrl,3);
		}else{
            $this->error(xstr('error_signed'));
        }
	}
	
	public function check_cf_no($cno,$cid=0){
		$card = M('card');
		$where = array();
		$where['card_no'] = array('eq',$cno);
		$where['id'] = array('neq',$cid);
		$crs = $card->where($where)->find();
		if($crs){
			$res = 1;
		}else{
			$res = 0;
		}
		unset($card,$where,$crs);
		return $res;
	}
	
	//发放卡号
	public function fafang_card($fid,$fuserid,$cx_n=0,$cid=0,$ctype=0,$cmoney=0){
		$card = M('card');
		$result = 0;
		$i=0;
		if($cid==0){
			if($cx_n>0){
				if($cmoney>0){
					$where = 'is_sell=0 and c_type='.$ctype.' and money='.$cmoney;
				}else{
					$where = 'is_sell=0 and c_type='.$ctype.'';
				}
				$lirs = $card->where($where)->order("RAND()")->limit($cx_n)->select();
				foreach($lirs as $lrs){
					$lid = $lrs['id'];
					$data = array();
					$data['id'] = $lid;
					$data['bid'] = $fid;
					$data['buser_id'] = $fuserid;
					$data['is_sell'] = 1;
					$data['b_time'] = time();
					
					$card->save($data);
					unset($data);
					$i++;
				}
				unset($lirs,$lrs);
			}
		}else{
			$where = array();
			$where['id'] = array('eq',$cid);
			$where['is_sell'] = array('eq',0);
			$where['c_type'] = array('eq',$ctype);
			if($cmoney>0){
				$where['money'] = array('eq',$cmoney);
			}
			$frs = $card->where($where)->find();
			if($frs){
				$lid = $frs['id'];
				$data = array();
				$data['id'] = $lid;
				$data['bid'] = $fid;
				$data['buser_id'] = $fuserid;
				$data['is_sell'] = 1;
				$data['b_time'] = time();
				$card->save($data);
				unset($data);
				$i=1;
			}
			unset($frs,$where);
		}
		unset($card);
		$result = $i;
		return $result;
	}
	
	public function upload_add(){
		$pctype = (int)$_SESSION['Phonectype'];
		if($pctype==0){
        	$title = "电话卡";
        }else{
        	$title = "体验卡";
        }
        $this->assign('viptitle',$title);
        $this->display();
	}
	
	public function upload_excel(){
		header("content-type:text/html;charset=utf-8");
		//载入文件上传类
		import("@.ORG.UploadFile");
		$upload = new UploadFile();
	
		//设置上传文件大小
		$upload->maxSize  = 1048576 * 5 ;// TODO 50M   3N 3292200 1M 1048576
	
		//设置上传文件类型
		$upload->allowExts  = explode(',','xls');
	
		//设置附件上传目录
		$upload->savePath =  './Public/Uploads/excel/';
	
	
		//设置上传文件规则
		//		$upload->saveRule = uniqid;
		$upload->saveRule = 'filename';
	
		//删除原图
		$upload->thumbRemoveOrigin = true;
		
		//替换原文件
		$upload->uploadReplace = true;
	
		if(!$upload->upload()) {
			//捕获上传异常
			$error_p=$upload->getErrorMsg();
			echo "<script>alert('".$error_p."');history.back();</script>";
		}else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
			$U_path=$uploadList[0]['savepath'];
			$U_nname=$uploadList[0]['savename'];
			$U_inpath=(str_replace('./Public/','__PUBLIC__/',$U_path)).$U_nname;
	
			$this->importExcel();
			exit;
		}
	}
	
	public function importExcel($type=0){
		$card=M('card');
// 		header("content-type:text/html;charset=utf-8");
		@include("phpExcelReader/Excel/reader.php");
		
		$xl_reader = new Spreadsheet_Excel_Reader ( );
		$xl_reader->setOutputEncoding('utf-8'); //GBK或者GB2312
		$xl_reader->read("./Public/Uploads/excel/filename.xls");
		
		$data=  $xl_reader->sheets[0]['cells'];
	
		if ($data){
			
// 			dump($data);exit;
			
			$ctype = (int)$_SESSION['Phonectype'];
		
			set_time_limit(0);
		$i=0;
		$ok=0;
		$nok=0;
		foreach ($data as $vo){
			$ca_numb = $vo[1];
			if (preg_match("/^[\x7f-\xff]+$/", $ca_numb)) {
				$i++;
				continue;
			}
			if ($i>=0){
				$card_data['card_no']=$vo[1];
				$cff = $this->check_cf_no($vo[1],0);
				if($cff==1){
					$nok++;
					$i++;
					continue;
				}
				$card_data['card_pw']=$vo[2];
				if(!empty($vo[3])){
					$dr_money = $vo[3];
				}else{
					$dr_money = 0;
				}
				$card_data['money']=$dr_money;
				if ($vo[4]=='是'){
					$is_sell=1;
				}else{
					$is_sell=0;
				}
				$c_time=explode('/', $vo[5]);
				$c_time_d = $c_time[0]-1;//excel 计算方式多一天
				$c_date=strtotime(date(''.$c_time[2].'-'.$c_time[1].'-'.$c_time_d.''));
				if(empty($c_date)){
					$c_date = time();
				}
				$b_time=explode('/', $vo[6]);
				$b_time_d = $b_time[0]-1;
				$b_date=strtotime(date(''.$b_time[2].'-'.$b_time[1].'-'.$b_time_d.''));
				if(empty($b_date)){
					$b_date = time();
				}
				if(!empty($vo[7])){
					$is_us = $vo[7];
				}else{
					$is_us = 0;
				}
				$card_data['is_sell']=$is_sell;
				$card_data['c_time']=time();
				$card_data['f_time']=$c_date;
				$card_data['l_time']=$b_date;
				$card_data['is_use']=$is_us;
				$card_data['c_type']=$ctype;
				
				$card->add($card_data);
				$ok++;
			}
			$i++;
		}
		$aurls='./Public/Uploads/excel/filename.xls';
		
		if(file_exists($aurls)){
			unlink($aurls);
		}
		
		$bUrl = __URL__.'/card_index';
		$this->_box(1,'成功导入'.$ok.'条记录，'.$nok.'条卡号存在重复！',$bUrl,1);
		
		}
	}

}
?>