<?php
if(!defined('Execute')){ exit();}
header("Content-Type: text/html;charset=utf-8");
include 'cgi/pdo.php';
?>
<table style="width:100%;">
	<thead>
		<tr>
			<th>电话</th>
			<th>消息</th>
			<th>操作</th>
		</tr>
	</thead>
<?php
	$pdosqlite -> exec('create table if not exists [messages](id INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT,tel,msg);');
	$sth = $pdosqlite -> query('select id,tel,msg from [messages];');
	$sth -> execute();
	foreach($sth -> fetchAll(PDO::FETCH_ASSOC) as $item){
			echo '<td>'.htmlspecialchars($item['tel']).'</td>';
			echo '<td>'.htmlspecialchars($item['msg']).'</td>';
			echo '<td><a href="',ActionLink('delete','message',array('id'=>$item['id']),true),'">删除</a></td>';
		echo '</tr>';
	}
?>
</table>