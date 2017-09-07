<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/23
 * Time: 23:32
 */
class MatchsAction extends CommonAction
{
    public function _initialize()
    {
        parent::_initialize();
        header("Content-Type:text/html; charset=utf-8");
        $this->_inject_check(0);//调用过滤函数
        $this->_checkUser();
    }

    //多对多匹配
    public function automatch()
    {
        $this->distheme("matchs");
    }

    //手动快速匹配NEWNEWNEW
    public function matchs($in = '', $out = '')
    {


//if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS'){

        $fee_rs = M('fee')->field('*')->find();
        $spID = $fee_rs['s4'];            //请根据自己的账户修改
        $password = $fee_rs['str12'];    //请根据自己的账户修改
        $accessCode = $fee_rs['str4'];        //


        $inCode = $in;
        $outCode = $out;


        $cash = M('cash');
        $zm = 0;
        $fck = M('fck');
        $in_rs = $cash->where("type=0 and is_pay=0 and is_cancel=0 and x1='" . $inCode . "'")->find();

//$cash->where('id='.$in_rs['id'])->delete();


        $out_rs = $cash->where("type=1 and is_pay=0 and is_cancel=0 and x1='" . $outCode . "'")->find();


        if (empty($inCode)) {
            //	$this->error("请输进场订单编号！");
            exit;
        }
        if (empty($in_rs)) {
            //	$this->error("该进场订单已匹配或不存在！");
            exit;
        }
        if ($in_rs['uid'] == $out_rs['uid']) {
            exit;
        }

        $zm = $zm + $out_rs['money'];

        $yiid = $out_rs['uid'];
        $syiid = $out_rs['s_user_id'];
        $myiid = $out_rs['id'];

        $whlock['id'] = $out_rs['uid'];
        $whlock['is_lock'] = 1;
        $loc = $fck->where($whlock)->find();
        if ($loc) {
            exit;
        }
        //	{$this->error("账号存在但无效，可能被锁定");}


        $num = 1;
        $nowtime = time();

        if ($in_rs['money'] != $zm) {
            //	$this->error("金额不匹配，请重新选择！");
            //	exit;
        }

        if ($in_rs['money'] == 0 || $out_rs['money'] == 0) {
            exit;
        }

        $nowtime = time();
        if (round($in_rs['money']) == round($zm)) {
            /*if(!empty($in_rs["sid"])){
                $yiid = $in_rs["sid"] . "," . $yiid;
            }
            if(!empty($in_rs["s_user_id"])){
                $syiid = $in_rs["s_user_id"] . "," . $syiid;
            }
            if(!empty($in_rs["match_id"])){
                $myiid = $in_rs["match_id"] . "," . $myiid;
            }*/
            $resuelt = $cash->execute("update __TABLE__ set is_pay=1,pdt=" . $nowtime . ",sid='" . $yiid . "',s_user_id='" . $syiid . "',match_id='" . $myiid . "',match_num=" . $num . " where id=" . $in_rs['id']);

            /*if(!empty($out_rs["bid"])){
                $in_rs['uid'] = $out_rs["bid"] . "," . $in_rs['uid'];
            }
            if(!empty($out_rs["b_user_id"])){
                $in_rs['b_user_id'] = $out_rs["b_user_id"] . "," . $in_rs['b_user_id'];
            }
            if(!empty($out_rs["match_id"])){
                $in_rs['id'] = $out_rs["match_id"] . "," . $in_rs['id'];
            }*/
            $resuelt2 = $cash->execute("update __TABLE__ set is_pay=1,pdt=" . $nowtime . ",bid='" . $in_rs['uid'] . "',b_user_id='" . $in_rs['b_user_id'] . "',match_id='" . $in_rs['id'] . "' where id=" . $out_rs['id']);
            $orderType = 2;
            $order = "";
        }

        if ($in_rs['money'] > $zm) {
            $resuelt = $cash->execute("update __TABLE__ set is_pay=1,pdt=" . $nowtime . ",sid='" . $yiid . "',s_user_id='" . $syiid . "',money=" . $zm . ",match_id='" . $myiid . "',match_num=" . $num . " where id=" . $in_rs['id']);
            /*if(!empty($in_rs["sid"])){
                $yiid = $in_rs["sid"] . "," . $yiid;
            }
            if(!empty($in_rs["s_user_id"])){
                $syiid = $in_rs["s_user_id"] . "," . $syiid;
            }
            if(!empty($in_rs["match_id"])){
                $myiid = $in_rs["match_id"] . "," . $myiid;
            }
            $zm = $in_rs['money'] - $zm;
            $resuelt = $cash->execute("update __TABLE__ set pdt=" . $nowtime . ",sid='" . $yiid . "',s_user_id='" . $syiid . "',match_id='" . $myiid . "',money=" . $zm . ",match_num = match_num+1 where id=" . $in_rs['id']);*/

            /*if(!empty($out_rs["bid"])){
                $in_rs['uid'] = $out_rs["bid"] . "," . $in_rs['uid'];
            }
            if(!empty($out_rs["b_user_id"])){
                $in_rs['b_user_id'] = $out_rs["b_user_id"] . "," . $in_rs['b_user_id'];
            }
            if(!empty($out_rs["match_id"])){
                $in_rs['id'] = $out_rs["match_id"] . "," . $in_rs['id'];
            }*/
            $resuelt2 = $cash->execute("update __TABLE__ set is_pay=1,pdt=" . $nowtime . ",bid='" . $in_rs['uid'] . "',b_user_id='" . $in_rs['b_user_id'] . "',match_id='" . $in_rs['id'] . "' where id=" . $out_rs['id']);

            $orderType = 0;
            $order = $this->createbuy($in_rs['uid'], $in_rs['money'] - $zm, $in_rs['x1']);
            //$order = $in_rs['x1'];
        }

        if ($in_rs['money'] < $zm) {
            /*if(!empty($in_rs["sid"])){
                $yiid = $in_rs["sid"] . "," . $yiid;
            }
            if(!empty($in_rs["s_user_id"])){
                $syiid = $in_rs["s_user_id"] . "," . $syiid;
            }
            if(!empty($in_rs["match_id"])){
                $myiid = $in_rs["match_id"] . "," . $myiid;
            }*/
            $resuelt = $cash->execute("update __TABLE__ set is_pay=1,pdt=" . $nowtime . ",sid='" . $yiid . "',s_user_id='" . $syiid . "',match_id='" . $myiid . "',match_num=" . $num . " where id=" . $in_rs['id']);

            //$resuelt2 = $cash->execute("update __TABLE__ set is_pay=1,pdt=" . $nowtime . ",bid='" . $in_rs['uid'] . "',b_user_id='" . $in_rs['b_user_id'] . "',money=" . $in_rs['money'] . ",match_id='" . $in_rs['id'] . "' where id=" . $out_rs['id']);
            /*$in_rs['money'] = $zm - $in_rs['money'];
            if(!empty($out_rs["bid"])){
                $in_rs['uid'] = $out_rs["bid"] . "," . $in_rs['uid'];
            }
            if(!empty($out_rs["b_user_id"])){
                $in_rs['b_user_id'] = $out_rs["b_user_id"] . "," . $in_rs['b_user_id'];
            }
            if(!empty($out_rs["match_id"])){
                $in_rs['id'] = $out_rs["match_id"] . "," . $in_rs['id'];
            }*/
            $resuelt2 = $cash->execute("update __TABLE__ set pdt=" . $nowtime . ",bid='" . $in_rs['uid'] . "',b_user_id='" . $in_rs['b_user_id'] . "',money=" . $in_rs['money'] . ",match_id='" . $in_rs['id'] . "' where id=" . $out_rs['id']);
            $orderType = 1;
            $order = $this->createsell($out_rs['uid'], $zm - $in_rs['money'], $out_rs['money_type'], $out_rs['x1']);
            //$order = $out_rs['x1'];
        }


        $user_idj = $out_rs['user_id'];
        $s_telj['user_id'] = $out_rs['user_id'];    //mai方电话
        $tels = $fck->where($s_telj)->getField('user_tel');
        $content = '尊敬的会员' . $out_rs['user_id'] . '：您的申请已经匹配订单，请在6小时内完成操作！';
        //	echo $tels;
        //$this->TXTmsg($accessCode,$spID,$password,$tels,$content);
        //	$this->send_sms_new($content,$tels);


        $user_ids = $in_rs['user_id'];
        $s_tels['user_id'] = $in_rs['user_id'];    //卖方电话
        $tel = $fck->where($s_tels)->getField('user_tel');
        //echo $tel;
        $contentss = '尊敬的会员' . $in_rs['user_id'] . '：您的申请已经匹配订单，请在6小时内完成操作！';
        //$this->TXTmsg($accessCode,$spID,$password,$tel,$contentss);
        //	$this->send_sms_new($contentss,$tel);


        //}
        if ($in_rs && $out_rs) {
            return ["order_type"=>$orderType, "order"=>$order];
        }
    }


