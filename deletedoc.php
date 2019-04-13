<?php

include("config.php");
include('session.php');

$id = isset($_SESSION['id'])?$_SESSION['id']:null;
$type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;
$doc_id = isset($_GET['doc_id'])? mysqli_real_escape_string($conn,$_GET['doc_id']):null;

if($id!=null && $doc_id!=null && $type != null && $type == 'c')
{
    
 
    $sql = "DELETE FROM tb_doctor WHERE doc_id = $doc_id";
    $result=mysqli_query($conn,$sql);
    $sql = "DELETE FROM tb_qualifications WHERE doc_id = $doc_id";
    $result1=mysqli_query($conn,$sql);
    $sql = "DELETE FROM tb_clinic_docs WHERE doc_id = $doc_id";
    $result2=mysqli_query($conn,$sql);
    
	if($result != null )
	{
		$_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Doctor Deleted Sucessfully </div>';
	}
    else
    {
    $_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Error in Deleting Doctor <br/> '.mysqli_error($conn).'</div>';
    }
    header("Location:welcome.php");
}
?>