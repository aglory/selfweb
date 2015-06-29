<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	$classid = 0;
	$targetlevel = 0;
	$displaytype = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('name',$_REQUEST)){
		$name = $_REQUEST['name'];
	}
	if(array_key_exists('classid',$_REQUEST)){
		$classid = intval($_REQUEST['classid']);
	}
	if(array_key_exists('targetlevel',$_REQUEST)){
		$targetlevel = intval($_REQUEST['targetlevel']);
	}
	if(array_key_exists('displaytype',$_REQUEST)){
		$displaytype = floatval($_REQUEST['displaytype']);
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	if(empty($id)){
		$sth = $pdomysql -> prepare('insert into tbClassPropertyKeyInfo(name,classid,targetlevel,displaytype,datecreate,datemodify,status)values(:name,:classid,:targetlevel,:displaytype,:datecreate,:datemodify,2)');
		$sth -> execute(array(
			'name' => $name,
			'classid' => $classid,
			'targetlevel' => $targetlevel,
			'displaytype' => $displaytype,
			'datecreate' => $timespan,
			'datemodify' => $timespan
		));
		
		$id = $pdomysql->lastInsertId();
	}else{
		$sth = $pdomysql -> prepare('update tbClassPropertyKeyInfo set name=:name,classid=:classid,targetlevel=:targetlevel,displaytype=:displaytype,datemodify=:datemodify where id='.$id);
		$sth -> execute(array(
			'name' => $name,
			'classid' => $classid,
			'targetlevel' => $targetlevel,
			'displaytype' => $displaytype,
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