<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	
	$id = 0;
	if(array_key_exists('id',$_GET)){
		$id = intval($_GET['id']);
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	$sth = $pdomysql -> prepare("update tbApplyInfo set status = 2, datemodify = :timespan where id=$id and status != 2;");
	$sth -> execute(array('timespan' => $timespan));
	
	header('Content-Type: application/json');
	$errors = array();
	$error = $sth -> errorInfo();
	if($error[0] > 0){
		$errors[] = $error[2];
	}
	
	$result = array('id' =>$id);
	$result['status'] = count($errors) == 0 ? true : false; 
	$result['message'] = implode('\r\n',$errors);
	echo json_encode($result,true);
?>