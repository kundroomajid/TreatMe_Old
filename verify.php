<?php 

include("header.php"); 
include ("config.php");
$email = mysqli_escape_string($conn,$_GET['email']); // Set email variable

?>
<html>
<main>
<?php	

 if(isset($_GET['email']) && !empty($_GET['email']))
  {
	 
	 if($_SERVER["REQUEST_METHOD"] == "POST") 
	 {
			// Verify data
			$hash = mysqli_escape_string($conn,$_POST['hash']); // Set hash variable
//		 echo($hash);
//		 echo($email);
		 
		    // search database for email and verification code
		 	$search = mysqli_query($conn,"SELECT user_email, hash, active FROM tb_user WHERE user_email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
      		$match  = mysqli_num_rows($search);
		 	 if($match > 0) // if its found
        		{
				  $sql = "SELECT * FROM tb_user WHERE user_email = '$email'";
				  $result = mysqli_query($conn,$sql);
				  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
				  $user_type = $row['user_type'];
				  // We have a match, activate the account
				  mysqli_query($conn,"UPDATE tb_user SET active='1' WHERE user_email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
				 // check user type to send user to proper page
				 
				 if($user_type == 'd')
					  {
						$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> Your Email has been verified Sucessfully click below to complete registration
				  </div>';
						echo '<script type="text/javascript">
				//        alert("Thanks for registering.click to complete profile ")
						window.location = "./register-doctor2.php?email='.$email.'";
						</script> ';
					  }
					  else if ($user_type == 'p')
					  {
						$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> Your Email has been verified Sucessfully click below to complete registration
				  </div>';
						echo '<script type="text/javascript">
				//        alert("Thanks for registering.click to complete profile ")
						window.location = "./register2.php?email='.$email.'";
						</script> ';
					  }
				 	else 
					  {
						$msg = '<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> Your Email has been verified Sucessfully click below to complete registration
				  </div>';
						echo '<script type="text/javascript">
				//        alert("Thanks for registering.click to complete profile ")
						window.location = "./registerclinic.php?email='.$email.'";
						</script> ';
					  }
			 }
		 		else 
//					if not found
		 		{
					  // No match -> invalid url or account has already been activated.
					  $msg = '<div class="alert alert-danger alert-dismissible">
					 <a href="login.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					 verification code incorrect or your account is active or email is not registered
					</div>';
					  echo '<script type="text/javascript">
//				      alert("The url is either invalid or you already have activated your account")
			//          window.location = "./login.php";
					  </script> ';
					}

					
			 } //if post
 }// if isset get email
	
	
else  // else isset get email
{
	$msg = '<div class="alert alert-danger alert-dismissible">
         <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         Sorry Error Missing Parameter
        </div>';
	echo('<h3 align="center">Sorry Error Missing Parameter</h3>');
	
}






?>
<div class="bg_color_2">
					<div class="container margin_60_35">
						<div id="login-2">
							<h1>Enter Verification Code</h1>
							<form action="" method="post">
								<div class="box_form clearfix">
									<div id="info" class="clearfix">  <?= "$msg";?> </div>
									<div class="box_login last" >
										<div class="form-group">
											<input type="number_format" name="hash" class="form-control" placeholder="Enter Verification Code" maxlength="6" required="true" />
										</div>
										<div class="form-group" align="center">
											<input class="btn_1" name ="submit" type="submit" value="Verify" />
										</div>
									</div>
								</div>
							</form>
						</div>
						<!-- /login -->
					</div>
				</div>	
	
	
<?php include("footer.php"); ?>
	</main>
</html>



  
