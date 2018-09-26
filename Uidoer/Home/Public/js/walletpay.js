$("#wallet-pay").click(function(){
    var url=walletpayurl;
    var orderid=$(this).attr('data-id');
    var data={'id':orderid}
    //做一个看似加载的效果
    layer.open({
        type: 2
        ,content: '正在支付，请稍后！'
        ,time:2
        ,end: function(){
              topay(url,data);
          }
    });
 function topay(url,data){
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
                    window.location.href=notifyurl;//刷新本页面
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
     }
})