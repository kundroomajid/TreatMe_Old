<?php
include("header.php");
include("config.php");
$msg = $_SESSION['msg'];
$user_email =  mysqli_real_escape_string($conn,$_GET['email']);

$_SESSION['email'] = $user_email;
if((isset($_POST['name']))&isset($_POST['phone_no'])&isset($_POST['gender'])){
  // Verify data
  $name =  mysqli_real_escape_string($conn,$_POST['name']);
  $phone_no =  mysqli_real_escape_string($conn,$_POST['phone_no']);
  $gender =  mysqli_real_escape_string($conn,$_POST['gender']);
  $dob =  mysqli_real_escape_string($conn,$_POST['dob']);
  $address =  mysqli_real_escape_string($conn,$_POST['address']);
  $district =  mysqli_real_escape_string($conn,$_POST['district']);
  $pincode =  mysqli_real_escape_string($conn,$_POST['pincode']);
  $bloodgroup =  mysqli_real_escape_string($conn,$_POST['bloodgroup']);
  $height =  mysqli_real_escape_string($conn,$_POST['height']);
  $weight =  mysqli_real_escape_string($conn,$_POST['weight']);

  $idquery = "SELECT user_id from tb_user WHERE user_email='$user_email'";
  $user_id = mysqli_query($conn,$idquery)->fetch_object()->user_id;


  $sql = "UPDATE tb_user SET user_name= '$name',user_phone = '$phone_no',gender = '$gender',user_type = 'p',dob = '$dob',address = '$address',district ='$district',pincode = '$pincode' WHERE user_email='$user_email'";
  $sql2 = "INSERT INTO tb_patient VALUES ($user_id, '$bloodgroup',$height,$weight)";
  if(mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)){
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
      <h1>Please Enter Your details to complete Your profile</h1>
      <div class="row justify-content-center">
        <div class="col-md-5">
          <form action="" method="POST" id="registerForm">
            <div class="box_form">
              <div class="form-group">
                <label>Name</label>
                <input type="name" name ="name"class="form-control" placeholder="Enter Your Name" required/>
              </div>
              <div class="form-group">
                <label>PhoneNo</label>
                <input type="number" name ="phone_no" class="form-control" id="phone_no" placeholder="Phone No" minlength="10" maxlength="10"  required/>
              </div>
              <p>
                <label>Gender</label>
                <input type = "radio"
                name = "gender"
                id = "male"
                value = "Male" />
                <label for = "male">Male</label>
                <input type = "radio"
                name = "gender"
                id = "female"
                value = "Female" />
                <label for = "female">Female</label>
                <input type = "radio"
                name = "gender"
                id = "other"
                value = "Other" />
                <label for = "other">Other</label>
              </p>
              <div class="form-group">
                <label>Date Of Birth</label>
                <input type="date" name ="dob" class="form-control" required/>
              </div>
              <div class="form-group">
                <label>Address</label>
                <input type="address" name ="address" class="form-control" id="address" placeholder="Enter Full Address" required/>
              </div>
              <label>Select District</label>
              <select id = "district" class="form-control" name ="district" required>
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

              <div class="form-group">
                <label>Pincode</label>
                <input type="pincode" name ="pincode" class="form-control" id="pincode" placeholder="Enter Your pincode" required/>
              </div>
              <div  <label>Select Blood Group</label>
                <select id = "bloodgroup" class="form-control" name ="bloodgroup">
                  <option value = "Unknown">Unknown</option>
                  <option value = "O-">O−</option>
                  <option value = "O+">O+</option>
                  <option value = "A−">A−</option>
                  <option value = "A+">A+</option>
                  <option value = "B−">B−</option>
                  <option value = "B+">B+</option>
                  <option value = "AB−">AB−</option>
                  <option value = "AB+">AB+</option>

                </select> </div>
                <div class="form-group">
                  <label>Height</label>
                  <input type="height" name ="height" class="form-control" id="height" placeholder="Enter Height in Inches" required/>
                </div>
                <div class="form-group">
                  <label>Weight</label>
                  <input type="weight" name ="weight" class="form-control" id="weight" placeholder="Enter Your Weight in Kgs"required />
                </div>
                <div class="form-group text-center add_top_30">
                  <input class="btn_1" type="submit" value="Submit" />
                </div>

              </form>
            </div>
          </div>
          <!-- /row -->
        </div>
  <!--jquery validator-->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
  <script src="./js/formvalidator.js"></script>

<!--validator ends-->
        <!-- /register -->
      </div>
    </div>

  </main>
</main>
</html>
