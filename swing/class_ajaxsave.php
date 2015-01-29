<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}

	$id = 0;
	$schoolid=0;							//所属院校	
	$name='';								//课名
	$price='';								//价格,小于0表示没有	
	$description='';						//简介		
	$requiredlevel=0;						//入学条件(1:小学，2：初中，3：高中)
	$teachdate=0;							//学制
	$teachunit=0;							//时间单位（1：年，2：月，3：天，4：小时）
	$levecount= -1;							//剩余名额
	$preferential='';						//优惠
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('schoolid',$_REQUEST)){
		$schoolid = intval($_REQUEST['schoolid']);
	}
	if(array_key_exists('name',$_REQUEST)){
		$name = $_REQUEST['name'];
	}
	if(array_key_exists('price',$_REQUEST)){
		$price = floatval($_REQUEST['price']);
	}
	if(array_key_exists('description',$_REQUEST)){
		$description = $_REQUEST['description'];
	}
	if(array_key_exists('requiredlevel',$_REQUEST)){
		$requiredlevel = intval($_REQUEST['requiredlevel']);
	}
	if(array_key_exists('teachdate',$_REQUEST)){
		$teachdate = intval($_REQUEST['teachdate']);
	}
	if(array_key_exists('teachunit',$_REQUEST)){
		$teachunit = intval($_REQUEST['teachunit']);
	}
	if(array_key_exists('levecount',$_REQUEST)){
		$levecount = intval($_REQUEST['levecount']);
	}
	if(array_key_exists('preferential',$_REQUEST)){
		$preferential = $_REQUEST['preferential'];
	}
	
	$timespan = date('Y-m-d H:i:s',time());
	
	

	
	if(empty($id)){
		$sth = $pdomysql -> prepare('insert into tbClassInfo(schoolid,
name,
price,
description,
requiredlevel,
teachdate,
teachunit,
levecount,
preferential,
datecreate,
datemodify,
status
)values(
:schoolid,
:name,
:price,
:description,
:requiredlevel,
:teachdate,
:teachunit,
:levecount,
:preferential,
:datecreate,
:datemodify,
1);');
		$sth -> execute(array(
			'schoolid' => $schoolid,
			'name' => $name,
			'price' => $price,
			'requiredlevel' => $requiredlevel,
			'teachdate' => $teachdate,
			'teachunit' => $teachunit,
			'levecount' => $levecount,
			'preferential' => $preferential,
			'description' => $description,
			'datecreate' => $timespan,
			'datemodify' => $timespan
		));
		
		$id = $pdomysql->lastInsertId();
	}else{
		$sth = $pdomysql -> prepare('update tbClassInfo set 
schoolid = :schoolid,
name = :name,
price = :price,
description = :description,
requiredlevel = :requiredlevel,
teachdate = :teachdate,
teachunit = :teachunit,
levecount = :levecount,
preferential = :preferential,
datemodify = :datemodify
where id='.$id);
		$sth -> execute(array(
'schoolid' => $schoolid,
'name' => $name,
'price' => $price,
'description' => $description,
'requiredlevel' => $requiredlevel,
'teachdate' => $teachdate,
'teachunit' => $teachunit,
'levecount' => $levecount,
'preferential' => $preferential,
'datemodify' => $timespan
		));	
	}
	
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