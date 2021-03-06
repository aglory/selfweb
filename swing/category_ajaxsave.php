<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('name',$_REQUEST)){
		$name = $_REQUEST['name'];
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	if(empty($id)){
		$sth = $pdomysql -> prepare('insert into tbCategoryInfo(guid,name,datecreate,datemodify,status)values(:guid,:name,:datecreate,:datemodify,2)');
		$sth -> execute(array(
			'name' => $name,
			'datecreate' => $timespan,
			'datemodify' => $timespan,
			'guid' => md5(mt_rand())
		));
		
		$id = $pdomysql->lastInsertId();
	}else{
		$sth = $pdomysql -> prepare('update tbCategoryInfo set name=:name,datemodify=:datemodify where id='.$id);
		$sth -> execute(array(
			'name' => $name,
			'datemodify' => $timespan
		));	
	}
	
	$errors = array();
	$error = $sth -> errorInfo();
	if($error[0] > 0){
		$errors[] = $error[2];
	}
	
	$result = array();
	$result['status'] = count($errors) == 0 ? true : false; 
	$result['message'] = implode('\r\n',$errors);
	$result['id'] = $id;
	
	echo json_encode($result,true);
	
	
?>