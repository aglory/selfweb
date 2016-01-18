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
<!DOCTYPE HTML>
<html>
	<head>
		<title>永恒的父爱 -&gt; <?php echo htmlspecialchars($school['name']) ?></title>
		<meta name="keywords"content="永恒的父爱,信息咨询,<?php echo htmlspecialchars($school['name']) ?>" />
		<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/mobile/base.css" />
	</head>
	<body>
		<header class="header">
			<a class="" href="<?php ActionLink('index','index')?>">
				<div class="text-center"><span class="iconfont  icon-angle-left left-icon h1"></span>
					<strong class=" h1"><?php echo htmlspecialchars($school['name'])?></strong>
				</div>
			</a>
		</header>
		<section>
			<ul class="list">
				<?php
				$sthClass = $pdomysql -> prepare("select * from tbClassInfo where schoolid = :schoolid and status = 1 order by `order` desc,id desc;;");
				$sthClass -> execute(array('schoolid' => $school['id']));
				foreach($sthClass -> fetchAll(PDO::FETCH_ASSOC) as $classItem){
					echo '<li class="list-inline row"><a href="',ActionLink('class','index',array('classid' => $classItem['guid'],'schoolid' => $schoolId),false),'" class="collapse in h2">',htmlspecialchars($classItem['name']),'</a></li>';
				}
				?>
				
			</ul>
		</section>
		<?php include 'cgi/mobile/footer.php' ?>
	</body>
</html>