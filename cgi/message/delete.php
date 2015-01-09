<?php
if(!defined('Execute')){ exit();}
include 'cgi/pdo.php';

$id= 0;
if(array_key_exists('id',$_GET)){
	$id = $_GET['id'];
}

$sth = $pdosqlite -> prepare("delete from messages where id=:id;");
$sth -> execute(array('id'=>$id));

header('Location: '.ActionLink('list','message',null,true));
?>