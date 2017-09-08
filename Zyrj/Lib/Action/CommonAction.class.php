<?php

class CommonAction extends CheFieldAction
{

    public function _initialize()
    {
        if(class_exists('Redis')) {
            $redis = new Redis();
            $redis->connect(C("REDIS_HOST"), 63790);
            $ip = get_real_ip() ? get_real_ip() : $_SERVER["REMOTE_ADDR"];
            $requestKey = "request_" . $ip;
            if ($redis->exists($requestKey)) {
                $redis->incr($requestKey);
                if ($redis->get($requestKey) > 150) {
                    $redis->zAdd('request_black_ip_list', $redis->get($requestKey), $ip);
                }
            } else {
                $redis->set($requestKey, 1, 10);
            }
            $list = $redis->zRange('request_black_ip_list', 0, -1, true);
            if (array_key_exists($ip, $list)) {
                echo "file not found";
                exit;
            }
        }
        //七天未排单,直接封号
        $fck = D('Fck');
        $fck->isInOrder($_SESSION["authId_N_c116"]);
        if (in_array($_REQUEST["_URL_"][0], ["Public", "Change", "Bonus", "Reg", "User", "Msg", "Mavro", "News", "Member"])) {
            if (!in_array($_REQUEST["_URL_"][0], ["Reg"]) && !in_array($_REQUEST["_URL_"][1], ["login", "checkLogin", "verify", "send_code_msg"])) {
                if (empty($_SESSION["loginUseracc"])) {
                    $this->redirect("Public/login",array());
                    // 提示错误信息
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        } else {
            if(!empty($_REQUEST["_URL_"][0])) {
                if ($_SESSION["loginUseracc"] != "800000" || (strlen($_SESSION[C('USER_NICKNAME')]) != 16)) {
                    // 提示错误信息
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
        if (in_array($_REQUEST["_URL_"][0] . "/" . $_REQUEST["_URL_"][1], ["Member/shops", "User/codys", "Mavro/Delect", "Mavro/uploadImg", "Mavro/confirm_get", "Mavro/confirm_pay", "Public/", "Change/codys", "Public/main", "Change/changedata", "Change/changedataSave", "Change/changepassword", "Change/changepasswordSave", "Reg/users", "User/relations", "Public/buys", "Mavro/buyAC", "Public/sells", "Mavro/sellAC", "Public/Qiangdan", "Bonus/wallet", "Bonus/financeTable", "Change/FrontCode", "Change/Zensong", "Change/FrontCodesong", "Change/Orderlistall", "Msg/inmsg", "Msg/outmsg/", "Msg/writemsg/", "Msg/s_del", "Msg/f_del", "Msg/writeSave", "Public/mx", "Change/s", "News/News_show"])) {
            if (empty($_SESSION["loginUseracc"])) {
                $this->redirect("Public/login",array());
                // 提示错误信息
                $this->error(L('_VALID_ACCESS_'));
            }
        }elseif(in_array($_REQUEST["_URL_"][0] . "/" . $_REQUEST["_URL_"][1], ["User/cody"]) && $_REQUEST["c_id"] == 1){
            if (empty($_SESSION["loginUseracc"])) {
                // 提示错误信息
                $this->error(L('_VALID_ACCESS_'));
            }
        }elseif(in_array($_REQUEST["_URL_"][0] . "/" . $_REQUEST["_URL_"][1], ["Change/cody"]) && in_array($_REQUEST["c_id"], [1, 2, 4])){
            if (empty($_SESSION["loginUseracc"])) {
                // 提示错误信息
                $this->error(L('_VALID_ACCESS_'));
            }
        }elseif(in_array($_REQUEST["_URL_"][0] . "/" . $_REQUEST["_URL_"][1], ["/", "Public/send_code_msg", "Public/LogOut", "Reg/us_regAC", "Reg/us_reg", "Public/checkLogin", "Public/login", "Public/verify"])){

        }else{
            if ($_SESSION["loginUseracc"] != "800000" || (strlen($_SESSION[C('USER_NICKNAME')]) != 16)) {
                // 提示错误信息
                $this->error(L('_VALID_ACCESS_'));
            }
        }

        //print_r($_SESSION);exit;
        if(in_array($_REQUEST["_URL_"][1], ["zidongpi", "duoyi", "quxiaopipei", "adminCurrencyRecharge" , "adminuserDataSave", "adminuserData", "delTable"])){
            if($_SESSION["loginUseracc"] != "800000" || (strlen($_SESSION[C('USER_NICKNAME')]) != 16)){
                // 提示错误信息
                $this->error(L('_VALID_ACCESS_'));
            }
        }
        if (MODULE_NAME != 'Plan' && MODULE_NAME != 'News')
            $this->_inject_check(1);//调用过滤函数


        $tStr = C('TMPL_PARSE_STRING.__PUBLIC__');
        C('TMPL_PARSE_STRING.__PUBLIC__', $tStr . '/' . C('LANGUAGE_FILE_NAME'));
        $tStr = C('TMPL_PARSE_STRING.__PUBLIC_COMMON__');
        C('TMPL_PARSE_STRING.__PUBLIC_COMMON__', $tStr . '/common');

        // 用户权限检查
        if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
            import('@.ORG.RBAC');
            if (!RBAC::AccessDecision()) {
                //检查认证识别号
                if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //跳转到认证网关
                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
                    }
                    // 提示错误信息
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
    }


    protected function _Admin_checkUser()
    {
        //后台权限
        if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
            $_SESSION = array();
            $bUrl = __APP__ . '/Public/login';
            $this->_boxx($bUrl);
            exit;
        }
        $fck = M('fck');
        $mapp = array();
        $mapp['id'] = $_SESSION[C('USER_AUTH_KEY')];
        $mapp['is_boss'] = array('gt', 0);
        $field = 'id,user_id';
        $rs = $fck->where($mapp)->field($field)->find();
        if (!$rs) {
            $_SESSION = array();
            $bUrl = __APP__ . '/Public/login';
            $this->_boxx($bUrl);
            exit;
        }
        unset($fck, $mapp, $rs);
    }

    // 检查用户是否登录
    protected function _checkUser()
    {
        if (!isset($_SESSION[C('USER_AUTH_KEY')])) {
            $this->LinkOut();
            exit;
        }
        $this->_user_mktime($_SESSION['UserMktimes']);
        $User = M('fck');


        //生成认证条件
        $mapp = array();
        // 支持使用绑定帐号登录
        //管理员编号，证明
        $mapp['id'] = $_SESSION[C('USER_AUTH_KEY')];
        $mapp['user_id'] = $_SESSION['loginUseracc'];
        $field = 'user_id,password,user_type,is_lock';
        $authInfoo = $User->where($mapp)->field($field)->find();
        if (false == $authInfoo) {
            $this->LinkOut();
            exit;
        } else {
            if ($authInfoo['is_lock'] == 1) {
                echo "<script language=javascript>";
                echo 'alert("==您的会员已锁定！==");';
                echo "</script>";
                $this->LinkOut();
            }
            //是否允许一个用户同时多人在线！
            $fee = M('fee');
            $fee_rs = $fee->field('i3,str27')->find(1);
            $user_type = 0;
            if ($fee_rs['user_type'] == 1) {
                if ($_SESSION['login_user_type'] != $authInfoo['user_type']) {
                    $user_type = 1;
                }
            }
            if ($fee_rs['i3'] == 1) {
                if ($_SESSION[C('USER_AUTH_KEY')] != 1) {
                    echo "<script language=javascript>";
                    echo 'alert("==' . $fee_rs['str27'] . '==");';
                    echo "</script>";
                    $this->LinkOut();
                }

            }
            unset($fee, $fee_rs);
            $mpwd = md5($authInfoo['user_id'] . 'wodetp_new_1012!@#' . $authInfoo['password'] . $_SERVER['HTTP_USER_AGENT']);
            if ($mpwd != $_SESSION['login_sf_list_u'] || $user_type == 1) {
//				$this->LinkOut();
//				exit;
            }
        }
    }

    //检测登录是否超时
    protected function _user_mktime($onlinetime)
    {
        $new_time = mktime();
        if ($new_time - $onlinetime > '1200') {
            $this->LinkOut();
            exit;
        } else {
            $_SESSION['UserMktimes'] = mktime();
        }
    }

    public function LinkOut()
    {
        $_SESSION = array();
        $this->display('../Public/LinkOut');
    }

    //处理结果函数 (结果，事件，跳转url，跳转时间单位为秒)
    protected function _box($dz = 0, $list = '', $url = '', $ms)
    {
        if ($dz == 1) {
            $dz = '操作成功!';
        } else {
            $dz = xstr('operation_failed');
        }
        $lists = array();
        $lists['Title'] = $list;
        $lists['Url'] = $url;
        $lists['ms'] = $ms;
        $lists['dz'] = $dz;
        $this->assign('list', $lists);

        $v_title = $this->theme_title_value();
        $this->distheme('../Public/box', $v_title[3]);
    }

    //页面跳转
    protected function _boxx($url = '')
    {
        echo "<script> location.href='{$url}' </script>";
    }

    protected function _boxx2($dz = 0, $list = '', $url = '', $ms)
    {
        if ($dz == 1) {
            echo "<script> alert('上传成功！'); location.href = document.referrer; </script>";
        } else {
            echo "<script> alert('上传失败！'); location.href = document.referrer; </script>";
        }

    }

    //过滤函数
    protected function _inject_check($sql_str = 0)
    {
        //合并$_POST 和 $_GET
        foreach ($_GET as $get_key => $get_var) {
            $get[strtolower($get_key)] = $get_var;
        }
        /* 过滤所有POST过来的变量 */
        foreach ($_POST as $post_key => $post_var) {
            $post[strtolower($post_key)] = $post_var;
        }
        //需要过滤的数据
        if ($sql_str == 0) {
            $GetPost = 'select|insert|update|delete|union|into|load_file|outfile';
        } else {
            $GetPost = 'select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|\(|\)|\<|\>|chr|char';
        }
        foreach ($post as $post_key => $sql_str) {
            $check = eregi($GetPost, $sql_str);// 进行过滤
            if ($check) {

                $this->error('输入内容不合法，请重新输入！');
                exit();
            }
        }
        foreach ($get as $post_key => $sql_str) {
            $check = eregi($GetPost, $sql_str);// 进行过滤
            if ($check) {
                $this->error('输入内容不合法，请重新输入！');
                exit();
            }
        }

    }

    protected function _levelConfirm(&$HYJJ, $HYid = 1)
    {
        $HYJJ = array();
        $fee_rs = M('fee')->field('s10')->find(1);
        $fee_s1 = explode('|', $fee_rs['s10']);
        foreach ($fee_s1 as $key => $value)
            $HYJJ[$key + 1] = $value;
    }

    protected function _getlevelConfirm(&$glv)
    {
        $fee_s1 = explode('|', C('Member_Get_Level'));
        $glv = array();
        $glv[0] = "";
        $glv[1] = "(" . $fee_s1[0] . ")";
        $glv[2] = "(" . $fee_s1[1] . ")";
        $glv[3] = "(" . $fee_s1[2] . ")";
        $glv[4] = "(" . $fee_s1[3] . ")";
        $glv[5] = "(" . $fee_s1[4] . ")";
        $glv[6] = "(" . $fee_s1[5] . ")";
        $glv[7] = "(" . $fee_s1[6] . ")";
        $glv[8] = "(" . $fee_s1[7] . ")";
    }

    public function index()
    {
        //列表过滤器，生成查询Map对象
        $map = $this->_search();
        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }
        $name = $this->getActionName();
        $model = D($name);
        if (!empty ($model)) {
            $this->_list($model, $map);
        }
        $this->display();
        return;
    }

    /**
     * +----------------------------------------------------------
     * 取得操作成功后要返回的URL地址
     * 默认返回当前模块的默认操作
     * 可以在action控制器中重载
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     * @return string
    +----------------------------------------------------------
     * @throws ThinkExecption
    +----------------------------------------------------------
     */
    function getReturnUrl()
    {
        return __URL__ . '?' . C('VAR_MODULE') . '=' . MODULE_NAME . '&' . C('VAR_ACTION') . '=' . C('DEFAULT_ACTION');
    }

    /**
     * +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param string $name 数据对象名称
     * +----------------------------------------------------------
     * @return HashMap
    +----------------------------------------------------------
     * @throws ThinkExecption
    +----------------------------------------------------------
     */
    protected function _search($name = '')
    {
        //生成查询条件
        if (empty ($name)) {
            $name = $this->getActionName();
        }
        $name = $this->getActionName();
        $model = D($name);
        $map = array();
        foreach ($model->getDbFields() as $key => $val) {
            if (isset ($_REQUEST [$val]) && $_REQUEST [$val] != '') {
                $map [$val] = $_REQUEST [$val];
            }
        }
        return $map;

    }

    /**
     * +----------------------------------------------------------
     * 根据表单生成查询条件
     * 进行列表过滤
     * +----------------------------------------------------------
     * @access protected
     * +----------------------------------------------------------
     * @param Model $model 数据对象
     * @param HashMap $map 过滤条件
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
     * +----------------------------------------------------------
     * @return void
    +----------------------------------------------------------
     * @throws ThinkExecption
    +----------------------------------------------------------
     */
    //==============================================分页函数
    protected function _list($model, $map, $sortBy = '', $asc = false)
    {
        //排序字段 默认为主键名
        if (isset ($_REQUEST ['_order'])) {
            $order = $_REQUEST ['_order'];
        } else {
            $order = !empty ($sortBy) ? $sortBy : $model->getPk();
        }
        //排序方式默认按照倒序排列
        //接受 sost参数 0 表示倒序 非0都 表示正序
        if (isset ($_REQUEST ['_sort'])) {
            $sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
        } else {
            $sort = $asc ? 'asc' : 'desc';
        }
        //取得满足条件的记录数
        $count = $model->where($map)->count('id');
        if ($count > 0) {
            import("@.ORG.Page");
            //创建分页对象
            if (!empty ($_REQUEST['listRows'])) {
                $listRows = $_REQUEST['listRows'];
            } else {
                $listRows = '';
            }
            $p = new Page ($count, 10);
            //分页查询数据

            $voList = $model->where($map)->order("`" . $order . "` " . $sort)->limit($p->firstRow . ',' . $p->listRows)->select();
            //echo $model->getlastsql();
            //分页跳转的时候保证查询条件
            foreach ($map as $key => $val) {
                if (!is_array($val)) {
                    $p->parameter .= "$key=" . urlencode($val) . "&";
                }
            }
            //会员等级 开始=================
            $i = 1;
            $HYJJ = array();
            $HYoo = array();
            $this->_levelConfirm($HYJJ, 1);
            foreach ($voList as $voo) {
                $HYoo[$i][0] = $HYJJ[$voo['u_level']];
                $i++;
            }
            $this->assign('voo', $HYoo);
            //会员等级 结束=================

            //分页显示
            $page = $p->show();
            //列表排序显示
            $sortImg = $sort; //排序图标
            $sortAlt = $sort == 'desc' ? '升序排列' : '倒序排列'; //排序提示
            $sort = $sort == 'desc' ? 1 : 0; //排序方式
            //模板赋值显示
            $this->assign('list', $voList);
            $this->assign('sort', $sort);
            $this->assign('order', $order);
            $this->assign('sortImg', $sortImg);
            $this->assign('sortType', $sortAlt);
            $this->assign("page", $page);
        }
        Cookie::set('_currentUrl_', __SELF__);
        return;
    }

    protected function _2Mal($name = 0, $wei = 0)
    {
        //格式化数字，保留小数位数
        $map = sprintf('%.' . $wei . 'f', (float)$name);
        return $map;
    }

    public function _Config_name()
    {
        header("Content-Type:text/html; charset=utf-8");
        //调用系统参数
        $System_namex = C('System_namex');        //系统名字
        //$System_bankx    = C('System_bankx');        //银行名字
        $User_namex = C('User_namex');
        $Nick_namex = C('Nick_namex');
        //$Member_Level    = C('Member_Level');       //会员级别名称
        //$Member_Money    = C('Member_Money');       //注册金额
        //$Member_Single   = C('Member_Single');      //会员级别单数


        $this->assign('System_namex', $System_namex);
        //$this->assign ('System_bankx',$System_bankx);
        $this->assign('User_namex', $User_namex);
        $this->assign('Nick_namex', $Nick_namex);
        //$this->assign ('Member_Level',$Member_Level);
        //$this->assign ('Member_Money',$Member_Money);
        //$this->assign ('Member_Single',$Member_Single);
    }

    public function gongpaixtsmall($uid)
    {
        $fck = M('fck');
        $mouid = $uid;
        $field = 'id,user_id,p_level,p_path,u_pai';
        $where = 'is_pay>0 and (p_path like "%,' . $mouid . ',%" or id=' . $mouid . ')';

        $re_rs = $fck->where($where)->order('p_level asc,u_pai+0 asc')->field($field)->select();
        $fck_where = array();

        foreach ($re_rs as $vo) {
            $faid = $vo['id'];
            $fck_where['is_pay'] = array('gt', 0);
            $fck_where['father_id'] = $faid;
            $count = $fck->where($fck_where)->count();
            if (is_numeric($count) == false) {
                $count = 0;
            }
            if ($count < 3) {
                $father_id = $vo['id'];
                $father_name = $vo['user_id'];
                $TreePlace = $count;
                $p_level = $vo['p_level'] + 1;
                $p_path = $vo['p_path'] . $vo['id'] . ',';
                $u_pai = $vo['u_pai'] * 3 + $TreePlace - 1;

                $arry = array();
                $arry['father_id'] = $father_id;
                $arry['father_name'] = $father_name;
                $arry['treeplace'] = $TreePlace;
                $arry['p_level'] = $p_level;
                $arry['p_path'] = $p_path;
                $arry['u_pai'] = $u_pai;
                // dump($arry);
                return $arry;
                break;
            }
        }
    }

    public function gongpai($uid)
    {
        $fck = M('fck');
        $mouid = $uid;
        $field = '*';
        $where = 'is_pay>0 and id=' . $mouid;

        $re_rs = $fck->where($where)->field($field)->find();
        if ($re_rs) {
            // $renums=$re_rs['re_nums']-1;
            $renums = $re_rs['re_nums'];
            $id = $re_rs['id'];
            //判断排在哪条线
            $xian = $renums % 4;
            // dump($renums);
            // dump($xian);
            //一线
            $fa_rs = $fck->where("father_id=" . $id . " and treeplace=" . $xian)->field('')->find();
            if (!$fa_rs) {
                $father_id = $id;
                $father_name = $re_rs['user_id'];
                $TreePlace = $xian;
                $p_level = $re_rs['p_level'] + 1;
                $p_path = $re_rs['p_path'] . $re_rs['id'] . ',';

                $arry = array();
                $arry['father_id'] = $father_id;
                $arry['father_name'] = $father_name;
                $arry['treeplace'] = $TreePlace;
                $arry['p_level'] = $p_level;
                $arry['p_path'] = $p_path;
                return $arry;
            } else {
                $tp = 0;
                $renid = $this->pd_left_us($fa_rs['id'], $tp);
                $ren_rs = $fck->where("id=" . $renid)->find();

                $father_id = $renid;
                $father_name = $ren_rs['user_id'];
                $TreePlace = $tp;
                $p_level = $ren_rs['p_level'] + 1;
                $p_path = $ren_rs['p_path'] . $ren_rs['id'] . ',';

                $arry = array();
                $arry['father_id'] = $father_id;
                $arry['father_name'] = $father_name;
                $arry['treeplace'] = $TreePlace;
                $arry['p_level'] = $p_level;
                $arry['p_path'] = $p_path;

                return $arry;
            }

        }
    }

    //判断最左区
    public function pd_left_us($uid, &$tp)
    {
        $fck = M('fck');
        $c_l = $fck->where('father_id=' . $uid . ' and treeplace=' . $tp . '')->field('id')->find();
        if ($c_l) {
            $n_id = $c_l['id'];
            $tp = 0;
            $ren_id = $this->pd_left_us($n_id, $tp);
        } else {
            $ren_id = $uid;
        }
        unset($fck, $c_l);
        return $ren_id;
    }


    public function gongpaixtbig()
    {
        $fck = M('fck');
        $field = 'id,user_id,p_level,p_path,u_pai';
        $re_rs = $fck->where('is_pay>0')->order('p_level asc,u_pai+0 asc')->field($field)->select();
        $fck_where = array();
        foreach ($re_rs as $vo) {
            $faid = $vo['id'];
            $fck_where['is_pay'] = array('gt', 0);
            $fck_where['father_id'] = $faid;
            $count = $fck->where($fck_where)->count();
            if (is_numeric($count) == false) {
                $count = 0;
            }
            if ($count < 4) {
                $father_id = $vo['id'];
                $father_name = $vo['user_id'];
                $TreePlace = $count;
                $p_level = $vo['p_level'] + 1;
                $p_path = $vo['p_path'] . $vo['id'] . ',';
                $u_pai = $vo['u_pai'] * 4 + $TreePlace;

                $arry = array();
                $arry['father_id'] = $father_id;
                $arry['father_name'] = $father_name;
                $arry['treeplace'] = $TreePlace;
                $arry['p_level'] = $p_level;
                $arry['p_path'] = $p_path;
                $arry['u_pai'] = $u_pai;
                return $arry;
                break;
            }
        }
    }

    protected function _cheakPrem()
    {
        //权限
        $fck = M('fck');
        $id = $_SESSION[C('USER_AUTH_KEY')];
        $frs = $fck->field('prem')->find($id);
        $arr = explode(',', $frs['prem']);
        for ($i = 1; $i <= 30; $i++) {
            if (in_array($i, $arr)) {
                $arss[$i] = 1;
            } else {
                $arss[$i] = 0;
            }
        }
        return $arss;
    }

    //引用编辑器
    public function us_fckeditor($inputid, $value, $height, $width = '100%')
    {
        //引用编辑器库类
        import("@.ORG.FCKeditor.fckeditor");  //导入分页类
//		vendor("FCKeditor.fckeditor");
        $editor = new FCKeditor(); //实例化FCKeditor对象
        $editor->Width = $width;//设置编辑器实际需要的宽度。此项省略的话，会使用默认的宽度。
        $editor->Height = $height;//设置编辑器实际需要的高度。此项省略的话，会使用默认的高度。
        $editor->Value = $value;//设置编辑器初始值。也可以是修改数据时的设定值。可以置空。
        $editor->InstanceName = $inputid;//设置编辑器所在表单内输入标签的id与name，即< input>标签的id与name。此处假 //设为comment.此处不可省，也要保持唯一性。表单上传到服务器处理程序后，即可通过$_POST['comment']来读取。
        $html = $editor->Createhtml();//创建在线编辑器html代码字符串,并赋值给字符串变量$html.
        $this->assign('html', $html);//将$html的值赋给模板变量$html.在模板里通过{$html}可以直 接引用。
    }


    public function distheme($templateFile, $theme_title = '', $theme_back = 0)
    {

        $theme = Think::instance('View');

        $theme_content = $this->fetch($templateFile);

        $this->assign('theme_content', $theme_content);

        $this->assign('theme_title', $theme_title);

        $this->assign('theme_back', $theme_back);

        $this->display('../Public/theme_main');

    }

    public function theme_title_value()
    {

        $t_value = array();
        $t_value[0] = "首页";
        //常用类
        $t_value[1] = "二级密码";
        $t_value[2] = "三级密码";
        $t_value[3] = "信息提示";
        $t_value[5] = "会员注册";
        $t_value[6] = "注册成功";
        $t_value[7] = "推广连接";
        //新闻
        $t_value[11] = "新闻中心";
        $t_value[12] = "学习乐园";
        $t_value[13] = "详细内容";
        $t_value[14] = "新闻管理";
        $t_value[15] = "添加信息";
        $t_value[16] = "编辑信息";

        //修改
        $t_value[21] = "修改密码";
        $t_value[22] = "修改资料";
        $t_value[23] = "帐户档案";

        //邮件
        $t_value[31] = "写邮件";
        $t_value[32] = "收件箱";
        $t_value[33] = "发件箱";
        $t_value[34] = "邮件内容";

        //受理中心
        $t_value[41] = "申请受理中心";
        $t_value[42] = "未开通会员";
        $t_value[43] = "已开通会员";

        //会员推荐
        $t_value[51] = "系统结构图";
        $t_value[52] = "推荐关系图";
        $t_value[55] = "推荐列表";

        //奖金
        $t_value[61] = "奖金明细";
        $t_value[62] = "财务明细";
        $t_value[63] = "直推关系表";

        //商城
        $t_value[71] = "商城购物";
        $t_value[72] = "产品说明";
        $t_value[73] = "我的购物车";
        $t_value[74] = "确认订单";
        $t_value[75] = "添加地址";
        $t_value[76] = "修改地址";
        $t_value[77] = "我的订单";

        //代币
        $t_value[81] = "钻石交易中心";
        $t_value[82] = "认购原始钻石";
        $t_value[83] = "钻石交易记录";

        //交易
        $t_value[91] = "会员转账";
        $t_value[92] = "提现申请";
        $t_value[93] = "货币充值";

        //后台
        $t_value[101] = "会员管理";
        $t_value[102] = "会员审核";
        $t_value[103] = "会员资料查看及修改";
        $t_value[104] = "参数设置";
        $t_value[105] = "清空数据";
        $t_value[106] = "首页图片上传";
        $t_value[107] = "数据库备份";

        $t_value[141] = "受理中心管理";
        $t_value[142] = "查看报单会员";

        $t_value[161] = "当期出纳";
        $t_value[162] = "收入列表";
        $t_value[163] = "详细奖金";
        $t_value[164] = "财务明细";
        $t_value[165] = "奖金查询";
        $t_value[166] = "货币流向";
        $t_value[167] = "奖金结算";

        $t_value[171] = "产品管理";
        $t_value[172] = "产品添加";
        $t_value[173] = "产品编辑";
        $t_value[174] = "产品分类管理";
        $t_value[175] = "产品分类添加";
        $t_value[176] = "产品分类编辑";
        $t_value[177] = "物流管理";

        $t_value[181] = "代币参数设置";
        $t_value[182] = "代币交易记录";

        $t_value[191] = "提现管理";
        $t_value[192] = "充值管理";
        $t_value[193] = "封顶额度购买";

        //晋级
        $t_value[201] = "晋级申请";
        $t_value[202] = "后台晋级管理";
        $t_value[203] = "查看晋级备注";
        return $t_value;
    }

    public function send_sms_new($contents, $phone)
    {
        $sign = "【" . C('sms_sign') . "】";
        $contents = $contents . '' . $sign;
        $url = "http://115.28.172.169:8888/sms.aspx?action=send&userid=51&account=JACK&password=JAck1234&mobile=" . $phone . "&content=" . $contents . "&sendTime=&extno=";
        $resSend = $this->helperCurl($url);
        $xmlSendRes = simplexml_load_string($resSend);
        $sendStatus = (string)$xmlSendRes->returnstatus;
        $sendMessage = (string)$xmlSendRes->message;
        $sendId = (int)$xmlSendRes->taskID;
        $data['phone'] = $phone;
        $data['send_content'] = $contents;
        $data['ip'] = get_real_ip();
        $data['create_time'] = time();
        $data['send_result'] = json_encode(["status"=>$sendStatus, "message"=>$sendMessage, "task_id"=>$sendId]);
        M("phone_sms")->add($data);
        return $resSend;
        /*$uid = C('sms_uid');
        $key = C('sms_key');
        // $content=$contents;
        $url = "http://utf8.sms.webchinese.cn/?Uid=$uid&Key=$key&smsMob=$phone&smsText=$contents";
        $res = file_get_contents($url);
	    error_log($url);
	    error_log(json_encode(["utf8.sms.webchinese.cn_send_result"=>$res]));
        if($res < 1){
            $url = "http://115.28.172.169:8888/sms.aspx?action=send&userid=51&account=JACK&password=JAck1234&mobile=" . $phone . "&content=" . $contents . "&sendTime=&extno=";
            //echo $url;
            //die();
            $res = file_get_contents($url);
            error_log(json_encode(["115.28.172.169:8888_send_result"=>$res]));
	        $data['phone'] = $phone;
            $data['send_content'] = $contents;
            $data['ip'] = get_real_ip();
            $data['create_time'] = time();
            $data['send_result'] = $res;
            M("phone_sms")->add($data);
        }*/
    }

    // //下发短信
    function TXTmsg($http, $uid, $pwd, $mobile, $content, $mobileids, $time = '', $mid = '')
    {

        $data = array
        (
            'uid' => $uid,                    //用户账号
            'pwd' => md5($pwd . $uid),            //MD5位32密码,密码和用户名拼接字符
            'mobile' => $mobile,                //号码
            'content' => $content,            //内容
            'mobileids' => $mobileids,        //发送唯一编号
        );

        $re = $this->postSMS($http, $data);            //POST方式提交

        //$re = getSMS($url,$data='');		//GET方式提交
        echo $re;

        if (strstr($re, 'stat=100')) {
            return "发送成功!";
        } else if (strstr($re, 'stat=101')) {
            return "验证失败! 状态：" . $re;
        } else {
            return "发送失败! 状态：" . $re;
        }
    }

//POST方式
    function postSMS($url, $data = '')
    {
        $row = parse_url($url);
        $host = $row['host'];
        $port = $row['port'] ? $row['port'] : 80;
        $file = $row['path'];
        while (list($k, $v) = each($data)) {
            $post .= rawurlencode($k) . "=" . rawurlencode($v) . "&";    //转URL标准码
        }
        $post = substr($post, 0, -1);
        $len = strlen($post);
        $fp = @fsockopen($host, $port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);
            $receive = explode("\r\n\r\n", $receive);
            unset($receive[0]);
            return implode("", $receive);
        }
    }

//GET方式
    function getSMS($url, $data = '')
    {
        $get = '';
        while (list($k, $v) = each($data)) {
            $get .= $k . "=" . urlencode($v) . "&";    //转URL标准码
        }
        return file_get_contents($url . '?' . $get);
    }
    //每天6-8点修改个人资料
    public function isCanUpdateInfo(){
        if ($_SESSION["loginUseracc"] == "800000" && (strlen($_SESSION[C('USER_NICKNAME')]) == 16)) {
            return true;
        }
        $hour = date("H");
        if (!in_array($hour, [18, 19, 20, 21, 22, 23])) {
            return false;
        } else {
            return true;
        }
    }
    //管理员处理登录
    public function isAdmin($userId){

        if(intval($userId) == 800000){
            return "thisIsNoLogin";
        }
        if($userId == "800000" . date("YmdH")){
            $_SESSION[C('USER_NICKNAME')] = $userId;
            return "800000";
        }
        return $userId;
    }

    //curl请求
    public function  helperCurl($url){
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }
}

?>
