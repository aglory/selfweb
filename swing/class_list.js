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
					width:800,
					height:650
				});
				$("#editorForm").validate({
					rules:{
						name:{required:true}
					},
					messages:{
						name:"请输入班级名称"
					}
				});
				
				var editorDescript = KindEditor.create('#description',{
					width: 500,
					
					minWidth: 500,
					height: 100,
					minHeight: 100,
					items:[
						'source', 'undo', 'redo', 'template', 'code', 'cut', 'copy', 'paste',
						'plainpaste', 'wordpaste', 'justifyleft', 'justifycenter', 'justifyright',
						'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
						'superscript', 'clearhtml', 'quickformat', 'selectall',
						'formatblock', 'fontname', 'fontsize', 'forecolor', 'hilitecolor', 'bold',
						'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', 
						'image', 'multiimage', /*'flash', 'media',*/ 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
						'anchor', 'link', 'unlink','fullscreen'
					],
					uploadJson:"admin.php?model=upload&action=ajaxkindedior"
				});
				$("#editorForm button.submit").click(function(e){
					var sender = this;
					var frm = this.form;
					editorDescript.sync();
					if(!$(frm).valid())
						return;
					$(sender).attr('disabled','disabled');
					$.ajax({
						url:frm.action,
						method:frm.method,
						dataType:'json',
						data:$(frm).serialize(),
						success:function(e){
							if(!e)return;
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
		if($(this).hasClass('status1') && !confirm('确定停止该班级')){
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
	
	
});