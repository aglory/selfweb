<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	
	$id = 0;
	if(array_key_exists('id',$_GET)){
		$id = intval($_GET['id']);
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	$errors = array();
	
	$sth = $pdomysql -> prepare("update tbApplyInfo set status = 4, datemodify = :timespan where id = $id and status != 4;");
	$sth -> execute(array('timespan' => $timespan));
	
	$error = $sth -> errorInfo();
	if($error[0] > 0){
		$errors[] = $error[2];
	}
	
	header('Content-Type: application/json');
	
	$result = array();
	$result['status'] = count($errors) == 0 ? true :false;
	$result['message'] = implode('\r\n',$errors);
	
	echo json_encode($result,true);
?>