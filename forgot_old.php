<?php
  session_start();
  include("config.php");
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
                 echo'<form action="forgot.php" method="post">
						<div class="box_form clearfix">
							<div class="box_login last">
								<div class="form-group">
									<input type="number_format" name="hash" class="form-control" placeholder="Verification code" />
								</div>
								<div class="form-group">
									<input class="btn_1" name ="submit" type="submit" value="Verify" />
								</div>
							</div>
						</div>
					</form>';
               }else{
                 echo "<p class='text-center link_bright'>The email <b>$email</b> doesn't exist in our database</p>";
               }
            }else
            {
              
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
						</div>
          <?php
        }
                  
                  
                  
          if(isset($_REQUEST['hash']))
          {
            $code = $_REQUEST['hash'];
           $sql = "SELECT user_id FROM tb_user WHERE hash = '$code' and active='1'";
               $result = mysqli_query($conn,$sql);
               $count = mysqli_num_rows($result);
               if($count == 1) 
               {
                $hash = md5(rand(0,1000));
                $update = "UPDATE tb_user SET hash='$hash' WHERE user_email='$email'";
                $x = $conn->prepare($update);
                  $x->execute();
                 echo '<script type="text/javascript">
                  alert("password reset")
//                  window.location = "./reset.php?token='.$hash.'&email='.$email.'";
                    </script> ';
                
               }
           else
           {
             echo "<p class='text-center link_bright'>failed</p>";
           }
           
            
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
    $hash = rand(0,100000);
    $update = "UPDATE tb_user SET hash='$hash' WHERE user_email='$user_email'";
    $x = $conn->prepare($update);
    $x->execute();


   $to      = $user_email; // Send email to our user
$subject = 'Shifa | Signup | Verification'; // Give the email a subject
$message = '<div style="margin:0;padding:0;width:100%!important">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#DDDDDD" style="width:100%;background:#dddddd">
    <tbody>
      <tr>
        <td>
          <table border="0" cellspacing="0" cellpadding="0" align="center" width="550" style="width:100%;padding:10px">
            <tbody>
              <tr>
                <td>
                  <div style="direction:ltr;max-width:600px;margin:0 auto">
                    <table border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="width:100%;background-color:#fff;text-align:left;margin:0 auto;max-width:1024px;min-width:320px">
                      <tbody>
                        <tr>
                          <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" height="8" background="https://ci4.googleusercontent.com/proxy/URvE_Cd0IgwinMXzb6MwJQyP1lEuYJMlw7iyrNYSJSH9HhA4F3B0RPWC7SxswYqlxE-Gjc_npi1i=s0-d-e1-ft#https://s0.wp.com/i/emails/stripes.gif" style="width:100%;background-image:url("https://ci4.googleusercontent.com/proxy/URvE_Cd0IgwinMXzb6MwJQyP1lEuYJMlw7iyrNYSJSH9HhA4F3B0RPWC7SxswYqlxE-Gjc_npi1i=s0-d-e1-ft#https://s0.wp.com/i/emails/stripes.gif");background-repeat:repeat-x;background-color:#43a4d0;height:8px">
                              <tbody>
                                <tr>
                                  <td></td>
                                </tr>
                              </tbody>
                            </table>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;background-color:#efefef;padding:0;border-bottom:1px solid #ddd">
                              <tbody>
                                <tr>
                                  <td>
                                    <h2 style="padding:0;margin:5px 20px;font-size:16px;line-height:1.4em;font-weight:normal;color:#464646;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">Please confirm your Email Address for <strong>TreatMe.co.in</strong></a></h2>
                                  </td>

                                </tr>
                              </tbody>
                            </table>
                            <table style="width:100%" width="100%" border="0" cellspacing="0" cellpadding="20" bgcolor="#ffffff">
                              <tbody>
                                <tr>
                                  <td>
                                    <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody>
                                        <tr>
                                          <td valign="top">
                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0">Welcome .<br><br>
                                              To Reset password copy below verification code.</p>

                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0;font-size:14px;padding:0;color:#666;padding-top:1em;padding-bottom:0em;margin-bottom:0;margin-left:0;padding-left:0">
                                            <p>zcopy the below verification code to reset password</p>
                                              <div align="center"><h4>'.$hash.'</h4></div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  </div>';
  require './phpmailer/PHPMailerAutoload.php';

//PHPMailer Object
$mail = new PHPMailer;


//Enable SMTP debugging. 
$mail->SMTPDebug = 0;                               
//Set PHPMailer to use SMTP.
$mail->isSMTP();            
//Set SMTP host name                          
$mail->Host = "smtp.gmail.com";
//Set this to true if SMTP host requires authentication to send email
$mail->SMTPAuth = true;                          
//Provide username and password     
$mail->Username = "treatme247@gmail.com";                 
$mail->Password = "Startup@2019"; 
//If SMTP requires TLS encryption then set it
$mail->SMTPSecure = "tls";                           
//Set TCP port to connect to 
$mail->Port = 587;    
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
                               


//From email address and name
$mail->From = "acountactivation@treatme.co.in";
$mail->FromName = "TreatMe.co.in";

//To address and name
$mail->addAddress($to);


//Address to which recipient will reply
$mail->addReplyTo("noreply@yourdomain.com", "Reply");


//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Account Activation";
$mail->Body = $message;
$mail->AltBody = "";

if(!$mail->send()) 
{
//    echo "Mailer Error: " . $mail->ErrorInfo;
  
} 
else 
{
//    echo "Message has been sent successfully";
}

  }
 ?>
