$('.reback').click(function(){
  var url=scope.reback;
  var id=$(this).attr('data-id');
  $.get(url, { id: id},function(result){
    if(result.status==1){
        return dialog.success(result.message,'');
      }else{
        return dialog.error(result.message);
    }
  },"JSON")
});
$('.delete').click(function(){
  var url=scope.reback;
  var id=$(this).attr('data-id');
  $.get(url, { id: id},function(result){
    if(result.status==1){
        return dialog.success(result.message,'');
      }else{
        return dialog.error(result.message);
    }
  },"JSON")
});