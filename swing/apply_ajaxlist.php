<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	function funRenderOperator($o){
		$btn = array();
		if($o['status']==1){
			$btn[] = '<a class="btn status mark" href="'.ActionLink('ajaxmark','apply',array('id' => $o['id']),false).'">标记</a>';
		}else if($o['status'] == 4){
			$btn[] = '<a class="btn status unmark" href="'.ActionLink('ajaxunmark','apply',array('id' => $o['id']),false).'">取消</a>';
		}
		if($o['status'] != 2){
			$btn[] = '<a class="btn status delete" href="'.ActionLink('ajaxdelete','apply',array('id' => $o['id']),false).'">删除</a>';
		}
		return implode('',$btn);
	}
	
	function funRenderStatus($o){
		if($o['status'] == '1'){
			return '?';
		}else if($o['status'] == '2'){
			return '×';
		}else if($o['status'] == '4'){
			return '√';
		}
	}

	//header('Content-Type: application/json');
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
	
	$status = 0;
	if(array_key_exists('status',$_REQUEST)){
		$status = intval($_REQUEST['status']);
		if($status > 0){
			$whereClause[] = 'status='.$status;
		}
	}
	if($status == 0){
		$whereClause[] = 'status in(1,4)';
	}
	
	if(empty($whereClause)){
		$whereClause = '';
	}else{
		$whereClause = 'where '.implode(' and ',$whereClause);
	}
	if(empty($orderBy)){
		$orderBy = 'order by id desc';;
	}else{
		$orderBy = 'order by '.$orderBy;
	}
	
	$errors = array();
	
	$sthlist = $pdomysql -> prepare("select * from tbApplyInfo $whereClause $orderBy limit $pageIndex,$pageSize;");
	$sthlist -> execute();
	
	$errorlist = $sthlist -> errorInfo();
	if($errorlist[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	$value = Array();
	
	foreach($sthlist->fetchAll(PDO::FETCH_ASSOC) as $item){
		$value[] = '<tr><td><input type="checkbox" class="checkboxid" value="'.$item['id'].'"/>'.htmlspecialchars($item['schoolname']).'</td>';
		$value[] = '<td><span title="'.$item['classname'].'">'.substr($item['studentname'],0,30).'</span></td>';
		$value[] = '<td>'.$item['studentname'].'/'.$item['contacttel'].'</td>';
		$value[] = '<td>'.$item['datecreate'].'</td><td>'.$item['datemodify'].'</td><td>'.funRenderStatus($item).'</td><td>'.funRenderOperator($item).'</td></tr>';
	}
	if(empty($value)){
		$value='<tr><td colspan="1000">暂无数据</td></tr>';
	}else{
		$value = implode('',$value);
	}
	
	$sthcount = $pdomysql -> prepare("select count(1) from tbApplyInfo $whereClause");
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