<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta name="keywords"content="永恒的父爱,信息咨询" />
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
		<meta name="sogou_site_verification" content="Dg3fhbzIql"/>
	</head>
	<body>
		<?php include 'cgi/header.php' ?>
		
		<div class="blockborder wrap body">
			<ul>
				<?php
					$sth = $pdomysql -> prepare("select * from tbSchoolInfo where status=1 order by `order`;"); 
					$sth -> execute();
					foreach($sth -> fetchAll(PDO::FETCH_ASSOC) as $item){
						echo '<li>',$item['name'],'<a href="',$item['url'],'">','#','</a></li>';
					}
				?>
			</ul>
		</div>
		
		<?php include 'cgi/footer.php' ?>
	</body>
</html>