<?php
	ob_start();
	define ('CLIENTID','ClientId');
	
	function ActionLink($action='',$model='',$opts=null,$echo=true){
		$result = array();
		$result[] = 'model='.urlencode($model);
		$result[] = 'action='.urlencode($action);
		if(!empty($opts)){
			foreach($opts as $k => $v){
				$result[] = $k.'='.urlencode($v);
			}
		}
		if($echo)
			echo '?'.implode('&',$result);
		return '?'.implode('&',$result);
	}
	
	function WebActionLink($action='',$model='',$opts=null,$echo=true){
		$result = array();
		$result[] = 'model='.urlencode($model);
		$result[] = 'action='.urlencode($action);
		if(!empty($opts)){
			foreach($opts as $k => $v){
				$result[] = $k.'='.urlencode($v);
			}
		}
		if($echo)
			echo 'index.php?'.implode('&',$result);
		return 'index.php?'.implode('&',$result);
	}
	
	function Render(){
		$params = func_get_args();
		if(empty($params))return;
		$params = array_reverse($params);
		include './cgi/'.implode(DIRECTORY_SEPATRATOR,$params).'.php';
	}
	
	$model="index";
	$action="index";
	if(array_key_exists('model',$_GET)){
		$model=$_GET['model'];
	}
	if(array_key_exists('action',$_GET)){
		$action=$_GET['action'];
	}
	
	define('Model',$model);
	define('Action',$action);
	define('Execute',true);
	define('Administartor',true);
	
	require "cgi/pdo.php";
	
	$TemplateManagerList = !preg_match('/(^ajax)|(^dialog)/',$action);
	
	
	if(!array_key_exists(CLIENTID,$_COOKIE)){
		if($model!='session'){
			header('location: '.ActionLink('login','session',null,false));
			exit();
		}
		require './swing/'.$model.'_'.$action.'.php';
		exit();
	}
	
	$ClientId = $_COOKIE[CLIENTID];
	$pdomysql -> query('delete from tbSessionIfo where datemodify<date_add(now(),interval -1 hour);') -> execute();
	$sth = $pdomysql -> prepare('update tbSessionIfo set datemodify=now() where clientid=:clientid and ip=:ip and datemodify<date_add(now(),interval -1 hour);');
	$sth -> execute(array('clientid' => $ClientId,'ip' => $_SERVER["REMOTE_ADDR"]));
	if(empty($sth -> rowCount())){
		header('location: '.ActionLink('login','session',null,false));
		exit();
	}
	$CurrentUserId='';
	
	if($TemplateManagerList){
		require "admintemp.php";
	}else{
		require './swing/'.$model.'_'.$action.'.php';
	}
?>