<?php include("session.php");
$id = isset($_SESSION['id'])?$_SESSION['id']:null;
$user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;
//for edit profile
if($id!=null && $_SERVER["REQUEST_METHOD"] == "POST")
{
  $name =  mysqli_real_escape_string($conn,$_POST['name']);
  $phone_no =  mysqli_real_escape_string($conn,$_POST['phone_no']);
  $gender =  mysqli_real_escape_string($conn,$_POST['gender']);
  $dob =  mysqli_real_escape_string($conn,$_POST['dob']);
  $address =  mysqli_real_escape_string($conn,$_POST['address']);
  $district =  mysqli_real_escape_string($conn,$_POST['district']);
  $pincode =  mysqli_real_escape_string($conn,$_POST['pin']);

  if($user_type=='d')
  {
    $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',gender = '$gender',dob = '$dob',district ='$district',pincode = '$pincode', address='$address' WHERE user_id='$id'";

    $specialization =  mysqli_real_escape_string($conn,$_POST['specialization']);
    $registration_council =  mysqli_real_escape_string($conn,$_POST['registration_council']);
    $registration_year =  mysqli_real_escape_string($conn,$_POST['registration_year']);
    $registration_no =  mysqli_real_escape_string($conn,$_POST['registration_no']);
    
    $clinic_name =  mysqli_real_escape_string($conn,$_POST['clinic_name']);
    $clinic_address =  mysqli_real_escape_string($conn,$_POST['clinic_address']);
    $fee =  mysqli_real_escape_string($conn,$_POST['fee']);
    $c_validity =  mysqli_real_escape_string($conn,$_POST['c_validity']);
    
    $morning_start_time = $_POST['morning_start_time'];
    $morning_end_time = $_POST['morning_end_time'];
    $evening_start_time = $_POST['evening_start_time'];
    $evening_end_time = $_POST['evening_end_time'];

    $sql2 = "UPDATE tb_doctor SET specialization='$specialization', registration_no='$registration_no', registration_year='$registration_year', registration_council='$registration_council',clinic_name='$clinic_name',clinic_address='$clinic_address',fee=$fee,c_validity=$c_validity, morning_start_time='$morning_start_time', morning_end_time='$morning_end_time', evening_start_time='$evening_start_time', evening_end_time='$evening_end_time' WHERE doc_id=$id";
    
          if(mysqli_query($conn, $sql) && mysqli_query($conn,$sql2)) 
          {
            
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
    
  }
  else if($user_type == 'c')
  {
   $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',district ='$district',pincode = '$pincode', address='$address' WHERE user_id='$id'"; 
    
        if(mysqli_query($conn, $sql) )
           {
          $_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Details Updated Sucessfully </div>';
        echo ' <script type="text/javascript">
    //    alert("Details Saved Sucessfully")
        window.location = "./welcome.php";
        </script> ';
      } 
           else 
           {
          $_SESSION['msg'] = '<div class= "alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Sorry Error Occured While Saving Your Details </div>';
        echo ' <script type="text/javascript">
    //    alert("Sorry Some error occured")
        window.location = "./welcome.php";
        </script> ';
      }

    
           
  }
  
  else
  {
    $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',gender = '$gender',dob = '$dob',district ='$district',pincode = '$pincode', address='$address' WHERE user_id='$id'";
    $sql2 = "";
    $height =  mysqli_real_escape_string($conn,$_POST['height']);
    $weight =  mysqli_real_escape_string($conn,$_POST['weight']);
    $blood_group =  mysqli_real_escape_string($conn,$_POST['blood_group']);
    $sql2 = "UPDATE tb_patient SET height=$height, weight=$weight, blood_group='$blood_group' WHERE pat_id=$id";
    
    if(mysqli_query($conn, $sql) && mysqli_query($conn,$sql2)) 
          {
            
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
    
    
  
}
mysqli_close($conn);
}

?>
