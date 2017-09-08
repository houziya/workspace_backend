<?php
class GupiaoAction extends CommonAction {

	function _initialize() {
		parent::_initialize();
		ob_clean();
		$this->_inject_check(0); //调用过滤函数
		header("Content-Type:text/html; charset=utf-8");
		$this->_checkUser();
		//$this->gp_up_down_pd();
		//$this->stock_past_due(); ///查看是否过一天   代币
	}

    //二级验证
    public function Cody(){
        $this->_checkUser();
        $UrlID = (int) $_GET['c_id'];
		if(!empty($_SESSION['user_pwd2'])){
			//unset($_SESSION['user_pwd3']);//清空二级输入的密码
			$url = __URL__."/codys/Urlsz/$UrlID";
			$this->_boxx($url);
			exit;
		}
//		$thisa = $this->getActionName();
//		$this->assign('thisa',$thisa);
//        if (empty($UrlID)){
//            $this->error(xstr('second_password_error'));
//            exit;
//        }
		$cody   =  M ('cody');
		$list   =  $cody->where("c_id=$UrlID")->getField('c_id');
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
		$this->_checkUser();
		$Urlsz = (int) $_POST['Urlsz'];
		if(empty($_SESSION['user_pwd2'])){
			$pass  = $_POST['oldpassword'];
			$fck   =  M ('fck');
			if (!$fck->autoCheckToken($_POST)){
				//$this->error(xstr('page_expire_please_reflush'));
				//exit();
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
		switch ($Urlsz) {
			case 1;
				$_SESSION['UrlszUserpass'] = 'MyssQiCheng';//求购代币
				$bUrl = __URL__ . '/buyGPform';
				$this->_boxx($bUrl);
				break;
			case 2;
				$_SESSION['UrlszUserpass'] = 'sellgupiao';//出卖代币
				$bUrl = __URL__ . '/sellGPform';
				$this->_boxx($bUrl);
				break;
			case 3;
				$_SESSION['UrlszUserpass'] = 'gpHistory';//代币买卖记录
				$bUrl = __URL__ . '/sellGPform_N';
				$this->_boxx($bUrl);
				break;
			case 4;
				$_SESSION['UrlszUserpass'] = 'gpHistory';//代币买卖记录
				$bUrl = __URL__ . '/alllistGP';
				$this->_boxx($bUrl);
				break;
			case 5;
				$_SESSION['UrlPTPass'] = 'adminsetGP';
				$bUrl = __URL__ . '/adminsetGP';
				$this->_boxx($bUrl);
				break;
			case 6;
				$_SESSION['UrlPTPass'] = 'JJRbuyform';
				$bUrl = __URL__ . '/JJRbuyform';
				$this->_boxx($bUrl);
				break;
			case 7;
				$_SESSION['UrlPTPass'] = 'JJRbuyform';
				$bUrl = __URL__ . '/buyyuans';
				$this->_boxx($bUrl);
				break;
			case 8;
				$_SESSION['UrlPTPass'] = 'JJRbuyform';
				$bUrl = __URL__ . '/JJRbuyform2';
				$this->_boxx($bUrl);
				break;
			case 9;
				$_SESSION['UrlPTPass'] = 'JJRbuyform';
				$bUrl = __URL__ . '/trade_list';
				$this->_boxx($bUrl);
				break;
			case 10;
				$_SESSION['UrlPTPass'] = 'JJRbuyform';
				$bUrl = __URL__ . '/trade_list1';
				$this->_boxx($bUrl);
				break;
			default;
				$this->error(xstr('second_password_error'));
				break;
		}
	}

	public function tradingfloor() { //交易大厅
	$this->error(xstr('feature_is_closed'));exit;
		$id	= $_SESSION[C('USER_AUTH_KEY')];
		$GPmj = M('gupiao');
		$fck = M('fck');
		$fee = M ('fee');

		$ttrs = $GPmj->where('id>0')->field('id,uid')->select();
		foreach($ttrs as $tors){
			$thid = $tors['id'];
			$tuid = $tors['uid'];
			$cs=$fck->where('id='.$tuid)->field('id,user_id')->find();
			if(!$cs){
				$GPmj->where('id='.$thid)->delete();
			}
		}

		$rs = $fee->find();
		$one_price = $rs['str1'];
		$dan = $rs['str2'];

		$ys_gp = $rs['str8'];
		$pt_gp = $rs['str24'];
		$gj_gp = $rs['str25'];

		$this -> assign('ys_gp',$ys_gp);
		$this -> assign('pt_gp',$pt_gp);
		$this -> assign('gj_gp',$gj_gp);

		$id = $_SESSION[C('USER_AUTH_KEY')];

		import ( "@.ORG.ZQPage" );  //导入分页类

		$where = 'zyrj_gupiao.uid>0 and zyrj_gupiao.lnum>0 and zyrj_gupiao.type=1 and zyrj_gupiao.status=0 and zyrj_gupiao.ispay=0'; //出售
		$map = 'zyrj_gupiao.uid>0 and zyrj_gupiao.type=0 and zyrj_gupiao.ispay=0';//求购

		$field = 'zyrj_gupiao.*';
		$field .= ',zyrj_fck.nickname,zyrj_fck.user_id';
		$join = 'left join zyrj_fck ON zyrj_fck.id=zyrj_gupiao.uid'; //连表查询

		$count = $GPmj->where($where)->field($field)->join($join)->Distinct(true)->count();//出售总页数
		$count1 = $GPmj->where($map)->field($field)->join($join)->Distinct(true)->count();//求购总页数

		$listrows = 15;//每页显示的记录数

		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量

		$this->assign('page',$show);//分页变量输出到模板
		$Page1 = new ZQPage($count1,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show1 = $Page1->show();//分页变量
		$this->assign('page1',$show1);//分页变量输出到模板
		$list = $GPmj->where($where)->field($field)->join($join)->Distinct(true)->order('ispay asc,eDate asc,id asc')->page($Page->getPage().','.$listrows)->select();
		$list1 = $GPmj->where($map)->field($field)->join($join)->Distinct(true)->order('ispay asc,eDate asc,id asc')->page($Page1->getPage().','.$listrows)->select();
		foreach($list1 as $vov){

//			$can_b[$vov['id']] = floor($vov['buy_s']/$vov['one_price']);
			$can_b[$vov['id']] = floor($vov['buy_s']/$one_price);

		}
		$this->assign('can_b', $can_b);

		$this->assign('one_price', $one_price);
		$this->assign('list', $list);
		$this->assign('list1', $list1);
		$this->display();
		exit;
	}

	public function alllistGP() { //代币买卖界面
		$this->error(xstr('feature_is_closed'));exit;
		$id	= $_SESSION[C('USER_AUTH_KEY')];
		$GPmj = M('gupiao');
		$fck = M('fck');
		$fee = M ('fee');

		$ttrs = $GPmj->where('id>0')->field('id,uid')->select();
		foreach($ttrs as $tors){
			$thid = $tors['id'];
			$tuid = $tors['uid'];
			$cs=$fck->where('id='.$tuid)->field('id,user_id')->find();
			if(!$cs){
				$GPmj->where('id='.$thid)->delete();
			}
		}

		$rs = $fee->find();
		//当前股价
		$one_price = $rs['gp_one'];

		$id = $_SESSION[C('USER_AUTH_KEY')];

		import ( "@.ORG.ZQPage" );  //导入分页类

		$where = 'zyrj_gupiao.uid>0 and zyrj_gupiao.lnum>0 and zyrj_gupiao.type=1 and zyrj_gupiao.status=0 and zyrj_gupiao.ispay=0'; //出售
		$map = 'zyrj_gupiao.uid>0 and zyrj_gupiao.type=0 and zyrj_gupiao.ispay=0';//求购

		$field = 'zyrj_gupiao.*';
		$field .= ',zyrj_fck.nickname,zyrj_fck.user_id';
		$join = 'left join zyrj_fck ON zyrj_fck.id=zyrj_gupiao.uid'; //连表查询

		$count = $GPmj->where($where)->field($field)->join($join)->Distinct(true)->count();//出售总页数
		$count1 = $GPmj->where($map)->field($field)->join($join)->Distinct(true)->count();//求购总页数

		$listrows = 15;//每页显示的记录数

		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量

		$this->assign('page',$show);//分页变量输出到模板
		$Page1 = new ZQPage($count1,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show1 = $Page1->show();//分页变量
		$this->assign('page1',$show1);//分页变量输出到模板
		$list = $GPmj->where($where)->field($field)->join($join)->Distinct(true)->order('ispay asc,one_price asc,eDate asc,id asc')->page($Page->getPage().','.$listrows)->select();

		$list1 = $GPmj->where($map)->field($field)->join($join)->Distinct(true)->order('ispay asc,one_price asc,eDate asc,id asc')->page($Page1->getPage().','.$listrows)->select();
		foreach($list1 as $vov){

			$can_b[$vov['id']] = floor($vov['buy_s']/$vov['one_price']);

		}
		$this->assign('can_b', $can_b);

		$this->assign('one_price', $one_price);
		$this->assign('list', $list);
		$this->assign('list1', $list1);


		$this->display('alllistGP');
	}

	//购买原始股
	public function buyyuans() {
		if(!empty($_SESSION[C('USER_AUTH_KEY')])){
			$GPmj = M('gupiao');
			$fck = M('fck');
			$fee = M('fee')->field('gp_kg,str1,str8,gp_sell_count,s6,gp_one')->find();
			$close_gp	= $fee['gp_kg'];//原始代币开关,1为关闭
			/*
			if($close_gp==1){
				$this->error(xstr('hint165'));
				exit;
			}*/
			
			$feeArr = M('Fee')->field('gp_sell_count,last_gp_count,s6,s7')->find();
			$allGuPiaoArr = explode('|',$feeArr['s6']);
			$sellCount = intval($feeArr['gp_sell_count']);
			$chgCfgArr = explode('|',$feeArr['s7']);
			foreach($chgCfgArr as $key => $value)
				$chgCfgArr[$key] = explode(',',$value);
			
			$index = -1;
			$tAllNum = 0;
			foreach($allGuPiaoArr as $key => $value)
			{
				if($sellCount>=$tAllNum && $sellCount<($tAllNum+$value))
				{
					$index = $key;
					break;
				}
				else
					$tAllNum += $value;
			}
			if($index >= 0)
			{
				$this->assign('sellGradient',$chgCfgArr[$index][0]);
				$this->assign('sellUpPerTime',$chgCfgArr[$index][1]);
				$this->assign('sellDistance',$chgCfgArr[$index][0]-($sellCount%$chgCfgArr[$index][0]));
			}
			
			$id = $_SESSION[C('USER_AUTH_KEY')];
			$user_rs = $fck->where("id=$id")->field("agent_gp,live_gupiao")->find();
			$this->assign('game_m', $user_rs['agent_gp']);	//股点数（用于买代币的个人资产）
			$this->assign('live_gp', $user_rs['live_gupiao']);//持有代币数量
			$this->assign('one_price', $fee['gp_one']);//当前代币价格
			$this->assign('allGupiao',array_sum(explode('|',$fee['s6'])));
			$this->assign('gpSellCount',intval($fee['gp_sell_count']));
			$this->display();
		}else{
			$this->error(xstr('error'));
		}
	}

	//购买原始股处理
	public function buyyuansAC() {
		if(!empty($_SESSION[C('USER_AUTH_KEY')])){
			$fck = M('fck');
			$fee = M('fee');
			$frse = $fee->field('gp_kg,str1,str8,str9,gp_sell_count,s6,gp_one')->find();
			$close_gp	= $frse['gp_kg'];//原始代币开关,1为关闭
			//$yuan_num	= $frse['str9'];//原始代币剩余数量
			if($close_gp==1){
				$this->error(xstr('hint160'));
				exit;
			}

			$id = $_SESSION[C('USER_AUTH_KEY')];
			//检查交易密码
			$user_info	= $fck->where("id=$id")->field("agent_gp,user_id,passopentwo")->find();
			/*
			$gp_pwd = trim($_POST['gp_pwd']);
			if(md5($gp_pwd) !=  $user_info['passopentwo']){
				$this->error(xstr('third_password_error'));
				exit;
			}*/

			$sNun	= intval($_POST['sNun']);//购买代币的数量

			if (empty ($sNun)) {
				$this->error(xstr('hint161'));
				exit;
			}
			if ($sNun != floor($sNun)) {
				$this->error(xstr('hint162'));
				exit;
			}
			
			$allGupiaoArr = explode('|',$frse['s6']);
			$allGupiao = array_sum($allGupiaoArr );
			$sellCount = intval($frse['gp_sell_count']);
			
			if($sellCount >= $allGupiao)
			{
				$this->error(xstr('hint163'));
				exit;
			}
			
			if($sNun>($allGupiao-$sellCount))
			{
				$this->error(xstr('hint164'));
				exit;
			}

			$needMoney	= bcmul($sNun,$frse['gp_one'],5);//购买代币所需的金额
			$needMoney = ceil($needMoney*100);
			$needMoney /= 100;
			
			if ($needMoney > $user_info['agent_gp'])
			{
				$this->error(xstr('hint_001').'：'.xstr('coin004_not_sufficient_funds_2'));
				exit;
			}
			
			$fck->execute("UPDATE __TABLE__ SET live_gupiao=live_gupiao+".$sNun.",agent_gp=agent_gp-".$needMoney." WHERE `id`=".$id);
			$fee->execute("UPDATE __TABLE__ SET gp_sell_count=gp_sell_count+".$sNun);
			
			$nowDay = strtotime(date('Y-m-d'));
			$nowDayRow = M('Xml')->where(array('x_date'=>$nowDay))->find();
			if($nowDayRow)
			{
				if($frse['gp_one'] != $nowDayRow['money'])
				{
					$xmlData = array();
					$xmlData['id'] = $nowDayRow['id'];
					$xmlData['money'] = $frse['gp_one'];
					$xmlData['amount'] = $sNun;
					M('Xml')->save($xmlData);
				}
			}
			else
			{
				$xmlData = array();
				$xmlData['money'] = $frse['gp_one'];
				$xmlData['amount'] = $sNun;
				$xmlData['x_date'] = $nowDay;
				$xmlData['is_lock'] = 0;
				M('Xml')->add($xmlData);
			}
			$this->ChartsPrice();
			
			//自动升价
			$this->autoChgPrice();

			$bUrl = __URL__ . '/buyyuans';
			$this->_box(1, xstr('hint167'), $bUrl, 3);

		}else{
			$this->error(xstr('error'));
		}
	}
	
	public function autoChgPrice()
	{
		M('Fee')->execute('LOCK TABLE __TABLE__ WRITE');
		M('Fck')->execute('LOCK TABLE __TABLE__ WRITE');
		M('Gp')->execute('LOCK TABLE __TABLE__ WRITE');
		$feeArr = M('Fee')->field('gp_sell_count,last_gp_count,s6,s7,str37,str38,str39')->find();
		$allGuPiaoArr = explode('|',$feeArr['s6']);
		$sellCount = intval($feeArr['gp_sell_count']);
		$chgCfgArr = explode('|',$feeArr['s7']);
		foreach($chgCfgArr as $key => $value)
			$chgCfgArr[$key] = explode(',',$value);
		$oldLast = intval($feeArr['last_gp_count']);
		if($sellCount > $oldLast)
		{
			$index = -1;
			$tAllNum = 0;
			foreach($allGuPiaoArr as $key => $value)
			{
				if($sellCount>$tAllNum && $sellCount<=($tAllNum+$value))
				{
					$index = $key;
					break;
				}
				else
					$tAllNum += $value;
			}
			if($index >= 0)
			{
				$disNum = $sellCount - $oldLast;
				if($disNum >= $chgCfgArr[$index][0])
				{
					$riseCount = intval($disNum/$chgCfgArr[$index][0]);
					M('Fee')->execute('UPDATE __TABLE__ SET gp_one=gp_one+'.(bcmul($riseCount,$chgCfgArr[$index][1],5)).',last_gp_count=last_gp_count+'.(bcmul($riseCount,$chgCfgArr[$index][0],0)));
					//价格有变动，对价格进行检测，如果达到预定值，则进行相应的拆分操作
					$tFeeArr = M('Fee')->field('gp_one')->find();
					if($tFeeArr['gp_one'] >= $feeArr['str37'])
					{
						//设置拆分比率，执行拆分函数
						//gp_cgbl
						$ratioArr = explode(':',$feeArr['str38']);
						$num1 = intval($ratioArr[0]);
						$num2 = intval($ratioArr[1]);
						if($num1>=1 && $num2>=1 && $num1!=$num2)
						{
							$tStr = $num1.':'.$num2;
							M('Fee')->save(array('id'=>1,'gp_cgbl'=>$tStr));
							$this->splitGP(1);
							$this->autoSellAllGP();
							$autoChgPrice = floatval($feeArr['str39']);
							if($autoChgPrice != 0)
								M('Fee')->execute('UPDATE __TABLE__ SET gp_one=gp_one+'.$autoChgPrice);
						}
					}
				}
			}
		}
		M('Fee')->execute('UNLOCK TABLES');
		M('Fck')->execute('UNLOCK TABLES');
		M('Gp')->execute('UNLOCK TABLES');
	}
	
	//检查代币开关是否开发
	private function check_gpopen($type=0){
		$fee_rs = M('fee')->field('gp_kg')->find();
		$gp_kg = $fee_rs['gp_kg'];
		if($type==1){
			if($gp_kg==1){
				$this->error(xstr('hint165'));
				exit;
			}
		}else{
			$this->assign('close_gp', $gp_kg);
		}
	}
	
	//求购代币列表
	public function buyGPform(){
		$this->error(xstr('feature_is_closed'));exit;
		if(!empty($_SESSION[C('USER_AUTH_KEY')])){
			$gupiao = M('gupiao');
			$fck = M('fck');
			$this->check_gpopen();
			
			$fee_rs = M('fee')->field('gp_one,gp_fxnum,gp_senum')->find();
			//当前股价
			$one_price = $fee_rs['gp_one'];
			$gp_fxnum = $fee_rs['gp_fxnum'];//涨价数量
			$gp_senum = $fee_rs['gp_senum'];//已售出
			$ca_gp_n = $gp_fxnum-$gp_senum;//差多少涨价
			$ca_gp_p = ((int)($one_price*$ca_gp_n*100))/100;//差多少钱涨价
			$this->assign('gp_upnum', $ca_gp_n);
			$this->assign('gp_uppri', $ca_gp_p);
			//正在求购的代币
			$gping_num	= $this->buy_and_ing(0);

			$id = $_SESSION[C('USER_AUTH_KEY')];

			import ( "@.ORG.ZQPage" );  //导入分页类
			$where = 'type=0 and id>0 and uid='.$id;
			$field = '*';

			$count = $gupiao->where($where)->field($field)->count();//总页数
			$listrows = 10;//每页显示的记录数
			$Page = new ZQPage($count,$listrows,1);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板
			$list = $gupiao->where($where)->field($field)->order('eDate desc')->page($Page->getPage().','.$listrows)->select();
			foreach($list as $vvv){
				$buy_s = $vvv['buy_s'];
				$is_pay = $vvv['ispay'];
				if($is_pay==1){
					$can_b = 0;
				}else{
					$can_b = floor($buy_s/$one_price);
				}
				$tvo[$vvv['id']] = $can_b;
			}
			$this->assign('list', $list);
			$this->assign('tvo', $tvo);


			$fck_rs = $fck->where("id=$id")->field("agent_gp,xf_money,live_gupiao")->find();
			$this->assign('fck_rs', $fck_rs);

			$this->assign('one_price', $one_price);
			$this->assign('live_gp', $gp_info[0]);//剩余的代币
			$this->assign('gping_num', $gping_num);//正在求购的代币

			$_SESSION['GP_Sesion_Buy'] = 'OK';

			$this->display('buyGPform');
		}else{
			$this->error(xstr('error'));
		}
	}


	public function sellGPform() { //出售代币
		$this->error(xstr('feature_is_closed'));exit;
		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}
		$GPmj = M('gupiao');
		$gp_sell = M('gp_sell');
		$fck = M('fck');
		
		$fee_rs = M('fee')->field('gp_one')->find();
		//当前股价
		$one_price = $fee_rs['gp_one'];

		$id = $_SESSION[C('USER_AUTH_KEY')];

		import ( "@.ORG.ZQPage" );  //导入分页类

		$where = 'type=1 and id>0 and uid='.$id;
		$field = '*';

		$count = $GPmj->where($where)->field($field)->count();//总页数
		$listrows = 15;//每页显示的记录数
		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板

		$list = $GPmj->where($where)->field($field)->order('eDate desc')->page($Page->getPage().','.$listrows)->select();
		$user_rs = $fck->where("id=$id")->field("agent_gp")->find();
		$game_m	= $user_rs['agent_gp'];//剩余的代币
		$this->assign('game_m', $game_m);

		$this->assign('one_price',$one_price);
		$this->assign('list', $list);

		$twhere = array();
		$twhere['uid'] = array('eq',$id);
		$twhere['sNun'] = array('gt',0);
// 		$twhere['is_over'] = array('eq',0);
		$field1 = "*";

		$tcount = $gp_sell->where($twhere)->field($field1)->count();//总页数
		$Page2 = new ZQPage($tcount,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show2 = $Page2->show();//分页变量
		$this->assign('page_t',$show2);//分页变量输出到模板

		$list2 = $gp_sell->where($twhere)->field($field1)->order('id desc')->page($Page2->getPage().','.$listrows)->select();
		$this->assign('list_t', $list2);

		$_SESSION['GP_Sesion_Sell'] = 'OK';
		
		$this->display('sellGPform');
		
	}

	public function sellGPform_N() { //出售代币
		$this->error(xstr('feature_is_closed'));exit;
		//$this->_Admin_checkUser();
		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}
		$GPmj = M('gupiao');
		$fck = M('fck');

		$this->check_gpopen();
			
		$fee_rs = M('fee')->field('gp_one')->find();
		//当前股价
		$one_price = $fee_rs['gp_one'];
		//代币的信息
		$gp_info	= $this->gpInfo();
		//正在出售的代币
		$gping_num	= $this->buy_and_ing(1);

		$id = $_SESSION[C('USER_AUTH_KEY')];

		import ( "@.ORG.ZQPage" );  //导入分页类

		$where = 'type=1 and id>0 and uid='.$id;
		$field = '*';

		$count = $GPmj->where($where)->field($field)->count();//总页数
		$listrows = 15;//每页显示的记录数
		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量
		$this->assign('page',$show);//分页变量输出到模板

		$list = $GPmj->where($where)->field($field)->order('eDate desc')->page($Page->getPage().','.$listrows)->select();
		$fck_rs = $fck->where("id=$id")->field("agent_gp,xf_money,live_gupiao")->find();
		$this->assign('fck_rs', $fck_rs);

		$this->assign('one_price',$one_price);
		$this->assign('live_gp', $gp_info[0]);//剩余的代币
		$this->assign('gping_num', $gping_num);//正在出售的代币
		$this->assign('list', $list);


		$_SESSION['GP_Sesion_Sell'] = 'OK';

		$this->display();
	}

	//代币买卖历史
	public function gpHistory(){
		if(!empty($_SESSION[C('USER_AUTH_KEY')]) && ($_SESSION['UrlszUserpass'] == 'gpHistory')){
			$id	= $_SESSION[C('USER_AUTH_KEY')];
			$GPmj = M('hgupiao');
			$fck = M('fck');
			$fee = M ('fee');

			$rs = $fee->find();
			$one_price = $rs['str1'];//当前代币价格
			$gp_info	= $this->gpInfo();//代币的信息
			$gping_num0	= $this->buy_and_ing(0);//正在求购的代币
			$gping_num1	= $this->buy_and_ing(1);//正在出售的代币

			import ( "@.ORG.ZQPage" );  //导入分页类

			$where = "uid=$id"; //买卖记录
			$field = '*';

			$count = $GPmj->where($where)->field($field)->count();//出售总页数
			$listrows = 15;//每页显示的记录数

			$Page = new ZQPage($count,$listrows,1);
			//===============(总页数,每页显示记录数,css样式 0-9)
			$show = $Page->show();//分页变量
			$this->assign('page',$show);//分页变量输出到模板

			$list = $GPmj->where($where)->field($field)->order('eDate desc')->page($Page->getPage().','.$listrows)->select();
			$this->assign('one_price', $one_price);

			$this->assign('list', $list);
			$this->assign('live_gp', $gp_info[0]);//剩余的代币
			$this->assign('all_in_gp', $gp_info[1]);//成功售出
			$this->assign('all_out_gp', $gp_info[2]);//成功买入
			$this->assign('gping_num0', $gping_num0);//正在求购的代币
			$this->assign('gping_num1', $gping_num1);//正在求购的代币
			$this->display();
			exit;
		}
	}
	
	public function sellGP_Next() {//出售代币
		$this->error(xstr('feature_is_closed'));exit;
		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}
		if(empty($_SESSION['GP_Sesion_Sell'])){
			$this->error(xstr('hint166'));
			exit;
		}
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$hgp = M('hgupiao');
		$gupiao = M('gupiao');//
		$gp_sell = M('gp_sell');//售股信息表
		$fck = D('Fck');
		$fee = M ('fee');

		$this->gpxz_sell_a();

		$fee_rs = $fee ->find();
		$one_price	= $fee_rs['str1'];
		$this->assign('one_price',$one_price);
		$close_gp	= $fee_rs['str3'];//代币交易开关,1为关闭
		$this->assign('close_gp',$close_gp);
		$jj_t11	= explode("|",$fee_rs['str13']);//竞价出售开始时间
		$jj_t12	= explode("|",$fee_rs['str14']);//竞价出售结束时间

		$start_t = $jj_t11[0].":".$jj_t11[1].":".$jj_t11[2];//组合分割的时间
		$end_t = $jj_t12[0].":".$jj_t12[1].":".$jj_t12[2];//组合分割的时间

		$time_ss = strtotime($start_t);//运用时间戳对比，开始时间
		$time_se = strtotime($end_t);//结束时间
		$now_time = strtotime(date("H:i:s",time()));//现在时间

		//检查交易密码及其他
		$user_info	= $fck->where("id=".$id)->field("id,live_gupiao,user_id,passopentwo,re_path,max_jy,u_level")->find();

		$my_lv = $user_info['u_level'];//级别

		$cur_one_price	= $fee_rs['str1'];//系统设置的代币价格

		$day_week	= $fee_rs['str20'];//运行出售日期

		$use	= $user_info['live_gupiao'];//剩余的代币

		if($close_gp == 1){
			$this->error(xstr('hint168'));
			exit;
		}

		if($now_time<$time_ss||$now_time>$time_se){
			$this->error(xstr('hint169'));
			exit;
		}

		$nowweek = date("w");
		if($nowweek==0){
			if(strpos($day_week,',7,')!==false){
			//允许运行
			}else{
				$this->error(xstr('hint170'));
				exit;
			}
		}else{
			if(strpos($day_week,','.$nowweek.',')!==false){
				//允许运行
			}else{
				$this->error(xstr('hint170'));
				exit;
			}
		}

		$next_min_d = 20;//20天才可再次交易
//		$next_min_d = 0;//20天才可再次交易

		$tid = (int)$_GET['tid'];

		$where = array();
		$where['id'] = array('eq',$tid);
		$where['is_over'] = array('eq',0);
		$where['uid'] = array('eq',$id);

		$trs = $gp_sell->where($where)->find();
		if($trs){
			$tgpid = $trs['id'];
			$gpuid = $trs['uid'];
			$last_d = $trs['sell_date'];
			$next_d = $last_d+3600*24*$next_min_d;
			$now_ddd = mktime();
			if($next_d>$now_ddd){
				$this->error(xstr('hint171').$next_min_d.xstr('hint172'));
				exit;
			}
			$ln_num = $trs['sell_ln'];//剩余
			$sell_m = $trs['sell_mon'];//售出总数
			$sell_n = $trs['sell_num'];//售出次数
			$mmsNun = $trs['sNun'];//总量
			$chus = 3-$sell_n;//被除数
			if($sell_n==2){
				$now_sell_num = $ln_num;
				$is_over = 1;
			}else{
				$now_sell_num = floor($ln_num/$chus);
				$is_over = 0;
			}
			$this->assign('tid',$tid);
		}else{
			$this->error(xstr('hint173'));
			exit;
		}

		$sNun = $now_sell_num;
		if($sNun>0){
			$this->assign('sNun',$sNun);
		}
		$this->display();
	}

	public function A_sellGP() { //出售代币
		$this->error(xstr('feature_is_closed'));exit;
		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}
		if(empty($_SESSION['GP_Sesion_Sell'])){
			$this->error(xstr('hint166'));
			exit;
		}
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$hgp = M('hgupiao');
		$gupiao = M('gupiao');//
		$gp_sell = M('gp_sell');//售股信息表
		$fck = D('Fck');
		$fee = M ('fee');

		$this->gpxz_sell_a();

		

		$fee_rs = $fee ->find();
		$now_price	= $fee_rs['str1'];
//		$one_price = $_POST['one_price'];//表单传来的代币单价
		$one_price = $now_price;
		$close_gp	= $fee_rs['str3'];//代币交易开关,1为关闭
		
		$max_price = $now_price+0.01;
		$min_price = $now_price-0.01;
		if($one_price>$max_price||$one_price<$min_price){
			$this->error(xstr('hint174'));
			exit;
		}
		
		$jj_t11	= explode("|",$fee_rs['str13']);//竞价出售开始时间
		$jj_t12	= explode("|",$fee_rs['str14']);//竞价出售结束时间

		$start_t = $jj_t11[0].":".$jj_t11[1].":".$jj_t11[2];//组合分割的时间
		$end_t = $jj_t12[0].":".$jj_t12[1].":".$jj_t12[2];//组合分割的时间

		$time_ss = strtotime($start_t);//运用时间戳对比，开始时间
		$time_se = strtotime($end_t);//结束时间
		$now_time = strtotime(date("H:i:s",time()));//现在时间

		//检查交易密码及其他
		$user_info	= $fck->where("id=".$id)->field("id,live_gupiao,user_id,passopentwo,re_path,max_jy,u_level")->find();

		$my_lv = $user_info['u_level'];//级别

		$cur_one_price	= $fee_rs['str1'];//系统设置的代币价格

		$day_week	= $fee_rs['str20'];//运行出售日期

		$use	= $user_info['live_gupiao'];//剩余的代币
//		$gp_pwd = trim($_POST['gp_pwd']);
//		if(md5($gp_pwd) !=  $user_info['passopentwo']){
//			$this->error(xstr('third_password_error'));
//			exit;
//		}

		if($close_gp == 1){
			$this->error(xstr('hint168'));
			exit;
		}

		if($now_time<$time_ss||$now_time>$time_se){
			$this->error(xstr('hint169'));
			exit;
		}

		$nowweek = date("w");
		if($nowweek==0){
			if(strpos($day_week,',7,')!==false){
			//允许运行
			}else{
				$this->error(xstr('hint170'));
				exit;
			}
		}else{
			if(strpos($day_week,','.$nowweek.',')!==false){
				//允许运行
			}else{
				$this->error(xstr('hint170'));
				exit;
			}
		}

		$next_min_d = 20;//20天才可再次交易
//		$next_min_d = 0;//20天才可再次交易

		$tid = (int)$_GET['tid'];

		$where = array();
		$where['id'] = array('eq',$tid);
		$where['is_over'] = array('eq',0);
		$where['uid'] = array('eq',$id);

		$trs = $gp_sell->where($where)->find();
		if($trs){
			$tgpid = $trs['id'];
			$gpuid = $trs['uid'];
			$last_d = $trs['sell_date'];
			$next_d = $last_d+3600*24*$next_min_d;
			$now_ddd = mktime();
			if($next_d>$now_ddd){
				$this->error(xstr('hint171').$next_min_d.xstr('hint172'));
				exit;
			}
			$ln_num = $trs['sell_ln'];//剩余
			$sell_m = $trs['sell_mon'];//售出总数
			$sell_n = $trs['sell_num'];//售出次数
			$mmsNun = $trs['sNun'];//总量
			$chus = 3-$sell_n;//被除数
			if($sell_n==2){
				$now_sell_num = $ln_num;
				$is_over = 1;
			}else{
				$now_sell_num = floor($ln_num/$chus);
				$is_over = 0;
			}

			$last_sellmon = $sell_m+$now_sell_num;
			$last_sellnum = $sell_n+1;
			$last_ln = $ln_num-$now_sell_num;

			$s_pid = $trs['id'];
			if($last_sellnum<3){
				$s_last = 0;
			}else{
				$s_last = 1;
			}

		}else{
			$this->error(xstr('hint173'));
			exit;
		}

		$swh = array();
		$swh['id'] = array('eq',$tgpid);
		$swh['is_over'] = array('eq',0);
		$swh['uid'] = array('eq',$id);

		$valuearr = array(
					'sell_ln'	=> $last_ln,
					'sell_mon'	=> $last_sellmon,
					'sell_num'	=> $last_sellnum,
					'sell_date'	=> mktime(),
					'is_over'	=> $is_over
					);

		$gp_sell->where($swh)->setField($valuearr);

		$sNun = $now_sell_num;
		if($sNun>0){
			$this->sell_GPAC($id,$user_info['user_id'],$sNun,$s_pid,$s_last,$one_price);
		}

		$_SESSION['GP_Sesion_Sell'] = "";

		$bUrl = __URL__ . '/sellGPform';
		$this->_box(1, xstr('hint175'), $bUrl, 3);
		exit;
	}


	public function sellGP() { //出售代币

		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}
		if(empty($_SESSION['GP_Sesion_Sell'])){
			$this->error(xstr('hint166'));
			exit;
		}
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$fck = D('Fck');
		$fee = M ('fee');
		
		$this->check_gpopen(1);

		$one_price = $_POST['one_price'];//表单传来的代币单价
		
		$fee_rs = $fee ->find();
		$cur_one_price	= $fee_rs['gp_one'];//系统设置的代币价格
		$max_num	= PHP_MAX_INT;//10000000;

		//检查交易密码及其他
		$user_info	= $fck->where("id=".$id)->field("id,live_gupiao,user_id,passopen,re_path,u_level")->find();
		$use	= $user_info['live_gupiao'];//剩余的代币
		$gp_pwd = trim($_POST['gp_pwd']);
		if(md5($gp_pwd) !=  $user_info['passopen']){
			$this->error(xstr('second_password_error'));
			exit;
		}

		$sNun	= trim($_POST['sNun']);//出售代币的数量

		if (empty ($sNun)||$sNun<=0) {
			$this->error(xstr('hint176'));
			exit;
		}
		if ($sNun != floor($sNun)) {
			$this->error(xstr('hint162'));
			exit;
		}

		if ($sNun>$max_num) {
			$this->error(xstr('hint177').$max_num.' ！');
			exit;
		}

		if ($sNun > $use) {
			$this->error(xstr('hint_001').'：'.xstr('hint178').$use);
			exit;
		}

		$this->sell_GPAC($id,$user_info['user_id'],$sNun,0,0,$one_price);

		$_SESSION['GP_Sesion_Sell'] = "";

		$bUrl = __URL__ . '/sellGPform_N';
		$this->_box(1, xstr('hint179'), $bUrl, 3);
		exit;
	}

