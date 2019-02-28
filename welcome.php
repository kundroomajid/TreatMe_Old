<?php
    include('session.php');
    $user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;

    if($user_type!=null){
      if($user_type=='d')
        header("location: welcomed.php");
      else
        header("location: welcomep.php");
    }else{
      header("location: login.php");
    }
 ?>
