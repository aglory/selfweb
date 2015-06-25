<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$classid = 0;
	if(array_key_exists('classid',$_GET)){
		$classid = intval($_GET['classid']);
	}
	$keyid = 0;
	if(array_key_exists('keyid',$_GET)){
		$keyid = intval($_GET['keyid']);
	}
	
?>
<article class="container_12">
    <section class="grid_12">
        <div class="block-border">
            <form action="<?php ActionLink('ajaxlist','classpropertyvalue')?>" method="post" id="mainForm" class="block-content form">
				<input type="hidden" id="pageIndex" name="pageIndex" value="1" />
				<input type="hidden" id="pageSize" name="pageSize" value="20" />
				<input type="hidden" id="orderBy" name="orderBy" value="" />
				<input type="hidden" id="classid" name="classid" value="<?php echo $classid ?>" />
				<input type="hidden" id="keyid" name="keyid" value="<?php echo $keyid ?>" />
                <h1>属性管理</h1>	
		        <div class="block-controls">
				    <div class="AddLink"><a class="editor" href="<?php ActionLink('dialogeditor','classpropertyvalue',array('id' => 0,'classid' => $classid,'keyid' => $keyid))?>" title="新增属性"><span></span><q>新增属性</q></a></div>
			        <ul class="controls-buttons">
				        <li><input id="value" name="value" type="text" placeholder="输入属性值称查询" /></li>
						<li>重要程度<select name="targetlevel">
							<option value="0">全部</option>
							<option value="1">normal</option>
							<option value="2">primary</option>
							<option value="3">info</option>
							<option value="4">warn</option>
							<option value="5">error</option>
						</select></li>
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
								属性值
                            </th>
							<th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="targetlevel">重要程度</a>
							</th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="`order`">顺序</a>
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