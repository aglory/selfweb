<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbCategoryInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$name = $item['name'];
		}
	}
	
	
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxsave','category')?>" method="post" id="editorForm" class="block-content form">
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
				<td class="dialog-buttons" colspan="2">
					<button class="submit" type="button">保 存</button>
				</td>
			</tr>
		</table>
	</form>
</div>