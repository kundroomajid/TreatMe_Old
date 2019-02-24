<?php
include("header.php");
$id = isset($_SESSION['id'])?$_SESSION['id']:null;


function fn_resize($image_resource_id,$width,$height) 
{

$target_width =300;
$target_height =300;
$target_layer=imagecreatetruecolor($target_width,$target_height);
imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
return $target_layer;
}

if($id!=null){
  $query ="select * from vw_doctor where user_id = $id";
  $result1=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
  $cdrow1=mysqli_fetch_array($result1);
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
  $pin = $cdrow1['pincode'];
  $specialization = $cdrow1['specialization'];
  $registration_council = $cdrow1['registration_council'];
  $registration_no = $cdrow1['registration_no'];
  $registration_year = $cdrow1['registration_year'];
  $morning_start_time = $cdrow1['morning_start_time'];
  $morning_end_time = $cdrow1['morning_end_time'];
  $evening_start_time = $cdrow1['evening_start_time'];
  $evening_end_time = $cdrow1['evening_end_time'];

  $gender_symbol = ($gender=='Male')?"&#9794;":($gender=='Female')?"&#9792;":"&#9893;";


  //get data from appointment table
  $apptquery = "Select * from tb_appointment where pat_id = $id";
  $resultappt = $conn->query($apptquery);
  $count = mysqli_num_rows($resultappt);

  //get education data
  $eduquery = "SELECT * FROM tb_doceducation where doc_id=$id";
  $resultedu = $conn->query("SELECT * FROM tb_doceducation where doc_id=$id");
}else{
  echo '<script type="text/javascript">
  alert("Please Login To Continue ")
  window.location = "./login.php";
  </script> ';
}

