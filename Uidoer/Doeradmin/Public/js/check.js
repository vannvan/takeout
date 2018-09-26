function validateForm(){
  var txt = "名称不能为空! ";
  var txt1 = "店铺描述不能为空! ";
  var txt2 = "图片不能为空！";
  var txt3 = "QQ不能为空！";
  var txt4 = "联系方式不能为空！";
  var txt5 = "类名不能为空！";
  var title=$("input[name='name']").val();
  var desc=$("#textArea").val();
  var img=$("input[name='image']").val();
  var qq=$("input[name='qq']").val();
  var tel=$("input[name='tel']").val();
  var class=$("input[name='class']").val();
  if(title==""){
    dialog.error(txt);
    return false;
  };
  if(desc==""){
    dialog.error(txt1);
    return false;
  }
  if(class==""){
    dialog.error(txt5);
    return false;
  }
  if(qq==""){
    dialog.error(txt3);
    return false;
  }
  if(tel==""){
    dialog.error(txt4);
    return false;
  }
  if(img==""){
    dialog.error(txt2);
    return false;
  }
}

function validateForm1(){
  var txt = "产品名称不能为空! ";
  var txt1 = "产品描述不能为空! ";
  var txt2 = "图片不能为空！";
  var txt3 = "产品价格不能为空！";
  var title=$("input[name='name']").val();
  var desc=$("#textArea").val();
  var img=$("input[name='image']").val();
  var price=$("input[name='price']").val();
  if(title==""){
    dialog.error(txt);
    return false;
  };
  if(desc==""){
    dialog.error(txt1);
    return false;
  }
  if(img==""){
    dialog.error(txt2);
    return false;
  }
   if(price==""){
    dialog.error(txt3);
    return false;
  }
}
