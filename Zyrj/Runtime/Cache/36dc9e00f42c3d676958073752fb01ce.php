<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html><head><title><?php echo xstr('page_hint');?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript">var waitSec = parseInt("<?php echo ($waitSecond); ?>");
var runStr = "<?php echo ($jumpUrl); ?>";
function waitFunc()
{
	if(isNaN(waitSec))
		waitSec = 0;
	if(waitSec<=0)
	{
		if(runStr.indexOf("javascript:")>=0)
			eval(runStr);
		else
			document.location.href = runStr; 
	}
	else
	{
		document.getElementById("wait").innerHTML = waitSec+"";
		waitSec--;
		window.setTimeout("waitFunc()",1000);
	}
}
</script><style>html, body{margin:0; padding:0; border:0 none;font:14px Tahoma,Verdana;line-height:150%;background:white}
a{text-decoration:none; color:#174B73; border-bottom:1px dashed gray}
a:hover{color:#F60; border-bottom:1px dashed gray}
div.message{margin:10% auto 0px auto;clear:both;padding:5px;border:1px solid silver; text-align:center; width:45%}
span.wait{color:blue;font-weight:bold}
span.error{color:red;font-weight:bold}
span.success{color:blue;font-weight:bold}
div.msg{margin:20px 0px}
</style></head><body><div class="message"><div class="msg"><?php if(isset($message)): ?><span class="success"><?php echo ($msgTitle); echo ($message); ?></span><?php else: ?><span class="error"><?php echo ($msgTitle); echo ($error); ?></span><?php endif; ?></div><div class="tip"><?php if(isset($closeWin)): echo xstr('tpl006');?><span class="wait" id="wait"><?php echo ($waitSecond); ?></span><?php echo xstr('tpl007');?><a href="<?php echo ($jumpUrl); ?>"><?php echo xstr('here');?></a><?php echo xstr('close'); else: echo xstr('tpl006');?><span class="wait" id="wait"><?php echo ($waitSecond); ?></span><?php echo xstr('tpl008');?><a href="<?php echo ($jumpUrl); ?>"><?php echo xstr('here');?></a><?php echo xstr('jump'); endif; ?></div></div></body></html><script type="text/javascript">waitFunc();</script>