    public function createbuy($id = 0, $money = 0, $orderid = '')
    {

        //$money = $fff['money'];
        //echo $money;

        $fck_rs = M('fck')->where("id=" . $id)->field('*')->find();

        $nowtime = time();

        $code_num = $this->_getUserCODE();

        unset($data);
        //插入交易表，生成抢单对应买方记录
        $data = array();
        $data['uid'] = $fck_rs['id'];
        $data['user_id'] = $fck_rs['user_id'];
        $data['bid'] = $fck_rs['id'];
        $data['b_user_id'] = $fck_rs['user_id'];
        $data['rdt'] = $nowtime;        //求购时间 重要
        $data['money'] = $money;
        $data['money_two'] = $money;
        $data['epoint'] = 0;            //存储国家，查询币值
        $data['is_pay'] = 0;            //是否匹配成功
        $data['is_cancel'] = 0;            //是否已取消
        $data['is_done'] = 0;            //是否已确认完成交易
        $data['bank_name'] = $fck_rs['bank_name'];  //银行名称
        $data['bank_card'] = $fck_rs['bank_card'];  //银行卡
        $data['user_name'] = $fck_rs['user_name'];  //开户名称
        // $data['sellbz']			= $bzcontent;  	//备注
        $data['s_type'] = '0,1,2,3';        //支付类型
        $data['type'] = 0;                //0为求购，1为挂卖
        $data['money_type'] = 0;                //0为求购，1为mavro挂卖,2为动态余额的挂卖
        $data['ldt'] = $nowtime;
        $data['money_key'] = 0;
        //$data['sellbz']=$fff['id'];
        $data['bz'] = $orderid;
        //	$data['own']='N';
        $data['x1'] = $code_num;                //编号

        //echo $fck_rs['id'];

        $rs2 = M('cash')->add($data);

        return $code_num;

    }

