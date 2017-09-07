<?php
class PublicAction extends CommonAction {
   public function _initialize() {
      parent::_initialize();
      header("Content-Type:text/html; charset=utf-8");
      $this->_inject_check(1);//调用过滤函数
      $this->_Config_name();//调用参数
   }

            //过滤查询字段
   function _filter(&$map){
      $map['title'] = array('like',"%".$_POST['name']."%");
   }
            // 顶部页面
   public function top() {
      C('SHOW_RUN_TIME',false);			// 运行时间显示
      C('SHOW_PAGE_TRACE',false);
      $fck = M('fck');
      $fwhere = array();
      $fwhere['ID'] = $_SESSION[C('USER_AUTH_KEY')];
      $frs = $fck->where($fwhere)->field('*')->find();
      $uLevl=$this->_levelConfirm($HYJJ,1);
      $this->assign('HYJJ',$HYJJ);
      $this->assign('fck_rs',$frs);
      $this->display();
   }
            // 尾部页面
   public function footer() {
      C('SHOW_RUN_TIME',false);			// 运行时间显示
      C('SHOW_PAGE_TRACE',false);
      $this->display();
   }
            // 菜单页面
   public function menu() {
      $this->_checkUser();
      $map = array();
      $id = $_SESSION[C('USER_AUTH_KEY')];
      $field = '*';

      $map = array();
      $map['s_uid']   = $id;   //会员ID
      $map['s_read'] = 0;     // 0 为未读
      $info_count = M ('msg') -> where($map) -> count(); //总记录数
      $this -> assign('info_count',$info_count);

      $fee = M('fee');
      $fee_rs = $fee->field('i4,i2,s10')->find();
      $this->assign('i4',$fee_rs['i4']);
      $this->assign('i2',$fee_rs['i2']);

      $fck = M('fck');
      $fwhere = array();
      $fwhere['ID'] = $_SESSION[C('USER_AUTH_KEY')];
      $frs = $fck->where($fwhere)->field('*')->find();
               //dump($frs);
      $HYJJ = '';
      $this->_levelConfirm($HYJJ,1);

      $this->assign('voo',explode('|',$fee_rs['s10']));
      $arss = $this->_cheakPrem();
      $this->assign('arss',$arss);

      $this->assign('fck_rs',$frs);
      $this->display('menu');

   }

