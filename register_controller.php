<?php
session_start();

include("config.php");
require './phpmailer/PHPMailerAutoload.php';
include('textlocal.class.php');


function check_email($con, $email_id)
{
    $sql = 'Select user_email from tb_user where user_email =' . $email_id;
    $result = mysqli_query($con, $sql);
    if ($result->num_rows >= 1) {
        return false;
    } else {
        return true;
    }

}

function check_mobile_no($con, $mobile_no)
{
    $sql = 'Select user_phone from tb_user where user_phone =' . $mobile_no;
    $result = mysqli_query($con, $sql);
    if ($result->num_rows >= 1) {
        return false;
    } else {
        return true;
    }

}

function sendmail($email,$hash)
{
    $to = $email; // Send email to our user
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
                                              <div align="center"><h4><b>' . $hash . '</b></h4></div>
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

    if (!$mail->send()) {
       echo ($mail->ErrorInfo);
       die();
        return false;

    } else {
        return true;
    }


}

function sendsms($user_number,$hash)
{
//    /sending sms using api textlocal
    $apiKey = urlencode('ambBaC64a9k-tfb5yiqYkMwB1FG8hGfUdzIOrdirfq');
    $Textlocal = new Textlocal('treatme247@gmail.com', 'paytm36', $apiKey);

    $numbers = array($user_number);
    $sender = 'TXTLCL';
    $message = "Your One Time Password is " . $hash;
    try {
        $response = $Textlocal->sendSms($numbers, $message, $sender);
        $msg = '<div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Registered Sucessfully please confirm your Mobile Number and  check your Inbox.
            </div>';
        $_SESSION['msg'] = $msg;
        $_SESSION['verify'] = 0;
        return true;
    } catch (Exception $e) {
        return false;
    }

}

function gCaptcha()
{
    $seretkey="6Lch9KsUAAAAAB6wnc2slBlTb4bhUql96w945dNa";
    $responserec=$_POST["g-recaptcha-response"];
    $userip = $_SERVER["REMOTE_ADDR"];
    $urlrec="https://www.google.com/recaptcha/api/siteverify?secret=$seretkey&response=$responserec&remoteip=$userip";
    $responseG=file_get_contents($urlrec);
    $responseG=json_decode($responseG);
    return $responseG;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if(gCaptcha()->success){
    // user_email and user_password sent from form
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $_SESSION['email'] = $user_email;
    $user_phone = mysqli_real_escape_string($conn, $_POST['user_mobile']);
    $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
    $blob = addslashes(file_get_contents('./img/user.png', true));
    $blob = "'" . $blob . "'";
//    check if email exists or not in our database
    $email_id = "'" . $user_email . "'";
    if (!check_email($conn, $email_id)) {
        $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Someone is allready registered using this email
    </div>';
        $_SESSION['msg'] = $msg;
        header('Location: ./register.php');
        exit();
    }

    //    check if mobile number exists or not in our database
    if (!check_mobile_no($conn, $user_phone)) {
        $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Someone is allready registered using this mobile number
    </div>';
        $_SESSION['msg'] = $msg;
        header('Location: ./register.php');
        exit();
    }
    
    if (!empty($user_password) || !empty($user_email)) {    //create connection
        if (mysqli_connect_error()) {
            die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
        } else {
            $hash = rand(1, 1000000);
            $user_password = md5($user_password);
            $user_password = "'" . $user_password . "'";
            $user_email = "'" . $user_email . "'";
            $user_type = "'" . $user_type . "'";
            $INSERT = "INSERT Into tb_user (user_password,hash,user_phone,user_email,user_type,photo) values($user_password,$hash,$user_phone,$user_email,$user_type,$blob)";
            if (!mysqli_query($conn, $INSERT)) {
                echo 'insert error' . $conn->error;
                $msg = '<div class="alert alert-danger alert-dismissible">
                <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Sorry Something went Wrong Please try Again
                </div>';
                $_SESSION['msg'] = $msg;
                header('Location: ./register.php');
            }
            else {
                if(sendsms($user_phone,$hash) || sendmail($_SESSION['email'],$hash)) {
//                    Registered Sucessfully please confirm your mobile number
                    echo "Message has been sent successfully";
                    $msg = '<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                               <strong>Success!</strong> Registered Sucessfully please confirm your Mobile No or email by entering Otp.
                            </div>';
                    $_SESSION['msg'] = $msg;
                    $_SESSION['verify'] = 0;
                    $to = $_SESSION['email'];
                    echo '<script type="text/javascript">
                    window.location = "./verify.php?email=' . $to . '";
                    </script> ';
                }
                else
                {
                    $msg = '<div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                               <strong>Error!</strong> Sorry Some Error Occured Please Try again.
                            </div>';
                    $_SESSION['msg'] = $msg;
                    $_SESSION['verify'] = 0;
                    $to = $_SESSION['email'];
                    echo '<script type="text/javascript">
                    window.location = "./register.php";
                    </script> ';

                }

            }
        }

    }
    else
        {
        echo "All field are required";
        die();
    }
    }
    else{
        $msg = '<div class="alert alert-danger alert-dismissible">
        <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Sorry  please confirm your recaptcha!
        </div>';
        $boolean="true";
    }
}