	public function sell_GPAC($uid,$user_id,$sNunb=0,$spid=0,$ssn=0,$o_pri=0){
		return;
		$fck = D('Fck');
		$gupiao = M('gupiao');
		$fee = M('fee');
		$game = D('Game');
		
		$this->check_gpopen(1);
		
		$one_price = $o_pri;
		$fee_rs = $fee ->find();
		$now_price	= $fee_rs['gp_one'];//系统设置的代币价格
		if(empty($one_price)){
			$one_price = $now_price;
		}

		$sNunb = (int)$sNunb;//卖出数
		$ok_sell = 0;//成功卖出数
		$ok_over = 0;//结束卖操作
		while($ok_over==0){

			$sNun = $sNunb-$ok_sell;
			if($sNun>0){
				$map = array();
				$map['type']	= array('eq',0);//求购代币的标识
				$map['status']	= array('eq',0);//没有作废的标识
				$map['ispay']	= array('eq',0);//没有交易完成的标识
				$map['is_en']	= array('eq',0);//标准代币
				$map['one_price']	= array('eq',$one_price);//价格
				$order	= "eDate asc,id asc";//时间先后顺序
				$list_gp	= $gupiao->where($map)->field("*")->order($order)->find();
				if($list_gp){
					$gpid	= $list_gp['id'];
					$gpuid  = $list_gp['uid'];
					$buy_s  = $list_gp['buy_s'];//剩余总值
					$scan_b = floor($buy_s/$one_price);//当前购买力

					if($scan_b == 0){//说明该交易完成了【再判断一次，以防程序出错】
						$gupiao->query("update __TABLE__ set ispay=1 where id=".$gpid);
						sleep(1);//休眠1秒以免程序运行过快数据未处理;
					}

					$lnum	= $scan_b;//剩余
					$i_ispay = $list_gp['ispay'];//成功标签
					$buy_a = $list_gp['buy_a'];//已购买总额
					$buy_nn = $list_gp['buy_nn'];//已购买量
					if($lnum<=$sNun){

						$us_money = $lnum*$one_price;//使用额度

						$s_buy_s = $buy_s-$us_money;//过后剩余总值
						$s_buy_a = $buy_a+$us_money;//过后已购买总额
						$s_buy_nn = $buy_nn+$lnum;//过后已购买量

						$s_ispay = 1;
						$se_numb = $lnum;
					}else{

						$us_money = $sNun*$one_price;//使用额度

						$s_buy_s = $buy_s-$us_money;//过后剩余总值
						$s_buy_a = $buy_a+$us_money;//过后已购买总额
						$s_buy_nn = $buy_nn+$sNun;//过后已购买量

						$s_ispay = 0;
						$se_numb = $sNun;
					}
					$do_where = "id=".$gpid." and buy_a=".$buy_a." and buy_nn=".$buy_nn." and buy_s=".$buy_s." and ispay=".$i_ispay."";
					$do_sql = "update __TABLE__ set buy_s=".$s_buy_s.",buy_a=".$s_buy_a.",buy_nn=".$s_buy_nn.",ispay=".$s_ispay.",used_num=used_num+".$se_numb." where ".$do_where;
					$do_relute = $gupiao->execute($do_sql);//返回影响的行数

					if($do_relute!=false){//上一个语句是否存在行数

						if($s_ispay==1){
							//自动生成卖出信息
							$this->addsell_gp($gpuid,$s_buy_nn,$one_price);
							if($s_buy_s>0){
								$fck->execute("UPDATE __TABLE__ SET agent_gp=agent_gp+".$s_buy_s.",agent_lock=agent_lock+".$s_buy_s." WHERE `id`=".$gpuid."");
							}
						}

						$ok_sell = $ok_sell+$se_numb;

						//更新对方的代币信息
						$fck->execute("UPDATE __TABLE__ SET live_gupiao=live_gupiao+".$se_numb.",all_in_gupiao=all_in_gupiao+".$se_numb." WHERE `id`=".$gpuid."");
						//记录成功交易的代币信息
						$this->gpSuccessed($gpuid,$se_numb,0,$fee_rs,$gpid,0,0,$uid);

					}
				}else{
					$ok_over = 1;
				}
				unset($list_gp);
			}else{
				$ok_over = 1;
			}
		}

		$id = $uid;

		//更新自己的售股信息
		$data['uid'] = $uid;
		$data['one_price'] = $one_price;
		$data['price'] = $sNunb*$one_price;//总得代币金额
		$data['sNun'] = $sNunb;//总的代币数
		$data['used_num'] = $ok_sell;//成功买到的代币
		$data['lnum'] = $sNunb - $ok_sell;//还差没有售出的代币
		$data['ispay'] = ($sNunb - $ok_sell<=0)?1:0;//交易是否完成
		$data['eDate'] = mktime();//售出时间
		$data['status'] = 0;//这条记录有效
		$data['type'] = 1;//标识为售出
		$data['is_en'] = 0;//标准股
		$data['spid'] = $spid;//原卖出记录ID
		$data['last_s'] = $ssn;//是否最后一次卖出
		$data['sell_g'] = $ok_sell*$one_price;//售出获得总额
		$resid = $gupiao->add($data);//添加记录
		//记录成功交易的代币信息
		if($ok_sell>0){
			$this->gpSuccessed($uid,$ok_sell,1,$fee_rs,$resid,0,1);
		}
		
		$this->sellOutGp($id,0,$one_price,$fee_rs,$game,$sNunb);
		
		unset($fck,$fee,$gupiao,$game,$fee_rs);
	}
	