            // 后台首页 查看系统信息
   public function main() {

      ob_clean();
      set_time_limit(0);
      $this->_checkUser();
      $this->_Config_name();//调用参数
      C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
      C ( 'SHOW_PAGE_TRACE', false );
      $fck = D ('Fck');
      $form=M('form');
      $Msg=M('Msg');
      $id = $_SESSION[C('USER_AUTH_KEY')];
      $field = '*';
      $fck_rs = $fck -> field($field) -> find($id);
      $this->assign('fck_rs',$fck_rs);
      $arss = $this->_cheakPrem();  //权限函数
      $this->assign('arss',$arss);	
               //首页图片
      $fee = M('fee');
      $fee_rs = $fee->field('*')->find();
      $str20 = $fee_rs['str20'];
      $str21 = $fee_rs['str21'];
      $str22 = $fee_rs['str22'];
      $str23 = $fee_rs['str23'];
      $str24 = $fee_rs['str24'];
      $str25 = $fee_rs['str25'];
      $str7 = $fee_rs['str7'];
      $str8 = $fee_rs['str8'];
      $str11 = $fee_rs['str11'];
      $s6 = $fee_rs['s6'];
      $s1 = $fee_rs['s1']/100;
      $s2=explode("|", $fee_rs['s2']);
      $all_img = $str21."|".$str22."|".$str23;
      $this->assign('all_img',$all_img);
      if(empty($str21)){
         $str21 = __PUBLIC__."/Images/tirl_tp.jpg";
      }
      $this->assign('str7',$fee_rs['str7']);
      $this->assign('str8',$fee_rs['str8']);
      $this->assign('zrs',$fee_rs['str11']);
      $this->assign('str21',$str21);
      $this->assign('str24',$str24);
      $this->assign('str25',$str25);
      $this->assign('s2',$s2);
      $this->assign('s6',$s6);
      $this->assign('s1',$s1);

      $this->assign('i4',$fee_rs['i4']);
      $this->aotu_clearings();

      $count_msg=$Msg->where("f_read=0 and s_read=0 and (f_uid=".$id." or s_uid=".$id.")")->count();
      $this->assign('count_msg',$count_msg);
      $count_msg=$Msg->where("f_read=0")->count();
      $this->assign('count_f',$count_msg);
      $count_msg=$Msg->where("s_read=0")->count();
      $this->assign('count_s',$count_msg);


               //

      $whid['id']=$id;
               //$fck=M('fck');

      $wherep['re_id']=$id;
      $wherep['yuan_gupiao']=1;
      $zhitui=$fck->where($wherep)->count();

      $wherep2['re_path']=array('like','%,'.$id.'%');
      $wherep2['yuan_gupiao']=1;
      $tuandui=$fck->where($wherep2)->count();

      if($tuandui>199 and $zhitui>19)
      {
         $data['jingli']=0;
         $data['zongjian']=0;
         $data['dongshi']=1;
      }
      elseif ($tuandui>49 and $zhitui>9)
      {
         $data['jingli']=0;
         $data['zongjian']=1;
         $data['dongshi']=0;
      }
      elseif ($tuandui>29 and $zhitui>4)
      {
         $data['jingli']=1;
         $data['zongjian']=0;
         $data['dongshi']=0;
      }
      $fck->where($whid)->save($data);
               //

               //即将得到的利息
      $future_get=M('cash')->where("is_cancel=0 and type=0 and is_out=0 and is_done=0 and uid=".$_SESSION[C('USER_AUTH_KEY')])->field('money,rdt')->find();
               //单位时间
      $begin_time=$future_get['rdt'];
      $per_time=$fee_rs['str21']*24*60+$fee_rs['str22']*60+$fee_rs['str23'];
               //封顶时间
      $feng=$fee_rs['str24']*24*60+$fee_rs['str25']*60+$fee_rs['str26'];
      $feng_time=$begin_time+$feng*60;

      if($future_get){
         $nowtime=time();
         if($nowtime>=$feng_time){
            $nowtime=$feng_time;
            $s1=$fee_rs['s1']/100; //单位时间的利息
            $cha_time=($nowtime-$begin_time)/($per_time*60);
            $num=floor($cha_time);  //单位时间的倍数

         }else{
            $s1=$fee_rs['s1']/100; //单位时间的利息
            $cha_time=($nowtime-$begin_time)/($per_time*60);
            $num=floor($cha_time);  //单位时间的倍数
         }
         $money_hong=$future_get['money']+$future_get['money']*$num*$s1;
         $lixi=$future_get['money']*$num*$s1;
      }else{
         $money_hong=0;
      }
      $this->assign('money_hong',$money_hong);
      $fck->B1_fh_perday();
               //jieshu index

      $map = array();
      $map['status'] = array('eq',1);
      $map['type'] = array('eq',1);
      $field  = '*';
      $nlist = $form->where($map)->field($field)->order('baile desc,id desc')->limit(10)->select();
      $this->assign('f_list',$nlist);//数据输出到模板


               //会员级别
      $fck = M('fck');
      $urs = $fck -> where('id='.$id)->field('*') -> find();
      $this -> assign('fck_rs',$urs);//总奖金

      $z_cou = (int)$fck->where('p_path like "%,'.$urs['id'].',%" and is_pay>0')->count();
      $this -> assign('z_cou',$z_cou);//总奖金




      $sname = $_SERVER['SERVER_NAME'];
               // $tg = "http://m5.zzqun.net".__APP__."/";
      $tg = "http://yunkelm.com".__APP__."/Reg/us_reg/rid/".$_SESSION[C('USER_AUTH_KEY')]."?from=".$fck_rs['user_id'];
      $this->assign('tg',$tg);
      $cash=M('cash');
               //求购信息
               //查询字段
      $field  = '*';
               //=====================分页开始==============================================
               // $map="type=0 and bid=".$id;
      $map=array();
      $map['type']=0;
      $map['bid']=$id;
      import ( "@.ORG.ZQPage" );  //导入分页类
      $count = $cash->where($map)->count();//总页数
      $listrows = C('ONE_PAGE_RE');//每页显示的记录数
      $listrows = 20;//每页显示的记录数
      $page_where = $map ;//分页条件
      $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
               //===============(总页数,每页显示记录数,css样式 0-9)
      $show = $Page->show();//分页变量

      $this->assign('bpage',$show);//分页变量输出到模板
      $buylist = $cash->where($map)->field($field)->order('rdt desc')->page($Page->getPage().','.$listrows)->select();
      $this->assign('buylist',$buylist);

               //求购信息
               //查询字段
      $field  = '*';
               //=====================分页开始==============================================
               // $map1="type=1 and sid=".$id;
      $map1=array();
      $map1['type']=1;
      $map1['sid']=$id;
      import ( "@.ORG.ZQPage" );  //导入分页类
      $count1 = $cash->where($map1)->count();//总页数
      $listrows = C('ONE_PAGE_RE');//每页显示的记录数
      $listrows = 20;//每页显示的记录数
      $page_where1 = $map1 ;//分页条件
      $Page = new ZQPage($count1, $listrows, 1, 0, 3, $page_where1);
               //===============(总页数,每页显示记录数,css样式 0-9)
      $show2 = $Page->show();//分页变量
      $this->assign('spage',$show2);//分页变量输出到模板
      $selllist = $cash->where($map1)->field($field)->order('rdt desc')->page($Page->getPage().','.$listrows)->select();
      $this->assign('selllist',$selllist);

               //即将得到的利息


      $map22 = array();
      $map22['status'] = 1;
      $map22['type'] = array('eq','1');

               //=====================分页开始==============================================
      import ( "@.ORG.ZQPage" );  //导入分页类
      $count = $form->where($map22)->count();//总页数
      $listrows = C('ONE_PAGE_RE');//每页显示的记录数
      $listrows = 5;//每页显示的记录数
      $Page = new ZQPage($count,$listrows,1);
               //===============(总页数,每页显示记录数,css样式 0-9)
      $show = $Page->show();//分页变量
      $this->assign('page',$show);//分页变量输出到模板
      $list = $form->where($map22)->field($field)->order('baile desc,id desc')->page($Page->getPage().','.$listrows)->select();
      $this->assign('list',$list);//数据输出到模板
               //=================================================

      $nclass = $this->news_class();
      $this->assign('nclass',$nclass);

               //注册不排单锁定 
      $cas=M("cash");
      $pd=$cas->where("uid=".$_SESSION[C('USER_AUTH_KEY')])->getfield('rdt');
      $nt=time();
      $zt=$fck_rs['rdt'];
      if (!$pd)
      {
                  //echo '23';
         if($nt-$zt>86400)
         {
            $dats['is_lock']=1;
            $whe['id']=$_SESSION[C('USER_AUTH_KEY')];
                     //$fck->where($whe)->save($dats);
         }
      }

               //超时不执行锁定
      $whl['is_pay']=1;
      $whl['type']=1;
      $whl['is_get']=0;
      $whl['uid']=$_SESSION[C('USER_AUTH_KEY')];

      $pdl=$cas->where("uid=".$_SESSION[C('USER_AUTH_KEY')])->select();
      foreach ($pdl as $pdx)
      {
         if($pdx['pdt']-time()>172800)
         {
                     //suoding
            $whls[id]=$pdx['b_user_id'];
            $dats['is_lock']=1;
            $fck->where($whe)->save($dats);
                     //chongpai
            $whc['id']=$pdx['id'];
            $dac['is_pay']=0;
            $dac['is_get']=0;
            $dac['pdt']='';
            $cas->$where($whc)->save($dac);
                     //shanchu
            $whd['id']=$pdx['match_id'];
            $cas->$where($whc)->delete();

         }
      }

	              unset($map);
      $map['re_id']=$_SESSION[C('USER_AUTH_KEY')];
      $count=M('fck')->where($map)->count();
      $tuandui_arr=M('fck')->where($map)->field('id')->select();
      $id_arr[]=$map['re_id'];
      foreach($tuandui_arr as $v){
         $id_arr[]=$v['id'];
      }
      $map['re_id']=array('in',$id_arr);
      $tuandui_count=M('fck')->where($map)->count();

              unset($map);
	
      $map['re_id']=$_SESSION[C('USER_AUTH_KEY')];
	  $map['zjj'] = array('gt',0);
	  $map['_logic'] = 'and';
      $count_z=M('fck')->where($map)->count();
      $tuandui_arr=M('fck')->where($map)->field('id','zjj')->select();
      $id_arr[]=$map['re_id'];
      foreach($tuandui_arr as $v){
         $id_arr[]=$v['id'];
      }
	   $map = array();
      $map['re_id']=array('in',$id_arr);
	    $map['zjj'] = array('gt',0);
	  $map['_logic'] = 'and';
      $tuandui_count_z=M('fck')->where($map)->count();

      $this->assign('tuijian_count',$count);
      $this->assign('tuandui_count',$tuandui_count);
	   $this->assign('tuijian_count_z',$count_z);
      $this->assign('tuandui_count_z',$tuandui_count_z);
      $this->display();


   }


