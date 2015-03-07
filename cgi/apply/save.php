<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include 'cgi/pdo.php';
?>
<?php
	$schoolname = '';
	$classname = '';
	$studentname = '';
	$contacttel = '';
	$remark = '';
	if(array_key_exists('schoolname' ,$_REQUEST)){
		$schoolname = $_REQUEST['schoolname'];
	}
	if(array_key_exists('classname' ,$_REQUEST)){
		$classname = $_REQUEST['classname'];
	}
	if(array_key_exists('studentname' ,$_REQUEST)){
		$studentname = $_REQUEST['studentname'];
	}
	if(array_key_exists('contacttel' ,$_REQUEST)){
		$contacttel = $_REQUEST['contacttel'];
	}
	if(array_key_exists('remark' ,$_REQUEST)){
		$remark = $_REQUEST['remark'];
	}

		$sth = $pdomysql -> prepare('insert into tbApplyInfo(schoolname,classname,studentname,contacttel,remark,status)values(:schoolname,:classname,:studentname,:contacttel,:remark,1);');
		$sth -> execute(array('schoolname' => $schoolname,'classname' => $classname,'studentname' => $studentname,'contacttel' => $contacttel, 'remark' => $remark));
	
?>
<script type="text/javascript" language="javascript">
	alert("在线报名成功，我们会在24小时内联系你");
	window.location='<?php ActionLink('apply','apply')?>';
</script>