	//购买处理
	public function buyGP(){
		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$gupiao = M('gupiao');//购股信息表
		$fck = M('fck');
		$fee = M ('fee');
		$gp = M('gp');
		
		$this->check_gpopen(1);

		$one_price = $_POST['one_price'];//表单传来的求购金额

		$fee_rs = $fee ->find();
		$cur_one_price	= $fee_rs['gp_one'];//系统设置的代币价格
		$gp_fxnum = $fee_rs['gp_fxnum'];//涨价数量
		$gp_senum = $fee_rs['gp_senum'];//已售出
		$ca_gp_n = $gp_fxnum-$gp_senum;//差多少涨价
		$ca_gp_p = ((int)($cur_one_price*$ca_gp_n*100))/100;
		
		//检查交易密码
		$user_info	= $fck->where("id=$id")->field("agent_gp,agent_lock,user_id,passopen")->find();
		$myuser_id = $user_info['user_id'];
		$use	= $user_info['agent_gp'];//可以的代币
		$gp_pwd = trim($_POST['gp_pwd']);
		if(md5($gp_pwd)!= $user_info['passopen']){
			$this->error(xstr('second_password_error'));
			exit;
		}
// 		if($user_info['agent_lock']<=0){
// 			$this->error("等待循环出局，不能再购买代币！");
// 			exit;
// 		}

		$sNun	= trim($_POST['sNun']);//购买代币数量
		//$sNun	= (int)($this->numb_duibi($buy_mm,$cur_one_price));
		$buy_mm = $one_price * $sNun;
		$buy_mm = $this->_2Mal($buy_mm ,2);

		if (empty ($sNun)||$sNun<=0) {
			$this->error(xstr('hint180'));
			exit;
		}
		if($sNun>$ca_gp_n){
			$this->error('距离下次涨价只能购买'.$ca_gp_n.'代币，请检验后再试！');
			exit;
		}

		if (bccomp($buy_mm, $use, 2)>0){
			$this->error('你的代币会员余额不足 '.$buy_mm.'。请检验后再试！');
			exit;
		}
//		$map = array();
//		$map['type']	= array('eq',1);//售出代币的标识
//		$map['status']	= array('eq',0);//没有作废的标识
//		$map['ispay']	= array('eq',0);//没有交易完成的标识
//		$order	= "eDate asc,id asc";//时间先后顺序
//		$list_gp	= $gupiao->where($map)->field("*")->order($order)->find();
//		if(!$list_gp){
//			$this->error("市场上还没有代币出售，还不能购买");
//		}

// 		if($user_info['agent_lock']<$buy_mm){
// 			$this->error("您会员级别最多只能再购买价值：".$user_info['agent_lock']."的代币！");
// 			exit;
// 		}

		//代币交易
		$this->buy_GPAC($id,$myuser_id,$sNun,$one_price);

		$bUrl = __URL__ . '/buyGPform';
		$this->_box(1, xstr('hint181'), $bUrl, 3);
	}
	
