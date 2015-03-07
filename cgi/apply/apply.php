<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include './cgi/pdo.php';

$schoolname = '';$classname = '';

if(array_key_exists('schoolid', $_REQUEST)){
	$sth_school = $pdomysql -> prepare('select * from tbSchoolInfo where guid = :schoolid;');
	$sth_school -> execute(array('schoolid' => $_REQUEST['schoolid']));
	foreach($sth_school -> fetchAll(PDO::FETCH_ASSOC) as $school){
		$schoolname = $school['name'];
	}
}
if(array_key_exists('classid', $_REQUEST)){
	$sth_class = $pdomysql -> prepare('select * from tbClassInfo where guid = :classid;');
	$sth_class -> execute(array('classid' => $_REQUEST['classid']));
	foreach($sth_class -> fetchAll(PDO::FETCH_ASSOC) as $class){
		$classname = $class['name'];
	}
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
		<link type="text/css" rel="stylesheet" href="/css/apply.css" />
	</head>
	<body>
		<?php Render('header')?>
		<div class="blockborder wrap body">
		
		
			<fieldset>
				<legend>
					<h1>在线报名</h1>
				</legend>
				<form id="frmSubmit" method='post' action='<?php ActionLink('save','apply') ?>'>
				<table class="editortemplate">
					<tr>
						<td class="label">
							<label for="schoolname">学校：</label>
						</td>
						<td class="input">
							<input id='schoolname' class="inputdom" name='schoolname' type="text" value="<?php echo $schoolname?>" />
						</td>
						<td class="validate">
						</td>
					</tr>
					<tr>
						<td class="label">
							<label for="classname">班级：</label>
						</td>
						<td class="input">
							<input id='classname' class="inputdom" name='classname' type="text" value="<?php echo $classname?>" />
						</td>
						<td class="validate">
						</td>
					</tr>
					<tr>
						<td class="label">
							<label for="studentname">姓名：</label>
						</td>
						<td class="input">
							<input id='studentname' class="inputdom" name='studentname' placeholder="学生姓名" />
						</td>
						<td class="validate">
						</td>
					</tr>
					<tr>
						<td class="label">
							<label for="contacttel">联系方式：</label>
						</td>
						<td class="input">
							<input id='contacttel' class="inputdom" name='contacttel' placeholder="联系方式" />
						</td>
						<td class="validate">
						</td>
					</tr>
					<tr>
						<td class="label">
							<label for="remark">备注</label>
						</td>
						<td class="input">
							<textarea id='remark' class="inputdom" name='remark'></textarea>
						</td>
						<td class="validate">
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<button id="btSubmit" class="inputdom" type='submit'>确定</button>
						</td>
					</tr>
					
				</table>
					
					
				</form>
		
			</fieldset>
		</div>
		<?php Render('footer')?>
	</body>
	<script type="text/javascript">
		/*
		document.getElementById("btSubmit").onclick=function(){
			var tel = document.getElementById('tel').value);
			if(tel.length == 0){
				return false;
			}
			if(!/^1\d{10}$/.test(tel){
				alert('电话号码错误');
				return false;
			}
		}
		*/
	</script>
</html>