    public function createsell($id = 0, $money = 0, $money_type = 1, $orderid = '')
    {

        //$money = $fff['money'];
        //echo $money;

        $fck_rs = M('fck')->where("id=" . $id)->field('*')->find();

        $nowtime = time();

        $code_num = $this->_getUserCODE2();

        unset($data);
        //插入交易表，生成抢单对应买方记录
        $data = array();
        $data['uid'] = $fck_rs['id'];
        $data['user_id'] = $fck_rs['user_id'];
        $data['sid'] = $fck_rs['id'];
        $data['s_user_id'] = $fck_rs['user_id'];
        $data['rdt'] = $nowtime;        //求购时间 重要
        $data['money'] = $money;
        $data['money_two'] = $money;
        $data['epoint'] = 0;            //存储国家，查询币值
        $data['is_pay'] = 0;            //是否匹配成功
        $data['is_cancel'] = 0;            //是否已取消
        $data['is_done'] = 0;            //是否已确认完成交易
        $data['bank_name'] = $fck_rs['bank_name'];  //银行名称
        $data['bank_card'] = $fck_rs['bank_card'];  //银行卡
        $data['user_name'] = $fck_rs['user_name'];  //开户名称
        // $data['sellbz']			= $bzcontent;  	//备注
        $data['s_type'] = '0,1,2,3';        //支付类型
        $data['type'] = 1;                //0为求购，1为挂卖
        $data['money_type'] = $money_type;                //0为求购，1为mavro挂卖,2为动态余额的挂卖
        $data['ldt'] = $nowtime;
        $data['money_key'] = 0;
        //$data['sellbz']=$fff['id'];
        $data['bz'] = $orderid;
        //	$data['own']='N';
        $data['x1'] = $code_num;                //编号

        //echo $fck_rs['id'];

        $rs2 = M('cash')->add($data);

        return $code_num;

    }

