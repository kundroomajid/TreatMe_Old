<?php

include("config.php");
include('session.php');
$id = isset($_SESSION['id'])?$_SESSION['id']:null;
$appt_id = isset($_GET['appt_id'])?$_GET['appt_id']:null;

if($id!=null && $appt_id!=null){
  $query ="DELETE FROM tb_appointment WHERE apptt_id = $appt_id";
  $result=mysqli_query($conn,$query) or die ('<script type="text/javascript"> alert("Deleteion Failed ") window.location = "./welcomep.php"; </script> ');
	if($result != null)
	{
		$_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Appointment Deleted Sucessfully </div>';
	}
  header("Location:welcomep.php");
}else{
  echo '<script type="text/javascript"> alert("Illegal entry ") window.location = "./welcomep.php"; </script> ';
}



?>
