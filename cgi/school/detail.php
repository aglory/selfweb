<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';
$id = 0;
if(array_key_exists('id',$_GET)){
	$id = intval($_GET['id']);
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
		<link type="text/css" rel="stylesheet" href="/css/schooldetail.css" />
	</head>
	<body>
		<?php include 'cgi/header.php' ?>
		
		<div class="blockborder wrap body">
			<?php
				$sthschool = $pdomysql -> prepare("select * from tbSchoolInfo where id = $id;"); 
				$sthclass = $pdomysql -> prepare("select * from tbClassInfo where schoolid = :id and status = 1 order by 'order' desc;");
				$sthschool -> execute();
				$teachunits = array('0' => '' , '1' => '年' , '2' => '月', '3' => '天', '4' => '小时');
				$requiredlevels = array('0' => '无' , '1' => '小学' , '2' => '初中' , '3' => '高中');
				
				foreach($sthschool -> fetchAll(PDO::FETCH_ASSOC) as $school){
					echo '<h1>',$school['name'],'</h1>';
					$sthclass -> execute(array('id' => $school['id']));
					foreach($sthclass -> fetchAll(PDO::FETCH_ASSOC) as $class){
						echo '<table class="class" id="class',$class['id'],'"> ';
						
						echo '<tr><td class="colt name" colspan="2"><h3>',$class['name'],'</h3>';
						if(!empty($class['levecount'])){
							echo '<a class="apply" href="',ActionLink('apply','class',array('schoolid' => $school['id'],'classid' => $class['id']),true),'">在线报名</a>';
						}
						echo '</td></tr>';
						
						echo '<tr><td class="colt"><span>学时</span></td><td><span class="colv">';
						if(!empty($class['teachdate'])){
							echo $class['teachdate'],$teachunits[$class['teachunit']];
						}else{
							echo '-';
						}
						echo '</td></tr>';
						
						echo '<tr><td><span class="colt">学历要求</span></td><td class="colv">',$requiredlevels[$class['requiredlevel']],'</td></tr>';
						
						echo '<tr><td class="colt">学费</td><td class="colv">';
						if($class['price']> 0){
							echo $class['price'];
						}else{
							echo '-';
						}
						echo '</td></tr>';
						
						if(!empty($class['levecount'])){
							echo '<tr><td class="colt">剩余名额</td><td class="colv">',$class['levecount'],'</td></tr>';
						}
						
						if(!empty(strip_tags($class['description']))){
							echo "<tr><td class='colt description'>简介</td><td class='colv'>{$class['description']}</td></tr>";
						}
						
						
						if(!empty($class['preferential'])){
							echo '<tr><td class="colt preferential">优惠</td><td class="colv">',htmlspecialchars($class['preferential']),'</td></tr>';
						}
						
						echo '</table>';
					}
					if(!empty($school['description'])){
						echo "<div>",$school['description'],"</div>";
					}
				}
			?>
		</div>
		
		<?php include 'cgi/footer.php' ?>
	</body>
</html>