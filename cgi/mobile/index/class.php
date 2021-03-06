<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
$schoolId = 0;
$classId = 0;

if(array_key_exists('schoolid',$_GET)){
	$schoolId = $_GET['schoolid'];
}

if(array_key_exists('classid',$_GET)){
	$classId = $_GET['classid'];
}

$sthTitleInfo = $pdomysql -> prepare("select tbSchoolInfo.id as schoolid,tbSchoolInfo.name as schoolname,tbClassInfo.id as classid,tbClassInfo.name as classname from tbSchoolInfo inner join tbClassInfo on tbSchoolInfo.id = tbClassInfo.schoolid where tbClassInfo.guid = :guid");
$sthTitleInfo -> execute(array('guid' => $classId));

$titleInfo = array('schoolid' => 0,'schoolname' => '','classid' => 0,'classname' => '');
foreach($sthTitleInfo -> fetchAll(PDO::FETCH_ASSOC) as $titleInfoItem){
	$titleInfo = $titleInfoItem;
}

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>永恒的父爱 -&gt; <?php echo  htmlspecialchars($titleInfo['schoolname']) ?> -&gt; <?php echo htmlspecialchars($titleInfo['classname'])?></title>
		<meta name="keywords"content="永恒的父爱,信息咨询,<?php echo  htmlspecialchars($titleInfo['schoolname']) ?> , <?php echo htmlspecialchars($titleInfo['classname'])?>" />
		<link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="/css/mobile/base.css" />
	</head>
	<body>
		<header class="header">
			<a class="" href="<?php ActionLink('school','index',array('id' => $schoolId))?>">
				<div class="text-center">
					<span class="iconfont icon-angle-left left-icon h1" title = "<?php echo  htmlspecialchars($titleInfo['schoolname']) ?>"></span>
					<strong class=" h1"><?php echo htmlspecialchars($titleInfo['classname'])?></strong>
				</div>
			</a>
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
					echo '<li class="list-inline row h2">学时：';
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
						echo '<li class="list-inline row h2">学历要求：',implode('、',$diplomabefore),'</li>';
					}
					
					if(!empty($diplomaafter)){
						echo '<li class="list-inline row h2">毕业文凭：',implode('、',$diplomaafter),'</li>';
					}
					
					echo '<li class="list-inline row h2">费用：';
					if($class['price']> 0){
						echo $class['price'];
					}else{
						echo '-';
					}
					echo '</li>';
					
					
					$sthpropertykey = $pdomysql -> prepare("select * from tbClassPropertyKeyInfo where classid = :classid and status = 1 order by `order` desc,id desc;"); 
					$sthpropertyvalue = $pdomysql -> prepare("select * from tbClassPropertyValueInfo where classid = :classid and keyid = :keyid and status = 1 order by `order` desc,id desc;"); 
					
					$sthpropertykey -> execute(array('classid' => $class['id']));
					foreach($sthpropertykey -> fetchAll(PDO::FETCH_ASSOC) as $propertykey){
						$sthpropertyvalue -> execute(array('classid' => $class['id'],'keyid' => $propertykey['id']));
						$firstproperty = true;
						if($sthpropertyvalue -> rowCount() > 0){
							foreach($sthpropertyvalue -> fetchAll(PDO::FETCH_ASSOC) as $propertyvalue){
								if($firstproperty) {
									echo '<dl><dt class="h2"><strong>',htmlspecialchars($propertykey['name']),'</strong></dt>';
									$firstproperty = false;
								}
								echo '<dd>',$propertyvalue['value'],'</dd>';
							}
						}
						if(!$firstproperty){
							echo '</dl>';
						}
					}
				}
				?>
				
			</ul>
		</section>
		<?php include 'cgi/mobile/footer.php' ?>
	</body>
</html>