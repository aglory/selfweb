<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	header('Content-Type: application/json');	
	
	$id = 0;$order = 0;
	if(array_key_exists('id',$_GET)){
		$id = $_GET['id'];
	}
	if(array_key_exists('order',$_GET)){
		$order = intval($_GET['order']);
	}
	
	if(empty($id)){
		echo json_encode(array('status' => false,'message' => '数据错误'),true);
		exit(1);
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	$errors = array();
	
	$sth = $pdomysql -> prepare("update tbCategoryInfo set `order` = $order,datemodify='$timespan'  where `id` = $id;");
	$count = $sth -> execute();
	$error = $sth -> errorInfo();
	if($error[0] > 0){
		$errors[] = $error[2];
	}
	
	$result = array();
	$result['status'] = count($errors) == 0 ? true : false; 
	$result['message'] = implode('\r\n',$errors);
	
	echo json_encode($result,true);
	
?>