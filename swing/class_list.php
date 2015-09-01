<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$schoolid = 0;
	if(array_key_exists('schoolid',$_GET)){
		$schoolid = intval($_GET['schoolid']);
	}
?>
<script type="text/javascript" src="/js/kindeditor/kindeditor-min.js"></script>
<article class="container_12">
    <section class="grid_12">
        <div class="block-border">
            <form action="<?php ActionLink('ajaxlist','class')?>" method="post" id="mainForm" class="block-content form">
				<input type="hidden" id="pageIndex" name="pageIndex" value="1" />
				<input type="hidden" id="pageSize" name="pageSize" value="20" />
				<input type="hidden" id="orderBy" name="orderBy" value="" />
				<input type="hidden" id="schoolid" name="schoolid" value="<?php echo $schoolid?>" />
                <h1>班级管理</h1>	
		        <div class="block-controls">
				    <div class="AddLink"><a class="editor" href="<?php ActionLink('dialogeditor','class',array('id' => 0 ,'schoolid' => $schoolid))?>" title="新增班级"><span></span><q>新增班级</q></a></div>
			        <ul class="controls-buttons">
						<li>无学校<input name="noschoolid" type="checkbox" value="1" /> </li>
						<li><input name="schoolname" type="text" value="" placeholder="输入学校名称查询" /></li>
				        <li><input id="name" name="name" type="text" placeholder="输入班级名称查询" /></li>
						<li>状态<select name="status"><option value="0">全部</option><option value="1">启用</option><option value="2">停用</option></select></li>
				        <li><a class="btn" id="btnSeacher" title="搜索">搜索<img src="/images/icons/fugue/navigation.png" width="16" height="16"></a></li>
				        <li class="sep"></li>
				        <li><a class="btn" id="btnRefresh" title="刷新"><img src="/images/icons/fugue/arrow-circle.png" width="16" height="16"></a></li>
			        </ul>
		        </div>
                <div class="no-margin">
                    <table cellspacing="0" width="100%" class="table">
                    <thead>
                        <tr class="mainTable-head">
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="c.Name">班级名称</a>
                            </th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="s.Name">学校名称</a>
                            </th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="c.price">学费</a>
                            </th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="c.order">顺序</a>
                            </th>
                            <th scope="col" class="table-actions">操作</th>
                        </tr>
                        </thead>
                        <tbody class="content">
                        </tbody>
                    </table>
                </div>
                <ul class="message no-margin"><li id="pager" class="pagerRemark">Loading...</li></ul>		
		        <div class="block-footer">
			        <div class="float-right">
				        <label for="table-display" style="display:inline">显示</label>	 
                        <select size="1" id="pageSizeChange">
                            <option value="10">10</option>
                            <option value="20" selected="selected">20</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="table-display" style="display:inline">记录</label>
			        </div>
			        <img src="/images/icons/fugue/arrow-curve-000-left.png" width="16" height="16" class="picto"> 
                    <div class="pager" style="height: 30px; margin: 5px; float: left"></div>
		        </div>
            </form>
        </div>
    </section>

    <div class='dialog' id='dialog' style="display:none">
	</div>

</article>