<?php
include("header.php");
include("config.php");

$user_email =  mysqli_real_escape_string($conn,$_GET['email']);
$_SESSION['email'] = $user_email;

$idquery = "SELECT user_id from tb_user WHERE user_email='$user_email'";
   $result1=mysqli_query($conn,$idquery) or die ("Query to get data from firsttable failed: ".mysqli_error());
    $cdrow1=mysqli_fetch_array($result1);
    $clinic_id = $cdrow1['user_id'];
  echo($clinic_id);


if((isset($_POST['name']))&isset($_POST['phone_no'])&isset($_POST['address'])){
  // Verify data
  $name =  mysqli_real_escape_string($conn,$_POST['name']);
  $phone_no =  mysqli_real_escape_string($conn,$_POST['phone_no']);
  $address =  mysqli_real_escape_string($conn,$_POST['address']);
  $district =  mysqli_real_escape_string($conn,$_POST['district']);


  $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',user_type = 'c',address = '$address',district ='$district' WHERE user_email='$user_email'";
  //query to insert data into tb_clinics
  $sql2 = "Insert into tb_clinic(clinic_id,clinic_name) values($clinic_id,'$name')";
 
  if(mysqli_query($conn, $sql) && (mysqli_query($conn,$sql2))){
    $msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Details Saved Sucessfully 
  </div>';
    echo '<script type="text/javascript">
//    alert("Details Saved Sucessfully")
    window.location = "./upload_photo.php?email='.$user_email.'";
    </script> ';
  } else {
    $msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Alert!</strong> Some Error Occured while saving Details
  </div>';
//    echo '<script language="javascript">';
//    echo 'alert("Error")';
//    echo '</script>';
  }
  mysqli_close($conn);

}

$_SESSION['msg'] = $msg;

?>


<html>
<main>
  <div class="bg_color_2">
    <div class="container margin_60_35"  id="register">
      <div id="info" class="clearfix">  <?= "$msg";?> </div>
      <h1>Please details of Clinic to complete Your profile</h1>
      <div class="row justify-content-center">
        <div class="col-md-5">
          <form action="" method="POST">
            <div class="box_form">
              <div class="form-group">
                <label>Clinic Name </label>
                <input type="name" name ="name"class="form-control" placeholder="Enter Name of Clinic" />
              </div>
              <div class="form-group">
                <label>Clinic PhoneNo</label>
                <input type="phone_no" name ="phone_no" class="form-control" id="phone_no" placeholder="Phone No" />
              </div>
              <div class="form-group">
                <label>Clinic Address</label>
                <input type="address" name ="address" class="form-control" id="address" placeholder="Enter Full Address of Clinic" />
              </div>
              <label>Select District</label>
              <select id = "district" class="form-control" name ="district">
                <option value = "Anantnag">Anantnag</option>
                <option value = "Bandipora">Bandipora</option>
                <option value = "Baramulla">Baramulla</option>
                <option value = "Budgam">Budgam</option>
                <option value = "Ganderbal">Ganderbal</option>
                <option value = "Kulgam">Kulgam</option>
                <option value = "Kupwara">Kupwara</option>
                <option value = "Pulwama">Pulwama</option>
                <option value = "Shopain">Shopain</option>
                <option value = "Srinagar">Srinagar</option>
                <option value = "Doda">Doda</option>
                <option value = "Jammu">Jammu</option>
                <option value = "Kathua">Kathua</option>
                <option value = "Kishtwar">Kishtwar</option>
                <option value = "Poonch">Poonch</option>
                <option value = "Rajouri">Rajouri</option>
                <option value = "Reasi">Reasi</option>
                <option value = "Ramban">Ramban</option>
                <option value = "Samba">Samba</option>
                <option value = "Udhampur">Udhampur</option>
                <option value = "Kargil">Kargil</option>
                <option value = "Leh">Leh</option>
              </select>

              
             
                <div class="form-group text-center add_top_30">
                  <input class="btn_1" type="submit" value="Submit" />
                </div>

              </form>
            </div>
          </div>
          <!-- /row -->
        </div>
        <!-- /register -->
      </div>
    </div>

  </main>
</main>
</html>
