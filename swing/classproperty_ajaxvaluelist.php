<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	function funRenderOperator($o){
		$btn = array();
		$btn[] = funRenderEditorBtn($o);
		if($o['status']==1){
			$btn[] = '<a rel="'.$o['keyid'].'" class="btn valuestatus status1" href="'.ActionLink('ajaxvaluechangestatus','classproperty',array('id' => $o['id'],'status' => $o['status']),false).'">运行</a>';
		}else if($o['status'] == 2){
			$btn[] = '<a rel="'.$o['keyid'].'" class="btn valuestatus status2" href="'.ActionLink('ajaxvaluechangestatus','classproperty',array('id' => $o['id'],'status' => $o['status']),false).'">停用</a>';
		}
		$btn[] = '<a rel="'.$o['keyid'].'" class="btn valuemove" href="'.ActionLink('ajaxvaluechangeorder','classproperty',array('id' => $o['id'],'order' => $o['order']+1),false).'">↑</a>';
		$btn[] = '<a rel="'.$o['keyid'].'" class="btn valuemove" href="'.ActionLink('ajaxvaluechangeorder','classproperty',array('id' => $o['id'],'order' => $o['order']-1),false).'">↓</a>';
		$btn[] = '<a rel="'.$o['keyid'].'" class="btn valuemoveinput" title="排序" href="'.ActionLink('dialogvaluechangeordereditor','classproperty',array('id' => $o['id']),false).'">排序</a>';

		return implode('',$btn);
	}
	
	function funRenderEditorBtn($o){
		$name = '编辑';
		if(empty($o['id'])){
			$name = '新增属性值';
		}
		return '<a rel="'.$o['keyid'].'" class="btn valueeditor" title="'.$name.'" href="'.ActionLink('dialogvalueeditor','classproperty',array('id' => $o['id'] ,'classid' => $o['classid'],'keyid' => $o['keyid']),false).'">'.$name.'</a>';;
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
	$propertyid = 0;
	$classid = 0;
	
	if(array_key_exists('propertyid',$_REQUEST)){
		$propertyid = intval($_REQUEST['propertyid']);
		if($propertyid > 0){
			$whereClause[] = 'keyid = '.$propertyid;
		}
	}
	if(array_key_exists('classid',$_REQUEST)){
		$classid = intval($_REQUEST['classid']);
		if($classid > 0){
			$whereClause[] = 'classid = '.$classid;
		}
	}
	if(array_key_exists('value',$_REQUEST)){
		$whereClause[] = "`value` like '%{$_REQUEST['value']}%'";
	}
	if(array_key_exists('targetlevel',$_REQUEST)){
		$targetlevel = intval($_REQUEST['targetlevel']);
		if($targetlevel > 0){
			$whereClause[] = 'targetlevel = '.$targetlevel;
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
	
	$sthlist = $pdomysql -> prepare("select * from tbClassPropertyValueInfo $whereClause $orderBy limit $pageIndex,$pageSize;");
	
	$sthlist -> execute();
	$value = Array();
	
	$errorlist = $sthlist -> errorInfo();
	if($errorlist[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	$targetlevels = array('0' => '','1' => 'normal','2' => 'primary','3' => 'info','4' => 'warn','5' => 'error');
	
	$value[] = '<tr class="tr_property_key tr_property_key_'.$propertyid.'_value"><th>属性值</th><th>重要程度</th><th></th><th>顺序</th><th><span class="ChildAddLink">'.funRenderEditorBtn(Array('id' => 0 ,'classid' => $classid ,'keyid' => $propertyid)).'</span></th></tr>';
	foreach($sthlist->fetchAll(PDO::FETCH_ASSOC) as $item){
		$item_value = strip_tags($item['value']);
		if(mb_strlen($item_value,'utf-8') > 60){
			$item_value = mb_substr($item_value,0,58,'utf-8').'..';
		}
		$value[] = '<tr class="tr_property_key tr_property_key_'.$propertyid.'_value"><td title="'.strip_tags($item['value']).'">'.$item_value.'</td><td>'.$targetlevels[$item['targetlevel']].'</td><td>-</td><td>'.$item['order'].'</td><td>'.funRenderOperator($item).'</td></tr>';
	}
	if(empty($value)){
		$value = '<tr class="tr_property_key tr_property_key_'.$propertyid.'_value"><td colspan="5">暂无数据</td></tr>';
	}else{
		$value = implode('',$value);
	}
	
	$value .= '<tr class="tr_property_key tr_property_key_'.$propertyid.'_value"><td id="tr_property_key_'.$propertyid.'_pager" class="pager" colspan="5"></td></tr>';
	
	$sthcount = $pdomysql -> prepare("select count(1) from tbClassPropertyValueInfo $whereClause");
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