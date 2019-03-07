<?php
    include('session.php');
    $user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;

    if($user_type!=null)
	{
      if($user_type=='d')
	  {
		  echo '<script type="text/javascript"> alert ("in welcome d");window.location = "./welcomed.php"; </script>';
//		  header("location: welcomed.php");
	  }
        
      else
	  {
		  echo '<script type="text/javascript"> alert ("in welcome p"); window.location = "./welcomep.php"; </script>';
//		 header("location: welcomep.php"); 
	  }
        
    }
else
{
	echo '<script type="text/javascript"> alert ("in welcome else 21");window.location = "./login.php"; </script>';
//      header("location: login.php");
    }
 ?>
