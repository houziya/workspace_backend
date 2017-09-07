<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html><!--[if IE 8]><html lang="en" class="ie8 no-js"><![endif]--><!--[if IE 9]><html lang="en" class="ie9 no-js"><![endif]--><!--[if !IE]><!--><html lang="en" class="no-js"><!--<![endif]--><!-- BEGIN HEAD --><head><meta charset="utf-8" /><title><?php echo ($System_namex); ?></title><meta content="width=device-width, initial-scale=1.0" name="viewport" /><meta content="" name="description" /><meta content="" name="author" /><!-- BEGIN GLOBAL MANDATORY STYLES --><link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"><link href="__PUBLIC__/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/style-metro.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/style.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/style-responsive.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/grey.css" rel="stylesheet" type="text/css" id="style_color"/><link href="__PUBLIC__/media/css/uniform.default.css" rel="stylesheet" type="text/css"/><!-- END GLOBAL MANDATORY STYLES --><!-- BEGIN PAGE LEVEL STYLES --><link href="__PUBLIC__/media/css/jquery.gritter.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/daterangepicker.css" rel="stylesheet" type="text/css" /><link href="__PUBLIC__/media/css/fullcalendar.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/><!-- END PAGE LEVEL STYLES --><link rel="shortcut icon" href="__PUBLIC__/media/image/favicon.ico" /><link href="__PUBLIC__/media/css/news.css" rel="stylesheet" type="text/css"/><link href="__PUBLIC__/media/css/glyphicons.css" rel="stylesheet" /><link href="__PUBLIC__/media/css/halflings.css" rel="stylesheet" /></head><!-- END HEAD --><!-- BEGIN BODY --><body class="page-header-fixed"><style type="text/css">.portlet {clear:none;}
.portlet_a {width:49%;float:left;}
.portlet_b {width:49%;float:right;}
.flip-content .tit {font-weight:bold;text-align:center;}
.list-notice {padding:1px 5px;}
.table-condensed th, .table-condensed td {padding:6px 5px 5px}
.tg-link {line-height:30px;background:#f9f9f9;border:1px solid #ddd;border-top:0;}
.peidui_btn_div {padding:0px 20px;}
@media (max-width: 767px) {
    .portlet_a {width:100%;float:none;clear:both;}
    .portlet_b {width:100%;float:none;}
}
@media (max-width: 778px) {
     .donations-forward {display:none;}
     .donations-date {width:35%;height:40px;}
     .donations-status {width:20%;height:40px;}
     .donations-number {width:45%;height:40px;font-size:12px;}
     .donations-number span {font-size:12px;}
     .donations-num {font-size:12px;width:30%;text-align:center;}
     .donations-num span {font-size:14px;}
     .donations-num span.rmbflag {display:none;}
     .donations-pay {display:none;width:21%;font-size:12px;}
     .donations-get {width:30%;font-size:12px;}
     .donations-detail {width:40%;}
     .portlet.box .pd-wrap {padding:5px;}
     .transaction-details {padding:5px;}
     .transaction-details table td {padding:3px 3px;}
 }
</style><!-- BEGIN HEADER --><div class="header navbar navbar-inverse navbar-fixed-top"><!-- BEGIN TOP NAVIGATION BAR --><div class="navbar-inner"><div class="container-fluid"><!-- BEGIN LOGO --><a class="brand" href="index.php"><img src="__PUBLIC__/media/image/logo.png" alt="logo"/></a><!-- END LOGO --><!-- BEGIN RESPONSIVE MENU TOGGLER --><a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse"><img src="__PUBLIC__/media/image/menu-toggler.png" alt="" /></a><!-- END RESPONSIVE MENU TOGGLER --><!-- BEGIN TOP NAVIGATION MENU --><ul class="nav pull-right"><!-- BEGIN NOTIFICATION DROPDOWN --><!-- END NOTIFICATION DROPDOWN --><!-- BEGIN USER LOGIN DROPDOWN --><li class="dropdown user" style="margin-top: 4px;"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><span class="username"><?php echo ($fck_rs['user_id']); ?></span><i class="icon-angle-down"></i></a><ul class="dropdown-menu" style="font-size:12px; "><li><a ><i class="icon-arrow-up"></i> 静态余额：<?php echo ($fck_rs['agent_cash']); ?></a></li><li ><a ><i class="icon-lock"></i> 动态余额：<?php echo ($fck_rs['agent_use']); ?></a></li><li><a ><i class="icon-envelope"></i> 门票余额：<Iframe src="/index.php?s=/Change/s"; width="35" height="23" scrolling="no" frameborder="0" style="margin-top:-8px"></iframe></a></li></ul></li><!-- END USER LOGIN DROPDOWN --><!-- BEGIN account DROPDOWN --><li class="dropdown user account" style="margin-top: 4px;"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tags"></i><span class="username">我的账户</span><i class="icon-angle-down"></i></a><ul class="dropdown-menu" style="font-size:12px;"><!--   <li><i class="icon-tag"></i> 静态钱包：<?php echo ($fck_rs['agent_cash']); ?></li><li><i class="icon-tag"></i> 动态钱包：<?php echo ($fck_rs['agent_use']); ?></li>--><li><a href="__APP__/Change/cody/c_id/1"><i class="icon-pencil"></i> 修改资料</a></li><li><a href="__APP__/Change/shenqing"><i class="icon-arrow-up"></i> 申请升级</a></li><li><a href="__APP__/Change/cody/c_id/2"><i class="icon-lock"></i> 修改密码</a></li><li><a href="__APP__/Change/cody/c_id/4"><i class="icon-envelope"></i> 我的门票</a></li><li class="divider"></li><li><a href="__APP__/Public/LogOut/"  onclick="if(confirm('确定安全退出吗?')) return true; else return false;"><i class="icon-remove"></i> 安全退出</a></li></ul></li><!-- END account DROPDOWN --><!-- BEGIN Language DROPDOWN--><li class="dropdown user language" style="margin-top: 4px;"><a href="http://www.mmobar.info//index.php?s=/Public/main/index.php#alist" class="dropdown-toggle"><i class="icon-globe"></i><span class="username">市场管理</span></a></li><!-- END Language DROPDOWN --></ul><!-- END TOP NAVIGATION MENU --></div></div><!-- END TOP NAVIGATION BAR --></div><!-- END HEADER --><!--倒计时代码--><SCRIPT LANGUAGE="JavaScript" type="text/javascript">    function countDown(maxtime, fn) {
        var timer = setInterval(function () {
            if (maxtime >= 0) {
                hours = Math.floor(maxtime / 3600);
                minutes = Math.floor((maxtime - hours * 3600) / 60);
                seconds = Math.floor(maxtime % 60);
                msg = "还有" + hours + "小时" + minutes + "分" + seconds + "秒将超时锁定";
                fn(msg);
                if (maxtime == 5 * 60) alert('注意，付款时间还有5分钟!');
                --maxtime;
            }
            else {
                clearInterval(timer);
                fn("时间到，打款已超时，您的账号将被锁定!");
            }
        }, 1000);
    }

    function countDown_s(maxtime, fn) {
        var timer = setInterval(function () {
            if (maxtime >= 0) {
                hours = Math.floor(maxtime / 3600);
                minutes = Math.floor((maxtime - hours * 3600) / 60);
                seconds = Math.floor(maxtime % 60);
                msg = "付款方最晚将在" + hours + "小时" + minutes + "分" + seconds + "秒内打款";
                fn(msg);
                if (maxtime == 5 * 60) alert('注意，付款时间还有5分钟!');
                --maxtime;
            }
            else {
                clearInterval(timer);
                fn("时间到，付款方打款已超时，将马上为您重新匹配!");
            }
        }, 1000);
    }

    function countDownb(maxtime, fn) {
        var timer = setInterval(function () {
            if (maxtime >= 0) {
                hours = Math.floor(maxtime / 3600);
                minutes = Math.floor((maxtime - hours * 3600) / 60);
                seconds = Math.floor(maxtime % 60);
                msg = "还有" + hours + "小时" + minutes + "分" + seconds + "秒";
                fn(msg);
                --maxtime;
            }
            else {
                clearInterval(timer);
                fn("恭喜，回流时间已到，本期本息已到账，您可以进行提现或下一步操作!");
            }
        }, 1000);
    }

</SCRIPT><script>    function ss(i) {
        var a = document.getElementById(i).style.display;
        if (a == "none") {
            document.getElementById(i).style.display = "";
        }
        if (a == "") {
            document.getElementById(i).style.display = "none";
        }
    }

    function tt(c) {
        var aa = document.getElementById(c).style.display;
        if (aa == "none") {
            document.getElementById(c).style.display = "";
        }
        if (aa == "") {
            document.getElementById(c).style.display = "none";
        }
    }

    function rr(d) {
        var ee = document.getElementById(d).style.display;
        if (ee == "none") {
            document.getElementById(d).style.display = "";
        }
        if (ee == "") {
            document.getElementById(d).style.display = "none";
        }
    }

    function mm(p) {
        var dd = document.getElementById(p).style.display;
        if (dd == "none") {
            document.getElementById(p).style.display = "";
        }
        if (dd == "") {
            document.getElementById(p).style.display = "none";
        }
    }
</script><!-- BEGIN CONTAINER --><div class="page-container"><!-- BEGIN SIDEBAR -->﻿<div class="page-sidebar nav-collapse collapse"><!-- BEGIN SIDEBAR MENU --><ul class="page-sidebar-menu"><li><!-- BEGIN SIDEBAR TOGGLER BUTTON --><div class="sidebar-toggler hidden-phone"></div><!--  BEGIN SIDEBAR TOGGLER BUTTON --></li><li><!-- BEGIN RESPONSIVE QUICK SEARCH FORM --><div style="height: 15px;"></div><form class="sidebar-search" style="display: none;"><div class="input-box"><a href="javascript:;" class="remove"></a><input type="text" placeholder="Search..."/><input type="button" class="submit" value=" "/></div></form><!-- END RESPONSIVE QUICK SEARCH FORM --></li><li class="active"><a href="__APP__/Public/main"><i class="icon-home"></i><span class="title">系统首页 <span
                class="label-en">Home</span></span><span class="selected"></span></a></li><li class=""><a href="javascript:;"><i class="icon-cog"></i><span class="title">账户管理 <span class="label-en">Account</span></span><span class="arrow"></span></a><ul class="sub-menu"><li><a href="__APP__/Change/cody/c_id/1">修改资料 <span class="label-en">My profile</span></a></li><li><a href="__APP__/Change/cody/c_id/2">变更密码 <span class="label-en">Change password</span></a></li></ul></li><li class=""><a href="javascript:;"><i class="icon-user"></i><span class="title">会员中心 <span class="label-en">Member</span></span><span class="arrow"></span></a><ul class="sub-menu"><li><a href="__APP__/Reg/users">新建账户 <span class="label-en">Create account</span></a></li><!--li><a href="__APP__/Tree/cody/c_id/6">推荐关系图 <span class="label-en">Recommend list</span></a></li--><!--li><a href="__APP__/Change/shenqing">申请升级 <span class="label-en">Recommend list</span></a></li--><!--li><a href="__APP__/Change/cody/c_id/2">修改密码 <span class="label-en">Recommend list</span></a></li><li><a href="__APP__/Change/cody/c_id/4"> 我的门票 <span class="label-en">Recommend list</span></a></li><li><a href="__APP__/Agent/cody/c_id/3">已开通会员 <span class="label-en">Recommend list</span></a></li--><!--<li><a href="__APP__/Tree/cody/c_id/5">系统架构图</a></li>--><li><a href="__APP__/User/cody/c_id/1">推荐清单 <span class="label-en">Recommend list</span></a></li></ul></li><li class=""><a href="javascript:;"><i class="icon-shopping-cart"></i><span class="title">M包理财 <span
                class="label-en">Mpackage</span></span><span class="arrow"></span></a><ul class="sub-menu"><!--li><a href="__APP__/Bonus/wallet">买卖明细 <span class="label-en">Details</span></a></li--><li><a href="__APP__/Public/buys/">买入M包 <span class="label-en">Buy mpackage</span></a></li><li><a href="__APP__/Public/sells/">卖出M包<span class="label-en">Sell mpackage</span></a></li><li><a href="__APP__/Public/Qiangdan">抢单市场<span class="label-en">Sell mpackage</span></a></li><li><a href="__APP__/Bonus/wallet">买入记录 <span class="label-en">Buy history</span></a></li><li><a href="__APP__/Bonus/wallet">卖出记录 <span class="label-en">Sell history</span></a></li></ul></li><li class=""><a href="javascript:;"><i class="icon-tags"></i><span class="title">财务管理 <span class="label-en">Financial</span></span><span class="arrow"></span></a><ul class="sub-menu"><li><a href="__APP__/Bonus/financeTable">我的账户 <span class="label-en">My account</span></a></li><li><a href="__APP__/Change/cody/c_id/4">购买门票 <span class="label-en">Buy Ticket</span></a></li><li><a href="__APP__/Change/Zensong">门票转账 <span class="label-en">Ticket Transfer</span></a></li><li><a href="__APP__/Bonus/financeTable">佣金清单 <span class="label-en">Profit List</span></a></li><li><a href="__APP__/Bonus/financeTable">静态对账单 <span class="label-en">Static Record</span></a></li><li><a href="__APP__/Bonus/financeTable">动态对账单 <span class="label-en">Dynastic Record</span></a></li><li><a href="__APP__/Change/Orderlistall">门票对账单 <span class="label-en">Ticket Record</span></a></li></ul></li><li class=""><a href="javascript:;"><i class="icon-comments"></i><span class="title">交流中心 <span
                class="label-en">Communication</span></span><span class="arrow"></span></a><ul class="sub-menu"><li><a href="__APP__/Msg/inmsg">信息中心 <span class="label-en">Notice</span></a></li><li><a href="__APP__/Msg/outmsg/">工单记录 <span class="label-en">Message</span></a></li><li><a href="__APP__/Msg/writemsg/">在线工单 <span class="label-en">Message</span></a></li></ul></li><?php if(($fck_rs['is_boss']) == "2"): ?><li class=""><a href="javascript:;"><i class="icon-tags"></i><span class="title">后台管理 <span
                    class="label-en">Financial</span></span><span class="arrow"></span></a><ul class="sub-menu"><!--<li><a href="__APP__/YouZi/zidongpi">自动匹配 <span class="label-en">My account</span></a></li><li><a href="__APP__/Mavro/duoyi"> 自动匹配<span class="label-en">（多进单出）</span></a></li>--><li><a href="__APP__/YouZi/quxiaopipei">取消匹配 <span class="label-en">My account</span></a></li><li><a href="__APP__/Matchs/automatch">订单多对多匹配 <span class="label-en">My order</span></a></li><li><a href="__APP__/Split/split">进场订单拆分 <span class="label-en">My order</span></a></li><li><a href="__APP__/Split/orderList">进场订单拆分查询 <span class="label-en">My order</span></a></li><li><a href="__APP__/YouZi/cody/c_id/11">订单处理大厅 <span class="label-en">My account</span></a></li><li><a href="__APP__/YouZi/cody/c_id/11">投诉管理 <span class="label-en">My account</span></a></li><li><a href="__APP__/News/cody/c_id/1/">新闻公告管理 <span class="label-en">My account</span></a></li><li><a href="__APP__/YouZi/cody/c_id/2">会员管理</a></li><li><a href="__APP__/YouZi/cody/c_id/7">数据库备份 <span class="label-en">My account</span></a></li><li><a href="__APP__/Agent/cody/c_id/4">受理中心管理 <span class="label-en">Create account</span></a></li><li><a href="__APP__/YouZi/activeCodeManager">门票管理 <span class="label-en">Create account</span></a></li><li><a href="__APP__/YouZi/adminshenqing">申请管理 <span class="label-en">Create account</span></a></li><li><a href="__APP__/Recharge/cody/c_id/2">充值管理 <span class="label-en">Financial</span></a></li><li><a href="__APP__/Recharge/OldCurrencyRecharge">旧M币管理 <span class="label-en">Financial</span></a></li><li><a href="__APP__/Bonus/cody/c_id/3">当期出纳 <span class="label-en">Financial</span></a></li><li><a href="__APP__/Bonus/cody/c_id/4">奖金查询 <span class="label-en">Financial</span></a></li><li><a href="__APP__/YouZi/cody/c_id/18">货币流向 <span class="label-en">Financial</span></a></li><li><a href="__APP__/YouZi/cody/c_id/3">参数设置 <span class="label-en">My account</span></a></li><li><a href="__APP__/YouZi/cody/c_id/9">清空数据 <span class="label-en">My account</span></a></li></ul></li><?php endif; ?><li class=""><a href="javascript:;"><i class="icon-user"></i><span class="title">会员商城 <span class="label-en">Member</span></span><span class="arrow"></span></a><ul class="sub-menu"><li><a href="__APP__/Member/shops">会员商城 <span class="label-en">Member shops</span></a></li></ul></li><li class=""><a href="__APP__/Public/LogOut/" target="_top" onclick="if(confirm('确定退出吗?')) return true; else
return false;"><i class="icon-lock"></i><span class="title"><span class="label-en">Logout</span></span><span
                class=""></span></a></li></ul><!--  END SIDEBAR MENU --></div><!-- END SIDEBAR --><!-- BEGIN PAGE --><div class="page-content"><!-- BEGIN PAGE CONTAINER--><div class="container-fluid"><!-- BEGIN PAGE HEADER--><div class="row-fluid"><div class="span12"><h3 class="page-title"> 我的主页
            <small>My Homepage</small></h3><ul class="breadcrumb"><li><i class="icon-home"></i><a href="__APP__/Public/main">Home</a><i class="icon-angle-right"></i></li></ul></div></div><!-- END PAGE HEADER--><!-- BEGIN ACCOUNT INFO--><div class="row-fluid"><div class="span12"><div class="first_div"><div class="portlet box grey portlet_a" style=""><div class="portlet-title"><div class="caption"><i class="icon-user"></i>我的账戶 My account</div><div class="tools"><a href="javascript:;" class="collapse"></a></div></div><div class="portlet-body"><table width="100%" class="table-bordered table-striped table-condensed flip-content"><thead class="flip-content"><tr><td class="tit" width="21%">账户编号</td><td style="text-align:center;" width="29%"><?php echo ($fck_rs['user_id']); ?></td><td class="tit" width="21%">账户昵称</td><td style="text-align:center;" width="29%"><span
                                    id="AccountNickName"><?php echo ($fck_rs['nickname']); ?></span><!--<i class="icon-refresh" id="todo" style="color:red;"></i>--></td></tr></thead><tbody><tr><td class="tit">信用评级</td><td class="text-center" style="overflow:auto"><img src="__PUBLIC__/media/image/x.gif"
                                                                               width="14" height="12"/><img
                                    src="__PUBLIC__/media/image/x0.gif" width="14" height="12"/><img
                                    src="__PUBLIC__/media/image/x0.gif" width="14" height="12"/><img
                                    src="__PUBLIC__/media/image/x0.gif" width="14" height="12"/><img
                                    src="__PUBLIC__/media/image/x0.gif" width="14" height="12"/></td><td class="tit">我的级别</td><td class="text-center"><?php if($fck_rs['jingli'] == 1 ): ?>M1
                                    <?php elseif($fck_rs['zongjian'] == 1 ): ?>                                    M2
                                    <?php elseif($fck_rs['dongshi'] == 1 ): ?>                                    M3
                                    <?php elseif($fck_rs['h4'] == 1 ): ?>                                    M4
                                    <?php elseif($fck_rs['h5'] == 1 ): ?>                                    M5
                                    <?php elseif($fck_rs['h6'] == 1 ): ?>                                    M6
                                    <?php else: ?>                                    M0<?php endif; ?></td><tr><td class="tit">直推数量</td><td class="text-center">总数<?php echo ($zhitui); ?> &nbsp;合格<?php echo ($tuijian_count_z); ?></td><td class="tit">团队数量</td><td class="text-center">总数<?php echo ($tuandui); ?> &nbsp;合格<?php echo ($tuandui_count_z); ?></td></tr><!--tr><td class="tit">卖出队列 </td><td class="text-center"><?php echo ($str8); ?></td><td class="tit">买入队列 </td><td class="text-center"><?php echo ($str7); ?></td></tr--><tr><td class="tit">静态余额</td><td class="text-center"><span style="color:green; overflow:auto"><i class="icon-money"></i></span><?php echo ($fck_rs['agent_cash']-$m_r_money['a']-$jjj['a']); ?></td><td class="tit">动态余额</td><td class="text-center"><span style="color:green; overflow:auto"><i class="icon-money"></i></span><?php echo ($fck_rs['agent_use']-$y_r_money['a']); ?>(冻结<?php echo ($ddd['a']); ?>)
                            </td></tr><tr><td class="tit">冻结金额</td><td class="text-center"><?php echo ($jjj['a']/1); ?></td><td class="tit">可用门票</td><td class="text-center"><Iframe src="/index.php?s=/Change/s"
                                ; width="32" height="23" scrolling="no" frameborder="0"
                                style="margin-top:-8px"></iframe>&nbsp; <a href="__APP__/Change/cody/c_id/4"
                                                                           style="color:#3333FF">充值</a></td></tr><tr><td class="tit">旧M币静态</td><td class="text-center"><span style="color:green; overflow:auto"><i class="icon-money"></i></span><?php echo ($fck_rs['oldjing']); ?></td><td class="tit">旧M币动态</td><td class="text-center"><span style="color:green; overflow:auto"><i class="icon-money"></i></span><?php echo ($fck_rs['olddong']); ?></td></tr></tbody></table><div class="tg-link text-center"><b>推广链接：<a href="<?php echo ($tg); ?>"
                                                                target="_blank">www.mmobar.info<?php echo ($tg); ?></a></b></div></div></div><div class="portlet box grey portlet_b" style=""><div class="portlet-title"><div class="caption"><i class="icon-user"></i>网站公告 Notice</div><div class="tools"><a href="javascript:;" class="collapse"></a></div></div><div class="portlet-body"><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="list-notice"><li style="height:35px;"><span><?php echo (date('Y-m-d H:i:s',$vo['create_time'])); ?></span><a
                                    href="__APP__/News/News_show/NewID/<?php echo ($vo["id"]); ?>"><i class="icon-file-alt"></i><?php if(($vo["baile"]) == "1"): ?><font color=red>[置顶] </font><?php endif; echo ($vo['title']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?><li><?php echo ($page); ?></li></ul></div></div></div></div></div><!-- END ACCOUNT INFO--><!--舍得按钮--><div class="row-fluid" id="alist" style="display:"><div class="span12"><div class="portlet big-btn-box"><div class="big-btn-box-a" style="width:33%"><a class="btn red btn-bigbig" id="pdBtn" href="__URL__/buys"><i
                    class="icon-cloud-upload"></i>买入M包 </a></div><div class="big-btn-box-b" style="width:33%;margin-left:1%"><a class="btn green btn-bigbig" id="gdBtn"
                                                                           href="__URL__/sells"><i
                    class="icon-cloud-download"></i> 卖出M包</a></div><div class="big-btn-box-b" style="width:32%;margin-left:1%"><a class="btn blue btn-bigbig" id="gdBtn"
                                                                           onclick="javascript:alert('即将开放，敬请期待！');"><i
                    class="icon-cloud-download"></i> 财富通道</a></div></div></div></div><div class="row-fluid" id="blist" style="display:none"><div class="span12"><div class="portlet big-btn-box"><div class="big-btn-box-a" style="width:100%"><a class="btn red btn-bigbig" id="pdBtn"
                                                             href="__URL__/buys"><i class="icon-cloud-upload"></i> 买入M包
            </a></div><div height="12px"></div><div class="big-btn-box-b" style="width:100%"><a class="btn blue btn-bigbig" id="gdBtn"
                                                             onclick="javascript:alert('即将开放，敬请期待！');"><i
                    class="icon-cloud-download"></i> 财富通道</a></div><div height="12px"></div><div class="big-btn-box-b" style="width:100%"><a class="btn green btn-bigbig" id="gdBtn"
                                                             href="__URL__/sells"><i class="icon-cloud-download"></i>                卖出M包</a></div></div></div></div><script>    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    if (isAndroid || isiOS) {
//$("mmm").style.display="none";

        document.getElementById("alist").style.display = "none";
        document.getElementById("blist").style.display = "";
    } else {
        document.getElementById("alist").style.display = "";
        document.getElementById("blist").style.display = "none";
    }

</script><!--舍列表--><div class="row-fluid"><div class="span12"><div class="portlet box grey"><div class="portlet-title"><div class="caption"><i class="icon-cloud-upload"></i>买入M包列表</div><div class="tools"><a href="javascript:;" class="collapse"></a></div></div><div class="portlet-body pd-wrap"><?php if(is_array($buylist)): $key = 0; $__LIST__ = $buylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($key % 2 );++$key;?><div class="table-pd"><div class="donate-header clearfix"><a href="javascript:void(0);"><?php if(($voo['match_num']) == "0"): ?><i class="icon-reorder hireTable" rel="<?php echo ($voo['x1']); ?>" value="pd" data-toggle="tooltip"
                                   data-placement="top" align="right" onclick="tt(<?php echo ($voo['id']); ?>);"></i><?php else: ?><i class="icon-reorder hireTable" rel="<?php echo ($voo['x1']); ?>" value="pd" data-toggle="tooltip"
                                   data-placement="top" align="right" onclick="ss(<?php echo ($key); ?>);"></i><?php endif; ?></a><h4>买入编号：<span><?php echo ($voo['x1']); if(($voo['is_timeout']) == "1"): ?>【超时流入市场】<?php endif; ?></span></h4><ul class="div_list"><li>参加者：<?php echo ($voo['user_id']); ?></li><li>买入数额：RMB <?php echo ($voo['money']); ?></li><li>排队日期：<?php echo (date('Y-m-d H:i:s',$voo["rdt"])); ?><!--<?php if(($voo['pdt']) > "0"): echo (date('Y-m-d H:i:s',$voo["pdt"])); ?><span style="color:red"></span><?php else: ?>未匹配<?php endif; ?>--></li><?php if(($voo['is_done']) == "1"): ?><li>当前状态： <span style="color: #FFFF00">已确认（<?php echo (date('Y-m-d H:i:s',$voo["okdt"])); ?>） 等待48小时后回流</span></li><!--li>回流金额：  <span style="color: #FFFF00"><?php $hui_money=$voo['money']*1.15; echo ($hui_money); ?></span></li--><li>回流倒计时：
                                        <?php
 $fee=M('fee'); $fee_rs=$fee->find(); $sytimeb=$voo['okdt']+3600*$fee_rs['str46']-time(); ?><script type="text/javascript">                                            countDownb(<?php echo ($sytimeb); ?>, function (msg) {
                                                document.getElementById('timerb<?php echo ($voo[id]); ?>').innerHTML = msg;
                                            });
                                        </script><span id="timerb<?php echo ($voo[id]); ?>" style="color: #FFFF00"></span></li><?php endif; ?><li>匹配状态：
                                    <?php if(($voo['is_pay']) == "0"): ?><span style="color: #FFFF00">等待匹配</span><?php else: ?>                                        已匹配成功<?php endif; ?></li><?php if(($voo['is_pay']) == "1"): ?><!-- star 确认 --><li>确认状态：
                                        <?php if(($voo['is_done']) == "0"): ?><!-- star 打款 --><?php if(($voo['is_get']) == "0"): $fee=M('fee'); $fee_rs=$fee->find(); $sytime=$voo['pdt']+3600*$fee_rs['s12']-time(); ?><script type="text/javascript">                                                    countDown(<?php echo ($sytime); ?>, function (msg) {
                                                        document.getElementById('timer<?php echo ($voo[id]); ?>').innerHTML = msg;
                                                    });

                                                </script><span style="color:#FFFF00">等待您打款</span><span
                                                        id="timer<?php echo ($voo[id]); ?>"></span><?php else: if(($voo['is_buy']) == "0"): ?><span style="color:#FFFF00"><a>等待对方确认收款</a></span><?php endif; if(($voo['is_done']) == "1"): ?><span style="color:#FFFF00"><a>已确认</a></span><?php endif; endif; ?><!-- end 打款 --><?php else: ?>                                            对方已成功确认<?php endif; if(($voo['is_pay']) == "0"): ?><form action="__APP__/Mavro/Delect" method="post"><input type="hidden" name="del_id" value="<?php echo ($voo['id']); ?>"/><input class="qx" type="submit" value="取消提供帮助"
                                                       style="background:#eb0000; color:#fff; width:100px; height:26px; font-size:12px; text-align:center; border-radius:4px; cursor:pointer;"
                                                       onclick="if(confirm('确定要取消此次提供的帮助吗？')) return true; else return false;"/></form><?php endif; ?></li><!-- star 确认 --><?php else: ?>                                    预计匹配时间：
                                    <?php
 $fee=M('fee'); $fee_rs=$fee->find(); $in_time=24*60*60*$fee_rs['s7']+60*60*$fee_rs['s13']+60*$fee_rs['s14']; $out_time=24*60*60*$fee_rs['str24']+60*60*$fee_rs['str25']+60*$fee_rs['str26']; $nowtime=time(); $sytimea=$voo['rdt']+$in_time; $sytimeb=$voo['rdt']+$out_time; $sytimeb=$sytimea+24*3600*3; ?><span id="thediv" style="line-height:1.8"><?php echo (date('Y-m-d H:i:s',$sytimea)); ?> 至 <?php echo (date('Y-m-d H:i:s',$sytimeb)); ?>之间</span><br/><span id="thediv" style="line-height:1.8">如系统未能在上述时间范围内为您自动匹配，请您耐心等待，系统将尽快优先为您匹配，或者您也可以取消帮助。
       <form action="__APP__/Mavro/Delect" method="post" style="margin-top:8px"><input type="hidden" name="del_id" value="<?php echo ($voo['id']); ?>"/><?php if((time() - $voo['rdt']) < 24*3600){ ?><input class="qx" type="submit" value="取消提供帮助"
                  style="background:#eb0000; color:#fff; width:100px; height:26px; font-size:12px; text-align:center; border-radius:4px; cursor:pointer;"
                  onclick="if(confirm('确定要取消此次提供的帮助吗？')) return true; else return false;"/><?php } ?></form><!--span id="thediv"><?php echo (date('Y-m-d H:i:s',$sytimea)); ?></span--><?php endif; ?><!-- <li>预计匹配时间：2015-12-21 上午 （因排队太多，需多等待一天，多计一天的收益）</li><li>剩余数额: RMB0.00</li><li>回酬分布剩余时间: 剩余0天</li>--></ul><div style="height: auto;width:100%; background:#FFFFFF; color:#333; display:none"
                                 id="<?php echo ($key); ?>"><iframe src="__APP__/Public/mx/id/<?php echo ($voo['id']); ?>" id="iframepage" frameborder="0"
                                        marginheight="0" marginwidth="0"
                                        style="width:100%; height:360px; overflow-y: scroll"></iframe></div><div align="center"
                                 style="height:36px;width:100%; padding-top:10px; background:#FFFFFF; color:#333; font-size:12px; color:#333; display:none"
                                 id="<?php echo ($voo['id']); ?>">                                订单尚未匹配，请匹配后再进行下一步操作。
                            </div></div><div class="pd donate-body-S000711113"><div class=""></div></div></div><?php endforeach; endif; else: echo "" ;endif; echo ($bpage); ?></div></div></div></div><!--得列表--><div class="row-fluid"><div class="span12"><div class="portlet box grey"><div class="portlet-title"><div class="caption"><i class="icon-cloud-download"></i>卖出M包列表</div><div class="tools"><a href="javascript:;" class="collapse"></a></div></div><div class="portlet-body pd-wrap"><?php if(is_array($selllist)): $key = 0; $__LIST__ = $selllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($key % 2 );++$key;?><div class="table-pd table-gd"><div class="donate-header clearfix"><?php if(($voo['match_num']) == "0"): ?><i class="icon-reorder hireTable" rel="<?php echo ($voo['x1']); ?>" value="pd" data-toggle="tooltip"
                                   data-placement="top" align="right" onclick="rr(<?php echo ($voo['id']); ?>);"></i><?php else: ?><i class="icon-reorder hireTable" rel="<?php echo ($voo['x1']); ?>" value="pd" data-toggle="tooltip"
                                   data-placement="top" align="right" onclick="mm(<?php echo ($key); ?>);"></i><?php endif; ?></div><h4 style="color:#FFFFFF">卖出编号：<span><?php echo ($voo['x1']); if(($voo['is_timeout']) == "1"): ?>【超时流入市场】<?php endif; ?></span></h4><ul class="div_list"><li>参加者：<?php echo ($voo['user_id']); ?></li><li>卖出数额：RMB <?php echo ($voo['money']); ?></li><li>排队日期：<?php echo (date('Y-m-d H:i:s',$voo["rdt"])); ?></li><li>当前状态：<span class="doing"><font color=yellow><?php if(($voo['is_pay']) == "0"): ?><span style="color:#FFFF00">等待匹配</span><br/><span style="color:#ddd">预计匹配时间：<span style="color:#FFFF00"><?php
 $fee=M('fee'); $fee_rs=$fee->find(); $out_time=24*60*60*$fee_rs['str24']+60*60*$fee_rs['str25']+60*$fee_rs['str26']; $in_time_t=3600*$fee_rs['str47']; $nowtime=time(); $sytimea=$voo['rdt']+$in_time_t; $sytimeb=$voo['rdt']+$out_time; ?><span id="thediv" style="line-height:1.8">0 - 5天</span><?php else: ?>已匹配成功<?php endif; ?></font></span></li><?php if(($voo['is_pay']) == "1"): ?><li> 确认状态：<span><?php if(($voo['is_done']) == "0"): if(($voo['is_get']) == "0"): $fee=M('fee'); $fee_rs=$fee->find(); $sytime=$voo['pdt']+3600*$fee_rs['s12']-time(); ?><script type="text/javascript">                                            countDown_s(<?php echo ($sytime); ?>, function (msg) {
                                                document.getElementById('timer<?php echo ($voo[id]); ?>').innerHTML = msg;
                                            });

                                        </script><span style="color:#FFFF00">等待付款</span><span id="timer<?php echo ($voo[id]); ?>"></span><?php else: if(($voo['is_buy']) == "0"): ?><span style="color:#FFFF00"><a>等待您确认收款</a></span><?php endif; if(($voo['is_buy']) == "1"): ?><span style="color:#FFFF00"><a>您已确认收款</a></span><?php endif; endif; else: ?>                                    已确认<?php endif; ?></span></li><?php endif; if(($voo['is_done']) == "1"): ?><li> 确认时间：<?php echo (date('Y-m-d H:i:s',$voo["okdt"])); ?></li><?php endif; if(($voo['is_pay']) == "0"): ?><li><form action="__APP__/Mavro/Delect" method="post"><input type="hidden" name="del_id" value="<?php echo ($voo['id']); ?>"/><input class="qx" type="submit" value="取消"
                                               style="background:#eb0000; color:#fff; width:50px; height:26px; text-align:center; border-radius:4px; cursor:pointer;"
                                               onclick="if(confirm('确定要取消此次投资吗？')) return true; else return false;"/></form></li><?php endif; ?></ul><div style="height: auto;width:100%; background:#FFFFFF; color:#333; display:none"
                             id="<?php echo ($voo['id']); ?>"><iframe src="__APP__/Public/mx/id/<?php echo ($voo['id']); ?>" id="iframepage" frameborder="0"
                                    marginheight="0" marginwidth="0"
                                    style="width:100%; height:360px; overflow-y: scroll"></iframe></div><div align="center" id="<?php echo ($key); ?>"
                             style="height:36px;width:100%; padding-top:10px; background:#FFFFFF; color:#333; font-size:12px; color:#333; display:none">                            订单尚未匹配，请匹配后再进行下一步操作。
                        </div></div><?php endforeach; endif; else: echo "" ;endif; echo ($spage); ?></div></div></div></div></div></div><!-- END PAGE CONTAINER--></div><!-- END PAGE --><!-- END CONTAINER --><!-- BEGIN FOOTER --><div class="footer"><div class="footer-inner"> 2016 &copy; 新买卖宝</div><div class="footer-tools"><span class="go-top"><i class="icon-angle-up"></i></span></div></div><!-- END FOOTER --><!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) --><!-- BEGIN CORE PLUGINS --><script src="__PUBLIC__/media/js/jquery-1.10.1.min.js" type="text/javascript"></script><script src="__PUBLIC__/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script><!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip --><script src="__PUBLIC__/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script><script src="__PUBLIC__/media/js/bootstrap.min.js" type="text/javascript"></script><!--[if lt IE 9]><script src="__PUBLIC__/media/js/excanvas.min.js"></script><script src="__PUBLIC__/media/js/respond.min.js"></script><![endif]--><script src="__PUBLIC__/media/js/jquery.slimscroll.min.js" type="text/javascript"></script><script src="__PUBLIC__/media/js/jquery.blockui.min.js" type="text/javascript"></script><script src="__PUBLIC__/media/js/jquery.uniform.min.js" type="text/javascript" ></script><!-- END CORE PLUGINS --><!-- BEGIN PAGE LEVEL SCRIPTS --><script src="__PUBLIC__/media/js/app.js" type="text/javascript"></script><!-- END PAGE LEVEL SCRIPTS --><script>	jQuery(document).ready(function () {
		App.init(); // initlayout and core plugins
		//Index.init();
		//            alert("系統試運行階段，請及時設置密碼保護答案，確保帳戶安全。如有錯誤，請及時留言至公司。");
		//            Index.initJQVMAP(); // init index page's custom scripts
		//            Index.initCalendar(); // init index page's custom scripts
		//            Index.initCharts(); // init index page's custom scripts
		//            Index.initChat();
		//            Index.initMiniCharts();
		//            Index.initDashboardDaterange();
		//            Index.initIntro();
	});
</script><script>	var OriginalHtml = $('#AccountNickName').html();
	$('#todo').click(function () {
		$('#AccountNickName').html("<input name='newnickname' type='text' id='newnickname' value='" + OriginalHtml + "' style='width:80px;' maxlength=10>");
		$('#newnickname').focus();
		$('#newnickname').blur(function () {
			if ($('#newnickname').val() != '') {
				$.ajax({
					url: "ajax/ajax_RenewNickName.php",
					dataType: "html",
					data: {nickname: $('#newnickname').val(), timestamp: Math.random()},
					success: function (strValue) {
						if (strValue == 0) {
							window.location = 'index.php';
						} else {
							alert(strValue);
						}
					}
				})
			} else {
				$('#newnickname').focus();
				//alert('請輸入一個昵稱');
			}
			;
		});
	});
</script><!-- END JAVASCRIPTS --><script type="text/javascript" src="__PUBLIC__/media/js/remaining.js"></script><script type="text/javascript">var _gNow = new Date();
jQuery(document).ready(function($){
	var _allsecs = new Array();
	var _allsecs2 = new Array();
	var _i18n = {
		weeks: ['星期', '星期'],
		days: ['天', '天'],
		hours: ['小时', '小时'],
		minutes: ['分', '分'],
		seconds: ['秒', '秒']
	};
	$('.approve_remaining_time').each(function(){
		var _rid = $(this).attr('id');
		var _seconds = parseInt($(this).attr('rel'));
		if(_seconds > 0){
			$(this).html(
				remaining.getString(_seconds, _i18n, false)
			);
		}
		else{
			$(this).html('剩余0天');
		}
		_allsecs[_rid] = _seconds;
		_allsecs2[_rid] = _seconds;
	});

	timer = setInterval(function(){
		var now = new Date();
        //alert('ok');
		true_elapsed = Math.round((now.getTime() - _gNow.getTime()) / 1000);
        $('.approve_remaining_time').each(function(){
			var _rid = $(this).attr('id');
			_seconds = _allsecs[_rid];
			//synchronize
			_diff_sec = _allsecs2[_rid] - _seconds;
			if(_diff_sec < true_elapsed){
				_seconds = _allsecs2[_rid] - true_elapsed;
			}
			if(_seconds > 0){
				$(this).html(
					remaining.getString(_seconds, _i18n, false)
				);
				_allsecs[_rid] = --_seconds;
			}
			else{
				$("#too_many_user").hide();
				$("#login_btn").removeAttr("disabled");
				$(this).html('剩余0天');
			}
		});
	}, 1000);
});
</script><script type="text/javascript">jQuery(document).ready(function($){
	var mdid, pdid, gdid, amount, status;

	$('[data-toggle="tooltip"]').tooltip({
		container : 'body',
	});

	$('.hireTable').click(function(){
		$('.'+$(this).attr('value')+'.donate-body-'+$(this).attr('rel')).slideToggle('normal');
	});

	$('.transactionWrap').hide();
	$('.btn-details').click(function () {
		$(this).parents('.table-donations').siblings('.transactionWrap').stop(true, false).slideUp('normal');
		$(this).parents('.table-donations').next().stop(true, false).slideToggle('normal');
		return false;
	});
});
</script></body></html>