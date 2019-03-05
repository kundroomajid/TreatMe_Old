<?php
include("header.php");
$msg = $_SESSION['msg'];
unset($_SESSION['msg']);
function fn_resize($image_resource_id,$width,$height) {
  $target_width =300;
  $target_height =300;
  $target_layer=imagecreatetruecolor($target_width,$target_height);
  imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
  return $target_layer;
}

$id = isset($_SESSION['id'])?$_SESSION['id']:null;
if($id!=null) {

  $user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;
  if($user_type==null || $user_type!='p'){
    echo '<script>window.location = "welcome.php";</script>';
  }
  $query ="select * from vw_patient where pat_id = $id";
  $result1=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
  $cdrow1=mysqli_fetch_array($result1);
  //getting result from database
  $name = $cdrow1["user_name"];
  $email = $cdrow1["user_email"];
  $phone = $cdrow1["user_phone"];
  $dob = $cdrow1["dob"];
  $height = $cdrow1["height"];
  $weight = $cdrow1["weight"];
  $address = $cdrow1["address"];
  $blood_group = $cdrow1["blood_group"];
  $gender = $cdrow1["gender"];
  $gender_symbol = ($gender=='Male')?"&#9794;":($gender=='Female')?"&#9792;":"&#9893;";
  $district = $cdrow1["district"];
  $pin = $cdrow1['pincode'];
  //get data from appointment table
  $apptquery = "Select * from tb_appointment where pat_id = $id";
  $resultappt = $conn->query($apptquery);
  $count = mysqli_num_rows($resultappt);
} else {
  echo '<script type="text/javascript">
//  alert("Please Login To Continue ")
  window.location = "./login.php";
  </script> ';
}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $file_size = $_FILES['image']['size'];
  if (($file_size > 655000))
  {
//    $message = 'File too large. File must be less than 640 kb.';
//	   $msg = '<div class="alert alert-danger alert-dismissible">
//     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
//     File too large. File must be less than 1Mb
//    </div>';
//    echo '<script type="text/javascript">alert("'.$message.'");</script>';
  } 
	if($file!=null && $file!="" && file_exists($_FILES['image']['tmp_name']))
  {
    $file = $_FILES['image']['tmp_name'];
    $source_properties = getimagesize($file);
    $image_type = $source_properties[2];

    if( $image_type == IMAGETYPE_JPEG )
    {
      $image_resource_id = imagecreatefromjpeg($file);
      $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
      imagejpeg($target_layer,'temp.jpg');
      $blob = addslashes(file_get_contents('./temp.jpg', true));
      $q = "UPDATE tb_user SET photo= '$blob' where user_id = '$id'";
      $conn->query($q);
    }
    elseif( $image_type == IMAGETYPE_GIF )
    {
      $image_resource_id = imagecreatefromgif($file);
      $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
      imagejpeg($target_layer,'temp.jpg');
      $blob = addslashes(file_get_contents('./temp.jpg', true));
      $q = "UPDATE tb_user SET photo= '$blob' where user_id = '$id'";
      $conn->query($q);

    }
    elseif( $image_type == IMAGETYPE_PNG )
    {
      $image_resource_id = imagecreatefrompng($file);
      $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
      imagejpeg($target_layer,'temp.jpg');
      $blob = addslashes(file_get_contents('./temp.jpg', true));
      $q = "UPDATE tb_user SET photo= '$blob' where user_id = '$id'";
      $conn->query($q);

    }
		$msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Photo Uploaded Sucessfully
    </div>';
	}
else{
		$msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     File too large. File must be less than 1 MB
    </div>';
	}


  
	
}
$str = "select photo from tb_user where user_id = '$id'";
$result = $conn->query($str);
if($result==null) echo "nonos";
if(($r = mysqli_fetch_array($result))!=null)
$imagepic = "<img src = 'data:image/jpeg;base64,".base64_encode( $r[0])."' width='200' height='200' /><br/>";
?>
<!--
<script>
var uploadImage = document.getElementById("uploadImage");
uploadImage.onchange = function() {
echo '<script type="text/javascript">
if(this.files[0].size > 65500)
{
alert("File is too big!");
this.value = "";
};
};
</script>
-->
<html>
<head>
  <title>Welcome </title>
