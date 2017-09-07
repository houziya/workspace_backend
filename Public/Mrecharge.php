<?php
header('Content-Type:text/html;charset=utf-8');
$msg = "<body onload='sub();'><form action='/index.php?s=YouZi/createActiveCode' method='post' name='form' id='form'><input name='UserID' id='UserID' value=".$_REQUEST["MY18JYF"]."><input name='Num' id='Num' value=".(int)($_REQUEST["MY18M"]/10)."><input type='submit' id='ttt'></form></body>";
echo $msg;
?>

<script language="Javascript"> 
function sub(){
document.form.submit();
}
/*
function aa() {
$nn = parseInt($_REQUEST["MY18M"]/10); 
document.getelementbyid("UserID").value = $_REQUEST['MY18JYF'];
document.getelementbyid("Num").value = $nn;

}
*/
</script>