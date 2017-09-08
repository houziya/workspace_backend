<?php if (!defined('THINK_PATH')) exit();?><!-- BEGIN PAGE HEADER--><div class="row-fluid"><div class="span12"><h3 class="page-title"> 拆分匹配
            <small>Split Match</small></h3><ul class="breadcrumb"><li><i class="icon-home"></i><a href="__APP__/Public/main">Home</a><i
                    class="icon-angle-right"></i></li><li><a href="/index.php?s=/Matchs/automatch">拆分匹配</a></li></ul></div></div><div class="ncenter_box"><form method="post" name="match" action="__APP__/Matchs/automatchall"><table width="100%" border="0" cellspacing="10" cellpadding="0"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"><h2>拆分匹配</h2><tr><td width="100%" height="90">                        要匹配的进场订单号:<textarea type="text" rows="5" name="aaa"
                                            style=" background-color: #ADD9C0;; min-width:700px"/></textarea>                        &nbsp;&nbsp;请以英文逗号,隔开

                    </td></tr><tr><td width="100%" height="90">                        要匹配的出场订单号:<textarea type="text" rows="5" name="bbb"
                                            style=" background-color: #ADD9C0; min-width:700px"/></textarea>                        &nbsp;&nbsp;请以英文逗号,隔开

                    </td></tr><tr><td><input type="submit" name="action" value="确认匹配" class="button_text"
                               onclick="if(confirm('確定要进行拆分匹配吗?')) return true; else return false;">&nbsp;&nbsp;
                    </td></tr></table></table></form></div>