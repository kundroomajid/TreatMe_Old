

<?php include("header.php");
include("config.php");
$email = mysqli_escape_string($conn,$_GET['email']); // Set email variable
//  if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){

 if($_SERVER["REQUEST_METHOD"] == "POST") {
   
   
   
  if(isset($_GET['email']) && !empty($_GET['email']))
  {
    // Verify data
    $hash = mysqli_escape_string($conn,$_POST['hash']); // Set hash variable

      $search = mysqli_query($conn,"SELECT user_email, hash, active FROM tb_user WHERE user_email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
      $match  = mysqli_num_rows($search);


        if($match > 0)
        {
          $sql = "SELECT * FROM tb_user WHERE user_email = '$email'";
          $result = mysqli_query($conn,$sql);
          $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
          //  $user_email = $row['user_email'];
          $user_type = $row['user_type'];
          // We have a match, activate the account
          mysqli_query($conn,"UPDATE tb_user SET active='1' WHERE user_email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
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
          else {
            $msg = '<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Your Email has been verified Sucessfully click below to complete registration
      </div>';
            echo '<script type="text/javascript">
    //        alert("Thanks for registering.click to complete profile ")
            window.location = "./register2.php?email='.$email.'";
            </script> ';
          }

        }else{
          // No match -> invalid url or account has already been activated.
          $msg = '<div class="alert alert-danger alert-dismissible">
         <a href="login.php" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         verification code incorrect or your account is active
        </div>';
          echo '<script type="text/javascript">
    //      alert("The url is either invalid or you already have activated your account")
//          window.location = "./login.php";
          </script> ';
        }

      }
   else{
        // Invalid approach
    //    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
        $msg = '<div class="alert alert-danger alert-dismissible">
         <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         Invalid approach
        </div>';
     echo("Invalid approach");
      }
    }



if($user_type == 'd')
      {
        $link = "./register-doctor2.php?email=$email";
      }
else if($user_type == 'p')
    {
      $link = "./register2.php?email=$email";

    }
else if($user_type == 'c')
{
  $link = "./registerclinic.php?email=$email";
}
else
{

$link = "index.php";
}
$msg2 = $_SESSION['msg'];
?>
<html>
<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div id="login-2">
					<h1>Enter Verification Code</h1>
					<form action="forgot.php" method="post">
						<div class="box_form clearfix">
							<div class="box_login last">
								<div class="form-group">
									<input type="number" name="hash" class="form-control" placeholder="Enter Verification Code" maxlength="6" required="true" />
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


  
