function query(){
	if($("#mainForm").length==0){
		return;
	}
	
    $(".content").mask("loading");
	
	$.ajax({
		url:$("#mainForm").attr('action'),
		type:$("#mainForm").attr('method'),
		data:$("#mainForm").serialize(),
		dataType:"json",
		success:function(e){
			if(!e)return;
			if(!e.status){alert(e.message);return;}
			if(window.ajaxSuccess!=undefined)
				ajaxSuccess(e);
			var pageIndex = parseInt($("#pageIndex").val());
			var pageSize = parseInt($("#pageSize").val());
			$(".content").html(e.value);
			
			$("#pager").pager({pageIndex:pageIndex, pageSize:pageSize, recordCount:e.recordCount, pageIndexChanged:function(e){
				$("#pageIndex").val(e);
				query();
			}});
		},complete:function(){
			$(".content").unmask();
			if(window.ajaxComplete!=undefined)
				ajaxComplete();
		},error:function(){
			if(window.ajaxError!=undefined)
				ajaxError();
		}
	});
}

function ini(){
	query();
	$("#pageSizeChange").change(function(){
		var sender = this;
		$("#pageSize").val(sender.value);
		query();
	});
	$("#btnSeacher").click(function(){
		$("#pageIndex").val(1);
		query();
	});
	$("#btnRefresh").click(function(){
		query();
	});
	$("#mainForm").on("click",".mainTable-head .btn-sort-order",function(e){
		var lis = ($("#orderBy").val().length==0)? (new Array()) : $("#orderBy").val().split(",");
		var liv = new Array();
		var key = $(this).attr('sort-expression');
		var f = false;
		for(var i = lis.length;i>0;i--){
			var s = lis[i-1];
			var p = s.split(" ");
			var k = p[0];
			var v = p[1];
			if(k!==key){
				liv.unshift(s);
				continue;
			}
			f = true;
			if(v == 'asc'){
				$(this).parent().find(".column-sort a").removeClass("active");
				continue;
			}
			if(v == 'desc'){
				$(this).parent().find(".column-sort a").removeClass("active").filter(".sort-up").addClass('active');
				liv.unshift(key + " asc");
				continue;
			}
		}
		if(!f){
			$(this).parent().find(".column-sort a").removeClass("active").filter(".sort-down").addClass('active');
			liv.push(key+" desc");
		}
		$("#orderBy").val(liv.join(','));
		query();
	});
}
	