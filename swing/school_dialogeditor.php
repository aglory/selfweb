<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	$url = '';
	$description = '';
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbSchoolInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$name = $item['name'];
			$url = $item['url'];
			$description = $item['description'];
		}
	}
	
	 // 'id' => '1', 
	 // 'name' => '四川化工高级技工学校', 
	 // 'url' => 'http://www.hggjjx.com/', 
	 // 'latitude' => '0.000000', 
	 // 'longitude' => '0.000000', 
	 // 'description' => NULL, 
	 // 'order' => '0', 
	 // 'status' => '1', 
	 // 'datecreate' => '2015-01-12 16:43:05', 
	 // 'datemodify' => '2015-01-12 16:43:05', 
	 // 'imgs' => '', ), )
	
	
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxsave','school')?>" method="post" id="editorForm" class="block-content form">
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
					网址：
				</td>
				<td>
					<input name="url" type="text" value="<?php echo $url; ?>" class="value" />
				</td>
			</tr>
			<tr>
				<td class="title">
					简介：
				</td>
				<td>
					<textarea id="description" name="description" class="value"><?php echo $description; ?></textarea>
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