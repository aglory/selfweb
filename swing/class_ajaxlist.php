<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	function funRenderOperator($o){
		$btn = array();
		$btn[] = '<a class="btn editor" title="编辑" href="'.ActionLink('dialogeditor','class',array('id' => $o['id'], 'schoolid' => $o['schoolid']),false).'">编辑</a>';
		if($o['status']==1){
			$btn[] = '<a class="btn status status1" href="'.ActionLink('ajaxchangestatus','class',array('id' => $o['id'],'status' => $o['status']),false).'">运行</a>';
		}else if($o['status'] == 2){
			$btn[] = '<a class="btn status status2" href="'.ActionLink('ajaxchangestatus','class',array('id' => $o['id'],'status' => $o['status']),false).'">停用</a>';
		}
		$btn[] = '<a class="btn move" href="'.ActionLink('ajaxchangeorder','class',array('id' => $o['id'],'order' => $o['order']+1),false).'">↑</a>';
		$btn[] = '<a class="btn move" href="'.ActionLink('ajaxchangeorder','class',array('id' => $o['id'],'order' => $o['order']-1),false).'">↓</a>';
		$btn[] = '<a class="btn moveinput" href="'.ActionLink('dialogchangeordereditor','class',array('id' => $o['id']),false).'">排序</a>';
		
		$btn[] = '<a class="btn" href="'.ActionLink('list','classproperty',array('classid' => $o['id']),false).'">属性</a>';
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
	
	if(array_key_exists('name',$_REQUEST) && !empty($_REQUEST['name'])){
		$whereClause[] = "c.name like '%{$_REQUEST['name']}%'";
	}
	if(array_key_exists('schoolid',$_REQUEST) && !empty($_REQUEST['schoolid'])){
		$whereClause[] = 'c.schoolid = '.intval($_REQUEST['schoolid']);
	}
	if(array_key_exists('schoolname',$_REQUEST) && !empty($_REQUEST['schoolname'])){
		$whereClause[] = "s.name like '%".addslashes($_REQUEST['schoolname'])."%'";
	}
	if(array_key_exists('status',$_REQUEST) && !empty($_REQUEST['status'])){
		$whereClause[] = 'c.status = '.intval($_REQUEST['status']);
	}
	
	if(array_key_exists('noschoolid',$_REQUEST)){
		$whereClause[] = 'c.schoolid = 0';
	}
	
	if(empty($whereClause)){
		$whereClause = '';
	}else{
		$whereClause = 'where '.implode(' and ',$whereClause);
	}
	if(empty($orderBy)){
		$orderBy = 'order by c.order desc,c.id desc';
	}else{
		$orderBy = 'order by '.$orderBy;
	}
	
	$errors = array();
	
	
	$sthlist = $pdomysql -> prepare("select c.*,s.name as schoolname from tbClassInfo as c left join tbSchoolInfo as s on c.schoolid=s.id $whereClause $orderBy limit $pageIndex,$pageSize;");
	
	$sthlist -> execute();
	$value = Array();
	
	$errorlist = $sthlist -> errorInfo();
	if($errorlist[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	foreach($sthlist->fetchAll(PDO::FETCH_ASSOC) as $item){
		$value[] = '<tr><td>'.htmlspecialchars($item['name']).'</td>'.
		'<td>'.($item['schoolname']===null?'-':htmlspecialchars($item['schoolname'])).'</td>'.
		'<td class="decimal price">'.$item['price'].'</td>'.
		'<td>'.$item['order'].'</td><td>'.funRenderOperator($item).'</td></tr>';
	}
	if(empty($value)){
		$value='<tr><td colspan="1000">暂无数据</td></tr>';
	}else{
		$value = implode('',$value);
	}
	
	$sthcount = $pdomysql -> prepare("select count(1) from tbClassInfo as c left join tbSchoolInfo as s on c.schoolid=s.id $whereClause");
	$sthcount -> execute();
	
	$errorcount = $sthcount -> errorInfo();
	if($errorcount[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	$result = array();
	$result['recordCount'] = intval($sthcount->fetch()[0]);
	$result['status'] = count($errors) == 0 ? true : false;
	$result['value'] = $value;
	$result['message'] = implode('\r\n',$errors);
	
	echo json_encode($result ,true);
?>