$(function(){
	$(".content").on("click","a.mark",function(e){
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				query();
			}
		});
		return false;
	});
	
	$(".content").on("click","a.unmark",function(e){
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				query();
			}
		});
		return false;
	});
	
	$(".content").on("click","a.delete",function(e){
		if(!confirm('确定删除该留言')){
			return false;
		}
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				query();
			}
		});
		return false;
	});
	$("#btnDelete").click(function(e){
		var sender = this;
		if(!confirm('确定删除该留言')){
			return false;
		}
		$li = $(".content .checkboxid:checked");
		if($li.length == 0)
		{
			return false;
		}
		var ids = Array();
		$li.each(function(i,o){
			ids.push('ids[]='+o.value);
		});
		$.ajax({
			url:sender.href,
			type:'post',
			data:ids.join('&'),
			cache:false,
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				$("#checkedAll").prop('checked',false);
				query();
			}
		});
		return false;
	});
	$("#checkedAll").change(function(){
		var sender = this;
		$(".content .checkboxid").each(function(i,o){
			o.checked=sender.checked;
		});
	});
	
	
});