<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="/css/base.css" />

	</head>
	<body>
		<?php include 'cgi/header.php' ?>
		
		<div class="blockborder wrap body">
			<ul>
				<?php
					$sth = $pdomysql -> prepare("select * from tbSchoolInfo where status=1 order by `order`;"); 
					$sth -> execute();
					foreach($sth -> fetchAll(PDO::FETCH_ASSOC) as $item){
						echo '<li>',$item['name'],</li>';
					}
				?>
			</ul>
		</div>
		
		<?php include 'cgi/footer.php' ?>
	</body>
</html>