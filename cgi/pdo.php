<?php
if(!defined('Execute')){ exit();}
$pdomysql = new PDO('mysql:host=fireman.gotoftp3.com;dbname=fireman','fireman','a747258621900z',array(PDO::MYSQL_ATTR_FOUND_ROWS => true,PDO::ATTR_STRINGIFY_FETCHES => false,PDO::ATTR_EMULATE_PREPARES => false));
$pdosqlite = new PDO('sqlite:./sqlite.db3','','',array(PDO::MYSQL_ATTR_FOUND_ROWS => true,PDO::ATTR_STRINGIFY_FETCHES => false,PDO::ATTR_EMULATE_PREPARES => false));
?>