	//购买交易算法
	public function buy_GPAC($uid,$user_id,$sNunb=0,$o_pri=0){
		return;
		$fck = D('Fck');
		$gupiao = M('gupiao');
		$fee = M('fee');
		$game = D('Game');

		$fee_rs = $fee ->find();
		
		$one_price = $o_pri;
		$bmoney = $sNunb * $o_pri;//求购总值
		$bmoney = $this->_2Mal($bmoney ,2);
		
//		$can_buy = round($bmoney/$one_price);
		//$can_buy = floor($this->numb_duibi($bmoney,$one_price));

		$ok_buy = 0;//成功买入数
		$ok_over = 0;//结束买操作
		while($ok_over==0){
			$sNun = $sNunb-$ok_buy;
			if($sNun>0){
				$map = array();
				$map['type']	= array('eq',1);//售出代币的标识
				$map['status']	= array('eq',0);//没有作废的标识
				$map['ispay']	= array('eq',0);//没有交易完成的标识
				$map['one_price']	= array('eq',$one_price);//价格
				$order	= "eDate asc,id asc";//时间先后顺序
				$list_gp	= $gupiao->where($map)->field("*")->order($order)->find();
				if($list_gp){
					$gpid	= $list_gp['id'];
					$gpuid  = $list_gp['uid'];
					if(($list_gp['sNun'] == $list_gp['used_num']) || ($list_gp['lnum'] == 0)){//说明该交易完成了【再判断一次，以防程序出错】
						$gupiao->query("update __TABLE__ set ispay=1 where id=".$gpid);
						usleep(500000);//休眠5000毫秒以免程序运行过快数据未处理;
					}

					$ussNun	= $list_gp['sNun'];//全部
					$used_num	= $list_gp['used_num'];//已使用
					$lnum	= $list_gp['lnum'];//剩余
					$sell_g = $list_gp['sell_g'];//已售出总额
					$i_ispay = $list_gp['ispay'];//成功标签
					if($lnum<=$sNun){

						$us_money = $lnum*$one_price;//使用额度

						$s_sell_g = $sell_g+$us_money;//过后已售出总额
						$s_used_n = $ussNun;//过后已使用
						$s_lnum = 0;//过后剩余
						$s_ispay = 1;
						$se_numb = $lnum;
					}else{

						$us_money = $sNun*$one_price;//使用额度

						$s_sell_g = $sell_g+$us_money;//过后已售出总额
						$s_used_n = $used_num+$sNun;//过后已使用
						$s_lnum = $lnum-$sNun;//过后剩余
						$s_ispay = 0;
						$se_numb = $sNun;
					}
					$do_where = "id=".$gpid." and sNun=".$ussNun." and used_num=".$used_num." and lnum=".$lnum." and ispay=".$i_ispay."";
					$do_sql = "update __TABLE__ set used_num=".$s_used_n.",lnum=".$s_lnum.",sell_g=".$s_sell_g.",ispay=".$s_ispay." where ".$do_where;
					$do_relute = $gupiao->execute($do_sql);//返回影响的行数

					if($do_relute!=false){//上一个语句是否存在行数

						$ok_buy = $ok_buy+$se_numb;

						//更新对方成功出售的代币信息
						$this->sellOutGp($gpuid,$gpid,$se_numb,$fee_rs,$game,$one_price);
						//记录成功交易的代币信息
						$this->gpSuccessed($gpuid,$se_numb,1,$fee_rs,$gpid,0,0,$uid);

					}
				}else{
					$ok_over = 1;
				}
				unset($list_gp);
			}else{
				$ok_over = 1;
			}
		}

		$id = $uid;

		$lv_nnm = $sNunb - $ok_buy;
		$all_bm = $ok_buy*$one_price;//购买总金额
		$lv_money = $bmoney-$all_bm;//差额

		//更新自己的购股信息
		$data['uid'] = $id;
		$data['one_price'] = $one_price;
		$data['price'] = $bmoney;//总金额
		$data['sNun'] = 0;//总的代币数
		$data['used_num'] = 0;//成功买到的代币
		$data['lnum'] = 0;//还差没有买到的代币
		$data['ispay'] = ($lv_nnm<=0)?1:0;//交易是否完成
		$data['eDate'] = mktime();//购买时间
		$data['status'] = 0;//这条记录有效
		$data['type'] = 0;//标识为求股
		$data['is_en'] = 0;//标准股

		$data['buy_a'] = $all_bm;
		$data['buy_nn'] = $ok_buy;
		$data['buy_s'] = $lv_money;
		if($lv_nnm==0){
			if($lv_money>0){
				$fck->execute("UPDATE __TABLE__ SET agent_gp=agent_gp+".$lv_money.",agent_lock=agent_lock+".$lv_money." WHERE `id`=".$id."");
			}
		}
		$resid = $gupiao->add($data);//添加记录
		//记录成功交易的代币信息
		if($ok_buy>0){
			$this->gpSuccessed($id,$ok_buy,0,$fee_rs,$resid,0,1);
		}
		//小于零时，自动生成卖出信息
		$lv_n = $sNunb - $ok_buy;
		if($sNunb>0){
			$this->addsell_gp($id,$sNunb,$one_price);
		}
		$gm = $sNunb*$one_price;//购股所花费的金额
		$hm	= $ok_buy*$one_price;//已经用在买代币上的钱
		$game->updateGameCash($id,$hm);
		//更新fck表中的代币信息
		$fck->execute("UPDATE __TABLE__ SET live_gupiao=live_gupiao+".$ok_buy.",all_in_gupiao=all_in_gupiao+".$ok_buy.",agent_gp=agent_gp-".$bmoney.",agent_lock=agent_lock-".$bmoney." WHERE `id`=".$id."");
		$fck->execute("UPDATE __TABLE__ SET agent_lock=0 WHERE `id`=".$id." and agent_lock<0");
		unset($fck,$fee,$gupiao,$game,$fee_rs);
	}