   public function mx(){
      $x1=$_GET['id'];

      $cash=M('cash');
      $field  = '*';
      $yixi=$cash->where('id='.$x1)->select();

               //$this->assign('tp',$yixi['type']);
      $this->assign('yixiu',$yixi);


      $this->display();
   }





   public function news_class(){
      $nclass = array();
      $nclass[1] = xstr('subWindowTitle_notype_001');
               // $nclass[2] = "学习乐园";
      return $nclass;
   }
            // 用户登录页面
   public function buys(){

      $fee = M('fee');
      $fee_rs = $fee->field('s2')->find();

      $s2=explode("|", $fee_rs['s2']);

      $this->assign('s2',$s2);
         unset($map);
			$map['buser_id']=$_SESSION['loginUseracc'];
			$map['is_use']=0;
			$count = M('card')->where($map)->count();//总页数
         $this->assign('card_num',$count);

      $this->display('buys');
   }

   public function sells(){
      $this->display('sells');
   }

   public function login() {
      $fee = M('fee');
      $fee_rs = $fee->field('*')->find();
      $this->assign('fflv',$fee_rs['str21']);
      $this->assign('qlist',explode('|',$fee_rs['str7']));
      $this->assign('qname',explode('|',$fee_rs['str8']));

      unset($fee,$fee_rs);
      $this->display('login');
   }