if($_SERVER["REQUEST_METHOD"] == "POST" )
{
  $file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
  $file_size = $_FILES['image']['size'];

  if (($file_size > 655000)){
    $message = 'File too large. File must be less than 640kb.';
    echo '<script type="text/javascript">alert("'.$message.'");</script>';
  }

  if($file!=null && $file!="")
  {
    //  unset($imagepic);
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
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="" data-target="#profile" data-toggle="tab" class="nav-link">Profile</a>
        </li>
        <li class="nav-item">
          <a href="" data-target="#myappointments" data-toggle="tab" class="nav-link">My Appointments</a>
        </li>
        <li class="nav-item">
          <a href="" data-target="#edit" data-toggle="tab" class="nav-link">Edit Profile</a>
        </li>
        <li class="nav-item">
          <a href="" data-target="#addinfo" data-toggle="tab" class="nav-link active">Additional Info</a>
        </li>
      </ul>

      <div class="tab-content py-4">
        <div class="tab-pane" id="profile">
          <div class="row">
            <div class="col-md-8 ">
              <h4> <?= $user."(".getAge($dob).")".$gender_symbol  ?></h4>
            </div>

            <div class="col-md-12">
              <h5 class="mt-2"> User Details</h5>
              <table class="table">
                <tr> <td>Name</td>      <td><?= $user?></td> </tr>
                <tr> <td>Email</td>     <td><?= $email ?></td> </tr>
                <tr> <td>Phone</td>     <td><?= $phone ?> </td> </tr>
                <tr> <td>Address</td>  <td> <?= $address."<br/>".$district." - ".$pin ?> </td> </tr>

                <tr> <td>Specialization</td>  <td>  <?= $specialization ?> </td> </tr>
                <tr> <td>Registration</td>  <td>  <?= $registration_council."(".$registration_year.") [Reg. No: ".$registration_no."]" ?> </td> </tr>

                <tr>  <td>Morning Timing</td> <td>  <?= "$morning_start_time to $morning_end_time" ?></td></tr>
                <tr>  <td>Morning Timing</td> <td>  <?= "$evening_start_time to $evening_end_time" ?></td></tr>
              </table>
            </div>
          </div>
        </div>

        <div class="tab-pane" id="myappointments">
          <?php   if($resultappt ->num_rows > 0)
          {

            if($count == "0")
            {
              $apptmessage = "No Appointments Booked yet";
              //                die ("Query to get data from first table failed: ".mysqli_error());)

            }
            else
            {
              $apptmessage = "Appointments Booked";
              echo($apptmessage);
              echo("<div class='table-responsive'> <table class='table'><thead><tr><th>Appt Id</th><th>Date</th><th>Doc Name</th><th>Shift</th><th>Queue No</th></tr></thead></table></div>");
              while ($cdrow2=mysqli_fetch_array($resultappt))
              {

                //getting result from database
                $appt_id = $cdrow2["apptt_id"];
                $doc_id = $cdrow2["doc_id"];
                $appt_date = $cdrow2["appt_date"];
                $shift = $cdrow2["shift"];
                $queue_no = $cdrow2["queue_no"];
                //query to get doc name from view doctor
                $docquery = $conn->query("select user_name from vw_doctor where doc_id = $doc_id");
                $cdrow3=mysqli_fetch_array($docquery);
                $doc_name = $cdrow3["user_name"];
                echo"<div class='table-responsive'><table class='table'> <tbody><tr><td>&nbsp;&nbsp;$appt_id </td><td> $appt_date</td><td>  $doc_name</td><td>  $shift</td><td>  $queue_no</td></tr></tbody></table></div>" ;
              }
            }

          }

          else
          {
            echo("<h5>No Appointments booked Yet</h5>");

          }
          ?>

        </div>

        <div class="tab-pane" id="edit">
          <form role="form" method="post" action="edit_profile.php">
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Name </label>
              <div class="col-lg-9"> <input class="form-control" type="text" name ="name" value="<?php echo $user; ?>"> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Email</label>
              <div class="col-lg-9"> <input class="form-control"  name ="email" type="email" readonly value="<?php echo $email; ?>"> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Phone No</label>
              <div class="col-lg-9"> <input class="form-control" type="number" name ="phone_no" value="<?php echo $phone; ?>"> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Gender</label>
              <div class="col-lg-3">
                <select id = "gender" class="form-control" name ="gender">
                  <option value = "<?php echo $gender; ?>"><?php echo $gender; ?></option>
                  <option value = "Male">Male</option>
                  <option value = "Female">Female</option>
                  <option value = "Other">Other</option>
                </select>
              </div>
              <label class="col-lg-3 col-form-label form-control-label">D.O.B</label>
              <div class="col-lg-3"> <input class="form-control" type="date" name ="dob" value="<?php echo $dob; ?>"> </div>
            </div>
            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Address</label>
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

            <div class="form-group row">
              <label class="col-lg-3 col-form-label form-control-label">Specialization</label>
              <div class="col-lg-9">
                <input class="form-control" type="text" name ="specialization" id = "specialization" value="<?= $specialization ?>"> </div>
                <script type="text/javascript">
                $('#specialization').tagsInput();
                </script>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Registration Council</label>
                <div class="col-lg-9"> <input class="form-control" type="text" name ="registration_council" value="<?= $registration_council ?>"> </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Registration Year</label>
                <div class="col-lg-3"> <input class="form-control" type="text" name ="registration_year" value="<?= $registration_year ?>"> </div>
                <label class="col-lg-3 col-form-label form-control-label">Registration No</label>
                <div class="col-lg-3"> <input class="form-control" type="text" name ="registration_no" value="<?= $registration_no ?>"> </div>
              </div>

              <hr style="width:100%"/>

              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Morning Start Time</label>
                <div class="col-lg-3"> <input class="form-control" type="time" name ="morning_start_time" value="<?php echo $morning_start_time ?>"> </div>
                <label class="col-lg-3 col-form-label form-control-label">Morning End Time</label>
                <div class="col-lg-3"> <input class="form-control" type="time" name ="morning_end_time" value="<?php echo $morning_end_time ?>"> </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Evening Start Time</label>
                <div class="col-lg-3"> <input class="form-control" type="time" name ="evening_start_time" value="<?php echo $evening_start_time ?>"> </div>
                <label class="col-lg-3 col-form-label form-control-label">Evening End Time</label>
                <div class="col-lg-3"> <input class="form-control" type="time" name ="evening_end_time" value="<?php echo $evening_end_time ?>"> </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label"></label>
                <div class="col-lg-9">
                  <input type="submit"  class="btn_1" value="Save Changes">
                </div>
              </div>
            </form>
          </div>

        <div class="tab-pane active" id="addinfo">
          <form class="" action="update_edu.php" method="post">

            <table id="edutable" class="table">
              <thead> <tr>
                <th>Degree</th> <th>Year</th> <th>Institute</th>
               <th>&nbsp;</th>
              </tr> </thead>

              <tbody id = "educontrols">
                <?php
                $rowcount = mysqli_num_rows($resultedu);
                if($rowcount>0){
                  while(($r = mysqli_fetch_array($resultedu))!=null){
                      $degree = $r['degree'];
                      $year = $r['year'];
                      $institute = $r['institute'];
                ?>
                  <tr>
                    <td><input class='input-sm' name='degree[]' value="<?= $degree ?>"/></td>
                    <td><input class='input-sm' name='year[]' value="<?= $year ?>"/></td>
                    <td><input class='input-sm' name='institute[]'value="<?= $institute ?>" /></td>
                    <td><input class='btn btn-danger btn-sm'onclick="delete_me(this)" type="button" Value = 'X'/></td>
                  </tr>
                  <?php
                  }
                }else{
                  ?>
                  <tr>
                    <td><input class='input-sm' name='degree[]'/></td>
                    <td><input class='input-sm' name='year[]'/></td>
                    <td><input class='input-sm' name='institute[]'/></td>
                    <td><input class='btn btn-danger btn-sm'onclick="delete_me(this)" type="button" Value = 'X'/></td>
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
            <input class = 'btn btn-success' type='submit' value="Update"/>

          </form>

          <script type="text/javascript">
            var add_button = $("#add");

            function delete_me(v) {
              v = $(v).parent().parent();

              if(!v.is(":first-child")){
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

        </div>
      </div>
    </div>
    <!--/div-->
  </div>




</body>
<?php include("footer.php");

function getAge($date){
  $dob = new DateTime($date);
  $now = new DateTime();
  return $now->diff($dob)->y;
}
?>
</html>
