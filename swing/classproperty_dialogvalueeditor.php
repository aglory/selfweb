<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$value = '';
	$keyid = 0 ;
	$classid = 0;
	$targetlevel = 0;
	$displaytype = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('keyid',$_REQUEST)){
		$keyid = intval($_REQUEST['keyid']);
	}
	if(array_key_exists('classid',$_REQUEST)){
		$classid = intval($_REQUEST['classid']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbClassPropertyValueInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$value = $item['value'];
			$keyid = $item['keyid'];
			$classid = intval($item['classid']);
			$targetlevel = intval($item['targetlevel']);
		}
	}
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxvaluesave','classpropertyvalue')?>" method="post" id="editorForm" class="block-content form">
		<input name="id" type="hidden" value="<?php echo $id; ?>" />
		<input name="keyid" type="hidden" value="<?php echo $keyid; ?>" />
		<input name="classid" type="hidden" value="<?php echo $classid; ?>" />
		<table style="width:100%">
			<tr>
				<td class="title">
					重要程度：
				</td>
				<td>
					<select name ="targetlevel">
						<option value="0">无</option>
						<?php
						$targetlevels = array('1' => 'normal','2' => 'primary','3' => 'info','4' => 'warn','5' => 'error');
						foreach($targetlevels as $key => $val){
							echo '<option value="'.$key.'"'.($key == $targetlevel?' selected="selected"':'').'>'.htmlspecialchars($val).'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">
					值：
				</td>
				<td>
					<textarea name="value"><?php echo htmlspecialchars($value); ?></textarea>
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