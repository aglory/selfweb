<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	
	$ids = 0;
	if(array_key_exists('id',$_GET)){
		$ids = intval($_GET['id']);
	}
	if(array_key_exists('ids',$_POST) && is_array($_POST['ids'])){
		$ids = implode(',', array_map(function($item){return intval($item);} ,$_POST['ids']));
		if(strlen($ids)==0){
			$ids = 0;
		}
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	$sth = $pdomysql -> prepare("update tbMessageInfo set status = 3, datemodify = :timespan where id in($ids) and status != 3;");
	$sth -> execute(array('timespan' => $timespan));
	
	header('Content-Type: application/json');
	$errors = array();
	$error = $sth -> errorInfo();
	if($error[0] > 0){
		$errors[] = $error[2];
	}
	
	$result = array('id' =>$ids);
	$result['status'] = count($errors) == 0 ? true : false; 
	$result['message'] = implode('\r\n',$errors);
	echo json_encode($result,true);
?>