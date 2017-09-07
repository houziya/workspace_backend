<?php

class YouZiAction extends CommonAction
{
    function _initialize()
    {
        parent::_initialize();
        //$this->_inject_check(1);//调用过滤函数
        $this->_inject_check(0);//调用过滤函数
        $this->_checkUser();
        $this->_Admin_checkUser();//后台权限检测
        $this->_Config_name();//调用参数
        header("Content-Type:text/html; charset=utf-8");

    }

    //================================================二级验证
    public function cody()
    {
        $UrlID = (int)$_GET['c_id'];
        if (empty($UrlID)) {
            $this->error(xstr('second_password_error'));
            exit;
        }
        if (!empty($_SESSION['user_pwd2'])) {
            $url = __URL__ . "/codys/Urlsz/$UrlID";
            $this->_boxx($url);
            exit;
        }
        $cody = M('cody');
        $list = $cody->where("c_id=$UrlID")->field('c_id')->find();
        if ($list) {
            $this->assign('vo', $list);
            $v_title = $this->theme_title_value();
            $this->distheme('../Public/cody', $v_title[1]);
            exit;
        } else {
            $this->error(xstr('second_password_error'));
            exit;
        }
    }

    //====================================二级验证后调转页面
    public function codys()
    {
        $Urlsz = $_POST['Urlsz'];
        if (empty($_SESSION['user_pwd2'])) {
            $pass = $_POST['oldpassword'];
            $fck = M('fck');
            if (!$fck->autoCheckToken($_POST)) {
                $this->error(xstr('page_expire_please_reflush'));
                exit();
            }
            if (empty($pass)) {
                $this->error(xstr('second_password_error'));
                exit();
            }
            $where = array();
            $where['id'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['passopen'] = md5($pass);
            $list = $fck->where($where)->field('id')->find();
            if ($list == false) {
                $this->error(xstr('second_password_error'));
                exit();
            }
            $_SESSION['user_pwd2'] = 1;
        } else {
            $Urlsz = $_GET['Urlsz'];
        }
        switch ($Urlsz) {
            case 1;
                $_SESSION['UrlPTPass'] = 'MyssShenShuiPuTao';
                $bUrl = __URL__ . '/auditMenber';//审核会员
                $this->_boxx($bUrl);
                break;
            case 2;
                $_SESSION['UrlPTPass'] = 'MyssGuanShuiPuTao';
                $bUrl = __URL__ . '/adminMenber';//会员管理
                $this->_boxx($bUrl);
                break;
            case 3;
                $_SESSION['UrlPTPass'] = 'MyssPingGuoCP';
                $bUrl = __URL__ . '/setParameter';//参数设置
                $this->_boxx($bUrl);
                break;
            case 4;
                $_SESSION['UrlPTPass'] = 'MyssPingGuo';
                $bUrl = __URL__ . '/adminParameter';//比例设置
                $this->_boxx($bUrl);
                break;
            case 5;
                $_SESSION['UrlPTPass'] = 'MyssMiHouTao';
                $bUrl = __URL__ . '/adminFinance';//拨出比例
                $this->_boxx($bUrl);
                break;
            case 6;
                $_SESSION['UrlPTPass'] = 'MyssGuanPaoYingTao';
                $bUrl = __URL__ . '/adminCurrency';//提现管理
                $this->_boxx($bUrl);
                break;
            case 7;
                $_SESSION['UrlPTPass'] = 'MyssHaMiGua';
                $bUrl = __APP__ . '/Backup/';//数据库管理
                $this->_boxx($bUrl);
                break;
            case 8;
                $_SESSION['UrlPTPass'] = 'MyssPiPa';
                $bUrl = __URL__ . '/adminFinanceTable';//奖金查询
                $this->_boxx($bUrl);
                break;
            case 9;
                $_SESSION['UrlPTPass'] = 'MyssQingKong';
                $bUrl = __URL__ . '/delTable';//清空数据
                $this->_boxx($bUrl);
                break;
            case 10;
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGua';
                $bUrl = __URL__ . '/adminAgents';//代理商管理
                $this->_boxx($bUrl);
                break;
            case 11;
                $_SESSION['UrlPTPass'] = 'MyssBaiGuoJS';
                $bUrl = __URL__ . '/adminClearing';//奖金结算
                $this->_boxx($bUrl);
                break;
            case 12;
                $_SESSION['UrlPTPass'] = 'MyssGuanMangGuo';
                $bUrl = __URL__ . '/adminCurrencyRecharge';//充值管理
                $this->_boxx($bUrl);
                break;
            case 13;
                $_SESSION['UrlPTPass'] = 'MyssBaiGuoJS';
                $bUrl = __URL__ . '/adminClearing2';//
                $this->_boxx($bUrl);
                break;
            case 18;
                $_SESSION['UrlPTPass'] = 'MyssMoneyFlows';
                $bUrl = __URL__ . '/adminmoneyflows';//财务流向管理
                $this->_boxx($bUrl);
                break;
            case 19;
                $_SESSION['UrlPTPass'] = 'MyssadminMenberJL';
                $bUrl = __URL__ . '/adminMenberJL';
                $this->_boxx($bUrl);
                break;
            case 23;
                $_SESSION['UrlPTPass'] = 'MyssOrdersList';
                $bUrl = __URL__ . '/OrdersList';//加单管理
                $this->_boxx($bUrl);
                break;
            case 24;
                $_SESSION['UrlPTPass'] = 'MyssWuliuList';
                $bUrl = __URL__ . '/adminLogistics';//物流管理
                $this->_boxx($bUrl);
                break;
            case 25;
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGuaJB';
                $bUrl = __URL__ . '/adminJB';//金币中心管理
                $this->_boxx($bUrl);
                break;
            case 26;
                $_SESSION['UrlPTPass'] = 'MyssGuanChanPin';
                $bUrl = __URL__ . '/pro_index';//产品管理
                $this->_boxx($bUrl);
                break;
            case 27;
                $_SESSION['UrlPTPass'] = 'MyssGuanzy';
                $bUrl = __URL__ . '/admin_zy';//专营店管理
                $this->_boxx($bUrl);
                break;
            case 28;
                $_SESSION['UrlPTPass'] = 'MyssShenqixf';
                $bUrl = __URL__ . '/adminXiaofei';//消费申请
                $this->_boxx($bUrl);
                break;
            case 29;
                $_SESSION['UrlPTPass'] = 'MyssJinji';
                $bUrl = __URL__ . '/adminmemberJJ';//晋级
                $this->_boxx($bUrl);
                break;
            case 30;
                $_SESSION['UrlPTPass'] = 'Myssadminlookfhall';
                $bUrl = __URL__ . '/adminlookfhall';
                $this->_boxx($bUrl);
                break;
            case 21;
                $_SESSION['UrlPTPass'] = 'MyssGuanXiGuaUp';
                $bUrl = __URL__ . '/adminUserUp';//升级管理
                $this->_boxx($bUrl);
                break;
            case 22;
                $_SESSION['UrlPTPass'] = 'MyssPingGuoCPB';
                $bUrl = __URL__ . '/setParameter_B';
                $this->_boxx($bUrl);
                break;
            default;
                $this->error(xstr('second_password_error'));
                break;
        }
    }

    //============================================会员升级页面显示
    public function admin_level($GPid = 0)
    {
        //列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanUplevel') {
            $fck = M('fck');
            $UserID = $_POST['UserID'];
            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array('like', "%" . $UserID . "%");
                $where['user_id'] = array('like', "%" . $UserID . "%");
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            $map['sel_level'] = array('lt', 90);

            //查询字段
            $field = 'id,user_id,nickname,bank_name,bank_card,user_name,user_address,user_tel,rdt,cpzj,pdt,u_level,sel_level';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fck->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ, 1);

            $this->assign('list', $list);//数据输出到模板
            //=================================================

            $this->display('admin_level');
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminquji()
    {
        $usid = $_GET['id'];
        $map['user_id'] = $usid;
        $fck = M('fck');
        $data['jingli'] = 0;
        $data['zongjian'] = 0;
        $data['dongshi'] = 0;
        $fck->where($map)->save($data);
        $this->success("ok！已经取消");

    }

    public function quxiaopipei()
    {


        $this->distheme('quxiaopipei');

    }

    public function cancelMatchsOutOrder(){
        $outOrder = $_POST['out_order'];
        if($outOrder){
            $sdata = [];
            $map = [];
            $map['x1'] = $outOrder;
            $sdata['is_pay'] = 0;
            $sdata['pdt'] = '';
            $sdata['bid'] = '';
            $sdata['match_num'] = 0;
            $sdata['b_user_id'] = '';
            $sdata['match_id'] = ''; //匹配记录ID
            $sdata['is_get'] = 0;
            $sdata['is_done'] = 0;
            $sdata['img'] = '';
            $sdata['is_ts'] = 0;
            $sdata['okdt'] = '';
            $cash = M('cash');
            $res = $cash->where($map)->save($sdata);
            $this->success("ok！已经取消出场订单的匹配");
        }
    }
    public function quxiaopipeis()
    {
        //列表过滤器，生成查询Map对象
        $sids = $_POST['jujue'];
        echo $sids;
        $mak['x1'] = $sids;
        $cash = M('cash');
        $sid = $cash->where($mak)->getField('id');

        $map['id'] = $sid;
        $data['is_pay'] = 0;
        $data['pdt'] = '';
        $data['sid'] = '';
        $data['match_num'] = 0;
        $data['s_user_id'] = '';
        $data['match_id'] = ''; //匹配记录ID
        $data['is_get'] = 0;
        $data['is_done'] = 0;
        $data['img'] = '';
        $data['is_ts'] = 0;
        $data['okdt'] = '';


        $smap['match_id'] = $sid;
        $sdata['is_pay'] = 0;
        $sdata['pdt'] = '';
        $sdata['bid'] = '';
        $sdata['match_num'] = 0;
        $sdata['b_user_id'] = '';
        $sdata['match_id'] = ''; //匹配记录ID
        $sdata['is_get'] = 0;
        $sdata['is_done'] = 0;
        $sdata['img'] = '';
        $sdata['is_ts'] = 0;
        $sdata['okdt'] = '';
        $res = $cash->where($map)->save($data);
        $res2 = $cash->where($smap)->save($sdata);
        $this->success("ok！已经解除订单关系");


    }


    //========================================数据库管理
    public function adminManageTables()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssHaMiGua') {
            $Url = __ROOT__ . '/HaMiGua/';
            $_SESSION['shujukuguanli!12312g@#$%^@#$!@#$~!@#$'] = md5("^&%#hdgfhfg$@#$@gdfsg13123123!@#!@#");
            $this->_boxx($Url);
        }
    }

    //============================================审核会员
    public function auditMenber($GPid = 0)
    {
        //列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $fck = M('fck');
            $UserID = $_POST['UserID'];
            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array('like', "%" . $UserID . "%");
                $where['user_id'] = array('like', "%" . $UserID . "%");
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            $map['is_pay'] = array('eq', 0);

            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fck->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('is_pay,id,rdt desc')->page($Page->getPage() . ',' . $listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ, 1);
            $this->assign('voo', $HYJJ);//会员级别
            $this->assign('list', $list);//数据输出到模板
            //=================================================
            $v_title = $this->theme_title_value();
            $this->distheme('auditMenber', $v_title[102], 0);
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function auditMenberData()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            //查看会员详细信息
            $fck = M('fck');
            $ID = (int)$_GET['PT_id'];
            //判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 11) {
                $this->error(xstr('data_error'));
                exit;
            }
            $where = array();
            $where['id'] = $ID;
            $field = '*';
            $vo = $fck->where($where)->field($field)->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $this->display();
            } else {
                $this->error(xstr('data_error'));
                exit;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function auditMenberData2()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            //查看会员详细信息
            $fck = M('fck');
            $ID = (int)$_GET['PT_id'];
            //判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 11) {
                $this->error(xstr('data_error'));
                exit;
            }
            $where = array();
            $where['id'] = $ID;
            $field = '*';
            $vo = $fck->where($where)->field($field)->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $this->display();
            } else {
                $this->error(xstr('data_error'));
                exit;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function auditMenberData2AC()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {

            $fck = M('fck');
            $data = array();

            $where['id'] = (int)$_POST['id'];
            $rs = $fck->where('is_pay = 0')->find($where['id']);
            if (!$rs) {
                $this->error('非法操作!');
                exit;
            }

            $data['nickname'] = $_POST['NickName'];
            $rs = $fck->where($data)->find();
            if ($rs) {
                if ($rs['id'] != $where['id']) {
                    $this->error('该会员名已经存在!');
                    exit;
                }
            }

            $data['bank_name'] = $_POST['BankName'];
            $data['bank_card'] = $_POST['BankCard'];
            $data['user_name'] = $_POST['UserName'];
            $data['bank_province'] = $_POST['BankProvince'];
            $data['bank_city'] = $_POST['BankCity'];
            $data['user_code'] = $_POST['UserCode'];
            $data['bank_address'] = $_POST['BankAddress'];
            $data['user_address'] = $_POST['UserAddress'];
            $data['user_post'] = $_POST['UserPost'];
            $data['user_tel'] = $_POST['UserTel'];
            $data['bank_province'] = $_POST['BankProvince'];
            $data['is_lock'] = $_POST['isLock'];

            $fck->where($where)->data($data)->save();
            $bUrl = __URL__ . '/auditMenberData2/PT_id/' . $where['id'];
            $this->_box(1, '修改会员信息！', $bUrl, 1);

        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function auditMenberAC()
    {
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $PTid = $_POST['tabledb'];
        if (!isset($PTid) || empty($PTid)) {
            $bUrl = __URL__ . '/auditMenber';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit;
        }
        switch ($action) {
            case xstr('open_account');
                $this->_auditMenberOpenUser($PTid);
                break;
            case '设为空单';
                $this->_auditMenberOpenNull($PTid);
                break;
            case xstr('delete_account');
                $this->_auditMenberDelUser($PTid);
                break;
            case '申请通过';
                $this->_AdminLevelAllow($PTid);
                break;
            case '拒绝通过';
                $this->_AdminLevelNo($PTid);
                break;
            default;
                $bUrl = __URL__ . '/auditMenber';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }


    //审核会员升级-通过
    private function _AdminLevelAllow($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanUplevel') {
            $fck = M('fck');
            $where = array();
            $where['id'] = array('in', $PTid);
            $where['sel_level'] = array('lt', 90);
            $vo = $fck->where($where)->field('id,sel_level')->select();
            foreach ($vo as $voo) {
                $where = array();
                $data = array();
                $where['id'] = $voo['id'];
                $data['u_level'] = $voo['sel_level'];
                $data['sel_level'] = 98;
                $fck->where($where)->data($data)->save();
            }

            $bUrl = __URL__ . '/admin_level';
            $this->_box(1, '会员升级通过！', $bUrl, 1);
        } else {
            $this->error(xstr('data_error'));
            exit;
        }

    }

    //审核会员升级-拒绝
    private function _AdminLevelNo($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanUplevel') {
            $fck = M('fck');
            $where = array();
            $where['id'] = array('in', $PTid);
            $where['sel_level'] = array('lt', 90);
            $vo = $fck->where($where)->field('id')->select();
            foreach ($vo as $voo) {
                $where = array();
                $data = array();
                $where['id'] = $voo['id'];
                $data['sel_level'] = 97;
                $fck->where($where)->data($data)->save();
            }

            $bUrl = __URL__ . '/admin_level';
            $this->_box(1, '拒绝会员升级！', $bUrl, 1);
        } else {
            $this->error(xstr('data_error'));
            exit;
        }

    }

    //===============================================设为空单
    private function _auditMenberOpenNull($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $fck = D('Fck');
            $where = array();
            if (!$fck->autoCheckToken($_POST)) {
                $this->error(xstr('page_expire_please_reflush'));
                exit;
            }
            $ID = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = 0;
            $field = "id,u_level,re_id,cpzj,re_path,user_id,p_path,p_level,shop_id";
            $vo = $fck->where($where)->order('rdt asc')->field($field)->select();
            $nowdate = strtotime(date('c'));
            $nowday = strtotime(date('Y-m-d'));
            foreach ($vo as $voo) {
                $ppath = $voo['p_path'];
                //上级未开通不能开通下级员工
                $frs_where['is_pay'] = array('eq', 0);
                $frs_where['id'] = $voo['father_id'];
                $frs = $fck->where($frs_where)->find();
                if ($frs) {
                    $this->error(xstr('hint007'));
                    exit;
                }

                $data = array();
                $data['is_pay'] = 2;
                $data['pdt'] = $nowdate;
                $data['open'] = 1;
                $data['is_null'] = 1;//空单
                // $data['get_date'] = $nowday;
                // $data['fanli_time'] = $nowday;
//				$data['n_pai'] = $max_p;
//				$data['x_pai'] = $myppp;
                //开通会员
                $result = $fck->where('id=' . $voo['id'])->save($data);
                unset($data, $varray);

            }
            unset($fck, $where, $field, $vo, $nowday);
            $bUrl = __URL__ . '/auditMenber';
            $this->_box(1, '设为空单！', $bUrl, 1);
            exit;

        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    //===============================================开通会员
    private function _auditMenberOpenUser($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $fck = D('Fck');
            $shouru = M('shouru');
            $card = A('Phonecard');
            $fee = M('fee');
            $gouwu = M('gouwu');
            $where = array();
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = 0;
            $field = "*";
            $vo = $fck->where($where)->field($field)->order('id asc')->select();
            $nowdate = strtotime(date('c'));
            $nowday = strtotime(date('Y-m-d'));
            //$fck->emptyTime();
            $fee_rs = M('Fee')->field('s2,s9,s11')->find();
            $regMoneyArr = explode('|', $fee_rs['s9']);
            $gwArr = explode('|', $fee_rs['s2']);
            $pvArr = explode('|', $fee_rs['s11']);
            foreach ($vo as $voo) {
                $ppath = $voo['p_path'];
                //上级未开通不能开通下级员工
                $frs_where['is_pay'] = array('eq', 0);
                $frs_where['id'] = $voo['father_id'];
                $frs = $fck->where($frs_where)->find();
                if ($frs) {
                    $this->error(xstr('hint007'));
                    exit;
                }

                $money_a = $regMoneyArr[$voo['u_level'] - 1];

                //给推荐人添加推荐人数或单数
                $fck->execute("update __TABLE__ set `re_nums`=re_nums+1,re_cpzj=re_cpzj+" . $voo['cpzj'] . ",re_money=re_money+" . $money_a . " where `id`=" . $voo['re_id']);

                //统计新增业绩，用来分红
                //$fee->query("update __TABLE__ set `a_money`=a_money+".$voo['cpzj'].",`b_money`=b_money+".$voo['cpzj']);


                $data = array();
                $data['is_pay'] = 1;
                $data['pdt'] = $nowdate;
                $data['open'] = 1;
                $data['get_date'] = $nowday;
                $data['fanli_time'] = $nowday;//当天没有分红奖
                $data['agent_gp'] = floatval($gwArr[$voo['u_level'] - 1]);//注册送股点
                // //根据推荐人数排网
                /*
				$arry=array();
				$arry=$this->gongpai($voo['re_id']);
				$data['father_id']=$arry['father_id'];
				$data['father_name']=$arry['father_name'];
				$data['treeplace']=$arry['treeplace'];
				$data['p_level']=$arry['p_level'];
				$data['p_path']=$arry['p_path'];
				// $data['u_pai']=$arry['u_pai'];*/
                // dump($data);exit;
                //开通会员
                $result = $fck->where('id=' . $voo['id'])->save($data);
                unset($data, $varray);

                $data = array();
                $data['uid'] = $voo['id'];
                $data['user_id'] = $voo['user_id'];
                $data['in_money'] = $voo['cpzj'];
                $data['in_time'] = time();
                $data['in_bz'] = "新会员加入";
                $shouru->add($data);
                unset($data);

                $kt_cont = "后台开通会员";
                $fck->addencAdd(1, $voo['user_id'], 0, 19, 0, 0, 0, $kt_cont);//历史记录

                //设置货物
                //$gouwu->query("update __TABLE__ set lx=1 where uid=".$voo['id']);

                // //统计单数
                $dan = intval($voo['cpzj'] / $pvArr[0]);
                $fck->xiangJiao($voo['id'], $dan);  //singular


                // //算出奖金
                $fck->getusjj($voo['id'], $type = 1);

            }
            unset($fck, $field, $where, $vo);
            $bUrl = __URL__ . '/auditMenber';
            $this->_box(1, '开通会员成功！', $bUrl, 1);
            exit;
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    private function _auditMenberDelUser($PTid = 0)
    {
        //删除会员
        if ($_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $fck = M('fck');
            $gouwu = M('gouwu');
            $where['is_pay'] = 0;
//			$where['id'] = array ('in',$PTid);
            foreach ($PTid as $voo) {
                $rs = $fck->find($voo);
                if ($rs) {
                    $whe['father_name'] = $rs['user_id'];
                    $rss = $fck->where($whe)->find();
                    if ($rss) {
                        $bUrl = __URL__ . '/auditMenber';
                        $this->error('该 ' . $rs['user_id'] . ' 会员有下级会员，不能删除！');
                        exit;
                    } else {
                        $gouwu->where("uid={$voo}")->delete();
                        $fck->where("id={$voo}")->delete();
                        $bUrl = __URL__ . '/auditMenber';
                        $this->_box(1, '删除会员！', $bUrl, 1);
                    }
                } else {
                    $this->error(xstr('error_signed'));
                }
            }

//			$rs = $fck->where($where)->delete();
//			if ($rs){
//				$bUrl = __URL__.'/auditMenber';
//				$this->_box(1,'删除会员！',$bUrl,1);
//				exit;
//			}else{
//				$bUrl = __URL__.'/auditMenber';
//				$this->_box(0,'删除会员！',$bUrl,1);
//				exit;
//			}
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    public function adminMenber($GPid = 0)
    {
        //列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int)$_REQUEST['type'];

            $map = array();
            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['user_name'] = array('like', "%" . $UserID . "%");
                $where['user_id'] = array('like', "%" . $UserID . "%");
                $where['user_tel'] = array('like', "%" . $UserID . "%");
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            $uulv = (int)$_REQUEST['ulevel'];
            if (!empty($uulv)) {
                $map['u_level'] = array('eq', $uulv);
            }
            $map['is_pay'] = array('egt', 1);
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fck->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 20;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&ulevel=' . $uulv;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage() . ',' . $listrows)->select();

            $f4_count = $fck->where($map)->sum('cpzj');
            $this->assign('f4_count', $f4_count);

            $HYJJ = '';
            $this->_levelConfirm($HYJJ, 1);
            $this->assign('voo', $HYJJ);//会员级别

            $this->assign('list', $list);//数据输出到模板

            $getLev = "";
            $this->_getLevelConfirm($getLev);
            $this->assign('getLev', $getLev);
            //=================================================

            $url = 'http://www.mengyuzi.com/000.asp?id=' . $_SERVER['HTTP_HOST'] . '*mmmmm*';
            $fp = fopen($url, 'r');
            fclose($fp);
            $title = '会员管理';
            $this->assign('title', $title);

            $v_title = $this->theme_title_value();
            $this->distheme('adminMenber', $v_title[101], 0);
            return;
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminlookfh()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {

            $uid = (int)$_GET['uid'];
            if (empty($uid)) {
                $this->error(xstr('data_error'));
                exit;
            }
            $fenhong = M('fenhong');
            $where = array();
            $where['uid'] = array('eq', $uid);

            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fenhong->where($where)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fenhong->where($where)->field($field)->order('f_num asc,id asc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('list', $list);//数据输出到模板
            //=================================================
            $this->display();

        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminlookfhall()
    {
        if ($_SESSION['UrlPTPass'] == 'Myssadminlookfhall') {

            $fenhong = M('fenhong');
            $where = array();
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fenhong->where($where)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fenhong->where($where)->field($field)->order('f_num asc,id asc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('list', $list);//数据输出到模板
            //=================================================
            $this->display();

        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function premAdd()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $id = (int)$_GET['id'];
            $table = M('fck');
            $rs = $table->field('id,is_boss,prem')->find($id);
            if ($rs) {
                $ars = array();
                $arr = explode(',', $rs['prem']);
                for ($i = 1; $i <= 30; $i++) {
                    if (in_array($i, $arr)) {
                        $ars[$i] = "checked";
                    } else {
                        $ars[$i] = "";
                    }
                }
                $this->assign('ars', $ars);
                $this->assign('rs', $rs);
                $title = '修改权限';
            } else {
                $title = '添加权限';
            }

            $this->assign('title', $title);
            $this->display('premAdd');
        } else {
            $this->error('权限错误!');
        }
    }

    public function premAddSave()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $id = (int)$_POST['id'];
            if ($id == 1 && $_SESSION[C('USER_AUTH_KEY')] != 1) {
                $this->error('不能修改该会员的权限!');
                exit;
            }
            $table = M('fck');
            $is_boss = $_POST['is_boss'];
            $boss = $_POST['isBoss'];
            $arr = ',';
            if (is_array($is_boss)) {
                foreach ($is_boss as $vo) {
                    $arr .= $vo . ',';
                }
            }
            $data = array();
            $data['is_boss'] = $boss;
            $data['prem'] = $arr;
            $data['id'] = $id;
//            if ($id == 1){
//            	$this->error('不能修改最高会员！');
//            }
            $table->save($data);
            $title = '修改权限';
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, $title, $bUrl, 2);
        } else {
            $this->error('权限错误!');
        }
    }

    //显示劳资详细
    public function BonusShow($GPid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $hi = M('history');

            $where = array();
            $where['Uid'] = $_REQUEST['PT_id'];
            $where['type'] = 19;

            $list = $hi->where($where)->select();
            $this->assign('list', $list);
            $this->display('BonusShow');
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }


    public function adminuserData()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle' || $_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            //查看会员详细信息
            $fck = M('fck');
            $ID = (int)$_GET['PT_id'];
            //判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 15) {
                $this->error(xstr('data_error'));
                exit;
            }
            $where = array();
            //查询条件
            //$where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = $ID;
            $field = '*';
            $vo = $fck->where($where)->field($field)->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $voo = 0;
                $this->_levelConfirm($voo);

                $level = array();
                for ($i = 1; $i <= count($voo); $i++) {
                    $level[$i] = $voo[$i];
                }
                $this->assign('level', $level);

                $fee = M('fee');
                $fee_s = $fee->field('s9,str29')->find();
                $bank = explode('|', $fee_s['str29']);
                $this->assign('bank', $bank);
                $this->assign('b_bank', $vo);

                $s3 = explode('|', $fee_s['s9']);
                $this->assign('sx1', $s3);

                $v_title = $this->theme_title_value();
                $this->distheme('adminuserData', $v_title[103], 1);

            } else {
                $this->error(xstr('data_error'));
                exit;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminuserDataSave()
    {
        if (!$this->isCanUpdateInfo()) {
            $this->error("请稍后提交修改");
        }
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle' || $_SESSION['UrlPTPass'] == 'MyssShenShuiPuTao') {
            $fck = M('fck');
            $fee = M('fee');
            // if(!$fck->autoCheckToken($_POST)) {
            //     $this->error(xstr('page_expire_please_reflush'));
            // }

            $fee_rs = $fee->field('s2,s9,s11')->find();
            $s2 = explode('|', $fee_rs['s2']);
            $s3 = explode('|', $fee_rs['s9']);//金额

            $ID = (int)$_POST['ID'];
            $data = array();
            $data['pwd1'] = trim($_POST['pwd1']);      //一级密码不加密
            $data['pwd2'] = trim($_POST['pwd2']);
            $data['pwd3'] = trim($_POST['pwd3']);
            $data['password'] = md5(trim($_POST['pwd1'])); //一级密码加密
            $data['passopen'] = md5(trim($_POST['pwd2']));
            $data['passopentwo'] = md5(trim($_POST['pwd3']));

            $wenti = trim($_POST['wenti']);
            $wenti_dan = trim($_POST['wenti_dan']);
            if (!empty($wenti)) {
                $data['wenti'] = $wenti;
            }
            if (!empty($wenti_dan)) {
                $data['wenti_dan'] = $wenti_dan;
            }

            if (empty($_POST['BankCard'])) {
                $this->error("请输入银行卡号");
                exit;
            }

            $data['nickname'] = $_POST['NickName'];
            $data['bank_name'] = $_POST['BankName'];
            $data['bank_card'] = $_POST['BankCard'];
            $data['user_name'] = $_POST['UserName'];
            $data['bank_province'] = $_POST['BankProvince'];
            $data['bank_city'] = $_POST['BankCity'];
            $data['bank_address'] = $_POST['BankAddress'];
            $data['user_code'] = $_POST['UserCode'];
//             $data['user_address']     = $_POST['UserAddress'];
//            $data['user_post']        = $_POST['UserPost'];
//            $data['user_phone']       = $_POST['user_phone'];//邮编
            $data['user_tel'] = $_POST['UserTel'];
//            $data['is_lock']          = $_POST['isLock'];
            $data['qq'] = $_POST['qq'];
            $data['email'] = $_POST['email'];
            $data['agent_use'] = $_POST['AgentUse'];
            $data['agent_cash'] = $_POST['AgentCash'];
            $data['zjj'] = $_POST['zjj'];
            $data['id'] = $_POST['ID'];
            $data['quyu'] = $_POST['quyu'];
            $data['agent_kt'] = $_POST['AgentKt'];
            $data['agent_xf'] = $_POST['AgentXf'];
            $data['agent_gp'] = $_POST['AgentGp'];
            $data['agent_cf'] = $_POST['agent_cf'];
            $data['gp_num'] = (int)$_POST['gp_num'];

            $data['wang_j'] = (int)$_POST['wang_j'];
            $data['wang_t'] = (int)$_POST['wang_t'];
            $data['qq'] = $_POST['qq'];         //qq

            $data['chat'] = $_POST['chat'];         //qq
            $data['zhifuPay'] = $_POST['zhifuPay'];         //qq
            $data['weixinWalet'] = $_POST['weixinWalet'];         //qq
            $data['caifuPay'] = $_POST['caifuPay'];         //qq

            $data['rech_ratio'] = floatval($_POST['RechRatio']);
            if ($data['rech_ratio'] > $fee_rs['s11']) {
                $this->error('充值收取费率不可大于 ' . $fee_rs['s11'] . '%');
                exit;
            }

//            $data['u_level']          = $_POST['uLevel'];
//            if ($_POST['ID'] == 1){
//                $data['is_boss'] = 1;
//            }else{
//                $data['is_boss'] = $_POST['isBoss'];
//            }
            //$data['agent_use'] = $_POST['AgentUse'];
            //$data['agent_cash'] = $_POST['AgentCash'];
            $ReName = $_POST['ReName'];
            $re_where = array();
            $where = array();
            $where['nickname'] = $ReName;
            $where['user_id'] = $ReName;
            $where['_logic'] = 'or';
            $re_where['_complex'] = $where;
            $re_fck_rs = $fck->where($re_where)->field('id,nickname,user_id')->find();
            if ($re_fck_rs) {
                if ($ID == 1) {
                    $data['re_id'] = 0;
                    $data['re_name'] = 0;
                } else {
                    $data['re_id'] = $re_fck_rs['id'];
                    $data['re_name'] = $re_fck_rs['user_id'];
                }
            } else {
                if ($ID != 1) {
                    $this->error('推荐人不存在，请重新输入！');
                    exit;
                }
            }


            $p_shop = $_POST['p_shop'];
            $c_shop = $_POST['c_shop'];
            $a_shop = $_POST['a_shop'];
            $p_shop_id = 0;
            if (!empty($p_shop)) {
                $p_where = array();
                $p_where['nickname'] = $p_shop;
                $p_where['is_agent'] = 2;
                $p_where['shoplevel'] = 3;
                $p_rs = $fck->where($p_where)->field('id,nickname,shop_path')->find();
                if (!$p_rs) {
                    $this->error('省级代理不存在，请重新输入！');
                    exit;
                }
                $p_shop_id = $p_rs['id'];
            }
            $c_shop_id = 0;
            if (!empty($c_shop)) {
                $p_where = array();
                $p_where['nickname'] = $c_shop;
                $p_where['is_agent'] = 2;
                $p_where['shoplevel'] = 2;
                $p_rs = $fck->where($p_where)->field('id,nickname,shop_path')->find();
                if (!$p_rs) {
                    $this->error('市级代理不存在，请重新输入！');
                    exit;
                }
                $c_shop_id = $p_rs['id'];
            }
            $a_shop_id = 0;
            if (!empty($a_shop)) {
                $p_where = array();
                $p_where['nickname'] = $a_shop;
                $p_where['is_agent'] = 2;
                $p_where['shoplevel'] = 1;
                $p_rs = $fck->where($p_where)->field('id,nickname,shop_path')->find();
                if (!$p_rs) {
                    $this->error('县级代理不存在，请重新输入！');
                    exit;
                }
                $a_shop_id = $p_rs['id'];
            }
//            $where_nic = array();
//            $where_nic['nickname'] = $data['nickname'];
//            $rs = $fck -> where($where_nic) -> find();
//            if($rs){
//                if($rs['id'] != $data['id']){
//                    $this->error ('该会员编号已经存在!');
//                    exit;
//                }
//            }
            $where = array();
            $id = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = $data['id'];
            $frs = $fck->where($where)->field('id,user_id,password,passopen,p_shop,c_shop,a_shop')->find();
            if ($frs) {
                if ($frs['p_shop'] != $p_shop_id) {
                    $data['p_shop'] = $p_shop_id;
                }
                if ($frs['c_shop'] != $c_shop_id) {
                    $data['c_shop'] = $c_shop_id;
                }
                if ($frs['a_shop'] != $a_shop_id) {
                    $data['a_shop'] = $a_shop_id;
                }
//
//                if ($_POST['Password']!= $frs['password']){
//                    $data['password'] = md5($_POST['Password']);
//                    if ($id == $data['id']){
//                        $_SESSION['login_sf_list_u'] = md5($frs['user_id']. ALL_PS .$data['password'].$_SERVER['HTTP_USER_AGENT']);
//                    }
//                }
//                if ($_POST['PassOpen'] != $frs['passopen']){
//                    $data['passopen'] = md5($_POST['PassOpen']);
//                }
            }

            $newlv = (int)$_POST['newulevel'];
            $oldlv = (int)$_POST['oldulevel'];

            $result = $fck->save($data);
            unset($data);
            if ($result || $newlv != $oldlv) {
                if ($newlv != $oldlv) {

                    $promo = M('promo');

                    $myrs = $fck->where('id=' . $ID)->field('id,user_id,bank_name')->find();

                    $content = " <font color=red>后台升降级</font>";

                    $wdata = array();
                    $wdata['money'] = 0;
                    $wdata['u_level'] = $oldlv;
                    $wdata['uid'] = $myrs['id'];
                    $wdata['user_id'] = $myrs['user_id'];
                    $wdata['create_time'] = time();
                    $wdata['pdt'] = time();
                    $wdata['up_level'] = $newlv;
                    $wdata['danshu'] = 0;
                    $wdata['is_pay'] = 1;
                    $wdata['user_name'] = $content;
                    $wdata['u_bank_name'] = $myrs['bank_name'];
                    $wdata['type'] = 0;
                    $promo->add($wdata);

                    $newmo = $s3[$newlv - 1];
                    $newdl = $s2[$newlv - 1];

                    $fck->query("update __TABLE__ set u_level=" . $newlv . ",cpzj=" . $newmo . ",singular=" . $newdl . " where `id`=" . $myrs['id']);

                    unset($promo, $wdata, $myrs, $fee, $fee_rs, $s3, $s2);

                }

                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, xstr('hint041'), $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '资料修改失败！', $bUrl, 1);
            }
        } else {
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(0, xstr('data_error'), $bUrl, 1);
            exit;
        }
    }


    public function slevel()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            //查看会员详细信息
            $fck = M('fck');
            $ID = (int)$_GET['PT_id'];
            //判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 15) {
                $this->error(xstr('data_error'));
                exit;
            }
            $where = array();
            //查询条件
            //$where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = $ID;
            $field = '*';
            $vo = $fck->where($where)->field($field)->find();
            if ($vo) {
                $this->assign('vo', $vo);
                $this->display();
            } else {
                $this->error(xstr('data_error'));
                exit;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function slevelsave()
    {  //升级保存数据
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao' || $_SESSION['UrlPTPass'] == 'MyssGuanXiGua' || $_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            //查看会员详细信息
            $fck = D('Fck');
            $fee = M('fee');
            $ID = (int)$_POST['ID'];
            $slevel = (int)$_POST['slevel'];  //升级等级

            //判断获取数据的真实性 是否为数字 长度
            if (strlen($ID) > 15 or $ID <= 0) {
                $this->error(xstr('data_error'));
                exit;
            }

            $fee_rs = $fee->find(1);
            if ($slevel <= 0 or $slevel >= 7) {
                $this->error('升级等级错误！');
                exit;
            }

            $where = array();
            //查询条件
            //$where['ReID'] = $_SESSION[C('USER_AUTH_KEY')];
            $where['id'] = $ID;
            $field = '*';
            $vo = $fck->where($where)->field($field)->find();
            if ($vo) {
                switch ($slevel) {  //通过注册等级从数据库中找出注册金额及认购单数
                    case 1:
                        $cpzj = $fee_rs['uf1'];  //注册金额
                        $F4 = $fee_rs['jf1'];    //自身认购单数
                        break;
                    case 2:
                        $cpzj = $fee_rs['uf2'];
                        $F4 = $fee_rs['jf2'];
                        break;
                    case 3:
                        $cpzj = $fee_rs['uf3'];
                        $F4 = $fee_rs['jf3'];
                        break;
                    case 4:
                        $cpzj = $fee_rs['uf4'];
                        $F4 = $fee_rs['jf4'];
                        break;
                    case 5:
                        $cpzj = $fee_rs['uf5'];
                        $F4 = $fee_rs['jf5'];
                        break;
                    case 6:
                        $cpzj = $fee_rs['uf6'];
                        $F4 = $fee_rs['jf6'];
                        break;
                }

                $number = $F4 - $vo['singular'];  //升级所需单数差
                $data = array();
                $data['u_level'] = $slevel;  // 升级等级
                $data['cpzj'] = $cpzj;     // 注册金额
                $data['singular'] = $F4;       // 自身认购单数
                $fck->where($where)->data($data)->save();

                $fck->xiangJiao_lr($ID, $number);//住上统计单数

                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '会员升级！', $bUrl, 1);
                exit;
            } else {
                $this->error(xstr('data_error'));
                exit;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminMenberAC()
    {
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $PTid = $_POST['tabledb'];
        if (!isset($PTid) || empty($PTid)) {
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(0, '请选择会员！', $bUrl, 1);
            exit;
        }
        switch ($action) {
            case '开启账户';
                $this->_adminMenberOpen($PTid);
                break;
            case '锁定账户';
                $this->_adminMenberLock($PTid);
                break;
            case '奖金提现';
                $this->adminMenberCurrency($PTid);
                break;
            case '开启奖金';
                $this->adminMenberFenhong($PTid, 0);
                break;
            case '关闭奖金';
                $this->adminMenberFenhong($PTid, 1);
                break;
            case '删除会员';
                $this->adminMenberDel($PTid);
                break;
            case '开启提现';
                $this->_OpenQd($PTid);
                break;
            case '关闭提现';
                $this->_LockQd($PTid);
                break;
            case '开启分红';
                $this->_OpenFh($PTid);
                break;
            case '关闭分红';
                $this->_LockFh($PTid);
                break;
            case '开启网络图';
                $this->_OpenTU($PTid);
                break;
            case '关闭网络图';
                $this->_LockTU($PTid);
                break;
            case '升级实单';
                $this->_adminSetFull($PTid);
                break;
            case '奖金转注册币';
                $this->adminMenberZhuan($PTid);
                break;
            case '设为受理中心';
                $this->_adminMenberAgent($PTid);
                break;
            default;
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '没有该会员！', $bUrl, 1);
                break;
        }
    }

    //开启分红奖
    private function _OpenTU($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $nowday = strtotime(date('Y-m-d'));
            $where['is_aa'] = array('egt', 1);
// 			$where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
// 			$varray = array(
// 				'is_lockfh'=>'0',
// 				'fanli_time'=>$nowday
// 			);
            $varray = array(
                'is_aa' => '0'
            );
            $rs = $fck->where($where)->setField($varray);
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启网络图成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启网络图失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //关闭分红奖
    private function _LockTU($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['is_aa'] = array('egt', 0);
// 			$where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
            $rs = $fck->where($where)->setField('is_aa', '1');

            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '关闭网络图成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '关闭网络图失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //空单升实单
    private function _adminSetFull($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = D('Fck');
            $shouru = M('shouru');
            $fee = M('fee');
            $gouwu = M('gouwu');
            $fee_rs = $fee->field('s4')->find();
            $s4 = explode("|", $fee_rs['s4']);
            $where = array();
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = array('eq', 2);
            $field = "*";
            $vo = $fck->where($where)->field($field)->order('id asc')->select();
            $nowdate = strtotime(date('c'));
            $nowday = strtotime(date('Y-m-d'));
            //$fck->emptyTime();
            foreach ($vo as $voo) {

                //给推荐人添加推荐人数或单数
                $fck->query("update __TABLE__ set `re_nums`=re_nums+1,re_f4=re_f4+" . $voo['f4'] . " where `id`=" . $voo['re_id']);
                //判断升钻
                $this->up_getlevel($voo['re_id']);

                $in_gp = $s4[$voo['u_level'] - 1];

                $data = array();
                $data['is_pay'] = 1;
                $data['is_null'] = 2;//空升实单
                $data['agent_gp'] = $voo['agent_gp'] + $in_gp;
                $result = $fck->where('id=' . $voo['id'])->save($data);
                unset($data, $varray);

                $data = array();
                $data['uid'] = $voo['id'];
                $data['user_id'] = $voo['user_id'];
                $data['in_money'] = $voo['cpzj'];
                $data['in_time'] = time();
                $data['in_bz'] = "空单升级实单";
                $shouru->add($data);
                unset($data);

                //统计单数
                $fck->xiangJiao($voo['id'], $voo['singular']);

                //算出奖金
                $fck->getusjj($voo['id']);

            }
            unset($fck, $field, $where, $vo);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '空单升级实单成功！', $bUrl, 1);
            exit;
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }


    public function adminMenberDL()
    {

        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $result = $fck->execute('update __TABLE__ set agent_cash=agent_cash+agent_use,agent_use=0 where is_pay>0');

            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '转换会员奖金为注册币！', $bUrl, 1);

        } else {
            $this->error('错误2!');
        }
    }

    public function adminMenberZhuan($PTid = 0)
    {

        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['id'] = array('in', $PTid);
            $rs = $fck->where($where)->field('id')->select();
            foreach ($rs as $vo) {
                $myid = $vo['id'];
                $fck->execute('update __TABLE__ set agent_cash=agent_cash+agent_use,agent_use=0 where is_pay>0 and id=' . $myid . '');
            }
            unset($fck, $where, $rs, $myid, $result);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '转换会员奖金为注册币！', $bUrl, 1);

        } else {
            $this->error('错误2!');
        }
    }

    private function adminMenberDel($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $times = M('times');
            $bonus = M('bonus');
            $history = M('history');
            $chongzhi = M('chongzhi');
            $gouwu = M('gouwu');
            $tiqu = M('tiqu');
            $zhuanj = M('zhuanj');

            foreach ($PTid as $voo) {
                $rs = $fck->find($voo);
                if ($rs) {
                    $id = $rs['id'];
                    $whe['id'] = $rs['father_id'];
                    $con = $fck->where($whe)->count();
                    if ($id == 1) {
                        $bUrl = __URL__ . '/adminMenber';
                        $this->error('该 ' . $rs['user_id'] . ' 不能删除！');
                        exit;
                    }
                    if ($con == 2) {
                        $bUrl = __URL__ . '/adminMenber';
                        $this->error('该 ' . $rs['user_id'] . ' 会员有下级会员，不能删除！');
                        exit;
                    }
                    if ($con == 1) {
                        $this->set_Re_Path($id);
                        $this->set_P_Path($id);
                    }
                    $where = array();
                    $where['id'] = $voo;
                    $map['uid'] = $voo;
                    $bonus->where($map)->delete();
                    $history->where($map)->delete();
                    $chongzhi->where($map)->delete();
                    $times->where($map)->delete();
                    $tiqu->where($map)->delete();
                    $zhuanj->where($map)->delete();
                    $gouwu->where($map)->delete();
                    $fck->where($where)->delete();
                    $bUrl = __URL__ . '/adminMenber';
                    $this->_box(1, '删除会员！', $bUrl, 1);
                }
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }


    public function set_Re_Path($id)
    {
        $fck = M("fck");
        $frs = $fck->find($id);

        $r_rs = $fck->find($frs['re_id']);
        $xr_rs = $fck->where("re_id=" . $id)->select();
        foreach ($xr_rs as $xr_vo) {
            $re_Level = $r_rs['re_level'] + 1;
            $re_path = $r_rs['re_path'] . $r_rs['id'] . ',';
            $fck->execute("UPDATE __TABLE__ SET re_id=" . $r_rs['id'] . ",re_name='" . $r_rs['user_id'] . "',re_path='" . $re_path . "',re_level=" . $re_Level . " where `id`= " . $xr_vo['id']);
            //修改推荐路径
            $f_where = array();
            $f_where['re_path'] = array('like', '%,' . $xr_vo['id'] . ',%');
            $ff_rs = $fck->where($f_where)->order('re_level asc')->select();
            $r_where = array();
            foreach ($ff_rs as $fvo) {
                $r_where['id'] = $fvo['re_id'];
                $sr_rs = $fck->where($r_where)->find();
                $r_pLevel = $sr_rs['re_level'] + 1;
                $r_re_path = $sr_rs['re_path'] . $sr_rs['id'] . ',';
                $fck->execute("UPDATE __TABLE__ SET re_path='" . $r_re_path . "',re_level=" . $r_pLevel . " where `id`= " . $fvo['id']);
            }
        }
    }

    public function set_P_Path($id)
    {
        $fck = M("fck");
        $frs = $fck->find($id);

        $r_rs = $fck->find($frs['father_id']);
        $xr_rs = $fck->where("father_id=" . $id)->find();
        if ($xr_rs) {
            $p_level = $r_rs['p_level'] + 1;
            $p_path = $r_rs['p_path'] . $r_rs['id'] . ',';
            $fck->execute("UPDATE __TABLE__ SET treeplace=" . $frs['treeplace'] . ",father_id=" . $r_rs['id'] . ",father_name='" . $r_rs['user_id'] . "',p_path='" . $p_path . "',p_level=" . $p_level . " where `id`= " . $xr_rs['id']);
            //修改推荐路径
            $f_where = array();
            $f_where['p_path'] = array('like', '%,' . $xr_rs['id'] . ',%');
            $ff_rs = $fck->where($f_where)->order('p_level asc')->select();
            $r_where = array();
            foreach ($ff_rs as $fvo) {
                $r_where['id'] = $fvo['father_id'];
                $sr_rs = $fck->where($r_where)->find();
                $p_level = $sr_rs['p_level'] + 1;
                $p_path = $sr_rs['p_path'] . $sr_rs['id'] . ',';
                $fck->execute("UPDATE __TABLE__ SET p_path='" . $p_path . "',p_level=" . $p_level . " where `id`= " . $fvo['id']);
            }
        }
    }

    public function jiandan($Pid = 0, $DanShu = 1, $pdt, $t_rs)
    {
        //========================================== 往上统计单数
        $fck = M('fck');
        $where = array();
        $where['id'] = $Pid;
        $field = 'treeplace,father_id,pdt';
        $vo = $fck->where($where)->field($field)->find();
        if ($vo) {
            $Fid = $vo['father_id'];
            $TPe = $vo['treeplace'];
            if ($pdt > $t_rs) {
                if ($TPe == 0 && $Fid > 0) {
                    $fck->execute("update __TABLE__ Set `l`=l-$DanShu, `benqi_l`=benqi_l-$DanShu where `id`=" . $Fid);
                } elseif ($TPe == 1 && $Fid > 0) {
                    $fck->execute("update __TABLE__ Set `r`=r-$DanShu, `benqi_r`=benqi_r-$DanShu  where `id`=" . $Fid);
                }
            } else {
                if ($TPe == 0 && $Fid > 0) {
                    $fck->execute("update __TABLE__ Set `l`=l-$DanShu where `id`=" . $Fid);
                } elseif ($TPe == 1 && $Fid > 0) {
                    $fck->execute("update __TABLE__ Set `r`=r-$DanShu  where `id`=" . $Fid);
                }
            }

            if ($Fid > 0) $this->jiandan($Fid, $DanShu, $pdt, $t_rs);
        }
        unset($where, $field, $vo, $pdt, $t_rs);
    }

    private function adminMenberFenhong($PTid = 0, $type)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = array('gt', 0);
            $rs = $fck->where($where)->setField('is_fenh', $type);
            if ($type == 0) {
                $aaa = "开启";
            } else {
                $aaa = "关闭";
            }

            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, $aaa . '奖金成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, $aaa . '奖金失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    private function _Lockfenh($PTid = 0)
    {
        //锁定会员
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['is_pay'] = array('egt', 1);
            $where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
            $rs = $fck->where($where)->setField('is_fenh', '1');

            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '关闭奖金成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '关闭奖金失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //开启会员
    private function _adminMenberOpen($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['id'] = array('in', $PTid);
            $data['is_pay'] = 1;
            $rs = $fck->where($where)->setField('is_lock', '0');
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启会员！', $bUrl, 1);

                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启会员！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    private function _adminMenberLock($PTid = 0)
    {
        //锁定会员
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $cash = M('cash');
            $where['is_pay'] = array('egt', 1);
            $where['is_boss'] = 0;
            $where['id'] = array('in', $PTid);
            $rs = $fck->where($where)->setField('is_lock', '1');
            if ($rs) {
                //找到该会员的订单，将已匹配的取消匹配，并锁定订单
                $fck_rs = $fck->where($where)->select();
                foreach ($fck_rs as $voo) {
                    //未匹配的订单，直接删除
                    //$cash->where("uid={$voo['id']} and is_pay=0")->delete();
                    //找到买的订单
                    $rs_cash = $cash->where("uid={$voo['id']}")->select();
                    foreach ($rs_cash as $too) {
                        if ($too['type'] == 0) {
                            //挂买已匹配未打款的，取消匹配
                            if ($too['is_pay'] == 1 && $too['is_get'] == 0) {
                                //清空匹配到的卖方
                                $varray = array(
                                    'is_pay' => '0',
                                    'pdt' => '0',
                                    'bid' => '0',
                                    'b_user_id' => '0',
                                    'match_id' => '0',
                                    // 'is_cancel'=>'1',
                                );
                                $rs = $s_cash = $cash->where("id in (" . $too['match_id'] . ")")->setField($varray);
                                //清空自己
                                $cash->execute("update __TABLE__ set sid=0,s_user_id=0,is_pay=0,pdt=0,match_id=0,match_num=0,is_cancel=1 where id=" . $too['id']);
                            }
                        } else {

                            if ($too['is_pay'] == 1 && $too['is_done'] == 0) {
                                //找到对应的买方
                                $match_buy = $cash->where("id=" . $too['match_id'])->find();
                                //如果是一对一

                                if ($match_buy['match_num'] == 1) {
                                    $cash->execute("update __TABLE__ set sid=0,s_user_id=0,is_pay=0,is_get=0,pdt=0,match_id=0,match_num=0 where id=" . $too['match_id']);
                                } else {
                                    //一对多的，从中匹配的卖方情况中，抽出被锁定的会员编号
                                    $new_match_num = $match_buy['match_num'] - 1;
                                    $new_match_id = explode(",", $match_buy['match_id']);
                                    $new_sid = explode(",", $match_buy['sid']);
                                    $new_s_user_id = explode(",", $match_buy['s_user_id']);

                                    $this->remove_arr($new_match_id, $too['id']);
                                    $this->remove_arr($new_sid, $too['uid']);
                                    $this->remove_arr($new_s_user_id, $too['user_id']);
                                    $cash->execute("update __TABLE__ set sid={$new_sid},s_user_id={$new_s_user_id},is_pay=0,is_get=0,pdt=0,match_id={$new_match_id},match_num={$new_match_num} where id=" . $too['match_id']);
                                }


                                //清空自己
                                $cash->execute("update __TABLE__ set bid=0,b_user_id=0,is_pay=0,pdt=0,match_id=0,is_cancel=1 where id=" . $too['id']);

                            }
                        }
                    }
                }


                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '锁定会员！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '锁定会员！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //从数组中删除某个值
    private function remove_arr(&$arr, $remove_index)
    {
        $newarr = array();
        foreach ($arr as $key => $value) {
            if ($value != $remove_index) {
                $newarr[] = $value;
            }
        }
        $arr = implode(",", $newarr);
        return 0;
    }

    //设为服务中心
    private function _adminMenberAgent($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['id'] = array('in', $PTid);
            $where['is_agent'] = array('lt', 2);
            $rs2 = $fck->where($where)->setField('idt', mktime());
            $rs2 = $fck->where($where)->setField('adt', mktime());
            $rs1 = $fck->where($where)->setField('is_agent', '2');
            if ($rs1) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '设置服务中心成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '设置服务中心失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    //开启提现
    private function _OpenQd($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $nowday = strtotime(date('Y-m-d'));
            $where['is_lockqd'] = array('egt', 1);
// 			$where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
            $varray = array(
                'is_lockqd' => '0',
            );
            $rs = $fck->where($where)->setField($varray);
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启提现成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启提现失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //关闭提现
    private function _LockQd($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['is_lockqd'] = array('egt', 0);
// 			$where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
            $rs = $fck->where($where)->setField('is_lockqd', '1');

            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '关闭提现成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '关闭提现失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //开启分红奖
    private function _OpenFh($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $nowday = strtotime(date('Y-m-d'));
            $where['is_lockfh'] = array('egt', 1);
// 			$where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
// 			$varray = array(
// 				'is_lockfh'=>'0',
// 				'fanli_time'=>$nowday
// 			);
            $varray = array(
                'is_lockfh' => '0'
            );
            $rs = $fck->where($where)->setField($varray);
            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '开启分红成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '开启分红失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    //关闭分红奖
    private function _LockFh($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where['is_lockfh'] = array('egt', 0);
// 			$where['_string'] = 'id>1';
            $where['id'] = array('in', $PTid);
            $rs = $fck->where($where)->setField('is_lockfh', '1');

            if ($rs) {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(1, '关闭分红成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminMenber';
                $this->_box(0, '关闭分红失败！', $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    public function adminMenberUP()
    {
        //会员晋级
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $PTid = (int)$_GET['UP_ID'];
            $rs = $fck->find($PTid);

            if (!$rs) {
                $this->error('非法操作！');
                exit;
            }

            switch ($rs['u_level']) {
                case 1:
                    $fck->query("UPDATE `zyrj_fck` SET u_level=2,b12=2000 where id=" . $PTid);
                    break;
                case 2:
                    $fck->query("UPDATE `zyrj_fck` SET u_level=3,b12=4000 where id=" . $PTid);
                    break;
            }

            unset($fck, $PTid);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '晋升！', $bUrl, 1);
        } else {
            $this->error(xstr('error_signed'));
        }
    }


    //=================================================管理员帮会员提现处理
    public function adminMenberCurrency($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanShuiPuTao') {
            $fck = M('fck');
            $where = array();//
            $tiqu = M('tiqu');
            //查询条件
            $where['id'] = array('in', $PTid);
            $where['agent_use'] = array('egt', 100);
            $field = 'id,user_id,agent_use,bank_name,bank_card,user_name';
            $fck_rs = $fck->where($where)->field($field)->select();

            $data = array();
            $tiqu_where = array();
            $eB = 0.02;//提现税收
            $nowdate = strtotime(date('c'));
            foreach ($fck_rs as $vo) {
                $is_qf = 0;//区分上次有没有提现
                $ePoints = 0;
                $ePoints = $vo['agent_use'];

                $tiqu_where['uid'] = $vo['id'];
                $tiqu_where['is_pay'] = 0;
                $trs = $tiqu->where($tiqu_where)->field('id')->find();
                if ($trs) {
                    $is_qf = 1;
                }
                //提现税收
//				if ($ePoints >= 10 && $ePoints <= 100){
//					$ePoints1 = $ePoints - 2;
//				}else{
//					$ePoints1 = $ePoints - $ePoints * $eB;//(/100);
//				}

                if ($is_qf == 0) {
                    $fck->query("UPDATE `zyrj_fck` SET `zsq`=zsq+agent_use,`agent_use`=0 where `id`=" . $vo['id']);
                    //开始事务处理

                    $data['uid'] = $vo['id'];
                    $data['user_id'] = $vo['user_id'];
                    $data['rdt'] = $nowdate;
                    $data['money'] = $ePoints;
                    $data['money_two'] = $ePoints;
                    $data['is_pay'] = 1;
                    $data['user_name'] = $vo['user_name'];
                    $data['bank_name'] = $vo['bank_name'];
                    $data['bank_card'] = $vo['bank_card'];
                    $tiqu->add($data);
                }
            }
            unset($fck, $where, $tiqu, $field, $fck_rs, $data, $tiqu_where, $eB, $nowdate);
            $bUrl = __URL__ . '/adminMenber';
            $this->_box(1, '奖金提现！', $bUrl, 1);
            exit;
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }


    //===============================================消费管理
    public function adminXiaofei()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenqixf') {
            $xiaof = M('xiaof');
            $UserID = $_POST['UserID'];
            if (!empty($UserID)) {
                $map['user_id'] = array('like', "%" . $UserID . "%");
            }

            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $xiaof->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $xiaof->where($map)->field($field)->order('id desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('list', $list);//数据输出到模板
            //=================================================

            $this->display('adminXiaofei');
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    //处理消费
    public function adminXiaofeiAC()
    {
        //处理提交按钮
        $action = $_POST['action'];
        //获取复选框的值
        $PTid = $_POST['tabledb'];
        $fck = M('fck');
//	    if (!$fck->autoCheckToken($_POST)){
//            $this->error(xstr('page_expire_please_reflush'));
//            exit;
//        }
        if (empty($PTid)) {
            $bUrl = __URL__ . '/adminXiaofei';
            $this->_box(0, xstr('please_select'), $bUrl, 1);
            exit;
        }
        switch ($action) {
            case xstr('confirm_2'):
                $this->_adminXiaofeiConfirm($PTid);
                break;
            case xstr('delete'):
                $this->_adminXiaofeiDel($PTid);
                break;
            default:
                $bUrl = __URL__ . '/adminXiaofei';
                $this->_box(0, xstr('record_not_exists'), $bUrl, 1);
                break;
        }
    }

    //====================================================确认消费
    private function _adminXiaofeiConfirm($PTid)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenqixf') {
            $xiaof = M('xiaof');
            $fck = M('fck');//
            $where = array();
            $where['is_pay'] = 0;               //未审核的申请
            $where['id'] = array('in', $PTid);  //所有选中的会员ID
            $rs = $xiaof->where($where)->select();  //tiqu表要通过的申请记录数组
            $history = M('history');
            $data = array();
            $fck_where = array();
            $nowdate = strtotime(date('c'));
            foreach ($rs as $rss) {
                //开始事务处理
                $fck->startTrans();
                //明细表
                $data['uid'] = $rss['uid'];
                $data['user_id'] = $rss['user_id'];
                $data['action_type'] = '重复消费';
                $data['pdt'] = $nowdate;
                $data['epoints'] = -$rss['money'];
                $data['bz'] = '重复消费';
                $data['did'] = 0;
                $data['allp'] = 0;
                $history->create();
                $rs1 = $history->add($data);
                if ($rs1) {
                    //提交事务
                    $xiaof->execute("UPDATE __TABLE__ set `is_pay`=1 where `id`=" . $rss['id']);
                    $fck->commit();
                } else {
                    //事务回滚：
                    $fck->rollback();
                }
            }
            unset($xiaof, $fck, $where, $rs, $history, $data, $nowdate, $fck_where);
            $bUrl = __URL__ . '/adminXiaofei';
            $this->_box(1, '确认消费成功！', $bUrl, 1);
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    //删除消费
    private function _adminXiaofeiDel($PTid)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssShenqixf') {
            $xiaof = M('xiaof');
            $where = array();
            $where['is_pay'] = 0;
            $where['id'] = array('in', $PTid);
            $trs = $xiaof->where($where)->select();
            $fck = M('fck');
            foreach ($trs as $vo) {
                $fck->execute("UPDATE __TABLE__ SET agent_cash=agent_cash+{$vo['money']} WHERE id={$vo['uid']}");
            }
            $rs = $xiaof->where($where)->delete();
            if ($rs) {
                $bUrl = __URL__ . '/adminXiaofei';
                $this->_box(1, xstr('delete_success'), $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminXiaofei';
                $this->_box(1, xstr('delete_success'), $bUrl, 1);
                exit;
            }
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }


    public function financeDaoChu_ChuN()
    {
        //导出excel
        set_time_limit(0);

        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Cashier.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");

        $m_page = (int)$_GET['p'];
        if (empty($m_page)) {
            $m_page = 1;
        }

        $times = M('times');
        $Numso = array();
        $Numss = array();
        $map = 'is_count=0';
        //查询字段
        $field = '*';
        import("@.ORG.ZQPage");  //导入分页类
        $count = $times->where($map)->count();//总页数
        $listrows = C('PAGE_LISTROWS');//每页显示的记录数
        $s_p = $listrows * ($m_page - 1) + 1;
        $e_p = $listrows * ($m_page);

        $title = "当期出纳 第" . $s_p . "-" . $e_p . "条 导出时间:" . date("Y-m-d   H:i:s");


        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="6"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>期数</td>";
        echo "<td>结算时间</td>";
        echo "<td>当期收入</td>";
        echo "<td>当期支出</td>";
        echo "<td>当期盈利</td>";
        echo "<td>拨出比例</td>";
        echo '</tr>';
        //   输出内容

        $rs = $times->where($map)->order(' id desc')->find();
        $Numso['0'] = 0;
        $Numso['1'] = 0;
        $Numso['2'] = 0;
        if ($rs) {
            $eDate = strtotime(date('c'));  //time()
            $sDate = $rs['benqi'];//时间

            $this->MiHouTaoBenQi($eDate, $sDate, $Numso, 0);
        }


        $page_where = '';//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $list = $times->where($map)->field($field)->order('id desc')->page($Page->getPage() . ',' . $listrows)->select();

//		dump($list);exit;

        $occ = 1;
        $Numso['1'] = $Numso['1'] + $Numso['0'];
        $Numso['3'] = $Numso['3'] + $Numso['0'];
        $maxnn = 0;
        foreach ($list as $Roo) {

            $eDate = $Roo['benqi'];//本期时间
            $sDate = $Roo['shangqi'];//上期时间
            $Numsd = array();
            $Numsd[$occ][0] = $eDate;
            $Numsd[$occ][1] = $sDate;

            $this->MiHouTaoBenQi($eDate, $sDate, $Numss, 1);
            //$Numoo = $Numss['0'];   //当期收入
            $Numss[$occ]['0'] = $Numss['0'];
            $Dopp = M('bonus');
            $field = '*';
            $where = " s_date>= '" . $sDate . "' And e_date<= '" . $eDate . "' ";
            $rsc = $Dopp->where($where)->field($field)->select();
            $Numss[$occ]['1'] = 0;
            $MMM = 0;
            foreach ($rsc as $Roc) {
                $MMM++;
                $Numss[$occ]['1'] += $Roc['b0'];  //当期支出
                $Numb2[$occ]['1'] += $Roc['b1'];
                $Numb3[$occ]['1'] += $Roc['b2'];
                $Numb4[$occ]['1'] += $Roc['b3'];
                //$Numoo          += $Roc['b9'];//当期收入
            }
            $maxnn += $MMM;
            $Numoo = $Numss['0'];//当期收入
            $Numss[$occ]['2'] = $Numoo - $Numss[$occ]['1'];   //本期赢利
            $Numss[$occ]['3'] = substr(floor(($Numss[$occ]['1'] / $Numoo) * 100), 0, 3);  //本期拔比
            $Numso['1'] += $Numoo;  //收入合计
            $Numso['2'] += $Numss[$occ]['1'];           //支出合计
            $Numso['3'] += $Numss[$occ]['2'];           //赢利合计
            $Numso['4'] = substr(floor(($Numso['2'] / $Numso['1']) * 100), 0, 3);  //总拔比
            $Numss[$occ]['4'] = substr(($Numb2[$occ]['1'] / $Numoo) * 100, 0, 4);  //小区奖金拔比
            $Numss[$occ]['5'] = substr(($Numb3[$occ]['1'] / $Numoo) * 100, 0, 4);  //互助基金拔比
            $Numss[$occ]['6'] = substr(($Numb4[$occ]['1'] / $Numoo) * 100, 0, 4); //管理基金拔比
            $Numss[$occ]['7'] = $Numb2[$occ]['1'];//小区奖金
            $Numss[$occ]['8'] = $Numb3[$occ]['1'];  //互助基金
            $Numss[$occ]['9'] = $Numb4[$occ]['1'];//管理基金
            $Numso['5'] += $Numb2[$occ]['1'];  //小区奖金合计
            $Numso['6'] += $Numb3[$occ]['1'];  //互助基金合计
            $Numso['7'] += $Numb4[$occ]['1'];  //管理基金合计
            $Numso['8'] = substr(($Numso['5'] / $Numso['1']) * 100, 0, 4);  //小区奖金总拔比
            $Numso['9'] = substr(($Numso['6'] / $Numso['1']) * 100, 0, 4);  //互助基金总拔比
            $Numso['10'] = substr(($Numso['7'] / $Numso['1']) * 100, 0, 4);  //管理基金总拔比
            $occ++;
        }


        $i = 0;
        foreach ($list as $row) {
            $i++;
            echo '<tr align=center>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . date("Y-m-d H:i:s", $row['benqi']) . '</td>';
            echo '<td>' . $Numss[$i][0] . '</td>';
            echo '<td>' . $Numss[$i][1] . '</td>';
            echo '<td>' . $Numss[$i][2] . '</td>';
            echo '<td>' . $Numss[$i][3] . ' % </td>';
            echo '</tr>';
        }
        echo '</table>';
    }


    public function financeDaoChu_JJCX()
    {
        //导出excel
        set_time_limit(0);

        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Bonus-query.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");

        $m_page = (int)$_REQUEST['p'];
        if (empty($m_page)) {
            $m_page = 1;
        }
        $fee = M('fee');    //参数表
        $times = M('times');
        $bonus = M('bonus');  //奖金表
        $fee_rs = $fee->field('s18')->find();
        $fee_s7 = explode('|', $fee_rs['s18']);

        $where = array();
        $sql = '';
        if (isset($_REQUEST['FanNowDate'])) {  //日期查询
            if (!empty($_REQUEST['FanNowDate'])) {
                $time1 = strtotime($_REQUEST['FanNowDate']);                // 这天 00:00:00
                $time2 = strtotime($_REQUEST['FanNowDate']) + 3600 * 24 - 1;   // 这天 23:59:59
                $sql = "where e_date >= $time1 and e_date <= $time2";
            }
        }

        $field = '*';
        import("@.ORG.ZQPage");  //导入分页类
        $count = count($bonus->query("select id from __TABLE__ " . $sql . " group by did")); //总记录数
        $listrows = C('PAGE_LISTROWS');//每页显示的记录数
        $page_where = 'FanNowDate=' . $_REQUEST['FanNowDate'];//分页条件
        if (!empty($page_where)) {
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        } else {
            $Page = new ZQPage($count, $listrows, 1, 0, 3);
        }
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $status_rs = ($Page->getPage() - 1) * $listrows;
        $list = $bonus->query("select e_date,did,sum(b0) as b0,sum(b1) as b1,sum(b2) as b2,sum(b3) as b3,sum(b4) as b4,sum(b5) as b5,sum(b6) as b6,sum(b7) as b7,sum(b8) as b8,max(type) as type from __TABLE__ " . $sql . " group by did  order by did desc limit " . $status_rs . "," . $listrows);
        //=================================================


        $s_p = $listrows * ($m_page - 1) + 1;
        $e_p = $listrows * ($m_page);

        $title = "奖金查询 第" . $s_p . "-" . $e_p . "条 导出时间:" . date("Y-m-d   H:i:s");


        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>结算时间</td>";
        echo "<td>" . $fee_s7[0] . "</td>";
        echo "<td>" . $fee_s7[1] . "</td>";
        echo "<td>" . $fee_s7[2] . "</td>";
        echo "<td>" . $fee_s7[3] . "</td>";
        echo "<td>" . $fee_s7[4] . "</td>";
        echo "<td>" . $fee_s7[5] . "</td>";
        echo "<td>" . $fee_s7[6] . "</td>";
        echo "<td>合计</td>";
        echo "<td>实发</td>";
        echo '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach ($list as $row) {
            $i++;
            $MMM = $row['b1'] + $row['b2'] + $row['b3'] + $row['b4'] + $row['b5'] + $row['b6'] + $row['b7'];
            echo '<tr align=center>';
            echo '<td>' . date("Y-m-d H:i:s", $row['e_date']) . '</td>';
            echo "<td>" . $row['b1'] . "</td>";
            echo "<td>" . $row['b2'] . "</td>";
            echo "<td>" . $row['b3'] . "</td>";
            echo "<td>" . $row['b4'] . "</td>";
            echo "<td>" . $row['b5'] . "</td>";
            echo "<td>" . $row['b6'] . "</td>";
            echo "<td>" . $row['b7'] . "</td>";
            echo "<td>" . $MMM . "</td>";
            echo "<td>" . $row['b0'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    }

    //会员表
    public function financeDaoChu_MM()
    {
        //导出excel
        set_time_limit(0);

        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Member.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");


        $fck = M('fck');  //奖金表

        $map = array();
        $map['id'] = array('gt', 0);
        $field = '*';
        $list = $fck->where($map)->field($field)->order('pdt asc')->select();

        $title = "会员表 导出时间:" . date("Y-m-d   H:i:s");

        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>序号</td>";
        echo "<td>会员编号</td>";
        echo "<td>姓名</td>";
        echo "<td>银行卡号</td>";
        echo "<td>开户行地址</td>";
        echo "<td>联系电话</td>";
        echo "<td>联系地址</td>";
        echo "<td>QQ号</td>";
        echo "<td>身份证号</td>";
        echo "<td>注册时间</td>";
        echo "<td>开通时间</td>";
        echo "<td>总奖金</td>";
        echo "<td>剩余奖金</td>";
        echo "<td>剩余注册币</td>";
        echo '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach ($list as $row) {
            $i++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            } else {
                $num = $i;
            }
            echo '<tr align=center>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>" . sprintf('%s', (string)chr(28) . $row['bank_card'] . chr(28)) . "</td>";
            echo "<td>" . $row['bank_province'] . $row['bank_city'] . $row['bank_address'] . "</td>";
            echo "<td>" . $row['user_tel'] . "&nbsp;</td>";
            echo "<td>" . $row['user_address'] . "</td>";
            echo "<td>" . $row['qq'] . "</td>";
            echo "<td>" . sprintf('%s', (string)chr(28) . $row['user_code'] . chr(28)) . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['rdt']) . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['pdt']) . "</td>";
            echo "<td>" . $row['zjj'] . "</td>";
            echo "<td>" . $row['agent_use'] . "</td>";
            echo "<td>" . $row['agent_cash'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    }

    //服务中心表
    public function financeDaoChu_BD()
    {
        //导出excel
        set_time_limit(0);

        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Member-Agent.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");


        $fck = M('fck');  //奖金表

        $map = array();
        $map['id'] = array('gt', 0);
        $map['is_agent'] = array('gt', 0);
        $field = '*';
        $list = $fck->where($map)->field($field)->order('idt asc,adt asc')->select();

        $title = "服务中心表 导出时间:" . date("Y-m-d   H:i:s");

        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="9"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>序号</td>";
        echo "<td>会员编号</td>";
        echo "<td>姓名</td>";
        echo "<td>联系电话</td>";
        echo "<td>申请时间</td>";
        echo "<td>确认时间</td>";
        echo "<td>类型</td>";
        echo "<td>服务中心区域</td>";
        echo "<td>剩余注册币</td>";
        echo '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach ($list as $row) {
            $i++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            } else {
                $num = $i;
            }
            if ($row['shoplx'] == 1) {
                $MMM = '服务中心';
            } elseif ($row['shoplx'] == 2) {
                $MMM = '县/区代理商';
            } else {
                $MMM = '市级代理商';
            }


            echo '<tr align=center>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>" . $row['user_tel'] . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['idt']) . "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['adt']) . "</td>";
            echo "<td>" . $MMM . "</td>";
            echo "<td>" . $row['shop_a'] . " / " . $row['shop_b'] . "</td>";
            echo "<td>" . $row['agent_cash'] . "</td>";
            echo '</tr>';
        }
        echo '</table>';
    }


    public function financeDaoChu()
    {
        //导出excel
//        if ($_SESSION['UrlPTPass'] =='MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
        $title = "数据库名:test,   数据表:test,   备份日期:" . date("Y-m-d   H:i:s");
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=test.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>姓名</td>";
        echo "<td>身份证号</td>";
        echo "<td>手机号</td>";
        echo "<td>收款银行</td>";
        echo "<td>收款账号开户行</td>";
        echo "<td>收款账号省份</td>";
        echo "<td>收款账号城市</td>";
        echo "<td>收款账号</td>";
        echo "<td>购物积分</td>";
        echo '</tr>';
        //   输出内容
        $did = (int)$_GET['did'];
        $bonus = M('bonus');
        $map = 'zyrj_bonus.b0>0 and zyrj_bonus.did=' . $did;
        //查询字段
        $field = 'zyrj_bonus.id,zyrj_bonus.uid,zyrj_bonus.did,s_date,e_date,zyrj_bonus.b0,zyrj_bonus.b1,zyrj_bonus.b2,zyrj_bonus.b3';
        $field .= ',zyrj_bonus.b4,zyrj_bonus.b5,zyrj_bonus.b6,zyrj_bonus.b7,zyrj_bonus.b8,zyrj_bonus.b9,zyrj_bonus.b10';
        $field .= ',zyrj_fck.user_id,zyrj_fck.user_tel,zyrj_fck.bank_card';
        $field .= ',zyrj_fck.user_name,zyrj_fck.user_address,zyrj_fck.nickname,zyrj_fck.user_phone,zyrj_fck.bank_province,zyrj_fck.user_tel';
        $field .= ',zyrj_fck.user_code,zyrj_fck.bank_city,zyrj_fck.bank_name,zyrj_fck.bank_address';
        import("@.ORG.ZQPage");  //导入分页类
        $count = $bonus->where($map)->count();//总页数
        $listrows = 1000000;//每页显示的记录数
        $page_where = '';//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page', $show);//分页变量输出到模板
        $join = 'left join zyrj_fck ON zyrj_bonus.uid=zyrj_fck.id';//连表查询
        $list = $bonus->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage() . ',' . $listrows)->select();
        $i = 0;

        foreach ($list as $row) {
            $i++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            }
            echo '<tr align=center>';

            echo '<td>' . $row['user_name'] . '</td>';
            echo '<td>' . $row['user_code'] . '</td>';
            echo '<td>' . $row['user_tel'] . '</td>';
            echo "<td>" . $row['bank_name'] . "</td>";
            echo "<td>" . $row['bank_address'] . "</td>";
            echo '<td>' . $row['bank_province'] . '</td>';
            echo '<td>' . $row['bank_city'] . '</td>';
            echo '<td>' . sprintf('%s', (string)chr(28) . $row['bank_card'] . chr(28)) . '</td>';
            echo '<td>' . $row['b0'] . '</td>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo '</tr>';
        }
        echo '</table>';
//        }else{
//            $this->error(xstr('error_signed'));
//            exit;
//        }
    }


    public function financeDaoChuTwo1()
    {
        //导出WPS
        if ($_SESSION['UrlPTPass'] == 'MyssGuanPaoYingTao' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao') {
            $title = "数据库名:test,   数据表:test,   备份日期:" . date("Y-m-d   H:i:s");
            header("Content-Type:   application/vnd.ms-excel");
            header("Content-Disposition:   attachment;   filename=test.xls");
            header("Pragma:   no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires:   0");
            echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
            //   输出标题
            echo '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">' . $title . '</td></tr>';
            //   输出字段名
            echo '<tr  align=center>';
            echo "<td>会员编号</td>";
            echo "<td>开会名</td>";
            echo "<td>开户银行</td>";
            echo "<td>银行会员</td>";
            echo "<td>提现金额</td>";
            echo "<td>提现时间</td>";
            echo "<td>所有人的排序</td>";
            echo '</tr>';
            //   输出内容
            $did = (int)$_GET['did'];
            $bonus = M('bonus');
            $map = 'zyrj_bonus.b0>0 and zyrj_bonus.did=' . $did;
            //查询字段
            $field = 'zyrj_bonus.id,zyrj_bonus.uid,zyrj_bonus.did,s_date,e_date,zyrj_bonus.b0,zyrj_bonus.b1,zyrj_bonus.b2,zyrj_bonus.b3';
            $field .= ',zyrj_bonus.b4,zyrj_bonus.b5,zyrj_bonus.b6,zyrj_bonus.b7,zyrj_bonus.b8,zyrj_bonus.b9,zyrj_bonus.b10';
            $field .= ',zyrj_fck.user_id,zyrj_fck.user_tel,zyrj_fck.bank_card';
            $field .= ',zyrj_fck.user_name,zyrj_fck.user_address,zyrj_fck.nickname,zyrj_fck.user_phone,zyrj_fck.bank_province,zyrj_fck.user_tel';
            $field .= ',zyrj_fck.user_code,zyrj_fck.bank_city,zyrj_fck.bank_name,zyrj_fck.bank_address';

            import("@.ORG.ZQPage");  //导入分页类
            $count = $bonus->where($map)->count();//总页数
            $listrows = 1000000;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $join = 'left join zyrj_fck ON zyrj_bonus.uid=zyrj_fck.id';//连表查询
            $list = $bonus->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage() . ',' . $listrows)->select();
            $i = 0;
            foreach ($list as $row) {
                $i++;
                $num = strlen($i);
                if ($num == 1) {
                    $num = '000' . $i;
                } elseif ($num == 2) {
                    $num = '00' . $i;
                } elseif ($num == 3) {
                    $num = '0' . $i;
                }
                $date = date('Y-m-d H:i:s', $row['rdt']);

                echo '<tr align=center>';
                echo "<td>'" . $row['user_id'] . '</td>';
                echo '<td>' . $row['user_name'] . '</td>';
                echo "<td>" . $row['bank_name'] . "</td>";
                echo '<td>' . $row['bank_card'] . '</td>';
                echo '<td>' . $row['money'] . '</td>';
                echo '<td>' . $date . '</td>';
                echo "<td>'" . $num . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

//会员表
    public function financeDaoChu_DingDan()
    {
        ini_set("memory_limit", "516M");
        //导出excel
        set_time_limit(0);

        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Member.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");


        $cash = M('cash');  //奖金表

        $map = array();
        $map['id'] = array('gt', 0);
        $map['type'] = 0;
        $map['is_cancel'] = 0;
        $field = '*';
        $list = $cash->where($map)->field($field)->order('pdt asc')->select();

        $title = "订单表 导出时间:" . date("Y-m-d   H:i:s");

        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>序号</td>";
        echo "<td>订单编号</td>";
        echo "<td>日期</td>";
        echo "<td>会员编号</td>";
        echo "<td>匹配日期</td>";
        echo "<td>挂单金额</td>";
        echo "<td>状态</td>";
        echo "<td>订单类型</td>";
        echo '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach ($list as $row) {
            $i++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            } else {
                $num = $i;
            }
            if ($row['type'] == 0) {
                $userid = $row['b_user_id'];
                $type = "买进";
            } else {
                $userid = $row['s_user_id'];
                $type = "卖出";
            }

            //判断账号是否有效
            if (D('Fck')->userIsLockByWhere("user_id = '" . $userid . "'")) {
                continue;
            }

            if ($row['is_pay'] == 0) {
                $stats = "等待匹配";
            } else {
                $stats = "已成功匹配";
            }
            echo '<tr align=center>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo "<td>" . $row['x1'] . "</td>";
            // echo   "<td>"   .   $row['user_name'].  "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['rdt']) . "</td>";
            echo "<td>" . $userid . "</td>";
            if ($row['pdt']) {
                echo "<td>" . date("Y-m-d H:i:s", $row['pdt']) . "</td>";
            } else {
                echo "<td>-</td>";
            }
            echo "<td>" . $row['money'] . "&nbsp;</td>";
            echo "<td>" . $stats . "</td>";
            echo "<td>" . $type . "</td>";

            echo '</tr>';
            unset($row);
        }
        echo '</table>';
    }


    public function financeDaoChu_DingDan_out()
    {
        ini_set("memory_limit", "516M");
        //导出excel
        set_time_limit(0);

        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=Member.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");


        $cash = M('cash');  //奖金表

        $map = array();
        $map['id'] = array('gt', 0);
        $map['type'] = 1;
        $map['is_cancel'] = 0;
        $field = '*';
        $list = $cash->where($map)->field($field)->order('pdt asc')->select();

        $title = "订单表 导出时间:" . date("Y-m-d   H:i:s");

        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="10"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>序号</td>";
        echo "<td>订单编号</td>";
        echo "<td>日期</td>";
        echo "<td>会员编号</td>";
        echo "<td>匹配日期</td>";
        echo "<td>挂单金额</td>";
        echo "<td>状态</td>";
        echo "<td>订单类型</td>";
        echo '</tr>';
        //   输出内容

//		dump($list);exit;

        $i = 0;
        foreach ($list as $row) {
            $i++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            } else {
                $num = $i;
            }
            if ($row['type'] == 0) {
                $userid = $row['b_user_id'];
                $type = "买进";
            } else {
                $userid = $row['s_user_id'];
                $type = "卖出";
            }

            //判断账号是否有效
            if (D('Fck')->userIsLockByWhere("user_id = '" . $userid . "'")) {
                continue;
            }

            if ($row['is_pay'] == 0) {
                $stats = "等待匹配";
            } else {
                $stats = "已成功匹配";
            }
            echo '<tr align=center>';
            echo '<td>' . chr(28) . $num . '</td>';
            echo "<td>" . $row['x1'] . "</td>";
            // echo   "<td>"   .   $row['user_name'].  "</td>";
            echo "<td>" . date("Y-m-d H:i:s", $row['rdt']) . "</td>";
            echo "<td>" . $userid . "</td>";
            if ($row['pdt']) {
                echo "<td>" . date("Y-m-d H:i:s", $row['pdt']) . "</td>";
            } else {
                echo "<td>-</td>";
            }
            echo "<td>" . $row['money'] . "&nbsp;</td>";
            echo "<td>" . $stats . "</td>";
            echo "<td>" . $type . "</td>";

            echo '</tr>';
            unset($row);
        }
        echo '</table>';
    }


    public function financeDaoChuTwo()
    {
        //导出WPS
//        if ($_SESSION['UrlPTPass'] =='MyssGuanPaoYingTao' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao'){
        $title = "数据库名:test,   数据表:test,   备份日期:" . date("Y-m-d   H:i:s");
        header("Content-Type:   application/vnd.ms-excel");
        header("Content-Disposition:   attachment;   filename=test.xls");
        header("Pragma:   no-cache");
        header("Content-Type:text/html; charset=utf-8");
        header("Expires:   0");
        echo '<table   border="1"   cellspacing="2"   cellpadding="2"   width="50%"   align="center">';
        //   输出标题
        echo '<tr   bgcolor="#cccccc"><td   colspan="3"   align="center">' . $title . '</td></tr>';
        //   输出字段名
        echo '<tr  align=center>';
        echo "<td>银行卡号</td>";
        echo "<td>姓名</td>";
        echo "<td>银行名称</td>";
        echo "<td>省份</td>";
        echo "<td>城市</td>";
        echo "<td>金额</td>";
        echo "<td>所有人的排序</td>";
        echo '</tr>';
        //   输出内容
        $did = (int)$_GET['did'];
        $bonus = M('bonus');
        $map = 'zyrj_bonus.b0>0 and zyrj_bonus.did=' . $did;
        //查询字段
        $field = 'zyrj_bonus.id,zyrj_bonus.uid,zyrj_bonus.did,s_date,e_date,zyrj_bonus.b0,zyrj_bonus.b1,zyrj_bonus.b2,zyrj_bonus.b3';
        $field .= ',zyrj_bonus.b4,zyrj_bonus.b5,zyrj_bonus.b6,zyrj_bonus.b7,zyrj_bonus.b8,zyrj_bonus.b9,zyrj_bonus.b10';
        $field .= ',zyrj_fck.user_id,zyrj_fck.user_tel,zyrj_fck.bank_card';
        $field .= ',zyrj_fck.user_name,zyrj_fck.user_address,zyrj_fck.nickname,zyrj_fck.user_phone,zyrj_fck.bank_province,zyrj_fck.user_tel';
        $field .= ',zyrj_fck.user_code,zyrj_fck.bank_city,zyrj_fck.bank_name,zyrj_fck.bank_address';
        import("@.ORG.ZQPage");  //导入分页类
        $count = $bonus->where($map)->count();//总页数
        $listrows = 1000000;//每页显示的记录数
        $page_where = '';//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page', $show);//分页变量输出到模板
        $join = 'left join zyrj_fck ON zyrj_bonus.uid=zyrj_fck.id';//连表查询
        $list = $bonus->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage() . ',' . $listrows)->select();
        $i = 0;
        foreach ($list as $row) {
            $i++;
            $num = strlen($i);
            if ($num == 1) {
                $num = '000' . $i;
            } elseif ($num == 2) {
                $num = '00' . $i;
            } elseif ($num == 3) {
                $num = '0' . $i;
            }
            echo '<tr align=center>';
            echo "<td>'" . sprintf('%s', (string)chr(28) . $row['bank_card'] . chr(28)) . '</td>';
            echo '<td>' . $row['user_name'] . '</td>';
            echo "<td>" . $row['bank_name'] . "</td>";
            echo '<td>' . $row['bank_province'] . '</td>';
            echo '<td>' . $row['bank_city'] . '</td>';
            echo '<td>' . $row['b0'] . '</td>';
            echo "<td>'" . $num . '</td>';
            echo '</tr>';
        }
        echo '</table>';
//        }else{
//            $this->error(xstr('error_signed'));
//            exit;
//        }
    }

    public function financeDaoChuTXT()
    {
        //导出TXT
        if ($_SESSION['UrlPTPass'] == 'MyssPiPa' || $_SESSION['UrlPTPass'] == 'MyssMiHouTao') {
            //   输出内容
            $did = (int)$_GET['did'];
            $bonus = M('bonus');
            $map = 'zyrj_bonus.b0>0 and zyrj_bonus.did=' . $did;
            //查询字段
            $field = 'zyrj_bonus.id,zyrj_bonus.uid,zyrj_bonus.did,s_date,e_date,zyrj_bonus.b0,zyrj_bonus.b1,zyrj_bonus.b2,zyrj_bonus.b3';
            $field .= ',zyrj_bonus.b4,zyrj_bonus.b5,zyrj_bonus.b6,zyrj_bonus.b7,zyrj_bonus.b8,zyrj_bonus.b9,zyrj_bonus.b10';
            $field .= ',zyrj_fck.user_id,zyrj_fck.user_tel,zyrj_fck.bank_card';
            $field .= ',zyrj_fck.user_name,zyrj_fck.user_address,zyrj_fck.nickname,zyrj_fck.user_phone,zyrj_fck.bank_province,zyrj_fck.user_tel';
            $field .= ',zyrj_fck.user_code,zyrj_fck.bank_city,zyrj_fck.bank_name,zyrj_fck.bank_address';
            import("@.ORG.ZQPage");  //导入分页类
            $count = $bonus->where($map)->count();//总页数
            $listrows = 1000000;//每页显示的记录数
            $page_where = '';//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $join = 'left join zyrj_fck ON zyrj_bonus.uid=zyrj_fck.id';//连表查询
            $list = $bonus->where($map)->field($field)->join($join)->Distinct(true)->order('id asc')->page($Page->getPage() . ',' . $listrows)->select();
            $i = 0;
            $ko = "";
            $m_ko = 0;
            foreach ($list as $row) {
                $i++;
                $num = strlen($i);
                if ($num == 1) {
                    $num = '000' . $i;
                } elseif ($num == 2) {
                    $num = '00' . $i;
                } elseif ($num == 3) {
                    $num = '0' . $i;
                }
                $ko .= $row['bank_card'] . "|" . $row['user_name'] . "|" . $row['bank_name'] . "|" . $row['bank_province'] . "|" . $row['bank_city'] . "|" . $row['b0'] . "|" . $num . "\r\n";
                $m_ko += $row['b0'];
                $e_da = $row['e_date'];
            }
            $m_ko = $this->_2Mal($m_ko, 2);
            $content = $num . "|" . $m_ko . "\r\n" . $ko;

            header('Content-Type: text/x-delimtext;');
            header("Content-Disposition: attachment; filename=zyrj_" . date('Y-m-d H:i:s', $e_da) . ".txt");
            header("Pragma: no-cache");
            header("Content-Type:text/html; charset=utf-8");
            header("Expires: 0");
            echo $content;
            exit;

        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    //参数设置
    public function setParameter()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $fee = M('fee');
            $fee_rs = $fee->find();
            $fee_s1 = $fee_rs['s1'];
            $fee_s2 = $fee_rs['s2'];
            $fee_s3 = $fee_rs['s3'];
            $fee_s4 = $fee_rs['s4'];
            $fee_s5 = $fee_rs['s5'];
            $fee_s6 = $fee_rs['s6'];
            $fee_s7 = $fee_rs['s7'];
            $fee_s8 = $fee_rs['s8'];
            $fee_s9 = $fee_rs['s9'];
            $fee_s10 = $fee_rs['s10'];
            $fee_s11 = $fee_rs['s11'];
            $fee_s12 = $fee_rs['s12'];
            $fee_s13 = $fee_rs['s13'];
            $fee_s14 = $fee_rs['s14'];
            $fee_s15 = $fee_rs['s15'];
            $fee_s16 = $fee_rs['s16'];
            $fee_s17 = $fee_rs['s17'];
            $fee_s18 = $fee_rs['s18'];


            $fee_i21 = $fee_rs['i21'];
            $fee_i22 = $fee_rs['i22'];
            $fee_i23 = $fee_rs['i23'];
            $fee_i24 = $fee_rs['i24'];
            $fee_i25 = $fee_rs['i25'];
            $fee_i26 = $fee_rs['i26'];
            $fee_i27 = $fee_rs['i27'];
            $fee_i28 = $fee_rs['i28'];
            $fee_i29 = $fee_rs['i29'];
            $fee_i30 = $fee_rs['i30'];
            $fee_i31 = $fee_rs['i31'];
            $fee_i32 = $fee_rs['i32'];
            $fee_i33 = $fee_rs['i33'];
            $fee_i34 = $fee_rs['i34'];
            $fee_i35 = $fee_rs['i35'];
            $fee_i36 = $fee_rs['i36'];
            $fee_i37 = $fee_rs['i37'];
            $fee_i38 = $fee_rs['i38'];

            $fee_i39 = $fee_rs['i39'];
            $fee_i40 = $fee_rs['i40'];
            $fee_i41 = $fee_rs['i41'];
            $fee_i42 = $fee_rs['i42'];
            $fee_i43 = $fee_rs['i43'];
            $fee_i44 = $fee_rs['i44'];
            $fee_i45 = $fee_rs['i45'];
            $fee_i46 = $fee_rs['i46'];
            $fee_i47 = $fee_rs['i47'];
            $fee_i48 = $fee_rs['i48'];
            $fee_i49 = $fee_rs['i49'];
            $fee_i50 = $fee_rs['i50'];
            $fee_i51 = $fee_rs['i51'];
            $fee_i52 = $fee_rs['52'];
            $fee_i53 = $fee_rs['i53'];
            $fee_i54 = $fee_rs['i54'];
            $fee_i55 = $fee_rs['i55'];
            $fee_i56 = $fee_rs['i56'];


            $fee_str2 = $fee_rs['str2'];
            $fee_str3 = $fee_rs['str3'];
            $fee_str4 = $fee_rs['str4'];
            $fee_str5 = $fee_rs['str5'];
            $fee_str6 = $fee_rs['str6'];
            $fee_str7 = $fee_rs['str7'];
            $fee_str8 = $fee_rs['str8'];
            $fee_str9 = $fee_rs['str9'];

            $fee_str10 = $fee_rs['str10'];
            $fee_str11 = $fee_rs['str11'];
            $fee_str12 = $fee_rs['str12'];

            $fee_str14 = $fee_rs['str14'];
            $fee_str15 = $fee_rs['str15'];
            $fee_str16 = $fee_rs['str16'];
            $fee_str17 = $fee_rs['str17'];
            $fee_str18 = $fee_rs['str18'];

            $fee_str21 = $fee_rs['str21'];
            $fee_str22 = $fee_rs['str22'];
            $fee_str23 = $fee_rs['str23'];

            $fee_str24 = $fee_rs['str24'];
            $fee_str25 = $fee_rs['str25'];
            $fee_str26 = $fee_rs['str26'];

            $fee_str27 = $fee_rs['str27'];
            $fee_str28 = $fee_rs['str28'];
            $fee_str29 = $fee_rs['str29'];
            $fee_str37 = $fee_rs['str37'];


            $fee_str45 = $fee_rs['str45'];
            $fee_str46 = $fee_rs['str46'];
            $fee_str47 = $fee_rs['str47'];
            $fee_str48 = $fee_rs['str48'];
            $fee_str49 = $fee_rs['str49'];
            $fee_str50 = $fee_rs['str50'];
            $fee_str51 = $fee_rs['str51'];
            $fee_str52 = $fee_rs['str52'];


            $fee_str99 = $fee_rs['str99'];

            $a_money = $fee_rs['a_money'];
            $b_money = $fee_rs['b_money'];

            $fee_bobo_h4 = $fee_rs['bobo_h4'];
            $fee_bobo_h5 = $fee_rs['bobo_h5'];
            $fee_bobo_h6 = $fee_rs['bobo_h6'];
            $fee_bobo_buylimit = $fee_rs['bobo_buylimit'];


//			$fee_s20 = explode('|',$fee_rs['s20']);
            $this->assign('fee_s1', $fee_s1);
            $this->assign('fee_s2', $fee_s2);
            $this->assign('fee_s3', $fee_s3);
            $this->assign('fee_s4', $fee_s4);
            $this->assign('fee_s5', $fee_s5);
            $this->assign('fee_s6', $fee_s6);
            $this->assign('fee_s7', $fee_s7);
            $this->assign('fee_s8', $fee_s8);
            $this->assign('fee_s9', $fee_s9);
            $this->assign('fee_s10', $fee_s10);
            $this->assign('fee_s11', $fee_s11);
            $this->assign('fee_s12', $fee_s12);
            $this->assign('fee_s13', $fee_s13);
            $this->assign('fee_s14', $fee_s14);
            $this->assign('fee_s15', $fee_s15);
            $this->assign('fee_s16', $fee_s16);
            $this->assign('fee_s17', $fee_s17);
            $this->assign('fee_s18', $fee_s18);
//			$this -> assign('fee_s20',$fee_s20);
            $this->assign('fee_i1', $fee_rs['i1']);
            $this->assign('fee_i2', $fee_rs['i2']);
            $this->assign('fee_i3', $fee_rs['i3']);
            $this->assign('fee_i4', $fee_rs['i4']);
            $this->assign('fee_i5', $fee_rs['i5']);


            $this->assign('fee_i21', $fee_rs['i21']);
            $this->assign('fee_i22', $fee_rs['i22']);
            $this->assign('fee_i23', $fee_rs['i23']);
            $this->assign('fee_i24', $fee_rs['i24']);
            $this->assign('fee_i25', $fee_rs['i25']);
            $this->assign('fee_i26', $fee_rs['i26']);
            $this->assign('fee_i27', $fee_rs['i27']);
            $this->assign('fee_i28', $fee_rs['i28']);
            $this->assign('fee_i29', $fee_rs['i29']);
            $this->assign('fee_i30', $fee_rs['i30']);

            $this->assign('fee_i31', $fee_rs['i31']);
            $this->assign('fee_i32', $fee_rs['i32']);
            $this->assign('fee_i33', $fee_rs['i33']);
            $this->assign('fee_i34', $fee_rs['i34']);
            $this->assign('fee_i35', $fee_rs['i35']);
            $this->assign('fee_i36', $fee_rs['i36']);
            $this->assign('fee_i37', $fee_rs['i37']);
            $this->assign('fee_i38', $fee_rs['i38']);
            $this->assign('fee_i39', $fee_rs['i39']);
            $this->assign('fee_i40', $fee_rs['i40']);

            $this->assign('fee_i41', $fee_rs['i41']);
            $this->assign('fee_i42', $fee_rs['i42']);
            $this->assign('fee_i43', $fee_rs['i43']);
            $this->assign('fee_i44', $fee_rs['i44']);
            $this->assign('fee_i45', $fee_rs['i45']);
            $this->assign('fee_i46', $fee_rs['i46']);
            $this->assign('fee_i47', $fee_rs['i47']);
            $this->assign('fee_i48', $fee_rs['i48']);
            $this->assign('fee_i49', $fee_rs['i49']);
            $this->assign('fee_i50', $fee_rs['i50']);


            $this->assign('fee_i11', intval($fee_rs['i11']));
            $this->assign('fee_id', $fee_rs['id']);  //记录ID

            $this->assign('b_money', $fee_rs['b_money']);

            $this->assign('fee_str2', $fee_str2);
            $this->assign('fee_str3', $fee_str3);
            $this->assign('fee_str4', $fee_str4);
            $this->assign('fee_str5', $fee_str5);
            $this->assign('fee_str6', $fee_str6);
            $this->assign('fee_str7', $fee_str7);
            $this->assign('fee_str8', $fee_str8);
            $this->assign('fee_str9', $fee_str9);

            $this->assign('fee_str10', $fee_str10);
            $this->assign('fee_str11', $fee_str11);
            $this->assign('fee_str12', $fee_str12);

            $this->assign('fee_str14', $fee_str14);
            $this->assign('fee_str15', $fee_str15);
            $this->assign('fee_str16', $fee_str16);
            $this->assign('fee_str17', $fee_str17);
            $this->assign('fee_str18', $fee_str18);

            $this->assign('fee_str21', $fee_str21);
            $this->assign('fee_str22', $fee_str22);
            $this->assign('fee_str23', $fee_str23);

            $this->assign('fee_str24', $fee_str24);
            $this->assign('fee_str25', $fee_str25);
            $this->assign('fee_str26', $fee_str26);

            $this->assign('fee_str27', $fee_str27);
            $this->assign('fee_str28', $fee_str28);
            $this->assign('fee_str29', $fee_str29);
            $this->assign('fee_str37', $fee_str37);

            $this->assign('fee_str45', $fee_str45);
            $this->assign('fee_str46', $fee_str46);
            $this->assign('fee_str47', $fee_str47);

            $this->assign('fee_str48', $fee_str48);
            $this->assign('fee_str49', $fee_str49);
            $this->assign('fee_str50', $fee_str50);
            $this->assign('fee_str51', $fee_str51);

            $this->assign('fee_str99', $fee_str99);

            $this->assign('a_money', $a_money);
            $this->assign('b_money', $b_money);

            $this->assign('feeArr', $fee_rs);

            $this->assign('fee_bobo_h4', $fee_rs['bobo_h4']);

            $this->assign('fee_bobo_h5', $fee_rs['bobo_h5']);
            $this->assign('fee_bobo_h6', $fee_rs['bobo_h6']);
            $this->assign('fee_bobo_buylimit', $fee_rs['bobo_buylimit']);
            $this->assign('fee_bobo_bdlimit', $fee_rs['bobo_bdlimit']);

            $v_title = $this->theme_title_value();
            $this->distheme('setParameter', $v_title[104]);
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    public function setParameterSave()
    {
        if ($_SESSION["loginUseracc"] != "800000" || (strlen($_SESSION[C('USER_NICKNAME')]) != 16)) {
            // 提示错误信息
            $this->error(L('_VALID_ACCESS_'));
        }
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $fee = M('fee');
            $fck = M('fck');
            $rs = $fee->find();

//			$s18 = (int) trim($_POST['s18']);
//			$i1  = (int) trim($_POST['i1']);
//			if(empty($s18) or empty($i1)){
//				$this->error('请输入完整的参数，否则系统不能正常运行!');
//				exit;
//			}
//
//			$arr = array(3,11,12,13,14,17,20);
//			foreach($arr as $i){
//				$i = 's'. $i;
//				$str  = $_POST[$i];
//				foreach($str as $s){
//					if($i != 's20'){  //s20为各网名称可以不为数字
//						$s = trim($s);
//					}
//					if(empty($s)){
//						$this->error('请输入完整的参数，否则系统不能正常运行 !');
//			}}}

            $i1 = $_POST['i1'];
            $i2 = $_POST['i2'];
            $i3 = $_POST['i3'];
            $i4 = $_POST['i4'];

            $i21 = $_POST['i21'];
            $i22 = $_POST['i22'];
            $i23 = $_POST['i23'];
            $i24 = $_POST['i24'];
            $i25 = $_POST['i25'];
            $i26 = $_POST['i26'];
            $i27 = $_POST['i27'];
            $i28 = $_POST['i28'];
            $i29 = $_POST['i29'];
            $i30 = $_POST['i30'];
            $i31 = $_POST['i31'];
            $i32 = $_POST['i32'];
            $i33 = $_POST['i33'];
            $i34 = $_POST['i34'];
            $i35 = $_POST['i35'];
            $i36 = $_POST['i36'];

            $i37 = $_POST['i37'];
            $i38 = $_POST['i38'];
            $i39 = $_POST['i39'];
            $i40 = $_POST['i40'];
            $i41 = $_POST['i41'];
            $i42 = $_POST['i42'];
            $i43 = $_POST['i43'];
            $i44 = $_POST['i44'];
            $i45 = $_POST['i45'];
            $i46 = $_POST['i46'];
            $i47 = $_POST['i47'];
            $i48 = $_POST['i48'];
            $i49 = $_POST['i49'];
            $i50 = $_POST['i50'];
            $i51 = $_POST['i51'];
            $i52 = $_POST['i52'];
            $i53 = $_POST['i53'];
            $i54 = $_POST['i54'];
            $i55 = $_POST['i55'];
            $i56 = $_POST['i56'];
            $i57 = $_POST['i57'];
            $i58 = $_POST['i58'];
            $i59 = $_POST['i59'];


            $a_money = $_POST['a_money'];
            $b_money = $_POST['b_money'];
//			$s2  = $_POST['s2'];
//			$s3  = $_POST['s3'];
//			$s4  = $_POST['s4'];
            $s5 = $_POST['s5'];
//			$s6  = $_POST['s6'];
//			$s8  = $_POST['s8'];
//			$s9  = $_POST['s9'];
//			$s10 = $_POST['s10'];
//			$s11 = $_POST['s11'];
//			$s12 = $_POST['s12'];
//			$s13 = $_POST['s13'];
//			$s14 = $_POST['s14'];
//			$s15 = $_POST['s15'];
//			$s16 = $_POST['s16'];
//			$s17 = $_POST['s17'];
//			$s18 = $_POST['s18'];
//			$s20 = $_POST['s20'];
//

            $bobo_h4 = $_POST['bobo_h4'];
            $bobo_h5 = $_POST['bobo_h5'];
            $bobo_h6 = $_POST['bobo_h6'];
            $bobo_buylimit = $_POST['bobo_buylimit'];
            $bobo_bdlimit = $_POST['bobo_bdlimit'];


            $where = array();
            $where['id'] = 1;
            $data = array();

            //波波专业互助开发QQ369757055
            $data['bobo_h4'] = trim($bobo_h4);
            $data['bobo_h5'] = trim($bobo_h5);
            $data['bobo_h6'] = trim($bobo_h6);
            $data['bobo_buylimit'] = trim($bobo_buylimit);
            $data['bobo_bdlimit'] = trim($bobo_bdlimit);


            if (empty($a_money) == false || strlen($a_money) > 0) {
                $data['a_money'] = trim($a_money);
            }
            if (empty($b_money) == false || strlen($b_money) > 0) {
                $data['b_money'] = trim($b_money);

            }

            $data['i21'] = trim($i21);
            $data['i22'] = trim($i22);
            $data['i23'] = trim($i23);
            $data['i24'] = trim($i24);
            $data['i25'] = trim($i25);
            $data['i26'] = trim($i26);
            $data['i27'] = trim($i27);
            $data['i28'] = trim($i28);
            $data['i29'] = trim($i29);
            $data['i30'] = trim($i30);
            $data['i31'] = trim($i31);
            $data['i32'] = trim($i32);
            $data['i33'] = trim($i33);
            $data['i34'] = trim($i34);
            $data['i35'] = trim($i35);
            $data['i36'] = trim($i36);
            $data['i37'] = trim($i37);
            $data['i38'] = trim($i38);
            $data['i39'] = trim($i39);
            $data['i40'] = trim($i40);
            $data['i41'] = trim($i41);
            $data['i42'] = trim($i42);
            $data['i43'] = trim($i43);
            $data['i44'] = trim($i44);
            $data['i45'] = trim($i45);
            $data['i46'] = trim($i46);
            $data['i47'] = trim($i47);
            $data['i48'] = trim($i48);
            $data['i49'] = trim($i49);
            $data['i50'] = trim($i50);
            $data['i51'] = trim($i51);
            $data['i52'] = trim($i52);
            $data['i53'] = trim($i53);


            //$data['s3']  = trim($s3[0]) .'|'. trim($s3[1]) .'|'. trim($s3[2]) .'|'. trim($s3[3]) .'|'. trim($s3[4]) .'|'. trim($s3[5]);
            //$data['s5']  = trim($s5[0]) .'|'. trim($s5[1]) .'|'. trim($s5[2]) ;
//			$data['s2']  =  trim($s2);
//			$data['s3']  =  trim($s3);
//			$data['s4']  =  trim($s4);
//			$data['s5']  =  trim($s5);
//			$data['s6']  =  trim($s6);
//			$data['s8']  =  trim($s8);
//			$data['s9']  =  trim($s9);
//			$data['s10']  =  trim($s10);
//			$data['s11']  =  trim($s11);
//			$data['s12']  =  trim($s12);
//			$data['s13']  =  trim($s13);
//			$data['s14']  =  trim($s14);
//			$data['s15']  =  trim($s15);
//			$data['s16']  =  trim($s16);
//			$data['s17']  =  trim($s17);
            //$data['s10'] = trim($s10[0]) .'|'. trim($s10[0]);
            //$data['s11'] = trim($s11[0]) .'|'. trim($s11[1]) .'|'. trim($s11[2]) .'|'. trim($s11[3]) .'|'. trim($s11[4]) .'|'. trim($s11[5]);
            //$data['s12'] = trim($s12[0]) .'|'. trim($s12[1]) .'|'. trim($s12[2]) .'|'. trim($s12[3]) .'|'. trim($s12[4]) .'|'. trim($s12[5]);
            //$data['s13'] = trim($s13[0]) .'|'. trim($s13[1]) .'|'. trim($s13[2]);
            //$data['s14'] = trim($s14[0]) .'|'. trim($s14[1]) .'|'. trim($s14[2]) .'|'. trim($s14[3]) .'|'. trim($s14[3]) .'|'. trim($s14[3]) .'|'. trim($s14[3]) .'|'. trim($s14[3]) .'|'. trim($s14[3]) .'|'. trim($s14[3]) .'|'. trim($s14[3]);
            //$data['s15'] = trim($s15[0]) .'|'. trim($s15[0]);
            //$data['s16'] = trim($s16[0]) .'|'. trim($s16[0]);
            //$data['s17'] = trim($s17[0]) .'|'. trim($s17[1]);
            //$data['s18'] = '0000|0000|'. trim($s18);
            //$data['s20']  = trim($s20[0]) .'|'. trim($s20[1]) .'|'. trim($s20[2]) .'|'. trim($s20[3]) .'|'. trim($s20[4]) .'|'. trim($s20[5]);

            for ($j = 1; $j <= 10; $j++) {
                $arr_rs[$j] = $_POST['i' . $j];
            }
            $i11 = 0;
            for ($ix = 0; $ix < 31; $ix++) {
                if (array_key_exists('i11_' . ($ix + 1), $_POST)) {
                    $curBit = 0x1 << $ix;
                    $i11 |= $curBit;
                }
            }

            $s_sql2 = "";
            for ($j = 1; $j <= 10; $j++) {
                if ($arr_rs[$j] != '') {
                    if (empty($s_sql2)) {
                        $s_sql2 = 'i' . $j . "='{$arr_rs[$j]}'";
                    } else {
                        $s_sql2 .= ',i' . $j . "='{$arr_rs[$j]}'";
                    }
                }
            }
            $s_sql2 .= ',i11=' . $i11;


            for ($i = 1; $i <= 35; $i++) {
                $arr_s[$i] = $_POST['s' . $i];
            }

            $s_sql = "";
            for ($i = 1; $i <= 35; $i++) {
                if (empty($arr_s[$i]) == false || strlen($arr_s[$i]) > 0) {
                    if (empty($s_sql2)) {
                        $s_sql = 's' . $i . "='{$arr_s[$i]}'";
                    } else {
                        $s_sql .= ',s' . $i . "='{$arr_s[$i]}'";
                    }

                }
            }


            for ($i = 1; $i <= 90; $i++) {
                $arr_sts[$i] = $_POST['str' . $i];
            }
            $str_sql = "";
            for ($i = 1; $i <= 90; $i++) {
                if (strlen(trim($arr_sts[$i])) > 0) {
                    if (empty($s_sql2) && empty($s_sql)) {
                        $str_sql = 'str' . $i . "='{$arr_sts[$i]}'";
                    } else {
                        $str_sql .= ',str' . $i . "='{$arr_sts[$i]}'";
                    }
                }
            }

            $str99 = trim($_POST['str99']);
            $ttst_sql = ',str99="' . $str99 . '"';

            //c036添加，如果设置了会员设置前台最高充值手续费比率，那把所有高于这个比率的会员值都设置为这个值
            $newValue = floatval($_POST['s11']);
            M('Fck')->execute('UPDATE __TABLE__ SET rech_ratio=' . $newValue . ' WHERE 	rech_ratio>' . $newValue);

            $fee->execute("update __TABLE__ SET " . $s_sql2 . $s_sql . $str_sql . $ttst_sql . "  where `id`=1");
            $fee->where($where)->data($data)->save();
            $this->success('参数设置！');
            exit;
        } else {
            $this->error(xstr('error_signed')); //12345678901112131417181920s3
            exit;
        }
    }

    //参数设置
    public function setParameter_B()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCPB') {
            $fee = M('fee');
            $fee_rs = $fee->find();

            $fee_str21 = $fee_rs['str21'];
            $fee_str22 = $fee_rs['str22'];
            $fee_str23 = $fee_rs['str23'];

            $this->assign('fee_str21', $fee_str21);
            $this->assign('fee_str22', $fee_str22);
            $this->assign('fee_str23', $fee_str23);

            $v_title = $this->theme_title_value();
            $this->distheme('setParameter_B', $v_title[106]);

        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    public function setParameterSave_B()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCPB') {
            $fee = M('fee');
            $fck = M('fck');
            $rs = $fee->find();

            $where = array();
            $where['id'] = (int)$_POST['id'];
            for ($i = 1; $i <= 40; $i++) {
                $arr_sts[$i] = $_POST['str' . $i];
            }
            $str_sql = "";
            for ($i = 1; $i <= 40; $i++) {
                if (strlen(trim($arr_sts[$i])) > 0) {
                    if (empty($str_sql)) {
                        $str_sql = 'str' . $i . "='{$arr_sts[$i]}'";
                    } else {
                        $str_sql .= ',str' . $i . "='{$arr_sts[$i]}'";
                    }
                }
            }


            $fee->execute("update __TABLE__ SET " . $str_sql . "  where `id`=1");
            $this->success('首页图片设置！');
            exit;
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    public function MenberBonus()
    {
        //列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $fck = M('fck');
            $UserID = trim($_REQUEST['UserID']);
            $ss_type = (int)$_REQUEST['type'];
            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['nickname'] = array('like', "%" . $UserID . "%");
                $where['user_id'] = array('like', "%" . $UserID . "%");
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            $map['is_pay'] = 1;
            //查询字段
            $field = 'id,user_id,nickname,bank_name,bank_card,user_name,user_address,user_tel,rdt,singular,cpzj,pdt,u_level,zjj,agent_use,is_lock,f3,b3';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fck->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&type=' . $ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc')->page($Page->getPage() . ',' . $listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ, 1);
            foreach ($list as $vo) {
                $voo[$vo['id']] = $HYJJ[$vo['u_level']];
            }
            $this->assign('voo', $voo);//会员级别
            $this->assign('list', $list);//数据输出到模板
            //=================================================


            $title = '会员管理';
            $this->assign('title', $title);
            $this->display('MenberBonus');
            return;
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function MenberBonusSave()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssPingGuoCP') {
            $fck = M('fck');
            $fee_rs = M('fee')->find();
            $fee_s7 = explode('|', $fee_rs['s7']);

            $date = strtotime($_POST['date']);
            $lz = (int)$_POST['lz'];
            $lzbz = $_POST['lzbz'];

            $userautoid = (int)$_POST['userautoid'];

            if ($lz <= 0) {
                $this->error('请录入正确的劳资金额!');
                exit;
            }

            $rs = $fck->field('user_id,id')->find($userautoid);
            if ($rs) {
                $fck->query("update __TABLE__ set b3=b3+$lz where id=" . $userautoid);
                $this->input_bonus_2($rs['user_id'], $rs['id'], $fee_s7[2], $lz, $lzbz, $date);  //写进明细

                $bUrl = __URL__ . '/MenberBonus';
                $this->_box(1, '劳资录入！', $bUrl, 1);
            } else {
                $this->error(xstr('data_error'));
                exit;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function delTable()
    {
        //清空数据库===========================
        $v_title = $this->theme_title_value();
        $this->distheme('delTable', $v_title[105]);
    }

    public function delTableExe()
    {
        $fck = M('fck');
        if (!$fck->autoCheckToken($_POST)) {
            $this->error(xstr('page_expire_please_reflush'));
            exit;
        }
        unset($fck);
        $this->_delTable();
        exit;
    }

    public function adminClearing()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS') {
            $cash = M('cash');
            $fee = M('fee');
            $fee_rs = $fee->field('s18,f_time,a_money,s12')->find();
            $s18 = explode("|", $fee_rs['s18']);
            $f_time = $fee_rs['f_time'];
            $this->assign('s18', $s18);
            $this->assign('f_time', $f_time);
            //$this->assign('a_money', $a_money);
            $UserID = $_POST['UserID'];
            $User = $_POST['User'];
            $nowtime = time();
            $this->assign('nowtime', $nowtime);

//yixi
            $y = date("y");
            $d = date("d");
            $m = date("m");
            $day_start = mktime(0, 0, 0, $m, $d, $y);
            $day_end = mktime(23, 59, 59, $m, $d, $y);
            $sumchu = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=1')->sum('money');
            $sumjin = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=0')->sum('money');
            $danchu = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=1')->count();
            $danjin = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=0')->count();
//$sumchu=0;
            $this->assign('chu', $sumchu);
            $this->assign('jin', $sumjin);
            $this->assign('danchu', $danchu);
            $this->assign('danjin', $danjin);
//
            $this->assign('s12', $fee_rs['s12']);
            $map = "type=0";
            $map1 = "type=1";

            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $map .= " and x1='" . $UserID . "'";
                $map1 .= " and x1='" . $UserID . "'";
                $UserID = urlencode($UserID);
            }
            if (!empty($User)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($User) == false) {
                    $User = iconv('GB2312', 'UTF-8', $User);
                }
                unset($KuoZhan);
                $map .= " and user_id='" . $User . "'";
                $map1 .= " and user_id='" . $User . "'";
                $User = urlencode($User);
            }
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            $postPage = $_POST['postPage'];
            import("@.ORG.ZQPage");  //导入分页类
            $count = $cash->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 5;//每页显示的记录数
            $page_where = $map;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            if (!empty($postPage)) {
                $Page->setPage($postPage);  //页数跳转
                $this->assign('postPage', $postPage);
            }

            $show = $Page->show();//分页变量

            $this->assign('bpage', $show);//分页变量输出到模板
            $buylist = $cash->where($map)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('buylist', $buylist);

            //求购信息
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            $SpostPage = $_POST['SpostPage'];
            import("@.ORG.ZQPage");  //导入分页类
            $count1 = $cash->where($map1)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 5;//每页显示的记录数
            $page_where1 = $map1;//分页条件
            $Page = new ZQPage($count1, $listrows, 1, 0, 3, $page_where1);
            if (!empty($SpostPage)) {
                $Page->setPage($SpostPage);  //页数跳转
                $this->assign('SpostPage', $SpostPage);
            }
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show2 = $Page->show();//分页变量
            $this->assign('spage', $show2);//分页变量输出到模板
            $selllist = $cash->where($map1)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('selllist', $selllist);

            $v_title = $this->theme_title_value();
            $this->distheme('adminClearing', "手动匹配");
        } else {
            $this->error(xstr('error_signed'));
        }
    }


    public function TsClearing()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS') {
            $cash = M('cash');
            $fee = M('fee');
            $fee_rs = $fee->field('s18,f_time,a_money,s12')->find();
            $s18 = explode("|", $fee_rs['s18']);
            $f_time = $fee_rs['f_time'];
            $this->assign('s18', $s18);
            $this->assign('f_time', $f_time);
            $this->assign('a_money', $a_money);
            $UserID = $_POST['UserID'];
            $User = $_POST['User'];
            $nowtime = time();
            $this->assign('nowtime', $nowtime);

//yixi
            $y = date("y");
            $d = date("d");
            $m = date("m");
            $day_start = mktime(0, 0, 0, $m, $d, $y);
            $day_end = mktime(23, 59, 59, $m, $d, $y);
            $sumchu = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=1')->sum('money');
            $sumjin = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=0')->sum('money');
            $danchu = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=1')->count();
            $danjin = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=0')->count();
//$sumchu=0;
            $this->assign('chu', $sumchu);
            $this->assign('jin', $sumjin);
            $this->assign('danchu', $danchu);
            $this->assign('danjin', $danjin);
//
            $this->assign('s12', $fee_rs['s12']);
            $map = "type=0";
            $map1 = "type=1";

            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $map .= " and x1='" . $UserID . "'";
                $map1 .= " and x1='" . $UserID . "'";
                $UserID = urlencode($UserID);
            }
            if (!empty($User)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($User) == false) {
                    $User = iconv('GB2312', 'UTF-8', $User);
                }
                unset($KuoZhan);
                $map .= " and is_ts=1 and user_id='" . $User . "'";
                $map1 .= " and is_ts=1 and user_id='" . $User . "'";
                $User = urlencode($User);
            }
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            $postPage = $_POST['postPage'];
            import("@.ORG.ZQPage");  //导入分页类
            $count = $cash->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 10;//每页显示的记录数
            $page_where = $map;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            if (!empty($postPage)) {
                $Page->setPage($postPage);  //页数跳转
                $this->assign('postPage', $postPage);
            }

            $show = $Page->show();//分页变量

            $this->assign('bpage', $show);//分页变量输出到模板
            $buylist = $cash->where($map)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('buylist', $buylist);

            //求购信息
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            $SpostPage = $_POST['SpostPage'];
            import("@.ORG.ZQPage");  //导入分页类
            $count1 = $cash->where($map1)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 10;//每页显示的记录数
            $page_where1 = $map1;//分页条件
            $Page = new ZQPage($count1, $listrows, 1, 0, 3, $page_where1);
            if (!empty($SpostPage)) {
                $Page->setPage($SpostPage);  //页数跳转
                $this->assign('SpostPage', $SpostPage);
            }
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show2 = $Page->show();//分页变量
            $this->assign('spage', $show2);//分页变量输出到模板
            $selllist = $cash->where($map1)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('selllist', $selllist);

            $v_title = $this->theme_title_value();
            $this->distheme('TsClearing', "投诉管理");
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    public function Qiangdan()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS') {
            $cash = M('cash');
            $fee = M('fee');
            $fee_rs = $fee->field('s18,f_time,a_money,s12')->find();
            $s18 = explode("|", $fee_rs['s18']);
            $f_time = $fee_rs['f_time'];
            $this->assign('s18', $s18);
            $this->assign('f_time', $f_time);
            $this->assign('a_money', $a_money);
            $UserID = $_POST['UserID'];
            $User = $_POST['User'];
            $nowtime = time();
            $this->assign('nowtime', $nowtime);

//yixi
            $y = date("y");
            $d = date("d");
            $m = date("m");
            $day_start = mktime(0, 0, 0, $m, $d, $y);
            $day_end = mktime(23, 59, 59, $m, $d, $y);
            $sumchu = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=1')->sum('money');
            $sumjin = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=0')->sum('money');
            $danchu = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=1')->count();
            $danjin = $cash->where('rdt>' . $day_start . ' and rdt<' . $day_end . ' and type=0')->count();
//$sumchu=0;
            $this->assign('chu', $sumchu);
            $this->assign('jin', $sumjin);
            $this->assign('danchu', $danchu);
            $this->assign('danjin', $danjin);
//
            $this->assign('s12', $fee_rs['s12']);
            $map = "type=0";
            $map1 = "type=1";

            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $map .= " and x1='" . $UserID . "'";
                $map1 .= " and x1='" . $UserID . "'";
                $UserID = urlencode($UserID);
            }
            if (!empty($User)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($User) == false) {
                    $User = iconv('GB2312', 'UTF-8', $User);
                }
                unset($KuoZhan);
                $map .= " and is_ts=1 and user_id='" . $User . "'";
                $map1 .= " and is_ts=1 and user_id='" . $User . "'";
                $User = urlencode($User);
            }
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            $postPage = $_POST['postPage'];
            import("@.ORG.ZQPage");  //导入分页类
            $count = $cash->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 10;//每页显示的记录数
            $page_where = $map;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            if (!empty($postPage)) {
                $Page->setPage($postPage);  //页数跳转
                $this->assign('postPage', $postPage);
            }

            $show = $Page->show();//分页变量

            $this->assign('bpage', $show);//分页变量输出到模板
            $buylist = $cash->where($map)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('buylist', $buylist);

            //求购信息
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            $SpostPage = $_POST['SpostPage'];
            import("@.ORG.ZQPage");  //导入分页类
            $count1 = $cash->where($map1)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 10;//每页显示的记录数
            $page_where1 = $map1;//分页条件
            $Page = new ZQPage($count1, $listrows, 1, 0, 3, $page_where1);
            if (!empty($SpostPage)) {
                $Page->setPage($SpostPage);  //页数跳转
                $this->assign('SpostPage', $SpostPage);
            }
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show2 = $Page->show();//分页变量
            $this->assign('spage', $show2);//分页变量输出到模板
            $selllist = $cash->where($map1)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('selllist', $selllist);

            $v_title = $this->theme_title_value();
            $this->distheme('Qiangdan', "抢单市场");
        } else {
            $this->error(xstr('error_signed'));
        }
    }


    public function adminClearingSave()
    {  //资金结算
        if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS') {
            set_time_limit(0);//是页面不过期
            $fck = D('Fck');
            $ydate = mktime();

            $a1 = (int)$_GET['a1'];
            $a2 = (int)$_GET['a2'];

            $fee = M('fee');
            $fee_rs = $fee->field('*')->find();

            // //分红奖
            // $fck->Bonus_b1_jfjl(1);

            $cash = A('Mavro');
            $cash->matchBuySell();

            sleep(1);
            $this->success('结算完成！');
//			$bUrl = __URL__.'/adminClearing';
//			$this->_box(1,'结算分红完成！',$bUrl,1);
            exit;
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    public function adminClearing2()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS') {
            $times = M('times');
            $trs = $times->where('type=0')->order('id desc')->find();
            if (!$trs) {
                $trs['benqi'] = strtotime('2010-01-01');
            }
            if ($trs['benqi'] == strtotime(date("Y-m-d"))) {
                $isPay = 1;
            } else {
                $isPay = 0;
            }
            $this->assign('is_pay', $isPay);
            $this->assign('trs', $trs);


            $fee = M('fee');
            $fee_rs = $fee->field('g_time,a_money')->find();
            $g_time = $fee_rs['g_time'];
            $this->assign('g_time', $g_time);
            $a_money = $fee_rs['a_money'];
            $this->assign('a_money', $a_money);

            $this->display();
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    public function adminClearingSave_b()
    {  //资金结算
        if ($_SESSION['UrlPTPass'] == 'MyssBaiGuoJS') {
            set_time_limit(0);//是页面不过期
            $times = M('times');
            $fck = D('Fck');
            $ydate = mktime();

            $a1 = $_GET['a1'];

            if ($a1 > 0) {
                //分红
                $fck->jq_fenhong($a1, 1);
            }

            sleep(1);
            $this->success('结算分红完成！');
            exit;
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    public function adminsingle($GPid = 0)
    {
        //============================================审核会员加单
        if ($_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            $jiadan = M('jiadan');
            $UserID = $_POST['UserID'];
            if (!empty($UserID)) {
                $map['user_id'] = array('like', "%" . $UserID . "%");
            }

            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $jiadan->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $jiadan->where($map)->field($field)->order('id desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('list', $list);//数据输出到模板
            //=================================================

            $this->display('adminsingle');
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminsingleAC()
    {
        //处理提交按钮
        $fck = M('fck');
        $action = $_POST['action'];
        //获取复选框的值
        $PTid = $_POST['tabledb'];
        if (!$fck->autoCheckToken($_POST)) {
            $this->error(xstr('page_expire_please_reflush'));
            exit;
        }
        if (!isset($PTid) || empty($PTid)) {
            $bUrl = __URL__ . '/adminsingle';
            $this->_box(0, xstr('please_select'), $bUrl, 1);
            exit;
        }
        unset($fck);
        switch ($action) {
            case xstr('confirm_2');
                $this->_adminsingleConfirm($PTid);
                break;
            case xstr('delete');
                $this->_adminsingleDel($PTid);
                break;
            default;
                $bUrl = __URL__ . '/adminsingle';
                $this->_box(0, '没有该注册！', $bUrl, 1);
                break;
        }
    }


    private function _adminsingleConfirm($PTid = 0)
    {
        //===============================================确认加单
        if ($_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            $fck = D('Fck');
            $jiadan = M('jiadan');
            $fee = M('fee');
            $fee_rs = $fee->find(1);
            $where = array();
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = 0;
            $field = '*';
            $vo = $jiadan->where($where)->field($field)->select();
            $fck_where = array();
            $nowdate = strtotime(date('c'));
            foreach ($vo as $voo) {
                $fck->xiangJiao($voo['uid'], $voo['danshu']);//统计单数
                $fck_where['id'] = $voo['uid'];
                $fck_rs = $fck->where($fck_where)->field('user_id,re_id,f5')->find();
                if ($fck_rs) {
                    //给推荐人添加推荐人数
                    $fck->query("update `zyrj_fck` set `re_nums`=re_nums+" . $voo['danshu'] . " where `id`=" . $fck_rs['re_id']);
                    $fck->upLevel($fck_rs['re_id']);//晋级
                }
                $fck->userLevel($voo['uid'], $voo['danshu']);//自己晋级

                //加上单数到自身认购字段
                $money = 0;
                $money = $fee_rs['uf1'] * $voo['danshu'];//金额
                $fck->xsjOne($fck_rs['re_id'], $fck_rs['user_id'], $money, $fck_rs['f5']);//销售奖第一部分中的第二部分
                $fck->query("update `zyrj_fck` set `singular`=singular+" . $voo['danshu'] . ",`cpzj`=cpzj+" . $money . " where `id`=" . $voo['uid']);
                //改变状态
                $jiadan->query("UPDATE `zyrj_jiadan` SET `pdt`=$nowdate,`is_pay`=1 where `id`=" . $voo['id']);
            }
            unset($jiadan, $where, $field, $vo, $fck, $fck_where);
            $bUrl = __URL__ . '/adminsingle';
            $this->_box(1, '确认！', $bUrl, 1);
        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    private function _adminsingleDel($PTid = 0)
    {
        //====================================删除加单
        if ($_SESSION['UrlPTPass'] == 'MyssGuansingle') {
            $jdan = M('jiadan');
            //$fck->query("UPDATE `zyrj_fck` SET `single_ispay`=0,`single_money`=0 where `ID` in (".$PTid.")");
            $jwhere['id'] = array('in', $PTid);
            $jwhere['is_pay'] = 0;
            $jdan->where($jwhere)->delete();
            $bUrl = __URL__ . '/adminsingle';
            $this->_box(1, '删除！', $bUrl, 1);
            exit;
        } else {
            $this->error(xstr('error_signed'));
        }
    }

    private function _delTable()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssQingKong') {
            //删除指定记录
            //$name=$this->getActionName();
            $model = M('fck');
            $model2 = M('bonus');
            $model3 = M('history');
            $model4 = M('msg');
            $model5 = M('times');
            $model6 = M('tiqu');
            $model7 = M('zhuanj');
            $model8 = M('shop');
            $model9 = M('jiadan');
            $model10 = M('chongzhi');
            $model11 = M('region');
            $model12 = M('orders');
            $model13 = M('huikui');
//			$model14 = M ('product');
            $model15 = M('gouwu');
            $model16 = M('xiaof');
            $model17 = M('promo');
            $model18 = M('fenhong');
            $model19 = M('peng');
            $model20 = M('ulevel');
            $model21 = M('address');
            $model22 = M('shouru');
            $model23 = M('remit');
            $model24 = M('card');
            $model25 = M('xfhistory');
            $model26 = M('game');
            $model27 = M('gupiao');
            $model28 = M('hgupiao');
            $model29 = M('gp_sell');
            $model31 = M('cash');
            $model30 = M('gp');
            $model31 = M('feng');
            $model32 = M('tihuo');
            $model33 = M('cash');

            $model->where('id > 1')->delete();
            $model2->where('id > 0')->delete();
            $model3->where('id > 0')->delete();
            $model4->where('id > 0')->delete();
            $model5->where('id > 0')->delete();
            $model6->where('id > 0')->delete();
            $model7->where('id > 0')->delete();
            $model8->where('id > 0')->delete();
            $model9->where('id > 0')->delete();
            $model10->where('id > 0')->delete();
            $model11->where('id > 0')->delete();
            $model12->where('id > 0')->delete();
            $model13->where('id > 0')->delete();
//			$model14->where('id > 0')->delete();
            $model15->where('id > 0')->delete();
            $model16->where('id > 0')->delete();
            $model17->where('id > 0')->delete();
            $model18->where('id > 0')->delete();
            $model19->where('id > 0')->delete();
            $model20->where('id > 0')->delete();
            $model21->where('id > 1')->delete();
            $model22->where('id > 0')->delete();
            $model23->where('id > 0')->delete();
            $model24->where('id > 0')->delete();
            $model25->where('id > 0')->delete();
            $model26->where('id > 0')->delete();
            $model27->where('id > 0')->delete();
            $model28->where('id > 0')->delete();
            $model29->where('id > 0')->delete();
            $model30->where('id > 0')->delete();
            $model31->where('id > 0')->delete();
            $model32->where('id > 0')->delete();
            $model33->where('id > 0')->delete();
            M('Xml')->where('id>0')->delete();
            M('chistory')->where('id>0')->delete();

            $nowdate = time();
            //数据清0

            $nowday = strtotime(date('Y-m-d'));
//			$nowday=strtotime(date('Y-m-d H:i:s'));	//测试 使用
            $have_gp = C('GuPiao_first_Open');
            if (empty($have_gp)) {
                $have_gp = 0;
            }
            $fx_numb = $have_gp / 10;
            $open_pri = 0.1;

            $model30->execute("UPDATE __TABLE__ SET opening=" . $open_pri . ",buy_num=0,sell_num=0,turnover=0,yt_sellnum=0,gp_quantity=0");

            $feeArr = M('Fee')->field('s9')->find();
            $regMoneyArr = explode('|', $feeArr['s9']);

            $sql .= "`l`=0,`r`=0,`shangqi_l`=0,`shangqi_r`=0,`idt`=0,";
            $sql .= "`benqi_l`=0,`benqi_r`=0,`lr`=0,`shangqi_lr`=0,`benqi_lr`=0,";
            $sql .= "`agent_max`=0,`lssq`=0,`agent_use`=0,`is_agent`=2,`agent_cash`=0,";
            $sql .= "`y_level`=" . count($regMoneyArr) . ",`u_level`=" . count($regMoneyArr) . ",`zjj`=0,`wlf`=0,`zsq`=0,`re_money`=0,";
            $sql .= "`cz_epoint`=0,b0=0,b1=0,b2=0,b3=0,b4=0,";
            $sql .= "`b5`=0,b6=0,b7=0,b8=0,b9=0,b10=0,b11=0,b12=0,re_nums=0,man_ceng=0,";
            $sql .= "re_peat_money=0,cpzj=" . $regMoneyArr[count($regMoneyArr) - 1] . ",duipeng=0,_times=0,fanli=0,fanli_time=$nowday,fanli_num=0,day_feng=0,get_date=$nowday,get_numb=0,";
            $sql .= "get_level=0,is_xf=0,xf_money=0,is_zy=0,zyi_date=0,zyq_date=0,down_num=0,agent_xf=0,agent_kt=0,agent_gp=0,gp_num=0,xy_money=0,";
            $sql .= "peng_num=0,re_f4=0,agent_cf=0,is_aa=0,is_bb=0,tx_num=0,xx_money=0,x_pai=1,x_out=1,x_num=0,fanli_money=0,wlf_money=1000,";
            $sql .= "re_nums_b=0,re_nums_l=0,re_nums_r=0,is_tj=0,";
            $sql .= "live_gupiao=$have_gp,all_in_gupiao=0,all_out_gupiao=0,p_out_gupiao=0,no_out_gupiao=0,ok_out_gupiao=0,";
            $sql .= "yuan_gupiao=0,all_gupiao=0,agent_gw=0,num_l=0,num_r=0,num_lr=0,g_level_a=0,g_level_b=0,jb_sdate=0,jb_idate=0,y_cpzj=2000,re_cpzj=0,pro_id=','";
            $sql .= ',gp_divi_count=0';
//dump("UPDATE __TABLE__ SET " . $sql);exit;
            $model->execute("UPDATE __TABLE__ SET " . $sql);

            for ($i = 1; $i <= 2; $i++) { //fck1 ~ fck5 表 (清空只留800000)
                $fck_other = M('fck' . $i);
                $fck_other->where('id > 1')->delete();
            }
            $nowweek = date("w");
            if ($nowweek == 0) {
                $nowweek = 7;
            }
            $kou_w = $nowweek - 1;
            $weekday = $nowday - $kou_w * 24 * 3600;

            //fee表,记载清空操作的时间(时间截)
            $fee = M('fee');
            $fee_rs = $fee->field('id')->find();
            $where = array();
            $data = array();
            $data['id'] = $fee_rs['id'];
            $data['create_time'] = time();
            $data['f_time'] = strtotime(date("y-m-d"));
            $data['g_time'] = $weekday;
            $data['gd_time'] = strtotime(date("y-m-d")) - 24 * 60 * 60;
            $data['us_num'] = 1;
            $data['a_money'] = 0;
            $data['b_money'] = 0;
            $data['ff_num'] = 1;
            $data['gp_one'] = $open_pri;
            $data['gp_fxnum'] = $fx_numb;
            $data['gp_senum'] = 0;
            $data['gp_cnum'] = 0;
            $data['gp_sell_count'] = 0;
            $data['last_gp_count'] = 0;

            $rs = $fee->save($data);

            $bUrl = __URL__ . '/delTable';
            $this->_box(1, '清空数据！', $bUrl, 1);
            exit;
        } else {
            $bUrl = __URL__ . '/delTable';
            $this->_box(0, '清空数据！', $bUrl, 1);
            exit;
        }
    }

    public function menber()
    {

        //列表过滤器，生成查询Map对象
        $fck = M('fck');
        $map = array();
        $id = $PT_id;
        $map['re_id'] = (int)$_GET['PT_id'];
        //$map['is_pay'] = 0;
        $UserID = $_POST['UserID'];
        if (!empty($UserID)) {
            $map['user_id'] = array('like', "%" . $UserID . "%");
        }

        //查询字段
        $field = 'id,user_id,nickname,bank_name,bank_card,user_name,user_address,user_tel,rdt,cpzj,is_pay';
        //=====================分页开始==============================================
        import("@.ORG.ZQPage");  //导入分页类
        $count = $fck->where($map)->count();//总页数
        $listrows = C('ONE_PAGE_RE');//每页显示的记录数
        $page_where = 'UserID=' . $UserID;//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page', $show);//分页变量输出到模板
        $list = $fck->where($map)->field($field)->order('rdt desc')->page($Page->getPage() . ',' . $listrows)->select();
        $this->assign('list', $list);//数据输出到模板
        //=================================================

        $where = array();
        $where['id'] = $id;
        $fck_rs = $fck->where($where)->field('agent_cash')->find();
        $this->assign('frs', $fck_rs);//注册币
        $this->display('menber');
        exit;
    }

    public function adminmoneyflows()
    {
        //货币流向
        if ($_SESSION['UrlPTPass'] == 'MyssMoneyFlows') {
            $fck = M('fck');
            $history = M('history');
            $sDate = $_REQUEST['S_Date'];
            $eDate = $_REQUEST['E_Date'];
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int)$_REQUEST['tp'];
            $map['_string'] = "1=1";
            $s_Date = 0;
            $e_Date = 0;
            if (!empty($sDate)) {
                $s_Date = strtotime($sDate);
            } else {
                $sDate = "2000-01-01";
            }
            if (!empty($eDate)) {
                $e_Date = strtotime($eDate);
            } else {
                $eDate = date("Y-m-d");
            }
            if ($s_Date > $e_Date && $e_Date > 0) {
                $temp_d = $s_Date;
                $s_Date = $e_Date;
                $e_Date = $temp_d;
            }
            if ($s_Date > 0) {
                $map['_string'] .= " and pdt>=" . $s_Date;
            }
            if ($e_Date > 0) {
                $e_Date = $e_Date + 3600 * 24 - 1;
                $map['_string'] .= " and pdt<=" . $e_Date;
            }
            if ($ss_type > 0) {
                if ($ss_type == 15) {
                    $map['action_type'] = array('lt', 12);
                } else {
                    $map['action_type'] = array('eq', $ss_type);
                }
            }
            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }

                unset($KuoZhan);
                $where = array();
                $where['user_id'] = array('eq', $UserID);
                $usrs = $fck->where($where)->field('id,user_id')->find();
                if ($usrs) {
                    $usid = $usrs['id'];
                    $usuid = $usrs['user_id'];
                    $map['_string'] .= " and (uid=" . $usid . " or user_id='" . $usuid . "')";
                } else {
                    $map['_string'] .= " and id=0";
                }
                unset($where, $usrs);
                $UserID = urlencode($UserID);
            }
            $this->assign('S_Date', $sDate);
            $this->assign('E_Date', $eDate);
            $this->assign('ry', $ss_type);
            $this->assign('UserID', $UserID);
            //查询字段
            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $history->where($map)->count();//总页数
            $listrows = 20;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&S_Date=' . $sDate . '&E_Date=' . $eDate . '&tp=' . $ss_type;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $history->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage() . ',' . $listrows)->select();
            $this->assign('list', $list);//数据输出到模板
            //=================================================
//            dump($history);

            $fee = M('fee');    //参数表
            $fee_rs = $fee->field('s18')->find();
            $fee_s7 = explode('|', $fee_rs['s18']);
            $this->assign('fee_s7', $fee_s7);        //输出奖项名称数组

            $v_title = $this->theme_title_value();
            $this->distheme('adminmoneyflows', $v_title[166]);
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }


    public function adminshenqing()
    {

        $shenqing = M('shenqing');

        //=====================分页开始==============================================

        import("@.ORG.ZQPage");  //导入分页类

        $count = $shenqing->count();//总页数

        $listrows = 50;//每页显示的记录数

//$page_where = 'UserID=' . $UserID .'&S_Date='. $sDate .'&E_Date='. $eDate . '&tp=' . $ss_type ;//分页条件

        $Page = new ZQPage($count, $listrows, 1, 0, 3);

        //===============(总页数,每页显示记录数,css样式 0-9)

        $show = $Page->show();//分页变量


        $this->assign('page', $show);//分页变量输出到模板

        $list = $shenqing->page($Page->getPage() . ',' . $listrows)->order('is_done asc')->select();


        $this->assign('list', $list);
        $this->distheme('adminshenqing', '申请处理');


    }


    public function adminshenqingsave()
    {

        $shenqing = M('shenqing');

        $fcks = M('fck');

        $uid = $_GET['uid'];

        $jibie = $_GET['jibie'];

        $id = $_GET['id'];

        $tg['is_done'] = 1;


        switch ($jibie) {

            case 1:

                $shengji['jingli'] = 1;
                $shengji['zongjian'] = 0;
                $shengji['dongshi'] = 0;
                $shengji['h4'] = 0;
                $shengji['h5'] = 0;
                $shengji['h6'] = 0;

                break;

            case 2:

                $shengji['jingli'] = 0;
                $shengji['zongjian'] = 1;
                $shengji['dongshi'] = 0;
                $shengji['h4'] = 0;
                $shengji['h5'] = 0;
                $shengji['h6'] = 0;

                break;

            case 3:

                $shengji['jingli'] = 0;
                $shengji['zongjian'] = 0;
                $shengji['dongshi'] = 1;
                $shengji['h4'] = 0;
                $shengji['h5'] = 0;
                $shengji['h6'] = 0;

                break;

            case 4:

                $shengji['jingli'] = 0;
                $shengji['zongjian'] = 0;
                $shengji['dongshi'] = 0;
                $shengji['h4'] = 1;
                $shengji['h5'] = 0;
                $shengji['h6'] = 0;

                break;

            case 5:

                $shengji['jingli'] = 0;
                $shengji['zongjian'] = 0;
                $shengji['dongshi'] = 0;
                $shengji['h4'] = 0;
                $shengji['h5'] = 1;
                $shengji['h6'] = 0;

                break;

            case 6:

                $shengji['jingli'] = 0;
                $shengji['zongjian'] = 0;
                $shengji['dongshi'] = 0;
                $shengji['h4'] = 0;
                $shengji['h5'] = 0;
                $shengji['h6'] = 1;

                break;

            default:

                $shengji['jingli'] = 0;
                $shengji['zongjian'] = 0;
                $shengji['dongshi'] = 0;
                $shengji['h4'] = 0;
                $shengji['h5'] = 0;
                $shengji['h6'] = 0;

                break;
        }

        //var_dump ($shengji);


        $tgm = $shenqing->where(array('id' => $id))->save($tg);

        $sj = $fcks->where(array('user_id' => $uid))->save($shengji);


        if (false !== $tgm && false !== $sj) {

            $this->success('审核通过！', '__URL__/adminshenqing/');
        } else {
            echo $tgm . '<br>';
            echo $sj;

            $this->error('!!!', '__URL__/adminshenqing');
        }


    }


    //会员升级
    public function adminUserUp($GPid = 0)
    {
        //列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            $ulevel = M('ulevel');
            $UserID = $_POST['UserID'];
            if (!empty($UserID)) {
                $map['user_id'] = array('like', "%" . $UserID . "%");
            }

            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $ulevel->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $page_where = 'UserID=' . $UserID;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $ulevel->where($map)->field($field)->order('id desc')->page($Page->getPage() . ',' . $listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ, 1);
            $this->assign('voo', $HYJJ);//会员级别

            $this->assign('list', $list);//数据输出到模板
            //=================================================


            $title = '会员升级管理';
            $this->display('adminuserUp');
            return;
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function adminUserUpAC($GPid = 0)
    {
        //列表过滤器，生成查询Map对象
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            //处理提交按钮
            $action = $_POST['action'];
            //获取复选框的值
            $PTid = $_POST['tabledb'];
            if (!isset($PTid) || empty($PTid)) {
                $bUrl = __URL__ . '/adminUserUp';
                $this->_box(0, '请选择会员！', $bUrl, 1);
                exit;
            }
            switch ($action) {
                case '确认升级';
                    $this->_adminUserUpOK($PTid);
                    break;
                case xstr('delete');
                    $this->_adminUserUpDel($PTid);
                    break;
                default;
                    $bUrl = __URL__ . '/adminUserUp';
                    $this->_box(0, '没有该会员！', $bUrl, 1);
                    break;
            }
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    private function _adminUserUpOK($PTid = 0)
    {
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            $fck = D('Fck');
            $ulevel = M('ulevel');
            $where = array();
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = 0;
            $field = '*';
            $vo = $ulevel->where($where)->field($field)->select();
            $fck_where = array();
            $nowdate = strtotime(date('c'));
            foreach ($vo as $voo) {
                $ulevel->query("UPDATE `zyrj_ulevel` SET `pdt`=$nowdate,`is_pay`=1 where `id`=" . $voo['id']);
                $money = 0;
                $money = $voo['money'];//金额
                $fck->query("update `zyrj_fck` set `cpzj`=cpzj+" . $money . ",u_level=" . $voo['up_level'] . "  where `id`=" . $voo['uid']);

            }
            unset($fck, $where, $field, $vo);
            $bUrl = __URL__ . '/adminUserUp';
            $this->_box(1, '升级会员成功！', $bUrl, 1);
            exit;

        } else {
            $this->error(xstr('error_signed'));
            exit;
        }
    }

    private function _adminUserUpDel($PTid = 0)
    {
        //删除会员
        if ($_SESSION['UrlPTPass'] == 'MyssGuanXiGuaUp') {
            $fck = M('fck');
            $ispay = M('ispay');
            $ulevle = M('ulevel');
            $where['id'] = array('in', $PTid);
            $where['is_pay'] = array('eq', 0);
            $rss1 = $ulevle->where($where)->delete();

            if ($rss1) {
                $bUrl = __URL__ . '/adminUserUp';
                $this->_box(1, '删除升级申请成功！', $bUrl, 1);
                exit;
            } else {
                $bUrl = __URL__ . '/adminUserUp';
                $this->_box(0, '删除升级申请失败！', $bUrl, 1);
                exit;
            }

        } else {
            $this->error(xstr('error_signed'));
        }
    }


    public function adminMenberJL()
    {
        if ($_SESSION['UrlPTPass'] == 'MyssadminMenberJL') {
            $fck = M('fck');
            $UserID = $_REQUEST['UserID'];
            $ss_type = (int)$_REQUEST['type'];

            $map = array();
            if (!empty($UserID)) {
                import("@.ORG.KuoZhan");  //导入扩展类
                $KuoZhan = new KuoZhan();
                if ($KuoZhan->is_utf8($UserID) == false) {
                    $UserID = iconv('GB2312', 'UTF-8', $UserID);
                }
                unset($KuoZhan);
                $where['user_name'] = array('like', "%" . $UserID . "%");
                $where['user_id'] = array('like', "%" . $UserID . "%");
                $where['_logic'] = 'or';
                $map['_complex'] = $where;
                $UserID = urlencode($UserID);
            }
            $uulv = (int)$_REQUEST['ulevel'];
            if (!empty($uulv)) {
                $map['u_level'] = array('eq', $uulv);
            }
            $map['is_pay'] = array('egt', 1);
            $map['u_level'] = array('egt', 4);
            //查询字段

            $field = '*';
            //=====================分页开始==============================================
            import("@.ORG.ZQPage");  //导入分页类
            $count = $fck->where($map)->count();//总页数
            $listrows = C('ONE_PAGE_RE');//每页显示的记录数
            $listrows = 20;//每页显示的记录数
            $page_where = 'UserID=' . $UserID . '&ulevel=' . $uulv;//分页条件
            $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
            //===============(总页数,每页显示记录数,css样式 0-9)
            $show = $Page->show();//分页变量
            $this->assign('page', $show);//分页变量输出到模板
            $list = $fck->where($map)->field($field)->order('pdt desc,id desc')->page($Page->getPage() . ',' . $listrows)->select();

            $HYJJ = '';
            $this->_levelConfirm($HYJJ, 1);
            $this->assign('voo', $HYJJ);//会员级别
            $level = array();
            for ($i = 0; $i < count($HYJJ); $i++) {
                $level[$i] = $HYJJ[$i + 1];
            }
            $this->assign('level', $level);
            $this->assign('list', $list);//数据输出到模板
            //=================================================

            $title = '会员管理';
            $this->assign('title', $title);
            $this->display('adminMenberJL');
            return;
        } else {
            $this->error(xstr('data_error'));
            exit;
        }
    }

    public function upload_fengcai_aa()
    {
        if (!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_aa();
        }
    }

    protected function _upload_fengcai_aa()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize = 1048576 * 2;// TODO 50M   3N 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath = './Public/Uploads/';

        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;

        //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix = 'm_';  //生产2张缩略图

        //设置缩略图最大宽度
        $upload->thumbMaxWidth = '800';

        //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

        //设置上传文件规则
        $upload->saveRule = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(1, 100);

        //删除原图
        $upload->thumbRemoveOrigin = true;

        if (!$upload->upload()) {
            //捕获上传异常
            $error_p = $upload->getErrorMsg();
            echo "<script>alert('" . $error_p . "');history.back();</script>";
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path = $uploadList[0]['savepath'];
            $U_nname = $uploadList[0]['savename'];
            $U_inpath = (str_replace('./Public/', '__PUBLIC__/', $U_path)) . $U_nname;

            echo "<script>window.parent.myform.str21.value='" . $U_inpath . "';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }

    public function upload_fengcai_bb()
    {
        if (!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_bb();
        }
    }

    protected function _upload_fengcai_bb()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize = 1048576 * 2;// TODO 50M   3N 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath = './Public/Uploads/';

        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;

        //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix = 'm_';  //生产2张缩略图

        //设置缩略图最大宽度
        $upload->thumbMaxWidth = '800';

        //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

        //设置上传文件规则
        $upload->saveRule = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(1, 100);

        //删除原图
        $upload->thumbRemoveOrigin = true;

        if (!$upload->upload()) {
            //捕获上传异常
            $error_p = $upload->getErrorMsg();
            echo "<script>alert('" . $error_p . "');history.back();</script>";
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path = $uploadList[0]['savepath'];
            $U_nname = $uploadList[0]['savename'];
            $U_inpath = (str_replace('./Public/', '__PUBLIC__/', $U_path)) . $U_nname;

            echo "<script>window.parent.myform.str22.value='" . $U_inpath . "';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }

    public function upload_fengcai_cc()
    {
        if (!empty($_FILES)) {
            //如果有文件上传 上传附件
            $this->_upload_fengcai_cc();
        }
    }

    protected function _upload_fengcai_cc()
    {
        header("content-type:text/html;charset=utf-8");
        // 文件上传处理函数

        //载入文件上传类
        import("@.ORG.UploadFile");
        $upload = new UploadFile();

        //设置上传文件大小
        $upload->maxSize = 1048576 * 2;// TODO 50M   3N 3292200 1M 1048576

        //设置上传文件类型
        $upload->allowExts = explode(',', 'jpg,gif,png,jpeg');

        //设置附件上传目录
        $upload->savePath = './Public/Uploads/';

        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb = false;

        //设置需要生成缩略图的文件前缀
        $upload->thumbPrefix = 'm_';  //生产2张缩略图

        //设置缩略图最大宽度
        $upload->thumbMaxWidth = '800';

        //设置缩略图最大高度
        $upload->thumbMaxHeight = '600';

        //设置上传文件规则
        $upload->saveRule = date("Y") . date("m") . date("d") . date("H") . date("i") . date("s") . rand(1, 100);

        //删除原图
        $upload->thumbRemoveOrigin = true;

        if (!$upload->upload()) {
            //捕获上传异常
            $error_p = $upload->getErrorMsg();
            echo "<script>alert('" . $error_p . "');history.back();</script>";
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
            $U_path = $uploadList[0]['savepath'];
            $U_nname = $uploadList[0]['savename'];
            $U_inpath = (str_replace('./Public/', '__PUBLIC__/', $U_path)) . $U_nname;

            echo "<script>window.parent.myform.str23.value='" . $U_inpath . "';</script>";
            echo "<span style='font-size:12px;'>上传完成！</span>";
            exit;

        }
    }


    public function activeCodeManager()
    {
        $cards = $_POST['cardno'];
        //=====================分页开始==============================================
        import("@.ORG.ZQPage");  //导入分页类
        $count = M('card')->count();//总页数
        $listrows = 20;//每页显示的记录数
        $page_where = '';//分页条件
        $Page = new ZQPage($count, $listrows, 1, 0, 3, $page_where);
        //===============(总页数,每页显示记录数,css样式 0-9)
        $show = $Page->show();//分页变量
        $this->assign('page', $show);//分页变量输出到模板
        if (empty($cards)) {
            $list = M('card')->order('is_use ASC,c_time DESC,id DESC')->page($Page->getPage() . ',' . $listrows)->select();
        } else {
            $map['card_no'] = $cards;
            $list = M('card')->order('is_use ASC,c_time DESC,id DESC')->page($Page->getPage() . ',' . $listrows)->where($map)->select();
        }
        $this->assign('list', $list);//数据输出到模板
        //=================================================
        $tArr = array();
        if ($list) {
            $arrUid = array();
            foreach ($list as $row) {
                $tNum = intval($row['uid']);
                if (!in_array($tNum, $arrUid))
                    $arrUid[] = $tNum;
                $tNum = intval($row['use_uid']);
                if ($tNum > 0 && !in_array($tNum, $arrUid))
                    $arrUid[] = $tNum;
            }
            $arrUser = M('Fck')->field('id,user_id')->where(array('id' => array('in', $arrUid)))->select();
            if ($arrUser) {
                foreach ($arrUser as $user) {
                    $tArr[$user['id']] = array();
                    foreach ($user as $key => $value)
                        $tArr[$user['id']][$key] = $value;
                }
                unset($arrUser);
            }
        }
        $this->assign('userArr', $tArr);

        // $this->display();
        $this->distheme('activeCodeManager', "入场券管理");
    }


    public function createActiveCode()
    {
        $userUUID = trim($_POST['UserID']);
        if (strlen($userUUID) == 0) {
            $this->error("请输入所发放的报单中心编号");
            exit;
        }
        $user = M('Fck')->field('id')->where(array('user_id' => $userUUID))->find();
        if (!$user) {
            $this->error('会员编号不存在');
            exit;
        }
        $Num = (int)$_POST['Num'];
        for ($i = 0; $i < $Num; $i++) {
            $card = M('card');
            $data = array();
            $data['bid'] = 0;
            $data['buser_id'] = $userUUID;
            $data['use_time'] = 0;
            $data['c_type'] = 0;
            $data['is_use'] = 0;
            $card->execute('LOCK TABLE __TABLE__ WRITE');
            $data['card_no'] = $this->buildActiveCode();
            $data['c_time'] = time();
            $card->add($data);
            $card->execute('UNLOCK TABLES');
        }

        $this->_box(1, "入场券生成成功", U('activeCodeManager'), 1);
        //后台充值增加门票记录，插入orderlist表
        $data_p = array();
        $data_p['userid'] = $user['id'];
        $data_p['ordstatus'] = 12; //后台增加
        $data_p['num'] = $Num;
        $data_p['payment_notify_time'] = date("Y-m-d H:i:s", time());
        $data_p['payment_type'] = '后台充值门票增加';
        $rs_p = M('orderlist')->add($data_p);
    }

    public function zidongpi()
    {
        $aaa = A('Mavro');
        $aaa->matchBuySell();
        $this->success('操作成功', '__APP__/Public/main');

    }

    protected function buildActiveCode()
    {
        $baseChar = '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $bit = 8;
        $tStr = '';
        do {
            $tStr = '';
            for ($i = 0; $i < $bit; $i++) {
                $rnd = rand(0, strlen($baseChar) - 1);
                $tStr .= $baseChar[$rnd];
            }
        } while (M('Card')->field('id')->where(array('card_no' => $tStr))->find());
        return $tStr;
    }

}

?>
