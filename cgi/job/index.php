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
	return '<span>少量</span><a class="apply" href="'.ActionLink('apply','class',array('schoolid' => $item['schoolid'],'classid' => $item['id']),false).'">挣名额</a>';
}
	$params = array();
	$where = array('j.status = 1 and c.status = 1');
	
	$categoryid = 0;
	if(array_key_exists('categoryid', $_REQUEST)){
		$categoryid = intval($_REQUEST['categoryid']);
		if($categoryid > 0){
			$where[] = 'categoryid = :categoryid';
			$params['categoryid'] = $categoryid;
		}
	}
	
	$method = 0;
	if(array_key_exists('methodtype',$_REQUEST)){
		$method = intval($_REQUEST['methodtype']);
		if($method > 0){
			$where[] = 'method = :method';
			$params['method'] = $method;
		}
	}
	
	$pricemin = 0;
	if(array_key_exists('pricemin',$_REQUEST)){
		$pricemin = floatval($_REQUEST['pricemin']);
		$where[] = 'serviceprice>=:pricemin';
		$params['pricemin'] = $pricemin;
	}
	
	$pricemax = 0;
	if(array_key_exists('pricemax',$_REQUEST)){
		$pricemax = floatval($_REQUEST['pricemax']);
		if($pricemax>0){
			$where[] = 'serviceprice<=:pricemax';
			$params['pricemax'] = $pricemax;
		}
	}
				
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
		<link type="text/css" rel="stylesheet" href="/css/job.css" />
	</head>
	<body>
		<?php include 'cgi/header.php' ?>
		<?php
			$sthjob = $pdomysql -> prepare('select j.*,c.name as categoryname from tbJobInfo as j left join tbCategoryInfo as c on j.categoryid = c.id where '.implode(' and ',$where).' order by c.`order` desc,j.`order` desc');

			$sthjob -> execute($params);

			$methods = array('0' => '全部' , '1' => '直签' , '2' => '派遣' , '4' => '先派遣后直签');
			$prices = array();
			
			$jobs = $sthjob -> fetchAll(PDO::FETCH_ASSOC);
			$categories = array();
			
			foreach($jobs as $item){
				if(!array_key_exists($item['categoryid'],$categories)){
					$categories[$item['categoryid']] = $item['categoryname'];
				}
				$serviceprice = intval($item['serviceprice']);
				if(!in_array($serviceprice,$prices) && $serviceprice!= 0){
					$prices[] = $serviceprice;
				}
				sort($prices);
			}
		?>
		<div class="blockborder wrap search">
			<table class="class">
				<tr>
					<td class="coltitle">劳务方式：</td><td class="colvalue">
					<?php
					foreach($methods as $methodkey => $methodvalue){
						echo '<a class="'.($method == $methodkey ? "active":"").'" href="',actionlink('index','job',array('pricemin' => $pricemin,'pricemax' => $pricemax,'methodtype' => $methodkey,'categoryid' => $categoryid),false),'">',$methodvalue,'</a>';
					}
					?>
					</td>
				</tr>
				<tr>
					<td class="coltitle">服务费用：</td><td class="colvalue">
					<?php
					echo '<a class="'.(0 == $pricemin ? "active":"" ).'" href="',actionlink('index','job',array('pricemin' => 0,'pricemax' => 0,'methodtype' => $method,'categoryid' => $categoryid),false),'">全部</a>';
					foreach($prices as $price){
						echo '<a class="'.($price == $pricemin ? "active":"" ).'" href="',actionlink('index','job',array('pricemin' => $price,'pricemax' => $price,'methodtype' => $method,'categoryid' => $categoryid),false),'">',$price,'</a>';
					}
					?>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="blockborder wrap body">
			<?php
				foreach($categories as $categorykey => $categoryvalue){
					echo '<h1>',$categoryvalue,'</h1>';
					echo '<table class="class" id="class',$item['guid'],'"> ';
					echo '<tr><th class="t_c">职位</th><th class="t_c">劳务方式</th><th class="t_c">服务费用</th></tr>';
					foreach($jobs as $item){
						if($item['categoryid'] != $categorykey)
							continue;
						
						echo '<tr><td class="colt">',
							$item['name'],
							'</td><td class="colt method">',
							$methods[$item['method']],
							'</td><td class="colt price">',
							empty(floatval($item['serviceprice']))?'':$item['serviceprice'],
							'</td></tr>';
					}
					echo '</table>';
				}
			?>
		</div>
		
		<?php include 'cgi/footer.php' ?>
	</body>
</html>