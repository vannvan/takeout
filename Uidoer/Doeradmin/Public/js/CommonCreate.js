//公共的插入js
$("#create_btn").click(function(){
var formElement = $("#formdata");
var turl=scope.createurl;
//alert(url);
var formData = new FormData(formElement);
$.ajax({  
        url: "turl",  
        type: 'POST',  
        data: formData,  
        dataType: 'JSON',  
        cache: false,  
        processData: false,  
        contentType: false,
        success : function(data) {
            alert("上传成功");
        },
        error:function(){
            alert("上传失败");
        }
    });
    });         










