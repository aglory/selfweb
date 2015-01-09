<?php
	ob_start();
	function ActionLink($action='',$model='',$opts=null,$return=false){
		$ext = '';
		if(!empty($opts) && sizeof($opts)>0){
			foreach($opts as $k=>$v){
				$ext .= "&$k=";
				$ext .= urlencode($v);
			}
		}
		if($return)
			return '?model='.urlencode($model).'&action='.urlencode($action).$ext;
		else
			echo '?model='.urlencode($model).'&action='.urlencode($action).$ext;
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
	
	if(file_exists("cgi/$model/$action.php")){
		require "cgi/$model/$action.php";
	}
?>