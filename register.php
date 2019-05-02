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

     $hash = rand(1, 1000000);
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
     if ($rnum==0) 
     {
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
       else
        {
     $_SESSION['email'] = $user_email;
        $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
         $conn->query($q) or die(mysql_error($conn));
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
                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0">Welcome to TreatMe.<br><br>
                                              To activate your account please Copy the below verification Code If you believe this is an error, ignore this message and we"ll never bother you again.</p>

                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0;font-size:14px;padding:0;color:#666;padding-top:1em;padding-bottom:0em;margin-bottom:0;margin-left:0;padding-left:0">
                                            <p>Copy the below verification code to verify your account</p>
                                              <div align="center"><h4><b>'.$hash.'</b></h4></div>
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


  
      $msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Registered Sucessfully please confirm your email id please check spam folder also.
  </div>';
         $_SESSION['msg'] = $msg;
      
//        echo("Registered Sucessfully please confirm your email id please check spam folder also");
         echo '<script type="text/javascript">
//         alert("Registered Sucessfully please confirm your email id please check spam folder also")
         window.location = "./verify.php?email='.$to.'";
         </script> ';

      } 
     }
        else 
     {
         $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
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
            <form action="register.php" method="POST" id="myForm" name="myForm">
              <div class="box_form">
                <div id="info" class="clearfix"> <?= "$msg";?> </div>
                <div class="form-group">
                  <label>Select User Type</label>
                  <select id="user_type" class="form-control" name="user_type">
                    <option value="p">User</option>
                    <option value="d">Doctor</option>
                    <option value="c">Clinic</option>
                  </select>
                </div>
                </select>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="user_email" class="form-control" placeholder="Your Email Address"/>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="user_password" class="form-control" id="password1" placeholder="Your Password" />
                </div>
                <div class="form-group">
                  <label>Confirm password</label>
                  <input type="password" class="form-control" id="password2" name = "password2" placeholder="Confirm Password"/>
                </div>
                <div id="pass-info" class="clearfix"></div>
                <div class="checkbox-holder text-left">
                  <div class="checkbox_2">
                    <input type="checkbox" value="false" id="check_2" name="check_2" required/>
                    <label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
                  </div>
                </div>

                <div class="form-group text-center add_top_30">
                  <input class="btn_1" type="submit" value="Submit"/>

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

<!--jquery validator-->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
 <script src="./js/formvalidator.js"></script>


<!--validator ends-->

  <?php include("footer.php"); ?>
  <script src="./js/pw_strenght.js"></script>
</main>