<?php
    include('session.php');
    $user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;

    if($user_type!=null)
	{
      if($user_type=='d')
	  {
		  echo '<script type="text/javascript"> window.location = "./welcomed.php"; </script>';
//		  header("location: welcomed.php");
	  }
        
      else if($user_type == 'p')
	  {
		  echo '<script type="text/javascript">  window.location = "./welcomep.php"; </script>';
//		 header("location: welcomep.php"); 
	  }
      
      else if($user_type == 'c')
	  {
		  echo '<script type="text/javascript">  window.location = "./welcomec.php"; </script>';
//		 header("location: welcomec.php"); 
	  }
        
    }
else
{
	echo '<script type="text/javascript"> window.location = "./login.php"; </script>';
//      header("location: login.php");
    }
 ?>
