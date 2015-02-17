<?php
if(!defined('Execute') && !defined('Administartor')){ exit();}
header("Content-Type: text/html;charset=utf-8");
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
			
			
		<script type="text/javascript" src="/swing/admin.js"></script>
		<link type="text/css" rel="stylesheet" href="/swing/admin.css" />
		
		<script type="text/javascript" src="/swing/<?php echo Model,'_',Action ?>.js" ></script>
		<link type="text/css" rel="stylesheet" href="/swing/<?php echo Model,'_',Action ?>.css" />
		
		<script type="text/javascript" src="/js/kindeditor/kindeditor-min.js"></script>
		<script type="text/javascript" src="/js/kindeditor/lang/zh_CN.js"></script>
		
	</head>
	
	
	
<body>
    <!--top-->
    <nav id="main-nav">
		<ul class="container_12">
			<li id="navlogo">
                <div class="logo"></div>
            </li>
			<li id="navindex">
				<a class="navigationitem" href='<?php ActionLink('index','index') ?>'>首页</a>
			</li>
			<li id="navmessage">
				<a class="navigationitem" href='<?php ActionLink('list','message') ?>'>消息管理</a>
			</li>
			<li id="navschool">
				<a class="navigationitem" href='<?php ActionLink('list','school') ?>'>学校管理</a>
			</li>
			<li id="navclass">
				<a class="navigationitem" href='<?php ActionLink('list','class') ?>'>班级管理</a>
			</li>
			<li id="navcategory">
				<a class="navigationitem" href='<?php ActionLink('list','category') ?>'>分类管理</a>
			</li>
			<li id="navjob">
				<a class="navigationitem" href='<?php ActionLink('list','job') ?>'>就业管理</a>
			</li>
			
		</ul> 
         
	</nav>
   
    <div id="sub-nav">    
    <div class="dq_class"><!--当前位置：--></div>
        <div class="exit_class">
        <q>当前用户:&nbsp;<span>管理员</span></q><a>退出系统</a>
        </div>
    </div>
	<!-- End status bar -->	

    <div id="header-shadow"></div>
    <div id="ContentCon">
		<?php
		require './swing/'.$model.'_'.$action.'.php';
		?>
    </div>

    <div id="footer_main">
    </div>

</body>
</html>
<script type="text/javascript">
	ini();
</script>