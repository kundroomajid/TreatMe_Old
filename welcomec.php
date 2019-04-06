<html>
<?php
include("header.php");
$msg = $_SESSION['msg'];
unset($_SESSION['msg']);
$id = isset($_SESSION['id'])?$_SESSION['id']:null;


function fn_resize($image_resource_id,$width,$height){

  $target_width =300;
  $target_height =300;
  $target_layer=imagecreatetruecolor($target_width,$target_height);
  imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
  return $target_layer;
}

if($id!=null){
  $user_type = isset($_SESSION['user_type'])?$_SESSION['user_type']:null;
  if($user_type==null || $user_type!='c'){
    echo '<script>window.location = "welcome.php";</script>';
  }
  $query ="select * from vw_clinic where clinic_id = $id";
  $result1=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
  $cdrow1=mysqli_fetch_array($result1);
  //getting result from database
  $name = $cdrow1["clinic_name"];
  $email = $cdrow1["clinic_email"];
  $phone = $cdrow1["clinic_phone"];
  $address = $cdrow1['address'];
  $district = $cdrow1["district"];
  $pin = $cdrow1['pincode'];
  

////  get data from appointment table
//  $resultappt = $conn->query("Select * from tb_appointment where doc_id = $id");
//  $count = mysqli_num_rows($resultappt);
//
////  get data from temp appointment table
//  $resulttmpappt = $conn->query("SELECT * FROM tmp_appointment WHERE doc_id = $id") ;
//  $counttmpappt = mysqli_num_rows($resulttmpappt);
//  get education data
//  $resultedu = $conn->query("SELECT * FROM tb_doceducation where doc_id=$id");
}else{
  echo '<script type="text/javascript">
//  alert("Please Login To Continue ")
  window.location = "./login.php";
  </script> ';
}

if($_SERVER["REQUEST_METHOD"] == "POST" ){
  $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $file_size = $_FILES['image']['size'];

  if (($file_size > 655000)){
//    $message = 'File too large. File must be less than 640kb.';
	  $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     File too large. File must be less than 1Mb
    </div>';
//    echo '<script type="text/javascript">alert("'.$message.'");</script>';
  }

  if($file!=null && $file!="")
  {
    //  unset($imagepic);
   $file = $_FILES['image']['tmp_name'];
   $source_properties = getimagesize($file);
   $image_type = $source_properties[2];

  if( $image_type == IMAGETYPE_JPEG ){
    $image_resource_id = imagecreatefromjpeg($file);
    $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
    imagejpeg($target_layer,'temp.jpg');
    $blob = addslashes(file_get_contents('./temp.jpg', true));
    $q = "UPDATE tb_user SET photo= '$blob' where user_id = '$id'";
      $conn->query($q);
	  $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Photo uploaded Sucessfully
    </div>';
  }
  elseif( $image_type == IMAGETYPE_GIF ) {
    $image_resource_id = imagecreatefromgif($file);
    $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
    imagejpeg($target_layer,'temp.jpg');
    $blob = addslashes(file_get_contents('./temp.jpg', true));
    $q = "UPDATE tb_user SET photo= '$blob' where user_id = '$id'";
      $conn->query($q);
	  $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Photo uploaded Sucessfully
    </div>';

  }
  elseif( $image_type == IMAGETYPE_PNG ){
    $image_resource_id = imagecreatefrompng($file);
    $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
    imagejpeg($target_layer,'temp.jpg');
    $blob = addslashes(file_get_contents('./temp.jpg', true));
    $q = "UPDATE tb_user SET photo= '$blob' where user_id = '$id'";
      $conn->query($q);
	  $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Photo uploaded Sucessfully
    </div>';
  }
    }
	else{
		$msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Some Error Occured
    </div>';
	}
}

$str = "select photo from tb_user where user_id = '$id'";
$result = $conn->query($str);
if($result==null) echo "nonos";
if(($r = mysqli_fetch_array($result))!=null)
$imagepic = "<img src = 'data:image/jpeg;base64,".base64_encode( $r[0])."' width='200' height='200' /><br/>";
?>

<link rel="stylesheet" href="./css/tagsinput.css">
<script type="text/javascript" src="./js/tagsinput.js"></script>

