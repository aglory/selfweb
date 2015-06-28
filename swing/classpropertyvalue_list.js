$(function(){
	$("#mainForm").on("click","a.editor",function(e){
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(html){
				$("#dialog").html(html);
				$("#dialog").dialog({
					//modal:true,
					title:$(sender).attr('title'),
					width:600,
					height:300
				});
				$("#editorForm").validate({
					rules:{
						name:{required:true},
						targetlevel:{min:1}
					},
					messages:{
						name:{required:"请输属性值"},
						targetlevel:{min:"请选择重要程度"}
					}
				});

				$("#editorForm button.submit").click(function(e){
					var sender = this;
					var frm = this.form;
					if(!$(frm).valid())
						return;
					$(sender).attr('disabled','disabled');
					$.ajax({
						url:frm.action,
						method:frm.method,
						dataType:'json',
						data:$(frm).serialize(),
						success:function(e){
							if(!e) return;
							if(!e.status){alert(e.message);return;}
							$("#editorForm :input[name='id']").val(e.id);
							$.sticky("保存成功", { type: "st-success" });
							$("#dialog").dialog("close");
							query();
						},
						complete:function(e){
							$(sender).removeAttr('disabled');
						}
					});
				});
			}
		});
		return false;
	});
	
	$(".content").on("click","a.status",function(e){
		if($(this).hasClass('status1') && !confirm('确定停止该职位')){
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
	
	
	$(".content").on("click","a.move",function(e){
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
	
	$(".content").on("click","a.moveinput",function(e){
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(html){
				$("#dialog").html(html);
				$("#dialog").dialog({
					//modal:true,
					title:$(sender).attr('title'),
					width:400,
					height:200
				});
				$("#editorForm").validate({
					rules:{
						order:{required:true,number:true}
					},
					messages:{
						order:{required:"请正确输入排序数字",number:"请正确输入排序数字"}
					}
				});

				$("#editorForm button.submit").click(function(e){
					var sender = this;
					var frm = this.form;
					if(!$(frm).valid())
						return;
					$(sender).attr('disabled','disabled');
					$.ajax({
						url:frm.action,
						method:frm.method,
						dataType:'json',
						data:$(frm).serialize(),
						success:function(e){
							if(!e) return;
							if(!e.status){alert(e.message);return;}
							$("#dialog").dialog("close");
							query();
						},
						complete:function(e){
							$(sender).removeAttr('disabled');
						}
					});
				});
			}
		});
		return false;
	});
	
	
});