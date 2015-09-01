<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';

function funLeveCount($item){
	if($item['levecount'] == 0){
		return '无';
	}
	if($item['levecount'] <10 ){
		return '<span>稀少</span><a class="apply" href="'.ActionLink('apply','class',array('schoolid' => $item['schoolid'],'classid' => $item['id']),false).'">抢名额</a>';
	}
	return '<span>少量</span><a class="apply" href="'.ActionLink('apply','class',array('schoolid' => $item['schoolid'],'classid' => $item['id']),false).'">争名额</a>';
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
				$sthschool = $pdomysql -> prepare("select * from tbSchoolInfo where guid = :guid;"); 
				$sthclass = $pdomysql -> prepare("select * from tbClassInfo where schoolid = :id and status = 1 order by `order` desc,id desc;");
				$sthpropertykey = $pdomysql -> prepare("select * from tbClassPropertyKeyInfo where classid = :classid and status = 1 order by `order` desc,id desc;"); 
				$sthpropertyvalue = $pdomysql -> prepare("select * from tbClassPropertyValueInfo where classid = :classid and keyid = :keyid and status = 1 order by `order` desc,id desc;"); 
				
				
				$guid = '';
				if(array_key_exists('schoolid' , $_GET)){
					$guid = $_GET['schoolid'];
				}
				
				$sthschool -> execute(array('guid' => $guid));
				$teachunits = array('0' => '' , '1' => '年' , '2' => '月', '3' => '天', '4' => '小时');

				$diplomabefores = array('1' => '小学','2' => '初中','4' => '高中' ,'8' => '中专' ,'16' => '大专','32' => '本科');
				$diplomaafters = array('1' => '小学','2' => '初中','4' => '高中' ,'8' => '中专' ,'16' => '大专','32' => '本科');

				foreach($sthschool -> fetchAll(PDO::FETCH_ASSOC) as $school){
					echo '<h1>',$school['name'],'</h1>';
					$sthclass -> execute(array('id' => $school['id']));
					
					foreach($sthclass -> fetchAll(PDO::FETCH_ASSOC) as $class){
						echo '<table class="class" id="class',$class['guid'],'"> ';
						
						echo '<tr><td class="colt name" colspan="2"><h3><span class="title">',$class['name'];
						echo '</span>';
						if(!empty($class['levecount'])){
							echo '<a class="apply" href="',ActionLink('apply','apply',array('schoolid' => urlencode($school['guid']),'classid' => urlencode($class['guid'])),false),'">在线报名</a>';
						}
						echo '</h3>';
						echo '</td></tr>';
						
						echo '<tr><td class="colt"><span>学时</span></td><td><span class="colv">';
						if(!empty($class['teachdate'])){
							echo $class['teachdate'],$teachunits[$class['teachunit']];
						}else{
							echo '-';
						}
						echo '</td></tr>';
						
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
							echo '<tr><td><span class="colt">学历要求</span></td><td class="colv">',implode('、',$diplomabefore),'</td></tr>';
						}
						
						if(!empty($diplomaafter)){
							echo '<tr><td><span class="colt">毕业文凭</span></td><td class="colv">',implode('、',$diplomaafter),'</td></tr>';
						}
						
						echo '<tr><td class="colt">费用</td><td class="colv">';
						if($class['price']> 0){
							echo $class['price'];
						}else{
							echo '-';
						}
						echo '</td></tr>';
						
						
						if($class['levecount']>-1){
							echo '<tr><td class="colt">剩余名额</td><td class="colv">',funLeveCount($class),'</td></tr>';
						}
						
						$sthpropertykey -> execute(array('classid' => $class['id']));
						if($sthpropertykey -> rowCount()>0){
							echo '<tr><td colspan="2"><dl class="dl">';
							foreach($sthpropertykey -> fetchAll(PDO::FETCH_ASSOC) as $propertykey){
								echo '<dt class="dt targetlevel',$propertykey['targetlevel'],'">',$propertykey['name'],'</dt>';
								$sthpropertyvalue -> execute(array('classid' => $class['id'],'keyid' => $propertykey['id']));
								if($sthpropertyvalue -> rowCount() > 0){
									switch($propertykey['displaytype']){
										case '1':
											foreach($sthpropertyvalue -> fetchAll(PDO::FETCH_ASSOC) as $propertyvalue){
												echo '<dd class="dd targetlevel',$propertyvalue['targetlevel'],'">',$propertyvalue['value'],'</dd>';
											}
											break;
										case '2':
											echo '<dd class="dd targetlevel',$propertykey['targetlevel'],'"><ul class="ul">';
											foreach($sthpropertyvalue -> fetchAll(PDO::FETCH_ASSOC) as $propertyvalue){
												echo '<li class="li">',$propertyvalue['value'],'</li>';
											}
											echo '</ul></dd>';
											break;
										case '3':
											echo '<dd class="dd targetlevel',$propertykey['targetlevel'],'"><ol class="ol">';
											foreach($sthpropertyvalue -> fetchAll(PDO::FETCH_ASSOC) as $propertyvalue){
												echo '<li class="li">',$propertyvalue['value'],'</li>';
											}
											echo '</ol></dd>';
											break;
									}
									echo '<dd>';
									echo '</dd>';
								}
							}
							echo '</dl></td></tr>';
						}
						if(!empty(strip_tags($class['description']))){
							echo "<tr><td colspan='2'>{$class['description']}</td></tr>";
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