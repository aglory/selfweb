<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
?>
<article class="container_12">
    <section class="grid_12">
        <div class="block-border">
            <form action="<?php ActionLink('ajaxlist','message')?>" method="post" id="mainForm" class="block-content form">
				<input type="hidden" id="pageIndex" name="pageIndex" value="1" />
				<input type="hidden" id="pageSize" name="pageSize" value="20" />
				<input type="hidden" id="orderBy" name="orderBy" value="" />
                <h1>消息管理</h1>	
		        <div class="block-controls">
			        <ul class="controls-buttons">
				        <li><select name='status'><option value="0">全部</option><option value="1">未标记</option><option value="2">已标记</option><option value="3">已删除</option></select></li>
				        <li><a class="btn" id="btnSeacher" title="搜索">搜索<img src="/images/icons/fugue/navigation.png" width="16" height="16"></a></li>
				        <li class="sep"></li>
						<li><a class="btn" id="btnDelete" title="删除" href="<?php ActionLink('ajaxdelete','message',null,true)?>">删除</a></li>
				        <li><a class="btn" id="btnRefresh" title="刷新"><img src="/images/icons/fugue/arrow-circle.png" width="16" height="16"></a></li>
			        </ul>
		        </div>
                <div class="no-margin">
                    <table cellspacing="0" width="100%" class="table">
                    <thead>
                        <tr class="mainTable-head">
                            <th scope="col" class="tel">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
								<input id="checkedAll" type="checkbox" />
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="tel">电话</a>
                            </th>
                            <th scope="col">
								消息
                            </th>
                            <th scope="col" class="datetime">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="datecreate">留言时间</a>
                            </th>
                            <th scope="col" class="datetime">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="datemodify">操作时间</a>
                            </th>
                            <th scope="col" class="status">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="status">状态</a>
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