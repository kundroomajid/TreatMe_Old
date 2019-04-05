<pre>
<?php
//include("header.php");
include("session.php");
include("config.php");
if(isset($_SESSION['login_user']) && isset($_SESSION['user_type']) && $_SESSION['user_type']=='d' || $_SESSION['user_type']=='c'){

  $tmp_id = isset($_GET['tmp_id'])?$_GET['tmp_id']:null;
  $confirmed = isset($_GET['confirmed'])?$_GET['confirmed']:null;
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
//        alert("Rejected Successfully"); 
		window.location = "welcome.php";
        </script> ';
      }else{
		   $_SESSION['msg'] ='<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Unsuccessfull operation
  </div>';
        echo '<script type="text/javascript">
//        alert("Unsuccessfull operation");
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

      if(bookAppointment($doc_id,$pat_id,new DateTime($date),$shift) && ($result = $conn->query("DELETE FROM tmp_appointment WHERE tmp_id=$tmp_id")))
	  {
        $patients = $patients + 1;
        $q = "update tb_doctor SET patients = '$patients'";
      mysqli_query($conn,$q);
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
        echo '<script type="text/javascript">  window.location = "welcome.php"; </script> ';
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
  window.location = "/shifa/login.php?doc_id='.$doc_id.'";
  </script> ';
}

function bookAppointment($doc_id,$pat_id,$date,$shift){
  global $conn;
  if(isSlotAvaliable($doc_id,$date,$shift)){
    //$conn = mysqli_connect("localhost", "root","", "appointment") ;

    $queue_no = slotsFilled($doc_id,$date,$shift)+1;
    $str = "INSERT INTO tb_appointment(doc_id,pat_id,appt_date,queue_no,shift) VALUES".
    "($doc_id,$pat_id,'".$date->format('Y-m-d')."',$queue_no,$shift)";
    // echo "$str\n";

    $result = $conn->query($str);
    if(!$result){
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

?>

<!--main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="login-2">
        <h1>Thank You For Booking Appointment <?= "$pat_name" ?> </h1>
        <div class="box_form clearfix">
          <div class="wrapper_indent">
            <?= "<h2>Appointment id        :   $appt_id</h2>";?>
            <?= "<h2>Dr Name               :   $doc_name</h2>";?>
            <?= "<h2>Date                  :   $appt_date</h2>";?>
            <?= "<h2>Shift                 :   $shift_name</h2>";?>
            <?= "<h2>Queue No              :   $queue_no</h2>";?>

          </div>
          <div class="box_login last">
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php include("footer.php"); ?>
</main>
</html-->