   public function index()
   {
               //如果通过认证跳转到首页
      redirect('/index.php?s=/Public/main');
   }

            // 用户登出
   public function LogOut(){
      $_SESSION = array();
               //unset($_SESSION);
      $this->assign('jumpUrl',__URL__.'/login/');
      $this->success(xstr('exit_success'));
   }

            // 登录检测
   public function checkLogin() {
      if(empty($_POST['account'])) {
         $this->error(xstr('please_input_account'));
      }elseif (empty($_POST['password'])){
         $this->error(xstr('please_input_password'));
      }elseif (empty($_POST['verify'])){
         $this->error(xstr('please_input_verify_code'));
      }
      $fee = M ('fee');
               //生成认证条件
      $map            =   array();
               // 支持使用绑定帐号登录
      $map['user_id']	   = $_POST['account'];
               		//$map['nickname'] = $_POST['account']; 
					$map['user_tel'] = $_POST['account'];  //用户名也可以登录
               		$map['_logic']    = 'or';
               //$map['_complex']    = $where;
               //$map["status"]	=	array('gt',0);
      if($_SESSION['verify'] != md5($_POST['verify'])) {
         $this->error(xstr('verify_code_error'));
      }

      import ( '@.ORG.RBAC' );
      $fck = M('fck');
      $field = 'id,user_id,password,user_tel,is_pay,is_lock,nickname,user_name,is_agent,user_type,last_login_time,login_count,is_boss';
      $authInfo = $fck->where($map)->field($field)->find();
               //使用用户名、密码和状态的方式进行认证
               // dump($fck);exit;
      if(false == $authInfo) {
         $this->error(xstr('account_is_noexists_or_locked'));
      }else {
         if($authInfo['password'] != md5($_POST['password'])) {
            $this->error(xstr('password_error'));
            exit;
         }
                  // if ($authInfo['is_pay'] <1){
                  // 	$this->error('用户尚未开通，暂时不能登录系统！');
                  // 	exit;
                  // }
         if ($authInfo['is_lock']!=0){
            $this->error(xstr('hint001'));
            exit;
         }
         $_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];
         $_SESSION['loginUseracc']		=	$authInfo['user_id'];//用户名
         $_SESSION['loginNickName']		=	$authInfo['nickname'];//会员名
         $_SESSION['loginUserName']		=	$authInfo['user_name'];//开户名
         $_SESSION['lastLoginTime']	=	$authInfo['last_login_time'];
                  //$_SESSION['login_count']	    =	$authInfo['login_count'];
         $_SESSION['login_isAgent']	    =	$authInfo['is_agent'];//是否受理中心
         $_SESSION['UserMktimes']        = mktime();
                  //身份确认 = 用户名+识别字符+密码
         $_SESSION['login_sf_list_u']    = md5($authInfo['user_id'].'wodetp_new_1012!@#'.$authInfo['password'].$_SERVER['HTTP_USER_AGENT']);

                  //登录状态
         $user_type = md5($_SERVER['HTTP_USER_AGENT'].'wtp'.rand(0,999999));
         $_SESSION['login_user_type'] = $user_type;
         $where['id'] = $authInfo['id'];
         $fck->where($where)->setField('user_type',$user_type);
                  //			$fck->where($where)->setField('last_login_time',mktime());
                  //管理员

         $parmd = $this->_cheakPrem();
         if($authInfo['id'] == 1||$parmd[11]==1) {
            $_SESSION['administrator']		=	1;
         }else{
            $_SESSION['administrator']		=	2;
         }

                  //			//管理员
                  //			if($authInfo['is_boss'] == 1) {
                  //            	$_SESSION['administrator'] =	1;
                  //            }elseif($authInfo['is_boss'] == 2){
                  //            	$_SESSION['administrator'] = 3;
                  //            }elseif($authInfo['is_boss'] == 3){
                  //                $_SESSION['administrator']  = 4;
                  //            }elseif($authInfo['is_boss'] == 4){
                  //                $_SESSION['administrator'] = 5;
                  //            }elseif($authInfo['is_boss'] == 5){
                  //                $_SESSION['administrator'] =   6;
                  //            }elseif($authInfo['is_boss'] == 6){
                  //                $_SESSION['administrator'] =   7;
                  //            }else{
                  //				$_SESSION['administrator'] = 2;
                  //			}

         $fck->execute("update __TABLE__ set last_login_time=new_login_time,last_login_ip=new_login_ip,new_login_time=".time().",new_login_ip='".$_SERVER['REMOTE_ADDR']."' where id=".$authInfo['id']);

                  // 缓存访问权限
         RBAC::saveAccessList();
         $this->success(xstr('login_success'));
      }
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
         $_SESSION['DLTZURL02'] = 'updateUserInfo';
         $bUrl = __URL__.'/updateUserInfo';//修改资料
         $this->_boxx($bUrl);
         break;
      case 2:
         $_SESSION['DLTZURL01'] = 'password';
         $bUrl = __URL__.'/password';//修改密码
         $this->_boxx($bUrl);
         break;
      case 3:
         $_SESSION['DLTZURL01'] = 'pprofile';
         $bUrl = __URL__.'/pprofile';//修改密码
         $this->_boxx($bUrl);
         break;
      case 4:
         $_SESSION['DLTZURL01'] = 'OURNEWS';
         $bUrl = __URL__.'/News';//修改密码
         $this->_boxx($bUrl);
         break;
default;
$this->error(xstr('second_password_error'));
break;
      }
   }

   public function verify()
   {
      ob_clean();
      $type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
      import("@.ORG.Image");
      Image::buildImageVerify();
   }


   public function aotu_clearings(){
      set_time_limit(0);
      $fck = D ('Fck');
      $fee = M ('fee');
      $gouwu=M ('gouwu');
      $nowday = strtotime(date('Y-m-d'));
      $now_dtime = strtotime(date("Y-m-d"));
      if(empty($_SESSION['auto_cl_ok'])||$_SESSION['auto_cl_ok']!=$nowday){
         $js_c = $fee->where('id=1 and f_time<'.$nowday)->count();
         if($js_c>0){
                     // //每天剩余天数减1
                     // $fck->kouDay();
                     //經理分紅
                     //$fck->B1_fh_perday();

         }
         $_SESSION['auto_cl_ok'] = $nowday;
      }
      unset($fck,$fee);
   }
            //每日自动结算
   public function aotu_clearings2(){
      set_time_limit(0);
      $fck = D ('Fck');
      $fee = M ('fee');
      $yesday = strtotime(date('Y-m-d'))-24*60*60;
      if(empty($_SESSION['auto_gl_ok'])||$_SESSION['auto_gl_ok']!=$yesday){
         $js_c = $fee->where('id=1 and gd_time<'.$yesday)->count();
         if($js_c>0){
                     //經理分紅
            $fck->gd_fenghong();
         }
         $_SESSION['auto_gl_ok'] = $yesday;
      }
      unset($fck,$fee);
   }
            //免登在线收款
   public function olPay()
   {
      if(array_key_exists('muid',$_REQUEST))
      {
         $userUID = trim($_REQUEST['muid']);
         if(strlen($userUID) > 0)
         {
            $userInfo = M('Fck')->field('id,user_id,user_name')->where(array('user_id'=>$userUID,'is_pay'=>array('gt',0)))->find();
            if($userInfo)
            {
               $_SESSION['No_Login_Pay_System_User_id'] = $userInfo['id'];
               $_SESSION['No_Login_Pay_System_User_uid'] = $userInfo['user_id'];
               $this->assign('userInfo',$userInfo);
               $this->display();
               exit;
            }
         }
      }
      unset($_SESSION['No_Login_Pay_System_User_id'],$_SESSION['No_Login_Pay_System_User_uid']);
      header('location:'.U('/Public/main'));
   }



            //免登在线收款处理
   public function olPayAC()
   {
      if(!empty($_SESSION['No_Login_Pay_System_User_id']) && !empty($_SESSION['No_Login_Pay_System_User_uid']))
      {
         if(array_key_exists('cfmBtn',$_POST) && array_key_exists('payType',$_POST) && array_key_exists('payNum',$_POST))
         {
            $payType = intval($_POST['payType']);
            if($payType<1 || $payType>3)
            {
               $this->error(xstr('please_select_a_pay_type'));
               exit;
            }
            $payMoney = floatval($_POST['payNum']);
            if($payMoney<0.01)
            {
               $this->error(xstr('hint002'));
               exit;
            }
            $userInfo = M('Fck')->field('id,user_id,user_name')->where(array('id'=>$_SESSION['No_Login_Pay_System_User_id'],'user_id'=>$_SESSION['No_Login_Pay_System_User_uid']))->find();
            if($userInfo)
            {
               $orderID = '100';
               while(true)
               {
                  $Order = date("YmdHis").rand(100,999);
                  $chkID = M('Remit')->where(array('orderid'=>$Order))->count();
                  if(!$chkID)
                  {
                     $orderID .= $Order;
                     unset($Order);
                     break;
                  }
               }
               $data = array();
               $data['uid']     = $userInfo['id'];
               $data['user_id'] = $userInfo['user_id'];
               $data['amount'] = $payMoney;
               $data['kh_money'] = $payMoney;
               $data['or_time'] = mktime();
               $data['orderid'] = $orderID;
               $result = M('Remit')->add($data);
               unset($data);
               if($result)
               {
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
                  $pAction->send($orderID,$payMoney);
                  exit;
               }
               else
               {
                  $this->error(xstr('hint003'));
                  exit;
               }
            }
         }
      }
      unset($_SESSION['No_Login_Pay_System_User_id'],$_SESSION['No_Login_Pay_System_User_uid']);
      header('location:'.U('/Public/main'));
   }


           /******************************
        服务器异步通知页面方法
        其实这里就是将notify_url.php文件中的代码复制过来进行处理

           *******************************/
    public  function notifyurl(){

               //这里还是通过C函数来读取配置项，赋值给$alipay_config
      $alipay_config=C('alipay_config');
      $alipay_config['partner']=$alipay_config['partner'];
      $alipay_config['key']=$alipay_config['key'];
               //计算得出通知验证结果
       Vendor('Alipay.Corefunction');
       Vendor('Alipay.Md5function');
       Vendor('Alipay.AlipayNotify');
      $alipayNotify = new AlipayNotify($alipay_config);
      $verify_result = $alipayNotify->verifyNotify();
      if($verify_result) {
                  //验证成功
                  //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
         $out_trade_no   = $_POST['out_trade_no'];      //商户订单号
         $trade_no       = $_POST['trade_no'];          //支付宝交易号
         $trade_status   = $_POST['trade_status'];      //交易状态
         $total_fee      = $_POST['total_fee'];         //交易金额
         $notify_id      = $_POST['notify_id'];         //通知校验ID。
         $notify_time    = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
         $buyer_email    = $_POST['buyer_email'];       //买家支付宝帐号；
         $parameter = array(
            "out_trade_no"     => $out_trade_no, //商户订单编号；
            "trade_no"     => $trade_no,     //支付宝交易号；
            "total_fee"     => $total_fee,    //交易金额；
            "trade_status"     => $trade_status, //交易状态
            "notify_id"     => $notify_id,    //通知校验ID。
            "notify_time"   => $notify_time,  //通知的发送时间。
            "buyer_email"   => $buyer_email,  //买家支付宝帐号；
         );
         if($_POST['trade_status'] == 'TRADE_FINISHED') {
                     //
         }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {                           if(!checkorderstatus($out_trade_no)){
            orderhandle($parameter); //进行订单处理，并传送从支付宝返回的参数；
         }
         }
         echo "success";        //请不要修改或删除
      }else {
                  //验证失败
         echo "fail";
      }    
    }
   public function send_code_msg(){
      $phone=I('phone');
      $code=getRandChar();
      $ip=get_real_ip();
      $map['phone']=$phone;
     // $sql="select * from "
      $sign="【".C('sms_sign')."】";
      $uid=C('sms_uid');
      $key=C('sms_key');
      $content="您好，您的验证码：".$code."，如果不是本人操作，请忽略".$sign;
      $url="http://utf8.sms.webchinese.cn/?Uid=$uid&Key=$key&smsMob=$phone&smsText=$content";

      //echo $url;
      //die();
      $res=file_get_contents($url);
      $_SESSION['Mcode']=$code;
      if($res==1){
         $data['phone']=$phone;
         $data['code']=$code;
         $data['ip']=$ip;
         $data['create_date']=date('Y-m-d H:i:s',time());
         M("phone_sms")->add($data);
         echo 1;
      //   $this->ajaxReturn(array('success'=>1,'info'=>'发送成功'));
      }else{
         echo 0;
         //$this->ajaxReturn(array('success'=>0,'info'=>'发送失败'));
      }

   }

}
?>
