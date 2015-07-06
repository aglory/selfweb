<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	function funRenderOperator($o){
		$btn = array();
		$btn[] = '<a class="btn keyeditor" title="编辑" href="'.ActionLink('dialogkeyeditor','classproperty',array('id' => $o['id']),false).'">编辑</a>';
		if($o['status']==1){
			$btn[] = '<a class="btn keystatus status1" href="'.ActionLink('ajaxkeychangestatus','classproperty',array('id' => $o['id'],'status' => $o['status']),false).'">运行</a>';
		}else if($o['status'] == 2){
			$btn[] = '<a class="btn keystatus status2" href="'.ActionLink('ajaxkeychangestatus','classproperty',array('id' => $o['id'],'status' => $o['status']),false).'">停用</a>';
		}
		$btn[] = '<a class="btn keymove" href="'.ActionLink('ajaxkeychangeorder','classproperty',array('id' => $o['id'],'order' => $o['order']+1),false).'">↑</a>';
		$btn[] = '<a class="btn keymove" href="'.ActionLink('ajaxkeychangeorder','classproperty',array('id' => $o['id'],'order' => $o['order']-1),false).'">↓</a>';
		$btn[] = '<a class="btn keymoveinput" title="排序" href="'.ActionLink('dialogkeychangeordereditor','classproperty',array('id' => $o['id']),false).'">排序</a>';

		$btn[] = '<a class="btn keyvalue" rel="'.$o['id'].'" href="'.ActionLink('ajaxvaluelist','classproperty',array('propertyid' => $o['id']),false).'">键值</a>';
		
		$btn[] = '<a class="btn" rel="'.$o['id'].'" href="'.ActionLink('list','classpropertyvalue',array('propertyid' => $o['id']),false).'">键值详情</a>';
		$btn[] = '_list';
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
	if(array_key_exists('classid',$_REQUEST)){
		$classid = intval($_REQUEST['classid']);
		if($classid > 0){
			$whereClause[] = 'classid = '.$classid;
		}
	}
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
	$form = Array();
	
	$errorlist = $sthlist -> errorInfo();
	if($errorlist[0] > 0){
		$errors[] = $errorlist[2];
	}
	
	
	$displaytypes = array('0' => '','1' => '默认','2' => '无序','3' => '有序');
	$targetlevels = array('0' => '','1' => 'normal','2' => 'primary','3' => 'info','4' => 'warn','5' => 'error');
	
	foreach($sthlist->fetchAll(PDO::FETCH_ASSOC) as $item){
		$item_name = strip_tags($item['name']);
		if(strlen($item_name) > 60){
			$item_name = substr($item_name,0,58).'..';
		}
		$value[] = '<tr id="tr_property_key_'.$item['id'].'"><td title="'.strip_tags($item['name']).'">'.$item_name.'</td><td>'.$targetlevels[$item['targetlevel']].'</td>'.'<td>'.$displaytypes[$item['displaytype']].'</td><td>'.$item['order'].'</td><td>'.funRenderOperator($item).'</td></tr>';
		$form[] = '<form id="groupform'.$item['id'].'" target="_blank" action="'.ActionLink('ajaxvaluelist','classproperty',null,false).'" method="post" class="groupform"><input type="hidden" id="propertyid" name="propertyid" value="'.$item['id'].'" /><input type="hidden" name="pageIndex" value="1" /><input type="hidden" name="pageSize" value="2" /><input type="hidden" name="orderBy" value="" /></form>';
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
	$result['form'] = implode('',$form);
	$result['message'] = implode('\r\n',$errors);
	
	echo json_encode($result ,true);
?>