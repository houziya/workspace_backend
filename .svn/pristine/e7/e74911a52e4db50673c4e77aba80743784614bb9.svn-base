<?php
class IndexAction extends CommonAction {
	// 框架首页
	public function index() {
		ob_clean();
		set_time_limit(0);
		$this->_checkUser();
		$this->_Config_name();//调用参数

					$bUrl = __APP__.'/Public/main';
			$this->_boxx($bUrl);


		C ( 'SHOW_RUN_TIME', false ); // 运行时间显示
		C ( 'SHOW_PAGE_TRACE', false );
		$fck = D ('Fck');
		$form=M('form');
		$Msg=M('Msg');
		
		$id = $_SESSION[C('USER_AUTH_KEY')];
		$field = '*';
		$fck_rs = $fck -> field($field) -> find($id);
		$this->assign('fck_rs',$fck_rs);
		
		$week=date("w");
		if($week==1){
			$fck->emptyTime(); //清空对碰封顶
		}
	
		$arss = $this->_cheakPrem();  //权限函数
        $this->assign('arss',$arss);
		
		//首页图片
		$fee = M('fee');
	    $fee_rs = $fee->field('*')->find();
		$str21 = $fee_rs['str21'];
		$str22 = $fee_rs['str22'];
		$str23 = $fee_rs['str23'];
		$str7 = $fee_rs['str7'];
		$str8 = $fee_rs['str8'];
		$str11 = $fee_rs['str11'];
		$all_img = $str21."|".$str22."|".$str23;
	    $this->assign('all_img',$all_img);
	    $this->assign('i4',$fee_rs['i4']);
		 $this->assign('str7',$fee_rs['str7']);
		  $this->assign('str8',$fee_rs['str8']);
		    $this->assign('zrs',$fee_rs['str11']);
		$this->assign('qlist',explode('|',$fee_rs['str7']));
		$this->assign('qname',explode('|',$fee_rs['str8']));
		$this->assign('regLvNameArr',explode('|',$fee_rs['s10']));

		// //判断是否被锁定
		// $result=$fck->check_is_aa(',1,');
		//自动结算分红
		$this->aotu_clearings();

		// //过期提醒续费
		// $dates = C('DATE_Expired');
		// $bian = C('DB_NAME');
		// XTcheckInfo($id,$dates,$bian);
		$map['status'] = 1;
		$map['type'] = array('eq','1');
		$count_news=$form->where($map)->count();
		$this->assign('count_news',$count_news);

		$count_msg=$Msg->where("f_read=0 and s_read=0 and (f_uid=".$id." or s_uid=".$id.")")->count();
		$this->assign('count_msg',$count_msg);

		$count_msg=$Msg->where("f_read=0")->count();
		$this->assign('count_f',$count_msg);

		$count_msg=$Msg->where("s_read=0")->count();
		$this->assign('count_s',$count_msg);

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
            //根据显示的日息，计算互助辅导奖和互助大使奖
			$fck->lingdaojiang($fck_rs['re_path'],$fck_rs['user_id'],$lixi,1);
			$fck->lingdaojiang($fck_rs['re_path'],$fck_rs['user_id'],$lixi,1);
		}else{
			$money_hong=0;
		}
		$this->assign('money_hong',$money_hong);
		//dump($money_hong);
		$this->display('index');
		if($fee_rs['i2']==1){
			//$aaa=A('Mavro');
			//$aaa->matchBuySell();
		}
		//发放日息
		//$fck->B1_fh_perday();
		// $spID='000078';			//请根据自己的账户修改
		// $password = 'zy123456';	//请根据自己的账户修改	
		// $accessCode = '1069032239089';		//请根据自己的账户修改
		// $content = '接口接入调试。【优易网】';	//接口提交的短信内容，后面加上签名
		// $mobileString = '15177187127';	  //
		// $this->TXTmsg($spID,$password,$accessCode,$content,$mobileString);
	}

	public function checkInfo($id,$dates){
        if(empty($dates)){
			if (empty($_SESSION['LoginCheck'])){
				$content  = '============告示============';
				$content .= '\n\n';
				$content .= '本系统是测试系统,只供测试使用,不得做任何商业用途,';
				$content .= '\n\n';
				$content .= '在测试过程中,数据丢失或者系统有变动,所造成的损失,公司概不负责。';
				$content .= '\n\n';
				$content .= '如要正式使用系统，请尽快测试完善系统，';
				$content .= '\n\n';
				$content .= '测试完成后在通知负责人给您转成正式的使用。谢谢合作。';
				$content .= '\n\n';
				$content .= '===========================';
				$url = __APP__.'/';
				$_SESSION['LoginCheck'] = '2';
				echo "<script>alert('". $content ."');location.href='". $url ."';</script>";
			}
		}else{
			$dateh = strtotime($dates);
			$dateh = date('Y',$dateh).'年'.date('n',$dateh).'月'.date('j',$dateh).'日';
			$datek = date('Y-n-j',strtotime($dates.' +1 year -1 day'));
			$datec = strtotime($dates.' +11 month');
			$datex = time();
			$dateo = strtotime($dates.' +1 year');
			
			if($_SESSION['LoginCheckExpired']==22 && $dateo<$datex){
				echo "软件已到期...";exit;
			}

			if(empty($_SESSION['LoginCheckExpired']) && $datec<=$datex && $id==1){
				$YU = $_SERVER['HTTP_HOST'];
				$bian = C('DB_NAME');
				$bian = str_replace("sql_zyrj","",$bian);
				
				$content  = '=================续费通知=================';
				$content .= '\n\n';
				$content .= '您好:';
				$content .= '\n\n';
				$content .= '您的会员系统（'.$YU.')，在('.$dateh.')正式使用，';
				$content .= '\n\n';
				$content .= '至今已快满一年，请您与紫云软件客服联系，并且提前续费，';
				$content .= '\n\n';
				$content .= '否则会员系统将在('.$datek.')暂停使用。';
				$content .= '\n\n';
				$content .= '您的会员系统编号是：'.$bian;
				$content .= '\n\n';
				$content .= '请您把 "编号" 与 "域名" 或者 "截图本消息" 发给客服人员，';
				$content .= '\n\n';
				$content .= '并说明会员系统需要续费。如联系不到客服人员。';
				$content .= '\n\n';
				$content .= '可登录官方网站：www.nnzy.net 或者拔打电话：0771-5605212';
				$content .= '\n\n';
				$content .= '=========================================';
				$url = __APP__.'/';
				$_SESSION['LoginCheckExpired'] = '22';
				echo "<script>alert('". $content ."');location.href='". $url ."';</script>";
			}
		}
    }

    //每日自动结算
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
}
?>