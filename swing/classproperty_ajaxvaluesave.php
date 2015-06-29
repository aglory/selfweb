<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$value = '';
	$classid = 0;
	$keyid = 0;
	$targetlevel = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('value',$_REQUEST)){
		$value = $_REQUEST['value'];
	}
	if(array_key_exists('classid',$_REQUEST)){
		$classid = intval($_REQUEST['classid']);
	}
	if(array_key_exists('keyid',$_REQUEST)){
		$keyid = intval($_REQUEST['keyid']);
	}
	if(array_key_exists('targetlevel',$_REQUEST)){
		$targetlevel = intval($_REQUEST['targetlevel']);
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	if(empty($id)){
		$sth = $pdomysql -> prepare('insert into tbClassPropertyValueInfo(`value`,classid,keyid,targetlevel,datecreate,datemodify,status)values(:value,:classid,:keyid,:targetlevel,:datecreate,:datemodify,2)');
		$sth -> execute(array(
			'value' => $value,
			'classid' => $classid,
			'keyid' => $keyid,
			'targetlevel' => $targetlevel,
			'datecreate' => $timespan,
			'datemodify' => $timespan
		));
		$id = $pdomysql->lastInsertId();
	}else{
		$sth = $pdomysql -> prepare('update tbClassPropertyValueInfo set `value`=:value,targetlevel=:targetlevel,datemodify=:datemodify where id='.$id);
		$sth -> execute(array(
			'value' => $value,
			'targetlevel' => $targetlevel,
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