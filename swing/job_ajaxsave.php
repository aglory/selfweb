<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	$categoryid = 0;
	$method = 0;
	$serviceprice = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('name',$_REQUEST)){
		$name = $_REQUEST['name'];
	}
	if(array_key_exists('categoryid',$_REQUEST)){
		$categoryid = intval($_REQUEST['categoryid']);
	}
	if(array_key_exists('methodtype',$_REQUEST)){
		$method = intval($_REQUEST['methodtype']);
	}
	if(array_key_exists('serviceprice',$_REQUEST)){
		$serviceprice = floatval($_REQUEST['serviceprice']);
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	if(empty($id)){
		$sth = $pdomysql -> prepare('insert into tbJobInfo(guid,name,categoryid,method,serviceprice,datecreate,datemodify,status)values(:guid,:name,:categoryid,:method,:serviceprice,:datecreate,:datemodify,2)');
		$sth -> execute(array(
			'name' => $name,
			'categoryid' => $categoryid,
			'method' => $method,
			'serviceprice' => $serviceprice,
			'datecreate' => $timespan,
			'datemodify' => $timespan,
			'guid' => md5(mt_rand())
		));
		
		$id = $pdomysql->lastInsertId();
	}else{
		$sth = $pdomysql -> prepare('update tbJobInfo set name=:name,categoryid=:categoryid,method=:method,serviceprice=:serviceprice,datemodify=:datemodify where id='.$id);
		$sth -> execute(array(
			'name' => $name,
			'categoryid' => $categoryid,
			'method' => $method,
			'serviceprice' => $serviceprice,
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