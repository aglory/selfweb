<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
$schoolId = 0;
$classId = 0;

if(array_key_exists('schoolid',$_GET)){
	$schoolId = $_GET['schoolid'];
}
$sthSchool = $pdomysql -> prepare("select * from tbSchoolInfo where guid = :guid");
$sthSchool -> execute(array('guid' => $schoolId));

$school = array('id' => 0,'name' => '');
foreach($sthSchool -> fetchAll(PDO::FETCH_ASSOC) as $schoolItem){
	$school = $schoolItem;
}

if(array_key_exists('classid',$_GET)){
	$classId = $_GET['classid'];
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
			<ul>
				<?php
				
				$teachunits = array('0' => '' , '1' => '年' , '2' => '月', '3' => '天', '4' => '小时');

				$diplomabefores = array('1' => '小学','2' => '初中','4' => '高中' ,'8' => '中专' ,'16' => '大专','32' => '本科');
				$diplomaafters = array('1' => '小学','2' => '初中','4' => '高中' ,'8' => '中专' ,'16' => '大专','32' => '本科');
				
				$sthClass = $pdomysql -> prepare("select * from tbClassInfo where guid = :guid and status = 1 order by `order`;");
				$sthClass -> execute(array('guid' => $classId));
				foreach($sthClass -> fetchAll(PDO::FETCH_ASSOC) as $class){
					echo '<li class="list-inline row">学时：';
					if(!empty($class['teachdate'])){
						echo $class['teachdate'],$teachunits[$class['teachunit']];
					}else{
						echo '-';
					}
					echo '</li>';
					
					$diplomabefore = array();
					$diplomaafter = array();
					
					
					foreach($diplomabefores  as $item_key => $item_value){
						if((intval($item_key) & intval($class['diplomabefore'])) > 0){
							$diplomabefore[] = $item_value;
						}
					}
					
					foreach($diplomaafters  as $item_key => $item_value){
						if((intval($item_key) & intval($class['diplomaafter'])) > 0){
							$diplomaafter[] = $item_value;
						}
					}
					if(!empty($diplomabefore)){
						echo '<li class="list-inline row">学历要求：',implode('、',$diplomabefore),'</li>';
					}
					
					if(!empty($diplomaafter)){
						echo '<li class="list-inline row">毕业文凭：',implode('、',$diplomaafter),'</li>';
					}
					
					echo '<li class="list-inline row">费用：';
					if($class['price']> 0){
						echo $class['price'];
					}else{
						echo '-';
					}
					echo '</li>';
				}
				?>
				
			</ul>
		</section>
		<?php include 'cgi/mobile/footer.php' ?>
	</body>
</html>