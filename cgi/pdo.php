<?php
if(!defined('Execute')){ exit();}
$pdomysql = new PDO('mysql:host=localhost;dbname=fireman','fireman','123456',array(PDO::MYSQL_ATTR_FOUND_ROWS => true,PDO::ATTR_STRINGIFY_FETCHES => false,PDO::ATTR_EMULATE_PREPARES => false));
$pdosqlite = new PDO('sqlite:./sqlite.db3','','',array(PDO::MYSQL_ATTR_FOUND_ROWS => true,PDO::ATTR_STRINGIFY_FETCHES => false,PDO::ATTR_EMULATE_PREPARES => false));
?>
