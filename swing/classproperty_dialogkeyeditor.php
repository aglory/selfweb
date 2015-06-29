<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$name = '';
	$classid = 0;
	$targetlevel = 0;
	$displaytype = 0;
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	if(array_key_exists('classid',$_REQUEST)){
		$classid = intval($_REQUEST['classid']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbClassPropertyKeyInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$name = $item['name'];
			$classid = intval($item['classid']);
			$targetlevel = intval($item['targetlevel']);
			$displaytype = floatval($item['displaytype']);
		}
	}
	
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxkeysave','classproperty')?>" method="post" id="editorForm" class="block-content form">
		<input name="id" type="hidden" value="<?php echo $id; ?>" />
		<input name="classid" type="hidden" value="<?php echo $classid; ?>" />
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
					重要程度：
				</td>
				<td>
					<select name ="targetlevel">
						<option value="0">无</option>
						<?php
						$targetlevels = array('1' => 'normal','2' => 'primary','3' => 'info','4' => 'warn','5' => 'error');
						foreach($targetlevels as $key => $value){
							echo '<option value="'.$key.'"'.($key == $targetlevel?' selected="selected"':'').'>'.htmlspecialchars($value).'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">
					展示方式
				</td>
				<td>
					<select name ="displaytype">
						<option value="0">无</option>
						<?php
						$displaytypes = array('1' => '默认','2' => '无序','3' => '有序');
						foreach($displaytypes as $key => $value){
							echo '<option value="'.$key.'"'.($key == $displaytype?' selected="selected"':'').'>'.htmlspecialchars($value).'</option>';
						}
						?>
					</select>
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