<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$id = 0;
	$schoolid=0;							//所属院校	
	$name='';								//课名
	$price='';								//价格,小于0表示没有	
	$description='';						//简介
	//$order=0;								//顺序
	//$status=0;								//状态(1:正常,2:删除)				
	$diplomabefore=0;						//入学条件(1:小学，2：初中，4：高中，8：中专，16：大专，32：本科)
	$diplomaafter=0;						//毕业文凭(1:小学，2：初中，4：高中，8：中专，16：大专，32：本科)
	$teachdate=0;							//学制
	$teachunit=0;							//时间单位（1：年，2：月，3：天，4：小时）
	//$datecreate='';							//建立时间
	//$datemodify='';							//修改时间
	$levecount= -1;							//剩余名额
	$preferential='';						//优惠
	
	if(array_key_exists('id',$_REQUEST)){
		$id = intval($_REQUEST['id']);
	}
	
	if(array_key_exists('schoolid' ,$_REQUEST)){
		$schoolid = intval($_REQUEST['schoolid']);
	}
	
	if(!empty($id)){
		$sth = $pdomysql -> prepare("select * from tbClassInfo where id=$id");
		$sth -> execute();
		foreach($sth->fetchAll(PDO::FETCH_ASSOC) as $item){
			$schoolid = $item['schoolid'];
			$name = $item['name'];
			$price = $item['price'];
			$description = $item['description'];
			$diplomabefore = $item['diplomabefore'];
			$diplomaafter = $item['diplomaafter'];
			$teachdate = $item['teachdate'];
			$teachunit = $item['teachunit'];
			$levecount = $item['levecount'];
			$preferential = $item['preferential'];
		}
	}
?>

<div class="form DialogStyle">
	<form action="<?php ActionLink('ajaxsave','class')?>" method="post" id="editorForm" class="block-content form">
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
					所属学校：
				</td>
				<td>
					<select name ="schoolid">
						<option value="0">无</option>
						<?php
						$sthschools = $pdomysql -> prepare("select id,name from tbSchoolInfo where id = $schoolid or status = 1;");
						$sthschools -> execute();
						foreach($sthschools -> fetchAll(PDO::FETCH_ASSOC) as $item){
							echo '<option value="'.$item['id'].'"'.($item['id'] == $schoolid?' selected="selected"':'').'>'.htmlspecialchars($item['name']).'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">
					学费：
				</td>
				<td>
					<input name="price" type="text" value="<?php echo $price; ?>" class="value" />
				</td>
			</tr>
			<tr>
				<td class="title">
					入学条件：
				</td>
				<td>
					<?php
					$diplomabefores = array('1' => '小学','2' => '初中','4' => '高中' ,'8' => '中专' ,'16' => '大专','32' => '本科');
					
					
					foreach($diplomabefores as $key => $value){
						echo '<span class="inputgroup"><label for="diplomabefores'.$value.'">'.htmlspecialchars($value).'</label><input id="diplomabefores'.$value.'" name="diplomabefore[]" type="checkbox" value="'.$key.'"'.(((intval($diplomabefore) & intval($key)) > 0)?' checked="checked"':'').' /></span>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td class="title">
					颁发文凭：
				</td>
				<td>
					<?php
					$diplomaafters = array('1' => '小学','2' => '初中','4' => '高中' ,'8' => '中专' ,'16' => '大专','32' => '本科');
					foreach($diplomaafters as $key => $value){
						echo '<span class="inputgroup"><label for="diplomaafters'.$value.'">'.htmlspecialchars($value).'</label><input id="diplomaafters'.$value.'" name="diplomaafter[]" type="checkbox" value="'.$key.'"'.(((intval($diplomaafter) & intval($key)) > 0)?' checked="checked"':'').' /></span>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td class="title">
					学习时间：
				</td>
				<td>
					<input name="teachdate" type="text" value="<?php echo $teachdate; ?>" class="valueprev" />
					<select name="teachunit" class="valuenext">
						<?php
						$teachunits = array('0' => '无','1' => '年','2' => '月','3' => '天','4' => '小时');
						foreach($teachunits as $key => $value){
							echo '<option value="'.$key.'"'.($teachunit==$key?' selected="selected"':'').'>'.htmlspecialchars($value).'</option>';
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">
					剩余名额：
				</td>
				<td>
					<input name="levecount" type="text" value="<?php echo $levecount; ?>" class="value" />
				</td>
			</tr>
			<tr>
				<td class="title">
					优惠
				</td>
				<td>
					<textarea name="preferential" class="value"><?php echo $preferential; ?></textarea>
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