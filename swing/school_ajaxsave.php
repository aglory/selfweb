<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	$url = '';
	$description = '';
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('name',$_REQUEST)){
		$name = $_REQUEST['name'];
	}
	if(array_key_exists('url',$_REQUEST)){
		$url = $_REQUEST['url'];
	}
	if(array_key_exists('description',$_REQUEST)){
		$description = $_REQUEST['description'];
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	if(empty($id)){
		$sth = $pdomysql -> prepare('insert into tbSchoolInfo(name,url,description,datecreate,datemodify,status)values(:name,:url,:description,:datecreate,:datemodify,2)');
		$sth -> execute(array(
			'name' => $name,
			'url' => $url,
			'description' => $description,
			'datecreate' => $timespan,
			'datemodify' => $timespan
		));
		
		$id = $pdomysql->lastInsertId();
	}else{
		$sth = $pdomysql -> prepare('update tbSchoolInfo set name=:name,url=:url,description=:description,datemodify=:datemodify where id='.$id);
		$sth -> execute(array(
			'name' => $name,
			'url' => $url,
			'description' => $description,
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