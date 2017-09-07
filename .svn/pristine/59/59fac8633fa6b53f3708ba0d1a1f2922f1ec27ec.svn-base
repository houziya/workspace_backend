<?php
class UplevelAction extends CommonAction{
	
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
			$_SESSION['Urlszpass'] = 'Myssjinji';
			$bUrl = __URL__.'/MenberJinji';//会员晋级
			$this->_boxx($bUrl);
			break;
			case 2;
			$_SESSION['Urlszpass'] = 'Myssadminjinji';
			$bUrl = __URL__.'/adminmemberJJ';//后台晋级管理
			$this->_boxx($bUrl);
			break;
			default;
			$this->error(xstr('second_password_error'));
			exit;
		}
	}
	
	//前台会员晋级
	public function MenberJinji(){
		if ($_SESSION['Urlszpass'] == 'Myssjinji'){
			$where = array();
			$fck = M('fck');

	    	$uid = $_SESSION[C('USER_AUTH_KEY')];

			$frs = $fck->find($uid);
			$voo = array();
			$this->_levelConfirm($voo);
			$this->assign('level',$voo);

			$fee = M ('fee');
			$fee_rs =$fee->field('s9')->find();
			
			
			$promo = M('promo');
			$field  = '*';
			$map['uid'] = $uid;
            $list = $promo->where($map)->field($field)->order('id desc')->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$this->assign('frs',$frs);//数据输出到模板
			$this->assign('sx1',explode('|',$fee_rs['s9']));//数据输出到模板
			$v_title = $this->theme_title_value();
			$this->distheme('MenberJinji',$v_title[201],1);
			
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

	//前台晋级处理
	public function MenberJinjiConfirm(){
		if ($_SESSION['Urlszpass'] == 'Myssjinji'){
			$ulevel = (int)$_POST['uLevel'];
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$where['id'] = $uid;
			$promo = M('promo');
			$fck = D('Fck');
			$shouru = M ('shouru');
			$fck_rs = $fck->where($where)->find();
			if($fck_rs['is_pay'] == 0){
				$this->error(xstr('hint048'));
				exit;
			}
			$us_money = $fck_rs['agent_use'];
			
			$nowday=strtotime(date('Y-m-d'));
			$fee = D ('Fee');
			$fee_rs =$fee->field('*')->find();
			$regMoneyArr = explode('|',$fee_rs['s9']);
			$regPointArr = explode('|',$fee_rs['s2']);
			$regNameArr = explode('|',$fee_rs['s10']);

// 			$ulevel = $ulevel;
			$newlv = $ulevel-1;
			$oldlv  = $fck_rs['u_level']-1;
			
			if($newlv >= count($regMoneyArr))
			{
				$this->error(xstr('hint049').$regNameArr[count($regNameArr)-1]);
				exit;
			}
			
			//金额
			$new_m = $regMoneyArr[$newlv];
			$old_m = $regMoneyArr[$oldlv];
			$need_m = $new_m-$old_m;
			
			//股点
			$newPoint = $regPointArr[$newlv];
			$oldPoint = $regPointArr[$oldlv];
			$disPoint = $newPoint-$oldPoint;
			
			$ok = $us_money-$need_m;
			if($fck_rs['u_level'] >=$ulevel){
				$this->error(xstr('hint050'));
			}

 			if($fck_rs['u_level'] >= count($regMoneyArr)){
				$this->error(xstr('hint051'));
			}
			
			/*
			if(($newlv-$oldlv)>1){
				$this->error(xstr('hint058'));
			}*/

			$content = $_POST['content'];		//备注
			if (empty($content)){
// 				$this->error(xstr('hint057'));
// 				exit;
			}

			if ($ok < 0){
				$this->error(xstr('coin001_not_sufficient_funds_2'));
				exit;
			}

			$result = $fck->execute("UPDATE __TABLE__ set agent_use=agent_use-".$need_m." where `id`=".$uid." and agent_use=".$us_money);
			if($result) {
				$time=time();
				// 写入帐号数据
				$data = array();
				$data['uid']       			= $uid;
				$data['user_id']			= $fck_rs['user_id'];
				$data['money']				= $need_m;//补差额
				$data['u_level']			= $fck_rs['u_level'];//旧的
				$data['up_level']			= $ulevel;//新的
				$data['create_time']		= time();
				$data['pdt']				= time();
				$data['danshu']				= 0;
				$data['is_pay']				= 1;
				$data['user_name']			= "<font color=red>前台晋级</font>";;
				$data['u_bank_name']		= $fck_rs['bank_name'];
				$data['type']				= 0;
	            $promo->add($data);
				unset($data);
				
				$data = array();
				$data['uid'] = $uid;
				$data['user_id'] = $fck_rs['user_id'];
				$data['in_money'] = $need_m;
				$data['in_time'] = time();
				$data['in_bz'] = "会员升级";
				$shouru->add($data);
				unset($data);

				$mrs = $fck->where('id ='.$uid)->field('id,re_id,user_id,cpzj,re_path,p_path')->find();
				
				//统计单数
// 				$fck->xiangJiao($uid,$need_dl);
				//给推荐人添加推荐人数或单数
				//$fck->query("update __TABLE__ set `re_nums`=re_nums+1,re_cpzj=re_cpzj+".$fck_rs['cpzj']." where `id`=".$fck_rs['re_id']);
				
				//统计新增业绩，用来分红
				//$fee->query("update __TABLE__ set `a_money`=a_money+".$fck_rs['cpzj'].",`b_money`=b_money+".$fck_rs['cpzj']);
				//推荐奖
				//$fck->Bonus_b1_tjj($mrs['re_id'],$mrs['user_id'],$need_m,$fee_rs);
				//见点奖
            	//$fck->jiandianjiang($mrs['p_path'],$mrs['user_id'],$need_m,$fee_rs);
            	//s_pdt  升级日期
				//$fck->query("update __TABLE__ set u_level=".$ulevel.",cpzj=".$new_m.",agent_gp=agent_gp+".$need_m.",get_date=".$nowday.",wlf_money=wlf_money+".$need_f." where `id`=".$uid);
				$fck->execute("update __TABLE__ set u_level=".$ulevel.",get_date=".$nowday.",agent_gp=agent_gp+".$disPoint." where `id`=".$uid);
				// dump($fck);
				unset($fck,$fee,$promo,$shouru);
				$bUrl = __URL__.'/MenberJinji';
				$this->_box(1,xstr('hint052'),$bUrl,3);
			}else{
				$this->error(xstr('hint053'));
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

	public function MenberJinjishow(){
		//查看详细信息
		$promo = M('promo');
		$ID = (int) $_GET['Sid'];
		$where = array();
		$where['id'] = $ID;
		$srs = $promo->where($where)->field('user_name')->find();
		$this->assign('srs',$srs);
		unset($promo,$where,$srs);
		
		$v_title = $this->theme_title_value();
		$this->distheme('MenberJinjishow',$v_title[203],1);
	}
	
	//会员晋级管理
	public function adminmemberJJ($GPid=0){
		$this->_Admin_checkUser();
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
			$fck = M('fck');
			$UserID = $_REQUEST['UserID'];
			$u_sd = $_REQUEST['u_sd'];
			$uulv = (int)$_REQUEST['ulevel'];
			$ss_type = (int) $_REQUEST['type'];
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
			if(!empty($u_sd)){
				$map['is_lock'] =1;
            }
            if(!empty($uulv)){
            	$map['u_level'] =$uulv;
            }
			$map['is_pay'] = array('egt',1);
			$renshu = $fck->where($map)->count();//总人数
            //查询字段
            $field  = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $fck->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type. '&ulevel=' . $uulv;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage().','.$listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ,1);
            $this->assign('voo',$HYJJ);//会员级别
            $level = array();
			for($i=0;$i<count($HYJJ) ;$i++){
				$level[$i] = $HYJJ[$i+1];
			}
			$this->assign('level',$level);
            $this->assign('count',$renshu);
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            
            $v_title = $this->theme_title_value();
            $this->distheme('adminmemberJJ',$v_title[202]);
		}else{
			$this->error(xstr('data_error'));
			exit;
		}
	}
	
	//后台会员晋级
	public function adminMenberJinji(){
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
						$where = array();
			$fck = M('fck');
	    	$uid = $_GET['uid'];
			$frs = $fck->find($uid);
			if(!$frs){
				$this->error(xstr('data_error'));
				exit;
			}
			$voo = 0;
			$this->_levelConfirm($voo);

			$level = array();
			for($i=1;$i<=count($voo) ;$i++){
				$level[$i] = $voo[$i];
			}
			$this->assign('level',$level);


			$fee = M ('fee');
			$fee_rs =$fee->field('s1,s2')->find();
			$s1 =explode('|',$fee_rs['s1']);
			$s2 =explode('|',$fee_rs['s2']);

			$this->assign('sx1',$s2);

			$promo = M('promo');
			$field  = '*';
			$map['uid'] = $uid;
            $list = $promo->where($map)->field($field)->order('id desc')->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================

			$this->assign('uid',$uid);
			$this->assign('le',$voo);
			$this->assign('cleve',$frs['u_level']);
			$this->assign('frs',$frs);//数据输出到模板
			
			$v_title = $this->theme_title_value();
			$this->distheme('adminMenberJinji',$v_title[202],1);
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

	//后台晋级处理
	public function adminMenberJinjiConfirm(){
	$this->_Admin_checkUser();
		if ($_SESSION['Urlszpass'] == 'Myssadminjinji'){
			$ulevel = (int)$_POST['uLevel'];
			$uid = (int)$_POST['uid'];
			$js_yj = (int)$_POST['js_yj'];
			
			$promo = M('promo');
			$fck = D('Fck');
			$fee = D ('Fee');
			$nowday=strtotime(date('Y-m-d'));

			$where['id'] = $uid;
			$fck_rs = $fck->where($where)->find();
			if(!$fck_rs){
				$this->error(xstr('hint054'));
				exit;
			}
			
			$fee_rs =$fee->field('*')->find();

			$newlv = $ulevel-1;
			$oldlv  = $fck_rs['u_level']-1;
			
			if($fck_rs['u_level'] >=$ulevel){
				$this->error(xstr('hint055'));
			}

// 			if($fck_rs['u_level'] ==2){
// 				$this->error(xstr('hint051'));
// 			}
			if($ulevel==$fck_rs['u_level']){
				$this->error(xstr('hint056'));
			}

			$content = $_POST['content'];		//备注
			if (empty($content)){
// 				$this->error(xstr('hint057'));
// 				exit;
			}

			// 写入帐号数据
			$data['uid']				= $uid;
			$data['user_id']			= $fck_rs['user_id'];
			$data['money']				= 0;//补差额
			$data['u_level']			= $fck_rs['u_level'];//旧的
			$data['up_level']			= $ulevel;//新的
			$data['create_time']		= time();
			$data['pdt']				= time();
			$data['danshu']				= 0;
			$data['is_pay']				= 1;
			$data['user_name']			= " <font color=red>后台升降级别</font>";
			$data['u_bank_name']		= 0;
			$data['type']				= $js_yj;
            $result = $promo->add($data);
			unset($data);
			if($result) {
				
				$fck->query("update __TABLE__ set u_level=".$ulevel." where `id`=".$uid);
				
				unset($fck,$fee,$promo);
				$bUrl = __URL__.'/adminMenberJinji/uid/'.$uid;
				$this->_box(1,xstr('hint059'),$bUrl,3);
			}else{
				$this->error(xstr('hint060'));
				exit;
			}
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

}
?>