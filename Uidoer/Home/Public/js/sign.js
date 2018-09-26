//签到操作
$("#User-Sign").click(function(){
    var userid=$(this).attr('data-id');
    var data={'userid':userid}
    var url=signurl;
    $.post(url,data,function(result){
        if(result.status==1){
         //成功提示
          layer.open({
            content: result.message
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
            ,end: function(){
                window.location.reload();//刷新当前页面，及时显示积分更新信息
                }
          });
        }else if(result.status==0){
        //底部提示
          layer.open({
            content: result.message
            ,skin: 'footer'
            ,time:1
          });
        }else if(result.status==2){
            //底部提示
          layer.open({
            content: result.message
            ,skin: 'footer'
            ,time:1
          });
        }
    },"JSON")
});