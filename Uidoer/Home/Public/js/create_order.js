//提交订单
$("#Order_btn").click(function(){
    var orderinfo=$("#order_form").serializeArray();
    //价格+加速达+附加品+派送费
    postdata={};
    var price=Number($('input[name="price"]').val());
    var sendprice=Number($('input[name="sendprice"]').val());
    var quiksend=Number($('input[name="quiksend"]').val());
    var additional=Number($('input[name="additional"]').val());
    var paymoney=(price+sendprice+quiksend+additional);//应付金额
    var ordnum=Number($('input[name="ordnum"]').val());
    postdata['paymoney']=paymoney;
    $(orderinfo).each(function(i){
        postdata[this.name]=this.value;
    });
    //console.log(postdata);
    var url=createurl;
    $.post(url,postdata,function(result){
        if(result.status==1){
         ///loading带文字
          layer.open({
            type: 2
            ,content: result.message
            ,time:2
            ,end: function(){
                 window.location.href=payurl;
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