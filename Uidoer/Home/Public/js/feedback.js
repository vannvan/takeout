//反馈操作
$("#feedback").click(function(){
    var url=feedurl;
    var backurk=backurl;
    var content=$("#content").val();
    var data={'content':content}
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
})
