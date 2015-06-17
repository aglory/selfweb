<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include 'cgi/pdo.php';
?>
<?php

	if(array_key_exists('tel',$_POST) && array_key_exists('message',$_POST)){
		$timespan = date('Y-m-d H:i:s',time());
		$sth = $pdomysql -> prepare('insert into tbMessageInfo(tel,msg,datecreate,datemodify,status)values(:tel,:msg,:datecreate,:datemodify,1);');
		$sth -> execute(array('tel' => $_POST['tel'],'msg' => $_POST['message'],'datecreate' => $timespan, 'datemodify' => $timespan));
	}
?>
<script type="text/javascript" language="javascript">
	alert("感谢你的资讯，我们会在24小时内联系你");
	window.location='<?php ActionLink('index','message')?>';
</script>