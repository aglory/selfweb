$(function(){
	window.ajaxSuccess=function(e){
		$("#divFormGroup").html(e.form);
	}
	
	$("#mainForm").on("click","a.keyeditor",function(e){
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
						targetlevel:{min:1},
						displaytype:{min:1}
					},
					messages:{
						name:{required:"请输属性名称"},
						targetlevel:{min:"请选择重要程度"},
						displaytype:{min:"请选择展示方式"}
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
	
	$(".content").on("click","a.keystatus",function(e){
		if($(this).hasClass('status1') && !confirm('确定停止该属性')){
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
	
	
	$(".content").on("click","a.keymove",function(e){
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
	
	$(".content").on("click","a.keymoveinput",function(e){
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
	
	
		
	function groupQuery(keyid){
		var formId="#groupform"+keyid;
		if($(formId).length==0){
			return;
		}		
		$("#tr_property_key_"+keyid).mask("loading");
		$.ajax({
			url:$(formId).attr('action'),
			type:$(formId).attr('method'),
			data:$(formId).serialize(),
			dataType:"json",
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				var pageIndex = parseInt($(formId+" input[name='pageIndex']").val());
				var pageSize = parseInt($(formId+" input[name='pageSize']").val());
				$(".tr_property_key_"+keyid+"_value").remove();
				$("#tr_property_key_"+keyid).after(e.value);
				$("#tr_property_key_"+keyid+"_pager").pager({pageIndex:pageIndex, pageSize:pageSize, recordCount:e.recordCount, pageIndexChanged:function(e){
					$(formId+" input[name='pageIndex']").val(e);
					groupQuery(keyid);
				}});
			},complete:function(){
				$("#tr_property_key_"+keyid).unmask();
			}
		});
	}

	
	$("#mainForm").on('click','.keyvalue',function(e){
		groupQuery(this.rel);
		return false;
	});
	
	$(".content").on('click','.valueeditor',function(e){
		var sender = this;
		var rel = sender.rel;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(html){
				$("#dialog").html(html);
				$("#dialog").dialog({
					title:$(sender).attr('title'),
					width:600,
					height:300
				});
				$("#editorForm").validate({
					rules:{
						value:{required:true},
						targetlevel:{min:1},
						displaytype:{min:1}
					},
					messages:{
						value:{required:"请输属性值"},
						targetlevel:{min:"请选择重要程度"},
						displaytype:{min:"请选择展示方式"}
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
							groupQuery(rel);
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
	
	
	$("#mainForm").on('click','.valuemoveinput',function(e){
		var sender = this;
		var rel = sender.rel;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(html){
				$("#dialog").html(html);
				$("#dialog").dialog({
					title:$(sender).attr('title'),
					width:600,
					height:300
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
							groupQuery(rel);
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
	
	$(".content").on('click','a.valuestatus',function(e){
		if($(this).hasClass('status1') && !confirm('确定停止该属性值')){
			return false;
		}
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				groupQuery(sender.rel);
			}
		});
		return false;
	});
	
	$(".content").on("click","a.valuemove",function(e){
		var sender = this;
		$.ajax({
			url:sender.href,
			cache:false,
			success:function(e){
				if(!e)return;
				if(!e.status){alert(e.message);return;}
				groupQuery(sender.rel);
			}
		});
		return false;
	});
	
});