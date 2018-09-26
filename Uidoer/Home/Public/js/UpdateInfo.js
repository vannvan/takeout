//更改资料验证
$("#setInfo").click(function(){
    var userinfo=$("#userinfo").serializeArray();
    postdata={}
    $(userinfo).each(function(i){
        postdata[this.name]=this.value;
    });
    //console.log(postdata);
    var url=mod;
    $.post(url,postdata,function(result){
        if(result.status==1){
         //成功提示
          layer.open({
            content: result.message
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
            ,end: function(){
                window.location.href=backurl;//返回到用户中心
                }
          });
        }else if(result.status==0){
        //底部提示
          layer.open({
            content: result.message
            ,skin: 'footer'
            ,time:1
          });
        }
    },"JSON")
});