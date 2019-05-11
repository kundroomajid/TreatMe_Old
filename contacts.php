<?php include("header.php");
if(isset($_POST['email'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "treatme247@gmail.com";
    $email_subject = "Contact Us Form";
 
    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
 
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['comment'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
    }
 
     
 
    $first_name = $_POST['name']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['phone']; // required
    $comments = $_POST['comment']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Name: ".clean_string($first_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Comments: ".clean_string($comments)."\n";
 
// create email headers
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
$mail->From = "feedback@treatme.co.in";
$mail->FromName = "Feedback From TreatMe";
$to = "treatme247@gmail.com";
//To address and name
$mail->addAddress($to);


//Address to which recipient will reply
$mail->addReplyTo("noreply@treatme.co.in", "Reply");


//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Contact Us";
$mail->Body = $email_message;
$mail->AltBody = "";

if(!$mail->send()) 
{
//    echo "Mailer Error: " . $mail->ErrorInfo;
  
} 
else 
{
//    echo "Message has been sent successfully";
}


	
	
	
	
	
//$headers = 'From: '.$email_from."\r\n".
//'Reply-To: '.$email_from."\r\n" .
//'X-Mailer: PHP/' . phpversion();
//@mail($email_to, $email_subject, $email_message, $headers);  
?>
 <?php
  $msg = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Thanks for Contacting us we will get in touch with you soon.
  </div>';
 

 
}
?>




<!--jquery validator-->
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
 <script src="./js/formvalidator.js"></script>


<!--validator ends-->


<main>
		<div class="container margin_60_35">
			<div class="row">
				<aside class="col-lg-3 col-md-4">
					<div id="contact_info">
						<h3>Contacts info</h3>
						<p>
							University Avenue IUST Awantipora Pulwama J&K ,<br /> <br />
                        <a href="mailto:feedback@treatme.co.in" >feedback@treatme.co.in</a>
</p>
						</p>
						
						<ul>
<!--
							<li><strong>Administration</strong>
								<a href="tel://003823932342">0038 23932342</a><br /><a href="tel://003823932342"><span class="__cf_email__" data-cfemail="5130353c383f1137383f353e32253e237f323e3c">[email&#160;protected]</span></a><br />
								<small>Monday to Friday 9am - 7pm</small>
							</li>
							<li><strong>General questions</strong>
								<a href="tel://003823932342">0038 23932342</a><br /><a href="tel://003823932342"><span class="__cf_email__" data-cfemail="611014041215080e0f122107080f050e02150e134f020e0c">[email&#160;protected]</span></a><br />
								<p><small>Monday to Friday 9am - 7pm</small></p>
							</li>
-->
						</ul>
					</div>
				</aside>
				<!--/aside -->
				<div class=" col-lg-8 col-md-8 ml-auto">
					<div class="box_general">
						<h3>Contact us</h3>
						<p>
							Contact Us for Any help or suggestions
							<div id="info" class="clearfix"> <?= "$msg";?> </div>
						</p>
						<div>
							<div id="message-contact"></div>
							<form method="post" action="" id="contactform" />
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<input type="text" class="form-control styled" id="name_contact" name="name" placeholder="Name" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<input type="email" id="email_contact" name="email" class="form-control styled" placeholder="Email" />
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<input type="text" id="phone_contact" name="phone" class="form-control styled" placeholder="Phone number" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<textarea rows="5" id="message_contact" name="comment" class="form-control styled" style="height:100px;" placeholder="Message"></textarea>
										</div>
									</div>
								</div>
								<input type="submit" value="Submit" class="btn_1 add_top_20" id="submit-contact" />
							</form>
						</div>
						<!-- /col -->
					</div>
				</div>
				<!-- /col -->
			</div>
			<!-- End row -->
		</div>
		<!-- /container -->
	
<?php include("footer.php"); ?>
</main>
	<!-- /main -->
	
