<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>永恒的父爱</title>
		<meta name="keywords"content="永恒的父爱,信息咨询" />
		<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/mobile/base.css" />
	</head>
	<body>
		<header class="header">
			<a class="" href="<?php ActionLink('index','index')?>">
				<div class="text-center"><span class="iconfont  icon-home left-icon h1"></span>
					<strong class="h1">永恒的父爱</strong>
				</div>
			</a>
		</header>
		<section>
			<ul class="list">
				<?php
					$sth = $pdomysql -> prepare("select * from tbSchoolInfo where status=1 order by `order` desc,id desc;;"); 
					$sth -> execute();
					foreach($sth -> fetchAll(PDO::FETCH_ASSOC) as $item){
						echo '<li class="list-inline row"><a href="',ActionLink('school','index',array('id'=>$item['guid']),false),'" class="collapse in h1">',$item['name'],'</a></li>';
					}
				?>
			</ul>
		</section>
		<?php include 'cgi/mobile/footer.php' ?>
	</body>
</html>