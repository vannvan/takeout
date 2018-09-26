var dialog={
	//错误弹出层
	error:function (message) {
		layer.open({
			content:message,
			icon:5,
			shift: -1,//解决按钮延迟
			title:'错误提示',
		});
	},
     //成功弹出层
     success:function(message,url){
     	layer.open({
     		content:message,
     		icon:1,shift: -1,//解决按钮延迟
     		shift: -1,//解决按钮延迟
     		yes :function(){
     			location.href=url;
     		},
     	});
     },
     //确认弹出层
     confirm:function(message,url){
     	layer.open({
     		content:message,
     		icon:3,
     		btn :['是','否'],
     		yes :function(){
     			location.href=url;
     		},
     	});
     },
     //未登陆
     

}