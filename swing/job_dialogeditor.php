<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	$categoryid = 0;
	$method = 0;
	$serviceprice = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('categoryid',$_REQUEST)){
		$categoryid = intval($_REQUEST['categoryid']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbJobInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$name = $item['name'];
			$categoryid = intval($item['categoryid']);
			$method = intval($item['method']);
			$serviceprice = floatval($item['serviceprice']);
		}
	}
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxsave','job')?>" method="post" id="editorForm" class="block-content form">
		<input name="id" type="hidden" value="<?php echo $id; ?>" />
		<table style="width:100%">
			<tr>
				<td class="title">
					名称：
				</td>
				<td>
					<input name="name" type="text" value="<?php echo $name; ?>" class="value" />
				</td>
			</tr>
			<tr>
				<td class="title">
					分类：
				</td>
				<td>
					<select name ="categoryid">
						<option value="0">无</option>
						<?php
						$sthcategory = $pdomysql -> prepare("select id,name from tbCategoryInfo where id = $categoryid or status = 1;");
						$sthcategory -> execute();
						foreach($sthcategory -> fetchAll(PDO::FETCH_ASSOC) as $item){
							echo '<option value="'.$item['id'].'"'.($item['id'] == $categoryid?' selected="selected"':'').'>'.htmlspecialchars($item['name']).'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">
					劳务方式：
				</td>
				<td>
					<select name ="methodtype">
						<option value="0">无</option>
						<?php
						$methods = array('1' => '直签','2' => '派遣','4' => '先派遣后直签');
						foreach($methods as $key => $value){
							echo '<option value="'.$key.'"'.($key == $method?' selected="selected"':'').'>'.htmlspecialchars($value).'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">
					价格：
				</td>
				<td>
					<input name="serviceprice" type="text" value="<?php echo $serviceprice?>" />
				</td>
			</tr>
			<tr>
				<td class="dialog-buttons" colspan="2">
					<button class="submit" type="button">保 存</button>
				</td>
			</tr>
		</table>
	</form>
</div>