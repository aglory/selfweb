<?php
	if(!defined('Execute') && !defined('Administartor')){ exit();}
	$categoryid = 0;
	if(array_key_exists('categoryid',$_GET)){
		$categoryid = intval($_GET['categoryid']);
	}
?>
<article class="container_12">
    <section class="grid_12">
        <div class="block-border">
            <form action="<?php ActionLink('ajaxlist','job')?>" method="post" id="mainForm" class="block-content form">
				<input type="hidden" id="pageIndex" name="pageIndex" value="1" />
				<input type="hidden" id="pageSize" name="pageSize" value="20" />
				<input type="hidden" id="orderBy" name="orderBy" value="" />
                <h1>职位管理</h1>	
		        <div class="block-controls">
				    <div class="AddLink"><a class="editor" href="<?php ActionLink('dialogeditor','job',array('id' => 0,'categoryid' => $categoryid))?>" title="新增职位"><span></span><q>新增职位</q></a></div>
			        <ul class="controls-buttons">
				        <li><input id="name" name="name" type="text" placeholder="输入职位名称查询" /></li>
						<li>类别
							<select name ="categoryid">
								<option value="0">全部</option>
								<?php
								$sthcategory = $pdomysql -> prepare("select id,name from tbCategoryInfo where id = $categoryid or status = 1;");
								$sthcategory -> execute();
								foreach($sthcategory -> fetchAll(PDO::FETCH_ASSOC) as $item){
									echo '<option value="'.$item['id'].'"'.($item['id'] == $categoryid?' selected="selected"':'').'>'.htmlspecialchars($item['name']).'</option>';
								}
								?>
							</select>
						</li>
						<li>方式
							<select name ="methodtype">
								<?php
								$methods = array('0' => '全部' ,'1' => '直签','2' => '派遣','4' => '先派遣后直签');
								foreach($methods as $key => $value){
									echo '<option value="'.$key.'">'.htmlspecialchars($value).'</option>';
								}
								?>
							</select>
						</li>
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
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="j.name">职位名称</a>
                            </th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="j.categoryid">类别</a>
                            </th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="j.sex">类别</a>
                            </th>
							<th scope="col">
								服务费用
							</th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="j.method">劳务方式</a>
                            </th>
                            <th scope="col">
                                <span class="column-sort">
						            <a class="sort-up"></a>
						            <a class="sort-down"></a>
					            </span>
                                <a href="javascript:;" title="单击排序" class="btn-sort-order" sort-expression="j.`order`">顺序</a>
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