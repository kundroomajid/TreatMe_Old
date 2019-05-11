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
  
  //get data from temp appointment tablet
  $resulttmpappt = $conn->query("SELECT * FROM tmp_appointment WHERE pat_id = $id") ;
  $counttmpappt = mysqli_num_rows($resulttmpappt);
  
} else {
  echo '<script type="text/javascript">
//  alert("Please Login To Continue ")
  window.location = "./login.php";
  </script> ';
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

<body>
  <div class="container">
    <!---------------------PHOTO--------------------->
	<script type="text/javascript" src="./js/jquery.form.min.js"></script>

<script type="text/javascript">
	 var email = " <?php echo $email ?> ";
	var url = "uploadFile.php?email="+email;
	url = url.replace(/\s/g,'');
$(document).ready(function () {
	$('#progressDivId').hide();
    $('#submitButton').click(function () {
    	    $('#uploadForm').ajaxForm({
    	        target: '#outputImage',
    	        url: url,
    	        beforeSubmit: function () {
    	        	  $("#outputImage").hide();
    	        	   if($("#uploadImage").val() == "") {
    	        		   $("#outputImage").show();
    	        		   $("#outputImage").html("<div class='error'>Choose a file to upload.</div>");
                    return false; 
                }
    	            $("#progressDivId").css("display", "block");
    	            var percentValue = '0%';

    	            $('#progressBar').width(percentValue);
    	            $('#percent').html(percentValue);
    	        },
    	        uploadProgress: function (event, position, total, percentComplete) {

    	            var percentValue = percentComplete + '%';
    	            $("#progressBar").animate({
    	                width: '' + percentValue + ''
    	            }, {
    	                duration: 3000,
    	                easing: "linear",
    	                step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
    	                    $("#percent").text(percentText + "%");
                        if(percentText == "100") {
							
                        	   $("#outputImage").show();
								$('#progressDivId').hide();
							
                        }
    	                }
    	            });
    	        },
    	        error: function (response, status, e) {
					$("#progressBar").stop();
    	            alert('Oops something went.');
    	        },
    	        
//    	        complete: function (xhr) {
//    	            if (xhr.responseText && xhr.responseText != "error")
//    	            {
//    	            	  $("#outputImage").html(xhr.responseText);
//    	            }
//    	            else{  
//    	               	$("#outputImage").show();
//        	            	$("#outputImage").html("<div class='error'>Problem in uploading file.</div>");
//        	            	$("#progressBar").stop();
//    	            }
//    	        }
    	    });
    });
});
</script>

	
	
  <!--div style="border: 5px solid aqua; margin: 20px; padding : 20px; border-radius: 10px;"-->
  <form action="uploadFile.php?email=<?=$email?>" id="uploadForm" name="frmupload"
            method="post" enctype="multipart/form-data">
    <div class="row my-2">
      <div class="col-lg-4 order-lg-1 text-center">

		  <div id='outputImage'><?php echo $imagepic; ?></div>
        

        <h6 class="mt-2">Upload a different photo</h6>
		  
		  
			 
			  <label class="custom-file">
          <input type="file" class="custom-file-input" id="uploadImage" name="uploadImage" accept=".jpg, .jpeg, .png" required />
          <span class="custom-file-control">Choose file</span>
          <br><br> <br>
        </label>
		  
		 <br /> <input type="submit" id="submitButton" name="btnSubmit" class="btn_1" value="Upload" />
		  </form>
			  <br /><br />
				  <div class='progress' id="progressDivId">
            <div class='progress-bar' id='progressBar' role="progressbar"></div>
            <div class='percent' id='percent'>0%</div>
					   <div style="height: 10px;"></div>
        </div>
       
	  </div>
      
		  
		 
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
          <div class="tab-pane active" id="profile">
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
          </div>
          <div class="tab-pane" id="myappointments">
            <table class='table table-responsive'>
              <thead>
                <tr><th>Appt Id</th><th>Date</th><th>Doc Name</th><th>Shift</th><th>Queue No</th><th>&nbsp;</th></tr>
              </thead>
              <tbody>
                <?php
                
                if($count > 0 || $counttmpappt >0)
                {
                  if($count > 0)
                {
                    echo "<tr><td colspan='6'>Confirmed</td></tr>";
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
                  
                }
                  if($counttmpappt >0)
                  {
                    echo "<tr><td colspan='6'>Un Confirmed</td></tr>";
            while ($cdrow2=mysqli_fetch_array($resulttmpappt)) {
                //getting result from database
                $tmp_id = $cdrow2["tmp_id"];
                $pat_id = $cdrow2["pat_id"];
                $appt_date = $cdrow2["appt_date"];
                $shift = $cdrow2["shift"];
              $doc_id = $cdrow2["doc_id"];
              
                $shift_type = ($shift==0)?'Morning':'Evening';
               $docquery = $conn->query("select user_name from vw_doctor where doc_id = $doc_id");
                    $cdrow3=mysqli_fetch_array($docquery);
                    $doc_name = $cdrow3["user_name"];
              echo ("<tr><td>$tmp_id</td><td>$appt_date</td><td>$doc_name</td><td>$shift_type</td><td>$queue_no</td><td><a href='delete_appointment.php?t_appt_id=$tmp_id'>Delete</td></td></tr>");
                  }
                }
                }
                  else {
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

       
      </body>
</html>


      <?php include("footer.php");
      function getAge($date){
        $dob = new DateTime($date);
        $now = new DateTime();
        return $now->diff($dob)->y;
      }
      ?>
