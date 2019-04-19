<?php
  session_start();
  include("config.php");
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  }
  include("header.php");
?>

<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div id="login-2">
					<h1>Welcome to TreatMe</h1>
          <?php
            if(isset($_REQUEST['email_id'])){
              $email =  mysqli_real_escape_string($conn,$_REQUEST['email_id']);
              $sql = "SELECT user_id FROM tb_user WHERE user_email = '$email' and active='1'";
               $result = mysqli_query($conn,$sql);
               $count = mysqli_num_rows($result);
               if($count == 1) {
                 send_email($email);
                 echo "<p class='text-center link_bright'>A mail has been set to your email address: <b>$email</b> to recover your account</p>";
               }else{
                 echo "<p class='text-center link_bright'>The email <b>$email</b> doesn't exist in our database</p>";
               }
            }else{
          ?>
					<form action="forgot.php" method="post">
						<div class="box_form clearfix">
							<div class="box_login last">
								<div class="form-group">
									<input type="email" name="email_id" class="form-control" placeholder="Your email address" />
								</div>
								<div class="form-group">
									<input class="btn_1" name ="submit" type="submit" value="Next" />
								</div>
							</div>
						</div>
					</form>
          <?php
        }
           ?>
				</div>
				<!-- /login -->
			</div>
		</div>
    <?php include("footer.php"); ?>
	</main>
	<!-- /main -->

<?php

  //TODO: change to acutal address from localhost
  function send_email($user_email){
    global $conn;
    $to      = $user_email; // Send email to our user
    $subject = 'Password Reset'; // Give the email a subject
    $hash = md5( rand(0,1000) );
    $update = "UPDATE tb_user SET hash='$hash' WHERE user_email='$user_email'";
    $x = $conn->prepare($update);
    $x->execute();


    $message = "You are receiving this email because you had signed up on shifa.com and requested to recover your password.
    Please click the following link or paste it in your browser to reset yoru passowrd.

    localhost/reset.php?token='.$hash.'&email='.$user_email"; // Our message above including the link

    $headers = 'From:noreply@locah.com/' . "\r\n"; // Set from headers

//    echo $message;
    mail($to, $subject, $message, $headers);

  }
 ?>