	public function delbuyGP() {
		$this->error(xstr('feature_is_closed'));exit;
		$del = M('gupiao');
		$fck = M('fck');
		$gp_sell = M('gp_sell');
		$id	= $_SESSION[C('USER_AUTH_KEY')];

		if(empty($id)){
			$this->error(xstr('hint182'));
			exit;
		}

		$where['id'] = $_GET['id'];
		$where['uid'] = $id;
		//选出该条记录的信息
		$del_info = $del->where($where)->field("*")->find();
		if(empty($del_info)){
			$this->error(xstr('hint183'));
			exit;
		}

		$buy_s	= $del_info['buy_s'];//剩余总价

		$fck->execute("UPDATE __TABLE__ SET agent_gp=agent_gp+".$buy_s." WHERE `id`=".$del_info['uid']);
		$bUrl = __URL__ . '/buyGPform';

		//撤销的话要更新代币表
		$data['ispay']	= 1;
		$data['is_cancel']	= 1;

		$rs = $del->where($where)->save($data);
		if ($rs) {

			$sNunb = $del_info['buy_nn'];
			$wdata = array();
			$wdata['uid'] = $id;
			$wdata['sNun'] = $sNunb;
			$wdata['eDate'] = mktime();
			$wdata['sell_ln'] = $sNunb;
			$gp_sell->add($wdata);

			$this->_box(1, xstr('cancel_success'), $bUrl, 1);
		}else{
			$this->error(xstr('cancel_failed'));
		}

	}

	public function delsellGP() {
		$this->error(xstr('feature_is_closed'));exit;
		$del = M('gupiao');
		$fck = M('fck');
		$id	= $_SESSION[C('USER_AUTH_KEY')];

		if(empty($id)){
			$this->error(xstr('hint182'));
			exit;
		}

		$where['id'] = $_GET['id'];
		$where['uid'] = $id;
		//选出该条记录的信息
		$del_info = $del->where($where)->field("*")->find();
		if(empty($del_info)){
			$this->error(xstr('hint183'));
			exit;
		}

		$sNun	= $del_info['sNun'];//总得交易数
		$used_num	= $del_info['used_num'];//成功成交得数量
		$lnum	= $del_info['lnum'];//余下的数量

		if ($lnum+$used_num != 0){
			//交易成功跟余下的数量不等于0
			if($lnum+$used_num != $sNun){
				$this->error(xstr('hint184'));
				exit;
			}
		}

		//没有售出的那部分代币还给他
		$fck->execute("UPDATE __TABLE__ SET live_gupiao=live_gupiao+".$lnum." WHERE `id`=".$del_info['uid']);
		$bUrl = __URL__ . '/sellGPform_N';

		$cx_content = "撤销出售 ".$lnum." 个";

		//撤销的话要更新代币表
		$data['ispay']	= 1;
		$data['is_cancel']	= 1;
		$data['sNun']	= $del_info['used_num'];
		$data['lnum']	= 0;
		$data['bz']	= $cx_content;
		$rs = $del->where($where)->save($data);
		if($rs){
			$this->_box(1, xstr('cancel_success'), $bUrl, 1);
		}else{
			$this->error(xstr('cancel_failed'));
		}

	}

