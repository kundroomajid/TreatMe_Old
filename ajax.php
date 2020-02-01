<?php
require_once 'config.php';
require_once 'session.php';


if($_REQUEST['act'] == 'rate'){
  $pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;
	$therate = $_REQUEST['rate'];//rating value stars
	$thepost = $_REQUEST['post_id'];//doc id

  $query = mysqli_query($conn,"SELECT * FROM tb_rating where pat_id= $pat_id and doc_id =$thepost");
  $rate_db = mysqli_num_rows($query);

	if($rate_db == 0 )
		mysqli_query($conn,"INSERT INTO tb_rating (doc_id, pat_id, rate) VALUES ( $thepost, $pat_id, $therate)");
	else
		mysqli_query($conn,"UPDATE tb_rating SET rate=$therate WHERE pat_id = $pat_id and doc_id = $thepost");
}

if($_REQUEST['act'] == 'comment') {
	$pat_id = $_REQUEST['pat_id'];
	$doc_id = $_REQUEST['doc_id'];//docid
	$comment = $_REQUEST['comment'];//comment

	$comment_query = mysqli_query($conn, "SELECT * FROM comments WHERE doc_id = $doc_id and pat_id=$pat_id");
	$comment_rows = mysqli_num_rows($comment_query);

	if ($comment_rows == 0)
		$sql = "INSERT into comments (pat_id,doc_id,comment) values ('$pat_id','$doc_id','$comment')";
	else {
		$sql = "UPDATE comments SET comment = '$comment' WHERE doc_id = $doc_id and pat_id = $pat_id";
	}

	if (mysqli_query($conn, $sql)) {
		$msg = '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Comment Posted Sucessfully</div>';
		echo '<script type="text/javascript">
    //    alert("comment Sucessfully")
    </script> ';
	} else {

		$msg = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Something went Wrong
    </div>';

	}

}
?>
