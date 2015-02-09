<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
		<link type="text/css" rel="stylesheet" href="/css/school.css" />

	</head>
	<body>
		<?php Render('header')?>
		<div class="blockborder wrap body">
			<ul class="SchoolList">
				<?php
					$sthSchool = $pdomysql -> prepare("select * from tbSchoolInfo where status=1 order by `order` desc;"); 
					$sthSchool -> execute();
					foreach($sthSchool -> fetchAll(PDO::FETCH_ASSOC) as $school){
						echo '<li class="SchoolItem">';
						echo '<h2 class="SchoolTitle"><a href="',ActionLink('list','class',array('schoolid' => $school['guid']),false),'">',$school['name'],'</a></h2>';
						echo '</li>';
					}
				?>
			</ul>
		</div>
		<?php Render('footer')?>
	</body>
</html>