<div class="container table-bordered">

  <!---------------------PHOTO--------------------->
  <!--div style="border: 5px solid aqua; margin: 20px; padding : 20px; border-radius: 10px;"-->
  <form method="POST" enctype="multipart/form-data">
    <div class="row my-2">
      <div class="col-lg-4 order-lg-1 text-center">

        <?php echo $imagepic; ?>

        <h6 class="mt-2">Upload a different photo</h6>
        <label class="custom-file">
          <input type="file" class="custom-file-input" id="uploadImage" name="image" id="image" accept=".jpg, .jpeg, .png" required />
          <span class="custom-file-control">Choose file</span>
          <br><br> <br>
        </label>
        <input type="submit" class = "btn_1" value = "Upload"/>
      </div>
  </form>

    <!---------------------TABS--------------------->
    <div class="col-lg-8 order-lg-2">
		<div id="info" class="clearfix">  <?= "$msg";?> </div>
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
        </li>
        <li class="nav-item">
          <a href="" data-target="#myappointments" data-toggle="tab" class="nav-link ">Appointments</a>
        </li>
        <li class="nav-item">
          <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit Profile</a>
        </li>
        <li class="nav-item">
          <a href="" data-target="#adddocs" data-toggle="tab" class="nav-link">Add Doctors</a>
        </li>
        
        <li class="nav-item">
          <a href="" data-target="#addinfo" data-toggle="tab" class="nav-link">View Doctors</a>
        </li>
        
      </ul>

      <div class="tab-content py-4">
        

        <div class="tab-pane active" id="profile">
          <div class="tab-pane" id="profile">
          <div class="row">
            <div class="col-md-8 "></div>

            <div class="col-md-12">
              <h5 class="mt-2"> Clinic Details</h5>
              <table class="table">
                <tr> <td>Clinic Name</td>      <td><?= $user?></td> </tr>
                <tr> <td>Clinic Email</td>     <td><?= $email ?></td> </tr>
                <tr> <td>Clinic Phone</td>     <td><?= $phone ?> </td> </tr>
                <tr> <td>Clinic Address</td>  <td> <?= $address."<br/>".$district." - ".$pin ?> </td> </tr>
              </table>
            </div>
          </div>
        </div>
          

        </div>
        <div class="tab-pane" id ="myappointments">
          <table class='table'>
            <thead>
              <tr><th>Appt Id</th><th>Date</th><th>Patient Name</th><th>Shift</th><th>Queue No</th><th>Status</th></tr>
            </thead>
            <tbody>
          <?php
             $q= "Select * from tb_clinic_docs where clinic_id = $id";
              $result=mysqli_query($conn,$q) or die ("Query to get data from firsttable failed: ".mysqli_error());
                $countdocs = mysqli_num_rows($result);
                if($countdocs > 0)          
                {
                  while ($cdrow2=mysqli_fetch_array($result)) 
                  {
                    //getting result from database
                    $doc_id=$cdrow2['doc_id'];
                    //  get data from appointment table
                $resultappt = $conn->query("Select * from tb_appointment where doc_id = $doc_id");
                  $count = mysqli_num_rows($resultappt);

                      //  get data from temp appointment table
                  $resulttmpappt = $conn->query("SELECT * FROM tmp_appointment WHERE doc_id = $doc_id") ;
                          $counttmpappt = mysqli_num_rows($resulttmpappt);
                    // get doc name from vw_doctor table
                    $getdocname = $conn->query("Select user_name from vw_doctor where user_id = $doc_id");
                    $cdrow4=mysqli_fetch_array($getdocname);
                    $doc_name = $cdrow4['user_name'];
                    

                  if($count > 0 || $counttmpappt > 0) {

                    if($count > 0) {
                      while ($cdrow2=mysqli_fetch_array($resultappt)) {
                //getting result from database
                $appt_id = $cdrow2["apptt_id"];
                $pat_id = $cdrow2["pat_id"];
                $appt_date = $cdrow2["appt_date"];
                $shift = $cdrow2["shift"];
                $shift_type = ($shift==0)?'Morning':'Evening';
                $queue_no = $cdrow2["queue_no"];
                //query to get doc name from view doctor
                $docquery = $conn->query("select user_name from vw_patient where pat_id = $pat_id");
                $cdrow3=mysqli_fetch_array($docquery);
                $pat_name = $cdrow3["user_name"];
                echo "<tr><td colspan='6'><i><b>$doc_name</b> <i/> (confirmed Appointments) </td></tr>";
                echo "<tr><td>$appt_id <span class=''></span> </td><td>$appt_date</td><td>$pat_name</td><td>$shift_type</td><td>$queue_no</td>
                <td>confirmed</td>
                </tr>" ;

                //<a href='#' class='btn btn-sm btn-success'><span class='icon_check_alt2'></span> </a>
                // <a class='btn btn-sm btn-danger' href='delete_appointment.php?appt_id=$appt_id'>X</a>
            }
          }

          if ($counttmpappt > 0){
            echo "<tr><td colspan='6'><i><b>$doc_name</b> <i/>(Unconfirmed Appointments) </td></tr>";
            while ($cdrow2=mysqli_fetch_array($resulttmpappt)) {
                //getting result from database
                $tmp_id = $cdrow2["tmp_id"];
                $pat_id = $cdrow2["pat_id"];
                $appt_date = $cdrow2["appt_date"];
                $shift = $cdrow2["shift"];
                $shift_type = ($shift==0)?'Morning':'Evening';
                //query to get doc name from view doctor
                $docquery = $conn->query("select user_name from vw_patient where pat_id = $pat_id");
                $cdrow3=mysqli_fetch_array($docquery);
                $pat_name = $cdrow3["user_name"];

                echo "<tr><td>$tmp_id</td><td>$appt_date</td><td>$pat_name</td><td>$shift_type</td><td>unconfirmed</td>
                <td>
                  <a class='btn btn-sm btn-danger' href='confirm_appointment.php?tmp_id=$tmp_id&confirmed=0'>X</a>
                  <a href='confirm_appointment.php?tmp_id=$tmp_id&confirmed=1' class='btn btn-sm btn-success'><span class='icon_check_alt2'></span></a>
                </td></tr>" ;
                //<a href='#' class='btn btn-sm btn-success'><span class='icon_check_alt2'></span> </a>
                // <a class='btn btn-sm btn-danger' href='delete_appointment.php?appt_id=$appt_id'>X</a>
            }
          }
                  }
                  }
        }else{
          echo "<tr><td colspan='6'>No appointments booked yet</td></tr>";
        }

          ?>
          <tbody>
          </table>
        </div>

        <div class="tab-pane" id="edit">
          <form role="form" method="post" action="edit_profile.php">
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Clinic Name </label>
              <div class="col-lg-9"> <input class="form-control" type="text" name ="name" value="<?php echo $user; ?>"> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Clinic Email</label>
              <div class="col-lg-9"> <input class="form-control"  name ="email" type="email" readonly value="<?php echo $email; ?>"> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Clinic Phone No</label>
              <div class="col-lg-9"> <input class="form-control" type="number" name ="phone_no" value="<?php echo $phone; ?>"> </div>
            </div>
            
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label"> Clinic Address</label>
              <div class="col-lg-9">
                <textarea name="address" rows="3" class="col-lg-12" ><?= $address ?></textarea>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">District</label>
              <div class="col-lg-3">
                <select id = "district" class="form-control" name ="district">
                  <option value = "<?php echo $district; ?>"><?php echo $district; ?></option>
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
              <div class="col-lg-3"> <input class="form-control" type="number" name ="pin" value="<?= $pin ?>"> </div>
            </div>

            <hr style="width:100%"/>

