//确认订单
$(".order-ok").click(function(){
	var url=scope.orderok;
	var orderid=$(this).attr('data-id');
	var data={'id':orderid,'status':3}
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

//取消订单，状态应该改为-1，后应提示退款
$(".order-cancel").click(function(){
    var url=scope.ordercancel;
    var orderid=$(this).attr('data-id');
    var data={'id':orderid,'status':-1}
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

//重新购买，状态应该改为1
$(".order-rebay").click(function(){
    var url=scope.ordrebay;
    var orderid=$(this).attr('data-id');
    var data={'id':orderid,'status':1}
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


//删除订单，状态为-2
$(".order-del").click(function(){
    var url=scope.orderdel;
    var orderid=$(this).attr('data-id');
    var data={'id':orderid,'status':-2}
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

//彻底删除订单
$(".order-delete").click(function(){
    var url=scope.orderdelete;
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
