<?php include("header.php");
$id = isset($_SESSION['id'])?$_SESSION['id']:null;

if($id!=null)
    {
            $query ="select user_name,user_email,user_phone,dob,photo,height,weight,blood_group,gender,district,pincode from tb_user where user_id = $id";
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
            $district = $cdrow1["district"];
            $pin = $cdrow1['pincode'];
					 //get data from appointment table
            $apptquery = "Select * from tb_appointment where pat_id = $id";
			$resultappt = $conn->query($apptquery);
			$count = mysqli_num_rows($resultappt);
   
    }
            
else 
    {
        echo '<script type="text/javascript">
         alert("Please Login To Continue ")
         window.location = "./login.php";
         </script> ';
    }

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
$file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
     $file_size = $_FILES['image']['size'];
   
    if (($file_size > 65500)){      
        $message = 'File too large. File must be less than 64 kb.'; 
        echo '<script type="text/javascript">alert("'.$message.'");</script>'; 
    }

if($file!=null && $file!=""){
//  unset($imagepic);
  $q = "UPDATE tb_user SET photo= '$file' where user_id = '$id'";
  $conn->query($q);
}
}

$str = "select photo from tb_user where user_id = '$id'";
$result = $conn->query($str);
if($result==null) echo "nonos";
while(($r = mysqli_fetch_array($result))!=null){
$imagepic = "<img src = 'data:image/jpeg;base64,".base64_encode( $r[0])."' width='200' height='200' /><br/>";

}




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
        <div style="border: 5px solid aqua; margin: 20px; padding : 20px; border-radius: 10px;">
            <form method="POST" enctype="multipart/form-data">
            <div class="row my-2">
                 <div class="col-lg-4 order-lg-1 text-center">

            
            <?php echo $imagepic; ?>
            
            <h6 class="mt-2">Upload a different photo</h6>
            <label class="custom-file">
                <input type="file" class="custom-file-input" id="uploadImage" name="image" id="image" accept=".jpg, .jpeg, .png" /> 
                <span class="custom-file-control">Choose file</span>
                <br><br> <br>
            </label>
                     <input type="submit" class = "btn_1" value = "Upload"/>
        </div>
                </form>
                <div class="col-lg-8 order-lg-2">
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
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                               <h4 style="color:red; font-style: oblique;"> Hello : <?php echo $user; ?></h4>
                            </p>
                           
                        </div>
                        
                        <div class="col-md-12">
                            <h5 class="mt-2"><span class="fa fa-clock-o ion-clock float-right"></span>User Details</h5>
                            <table class="table table-sm table-hover table-striped">
                                <tbody> 
                                    
                                    <tr>
                                        <td>
                                            <h5 style="color:grey; font-style: oblique;"> Name : &nbsp;&nbsp;&nbsp;<?php echo $user; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                             <h5 style="color:grey; font-style: oblique;"> Email Id : <?php echo $email; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                           <h5 style="color:grey; font-style: oblique;"> Phone : <?php echo $phone; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 style="color:grey; font-style: oblique;"> D.O.B : <?php echo $dob; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                           <h5 style="color:grey; font-style: oblique;"> Height : <?php echo $height; ?></h5>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <h5 style="color:grey; font-style: oblique;"> Weight : <?php echo $weight; ?></h5>
                                        </td>
                                    </tr>
                                     <tr>
                                        <td>
                                           <h5 style="color:grey; font-style: oblique;"> Gender : <?php echo $gender; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                             <h5 style="color:grey; font-style: oblique;"> Blood Group : <?php echo $blood_group; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                           <h5 style="color:grey; font-style: oblique;"> District : <?php echo $district; ?></h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 style="color:grey; font-style: oblique;"> Pin : <?php echo $pin; ?></h5>
                                        </td>
                                    </tr>
                                   
                                </tbody>
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
                            <div class="col-lg-9">
                                <input class="form-control" type="text" name ="name" value="<?php echo $user; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Email</label>
                            <div class="col-lg-9">
                                <input class="form-control"  name ="email" type="email" readonly value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Phone No</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="number" name ="phone_no" value="<?php echo $phone; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">D.O.B</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="date" name ="dob" value="<?php echo $dob; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Weight</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="number"  name ="weight" value="<?php echo $weight; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Height</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="number" name ="height" value="<?php echo $height; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Gender</label>
                            <div class="col-lg-9">
                                  <select id = "gender" class="form-control" name ="gender">
                                                <option value = "<?php echo $gender; ?>"><?php echo $gender; ?></option>
                                              <option value = "Male">Male</option>
                                              <option value = "Female">Female</option>
                                              <option value = "Other">Other</option>
                                            </select>
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Blood Group</label>
                            <div class="col-lg-9">
                                <select id = "bloodgroup" class="form-control" name ="bloodgroup">
                                                <option value = "<?php echo $blood_group; ?>"><?php echo $blood_group; ?></option>
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
                            <label class="col-lg-3 col-form-label form-control-label">District</label>
                            <div class="col-lg-9">
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
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label">Pin</label>
                            <div class="col-lg-9">
                                <input class="form-control" type="number" name ="pin" value="<?php echo $pin; ?>">
                            </div>
                        </div>
                        
                        
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label form-control-label"></label>
                            <div class="col-lg-9">
                                <input type="submit"  class="btn_1" value="Save Changes">
                            </div>
                        </div>
                    </form>
                </div>
                        </div>
                </div>
            
       
    </div>
        </div>
</div>
       
           
       
       
   </body>
    <?php include("footer.php");?>
</html>