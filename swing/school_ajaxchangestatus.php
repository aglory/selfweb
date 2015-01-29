<?php
	header('Content-Type: application/json');	
	
	$id = 0;$status = 0;
	if(array_key_exists('id',$_GET)){
		$id = $_GET['id'];
	}
	if(array_key_exists('status',$_GET)){
		$status = $_GET['status'];
	}
	
	if(empty($id) || empty($status)){
		echo json_encode(array('statu' => false,'message' => '数据错误'),true);
		exit(1);
	}
	
	$status = 3 - $status;
	$timespan = date('Y-m-d H:i:s',time());
	
	$sth = $pdomysql -> prepare("update tbSchoolInfo set `status` = $status,datemodify='$timespan' where `id` = $id;");
	$count = $sth -> execute();
	
	$errors = array();
	$error = $sth -> errorInfo();
	if($error[0] > 0){
		$errors[] = $error[2];
	}
	
	$result = array();
	$result['status'] = count($errors) == 0 ? true : false; 
	$result['message'] = implode('\r\n',$errors);
	echo json_encode($result,true);
	
?>