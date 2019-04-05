<?php include("session.php");
$id = isset($_SESSION['id'])?$_SESSION['id']:null;
$user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;
//for edit profile
if($id!=null && $_SERVER["REQUEST_METHOD"] == "POST")
{
  $name = $_POST['name'];
  $phone_no = $_POST['phone_no'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $address = $_POST['address'];
  $district = $_POST['district'];
  $pincode = $_POST['pin'];

  


  if($user_type=='d')
  {
    $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',gender = '$gender',dob = '$dob',district ='$district',pincode = '$pincode', address='$address' WHERE user_id='$id'";

    $specialization = $_POST['specialization'];
    $registration_council = $_POST['registration_council'];
    $registration_year = $_POST['registration_year'];
    $registration_no = $_POST['registration_no'];
    $morning_start_time = $_POST['morning_start_time'];
    $morning_end_time = $_POST['morning_end_time'];
    $evening_start_time = $_POST['evening_start_time'];
    $evening_end_time = $_POST['evening_end_time'];

    $sql2 = "UPDATE tb_doctor SET specialization='$specialization', registration_no='$registration_no', registration_year='$registration_year', registration_council='$registration_council', morning_start_time='$morning_start_time', morning_end_time='$morning_end_time', evening_start_time='$evening_start_time', evening_end_time='$evening_end_time' WHERE doc_id=$id";
  } 
  else if($user_type == 'c')
  {
   $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',district ='$district',pincode = '$pincode', address='$address' WHERE user_id='$id'"; 
    
  }
  
  else
  {
    $sql2 = "";
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $blood_group = $_POST['blood_group'];
    $sql2 = "UPDATE tb_patient SET height=$height, weight=$weight, blood_group='$blood_group' WHERE pat_id=$id";
  }

  if(mysqli_query($conn, $sql) || mysqli_query($conn,$sql2)) {
	  $_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Details Updated Sucessfully </div>';
    echo ' <script type="text/javascript">
//    alert("Details Saved Sucessfully")
    window.location = "./welcome.php";
    </script> ';
  } else {
	  $_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Sorry Error Occured While Saving Your Details </div>';
    echo ' <script type="text/javascript">
//    alert("Sorry Some error occured")
    window.location = "./welcome.php";
    </script> ';
  }
  mysqli_close($conn);
}


?>
