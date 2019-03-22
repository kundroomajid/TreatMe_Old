<?php
require_once 'config.php';
require_once 'session.php';


    if($_POST['act'] == 'rate'){
      $pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;
    	$therate = $_POST['rate'];
    	$thepost = $_POST['post_id'];

    	$query = mysqli_query($conn,"SELECT * FROM tb_rating where pat_id= '$pat_id'  "); 
    	while($data = mysqli_fetch_assoc($query)){
    		$rate_db[] = $data;
    	}

    	if(@count($rate_db) == 0 ){
    		mysqli_query($conn,"INSERT INTO tb_rating (doc_id, pat_id, rate)VALUES('$thepost', '$pat_id', '$therate')");
    	}else{
    		mysqli_query($conn,"UPDATE tb_rating SET rate= '$therate' WHERE pat_id = '$pat_id'");
    	}
    } 
?>