<!--
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Specialization</label>
              <div class="col-lg-9">
                <input class="form-control" type="text" name ="specialization" id = "specialization" value="<?= $specialization ?>"> </div>
                <script type="text/javascript">
                $('#specialization').tagsInput();
                </script>
              </div>
-->
<!--
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Registration Council</label>
                <div class="col-lg-9"> <input class="form-control" type="text" name ="registration_council" value="<?= $registration_council ?>"> </div>
              </div>
-->
<!--
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Registration Year</label>
                <div class="col-lg-3"> <input class="form-control" type="text" name ="registration_year" value="<?= $registration_year ?>"> </div>
                <label class="col-lg-3 col-form-label form-control-label">Registration No</label>
                <div class="col-lg-3"> <input class="form-control" type="text" name ="registration_no" value="<?= $registration_no ?>"> </div>
              </div>
-->

              <hr style="width:100%"/>

              
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label"></label>
                <div class="col-lg-9">
                  <input type="submit"  class="btn_1" value="Save Changes">
                </div>
              </div>
            </form>
        </div>
          <div class="tab-pane" id="adddocs">
          <form role="form" method="post" action="add_docs.php">
            
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Doc Email</label>
                <div class="col-lg-9"> <input class="form-control" type="email" name ="doc_email" placeholder="Enter Doc Email" > </div>
              </div>
            
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Doc Password</label>
                <div class="col-lg-9"> <input class="form-control" type="password" name ="doc_password" placeholder="Enter Password" > </div>
              </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Doc Name</label>
                <div class="col-lg-9"> <input class="form-control" type="text" name ="doc_name" placeholder="Enter Name Of Doctor" > </div>
              </div>
            
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Doc Phone</label>
                <div class="col-lg-9"> <input class="form-control" type="phone" name ="doc_phone" placeholder="Enter Doc Phone No" > </div>
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
            
             <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">District</label>
              <div class="col-lg-3">
                <select id = "doc_district" class="form-control" name ="doc_district">
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
            </div>
            
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Doc Degree</label>
                <div class="col-lg-9"> <input class="form-control" type="text" name ="doc_degree" placeholder="Degree" > </div>
              </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Institute</label>
                <div class="col-lg-9"> <input class="form-control" type="text" name ="doc_institute" placeholder="Institute" > </div>
              </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Experience</label>
                <div class="col-lg-9"> <input class="form-control" type="number" name ="doc_experience" placeholder="Experience In Years" > </div>
              </div>
            
            
										<div class="form-group row">
                                          <label class="col-lg-3 col-form-label form-control-label">Specializations</label>
                                          <div class="col-lg-9"> <input class="form-control"type="text" id="specialization" name ="specialization"class="form-control" placeholder="What is Your specialization" /></div>
												<script type="text/javascript">
													$('#specialization').tagsInput();
												</script>
										</div>
            
            <div class="form-group row">

              <label class="col-lg-3 col-form-label form-control-label"> Morning Shift Start Time</label>
              <div class="col-lg-9">  <input class="form-control" type="time" name="morning_start_time" /></div>
            </div>

            <div class="form-group row">

              <label class="col-lg-3 col-form-label form-control-label"> Morning Shift End Time</label>
              <div class="col-lg-9">  <input class="form-control" type="time" name="morning_end_time" /></div>
            </div>
            <div class="form-group row">

              <label class="col-lg-3 col-form-label form-control-label"> Evening Shift Start Time</label>
              <div class="col-lg-9">  <input class="form-control" type="time" name="evening_start_time" /></div>
            </div>

            <div class="form-group row">

              <label class="col-lg-3 col-form-label form-control-label">Evening Shift End Time </label>
              <div class="col-lg-9">  <input class="form-control" type="time" name="evening_end_time" /></div>
            </div>
                                    
            
							<p class="text-center add_top_30"><input type="submit" class="btn_1" value="Submit" /></p>
							<div class="text-center"><small></small></div>
						</form>
            
        </div>
      

        <div class="tab-pane" id="addinfo">
            <table class='table table-responsive'>
              <thead>
                <tr><th>Doc Id</th><th>Name</th><th>Degree</th><th>Specalization</th><th>&nbsp;</th></tr>
              </thead>
              <tbody>
                <?php
             $q= "Select * from tb_clinic_docs where clinic_id = $id";
              $result=mysqli_query($conn,$q) or die ("Query to get data from firsttable failed: ".mysqli_error());
                $count = mysqli_num_rows($result);
                if($count > 0)          
                {
                  while ($cdrow2=mysqli_fetch_array($result)) 
                  {
                    //getting result from database
                    $doc_id=$cdrow2['doc_id'];
                  
                    
                    $query = "Select * from vw_doctor where doc_id = $doc_id";
                    $result1 = mysqli_query($conn,$query);
                    $cdrow1 = mysqli_fetch_array($result1);         
                    $user_name=$cdrow1['user_name'];
				    $specalization = $cdrow1['specialization'];
//                    query to get degree feom tb_qualifications
                     $query1="SELECT degree FROM tb_qualifications where doct_id = $doc_id";
                      $result1=mysqli_query($conn,$query1) or die ("Query to get data from firsttable failed: ".mysqli_error());
                    $cdrow1=mysqli_fetch_array($result1);
                      $degree = strtoupper($cdrow1['degree']);
                                
                    
                    echo "<tr><td>$doc_id</td><td>$user_name</td><td>$degree</td><td>$specalization</td></tr>" ;
                  }
                  // }
                }else 
                {
                  echo("<tr><td colspan='5'><h5>No Doctor registered yet</td></tr>");
                }
                ?>
                <tbody> </table>
          </div>

           
                
              </tbody>
              
            </table>
        </div>

          </form>
        </div></div>
   
  </div>




</body>
<?php include("footer.php");?>
</html>