    public function automatchall($inOrder = "", $outOrder = "")
    {
        $aaa = $inOrder ? $inOrder : $_POST['aaa'];
        $bbb = $outOrder ? $outOrder :$_POST['bbb'];
        if (!$aaa || !$bbb) {
            $this->error("订单号为空，请重新输入！");
            exit;
        }

        $ma = "";
        foreach(explode(",", $aaa) as $inCode){
            $ma .= "'" . $inCode . "',";
        }
        $ma = "(" . $ma ."'0')";
        $mb = "";
        foreach(explode(",", $bbb) as $outCode){
            $mb .= "'" . $outCode . "',";
        }
        $mb = "(" . $mb ."'0')";

        $fee = M('fee');
        $cash = M('cash');
        $fee_rs = $fee->find();
        //进场时间（及多长时间求购记录可以参与匹配）
        $in_time = 24 * 60 * 60 * $fee_rs['s7'] + 60 * 60 * $fee_rs['s13'] + 60 * $fee_rs['s14'];
        $in_time_t = 3600 * $fee_rs['str47'];
        $nowtime = time();
        //找有资格参与匹配的求购记录
        $where = "match_num=0 and is_pay=0 and is_cancel=0 and is_done=0 and type=0 and (id in " . $ma . " or bz in " . $ma . ")";
        $where = "is_pay=0 and is_cancel=0 and is_done=0 and type=0 and x1 in " . $ma . "";
        $cash_brs = $cash->where($where)->field('*')->order("rdt asc")->select();
        $count_b = $cash->where($where)->count();
        //找有资格参与匹配的挂卖记录
        // dump($cash_brs);
        $where2 = "is_pay=0 and is_cancel=0 and is_done=0 and type=1 and x1 in " . $mb . "";
        $cash_srs = $cash->where($where2)->order("money desc,rdt asc")->select();
        $count_s = $cash->where($where2)->count();
        //记录已经匹配的卖方ID
        if (!$cash_brs || !$cash_srs) {
            echo "订单号不存在或输入错误 ，请重新输入！";exit;
            $this->error("订单号不存在或输入错误 ，请重新输入！");
            exit;
        }

        $matchRes = [];
        foreach ($cash_brs as $key => $bbb) {
            $abs = array();
            $target = array();
            foreach ($cash_srs as $skey => $sss) {
                $dist = $bbb['money'] - $sss['money'];
                $abs[$skey] = abs($dist);
            }
            if(empty($cash_srs)){
                continue;
            }
            $pos = array_search(min($abs), $abs);
            //$ttt = mysql_fetch_array($abs);
            $matchRes[] = $this->matchs($bbb['x1'], $cash_srs[$pos]['x1']);
            unset($cash_srs[$pos]);
            unset($cash_brs[$key]);
        }
        //echo $checkk;exit;
        //$checkk = false;
        if ($matchRes) {
            $inOrderList = [];
            $outOrderList = [];
            foreach($matchRes as $match){
                if($match["order_type"] == 0){
                    $inOrderList[] = $match["order"];
                }
                if($match["order_type"] == 1){
                    $outOrderList[] = $match["order"];
                }
            }
            //print_r(array_column($cash_brs, "x1"));
            $inOrderList = array_merge($inOrderList, array_column($cash_brs, "x1"));
            $outOrderList = array_merge($outOrderList, array_column($cash_srs, "x1"));
            print_r($inOrderList);
            print_r($outOrderList);
            if(empty($inOrderList) && empty($outOrderList)){
                //echo "<script> alert('拆分匹配完成。'); location.href = '/index.php?s=/Public/main'; </script>";
                echo "拆分完成";
                exit;
            }
            $this->automatchall(implode(",", $inOrderList), implode(",", $outOrderList));
        }
        if (!$matchRes) {
            echo "拆分完成";
            exit;
            echo "<script> alert('拆分匹配完成。'); location.href = '/index.php?s=/Public/main'; </script>";
        }
    }
    //挂卖处理（提供帮助）
    protected function _getUserCODE()
    {
        $cash = M('cash');

        $a = 'S';
        $mynn = $a . rand(10000000, 99999999);
        $fwhere['x1'] = $mynn;
        $frss = $cash->where($fwhere)->field('id')->find();
        if ($frss) {
            return $this->_getUserCODE();
        } else {
            unset($cash, $fee);
            return $mynn;
        }
    }
    /***********single_in end**********************/
    protected function _getUserCODE2()
    {
        $cash = M('cash');
        $a = 'G';
        $mynn = $a . rand(10000000, 99999999);
        $fwhere['x1'] = $mynn;
        $frss = $cash->where($fwhere)->field('id')->find();
        if ($frss) {
            return $this->_getUserCODE2();
        } else {
            unset($cash, $fee);
            return $mynn;
        }
    }
    /***********single_out end**********************/
}

?>