<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
?>
<html>
	<head>
		<meta name="keywords"content="ÓÀºãµÄ¸¸°®,ÐÅÏ¢×ÉÑ¯" />
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
	</head>
	<body>
		<?php include 'cgi/header.php' ?>
		<section>
			<ul>
				<?php
					$sth = $pdomysql -> prepare("select * from tbSchoolInfo where status=1 order by `order`;"); 
					$sth -> execute();
					foreach($sth -> fetchAll(PDO::FETCH_ASSOC) as $item){
						echo '<li>',$item['name'],'<a href="',$item['url'],'">','#','</a></li>';
					}
				?>
			</ul>
			
		</section>
		<?php include 'cgi/footer.php' ?>
	</body>
</html>