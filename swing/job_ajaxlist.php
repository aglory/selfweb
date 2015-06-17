<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	function funRenderOperator($o){
		$btn = array();
		$btn[] = '<a class="btn editor" title="编辑" href="'.ActionLink('dialogeditor','job',array('id' => $o['id']),false).'">编辑</a>';
		if($o['status']==1){
			$btn[] = '<a class="btn status status1" href="'.ActionLink('ajaxchangestatus','job',array('id' => $o['id'],'status' => $o['status']),false).'">运行</a>';
		}else if($o['status'] == 2){
			$btn[] = '<a class="btn status status2" href="'.ActionLink('ajaxchangestatus','job',array('id' => $o['id'],'status' => $o['status']),false).'">停用</a>';
		}
		$btn[] = '<a class="btn move" href="'.ActionLink('ajaxchangeorder','job',array('id' => $o['id'],'order' => $o['order']+1),false).'">↑</a>';
		$btn[] = '<a class="btn move" href="'.ActionLink('ajaxchangeorder','job',array('id' => $o['id'],'order' => $o['order']-1),false).'">↓</a>';
		 
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
		$whereClause[] = "j.`name` like '%{$_REQUEST['name']}%'";
	}
	if(array_key_exists('categoryid',$_REQUEST)){
		$categoryid = intval($_REQUEST['categoryid']);
		if($categoryid > 0){
			$whereClause[] = 'j.categoryid = '.$categoryid;
		}
	}
	if(array_key_exists('methodtype',$_REQUEST)){
		$method = intval($_REQUEST['methodtype']);
		if($method > 0){
			$whereClause[] = 'j.method = '.$method;
		}
	}	
	if(array_key_exists('status', $_REQUEST)){
		$status = intval($_REQUEST['status']);
		if($status > 0){
			$whereClause[] = 'j.status = '.$status;
		}
	}
	if(empty($whereClause)){
		$whereClause = '';
	}else{
		$whereClause = 'where '.implode(' and ',$whereClause);
	}
	if(empty($orderBy)){
		$orderBy = 'order by j.`order` desc,j.id desc';;
	}else{
		$orderBy = 'order by '.$orderBy;
	}
	
	$errors = array();
	
	$sthlist = $pdomysql -> prepare("select j.*,c.name as categoryname from tbJobInfo as j left join tbCategoryInfo as c on j.categoryid = c.id $whereClause $orderBy limit $pageIndex,$pageSize;");

	$sthlist -> execute();
	$value = Array();
	
	$errorlist = $sthlist -> errorInfo();
	if($errorlist[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	$methods = array('0' => '','1' => '直签','2' => '派遣','4' => '先派遣后直签');
	
	foreach($sthlist->fetchAll(PDO::FETCH_ASSOC) as $item){
		$value[] = '<tr><td>'.htmlspecialchars($item['name']).'</td><td>'.$item['categoryname'].'</td><td class="price">'.$item['serviceprice'].'</td>'.$item['method'].'<td>'.$methods[$item['method']].'</td><td>'.$item['order'].'</td><td>'.funRenderOperator($item).'</td></tr>';
	}
	if(empty($value)){
		$value='<tr><td colspan="1000">暂无数据</td></tr>';
	}else{
		$value = implode('',$value);
	}
	
	$sthcount = $pdomysql -> prepare("select count(1) from tbJobInfo as j left join tbCategoryInfo as c on j.categoryid = c.id $whereClause");
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