	public function us_delsellgpAC() {
		$this->error(xstr('feature_is_closed'));exit;
		$del = M('gupiao');
		$fck = M('fck');
		$gp_sell = M('gp_sell');
		$id	= $_SESSION[C('USER_AUTH_KEY')];

		if(empty($id)){
			$this->error(xstr('hint182'));
			exit;
		}

		$where['id'] = $_GET['id'];
		$where['uid'] = $id;
		//选出该条记录的信息
		$del_info = $del->where($where)->field("*")->find();
		if(empty($del_info)){
			$this->error(xstr('hint183'));
			exit;
		}

		$sNun	= $del_info['sNun'];//总得交易数
		$used_num	= $del_info['used_num'];//成功成交得数量
		$lnum	= $del_info['lnum'];//余下的数量

		if ($lnum+$used_num != 0){
			//交易成功跟余下的数量不等于0
			if($lnum+$used_num != $sNun){
				$this->error(xstr('hint184'));
				exit;
			}
		}

		$last_s = $del_info['last_s'];
		if($last_s==1){
			$this->error(xstr('hint185'));
			exit;
		}

		$spid = $del_info['spid'];
		$y_rd = 1;//是否原数据读出
		if($spid>0){
			$s_c = $gp_sell->where('id='.$spid.' and sell_num<3')->count();
			if($s_c==0){
				$this->error(xstr('hint185'));
				exit;
			}
		}else{
			$s_rs = $gp_sell->where('uid='.$id.' and sell_num<3')->field('id,uid')->order('sell_date desc')->find();
			if(!$s_rs){
				$this->error(xstr('hint185'));
				exit;
			}else{
				$spid = $s_rs['id'];
				$y_rd = 0;
			}
		}

		$xz_hour = 1;
		$eDate = $del_info['eDate'];
		$n_edate = $eDate+3600*$xz_hour;
		if($n_edate>mktime()){
			$this->error(xstr('hint186').$xz_hour.xstr('hint187'));
			exit;
		}

		$where['sNun'] = array('eq',$sNun);
		$where['used_num'] = array('eq',$used_num);
		$where['lnum'] = array('eq',$lnum);

		$cx_content = "撤销出售 ".$lnum." 个";

		//撤销的话要更新代币表
		$data['ispay']	= 1;
		$data['is_cancel']	= 1;
		$data['sNun']	= $del_info['used_num'];
		$data['lnum']	= 0;
		$data['bz']	= $cx_content;
		$rs = $del->where($where)->save($data);
		if($rs){

			//没有售出的那部分代币还给他
			if($y_rd==1){
				$gp_sell->execute("UPDATE __TABLE__ SET sell_ln=sell_ln+".$lnum.",sell_mon=sell_mon-".$lnum." WHERE `id`=".$spid);
			}else{
				$gp_sell->execute("UPDATE __TABLE__ SET sNun=sNun+".$lnum.",sell_ln=sell_ln+".$lnum." WHERE `id`=".$spid);
			}

			$fck->execute("UPDATE __TABLE__ SET live_gupiao=live_gupiao+".$lnum." where id=".$id);

			$bUrl = __URL__ . '/sellGPform';
			$this->_box(1, xstr('cancel_success'), $bUrl, 1);
		}else{
			$this->error(xstr('cancel_failed'));
		}

	}
  
	//卖家交易出去后处理
	public function sellOutGp($uid=0,$gpid=0,$out_n=0,$fee_rs=0,$game=0,$senum=0){
		return;
		$fck = D('Fck');
		$mrs = $fck->where('id='.$uid)->field('id,user_id')->find();
		
		//$one_price = $fee_rs['gp_one'];//达人挂起的价格
		//$gp_perc = $fee_rs['gp_perc']/100;//交易手续费
		$in_usmoney = 0;
		$in_gpmoney = 0;
		$la_money = $senum*$out_n;//售出代币金额
		if($get_money>0){
			//$shuis = $get_money*$gp_perc;//税收
			//$la_money = $get_money-$shuis;//税后
			
			$game->setGameCash($uid,$la_money);
			
			//$fck->addencAdd($uid,$mrs['user_id'], $la_money, 31);//添加奖金和记录
		}
		//更新会员
		$fck->query("update __TABLE__ SET " .
			"live_gupiao=live_gupiao-".$senum.",all_out_gupiao=all_out_gupiao+".$senum.
			",agent_gp=agent_gp+".$la_money."" .
			" WHERE `id`=$uid");
		unset($fck,$game,$mrs,$fee_rs);
	}

	//把交易成功的记录写入到一个表中【不能删除的】
	public function gpSuccessed($uid=0,$out_n=0,$type=0,$fee_rs=0,$gpid=0,$en=0,$ett=0,$did=0){

		return;
		
		$hgp=M('hgupiao');
		$gp = M('gupiao');
		$grs = $gp->where('id='.$gpid)->find();
		$cur_one_price	= $grs['one_price'];//达人挂起的价格

		$gm	= $out_n*$cur_one_price;//售出代币金额
		//添加记录到表
		$data['uid'] = $uid;
		$data['price'] = $gm;
		$data['one_price'] = $cur_one_price;
		$data['sNun'] = $out_n;
		$data['ispay'] = 1;
		$data['eDate'] = time();
		$data['type'] = $type;
		if($type==1){
			//$fee_money	= $fee_rs['str2']/100;//代币的税费
			//$shuis = $gm*$fee_money;//税收
			//$la_sh = $gm - $shuis;//税后
			//$sy_sh = $la_sh;//剩余
			//扣税后的金额
			$data['gprice']	= $gm;
			//更新多少进入报单币,多少进入交易币
			//$stt6 = $fee_rs['str6']/100;//报单币比例
			//$stt5 = $fee_rs['str5']/100;//交易币比例
			//$data['gmp'] = $sy_sh*$stt6;//进入报单币
			$data['pmp'] = $gm;//进入交易币
		}else{
			D('Game')->updateGameCash($uid,$gm);
		}

		$data['is_en'] = $en;//代币类型
//		$data['did'] = $did;

		$hgp->add($data);
		//添加到历史记录表

		$fck = D('Fck');
		$rs	= $fck->where("id=$uid")->field("user_id")->find();

		$c_gp = M('gp');
		if($ett==1){
			$jioayi_n = 0;
		}else{
			$jioayi_n = $out_n;
		}
		$c_gp ->query("update __TABLE__ set gp_quantity=gp_quantity+".$jioayi_n.",turnover=turnover+".$jioayi_n." where id=1");

		$this->gp_jy_bs($jioayi_n,0);

		$this->gp_jy_bs($jioayi_n,1);

	}
	
	//代币买卖统计交易量
	public function gp_jy_bs($num,$type=0){
	
		if($num>0){
			$gp	= M('gp');
			if($type==0){
				$gp->query("update __TABLE__ set buy_num=buy_num+".$num." where id=1");
				//加卖出数量
				M('fee')->query("update __TABLE__ set gp_senum=gp_senum+".$num." where id=1");
			}else{
				$gp->query("update __TABLE__ set sell_num=sell_num+".$num." where id=1");
			}
			unset($gp);
		}
	}
	
	//代币升价降价
	public function gp_up_down_pd(){
		$gp		= M('gp');
		$fee	= M('fee');
		$fee_rs = $fee->field('gp_one,gp_fxnum,gp_senum,gp_cnum,gp_inm') ->find();
		$cf_pri = 0.2;
		$up_pri = $fee_rs['gp_inm'];
		$one_price	= $fee_rs['gp_one'];
		$gp_fxnum	= $fee_rs['gp_fxnum'];//升价标准
		$gp_senum	= $fee_rs['gp_senum'];//销售量
		//$gp_cnum	= $fee_rs['gp_cnum'];//拆股次数
		$gp_c_pri = $one_price;
		if($gp_fxnum==$gp_senum&&$gp_fxnum>0){//升价
			$new_pri = $one_price+$up_pri;
			$gp_c_pri = $new_pri;
			$result = $fee->execute("update __TABLE__ set gp_one=".$new_pri.",gp_senum=0 where id=1 and gp_one=".$one_price);
			if($result){//涨价成功
				$gp->query("update __TABLE__ set opening=".$new_pri."");
//				if($gp_cnum>1){
//					//自动抛出代币
//					$this->auto_sell_gp($new_pri);
//				}
			}
		}
//		if($gp_c_pri==$cf_pri){//达到拆股
//			//自动拆股
//			$this->splitGP(1);
//			$gp_ch_pri = $gp_c_pri/2;
//			$gp->query("update __TABLE__ set opening=".$gp_ch_pri."");
//			if($gp_cnum>=1){
//				//自动抛出代币
//				$this->auto_sell_gp($gp_ch_pri);
//			}else{
//				$this->gx_auto_sell();
//			}
//		}
		unset($gp,$fee,$fee_rs);
	}
	
	//自动抛售代币
	public function auto_sell_gp($one_price){
		return;
		if($one_price>0){
			$gp_sell = M('gp_sell');
			$fck = M('fck');
			$gupiao = M('gupiao');
			$where = "is_over=0 and sell_mm=".$one_price." and sell_mon=2";
			$order = "id asc";
			$lirs = $gp_sell->where($where)->order($order)->select();
			foreach($lirs as $lrs){
				$id = $lrs['id'];
				$myid = $lrs['uid'];
				$sNunb = $lrs['sNun'];
				$bmoney = $one_price*$sNunb;
				$ok_sell = 0;
				$ok_money = $ok_sell*$one_price;
				
				//更新自己的售股信息
				$data['uid'] = $myid;
				$data['one_price'] = $one_price;
				$data['price'] = $sNunb*$one_price;//总得代币金额
				$data['sNun'] = $sNunb;//总的代币数
				$data['used_num'] = $ok_sell;//成功买到的代币
				$data['lnum'] = $sNunb - $ok_sell;//还差没有售出的代币
				$data['ispay'] = 0;//交易是否完成
				$data['eDate'] = time();//售出时间
				$data['status'] = 0;//这条记录有效
				$data['type'] = 1;//标识为售出
				$data['is_en'] = 0;//标准股
				$data['spid'] = 0;//原卖出记录ID
				$data['last_s'] = 0;//是否最后一次卖出
				$data['sell_g'] = $ok_money;//售出获得总额
				$resid = $gupiao->add($data);//添加记录
				if($resid){
					//更新会员
					$fck->query("update __TABLE__ SET " .
							"live_gupiao=live_gupiao-".$sNunb.",all_out_gupiao=all_out_gupiao+".$ok_sell.
							" WHERE `id`=".$myid);
					$gp_sell->query("update __TABLE__ set is_over=1,ispay=1,sell_date=".time()." where id=".$id);
				}
			}
			unset($gp_sell,$fck,$gupiao,$lirs,$lrs);
		}
	}

	//更新所有会员股数
	public function gx_all_gp_tj(){

// 		$fck = M('fck');
// 		$gp_sell = M('gp_sell');

// 		$lirs = $fck->where('is_pay>0 and id>1 and is_lock=0')->field('id,live_gupiao')->order('id asc')->select();
// 		foreach($lirs as $lrs){
// 			$myid = $lrs['id'];
// 			$live_gupiao  = $lrs['live_gupiao'];

// 			$all_n = $gp_sell->where('uid='.$myid.' and is_over=0 and sell_ln>0')->sum('sell_ln');
// 			$all_n = (int)$all_n;
// 			if($live_gupiao!=$all_n){
// 				$fck->query("update __TABLE__ set live_gupiao=".$all_n." where id=".$myid);
// 			}
// 		}
// 		unset($fck,$gp_sell,$lirs,$lrs);
	}

