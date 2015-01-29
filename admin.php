<?php
	ob_start();
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
	
	if($TemplateManagerList){
		require "admintemp.php";
	}else{
		require './swing/'.$model.'_'.$action.'.php';
	}
?>