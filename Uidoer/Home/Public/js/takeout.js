//提现脚本
$("#takeout").click(function(){
    var money=$("input[name='money']").val();
    var userid=$(this).attr('data-id');
    if(money==''||money==null||money<10){
      //底部提示
        layer.open({
          content: '请输入有效金额'
          ,skin: 'footer'
          ,time:1
        });
    }else{
      var url=takeouturl;
      var data={'userid':userid,'money':money}
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
                    window.location.href=backurl;//返回到用户中心
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