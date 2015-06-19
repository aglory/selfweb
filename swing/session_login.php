<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	header("Content-Type: text/html;charset=utf-8");
	
	$name='';$password='';
	if(array_key_exists('name',$_REQUEST) && !empty($_REQUEST['name'])){
		$name=$_REQUEST['name'];
	}
	if(array_key_exists('password',$_REQUEST) && !empty($_REQUEST['password'])){
		$password=$_REQUEST['password'];
	}
	if(!array_key_exists('ClientId',$_COOKIE) || empty($_COOKIE['ClientId'])){
		$ClientId = md5(mt_rand());
		setcookie('ClientId',$ClientId,0,'/',null,false,true);
	}else{
		$ClientId = $_COOKIE['ClientId'];
	}
	
?><!DOCTYPE html>
<html>
	<head>
		<title>后台管理</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src="/js/jquery-1.11.2.js"></script>
		
		<script type="text/javascript" src="/js/jquery-ui-1.9.1.min.js"></script>
		<link type="text/css" rel="stylesheet" href="/css/jquery-ui-1.9.1.min.css" />
		
		<script type="text/javascript" src="/swing/jquery.pager.js"></script>
		<link type="text/css" rel="stylesheet" href="/swing/jquery.pager.css" />
		
		
		
	  
		<script type="text/javascript" src="/swing/jquery.validate.min.js"></script>
		
		<script type="text/javascript" src="/swing/jquery.loadmask.min.js"></script>
		<link type="text/css" rel="stylesheet" href="/swing/jquery.loadmask.css" />
		
		<script type="text/javascript" src="/swing/sticky.js"></script>
		<link type="text/css" rel="stylesheet" href="/swing/sticky.css" />
		
		<link rel="stylesheet" type="text/css" href="/swing/base.css" />
		<link rel="stylesheet" type="text/css" href="/swing/table.css" />
		<link rel="stylesheet" type="text/css" href="/swing/reset.css" />
		<link rel="stylesheet" type="text/css" href="/swing/form.css" />
		<link rel="stylesheet" type="text/css" href="/swing/standard.css" />
		<link rel="stylesheet" type="text/css" href="/swing/common.css" />

		<!-- Custom styles -->
		<!--[if IE 8]><link rel="stylesheet" type="text/css" href="ie8.css" /><![endif]--> 
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="ie7common.css" /><![endif]-->
		<style type="text/css">
			body{text-align:center}
			table{
				margin:200px auto;
				width:400px;
				height:200px;
			}
			.label{text-align:right;}
			.input{text-align:left;}
			.input input{width:300px}
		</style>
		<script type="text/javascript">
			
			$(document).ready(function(){
				$("#subForm").submit(function(){
					var frm = document.getElementById('subForm');
					var sender = $("#subForm *[type='submit']");
					sender.prop('disabled',true);
					$.ajax({
						data:$(frm).serialize(),
						dataType:'json',
						type:frm.method,
						url:frm.action,
						success:function(e){
							if(!e)return;
							if(!e.status){alert(e.message);return;}
							windows.location='<?php ActionLink('index','index')?>';
						},
						complete:function(e){
							sender.prop('disabled',false);
						}
					});
					return false;
				});
			});
		
		</script>
	</head>
	<body>
		<form action="<?php ActionLink('ajaxlogin','session')?>" method="post" class="form" id="subForm">
			<div>
				<table>
					<tr>
						<td class="label"><label>账号：</label></td>
						<td class="input"><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name);?>" /></td>
					</tr>
					<tr>
						<td class="label"><label>密码：</label></td>
						<td class="input"><input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password);?>" type="password" /></td>
					</tr>
					<tr>
						<td colspan="2"><button class="submit" type="submit">登录</button><?php echo $_COOKIE['ClientId'];?></td>
					</tr>
				</table>
			</div>
		</form>
	</body>
</html>