	//达人的代币信息
	public function gpInfo(){
		$id	= $_SESSION[C('USER_AUTH_KEY')];
		$rs	= M('fck')->where("id=$id")->field("live_gupiao,all_in_gupiao,all_out_gupiao,yuan_gupiao")->find();
		$arr = array();
		$arr[0] = $rs['live_gupiao'];//剩余的代币
		$arr[1] = $rs['all_in_gupiao'];//全部买进的代币
		$arr[2] = $rs['all_out_gupiao'];//全部卖出的代币
		$arr[3] = $rs['yuan_gupiao'];//原始代币
		return $arr;
	}

	//达人正在求购或者购买的代币,0为求购,1为出售
	public function buy_and_ing($x=0,$en=0){
		$id	= $_SESSION[C('USER_AUTH_KEY')];
		$gp = M('gupiao');
		$gping_num = $gp->where("uid=$id and type=$x and is_en=$en")->sum("lnum");
		return empty($gping_num)?0:$gping_num;
	}

	/*代币走势图部分【开始】*/
	public function trade() { ///7/股权交易
		if(empty($_SESSION[C('USER_AUTH_KEY')])){
			$this->error(xstr('error'));
			exit;
		}
		if(empty($_SESSION['first_in_trade'])){
			//第一次进来就刷新走势图
			$this->stock_past_due();
			$_SESSION['first_in_trade'] = 1;
		}
		$fck = M('fck');
		$gppp = M('gp');
		$fee	= M('fee');
		$xml = M('xml');
		$fee_rs = $fee->find();

		$fee_gp = $gppp->find();
		$laxl = $xml->order('id desc')->find();
		$now_p = $laxl['money'];
		$now_num = $laxl['amount'];
		$now_t = $laxl['x_date'];

		$bj_p = $fee_rs['gp_one'];
		$bj_n = $fee_gp['gp_quantity'];
		$bj_d = strtotime(date("Y-m-d"));
		if(bccomp($bj_p,$now_p,2)!=0||$now_num!=$bj_n||$now_t!=$bj_d){
			$this->stock_past_due();
		}

		$op_price	= $fee_rs['gp_one'];//现价和现在的购买价和销售价
		$day_price	= $fee_rs['gp_open'];//开盘价
		$close_pr	= $fee_rs['gp_close'];//昨日收盘价

		$tall_sNun	= $fee_gp['gp_quantity'];//今日成交量
		$tall_sNun	= number_format($tall_sNun,0,"",",");
		$all_sNun	= $xml->sum('amount');//XML总成交量
		$all_sNun	= number_format($all_sNun,0,"",",");
		
		$all_num	= $fee_gp['turnover'];//总成交量
		$yt_sellnum = $fee_gp['yt_sellnum'];//昨日交易量

		$all_num = number_format($all_num,0,"",",");
		$this->assign('all_num', $fee_rs['gp_sell_count']);//$all_num);//总成交量
		$yt_sellnum = number_format($yt_sellnum,0,"",",");
		$this->assign('yt_sellnum', $yt_sellnum);//

		$id = $_SESSION[C('USER_AUTH_KEY')];
		$gp_info	= $this->gpInfo();//代币的信息
		$fck_rs		= $fck->where("id=$id")->field("agent_gp")->find();

		$this->assign('live_gp', $gp_info[0]);//剩余的
		$this->assign('game_cash', $fck_rs['agent_gp']);//当前的代币

		$this->assign('op_price',$op_price);
		$this->assign('day_price',$day_price);
		$this->assign('cl_price',$close_pr);
		$this->assign('tall_sNun',$tall_sNun);
		$this->assign('all_sNun',$all_sNun);

		$this->display ();
	}

	public function stock_past_due(){
		$gp = M('gp');
		$xml = M('xml');
		$rs = $gp->where("id=1")->find();
		$gp_quantity = $rs['gp_quantity'];
		$tt = $rs['f_date'];
		$newday = strtotime(date("Y-m-d"));
		$ddtt = strtotime(date("Y-m-d",$tt));

		if($ddtt==$newday){
			$mrs=$xml->where('x_date='.$newday)->find();
			if($mrs){
				$data = array();
				$data['id']=$mrs['id'];
				$data['money'] =  $rs['opening'];
				$data['amount'] = $rs['gp_quantity'];
				$xml->save($data);
			}else{
				$data = array();
				$data['money'] =  $rs['opening'];
				$data['amount'] = $rs['gp_quantity'];
				$data['x_date'] = $newday;
				$xml->add($data);
			}
		}else{
			$result = $gp->execute("update __TABLE__ set yt_sellnum=gp_quantity,gp_quantity=0,closing=opening where id=1 and gp_quantity=".$gp_quantity);
			if($result){
				$mrs=$xml->where('x_date='.$newday)->find();
				if($mrs){
					$data = array();
					$data['id']=$mrs['id'];
					$data['amount'] = 0;
					$xml->save($data);
				}else{
					$data = array();
					$data['money'] =  $rs['opening'];
					$data['amount'] = 0;
					$data['x_date'] = $newday;
					$xml->add($data);
				}
			}
		}
		if ($tt < time()) {//时时更新价格
			$f_date = time();
			$gp->query ("update __TABLE__ set today=opening,most_g=opening,most_d=opening,f_date='$f_date' where id=1");
		}
		$this->ChartsPrice ();
	}

	//代币升值判断是否还能再购买
	public function pd_buy_ok($pri=0){

		$fck = M('fck');
		$gupiao = M('gupiao');

		$rs=$gupiao->where('ispay=0 and status=0 and buy_s<'.$pri.' and type=0')->select();
		foreach($rs as $vo){

			$buy_s = $vo['buy_s'];//剩余购买总额
			$myuid = $vo['uid'];
			$tid = $vo['id'];

			$sy_pri = $buy_s;//购买剩余多少没买到
			$gupiao->where('id='.$tid)->setField('ispay',1);//完成
			$fck->query('update __TABLE__ set agent_gp=agent_gp+'.$sy_pri.' where id='.$myuid);//补回余额
		}

	}

	public function ChartsPrice() {
		$xml = M ('xml');
		$fengD = strtotime("2012-01-01");
		$rs = $xml->where('x_date>='.$fengD)->order("x_date desc")->select();
		$xx = "";
		foreach ($rs as $vo ) {
			$xx = $xx.date("Y-m-d H:i:s",$vo['x_date']).",".$vo['amount'] .",".$vo['money']."\r\n";
		}
		$filename =  "./Public/amstock/data2.csv";
		if (file_exists($filename)) {
			unlink($filename); //存在就先删除
		}
		file_put_contents($filename,$xx);
	}

	public function ChartsVolume($date, $shu) {
		////生成xml档
		$yy = "<graph yAxisMaxValue='3500000' yAxisMinValue='100' numdivlines='19' lineThickness='1' showValues='0' numVDivLines='0' formatNumberScale='1' rotateNames='1' decimalPrecision='2' anchorRadius='2' anchorBgAlpha='0' divLineAlpha='30' showAlternateHGridColor='1' shadowAlpha='50'>";
		$yy = $yy . "<categories>";
		$yy = $yy . $date;
		$yy = $yy . "</categories>";
		$yy = $yy . "<dataset color='A66EDD' anchorBorderColor='A66EDD' anchorRadius='2'>";
		$yy = $yy . $shu;
		$yy = $yy . "</dataset>";
		$yy = $yy . "</graph>";
		$filename = "./Public/Images/ChartsVolume.xml";
		if (file_exists ( $filename )) {
			unlink ( $filename ); //存在就先删除
		}
		$wContent = $yy;
		$handle = fopen ( $filename, "a" );
		if (is_writable ( $filename )) {
			fwrite ( $handle, $wContent );
			if (is_readable ( $filename )) {
				$file = fopen ( $filename, "rb" );
				$contents = "";
				while ( ! feof ( $file ) ) {
					$contents = fread ( $file, 90000000 );
				}
				fclose ( $file );
			}
			fclose ( $handle );
		}
	}

    //检查代卖表
    public function addsell_gp($uid,$sNunb=0,$pri=0){
    	$gp_sell = M('gp_sell');
    	$lrs = $gp_sell->where('uid='.$uid.' and sell_mm='.$pri.' and is_over=0 and sell_mon=0')->find();
    	if($lrs){
    		$gp_sell->query("update __TABLE__ set sNun=sNun+".$sNunb.",sell_ln=sell_ln+".$sNunb." where id=".$lrs['id']);
    	}else{
    		$wdata = array();
    		$wdata['uid'] = $uid;
    		$wdata['sNun'] = $sNunb;
    		$wdata['eDate'] = time();
    		$wdata['sell_mm'] = $pri;
    		$wdata['sell_ln'] = $sNunb;
    		$gp_sell->add($wdata);
    		unset($wdata);
    	}
    	unset($gp_sell,$lrs);
    }

    //代币参数设置
    public function adminsetGP(){
    	$this->_Admin_checkUser();
    	if ($_SESSION['UrlPTPass'] == 'adminsetGP'){
    		$fee = M ('fee');
    		$fee_rs = $fee -> find();
    		
    		$is_sp	= $fee_rs['gp_cgbl'];
    		$is_yes	 = explode(':',$is_sp);
    
    		$btn ="<input name=\"bttn\" type=\"button\" id=\"bttn\" value=\"".xstr('hint188')."\" class=\"btn1\" onclick=\"if(confirm('".xstr('hint189').$fee_str10.xstr('hint190')."')){window.location='__URL__/set_gp_cg/f_b/".$is_yes[0]."/s_b/".$is_yes[1]."/';return true;}return false;\"/>";
    		$this -> assign('btn',$btn);
    		$this -> assign('fee_rs',$fee_rs);
    
    		$this->display('adminsetGP');
    	}else{
    		$this->error(xstr('error_signed'));
    		exit;
    	}
    }
    
