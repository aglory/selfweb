<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="/css/base.css" />
		<link type="text/css" rel="stylesheet" href="/css/message.css" />
	</head>
	<body>
		<?php Render('header')?>
		<div class="blockborder wrap body">
		
		
			<fieldset>
				<legend>
					留言资讯
				</legend>
				<form id="frmSubmit" method='post' action='<?php ActionLink('post','message') ?>'>
				<table class="editortemplate">
					<tr>
						<td class="label">
							<label for="tel">电话：</label>
						</td>
						<td class="input">
							<input id='tel' class="inputdom" name='tel' placeholder="请留下你的电话，我们将于你联系" />
						</td>
						<td class="validate">
						</td>
					</tr>
					<tr>
						<td class="label">
							<label for="message">电话：</label>
						</td>
						<td class="input">
							<textarea id='message' class="inputdom" name='message' placeholder="请留下你要咨询的问题，我们将为你解答"></textarea>
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