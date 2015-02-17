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
			$prices = array(0 => '全部');
			
			$jobs = $sthjob -> fetchAll(PDO::FETCH_ASSOC);
			$categories = array();
			foreach($jobs as $item){
				if(!array_key_exists($item['categoryid'],$categories)){
					$categories[$item['categoryid']] = $item['categoryname'];
				}
				$serviceprice = intval($item['serviceprice']);
				if(!array_key_exists($serviceprice,$prices)){
					$prices[$serviceprice] = $serviceprice;
				}
			}
			arsort($prices,2);
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
					<td class="coltitle">价格区间：</td><td class="colvalue">
					<?php
					foreach($prices as $pricekey => $pricevalue){
						echo '<a class="'.($pricekey == $pricemin ? "active":"" ).'" href="',actionlink('index','job',array('pricemin' => $pricekey,'pricemax' => $pricekey,'methodtype' => $method,'categoryid' => $categoryid),false),'">',$pricevalue,'</a>';
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