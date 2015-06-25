<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$order = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbClassPropertyValueInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$order = $item['order'];
		}
	}
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxchangeorder','classpropertyvalue')?>" method="get" id="editorForm" class="block-content form">
		<input name="id" type="hidden" value="<?php echo $id; ?>" />
		<table style="width:100%">
			<tr>
				<td class="title">
					顺序：
				</td>
				<td>
					<input name="order" type="text" value="<?php echo $order; ?>" class="value" />
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