</head>
<body>
  <div class="container">
    <form method="POST" enctype="multipart/form-data">
      <div class="row my-2">
        <div class="col-lg-4 order-lg-1 text-center">
          <?= $imagepic ?>
          <h6 class="mt-2">Upload a different photo</h6>
          <label class="custom-file">
            <input type="file" class="custom-file-input" id="uploadImage" name="image" id="image" accept=".jpg, .jpeg, .png" required />
            <span class="custom-file-control">Choose file</span>
            <br><br> <br>
          </label>
          <input type="submit" class = "btn_1" value = "Upload"/>
        </div>
      </form>

      <div class="col-lg-8 order-lg-2">
		  <div id="info" class="clearfix">  <?= "$msg";?> </div>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#myappointments" data-toggle="tab" class="nav-link">My Appointments</a>
          </li>
          <li class="nav-item">
            <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit Profile</a>
          </li>
        </ul>
        <div class="tab-content py-4">
          <div class="row tab-pane" id="profile">
            <h4 class="col-md-12"> <?= $user."(".getAge($dob).")".$gender_symbol  ?></h4>

            <div class="col-md-12">
              <table class="table table-bordered">
                <tr>  <td>Email </td>       <td><?=$email ?> </td> </tr>
                <tr>  <td>Phone </td>       <td><?= $phone ?></td> </tr>
                <tr>  <td>D.O.B </td>       <td><?= $dob ?></td> </tr>
                <tr>	<td>Address</td>     <td><?= "$address<br/>$district - $pin" ?></td> </tr>

                <tr>  <td>Height</td>       <td><?= $height ?></td> </tr>
                <tr>	<td>Weight</td>       <td><?= $weight ?></td> </tr>
                <tr>	<td>Blood Group</td>  <td><?= $blood_group ?></td> </tr>
              </table>
            </div>
          </div>
          <div class="tab-pane active" id="myappointments">

            <table class='table table-responsive'>
              <thead>
                <tr><th>Appt Id</th><th>Date</th><th>Doc Name</th><th>Shift</th><th>Queue No</th><th>&nbsp;</th></tr>
              </thead>
              <tbody>
                <?php
                // if($count == "0") {
                //   echo "No Appointments Booked yet";
                // } else {
                // if($resultappt->num_rows > 0)          {
                if($count > 0)          {
                  while ($cdrow2=mysqli_fetch_array($resultappt)) {
                    //getting result from database
                    $appt_id = $cdrow2["apptt_id"];
                    $doc_id = $cdrow2["doc_id"];
                    $appt_date = $cdrow2["appt_date"];
                    $shift = $cdrow2["shift"];
                    $shift_type = ($shift==0)?'Morning':'Evening';
                    $queue_no = $cdrow2["queue_no"];
                    //query to get doc name from view doctor
                    $docquery = $conn->query("select user_name from vw_doctor where doc_id = $doc_id");
                    $cdrow3=mysqli_fetch_array($docquery);
                    $doc_name = $cdrow3["user_name"];
                    echo "<tr><td>$appt_id</td><td>$appt_date</td><td>$doc_name</td><td>$shift_type</td><td>$queue_no</td>
                    <td><a href='delete_appointment.php?appt_id=$appt_id'>Delete</td></td></tr>" ;
                  }
                  // }
                }else {
                  echo("<tr><td colspan='5'><h5>No Appointments booked Yet</td></tr>");
                }
                ?>
                <tbody> </table>
                </div>
                <div class="tab-pane" id="edit">
                  <form role="form" method="post" action="edit_profile.php">
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Name </label>
                      <div class="col-lg-9">
                        <input class="form-control" type="text" name ="name" value="<?= $user ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Email</label>
                      <div class="col-lg-9">
                        <input class="form-control"  name ="email" type="email" readonly value="<?= $email ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Phone No</label>
                      <div class="col-lg-9">
                        <input class="form-control" type="number" name ="phone_no" value="<?= $phone ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">D.O.B</label>
                      <div class="col-lg-9">
                        <input class="form-control" type="date" name ="dob" value="<?= $dob ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Weight</label>
                      <div class="col-lg-3">
                        <input class="form-control" type="number"  name ="weight" value="<?= $weight ?>">
                      </div>
                      <label class="col-lg-3 col-form-label form-control-label">Height</label>
                      <div class="col-lg-3">
                        <input class="form-control" type="number" name ="height" value="<?= $height ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Gender</label>
                      <div class="col-lg-3">
                        <select id = "gender" class="form-control" name ="gender">
                          <option value = "<?= $gender ?>"><?= $gender ?></option>
                          <option value = "Male">Male</option>
                          <option value = "Female">Female</option>
                          <option value = "Other">Other</option>
                        </select>
                      </div>

                      <label class="col-lg-3 col-form-label form-control-label">Blood Group</label>
                      <div class="col-lg-3">
                        <select id = "blood_group" class="form-control" name ="blood_group">
                          <option value = "<?= $blood_group ?>"><?= $blood_group ?></option>
                          <option value = "Unknown">Unknown</option>
                          <option value = "O-">O−</option>
                          <option value = "O+">O+</option>
                          <option value = "A−">A−</option>
                          <option value = "A+">A+</option>
                          <option value = "B−">B−</option>
                          <option value = "B+">B+</option>
                          <option value = "AB−">AB−</option>
                          <option value = "AB+">AB+</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">Address</label>
                      <div class="col-lg-9">
                        <textarea name="address" rows="3" class="col-lg-12"><?= $address ?></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-lg-3 col-form-label form-control-label">District</label>
                      <div class="col-lg-3">
                        <select id = "district" class="form-control" name ="district">
                          <option value = "<?= $district ?>"><?= $district ?></option>
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
                      </div>
                      <label class="col-lg-3 col-form-label form-control-label">Pin</label>
                      <div class="col-lg-3">
                        <input class="form-control" type="number" name ="pin" value="<?= $pin ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <input type="submit"  class="btn_1" value="Save Changes" />
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
      </body>


      <?php include("footer.php");
      function getAge($date){
        $dob = new DateTime($date);
        $now = new DateTime();
        return $now->diff($dob)->y;
      }
      ?>
