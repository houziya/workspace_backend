<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title><?php echo xstr('System_namex');?></title><link href="__PUBLIC__/Css/body.css" rel="stylesheet" media="screen" type="text/css" /><link href="__PUBLIC__/Css/menu.css" rel="stylesheet" media="screen" type="text/css" /><link href="__PUBLIC__/Css/main.css" rel="stylesheet" media="all" type="text/css" /><link href="__PUBLIC__/Css/css.css" rel="stylesheet" media="all" type="text/css" /><script type="text/javascript" src="__PUBLIC__/Js/Ajax/ajaxpg.js"></script><script type=text/javascript src="__PUBLIC__/Js/jquery-1.11.3.min.js"></script><script type="text/javascript">    jQuery(document).ready(function(e) {
        jQuery("#trading a").click(function(ex){
        ex.stopPropagation();
        ex.preventDefault();
        var topBody = jQuery(window.parent.document).find("body");
        if(topBody.length > 0)
        {
            var bodyClass = '#buyDetail-'+this.id.split('-')[1];
            
            var showBoard = jQuery(bodyClass).clone();
            showBoard.css("display","none");
            showBoard.attr("id",null);
            showBoard.appendTo(topBody);
            var contentBoard = showBoard.children("div");
            if(contentBoard.length > 0)
            {
                contentBoard.click(function(es){
                    es.stopPropagation();
                });
            }
            showBoard.fadeIn(300);
            showBoard.click(function(ex){
                ex.stopPropagation();
                ex.preventDefault();
                jQuery(this).fadeOut(300,function(){
                    jQuery(this).remove();
                });
            });
        }
        else
            alert('not found top window body');
        });
    });
</script><script type="text/javascript">    jQuery(document).ready(function(e) {
        jQuery("#trading2 a").click(function(ex){
        ex.stopPropagation();
        ex.preventDefault();
        var topBody = jQuery(window.parent.document).find("body");
        if(topBody.length > 0)
        {
            var bodyClass = '#sellDetail-'+this.id.split('-')[1];
            
            var showBoard = jQuery(bodyClass).clone();
            showBoard.css("display","none");
            showBoard.attr("id",null);
            showBoard.appendTo(topBody);
            var contentBoard = showBoard.children("div");
            if(contentBoard.length > 0)
            {
                contentBoard.click(function(es){
                    es.stopPropagation();
                });
            }
            showBoard.fadeIn(300);
            showBoard.click(function(ex){
                ex.stopPropagation();
                ex.preventDefault();
                jQuery(this).fadeOut(300,function(){
                    jQuery(this).remove();
                });
            });
        }
        else
            alert('not found top window body');
        });
    });
</script><script type="text/javascript">		$(function(){
		$('.addout').click(function(){
			var obj=$('.outinput').clone();
			 obj.removeClass();
			$('.outinput').after(obj);
		});
	});

			$(function(){
		$('.addin').click(function(){
			var obj=$('.incd').clone();
			 obj.removeClass();
			$('.incd').after(obj);
		});
	});
