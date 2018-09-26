//验证手机以及发送验证码按钮操作
var sendurl=Sendcode;
//alert(sendurl);
var wait = 60;
    $("#Getcode").click(function(){
    	time(this);
    	var mobile = $("#mobile").val();
        var url = sendurl;
		 $.ajax({
          	 url:url,
          	 data:{mobile:mobile},
             type:'post',  
		 });
    });   
    function time(o) {
        if (wait == 0) {
            o.removeAttribute("disabled");
            o.innerHTML = "获取验证码";
            wait = 60;
        } else {
            o.setAttribute("disabled", true);
            o.innerHTML = wait + "秒后重新发送";
            wait--;
            setTimeout(function() {
                time(o)
            }, 1000)
        }
    }  
//提交资料验证
$("#reg").click(function(){
    var userinfo=$("#userinfo").serializeArray();
    postdata={};
    var resname=$("#restaurant").find("option:selected").text(); //获取当前选定的下拉列表value对应的text
    postdata['resname']=resname;
    $(userinfo).each(function(i){
        postdata[this.name]=this.value;
    });
    //console.log(postdata);
    var url=register;
    $.post(url,postdata,function(result){
        if(result.status==1){
         //成功提示
          layer.open({
            content: result.message
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
            ,end: function(){
                window.location.href=back;//返回到用户中心
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