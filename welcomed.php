<?php
include_once("header.php");
$msg = $_SESSION['msg'];

$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;




if ($id != null) {
  $user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
  if ($user_type == null || $user_type != 'd') {
    echo '<script>window.location = "welcome.php";</script>';
  }
  $query = "select * from vw_doctor where user_id = $id";
  $result1 = mysqli_query($conn, $query) or die("Query to get data from first table failed: " . mysqli_error());
  $cdrow1 = mysqli_fetch_array($result1);
  //getting result from database
  $name = $cdrow1["user_name"];
  $email = $cdrow1["user_email"];
  $phone = $cdrow1["user_phone"];
  $dob = $cdrow1["dob"];
  $height = $cdrow1["height"];
  $weight = $cdrow1["weight"];
  $blood_group = $cdrow1["blood_group"];
  $gender = $cdrow1["gender"];
  $address = $cdrow1['address'];
  $district = $cdrow1["district"];
  $clinic_name = $cdrow1["clinic_name"];
  $fee = $cdrow1["fee"];
  $c_validity = $cdrow1['c_validity'];
  $clinic_address = $cdrow1["clinic_address"];
  $pin = $cdrow1['pincode'];
  $specialization = $cdrow1['specialization'];
  $registration_council = $cdrow1['registration_council'];
  $registration_no = $cdrow1['registration_no'];
  $registration_year = $cdrow1['registration_year'];
  $morning_start_time = $cdrow1['morning_start_time'];
  $morning_end_time = $cdrow1['morning_end_time'];
  $evening_start_time = $cdrow1['evening_start_time'];
  $evening_end_time = $cdrow1['evening_end_time'];

  $gender_symbol = ($gender == 'Male') ? "&#9794;" : ($gender == 'Female') ? "&#9792;" : "&#9893;";

  // get verification satus from tb_verification
  $verify = $conn->query("Select status from tb_verification where doc_id = $id");
  $cdrow4 = mysqli_fetch_array($verify);
  $verification_status = $cdrow4['status'];


  if ($verification_status == 0) // has not uploaded documnets yet
  {
    $msgverification = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Please Verify your Degree By uploading documents From Dashboard
  </div>';
  } else if ($verification_status == 1) {
    $msgverification = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Thanks for Uploading Documents Your account is pending for verification .
  </div>';
  } else { }



  //get data from appointment table
  $resultappt = $conn->query("Select * from tb_appointment where doc_id = $id");
  $count = mysqli_num_rows($resultappt);

  //get data from temp appointment tablet
  $resulttmpappt = $conn->query("SELECT * FROM tmp_appointment WHERE doc_id = $id");
  $counttmpappt = mysqli_num_rows($resulttmpappt);
  //get education data
  $resultedu = $conn->query("SELECT * FROM tb_qualifications where doct_id=$id");
} else {
  echo '<script type="text/javascript">
//  alert("Please Login To Continue ")
  window.location = "./login.php";
  </script> ';
}


$str = "select photo from tb_user where user_id = '$id'";
$result = $conn->query($str);
if ($result == null) echo "nonos";
if (($r = mysqli_fetch_array($result)) != null)
  $imagepic = "<img src = 'data:image/jpeg;base64," . base64_encode($r[0]) . "' width='200' height='200' /><br/>";
?>

<link rel="stylesheet" href="./css/tagsinput.css">
<script type="text/javascript" src="./js/tagsinput.js"></script>

