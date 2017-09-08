<?php
class GouwuAction extends CommonAction{

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
			$this->display('../Public/cody');
		    exit;
		}else{
		    $this->error(xstr('second_password_error'));
		    exit;
		}
    }

    public function update_dingdan(){
    	$this->_Admin_checkUser();//后台权限检测
		$gid=$_REQUEST['gid'];
		$this->assign("gid",$gid);
		$dingdan=$_REQUEST['dingdan'];
		import ( "@.ORG.KuoZhan" );  //导入扩展类
        $KuoZhan = new KuoZhan();
        if ($KuoZhan->is_utf8($dingdan) == false){
            $dingdan = iconv('GB2312','UTF-8',$dingdan);
        }
		$this->assign("dingdan",$dingdan);
		$this->display();
    }

    public function update_dingdanAC(){
    	$this->_Admin_checkUser();//后台权限检测
		$gid=$_REQUEST['gid'];
		$dingdan=$_REQUEST['image'];
		$tihuo=M('tihuo');
		$data=array();
		$data['ccxhbz']=$dingdan;
		$data['id']=$gid;
		$result=$tihuo->save($data);
		// dump($result);
		if($result){
			echo "<script language='javascript'>window.parent.location.reload();</script>";
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
				$bUrl = __URL__ . '/pro_index';
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlszUserpass'] = 'MyssWuliuList';
				$bUrl = __URL__ . '/adminLogistics';
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlszUserpass'] = 'ACmilan';
				$bUrl = __URL__ . '/Buycp';
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlszUserpass'] = 'manlian';//求购代币
				$bUrl = __URL__ . '/BuycpInfo';
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlszUserpass'] = 'manlian';//求购代币
				$bUrl = __URL__ . '/TihuoInfo';
				$this->_boxx($bUrl);
				break;	
			case 6;
				$_SESSION['UrlszUserpass'] = 'MyssWuliuList';
				$bUrl = __URL__ . '/adminLogistics1';
				$this->_boxx($bUrl);
				break;	
			default;
				$this->error(xstr('second_password_error'));
				break;
		}
	}

	public function adminLogistics1(){
		$this->_Admin_checkUser();//后台权限检测
		//物流管理
		if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
			$shopping = M ('gouwu');
			$product = M('product');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['type'];
            $map = array();
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$map['user_id'] = array('like',"%".$UserID."%");
				$UserID = urlencode($UserID);
			}
			if($ss_type==0){
				$map['ispay'] = array('egt',0);
			}elseif($ss_type==1){
				$map['ispay'] = array('eq',0);
				$map['isfh'] = array('eq',0);
			}elseif($ss_type==2){
				$map['ispay'] = array('eq',0);
				$map['isfh'] = array('eq',1);
			}elseif($ss_type==3){
				$map['ispay'] = array('eq',1);
			}
            //查询字段
            $field   = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $shopping->where($map)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		    $page_where = 'UserID='.$UserID.'&type='.$ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $shopping ->where($map)->field($field)->page($Page->getPage().','.$listrows)->order('user_id desc,pdt desc')->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            foreach($list as $vv){
            	$ttid = $vv['did'];
            	$trs = $product->where('id='.$ttid)->find();
            	$voo[$ttid] = $trs['name'];
            }
            $this->assign('voo',$voo);

            //=======每月已发货信息=====================
            //查询字段
            $field   = "FROM_UNIXTIME(fhdt,'%Y-%m') as m,sum(shu) as sumNum,sum(cprice) as sumPri";
            $where='isfh=1';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            // $count = $shopping->where($where)->field($field)->group('m')->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		    // $page_where = 'UserID='.$UserID.'&type='.$ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page2',$show);//分页变量输出到模板
            $list2 = $shopping ->where($where)->field($field)->page($Page->getPage().','.$listrows)->group('m')->select();
            $this->assign('list2',$list2);//数据输出到模板
            //=================================================

			foreach ($list2 as $val) {
				$sum['0']+=$val['sumNum'];
				$sum['1']+=$val['sumPri'];
			}
            $this->assign('sum',$sum);
            //====================================================
			$v_title = $this->theme_title_value();
			$this->distheme('adminLogistics1',$v_title[72]);
			
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

	public function UpdateDay(){
		$this->_Admin_checkUser();//后台权限检测
		//物流管理
		if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
			$shopping = M ('gouwu');
			$product = M('product');
            $tabledb=$_REQUEST['tabledb'];
            // dump($tabledb);exit;
            foreach ($tabledb as $id) {
            	# code...
            	$data=array();
	            $data['id']=$id;
	            $dayid='Day'.$id;
	            $day=$_POST[$dayid];
	            $data['ccxhbz']=$day;
	            $result=$shopping->save($data);
            }
            
            // dump($shopping);exit;
            if($result){
            	$bUrl = __URL__.'/adminLogistics1';
	            $this->_box(1,'修改成功！',$bUrl,1);
	            exit;
            }else{
            	$this->error('修改错误!');
				exit;
            }
			
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

    public function BuycpInfoAC(){
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $XGid = $_POST['tabledb'];
        // dump($XGid);
        if (!isset($XGid) || empty($XGid)){
            $bUrl = __URL__.'/TihuoInfo';
            $this->_box(0,'请选择货物！',$bUrl,1);
            exit;
        }
        switch ($action){
            case '确定收货';
                $this->_BuycpInfoACDone($XGid);
                break;
           
	        default;
	            $bUrl = __URL__.'/BuycpInfo';
	            $this->_box(0,'没有该货物！',$bUrl,1);
	            break;
        }
    }

	private function _BuycpInfoACDone($XGid){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'manlian'){
            $shopping = M ('tihuo');
            //未发货的不能确定发货
            $where = array();
            $where['id'] = array ('in',$XGid);
            $where['ispay'] = array ('eq',0);
            $where['isfh'] = array ('eq',1);

            $valuearray = array(
            	'ispay' => '1',
            	'isfh' => '1',
            	'okdt' => mktime()
            );

            $result=$shopping->where($where)->setField($valuearray);
            unset($shopping,$where);
            if($result){
            	$bUrl = __URL__.'/TihuoInfo';
	            $this->_box(1,'确认收货成功！',$bUrl,1);
	            exit;
            }else{
            	$this->error('请确认是否发货或已确认收货!');
            	exit;
            }
            
        }else{
            $this->error(xstr('error_signed'));
            exit;
        }
    }

		public function TihuoInfo() {//购买信息
		$cp = M('product');
		$fck = M('fck');
		$tihuo = M('tihuo');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$map['uid'] = $id;
		// $map['guquan'] = array('neq',1);
		 //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $tihuo->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
//            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
		$where = 'zyrj_tihuo.ID>0 and zyrj_tihuo.guquan=0 and zyrj_tihuo.shu>0 and zyrj_tihuo.uid ='.$id;
		$field = 'zyrj_fck.user_id,zyrj_fck.nickname,zyrj_product.name,zyrj_tihuo.*';
		$join = 'left join zyrj_fck ON zyrj_tihuo.UID=zyrj_fck.id'; //连表查询
		$join1 = 'left join zyrj_product ON zyrj_tihuo.DID=zyrj_product.id'; //连表查询
		$list = $tihuo->where($where)->field($field)->join($join)->join($join1)->order('PDT desc')->page($Page->getPage().','.$listrows)->select();
		// dump($list);	
		$rs1 = $tihuo->where($map)->sum('Cprice');
		$this->assign('count', $rs1);
		$this->assign('list', $list);
		$v_title = $this->theme_title_value();
		$this->distheme('TihuoInfo',$v_title[74]);
	}
	

	public function Tihuo(){
		$id=$_GET['id'];
		$gouwu = M('gouwu');
		$field="zyrj_gouwu.*,zyrj_product.name";
		$join = 'left join zyrj_product ON zyrj_gouwu.did=zyrj_product.id';
		$rs=$gouwu->where('zyrj_gouwu.id='.$id)->join($join)->field($field)->find();
		$this->assign('vo',$rs);

		$v_title = $this->theme_title_value();
		$this->distheme('tihuo',$v_title[71],1);
	}

	public function TihuoAC(){
		$id=$_POST['id'];
		$tshu=$_POST['tshu'];
		$tzhong=$_POST['tshu1'];
		$gouwu = D('Gouwu');
		$Tihuo = D('Tihuo');
		$rs=$gouwu->where('id='.$id)->find();
		//提货数量是否超
		$zong_shu=$rs['shu'];  //总共的数量
		$ti_shu=$rs['tshu'];   //已提的数量
		// $zhong_sum=$rs['zhong_sum'];   //已提的重量
		// $zhong_zong=$rs['zhong_zong'];   //已提的重量
		$a=$zong_shu-$ti_shu;
		if($tshu>$a){
			$this->error("提货数量不能超过购买数量！");
			exit;
		}
		if($tshu==0){
			$this->error("请选择要提货的数量！");
			exit;
		}
		//写入提货表
		$data=array();
		$data['uid']=$rs['uid'];
		$data['did']=$rs['did'];
		$data['lx']=$rs['lx'];
		$data['ispay']=0;      //是否发货
		$data['pdt']=time();      //提货时间
		$data['money']=$rs['money'];  //提货单价
		$data['shu']=$tshu;  			//提货数量
		$data['cprice']=$rs['money']*$tshu; //提货总金额
		$data['pvzhi']=$rs['pvzhi'];
		$data['guquan']=$rs['guquan'];
		$data['s_type']=$rs['s_type'];
		$data['user_id']=$rs['user_id'];
		$data['us_name']=$rs['us_name'];
		$data['us_address']=$rs['us_address'];
		$data['us_tel']=$rs['us_tel'];
		$data['isfh']=0;    //是否收货
		$data['fhdt']=0;	//发货时间
		$data['okdt']=$rs['okdt'];	//收货时间
		$data['ccxhbz']="暂无";
		$data['tshu']=$rs['tshu'];   
		$data['tzhong']=$tzhong;  


		$result=$Tihuo->add($data);
		// dump($Tihuo);
		if($result){	
			$gouwu->execute("UPDATE __TABLE__ SET tshu=tshu+".$tshu.",zhong_ti=zhong_ti+".$tzhong." where id=".$rs['id']);
			// dump($gouwu);exit;
			$url = __URL__.'/BuycpInfo/';
			$this->_box(1,'提货成功！',$url,1);
			exit;
		}else{
			$this->error("提货失败！");
			exit;
		}

	}
	//显示产品信息
    public function Cpcontent() {
		$cp = M('product');
		$fck = M('fck');
		$product = M ('product');
		$PID = (int) $_GET['id'];
		if (empty($PID)){
			$this->error(xstr('error_signed'));
			exit;
		}
		$fck = M('fck');
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $fck->where($map)->find();

		$where = array();
		$where['id'] = $PID;
		$where['yc_cp'] = array('eq',0);
		$prs = $product->where($where)->field('*')->find();
		if ($prs){
			$this->assign('prs',$prs);
        	$w_money = $prs['a_money'];
			$cc[$prs['id']] = $w_money;
	        $this->assign('cc',$cc);

			$this->assign('f_rs', $f_rs);
			$v_title = $this->theme_title_value();
			$this->distheme('Cpcontent',$v_title[71],1);
		}
	}


    public function Buycp() { //购买产品页
		$cp = M('product');
		$fck = M('fck');
		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $fck->where($map)->find();

		$where = array();
		$ss_type = (int) $_REQUEST['tp'];
		if($ss_type>0){
			$where['cptype'] = array('eq',$ss_type);
		}
		$this->assign('tp',$ss_type);

		$where['yc_cp'] = array('eq',0);

		$cptype = M('cptype');
		$tplist = $cptype->where('status=0')->order('id asc')->select();
		$this->assign('tplist',$tplist);

		$order = 'id asc';
	    $field   = '*';
        //=====================分页开始==============================================
        import ( "@.ORG.ZQPage" );  //导入分页类
        $count = $cp->where($where)->count();//总页数
   		$listrows = 20;//每页显示的记录数
        $page_where = 'tp='.$ss_type;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page',$show);//分页变量输出到模板
        $list = $cp->where($where)->field($field)->order('id asc')->page($Page->getPage().','.$listrows)->select();
        //=================================================
        foreach($list as $voo){
			$w_money = $voo['a_money'];
			$cc[$voo['id']] = $w_money;
        }
        $this->assign('cc',$cc);
		$this->assign('list',$list);//数据输出到模板

		$v_title = $this->theme_title_value();
		$this->distheme('Buycp',$v_title[71]);
	}

	public function shopCar(){
		$pora = M('product');
		$fck = M('fck');

		$map['id'] = $_SESSION[C('USER_AUTH_KEY')];
		$f_rs = $fck->where($map)->find();

		$id = $_REQUEST['id'];

		$arr = $_SESSION["shopping"];
		if(empty($arr)){
			$url = __URL__.'/Buycp';
			$this->_box(0,'您的购物车里没有商品！',$url,1);
			exit;
		}
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$path .= $str[0].',';
			$ids[$str[0]] = $str[1];
		}

		$where['id'] = array('in','0'. $path .'0');
		$list = $pora -> where($where) ->select();
		foreach ($list as $lvo){
			$w_money = $lvo['a_money'];
			$weight=$lvo['xhname'];
			//物品总价

			$ep[$lvo['id']] = $ids[$lvo['id']] * $w_money;
			$num[$lvo['id']] = $ids[$lvo['id']];
			$zong[$lvo['id']] = $ids[$lvo['id']] * $weight;

			//所有商品总价
			$eps += $ids[$lvo['id']] * $w_money;
			$sum += $ids[$lvo['id']];
			$zongs+=$ids[$lvo['id']] * $weight;


			$cc[$lvo['id']] = $w_money;
			$ww[$lvo['id']] = $weight;
		}

		$bza = $_SESSION["shopping_bz"];
		$blrs = explode("|",$bza);
		$bzz = array();
		foreach($blrs as $vvv){
			$vava = explode(",",$vvv);
			$bzz[$vava[0]] = $vava[1];
		}
		$this->assign('bzz',$bzz);
		$this->assign('cc',$cc);
		$this->assign('ww',$ww);
		$this->assign('list',$list);
		$this->assign('path',$path);
		$this->assign('ids',$ids);
		$this->assign('num',$num);
		$this->assign('sum',$sum);
		$this->assign('eps',$eps);
		$this->assign('ep',$ep);
		$this->assign('zongs',$zongs);
		$this->assign('zong',$zong);

		$v_title = $this->theme_title_value();
		$this->distheme('shopCar',$v_title[73]);
	}

	public function delBuyList(){
		$ID = $_REQUEST['id'];
		$shopping_id ='';
		$arr = $_SESSION["shopping"];

		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				unset($rs[$key]);
			}else{
				if(empty($shopping_id)){
					$shopping_id = $vo;
				}else{
					$shopping_id .= '|'.$vo;
				}
			}
		}
		$_SESSION["shopping"] = $shopping_id;
		$this->success("删除成功！");
	}
	public function reset(){
		//清空购物车
		$_SESSION["shopping"] = array();
		$_SESSION["shopping_bz"] = array();
		$url = __URL__.'/Buycp';
		$this->success("清空完成！");
	}
	public function chang(){
		$ID = $_GET['DID'];
		$nums = $_GET['nums'];
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$shopping_id = '';
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				$str[1] = $nums;
			}
			$s_id = $str[0].','.$str[1];
			if(empty($shopping_id)){
				$shopping_id = $s_id;
			}else{
				$shopping_id .= '|'.$s_id;
			}
		}
		$_SESSION["shopping"] = $shopping_id;
	}

	public function chang_bz(){
		$ID = $_GET['DID'];
		$nums = trim($_GET['bzz']);

		if (!empty($nums)){
			import ( "@.ORG.KuoZhan" );  //导入扩展类
            $KuoZhan = new KuoZhan();
            if ($KuoZhan->is_utf8($nums) == false){
                $nums = iconv('GB2312','UTF-8',$nums);
            }
            unset($KuoZhan);
		}
		if(empty($_SESSION["shopping_bz"])){
			$_SESSION["shopping_bz"] = $ID.",".$nums;
		}
		$arr = $_SESSION["shopping_bz"];

		$rs = explode('|',$arr);
		$shopping_id = '';
		$tong = 0;
		foreach ($rs as $key=>$vo){
			$str = explode(',',$vo);
			if($str[0] == $ID){
				$tong = 1;
				$str[1] = $nums;
			}
			$s_id = $str[0].','.$str[1];
			if(empty($shopping_id)){
				$shopping_id = $s_id;
			}else{
				$shopping_id .= '|'.$s_id;
			}
		}
		if($tong==0){
			$shopping_id .= "|".$ID.",".$nums;
		}
		$_SESSION["shopping_bz"] = $shopping_id;
	}

	public function ShoppingListAdd(){
		$address = M('address');

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$aList = $address->where('uid='.$id)->select();
		$this->assign('aList',$aList);

		$fck = M('fck');
		$fck_rs = $fck->where('id='.$id)->find();
		$this->assign('fck_rs',$fck_rs);

		$pora = M('product');
		$arr = $_SESSION["shopping"];
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$ids[$str[0]] = $str[1];
			$path .= $str[0].',';
		}

		$where['id'] = array('in','0'. $path .'0');
		$list = $pora -> where($where) ->select();
		foreach ($list as $lvo){
			$w_money = $lvo['a_money'];
			$weight = $lvo['xhname'];
			//物品总价
			$ep[$lvo['id']] = $ids[$lvo['id']] * $w_money;
			$zong[$lvo['id']] = $ids[$lvo['id']] * $weight;

			//所有商品总价
			$eps += $ids[$lvo['id']] * $w_money;
			$sum += $ids[$lvo['id']];
			$zongs += $ids[$lvo['id']] * $weight;

			$cc[$lvo['id']] = $w_money;
		}
		$bza = $_SESSION["shopping_bz"];
		$blrs = explode("|",$bza);
		$bzz = array();
		foreach($blrs as $vvv){
			$vava = explode(",",$vvv);
			$bzz[$vava[0]] = $vava[1];
		}
		$this->assign('bzz',$bzz);

		$this->assign('cc',$cc);

		$this->assign('list',$list);
		$this->assign('path',$path);
		$this->assign('ids',$ids);
		$this->assign('sum',$sum);
		$this->assign('eps',$eps);
		$this->assign('ep',$ep);
		$this->assign('zongs',$zongs);
		$this->assign('zong',$zong);

		$v_title = $this->theme_title_value();
		$this->distheme('ShoppingListAdd',$v_title[73]);

	}

	public function addAddress(){
		$address = M('address');
		$id =  $_SESSION[C('USER_AUTH_KEY')];
		$did = $_POST['ID'];

		$name = $_POST['s_name'];
		$are = $_POST['s_address'];
		$tel= $_POST['s_tel'];

		$data['uid'] = $id;
		$data['name'] = $name;
		$data['address'] = $are;
		$data['tel'] = $tel;
		$data['moren'] = 0;

		if(empty($did)){
			$result = $address->add($data);
		}else{
			$result = $address->where('id='.$did)->save($data);
		}

		if($result){
			$url = __URL__.'/ShoppingListAdd';
			$this->_box(0,'添加成功！',$url,1);
			exit;
		}else{
			$this->error('添加失败');
		}

	}

	public function moren(){
		$address = M('address');
		$id =  $_SESSION[C('USER_AUTH_KEY')];
		$cid = $_GET['ID'];
		$rs2 = $address->where('uid ='.$id)->setField('moren',0);
		$rs  = $address->where("id={$cid} and uid=".$id)->setField('moren',1);
		if($rs && $rs2){
			echo $id;
		}else{
			echo '0';
		}
	}

	public function addadr(){
		$address = M('address');
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->find();
		$this->assign('rs',$rs);
		$this->assign('did',$id);
		$v_title = $this->theme_title_value();
		$this->distheme('addadr',$v_title[75],1);
	}

	public function delAdr(){
		$address = M('address');
		$id = $_GET['ID'];
		$rs  = $address->where('id='.$id)->delete();
		if($rs){
			$url = __URL__.'/ShoppingListAdd';
			$this->_box(1,'删除地址成功！',$url,1);
			exit;
		}else{
			$this->error('删除失败');
		}
	}

	public function  ShopingSave(){
		$Id = (int) $_SESSION[C('USER_AUTH_KEY')];
		$pora = M('product');
		$address = M('address');
		$fck = D('Fck');

		$prices = $_POST['prices'];
		$s_type = (int)$_POST['s_type'];

		$arr = $_SESSION["shopping"];
		if(empty($arr)){
			$this->error("您的购物车里面没有商品！");
			exit;
		}

		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$p_rs = $pora->where('id='.$str[0].'')->find();
			if(!$p_rs){
				$this->error("您所购买的产品暂时没货！");
				exit;
			}
		}
		$rs = explode('|',$arr);
		$path = ',';
		foreach ($rs as $vo){
			$str = explode(',',$vo);
			$path .= $str[0].',';
			$ids[$str[0]] = $str[1];
		}

		$fck_rs = $fck->where('id='.$Id) ->find();

		$pw = md5(trim($_POST['Password']));
		if($fck_rs['passopen'] != $pw){
			$this->error('二级密码输入错误!!');
			exit;
		}


		$aid = $_POST['adid'];
		$ars = $address->where('id='.$aid)->find();
		if(!$ars){
			$this->error('该地址不存在!!');
			exit;
		}
		$id = $_SESSION[C('USER_AUTH_KEY')];
		// $fck_rs=$fck->where("is_pay>0 id=".$id)->find();
		$gwd = array();
		$gwd['uid'] = $id;
		$gwd['user_id'] = $fck_rs['user_id'];
		$gwd['lx'] = 2;  //lx=2的才结算
		$gwd['ispay'] = 0;
		$gwd['pdt'] = mktime();
		$gwd['us_name'] = $ars['name'];;
		$gwd['us_address'] = $ars['address'];
		$gwd['us_tel'] = $ars['tel'];
		$gwd['s_type'] = $s_type;
 


		$where = array();
		$where['id'] = array('in','0'. $path .'0');

		$prs = $pora->where($where)->select();
		$gouwu = M('gouwu');

		if($s_type==1){
			$moccc = $fck_rs['agent_use'];
			}else{
				$moccc = $fck_rs['agent_cash'];
			}
		// DUMP($moccc);
		if($moccc < $prices){
			$this->error("您的余额不足，请先充值！");
			exit;
		}

		$money_count = 0;
		foreach ($prs as $vo){
			//库存数量减少
			$shu=$ids[$vo['id']];			
			$sheng=$vo['ccname'];
			if($sheng>=$shu){
				$pora->query("update __TABLE__ set ccname=ccname-".$shu." where id=".$vo['id']." and ccname=".$sheng);
			}else{
				$url = __URL__.'/BuycpInfo/';
				$this->_box(0,"商品名称".$vo['name']."库存不足，请减少购买数量！",$url,1);
				exit;
			}

			$w_money = $vo['a_money'];
			$weight = $vo['xhname'];
			$money_count += $w_money;
			$gwd['did'] = $vo['id'];
			$gwd['money'] = $w_money;
			$gwd['shu'] = $ids[$vo['id']];
			$gwd['cprice'] = $ids[$vo['id']]*$w_money;
			$gwd['tshu'] = 0;
			$gwd['ccxhbz'] = $vo['b_money'];
			$gwd['zhong_sum'] = $ids[$vo['id']]*$weight;
			// $fck->yeji($fck_rs['id'],$fck_rs['user_id'],$vo['a_money'],$vo['id']);
			$gouwu->add($gwd);
			//往上加业绩
			$fck->xiangJiaoJ($fck_rs['id'],$gwd['cprice']); 

			if($s_type==1){
			$sqlx ="agent_use=agent_use-".$gwd['cprice']."";
			$sqlx .=",g_level_a=g_level_a+".$gwd['cprice'].""; //消费业绩
			}else{
				$sqlx ="agent_cash=agent_cash-".$gwd['cprice']."";
				$sqlx .=",g_level_a=g_level_a+".$gwd['cprice'].""; //消费业绩
			}
			$nowdate=strtotime(date("Y-m-d"));
			$rs = $fck->execute("update __TABLE__ set ".$sqlx.",gdt=".$nowdate." where id=".$id);
			$fck->addencAdd($fck_rs['id'],$fck_rs['user_id'], -$gwd['cprice'],22);
		}
		//$rs = 1;
		if($rs){
			$_SESSION["shopping"]='';
			$_SESSION["shopping_bz"]='';
			$url = __URL__.'/BuycpInfo/';
			$this->_box(1,'购买成功！',$url,1);
			exit;
		}else{
			$this->error("购买失败！");
			exit;
		}
	}

	public function BuycpInfo() {//购买信息
		$cp = M('product');
		$fck = M('fck');
		$gouwu = M('gouwu');
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$map['uid'] = $id;
		$map['guquan'] = array('neq',1);
		 //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $gouwu->where($map)->count();//总页数
       		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
//            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
		$where = 'zyrj_gouwu.ID>0 and zyrj_gouwu.guquan=0 and zyrj_gouwu.shu>0 and zyrj_gouwu.uid ='.$id;
		$field = 'zyrj_fck.user_id,zyrj_fck.nickname,zyrj_product.name,zyrj_gouwu.*';
		$join = 'left join zyrj_fck ON zyrj_gouwu.UID=zyrj_fck.id'; //连表查询
		$join1 = 'left join zyrj_product ON zyrj_gouwu.DID=zyrj_product.id'; //连表查询
		$list = $gouwu->where($where)->field($field)->join($join)->join($join1)->order('PDT desc')->page($Page->getPage().','.$listrows)->select();
		$rs1 = $gouwu->where($map)->sum('Cprice');
		$this->assign('count', $rs1);
		$this->assign('list', $list);
		$v_title = $this->theme_title_value();
		$this->distheme('BuycpInfo',$v_title[74]);
	}
	
	//产品表查询
	public function pro_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('product');
			$title = $_REQUEST['stitle'];
			$map = array();
			if(strlen($title)>0){
				$map['name'] = array('like','%'. $title .'%');
			}
			$map['id'] = array('gt',0);
			$orderBy = 'create_time desc,id desc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $product->where($map)->count();//总页数
	   		$listrows = C('ONE_PAGE_RE');//每页显示的记录数
	   		$listrows = 10;//每页显示的记录数
	        $page_where = 'stitle=' . $title ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $product->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================

			$v_title = $this->theme_title_value();
			$this->distheme('pro_index',$v_title[77]);
		}else{
            $this->error(xstr('error_signed'));
        }
	}

	//产品表显示修改
	public function pro_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('product');
		$where = array();
		$where['id'] = $EDid;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);
			$this->us_fckeditor('content',$rs['content'],400,"96%");

			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);

			$v_title = $this->theme_title_value();
			$this->distheme('pro_edit',$v_title[77]);
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	//产品表修改保存
	public function pro_edit_save(){
		$this->_Admin_checkUser();
		$product = M ('product');
		$data = array();
		//h 函数转换成安全html
		$money = trim($_POST['money']);
		$a_money = $_POST['a_money'];
		$b_money = $_POST['b_money'];
		$content = stripslashes($_POST['content']);
		$title = trim($_POST['title']);
		$cid = trim($_POST['cid']);
		$image = $_POST['image'];
		$ctime = trim($_POST['ctime']);
		$ccname = $_POST['ccname'];
		$xhname = $_POST['xhname'];
		$cptype = trim($_POST['cptype']);
		$cptype = (int)$cptype;
		$ctime = strtotime($ctime);
		if (empty($title)){
			$this->error('标题不能为空!');
			exit;
		}
		if (empty($cid)){
			$this->error('商品编号不能为空!');
			exit;
		}
//		if (empty($ccname)){
//			$this->error('商品尺寸不能为空!');
//			exit;
//		}
//		if (empty($xhname)){
//			$this->error('商品型号不能为空!');
//			exit;
//		}
		if (empty($money)||!is_numeric($money)||empty($a_money)||!is_numeric($a_money)){
			$this->error('价格不能为空!');
			exit;
		}
		if($money <= 0||$a_money <= 0){
			$this->error('输入的价格有误!');
			exit;
		}

		if(!empty($ctime)){
			$data['create_time'] = $ctime;
		}
		$data['cid'] = $cid;
		$data['ccname'] = $ccname;
		$data['xhname'] = $xhname;
		$data['money'] = $money;
		$data['a_money'] = $a_money;
		$data['b_money'] = $b_money;
		$data['name'] = $title;
		$data['content'] = $content;
		$data['cptype'] = $cptype;

		$data['img'] = $image;

		$data['id'] = $_POST['ID'];

		$rs = $product->save($data);
		if (!$rs){
			$this->error(xstr('hint158'));
			exit;
		}
		$bUrl = __URL__.'/pro_index';
		$this->_box(1,xstr('operation_success'),$bUrl,1);
		exit;
	}

	//产品表操作（启用禁用删除）
	public function pro_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){

			$cptype = M('cptype');
			$list = $cptype->where('status=0')->order('id asc')->select();
			$this->assign('list',$list);

			$this->us_fckeditor('content',"",400,"96%");

			$v_title = $this->theme_title_value();
			$this->distheme('pro_add',$v_title[77]);
			exit;
		}
		$product = M ('product');
		switch ($action){
			case xstr('delete');
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,xstr('operation_success'),$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,xstr('operation_failed'),$bUrl,1);
				}
				break;
			case '屏蔽产品';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',1);
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'屏蔽产品成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'屏蔽产品失败',$bUrl,1);
				}
				break;
			case '解除屏蔽';
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->setField('yc_cp',0);
				if ($rs){
					$bUrl = __URL__.'/pro_index';
					$this->_box(1,'解除屏蔽成功',$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/pro_index';
					$this->_box(0,'解除屏蔽失败',$bUrl,1);
				}
				break;
			default;
				$bUrl = __URL__.'/pro_index';
				$this->_box(0,xstr('operation_failed'),$bUrl,1);
				break;
		}
	}

	//产品表添加保存
	public function pro_inserts(){
		$this->_Admin_checkUser();
		$product = M('product');

		$data = array();
		//h 函数转换成安全html
		$content = trim($_POST['content']);
		$title = trim($_POST['title']);
		$cid = trim($_POST['cid']);
		$image = trim($_POST['image']);
		$money = $_POST['money'];
		$a_money = $_POST['a_money'];
		$b_money = $_POST['b_money'];
		$ccname = $_POST['ccname'];
		$xhname = $_POST['xhname'];
		$cptype = (int)$_POST['cptype'];
		if (empty($title)){
			$this->error('商品名称不能为空!');
			exit;
		}
		if (empty($cid)){
			$this->error('商品编号不能为空!');
			exit;
		}
//		if (empty($ccname)){
//			$this->error('商品尺寸不能为空!');
//			exit;
//		}
//		if (empty($xhname)){
//			$this->error('商品型号不能为空!');
//			exit;
//		}
		if (empty($money)||!is_numeric($money)||empty($a_money)||!is_numeric($a_money)){
			$this->error('价格不能为空!');
			exit;
		}
		if($money <= 0||$a_money <= 0){
			$this->error('输入的价格有误!');
			exit;
		}

		$data['name'] = $title;
		$data['cid'] = $cid;
		$data['content'] = stripslashes($content);
		$data['img'] = $image;
		$data['create_time'] = mktime();
		$data['money'] = $money;
		$data['a_money'] = $a_money;
		$data['b_money'] = $b_money;
		$data['ccname'] = $ccname;
		$data['xhname'] = $xhname;
		$data['cptype'] = $cptype;
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/pro_index';
		$this->_box(1,xstr('operation_success'),$bUrl,1);
		exit;
	}

	public function cptype_index(){
		$this->_Admin_checkUser();
		if ($_SESSION['UrlszUserpass'] == 'MyssGuanChanPin'){
			$product = M('cptype');
			$map = array();
			$map['id'] = array('gt',0);
			$orderBy = 'id asc';
			$field  = '*';
	        //=====================分页开始==============================================
	        import ( "@.ORG.ZQPage" );  //导入分页类
	        $count = $product->where($map)->count();//总页数
	   		$listrows = 20;//每页显示的记录数
	        $page_where = "" ;//分页条件
	        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
	        //===============(总页数,每页显示记录数,css样式 0-9)
	        $show = $Page->show();//分页变量
	        $this->assign('page',$show);//分页变量输出到模板
	        $list = $product->where($map)->field($field)->order($orderBy)->page($Page->getPage().','.$listrows)->select();
	        $this->assign('list',$list);//数据输出到模板
	        //=================================================

			$v_title = $this->theme_title_value();
			$this->distheme('cptype_index',$v_title[78]);
		}else{
            $this->error(xstr('error_signed'));
        }
	}

	public function cptype_edit(){
		$this->_Admin_checkUser();
		$EDid = $_GET['EDid'];
		$field = '*';
		$product = M ('cptype');
		$where = array();
		$where['id'] = $EDid;
		$rs = $product->where($where)->field($field)->find();
		if ($rs){
			$this->assign('rs',$rs);//数据输出到模板
			$v_title = $this->theme_title_value();
			$this->distheme('cptype_edit',$v_title[78],1);
		}else{
			$this->error('没有该信息！');
			exit;
		}
	}

	public function cptype_edit_save(){
		$this->_Admin_checkUser();
		$cptype = M ('cptype');
		$title = trim($_POST['title']);
		if (empty($title)){
			$this->error('分类名不能为空!');
			exit;
		}
		$data = array();
		$data['tpname'] = $title;
		$data['id'] = $_POST['id'];
		$rs = $cptype->save($data);
		if (!$rs){
			$this->error(xstr('hint158'));
			exit;
		}
		$bUrl = __URL__.'/cptype_index';
		$this->_box(1,xstr('operation_success'),$bUrl,1);
		exit;
	}

	//处理
	public function cptype_zz(){
		$this->_Admin_checkUser();
		//处理提交按钮
		$action = $_POST['action'];
		//获取复选框的值
		$PTid = $_POST["checkbox"];
		if ($action=='添加'){
			$v_title = $this->theme_title_value();
			$this->distheme('cptype_add',$v_title[78],1);
			exit;
		}
		$product = M ('cptype');
		switch ($action){
			case xstr('delete');
				$wherea=array();
				$wherea['id'] = array('in',$PTid);
				$rs = $product->where($wherea)->delete();
				if ($rs){
					$bUrl = __URL__.'/cptype_index';
					$this->_box(1,xstr('operation_success'),$bUrl,1);
					exit;
				}else{
					$bUrl = __URL__.'/cptype_index';
					$this->_box(0,xstr('operation_failed'),$bUrl,1);
				}
				break;
			default;
			$bUrl = __URL__.'/cptype_index';
			$this->_box(0,xstr('operation_failed'),$bUrl,1);
			break;
		}
	}
	
	//产品表添加保存
	public function cptype_inserts(){
		$this->_Admin_checkUser();
		$product = M('cptype');
		$title = trim($_POST['title']);
		if (empty($title)){
			$this->error('分类名不能为空!');
			exit;
		}
		$data = array();
		$data['tpname'] = $title;
		$form_rs = $product->add($data);
		if (!$form_rs){
			$this->error('添加失败');
			exit;
		}
		$bUrl = __URL__.'/cptype_index';
		$this->_box(1,xstr('operation_success'),$bUrl,1);
		exit;
	}

	public function adminLogistics(){
		$this->_Admin_checkUser();//后台权限检测
		//物流管理
		if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
			$shopping = M ('tihuo');
			$product = M('product');
			$fee = M('fee');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int) $_REQUEST['type'];
            $map = array();
			if (!empty($UserID)){
				import ( "@.ORG.KuoZhan" );  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false){
                    $UserID = iconv('GB2312','UTF-8',$UserID);
                }
                unset($KuoZhan);
				$map['user_id'] = array('like',"%".$UserID."%");
				$UserID = urlencode($UserID);
			}
			if($ss_type==0){
				$map['ispay'] = array('egt',0);
			}elseif($ss_type==1){
				$map['ispay'] = array('eq',0);
				$map['isfh'] = array('eq',0);
			}elseif($ss_type==2){
				$map['ispay'] = array('eq',0);
				$map['isfh'] = array('eq',1);
			}elseif($ss_type==3){
				$map['ispay'] = array('eq',1);
			}
            //查询字段
            $field   = '*';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            $count = $shopping->where($map)->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		    $page_where = 'UserID='.$UserID.'&type='.$ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page',$show);//分页变量输出到模板
            $list = $shopping ->where($map)->field($field)->page($Page->getPage().','.$listrows)->order('user_id desc,pdt desc')->select();
            $this->assign('list',$list);//数据输出到模板
            //=================================================
            foreach($list as $vv){
            	$ttid = $vv['did'];
            	$trs = $product->where('id='.$ttid)->find();
            	$voo[$ttid] = $trs['name'];
            }
            $this->assign('voo',$voo);

            //=======每月已发货信息=====================
            //查询字段
            $field   = "FROM_UNIXTIME(fhdt,'%Y-%m') as m,sum(shu) as sumNum,sum(cprice) as sumPri";
            $where='isfh=1';
            //=====================分页开始==============================================
            import ( "@.ORG.ZQPage" );  //导入分页类
            // $count = $shopping->where($where)->field($field)->group('m')->count();//总页数
            $listrows = C('PAGE_LISTROWS')  ;//每页显示的记录数
		    // $page_where = 'UserID='.$UserID.'&type='.$ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page2',$show);//分页变量输出到模板
            $list2 = $shopping ->where($where)->field($field)->page($Page->getPage().','.$listrows)->group('m')->select();
            $this->assign('list2',$list2);//数据输出到模板
            //=================================================

			foreach ($list2 as $val) {
				$sum['0']+=$val['sumNum'];
				$sum['1']+=$val['sumPri'];
			}
            $this->assign('sum',$sum);
            $fee_rs=$fee->field('s16')->find(1);
            $s16=explode("|", $fee_rs['s16']);
            $this->assign('s16',$s16);

            //====================================================
			$v_title = $this->theme_title_value();
			$this->distheme('adminLogistics',$v_title[72]);
			
		}else{
			$this->error(xstr('error_signed'));
			exit;
		}
	}

    public function adminLogisticsAC(){
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $XGid = $_POST['tabledb'];
        $Tname=array();
        foreach ($XGid as $pvo){
			$aa = "Tname".$pvo;
			$Tname[$pvo] = $_POST[$aa];
		}
		foreach ($XGid as $pvo){
			$aa = "bz".$pvo;
			$bz[$pvo] = $_POST[$aa];
		}
        if (!isset($XGid) || empty($XGid)){
            $bUrl = __URL__.'/adminLogistics';
            $this->_box(0,'请选择货物！',$bUrl,1);
            exit;
        }
        // dump($Tname);exit;
        switch ($action){
            case '确认发货';
                $this->_adminLogisticsOK($XGid,$bz,$Tname);
                break;
            case '确定收货';
                $this->_adminLogisticsDone($XGid,$bz,$Tname);
                break;
            case '修改快递公司';
                $this->_adminLogisticsTname($XGid,$Tname);
                break;
            case xstr('delete');
                $this->_adminLogisticsDel($XGid);
                break;
	        default;
	            $bUrl = __URL__.'/adminLogistics';
	            $this->_box(0,'没有该货物！',$bUrl,1);
	            break;
        }
    }

        private function _adminLogisticsTname($XGid,$Tname){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('tihuo');
            
            //更改快递公司名称
            $where = array();
            $where['id'] = array ('in',$XGid);
            $sr=$shopping->where($where)->field('id')->select();
            // dump($sr);
            foreach ($sr as $voo) {
            	$id=$voo['id'];
            	$shopping->execute("update __TABLE__ set Tname='".$Tname[$id]."' where id=".$id);//加到fck
            	// dump($shopping);
            }
            // $valuearray = array(
            // 	'isfh' => '1',
            // 	'fhdt' => mktime()
            // );
            // $shopping->where($where)->setField($valuearray);
            unset($shopping,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,'修改成功！',$bUrl,1);
            exit;
        }else{
            $this->error(xstr('error_signed'));
        }
    }

    private function _adminLogisticsOK($XGid,$bz,$Tname){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('tihuo');
            $where = array();
            $where['id'] = array ('in',$XGid);
            $where['isfh'] = array ('eq',0);

            $sr=$shopping->where($where)->field('id')->select();
            // dump($sr);
            foreach ($sr as $voo) {
            	$id=$voo['id'];
            	$shopping->execute("update __TABLE__ set isfh=1,fhdt=".mktime()." where id=".$id);//加到fck
            	// dump($shopping);
            }
         
            // $valuearray = array(
            // 	'isfh' => '1',
            // 	'fhdt' => mktime()
            // );
            // $shopping->where($where)->setField($valuearray);
            unset($shopping,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,'发货成功！',$bUrl,1);
            exit;
        }else{
            $this->error(xstr('error_signed'));
        }
    }

    private function _adminLogisticsDone($XGid,$bz,$Tname){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('tihuo');

            $where1 = array();
            $where1['id'] = array ('in',$XGid);
            $where1['isfh'] = array ('eq',0);
            $sr=$shopping->where($where1)->field('id')->select();
            // dump($sr);
            foreach ($sr as $voo) {
            	$id=$voo['id'];
            	$shopping->execute("update __TABLE__ set isfh=1,fhdt=".mktime()." where id=".$id);//加到fck
            	// dump($shopping);
            }

            $where = array();
            $where['id'] = array ('in',$XGid);
            $where['ispay'] = array ('eq',0);

            $sr=$shopping->where($where)->field('id')->select();
            // dump($sr);
            foreach ($sr as $voo) {
            	$id=$voo['id'];
            	$shopping->execute("update __TABLE__ set ispay=1,okdt=".mktime()." where id=".$id);//加到fck
            	// dump($shopping);
            }

            // $valuearray1 = array(
            // 	'isfh' => '1',
            // 	'fhdt' => mktime()
            // );

            // $valuearray = array(
            // 	'ispay' => '1',
            // 	'okdt' => mktime()
            // );

            // $shopping->where($where1)->setField($valuearray1);
            // $shopping->where($where)->setField($valuearray);
            unset($shopping,$where1,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,'确认收货成功！',$bUrl,1);
            exit;
        }else{
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    private function _adminLogisticsDel($XGid){
    	//确定发货
        if ($_SESSION['UrlszUserpass'] == 'MyssWuliuList'){
            $shopping = M ('tihuo');
            $where = array();
            $where['id'] = array ('in',$XGid);
            $shopping->where($where)->delete();
            unset($shopping,$where);

            $bUrl = __URL__.'/adminLogistics';
            $this->_box(1,xstr('delete_success'),$bUrl,1);
            exit;
        }else{
            $this->error(xstr('error_signed'));
        }
    }

    
    /**
     * 上传图片
     * **/
	public function upload_fengcai_pp() {
		$this->_Admin_checkUser();//后台权限检测
        if(!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_pp();
        }
    }

    protected function _upload_fengcai_pp()
    {
        header("content-type:text/html;charset=utf-8");
        $this->_Admin_checkUser();//后台权限检测
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize  = 1048576 * 2 ;// TODO 50M   3N 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath =  './Public/Uploads/image/';

        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;

       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图

       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';

       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

       //设置上传文件规则
//		$upload->saveRule = uniqid;
		$upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);

       //删除原图
       $upload->thumbRemoveOrigin = true;

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

            echo "<script>window.parent.form1.image.value='".$U_inpath."';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }

    /**
     * 上传图片
     * **/
	public function upload_addb() {
		$this->_Admin_checkUser();//后台权限检测
		$gid=$_REQUEST['gid'];
		$this->assign("gid",$gid);
		$this->display();
    }
     /**
     * 上传图片
     * **/
	public function upload_fengcai_aa() {
		$this->_Admin_checkUser();//后台权限检测
		$gid=$_REQUEST['gid'];
        if(!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_aa($gid);
        }
    }

    protected function _upload_fengcai_aa($gid=0)
    {
        header("content-type:text/html;charset=utf-8");
        $this->_Admin_checkUser();//后台权限检测
        // 文件上传处理函数
        $gid=$_REQUEST['gid'];

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize  = 1048576 * 2 ;// TODO 50M   3N 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts  = explode(',','jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath =  './Public/Uploads/image/';

        //设置需要生成缩略图，仅对图像文件有效
       $upload->thumb =  false;

       //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix   =  'm_';  //生产2张缩略图

       //设置缩略图最大宽度
        $upload->thumbMaxWidth =  '800';

       //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

       //设置上传文件规则
//		$upload->saveRule = uniqid;
		$upload->saveRule = date("Y").date("m").date("d").date("H").date("i").date("s").rand(1,100);

       //删除原图
       $upload->thumbRemoveOrigin = true;

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
            $shopping = M ('tihuo');
            $result=$shopping->execute("update __TABLE__ set ccxhbz='".$U_inpath."' where id=".$gid);
            // dump($shopping);exit;
            if($result){
            	echo "<span style='font-size:12px;'>上传完成！</span>";
            	exit;
            }else{
            	echo "<span style='font-size:12px;'>上传失败！</span>";
            	exit;
            }
            

        }
    }

}
?>