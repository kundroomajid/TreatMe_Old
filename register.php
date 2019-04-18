<?php

session_start();

include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
      // user_email and user_password sent from form
      $user_type =  mysqli_real_escape_string($conn,$_POST['user_type']);
      $user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
      $user_password = mysqli_real_escape_string($conn,$_POST['user_password']);
      $blob = addslashes(file_get_contents('./img/user.png', true));
if ( !empty($user_password) || !empty($user_email) )
{    //create connection
    if (mysqli_connect_error()) {
     die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else 
    {

     $hash = md5( rand(0,1000) );
     $SELECT = "SELECT user_email From tb_user Where user_email = ? Limit 1";
     $user_password = md5($user_password);
     $INSERT = "INSERT Into tb_user (user_password,user_email,hash,user_type) values(?,?,?,?)";
     //Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $user_email);
     $stmt->execute();
     $stmt->bind_result($user_email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;
     if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("ssss",  $user_password,$user_email,$hash,$user_type);
     if( $stmt->execute() == False)
     {
        
         echo("Error description: " . mysqli_error($conn));
          echo '<script type="text/javascript">
         alert("execution failed of sql")
         window.location = "index.php";
         </script> ';
     }
     $_SESSION['email'] = $user_email;
        $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
         $conn->query($q) or die(mysql_error($conn));
      $msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Registered Sucessfully please confirm your email id please check spam folder also.
  </div>';
      
//        echo("Registered Sucessfully please confirm your email id please check spam folder also");
//         echo '<script type="text/javascript">
//         alert("Registered Sucessfully please confirm your email id please check spam folder also")
//         window.location = "index.php";
//         </script> ';

     } 
        else 
     {
         $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="index.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Someone is allready registered using this email
    </div>';
         
//          echo '<script type="text/javascript">
//         alert("Someone already register using this email")
//         window.location = "./login.php";
//         </script> ';

     }
     $stmt->close();
     $conn->close();
    }

    $to      = $user_email; // Send email to our user
$subject = 'Shifa | Signup | Verification'; // Give the email a subject
$message = '

Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

------------------------
email: '.$user_email.'
password: '.$user_password.'
------------------------

Please click this link to activate your account:
https://shifaddnn.000webhostapp.com/shifa/verify.php?email='.$user_email.'&hash='.$hash.'

'; // Our message above including the link

$headers = 'From:noreply@shifaddnn.000webhostapp.com/' . "\r\n"; // Set from headers
//mail($to, $subject, $message, $headers); // Send our email   TO DO
} else {
 echo "All field are required";
 die();
}
}
include("header.php");
?>
<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div id="register">
					<h1>Join TreatMe</h1>
					<div class="row justify-content-center">
						<div class="col-md-5">
							<form action="register.php" method="POST">
								<div class="box_form">
                                      <div id="info" class="clearfix">  <?= "$msg";?> </div>
                                 
                  <div class="form-group">
                <label>Select User Type</label>
                <select id = "user_type" class="form-control" name ="user_type">
                  <option value = "p">User</option>
                  <option value = "d">Doctor</option>
                  <option value = "c">Clinic</option>
                </select>
              </div>
                            

                  </select>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name ="user_email"class="form-control" placeholder="Your Email Address" />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name ="user_password" class="form-control" id="password1" placeholder="Your Password" />
									</div>
									<div class="form-group">
										<label>Confirm password</label>
										<input type="password" class="form-control" id="password2" placeholder="Confirm Password" />
									</div>
									<div id="pass-info" class="clearfix"></div>
									<div class="checkbox-holder text-left">
										<div class="checkbox_2">
											<input type="checkbox" value="accept_2" id="check_2" name="check_2" checked="" />
											<label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
										</div>
									</div>

									<div class="form-group text-center add_top_30">
										<input class="btn_1" type="submit" value="Submit" />

									</div>
								</div>

							</form>

						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /register -->
			</div>
		</div>


                        <?php include("footer.php"); ?>
<script src="./js/pw_strenght.js"></script>
	</main>
