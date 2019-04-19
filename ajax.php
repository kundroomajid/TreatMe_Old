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
?>
