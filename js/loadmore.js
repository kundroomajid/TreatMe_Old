loadmore = document.getElementById('loadmore');
comments = document.getElementById('comments');
offset =  document.getElementById('offset');
doc = document.getElementById('doc_id');
total_comments = parseInt(document.getElementById('total_comments').innerHTML);
doc_id = doc.value;


$(document).ajaxStart(function() {
  alert('loading');
});

$(document).ajaxComplete(function() {
  $("#loadmore").attr("disabled", false);

});


loadmore.addEventListener('click', function(e){
  os = parseInt(offset.value);
  //window.location = "loadmore.php?doc_id="+doc_id+"&offset="+offset.value;
  $.ajax({
    type : "POST",
//    data: {offset:offset},
    url : "loadmore.php?doc_id="+doc_id+"&offset="+os,
    success:function(data){
      comments.innerHTML = comments.innerHTML + data;
      if(os>=total_comments)
        os = total_comments;
      count.innerHTML = os;
    }
  });
  os = os + 3;
  offset.value = os;
  if(os>=total_comments){
    document.getElementById('loadmore').innerHTML = "No more comments";
    document.getElementById('loadmore').disabled = true;
  }
});

// beforeSend: function(){ $("#loadmore").attr("disabled", true); },
// complete: function(){ $("#loadmore").attr("disabled", false); },
