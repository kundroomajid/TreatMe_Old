loadmore = document.getElementById('loadmore');
comments = document.getElementById('comments');
offset =  document.getElementById('offset');
doc = document.getElementById('doc_id');
doc_id = doc.value;


  
loadmore.addEventListener('click', function(e){
  os = parseInt(offset.value);
  //window.location = "loadmore.php?doc_id="+doc_id+"&offset="+offset.value;
  $.ajax({
    type : "POST",
//    data: {offset:offset},
    beforeSend: function(){ $("#loadmore").attr("disabled", true); },
    complete: function(){ $("#loadmore").attr("disabled", false); },
    url : "loadmore.php?doc_id="+doc_id+"&offset="+os,
    success:function(data){
      comments.innerHTML = comments.innerHTML + data;
      count.innerHTML = os;
    }
  });
  os = os + 3;
  offset.value = os;
});



$(window).scroll(function() {
    if(Math.round($(window).scrollTop()) == $(document).height() - $(window).height()) {
           // ajax call get data from server and append to the div
           console.log('at the end of the screen');
           $.ajax();
    }
});


