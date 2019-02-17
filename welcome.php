<?php
    include('session.php');
    $user_type = $_SESSION['user_type'];
    if($user_type=='d'){
      header("location:   welcomed.php");
    }else{
      header("location:   welcomep.php");
    }
 ?>