</script></head><body><div class="ncenter_box" ><!-- <div class="accounttitle"><h1>结算每周分红 </h1></div> --><form method="post" name="match" action="__APP__/Mavro/manaul_match"><table width="100%" border="0" cellspacing="10" cellpadding="0"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"><h2>匹配区-单进单出 单进多出</h2><tr><td width="100%" height="20">进场订单编号:<input type="text" name="inCode" style=" background-color: #ADD9C0;"/>&nbsp;&nbsp;
出场订单编号[<span class= "addout">增加一个 </span> ]:
<input type="text" name="outCode[]" style=" background-color: #ADD9C0;" class="outinput" /></td></tr><tr><td><input type="submit" name="action" value="匹配订单" class="button_text" onclick="if(confirm('确定要匹配订单吗?')) return true; else return false;">&nbsp;&nbsp;</td></tr></table></form><form method="post" name="match" action="__APP__/Mavro/manaul_match2"><table width="100%" border="0" cellspacing="10" cellpadding="0"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"><h2>匹配区-多进单出</h2><tr><td width="100%" height="20">进场订单编号:[<span class= "addin">增加一个 </span> ]<input type="text" name="inCode[]" class="incd" style=" background-color: #ADD9C0;"/>&nbsp;&nbsp;
出场订单编号:
<input type="text" name="outCode" style=" background-color: #ADD9C0;" class="outinputs" /></td></tr><tr><td><input type="submit" name="action" value="匹配订单" class="button_text" onclick="if(confirm('确定要匹配订单吗?')) return true; else return false;">&nbsp;&nbsp;</td></tr></table><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"><h2>当日进出场数据</h2><tr><td width="30%" height="10">进场订单总额</td><td><?php echo ($jin); ?></td><td width="30%" height="10">进场订单总单数</td><td><?php echo ($danjin); ?></td></tr><tr><td width="30%" height="10">出场订单编号</td><td><?php echo ($chu); ?></td><td width="30%" height="10">出场订单总单数</td><td><?php echo ($danchu); ?></td></tr></table></form><form method='post' action="__URL__/adminClearing/"><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="records"><div id="result" style="text-align:center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"  id="trading"><h2>挂单进场</h2><tr><td width="20%" height="20"> 订单编号</td><td width="20%">日期</td><td width="10%">会员编号</td><td width="10%">挂单金额</td><td width="20%">状态</td><td width="10%">是否超时</td><td width="10%">是否冻结</td></tr><?php if(is_array($buylist)): $i = 0; $__LIST__ = $buylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><tr><td width="20%" height="20"><?php echo ($voo['x1']); ?></td><td width="20%"><?php echo (date('Y-m-d H:i:s',$voo["rdt"])); ?></td><td width="10%"><?php echo ($voo['b_user_id']); ?></td><td width="10%"><?php echo ($voo['money']); ?></td><td width="20%"><?php if(($voo['is_pay']) == "0"): ?><span style="color:#017ce8">待匹配&nbsp;<a href="__APP__/Mavro/Delect/del_id/<?php echo ($voo['id']); ?>/url_type/1">删除订单</a></span><?php else: ?>已匹配成功<br><a id="Bid-<?php echo ($voo['id']); ?>" style="color:#73450e; padding:6px 0; display:block;">详细资料</a><?php endif; ?></td><td width="10%"><?php if(($voo['is_pay']) == "1"): $ok=$nowtime-$voo['rdt']-$s12*60*60; if($ok>0&&$voo['is_done']==0){echo "已超时";}else{echo "未超时或已付款";} else: ?>未匹配<?php endif; ?></td><td width="10%"><?php if(($voo['is_cancel']) == "0"): ?><span style="color:#017ce8">正常</span><?php else: ?>已冻结<?php endif; ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><table width="100%" style="background:#f7f9fa; border-top:1px solid #f2f3f6;"><tr align='center'><td><?php echo ($bpage); ?></td></tr><tr align='center'><td><input name="postPage" value="<?php echo ($postPage); ?>" type="text" size="8"/>页&nbsp;&nbsp; <input type="submit" name="Submit" value="跳转"  class="button_text"/></td></tr></table><br/><br/></table><table width="100%" border="0" cellspacing="10" cellpadding="0"  class="records"><div id="result" style="text-align:center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"  id="trading2"><h2>挂单出场</h2><tr><td width="20%" height="20"> 订单编号</td><td width="20%">日期</td><td width="10%">会员编号</td><td width="10%">挂单金额</td><td width="15%">状态</td><td width="10%">是否超时</td><td width="10%">操作</td><td width="5%">是否冻结</td></tr><?php if(is_array($selllist)): $i = 0; $__LIST__ = $selllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><tr><td width="20%" height="20"><?php echo ($voo['x1']); ?></td><td width="20%"><?php echo (date('Y-m-d H:i:s',$voo["rdt"])); ?></td><td width="10%"><?php echo ($voo['s_user_id']); ?></td><td width="10%"><?php echo ($voo['money']); ?></td><td width="15%"><?php if(($voo['is_pay']) == "0"): ?><span style="color:#017ce8">待匹配</span>&nbsp;<a href="__APP__/Mavro/Delect/del_id/<?php echo ($voo['id']); ?>/url_type/1">删除订单</a><?php else: ?>已匹配成功<br><a id="Sid-<?php echo ($voo['id']); ?>" style="color:#73450e; padding:6px 0; display:block;">详细资料</a><?php endif; ?></td><td width="10%"><?php if(($voo['is_pay']) == "1"): $ok=$nowtime-$voo['pdt']-$s12*60*60; if($ok>0&&$voo['is_done']==0){echo "<span color='red'>已超时<span>";}else{echo "未超时或已收款";} else: ?>未匹配<?php endif; ?></td><td width="10%"><?php if(($voo['is_done']) == "0"): ?><a href="__APP__/Mavro/confirm_get/p_id/<?php echo ($voo['id']); ?>/url/1">确认收款<a/><?php else: ?>已确认收款<?php endif; ?></td><td width="5%"><?php if(($voo['is_cancel']) == "0"): ?><span style="color:#017ce8">正常</span><?php else: ?>已冻结<?php endif; ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table><table width="100%" style="background:#f7f9fa; border-top:1px solid #f2f3f6;"><tr align='center'><td><?php echo ($spage); ?></td></tr><tr align='center'><td><input name="SpostPage" value="<?php echo ($SpostPage); ?>" type="text" size="8"/>页&nbsp;&nbsp; <input type="submit" name="Submit" value="跳转"  class="button_text"/></td></tr></table><table width="100%" border="0" cellspacing="0" cellpadding="0"  class="records"><div id="result" style="text-align:center"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab11 tab_bor"  id="trading"><h2 id="ttt" name="ttt">投诉管理</h2><tr><td width="20%" height="20"> 订单编号</td><td width="20%">日期</td><td width="10%">会员编号</td><td width="10%">挂单金额</td><td width="20%">状态</td><td width="10%">是否超时</td><td width="10%">是否冻结</td></tr><?php if(is_array($selllist)): $i = 0; $__LIST__ = $selllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i; if(($voo['is_ts']) == "1"): ?><tr><td width="20%" height="20"><?php echo ($voo['x1']); ?></td><td width="20%"><?php echo (date('Y-m-d H:i:s',$voo["rdt"])); ?></td><td width="10%"><?php echo ($voo['b_user_id']); ?></td><td width="10%"><?php echo ($voo['money']); ?></td><td width="20%"><?php if(($voo['is_ts']) == "1"): ?><span style="color:#ff0000">未收到款投诉中&nbsp;</span><?php endif; ?><br /><?php if(($voo['is_pay']) == "0"): ?><span style="color:#017ce8">待匹配&nbsp;<a href="__APP__/Mavro/Delect/del_id/<?php echo ($voo['id']); ?>/url_type/1">删除订单</a></span><?php else: ?>已匹配成功<br><a id="Sid-<?php echo ($voo['id']); ?>" style="color:#73450e; padding:6px 0; display:block;">详细资料</a><?php endif; ?></td><td width="10%"><?php if(($voo['is_pay']) == "1"): $ok=$nowtime-$voo['pdt']-$s12*60*60; if($ok>0&&$voo['is_done']==0){echo "已超时";}else{echo "未超时或已付款";} else: ?>未匹配<?php endif; ?></td><td width="10%"><?php if(($voo['is_done']) == "0"): ?><a href="__APP__/Mavro/confirm_get/p_id/<?php echo ($voo['id']); ?>/url/1">确认收款<a/><?php else: ?>已确认收款<?php endif; ?></td></tr><?php endif; endforeach; endif; else: echo "" ;endif; ?></table><table width="100%" style="background:#f7f9fa; border-top:1px solid #f2f3f6;"><tr align='center'><td><?php echo ($bpage); ?></td></tr><tr align='center'><td><input name="postPage" value="<?php echo ($postPage); ?>" type="text" size="8"/>页&nbsp;&nbsp; <input type="submit" name="Submit" value="跳转"  class="button_text"/></td></tr></table><br/><br/></table><table width="100%" align="center"><tr><td align="center">订单搜索：<input type="text" name="UserID" title="<?php echo xstr('account_query');?>">      &nbsp;&nbsp;&nbsp;&nbsp;
      会员编号：<input type="text" name="User" title="<?php echo xstr('account_query');?>">      &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Submit" value="<?php echo xstr('query');?>"  class="button_text"/>      &nbsp;
      <input name="button3" type="button" onclick="window.location.href='__URL__/financeDaoChu_DingDan/'" value="将所有买进订单导出Excel表格" class="button_text" />	   &nbsp;
	   <input name="button3" type="button" onclick="window.location.href='__URL__/financeDaoChu_DingDan_out/'" value="将所有卖出订单导出Excel表格" class="button_text" /></form></td></tr></table></div></table></div></table></div><!-- 提供帮助详细信息的弹出框 --><?php if(is_array($buylist)): $i = 0; $__LIST__ = $buylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><div id="buyDetail-<?php echo ($voo['id']); ?>" class="help_Box" ><div class="del2" style="margin-top:-350px;"><div class="color-line"></div><div class="modal-header"><h2>提供帮助</h2></div><div class="modal-body" style="height:300px; overflow:auto"><p><strong>订单号码:<span id="order_id"><?php echo ($voo['x1']); ?></span></strong></p><p>亿联互助会员请求援助总金额为:<font id="amount_order" color="#FF0000"><?php echo ($voo['money']); ?></font>人民币</p><p><strong>你必须在<font id="expire_date"><?php $a=$voo['pdt']+2*24*60*60; echo date("Y-m-d H:i:s",$a); ?></font>之前根据银行提供进一步的细节：</strong></p><div style="border:1px solid #009" id="get_info"><p>输入完整的收款人银行资料如下：</p><!-- <p><strong>受益人银行:<font id="bank_name"><?php echo (bank_name($voo['bid'])); ?></font></strong></p><p><strong>受益人姓名:<font id="bank_user"><?php echo (bank_user($voo['bid'])); ?></font></strong></p><p><strong>受益人账户号码: <font id="bank_number"><?php echo (bank_number($voo['bid'])); ?></font></strong></p><p><strong>受益人qq: <font id="wechat"><?php echo (qq($voo['bid'])); ?></font></strong></p><p><strong>受益人电话: <font id="alipay"><?php echo (tel($voo['bid'])); ?></font></strong></p> --><?php  $sell_id=explode(",", $voo['sid']); $m_id=explode(",", $voo['match_id']); foreach ($sell_id as $key => $value) { echo "<table width='100%'  cellpadding='3' cellspacing='1' id='tb1' bgcolor='#ffffff' ><tr><td><table width='100%'  cellpadding='3' cellspacing='1'  bgcolor='#ffffff'  ><tr><td align='right'>收款人银行：</td><td align='left'>".bank_name($value)."</td></tr><tr><td align='right'>收款人姓名：</td><td align='left'>".bank_user($value)."</td></tr><tr><td align='right'>收款人账户号码：</td><td align='left'>".bank_number($value)."</td></tr><tr><td align='right'>收款人qq：</td><td align='left'>".qq($value)."</td></tr><tr><td align='right'>收款人微信号：</td><td align='left'>".chat($value)."</td></tr></table></td><td><table width='100%' cellpadding='3' cellspacing='1'  bgcolor='#ffffff'  ><tr><td align='right'>收款人支付宝：</td><td align='left'>".zhifuPay($value)."</td></tr><tr><td align='right'>收款人微信钱包：</td><td align='left'>".weixinWalet($value)."</td></tr><tr><td align='right'>收款人财付通：</td><td align='left'>".caifuPay($value)."</td></tr><tr><td align='right'>收款人电话：</td><td align='left'>".tel($value)."</td></tr><tr><td align='right'>收款金额：</td><td align='left'>".t_money($m_id[$key])."</td></tr></table></td><td><table width='100%'  cellpadding='3' cellspacing='1' bgcolor='#ffffff' ><tr><td align='right'>推荐人电话：</td><td align='left'>".tel(re_id($value))."</td></tr><tr><td align='right'>是否已确认收款：</td><td align='left'>"; if(is_done($m_id[$key])==1){ echo "已确认收款"; }else{ echo "未确认收款"; } echo "</td></tr><tr colspan=2><td align='right'>上传打款凭证：</td><td align='left'>"; echo "<form method='post' action='__APP__/Mavro/uploadImg/tid/".$m_id[$key]."' enctype='multipart/form-data'><input type='file' name='filename' size='10' width='100px'/><br/><input type='submit' value='上传' />&nbsp;&nbsp;图片类型jpg,gif,png,tif"; if(viewImg($m_id[$key])){ echo "<a href='".viewImg($m_id[$key])."' target='_blank'>查看</a>"; }else{ echo '(未上传)'; } echo "</td></tr></table></td></tr><tr><tr><td height='30' colspan='3' style='height:5px;'><hr></td></tr></table>"; } ?><p>汇款前请先电话或者短信分别通知收款人 <font class="receiver_phone" color="#0000FF"><?php echo (tel1($voo['sid'])); ?></font></p><p>---------------------</p><p><font color="#FF0000">警告!</font>在未汇款之前不要点击确认收款，因为确认了就不能撤销了，如果没有及时汇款，系统会自动封号！</p></div><p><font color="#FF0000">注意！</font></p><p>1)转账汇款不要提及到关于亿联互助的支付目的，使用非标准的方式来表达即可！</p><p>2)万一未及时汇款，你的账号将被封锁。你匹配的订单将给（转移）另一个参与者。</p></div></div></div><?php endforeach; endif; else: echo "" ;endif; ?><!-- 提供帮助详细信息的弹出框 --><!-- 接受帮助详细信息的弹出框 --><?php if(is_array($selllist)): $i = 0; $__LIST__ = $selllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><div id="sellDetail-<?php echo ($voo['id']); ?>" class="help_Box" ><div class="del2" style="margin-top:-350px;"><div class="color-line"></div><div class="modal-header"><h2>我要求助</h2></div><form name="form1" method="post" action="__APP__/Mavro/sellAC"><div class="modal-body" style="height:300px; overflow:auto"><p><strong>订单号码:<span id="order_id"><?php echo ($voo['x1']); ?></span></strong></p><p>亿联互助会员请求援助总金额为:<font id="amount_order" color="#FF0000"><?php echo ($voo['money']); ?></font>人民币</p><p><strong>你必须在<font id="expire_date"><?php $a=$voo['pdt']+2*24*60*60; echo date("Y-m-d H:i:s",$a); ?></font>之前根据银行提供进一步的细节：</strong></p><div style="border:1px solid #009"><p>输入完整的受益人银行资料如下：</p><!-- <p><strong>受益人银行:<font id="bank_name"><?php echo (bank_name($voo['sid'])); ?></font></strong></p><p><strong>受益人姓名:<font id="bank_user"><?php echo (bank_user($voo['sid'])); ?></font></strong></p><p><strong>受益人账户号码: <font id="bank_number"><?php echo (bank_number($voo['sid'])); ?></font></strong></p>--><p><strong>打款推荐人联系电话: <font id="wechat"><?php echo (tel(re_id($voo['bid']))); ?></font></strong></p><!--                     <p><strong>打款受理中心联系电话: <font id="alipay"><?php echo (tel(shop_id($voo['bid']))); ?></font></strong></p><hr> --><table width="100%" class="tab3" border="0" cellpadding="3" cellspacing="1" id="tb1" bgcolor="#ffffff"><tr><th align='right'>打款人银行：</th><td align='left'><?php echo (bank_name($voo['bid'])); ?></td></tr><tr><th align='right'>打款人姓名：</th><td align='left'><?php echo (bank_user($voo['bid'])); ?></td></tr><tr><th align='right'>打款人账户号码：</th><td align='left'><?php echo (bank_number($voo['bid'])); ?></td></tr><tr><th align='right'>打款人qq：</th><td align='left'><?php echo (qq($voo['bid'])); ?></td></tr><tr><th align='right'>打款人微信号：</th><td align='left'><?php echo (chat($voo['bid'])); ?></td></tr><tr><th align='right'>打款人支付宝：</th><td align='left'><?php echo (zhifupay($voo['bid'])); ?></td></tr><tr><th align='right'>打款人微信钱包：</th><td align='left'><?php echo (weixinwalet($voo['bid'])); ?></td></tr><tr><th align='right'>打款人财付通：</th><td align='left'><?php echo (caifupay($voo['bid'])); ?></td></tr><tr><th align='right'>打款人电话：</th><td align='left'><?php echo (tel($voo['bid'])); ?></td></tr><tr><th align='right'>打款金额：</th><td align='left'><?php echo (t_money($voo['match_id'])); ?></td></tr><tr><th align='right'>查看打款凭证：</th><td align='left'><?php if($voo['img']) {echo "<a href=".$voo['img']." target='_blank'>查看</a>";} else{echo '未上传';} ?></td></tr></table><p>汇款前请先电话或者短信通知打款人</p><p>---------------------</p><p>在收到资金之前不要确认支付，因为确认了就不能撤销了，系统会默认你已经收到钱了！</p><p><font color="#FF0000">注意！</font></p><p>1)转账汇款不要提及到关于亿联互助的支付目的，使用非标准的方式来表达即可！</p><p>2)万一订单没有完成，你的账号将被封锁。你匹配的订单将给（转移）另一个参与者。</p></div></form></div></div><?php endforeach; endif; else: echo "" ;endif; ?><!-- 接受帮助详细信息的弹出框 --></body></html><style>.ab{
    display: block
}

.table_tte{
border:solid 1px #add9c0;
}
.table_tte td{
border:1px solid #add9c0; 
}

</style>