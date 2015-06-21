<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	header("Content-Type: text/html;charset=utf-8");
	
	$name='';$password='';
	if(array_key_exists('name',$_REQUEST) && !empty($_REQUEST['name'])){
		$name=$_REQUEST['name'];
	}
	if(array_key_exists('password',$_REQUEST) && !empty($_REQUEST['password'])){
		$password=$_REQUEST['password'];
	}
?>