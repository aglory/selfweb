<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	function funRenderOperator($o){
		$btn = array();
		$btn[] = '<a class="btn editor" title="编辑" href="'.ActionLink('dialogeditor','classproperty',array('id' => $o['id']),false).'">编辑</a>';
		if($o['status']==1){
			$btn[] = '<a class="btn status status1" href="'.ActionLink('ajaxchangestatus','classproperty',array('id' => $o['id'],'status' => $o['status']),false).'">运行</a>';
		}else if($o['status'] == 2){
			$btn[] = '<a class="btn status status2" href="'.ActionLink('ajaxchangestatus','classproperty',array('id' => $o['id'],'status' => $o['status']),false).'">停用</a>';
		}
		$btn[] = '<a class="btn move" href="'.ActionLink('ajaxchangeorder','classproperty',array('id' => $o['id'],'order' => $o['order']+1),false).'">↑</a>';
		$btn[] = '<a class="btn move" href="'.ActionLink('ajaxchangeorder','classproperty',array('id' => $o['id'],'order' => $o['order']-1),false).'">↓</a>';
		$btn[] = '<a class="btn moveinput" href="'.ActionLink('dialogchangeordereditor','classproperty',array('id' => $o['id']),false).'">排序</a>';

		$btn[] = '<a class="btn" href="'.ActionLink('list','classpropertyvalue',array('propertyid' => $o['id'],'classid' => $o['classid']),false).'">键值</a>';
		return implode('',$btn);
	}

	header('Content-Type: application/json');	
	$pageIndex = 1;
	$pageSize = 20;
	$orderBy;
	
	if(array_key_exists('pageIndex',$_REQUEST)){
		$pageIndex = intval($_REQUEST['pageIndex']);
	}
	if(array_key_exists('pageSize',$_REQUEST)){
		$pageSize = intval($_REQUEST['pageSize']);
	}
	if(array_key_exists('orderBy',$_REQUEST)){
		$orderBy = $_REQUEST['orderBy'];
	}
	if($pageIndex<1) $pageIndex=1;
	if($pageSize<1) $pageSize=20;
	$pageIndex = ($pageIndex - 1) * $pageSize;
	
	$whereClause = array();
	$whereParams = array();
	
	if(array_key_exists('name',$_REQUEST)){
		$whereClause[] = "`name` like '%{$_REQUEST['name']}%'";
	}
	if(array_key_exists('targetlevel',$_REQUEST)){
		$targetlevel = intval($_REQUEST['targetlevel']);
		if($targetlevel > 0){
			$whereClause[] = 'targetlevel = '.$targetlevel;
		}
	}
	if(array_key_exists('displaytype',$_REQUEST)){
		$displaytype = intval($_REQUEST['displaytype']);
		if($displaytype > 0){
			$whereClause[] = 'displaytype = '.$displaytype;
		}
	}
	if(array_key_exists('status', $_REQUEST)){
		$status = intval($_REQUEST['status']);
		if($status > 0){
			$whereClause[] = 'status = '.$status;
		}
	}
	if(empty($whereClause)){
		$whereClause = '';
	}else{
		$whereClause = 'where '.implode(' and ',$whereClause);
	}
	if(empty($orderBy)){
		$orderBy = 'order by `order` desc,id desc';;
	}else{
		$orderBy = 'order by '.$orderBy;
	}
	
	$errors = array();
	
	$sthlist = $pdomysql -> prepare("select * from tbClassPropertyKeyInfo $whereClause $orderBy limit $pageIndex,$pageSize;");

	
	
	$sthlist -> execute();
	$value = Array();
	
	$errorlist = $sthlist -> errorInfo();
	if($errorlist[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	
	$displaytypes = array('0' => '','1' => '默认','2' => '无序','3' => '有序');
	$targetlevels = array('0' => '','1' => 'normal','2' => 'primary','3' => 'info','4' => 'warn','5' => 'error');
	
	foreach($sthlist->fetchAll(PDO::FETCH_ASSOC) as $item){
		$value[] = '<tr><td>'.htmlspecialchars($item['name']).'</td><td>'.$targetlevels[$item['targetlevel']].'</td>'.'<td>'.$displaytypes[$item['displaytype']].'</td><td>'.$item['order'].'</td><td>'.funRenderOperator($item).'</td></tr>';
	}
	if(empty($value)){
		$value='<tr><td colspan="1000">暂无数据</td></tr>';
	}else{
		$value = implode('',$value);
	}
	
	$sthcount = $pdomysql -> prepare("select count(1) from tbClassPropertyKeyInfo $whereClause");
	$sthcount -> execute();
	
	$errorcount = $sthcount -> errorInfo();
	if($errorcount[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	$result = array();
	$result['recordCount'] = intval($sthcount->fetch()[0]);
	$result['status'] = count($errors) == 0 ? true :false;
	$result['value'] = $value;
	$result['message'] = implode('\r\n',$errors);
	
	echo json_encode($result ,true);
?>