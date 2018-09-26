//删除操作
$(".delete").click(function(){
	var id=$(this).attr('data-id');
	var url=scope.deleteurl;
	//alert(url);
	data={};
	data['id']=id;
	data['status']=-1;
	// var data={'id':id,'status':-1}
	layer.open({
		type:0,
		title:'是否提交?',
		btn:['yes','no'],
		icon:3,
		closeBtn:1,//关闭按钮样式
		content:"是否确定删除？",
		scrollbar:true,
		yes:function(){
			//执行操作
			todelete(url,data);
		},
	});
});

function todelete(url,data){
	$.post(
		url,
		data,
		function(result){
			if(result.status==1){
				return dialog.success(result.message,'');
			}else{
				return dialog.error(result.message);
			}
		},"JSON");
}
//拉黑操作
$("#disabled").click(function(){
	var id=$(this).attr('data-id');
	var url=scope.disableurl;
	//alert(url);
	data={};
	data['id']=id;
	data['status']=-1;
	// var data={'id':id,'status':-1}
	layer.open({
		type:0,
		title:'是否提交?',
		btn:['yes','no'],
		icon:3,
		closeBtn:1,//关闭按钮样式
		content:"是否确定拉黑？",
		scrollbar:true,
		yes:function(){
			//执行操作
			todisable(url,data);
		},
	});
});

function todisable(url,data){
	$.post(
		url,
		data,
		function(result){
			if(result.status==1){
				return dialog.success(result.message,'');
			}else{
				return dialog.error(result.message);
			}
		},"JSON");
}
//恢复操作
$("#enabled").click(function(){
	var id=$(this).attr('data-id');
	var url=scope.enableurl;
	//alert(url);
	data={};
	data['id']=id;
	data['status']=1;
	// var data={'id':id,'status':-1}
	layer.open({
		type:0,
		title:'是否提交?',
		btn:['yes','no'],
		icon:3,
		closeBtn:1,//关闭按钮样式
		content:"是否确定恢复？",
		scrollbar:true,
		yes:function(){
			//执行操作
			toenable(url,data);
		},
	});
});

function toenable(url,data){
	$.post(
		url,
		data,
		function(result){
			if(result.status==1){
				return dialog.success(result.message,'');
			}else{
				return dialog.error(result.message);
			}
		},"JSON");
}
