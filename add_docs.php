<?php
include("config.php");
include("session.php");
$msg = $_SESSION['msg'];
$clinic_id = isset($_SESSION['id'])?$_SESSION['id']:null;
$blob = addslashes(file_get_contents('./img/user.png', true));

if((isset($_POST['doc_name']))&& isset($_POST['doc_email']) && isset($_POST['doc_password']))
{
	// Verify data
    $doc_email =  mysqli_real_escape_string($conn,$_POST['doc_email']);
    $doc_phone =  mysqli_real_escape_string($conn,$_POST['doc_phone']);
	$doc_name =  mysqli_real_escape_string($conn,$_POST['doc_name']);
   $doc_password =  mysqli_real_escape_string($conn,$_POST['doc_password']);
	$gender =  mysqli_real_escape_string($conn,$_POST['gender']);
	$district =  mysqli_real_escape_string($conn,$_POST['doc_district']);
    $specialization =  mysqli_real_escape_string($conn,$_POST['specialization']);
	$degree =  mysqli_real_escape_string($conn,$_POST['doc_degree']);
	$institution =  mysqli_real_escape_string($conn,$_POST['doc_institute']);
	$experience =  mysqli_real_escape_string($conn,$_POST['doc_experience']);
    $fee = mysqli_real_escape_string($conn,$_POST['fee']);
	$validity = mysqli_real_escape_string($conn,$_POST['c_validity']);
    $morning_start_time = (new DateTime($_POST['morning_start_time']))->format("H:i");
     $morning_end_time = (new DateTime($_POST['morning_end_time']))->format("H:i");
     $evening_start_time = (new DateTime($_POST['evening_start_time']))->format("H:i");
     $evening_end_time = (new DateTime($_POST['evening_end_time']))->format("H:i");
  
  $sql = "SELECT user_name,address from tb_user where user_id ='$clinic_id' and user_type = 'c'";
  $res = mysqli_query($conn, $sql);
   $row = mysqli_fetch_array($res);
       $clinic_name = $row['user_name'];
       $clinic_address = $row['address'];
   
  
$sql ="INSERT into tb_user (user_name,user_email,user_password,user_phone,user_type,active,gender,district,photo)          values('$doc_name','$doc_email','$doc_password',$doc_phone,'d',1,'$gender','$district','$blob')";
  
  if(mysqli_query($conn, $sql))
     {
   
       //  get doc id generated
       $q = "Select user_id from tb_user where user_email = '$doc_email' and user_type = 'd'";
       $res = mysqli_query($conn, $q);
       $row = mysqli_fetch_array($res);
       $doc_id = $row['user_id'];
       
       
        $sql1 ="INSERT into tb_doctor (doc_id,specialization,registration_council,registration_no,registration_year,morning_start_time,morning_end_time,evening_start_time,evening_end_time,experience,clinic_name,clinic_address,fee,c_validity) values('$doc_id','$specialization','$registration_council','$registration_no','$registration_year','$morning_start_time','$morning_end_time','$evening_start_time','$evening_end_time',$experience,'$clinic','$address',$fee,$validity)";
       $sql2 = "INSERT into tb_qualifications(doct_id,degree,institute) values($doc_id,'$degree','$institution')";
       $sql3 = "INSERT into tb_clinic_docs(doc_id,clinic_id) values($doc_id,$clinic_id)";

    
       if((mysqli_query($conn, $sql1)) && (mysqli_query($conn, $sql2)) && (mysqli_query($conn, $sql3)))
          {
		$msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Details Saved Sucessfully Continue
  </div>';
		echo '<script type="text/javascript">
//		alert("Details Saved Sucessfully")
		window.location = "./upload_photo.php?email='.$doc_email.'";
		</script> ';
	}
          else 
          {
		$msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> Some Error Occured
  </div>';
            echo '<script type="text/javascript">
//		alert("Details Saved Sucessfully")
		window.location = "./welcomec.php";
		</script> ';
	}
          }
    else
    {
      $msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> Some Error Occured
  </div>';
      
       echo '<script type="text/javascript">
//		alert("Details Saved Sucessfully")
		window.location = "./welcomec.php";
		</script> ';
    }
  
  

 

	
	$_SESSION['msg'] = $msg;
	mysqli_close($conn);



}


?>
