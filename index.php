<?php
	if(!defined('DIRECTORY_SEPATRATOR')) define('DIRECTORY_SEPATRATOR','/');
	
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
	
	if(file_exists("./cgi/$model/$action.php")){
		require "./cgi/$model/$action.php";
	}else{
		require "./cgi/index/index.php";
	}
?>