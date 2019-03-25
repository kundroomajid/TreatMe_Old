loadmore = document.getElementById('loadmore');
comments = document.getElementById('comments');
offset =  document.getElementById('offset');
doc = document.getElementById('doc_id');
doc_id = doc.value;
loadmore.addEventListener('click', function(e){
  offset.value =  (parseInt(offset.value))+1;
  //window.location = "loadmore.php?doc_id="+doc_id+"&offset="+offset.value;
  $.ajax({
    type : "POST",
    url : "loadmore.php?doc_id="+doc_id+"&offset="+offset.value,
    success:function(data){
      comments.innerHTML = comments.innerHTML + data;
    }
  });
});



$(window).scroll(function() {
    if(Math.round($(window).scrollTop()) == $(document).height() - $(window).height()) {
           // ajax call get data from server and append to the div
           console.log('at the end of the screen');
           $.ajax();
    }
});
