//登录验证
var login={
	check:function(){
		var sysname=$('input[name="sysname"]').val();
		var password=$('input[name="password"]').val();
		var code=$('input[name="code"]').val();
		if(sysname==''){
			dialog.error('用户名不能为空');
		}
		if(password==''){
			dialog.error('密码不能为空');
		}
		if(code==''){
			dialog.error('验证码不能为空');
		}
		var url=checkurl;
		var data={'sysname':sysname,'password':password,'code':code}
		$.post(url,data,function(result){
			if(result.status==0){
				dialog.error(result.message);
			}
			if(result.status==1){
				layer.msg(result.message, function(){
				$(location).attr('href', indexurl);//回到首页
			});
			}
			if(result.status==2){
				//$(location).attr('href', gotourl);//回到首页
				//dialog.success(result.message,gotourl);//跳出弹框确认后进首页
				// layer.msg(result.message, function(){
				// $(location).attr('href', gotourl);//回到首页
				layer.load();
				//此处演示关闭
				setTimeout(function(){
				  layer.closeAll('loading');
				  $(location).attr('href', gotourl);
				}, 800);
				
			}
		},'JSON');
	}
}