    public function setGPSave(){
    	$this->_Admin_checkUser();
    	if ($_SESSION['UrlPTPass'] == 'adminsetGP'){
    		$fee = M ('fee');
    		$gp = M( 'gp' );
    		$rs = $fee -> find();
    		
    		$data1 = array();
    		$data1['gp_open']  = trim($_POST['gp_open']);
    		$data1['gp_close']  = trim($_POST['gp_close']);
    		$data1['gp_perc']  = trim($_POST['gp_perc']);
    		$data1['gp_inm']  = trim($_POST['gp_inm']);
    		$data1['gp_kg']  = trim($_POST['gp_kg']);
    		$data1['gp_fxnum']  = trim($_POST['gp_fxnum']);
    		$is_sp	= trim($_POST['gp_cgbl']);
    		$is_yes	 = explode(':',$is_sp);
    		if(!is_numeric($is_yes[0])||!is_numeric($is_yes[1])){
    			$this->error(xstr('hint191'));
    			exit;
    		}
    		$data1['gp_cgbl']  = trim($_POST['gp_cgbl']);
    		$now_ppp = trim($_POST['gp_one']);
    		$gpprice = trim($_POST['gpprice']);
    		$data1['gp_one'] = $now_ppp;
    		$fee -> where("id=1") -> save($data1);
    		
    		if(bccomp($gpprice, $now_ppp, 2)!=0){
    			//更新价格
    			$gp->execute("update __TABLE__ set opening=$now_ppp,f_date=".time());
    			//更新交易信息
    			$this->pd_buy_ok($now_ppp);
    		}
    
    		$this->success(xstr('hint192'));
    		exit;
    	}else{
    		$this->error(xstr('error_signed'));
    		exit;
    	}
    }
	
	//C116自动以当前价格卖出会员所有股票，并按指定参数进入指定的财产
	private function autoSellAllGP()
	{
		$fckArr = M('Fck')->field('id,user_id,live_gupiao')->where('live_gupiao>0')->select();
		if($fckArr)
		{
			$feeArr = M('Fee')->find();
			$price = floatval($feeArr['gp_one']);
			$handCharge = floatval($feeArr['str34']);
			$handCharge /= 100;
			$cashRatio = floatval($feeArr['str35']);
			$cashRatio /= 100;
			$gpRatio = floatval($feeArr['str36']);
			$gpRatio /= 100;
			$ktRatio = floatval($feeArr['str33']);
			$ktRatio /= 100;
			foreach($fckArr as $user)
			{
				$realLiveGP = intval($user['live_gupiao']*(1-$handCharge));
				if($realLiveGP > 0)
				{
					$allMoney = $realLiveGP*$price;
					$getCASH = $allMoney*$cashRatio;
					$getGP = $allMoney*$gpRatio;
					$getKT = $allMoney*$ktRatio;
					if($getCASH < 0)
						$getCASH = 0;
					if($getGP < 0)
						$getGP = 0;
					if($getKT < 0)
						$getKT = 0;
					M('Fck')->execute('UPDATE __TABLE__ SET agent_cash=agent_cash+'.$getCASH.',agent_gp=agent_gp+'.$getGP.',agent_kt=agent_kt+'.$getKT.',live_gupiao=0 WHERE id='.$user['id']);
				}
			}
		}
		//M('Fee')->execute('UPDATE __TABLE__ SET last_gp_count=0,gp_sell_count=0');
	}
    
    //拆股操作
    public function set_gp_cg(){
    	$is_yes=array();
    	$is_yes[0]=$_GET['f_b'];
    	$is_yes[1]=$_GET['s_b'];
    	if(!is_numeric($is_yes[0])||!is_numeric($is_yes[1])){
    		$this->error(xstr('hint191'));
    		exit;
    	}
    	if($is_yes[0]!=$is_yes[1]){
    		$this->splitGP();
			$this->autoSellAllGP();
    		$bUrl = __URL__.'/adminsetGP';
    		$this->_box(1,xstr('hint193'),$bUrl,1);
    	}else{
    		$this->error(xstr('hint194'));
    		exit;
    	}
    }
    
    //拆分代币
    public function splitGP($c_type=0){
    	if($c_type==0){
    		$this->_Admin_checkUser();
    	}
    	$fee	= M('fee');
    	$fck	= M('fck');
    	$gp		= M( 'gp' );

    	$fee_rs = $fee ->find();
    	//拆分之前代币的相关设置
    	$old_close_gp	= $fee_rs['gp_kg'];//代币交易开关,1为关闭
    	$old_one_price	= $fee_rs['gp_one'];//系统设置的代币价格
    	//拆分比率
    	$split_m	= explode(':',$fee_rs['gp_cgbl']);
    	$split_m1	= $split_m[0];//拆分前的代币比率
    	$split_m2	= $split_m[1];//拆分后的代币比率
		/*
    	if($c_type==1)//自动拆分固定比例1:2
		{
			return; //不自动拆分
    		$split_m1 = 1;
    		$split_m2 = 2;
    	}*/
    	//计算拆分后的价格【根据拆分前后的总价值相等算出拆分后的价格】
    	$cur_one_price	= ((int)((($old_one_price*$split_m[0])/$split_m2)*10000))/10000;
    	//拆分后达人的代币变动比率【根据拆分前后的比率为$split_m1/$split_m2】
    	$cur_gp	= $split_m2/$split_m1;
    
    	//拆分之前先把代币的交易功能关闭掉,以免出错
    	$fee->execute("update __TABLE__ set gp_kg=1 where id=1");
    	//更新达人的代币信息
				
    	$fck->execute("update __TABLE__ set live_gupiao=live_gupiao*$cur_gp,gp_divi_count=gp_divi_count+1 where id>0 and live_gupiao>0");
    
    	//M('gp_sell')->query("update __TABLE__ set sNun=sNun*$cur_gp,sell_ln=sell_ln*$cur_gp,sell_mon=sell_mon+1 where is_over=0");
    	
    	//更新会员股数
    	$this->gx_all_gp_tj();
				
    	//更新代币的当前价格,恢复1:1
    	$fee->execute("update __TABLE__ set gp_one=$cur_one_price,gp_fxnum=gp_fxnum*$cur_gp,gp_cnum=gp_cnum+1,gp_cgbl='1:1' where id=1");
    	//更新代币价格
    	$gp->execute("update __TABLE__ set opening=".$cur_one_price.",f_date=".time()."");
    
    	//拆分完毕，重新恢复代币的之前设置
    	$fee->execute("update __TABLE__ set gp_kg=$old_close_gp where id=1");
    }
	    
    //公司自动抛售
    private function gx_auto_sell(){
		return;
    	$one_price = 0.1;
    	$sNunb = C('GuPiao_first_Open')*2;
    	if(empty($sNunb)){
    		$sNunb=300000;
    	}
    	$ok_sell = 0;
    	$ok_money = $ok_sell*$one_price;
    	
    	$data = array();
    	$data['uid'] = 1;
    	$data['one_price'] = $one_price;
    	$data['price'] = $sNunb*$one_price;//总得代币金额
    	$data['sNun'] = $sNunb;//总的代币数
    	$data['used_num'] = $ok_sell;//成功买到的代币
    	$data['lnum'] = $sNunb - $ok_sell;//还差没有售出的代币
    	$data['ispay'] = 0;//交易是否完成
    	$data['eDate'] = time();//售出时间
    	$data['status'] = 0;//这条记录有效
    	$data['type'] = 1;//标识为售出
    	$data['is_en'] = 0;//标准股
    	$data['spid'] = 0;//原卖出记录ID
    	$data['last_s'] = 0;//是否最后一次卖出
    	$data['sell_g'] = $ok_money;//售出获得总额
    	$resid = M('gupiao')->add($data);//添加记录
    	if($resid){
    		M('fck')->query("update __TABLE__ SET all_out_gupiao=all_out_gupiao+".$sNunb." WHERE `id`=1");
    	}
    	unset($data);
    }
    
    //两个数字相除
    private function numb_duibi($a,$b){
    	$numb = 2;
    	$chub = pow(10,$numb);
    	$c_a = (int)($a*$chub);
    	$c_b = (int)($b*$chub);
    	$c_c = $c_a/$c_b;
    	return $c_c;
    }
		
	public function trade_list(){
		$id	= $_SESSION[C('USER_AUTH_KEY')];
		$GPmj = M('gupiao');
		$fck = M('fck');
		$fee = M ('fee');

		$id = $_SESSION[C('USER_AUTH_KEY')];

		import ( "@.ORG.ZQPage" );  //导入分页类

		$where = 'uid>0 and ispay=0'; //出售
		//$map = 'uid>0 and type=0 and ispay=0';//求购

		$field = '*';

		$count = $GPmj->where($where)->field($field)->count();//出售总页数
		//$count1 = $GPmj->where($map)->field($field)->count();//求购总页数

		$listrows = 15;//每页显示的记录数

		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量

		$this->assign('page',$show);//分页变量输出到模板
		//$Page1 = new ZQPage($count1,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		//$show1 = $Page1->show();//分页变量
		//$this->assign('page1',$show1);//分页变量输出到模板
		$list = $GPmj->where($where)->field($field)->order('id desc')->page($Page->getPage().','.$listrows)->select();

		//$list1 = $GPmj->where($map)->field($field)->order('id desc')->page($Page1->getPage().','.$listrows)->select();
//		foreach($list1 as $vov){
//
//			$can_b[$vov['id']] = floor($vov['buy_s']/$vov['one_price']);
//
//		}
//		$this->assign('can_b', $can_b);

		$this->assign('list', $list);
		//$this->assign('list1', $list1);

		$this->display('trade_list');
		
	}
	
	
	public function trade_list1(){
		$id	= $_SESSION[C('USER_AUTH_KEY')];
		$GPmj = M('gupiao');
		$fck = M('fck');
		$fee = M ('fee');

		$id = $_SESSION[C('USER_AUTH_KEY')];

		import ( "@.ORG.ZQPage" );  //导入分页类

		$where = 'uid>0 and type=1 and ispay=0'; //出售
		$map = 'uid>0 and type=0 and ispay=0';//求购

		$field = '*';

		$count = $GPmj->where($where)->field($field)->count();//出售总页数
		$count1 = $GPmj->where($map)->field($field)->count();//求购总页数

		$listrows = 5;//每页显示的记录数

		$Page = new ZQPage($count,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show = $Page->show();//分页变量

		$this->assign('page',$show);//分页变量输出到模板
		$Page1 = new ZQPage($count1,$listrows,1);
		//===============(总页数,每页显示记录数,css样式 0-9)
		$show1 = $Page1->show();//分页变量
		$this->assign('page1',$show1);//分页变量输出到模板
		$list = $GPmj->where($where)->field($field)->order('one_price desc')->page($Page->getPage().','.$listrows)->select();
		$i=count($list);
		foreach($list as $vov){
			$can_a[$vov['id']] = $i--;
		}
		$list1 = $GPmj->where($map)->field($field)->order('one_price asc')->page($Page1->getPage().','.$listrows)->select();
		foreach($list1 as $vov){
			$can_b[$vov['id']] = floor($vov['buy_s']/$vov['one_price']);
		}
		$this->assign('can_a', $can_a);
		$this->assign('can_b', $can_b);

		$this->assign('list', $list);
		$this->assign('list1', $list1);

		$this->display('trade_list1');
		
	}



}
?>