<div class="container table-bordered">

  <!---------------------PHOTO--------------------->
  <script type="text/javascript" src="./js/jquery.form.min.js"></script>

  <script type="text/javascript">
    var email = " <?php echo $email ?> ";
    var url = "uploadFile.php?email=" + email;
    url = url.replace(/\s/g, '');
    $(document).ready(function() {
      $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $('#filename').html(fileName);
      });
      $('#progressDivId').hide();
      $('#submitButton').click(function() {
        $('#uploadForm').ajaxForm({
          target: '#outputImage',
          url: url,
          beforeSubmit: function() {
            $("#outputImage").hide();
            if ($("#uploadImage").val() == "") {
              $("#outputImage").show();
              $("#outputImage").html("<div class='error'>Choose a file to upload.</div>");
              return false;
            }
            $("#progressDivId").css("display", "block");
            var percentValue = '0%';

            $('#progressBar').width(percentValue);
            $('#percent').html(percentValue);
          },
          uploadProgress: function(event, position, total, percentComplete) {

            var percentValue = percentComplete + '%';
            $("#progressBar").animate({
              width: '' + percentValue + ''
            }, {
              duration: 3000,
              easing: "linear",
              step: function(x) {
                percentText = Math.round(x * 100 / percentComplete);
                $("#percent").text(percentText + "%");
                if (percentText == "100") {

                  $("#outputImage").show();
                  $('#progressDivId').hide();

                }
              }
            });
          },
          error: function(response, status, e) {
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
  <form action="uploadFile.php" id="uploadForm" name="frmupload" method="post" enctype="multipart/form-data">
    <div class="row my-2">
      <div class="col-lg-4 order-lg-1 text-center">

        <div id='outputImage'><?php echo $imagepic; ?></div>


        <h6 class="mt-2">Upload a different photo</h6>


        <label class="custom-file">
          <input type="file" class="custom-file-input" id="uploadImage" name="uploadImage" accept=".jpg, .jpeg, .png" required />
          <span class="custom-file-control">Choose file</span>
          <br><br> <br>
        </label>
        <div id="filename"></div>

        <br /> <input type="submit" id="submitButton" name="btnSubmit" class="btn_1" value="Upload" />
  </form>
  <br /><br />
  <div class='progress' id="progressDivId">
    <div class='progress-bar' id='progressBar' role="progressbar"></div>
    <div class='percent' id='percent'>0%</div>
    <div style="height: 10px;"></div>
  </div>


</div>


<!---------------------TABS--------------------->
<div class="col-lg-8 order-lg-2">
  <div id="info" class="clearfix"> <?= "$msg"; ?> </div>
  <div id="info" class="clearfix"> <?= "$msgverification"; ?> </div>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a href="" data-target="#profile" data-toggle="tab" class="nav-link">Profile</a>
    </li>
    <li class="nav-item">
      <a href="" data-target="#myappointments" data-toggle="tab" class="nav-link active">Appointments</a>
    </li>
    <li class="nav-item">
      <a href="" data-target="#doc_schedule" data-toggle="tab" class="nav-link">Schedule</a>
    </li>
    <li class="nav-item">
      <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit Profile</a>
    </li>
    <li class="nav-item">
      <a href="" data-target="#addinfo" data-toggle="tab" class="nav-link">Additional Info</a>
    </li>
    <li class="nav-item">
      <a href="" data-target="#verification" data-toggle="tab" class="nav-link">Upload Documents</a>
    </li>    
  </ul>

  <div class="tab-content py-4">


    <div class="tab-pane" id="profile">
      <div class="tab-pane" id="profile">
        <div class="row">
          <div class="col-md-8 ">

            <h4> <?= $user . "(" . getAge($dob) . ")" . $gender_symbol  ?>
              <?php
              if ($verification_status == 0) {
                echo ('<h5><b style="color:red">(Not Verified)</b></h5>');
              } else if ($verification_status == 1) {
                echo ('<h5><i style="color:blue">(Pending for Verification)</i></h5>');
              } else {
                echo ('<h5>(Verified)</h5>');
              }
              ?>




            </h4>
          </div>
          <div class="col-md-12">
            <h5 class="mt-2"> User Details</h5>
            <table class="table">
              <tr>
                <td>Name</td>
                <td><?= $user ?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?= $email ?></td>
              </tr>
              <tr>
                <td>Phone</td>
                <td><?= $phone ?> </td>
              </tr>
              <tr>
                <td>Address</td>
                <td> <?= $address . "<br/>" . $district . " - " . $pin ?> </td>
              </tr>

              <tr>
                <td>Specialization</td>
                <td> <?= $specialization ?> </td>
              </tr>
              <tr>
                <td>Clinic Name</td>
                <td> <?= $clinic_name ?> </td>
              </tr>
              <tr>
                <td>Clinic Address</td>
                <td> <?= $clinic_address ?> </td>
              </tr>
              <tr>
                <td>Fee</td>
                <td> <?= $fee ?> </td>
              </tr>
              <tr>
                <td>Consultation Validity</td>
                <td> <?= $c_validity ?> </td>
              </tr>
              <tr>
                <td>Registration</td>
                <td> <?= $registration_council . "(" . $registration_year . ") [Reg. No: " . $registration_no . "]" ?> </td>
              </tr>

              <tr>
                <td>Morning Timing</td>
                <td> <?= "$morning_start_time to $morning_end_time" ?></td>
              </tr>
              <tr>
                <td>Morning Timing</td>
                <td> <?= "$evening_start_time to $evening_end_time" ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>


    </div>
    <div class="tab-pane active" id="myappointments">
      <?php include_once('confirmation_table.php'); ?>
    </div>

    <div class="tab-pane" id="doc_schedule">
      <?php include_once('doc_schedule.php'); ?>
    </div>

    <div class="tab-pane" id="edit">
      <form role="form" method="post" action="edit_profile.php">
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Name </label>
          <div class="col-lg-9"> <input class="form-control" type="text" name="name" value="<?php echo $user; ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Email</label>
          <div class="col-lg-9"> <input class="form-control" name="email" type="email" readonly value="<?php echo $email; ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Phone No</label>
          <div class="col-lg-9"> <input class="form-control" type="number" name="phone_no" value="<?php echo $phone; ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Gender</label>
          <div class="col-lg-3">
            <select id="gender" class="form-control" name="gender">
              <option value="<?php echo $gender; ?>"><?php echo $gender; ?></option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <label class="col-lg-3 col-form-label form-control-label">D.O.B</label>
          <div class="col-lg-3"> <input class="form-control" type="date" name="dob" value="<?php echo $dob; ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Clinic Name</label>
          <div class="col-lg-9"> <input class="form-control" type="text" name="clinic_name" value="<?php echo $clinic_name; ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Clinic Address</label>
          <div class="col-lg-9">
            <textarea name="clinic_address" rows="3" class="col-lg-12"><?= $clinic_address ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Fee</label>
          <div class="col-lg-9"> <input class="form-control" type="number" name="fee" value="<?php echo $fee; ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Validity</label>
          <div class="col-lg-9"> <input class="form-control" type="text" name="c_validity" value="<?php echo $c_validity; ?>"> </div>
        </div>

        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">District</label>
          <div class="col-lg-3">
            <select id="district" class="form-control" name="district">
              <option value="<?php echo $district; ?>"><?php echo $district; ?></option>
              <option value="Anantnag">Anantnag</option>
              <option value="Bandipora">Bandipora</option>
              <option value="Baramulla">Baramulla</option>
              <option value="Budgam">Budgam</option>
              <option value="Ganderbal">Ganderbal</option>
              <option value="Kulgam">Kulgam</option>
              <option value="Kupwara">Kupwara</option>
              <option value="Pulwama">Pulwama</option>
              <option value="Shopain">Shopain</option>
              <option value="Srinagar">Srinagar</option>
              <option value="Doda">Doda</option>
              <option value="Jammu">Jammu</option>
              <option value="Kathua">Kathua</option>
              <option value="Kishtwar">Kishtwar</option>
              <option value="Poonch">Poonch</option>
              <option value="Rajouri">Rajouri</option>
              <option value="Reasi">Reasi</option>
              <option value="Ramban">Ramban</option>
              <option value="Samba">Samba</option>
              <option value="Udhampur">Udhampur</option>
              <option value="Kargil">Kargil</option>
              <option value="Leh">Leh</option>
            </select>
          </div>
          <label class="col-lg-3 col-form-label form-control-label">Pin</label>
          <div class="col-lg-3"> <input class="form-control" type="number" name="pin" value="<?= $pin ?>"> </div>
        </div>

        <hr style="width:100%" />

        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Specialization</label>
          <div class="col-lg-9">
            <input class="form-control" type="text" name="specialization" value="<?= $specialization ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Registration Council</label>
          <div class="col-lg-9"> <input class="form-control" type="text" name="registration_council" value="<?= $registration_council ?>"> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Registration Year</label>
          <div class="col-lg-3"> <input class="form-control" type="text" name="registration_year" value="<?= $registration_year ?>"> </div>
          <label class="col-lg-3 col-form-label form-control-label">Registration No</label>
          <div class="col-lg-3"> <input class="form-control" type="text" name="registration_no" value="<?= $registration_no ?>"> </div>
        </div>

        <hr style="width:100%" />
        <div align="center" id="infotime1" class="clearfix" style="color:red"> </div>
        <div align="center" id="infotime2" class="clearfix" style="color:red"> </div>
        <div class="form-group row">

          <label class="col-lg-3 col-form-label form-control-label">Morning Start Time</label>
          <div class="col-lg-3"> <input class="form-control" type="time" name="morning_start_time" id="mst" value="<?php echo $morning_start_time ?>" required> </div>
          <label class="col-lg-3 col-form-label form-control-label">Morning End Time</label>
          <div class="col-lg-3"> <input class="form-control" type="time" name="morning_end_time" id="met" onchange="check_morning_time()" value="<?php echo $morning_end_time ?>" required> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label">Evening Start Time</label>
          <div class="col-lg-3"> <input class="form-control" type="time" name="evening_start_time" id="est" value="<?php echo $evening_start_time ?>" required> </div>
          <label class="col-lg-3 col-form-label form-control-label">Evening End Time</label>
          <div class="col-lg-3"> <input class="form-control" type="time" name="evening_end_time" id="eet" onchange="check_evening_time()" value="<?php echo $evening_end_time ?>" required> </div>
        </div>
        <div class="form-group row">
          <label class="col-lg-3 col-form-label form-control-label"></label>
          <div class="col-lg-9">
            <input type="submit" class="btn_1" value="Save Changes">
          </div>
        </div>
      </form>
    </div>

    <div class="tab-pane" id="addinfo">
      <div class="table-responsive">
        <form class="" action="update_edu.php" method="post">

          <table id="edutable" class="table-condensed">
            <thead>
              <tr>
                <th>Degree</th>
                <th>Year</th>
                <th>Institute</th>
                <th>&nbsp;</th>
              </tr>
            </thead>

            <tbody id="educontrols">
              <?php
              $rowcount = mysqli_num_rows($resultedu);
              if ($rowcount > 0) {
                while (($r = mysqli_fetch_array($resultedu)) != null) {
                  $degree = $r['degree'];
                  $year = $r['completion_year'];
                  $institute = $r['institute'];
                  ?>
                  <tr>
                    <td><input class='input-sm' name='degree[]' value="<?= $degree ?>" /></td>
                    <td><input class='input-sm' name='year[]' value="<?= $year ?>" /></td>
                    <td><input class='input-sm' name='institute[]' value="<?= $institute ?>" /></td>
                    <td><input class='btn btn-danger btn-sm' onclick="delete_me(this)" type="button" Value='X' /></td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr>
                  <td><input class='input-sm' name='degree[]' /></td>
                  <td><input class='input-sm' name='year[]' /></td>
                  <td><input class='input-sm' name='institute[]' /></td>
                  <td><input class='btn btn-danger btn-sm' onclick="delete_me(this)" type="button" Value='X' /></td>
                </tr>
              <?php
              }
              ?>
              <tr>
                <td colspan="3">&nbsp;</td>
                <td><input class='btn btn-primary btn-sm' type="button" id="add" Value="Add New" /></td>
              </tr>
            </tbody>
          </table>
          <input class='btn btn-success' type='submit' value="Update" />

        </form>
      </div>
      <script type="text/javascript">
        var add_button = $("#add");

        function delete_me(v) {
          v = $(v).parent().parent();

          if (!v.is(":first-child")) {
            v.remove();
          }
        }

        // handle click and add class
        add_button.on("click", function() {
          edu = $('#educontrols');
          control = $("#educontrols").children().first();
          edu.prepend(control[0].outerHTML);
        });
      </script>
    </div>
    <!---------------------verification upload documnets--------------------->
    <div class="tab-pane" id="verification">

      <form method="POST" enctype="multipart/form-data" action="upload_docs.php">
        <div class="row my-2">
          <div class="form-group">

            <h6 class="mt-2">Upload Letter of authourity or Degree Certificate</h6>
            <label class="custom-file">
              <input type="file" class="custom-file-input" id="uploadImage" name="image" accept=".jpg, .jpeg, .png" required />
              <span class="custom-file-control">Choose file</span>
              <br><br> <br>
            </label>
            <input type="submit" class="btn_1" value="Upload" />
          </div>




        </div>


      </form>


    </div>


  </div>
</div>

</div>

<?php include("footer.php");

unset($_SESSION['msg']);

function getAge($date)
{
  $dob = new DateTime($date);
  $now = new DateTime();
  return $now->diff($dob)->y;
}
?>

</html>