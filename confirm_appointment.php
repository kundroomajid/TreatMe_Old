<pre>
<?php
//include("header.php");
include("session.php");
include("config.php");
if(isset($_SESSION['login_user']) && isset($_SESSION['user_type']) && $_SESSION['user_type']=='d' || $_SESSION['user_type']=='c'){

  $tmp_id = isset($_GET['tmp_id'])?$_GET['tmp_id']:null;
  $confirmed = isset($_GET['confirmed'])? mysqli_real_escape_string($conn,$_GET['confirmed']):null;
  $doc_id = isset($_SESSION['id'])?$_SESSION['id']:null;
  

  if($doc_id!=null && $tmp_id!=null){
    
    $result = $conn->query("select patients FROM vw_doctor WHERE doc_id=$doc_id");
    $row = mysqli_fetch_assoc($result);
      $patients = $row['patients'];
      
    
    
    if($confirmed==0){
      if($result = $conn->query("DELETE FROM tmp_appointment WHERE tmp_id=$tmp_id")){
		  $_SESSION['msg'] ='<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Reject Successfull
  </div>';
        echo '<script type="text/javascript">
		window.location = "welcome.php";
        </script> ';
      }else{
		   $_SESSION['msg'] ='<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Unsuccessfull operation
  </div>';
        echo '<script type="text/javascript">
		window.location = "welcome.php";
        </script> ';
      };
    }
    else{
      $result = $conn->query("SELECT * FROM tmp_appointment WHERE tmp_id=$tmp_id");
      $row = mysqli_fetch_assoc($result);
      $doc_id = $row['doc_id'];
      $pat_id = $row['pat_id'];
      $date = $row['appt_date'];
      $shift = $row['shift'];
      $patient_name = $row['name'];
      
      // get patient details
          $result = $conn->query("select user_email FROM vw_patient WHERE user_id=$pat_id");
    $row = mysqli_fetch_assoc($result);
      $email = $row['user_email'];
      
      

      if(bookAppointment($doc_id,$pat_id,new DateTime($date),$shift,$patient_name) && ($result = $conn->query("DELETE FROM tmp_appointment WHERE tmp_id=$tmp_id")))
	  {
        echo "<script> alert($email) </script>";
        $patients = $patients + 1;
        $q = "update tb_doctor SET patients = '$patients'";
      mysqli_query($conn,$q);
        send_email($email);
		  $_SESSION['msg'] = '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Appointment Confirmed Sucessfully</div>';
        echo "<script> window.location = 'welcome.php'; </script>";
		  }
      else
	  {
		  $_SESSION['msg'] ='<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Operation Unsuccessfull
  </div>';
    //    echo '<script type="text/javascript">  window.location = "welcome.php"; </script> ';
		  }
    }
  }
  else{
    die("Something wrong somewhere");
  }
}
else{
  echo '<script type="text/javascript">
//  alert("Please Login To Book an Appontmnet")
  window.location = "./login.php";
  </script> ';
}

function bookAppointment($doc_id,$pat_id,$date,$shift,$patient_name){
  global $conn;
  if(isSlotAvaliable($doc_id,$date,$shift)){
    //$conn = mysqli_connect("localhost", "root","", "appointment") ;

    $queue_no = slotsFilled($doc_id,$date,$shift)+1;
    $str = "INSERT INTO tb_appointment(doc_id,pat_id,appt_date,name,queue_no,shift) VALUES".
    "($doc_id,$pat_id,'".$date->format('Y-m-d')."','$patient_name',$queue_no,$shift)";
     

    $result = $conn->query($str);
    if(!$result){
      echo $str;
      return false;
    }
    return true;
  }else{
    return false;
  }
}

function isSlotAvaliable($doc_id, $date,$shift){
  global $conn;
  $tSlots = getNoOfSlots($doc_id,$shift);
  $aSlots = slotsFilled($doc_id, $date,$shift);

  //TODO:REMOVE IT IN PRODUCTION
  if($aSlots>$tSlots){
    die("something is really really wrong with slots");
  }
  return ($tSlots==$aSlots)?false:true;
}

function getNoOfSlots($doc_id,$shift){

  //$conn = mysqli_connect("localhost", "root","", "appointment") ;
  global $conn;
  $str = "select * from tb_doctor where doc_id = $doc_id";
  $result = $conn->query($str);
  $row  = mysqli_fetch_assoc($result);
  $start = new DateTime(($shift==0) ? $row['morning_start_time']:$row['evening_start_time']);
  $end = new DateTime(($shift==0) ? $row['morning_end_time']:$row['evening_end_time']);
  $diff = $end->diff($start);
  //$conn->close();

  return (($diff->h * 60)+ $diff->i)/15;
}

function slotsFilled($doc_id,$date,$shift){
  global $conn;

  // $conn = mysqli_connect("localhost", "root","", "appointment") ;
  $str = "SELECT count(*) as max_appt from tb_appointment where doc_id = $doc_id AND appt_date='".$date->format('Y-m-d')."' and shift = $shift";
  $result = $conn->query($str) or die ("result not properltys") ;
  $row  = $result->fetch_array();
  return $row[0];
  //  $conn->close();
}

//  /TODO: change to acutal address from localhost
  function send_email($user_email){
    global $conn;
    
   $to      = $user_email; // Send email to our user
$message = ' Appointmet has been confirmed please visit the dashboard for details';
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
$mail->From = "Appointment@treatme.co.in";
$mail->FromName = "TreatMe.co.in";

//To address and name
$mail->addAddress($to);


//Address to which recipient will reply
$mail->addReplyTo("noreply@treatme.co.in", "Reply");


//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Appointment Confirmed";
$mail->Body = $message;
$mail->AltBody = "";

if(!$mail->send()) 
{
//    echo "Mailer Error: " . $mail->ErrorInfo;
   $_SESSION['msg'] .= '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Email Sent</div>';
  
  
} 
else 
{
//    echo "Message has been sent successfully";
$_SESSION['msg'] .= '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Email Sent</div>';
}

  }
  
  
  
  
include("footer.php");?>
</main>
</html