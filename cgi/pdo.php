<?php
if(!defined('Execute')){ exit();}
//$pdomysql = new PDO('mysql:host=fireman.gotoftp3.com;dbname=fireman','fireman','a123456z');
$pdomysql = new PDO('mysql:host=localhost;dbname=fireman','root','');
$pdosqlite = new PDO('sqlite:./sqlite.db3');
?>