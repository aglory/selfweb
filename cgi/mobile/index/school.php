<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
$schoolId = 0;
if(array_key_exists('id',$_GET)){
	$schoolId = $_GET['id'];
}
$school = array('id' => 0,'name' => '');
				
$sthSchool = $pdomysql -> prepare("select * from tbSchoolInfo where guid = :guid");
$sthSchool -> execute(array('guid' => $schoolId));

foreach($sthSchool -> fetchAll(PDO::FETCH_ASSOC) as $schoolItem){
	$school = $schoolItem;
}

?>
<html>
	<head>
		<meta name="keywords"content="永恒的父爱,信息咨询" />
		<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/iconfont.css" />
		<link type="text/css" rel="stylesheet" href="/css/mobile/base.css" />
	</head>
	<body>
		<header class="header">
			<div class="text-center re">
				<a class="" href="<?php ActionLink('index','index')?>"><span class="iconfont icon-keyboardarrowleft left-icon h3"></span></a>
				<strong class=" h3"><?php echo htmlspecialchars($school['name'])?></strong>
			</div>
		</header>
		<section>
			<ul class="list">
				<?php
				$sthClass = $pdomysql -> prepare("select * from tbClassInfo where schoolid = :schoolid and status = 1 order by `order`;");
				$sthClass -> execute(array('schoolid' => $schoolItem['id']));
				foreach($sthClass -> fetchAll(PDO::FETCH_ASSOC) as $classItem){
					echo '<li class="list-inline row"><a href="',ActionLink('class','index',array('classid' => $classItem['guid'],'schoolid' => $schoolId),false),'" class="collapse in h4">',htmlspecialchars($classItem['name']),'</a></li>';
				}
				?>
				
			</ul>
		</section>
		<?php include 'cgi/mobile/footer.php' ?>
	</body>
</html>