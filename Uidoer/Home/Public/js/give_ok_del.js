//删除操作
$(".giveup").click(function(){
	var id=$(this).attr('data-id');
	var url=giveup;
	data={};
	data['id']=id;
	data['status']=1;
	// var data={'id':id,'status':-1}
	
	//底部对话框
	  layer.open({
	    content: '取消操作会降低信用度，确认要取消吗？'
	    ,btn: ['确认取消', '继续派送']
	    ,skin: 'footer'
	    ,yes: function(index){
	      togiveup(url,data);
	    }
	  });

});

function togiveup(url,data){
	$.post(
		url,
		data,
		function(result){
			if(result.status==1){
				return layer.open({
				    content: '取消成功'
				    ,skin: 'msg'
				    ,time: 2 //2秒后自动关闭
				    ,end: function(){
                    window.location.reload();//反馈到信息页面
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
//删除派送记录
$(".del-send").click(function(){
	var url=delsend;
	var orderid=$(this).attr('data-id');
	var data={'id':orderid,'status':-3}
        $.post(url,data,function(result){
            //错误提示
            if(result.status==0){
                layer.open({
                content: result.message
                ,skin: 'footer'
                ,time:1
              });
            }
            //成功提示
            if(result.status==1){
                layer.open({
                    content: result.message
                    ,skin:'msg'
                    ,time:1
                    ,end: function(){
                    window.location.reload();//刷新本页面
                    }
                  });
            }
            //非法提示
            if(result.status==-1)
            {
                layer.open({
                    content: result.message
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
            }

        },'JSON');
})