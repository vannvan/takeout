$(".send-btn").click(function(){
	var url=sendurl;
	var orderid=$(this).attr('data-id');
	var data={'id':orderid}
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
                    ,btn: '确认'
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