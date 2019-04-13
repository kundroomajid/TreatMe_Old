<?php
include("config.php");
include('session.php');
$query ="DELETE FROM tb_appointment WHERE apptt_id = $appt_id";
$result=mysqli_query($conn,$query) or die ('<script type="text/javascript"> alert("Deleteion Failed ") window.location = "./welcomep.php"; </script> 


?>