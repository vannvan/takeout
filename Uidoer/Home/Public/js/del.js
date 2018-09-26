//删除操作
$("#del").click(function(){
	var id=$(this).attr('data-id');
	var url=delurl;
	data={};
	data['id']=id;
	data['status']=-1;
	// var data={'id':id,'status':-1}
	
	//底部对话框
	  layer.open({
	    content: '确认要狠心删除吗？'
	    ,btn: ['删除', '取消']
	    ,skin: 'footer'
	    ,yes: function(index){
	      todelete(url,data);
	    }
	  });

});

function todelete(url,data){
	$.post(
		url,
		data,
		function(result){
			if(result.status==1){
				return layer.open({
				    content: '删除成功'
				    ,skin: 'msg'
				    ,time: 2 //2秒后自动关闭
				    ,end: function(){
                    window.location.href=back;//反馈到信息页面
                  }
				  });

			}else{
				return layer.open({
				    content: '删除失败'
				    ,skin: 'msg'
				    ,time: 2 //2秒后自动关
				  });
			}
		},"JSON");
}