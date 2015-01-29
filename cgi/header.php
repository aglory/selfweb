<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
?>
<header class="wrap">
	<ul class="navigation">
		<li class="navigationitem"><a <?php if(Model=='index'){ ?>class="current"<?php }?> href="<?php ActionLink('index','index')?>">首&nbsp;&nbsp;页</a></li>
		<li class="navigationitem"><a <?php if(Model=='school' || Model == 'class'){ ?>class="current"<?php }?> href="<?php ActionLink('list','school')?>">学校介绍</a></li>
		<li class="navigationitem"><a <?php if(Model=='apply'){ ?>class="current"<?php }?> href="<?php ActionLink('index','apply')?>">在线报名</a></li>
		<li class="navigationitem"><a <?php if(Model=='message'){ ?>class="current"<?php }?> href="<?php ActionLink('index','message')?>">咨询留言</a></li>
		<li class="navigationitem"><a href="#">就业安置</a></li>
		<li class="navigationitem"><a href="#">协助成考</a></li>
	</ul>
</header>