<?php include("header.php"); 
$bookerror = " ";
   unset($_SESSION['var']);
//	unset($bookerror);
include("session.php");
include("config.php");


if(isset($_SESSION['login_user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] !='d' ){
   $username = ($_SESSION['login_user']);
  $doc_id = isset($_GET['doc_id'])? mysqli_real_escape_string($conn,$_GET['doc_id']):null;
  $date1 = isset($_GET['date'])?$_GET['date']:null;
  $date = (new DateTime($date1))->format('Y-m-d');
  $shift = isset($_GET['shift'])? mysqli_real_escape_string($conn,$_GET['shift']):null;
  $pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;
  $patient_name = isset($_GET['pat_name'])? mysqli_real_escape_string($conn,$_GET['pat_name']):null;


  if($doc_id!=null && $pat_id!=null && $shift!=null && $date!=null){
    if(bookAppointment($doc_id,$pat_id,new DateTime($date),$shift,$patient_name)){
      $query = ("SELECT user_name from tb_user where user_id = $doc_id");
      $result1 = $conn->query($query) or die ("result not properltys") ;
      $row1  = $result1->fetch_array();
      $doc_name=$row1["user_name"];
      $pat_name = $_SESSION['login_user'];

      //query to get appointment details
      $querytogetdetails=("SELECT * from tb_appointment where doc_id = $doc_id  AND shift = $shift AND pat_id =$pat_id  AND date(appt_date) ='".$date."'");
      $resultofgetdetails=mysqli_query($conn,$querytogetdetails) or die ("Query to get data from first table failed: ".mysqli_error());
      $cdrowofdetails=mysqli_fetch_array($resultofgetdetails);
      $appt_id = $cdrowofdetails["apptt_id"];
      //$queue_no = $cdrowofdetails["queue_no"];
      $appt_date = (new DateTime($cdrowofdetails['appt_date']))->format('d-m-Y');
      $shift_name = ($shift == '0')?"Morning":"Evening";

//      echo "<script>alert('Appointment Booked Sucessfully');</script>";
    }
    else{
      $bookerror = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Sorry Slots for this Date are filled Please select another date
  </div>';
      $_SESSION['msg']= ' Sorry Slots for this Date are filled Please select another date';
      $_SESSION['var'] = $bookerror;
      echo '<script type="text/javascript">
//  alert("Ssorry Slots for this Date are filled or you have already booked for the said date. Please select another date")
      window.location = "detail-page.php?doc_id='.$doc_id.'";
      </script> ';
    }
  }
  else{
    echo "Something wrong somewhere";
  }
}
else{
  
  $bookerror = '<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Please Login To Book appointment
  </div>';
  
  echo '<script type="text/javascript">
//  alert("Please Login To Book an Appontmnet")
//  window.location = "./login.php";
  </script> ';
}

function bookAppointment($doc_id,$pat_id,$date,$shift,$patient_name){
  global $conn;
  if(isSlotAvaliable($doc_id,$date,$shift)){
    //$conn = mysqli_connect("localhost", "root","", "appointment") ;

    //$queue_no = slotsFilled($doc_id,$date,$shift)+1;
    //echo "que no is $queue_no and slot filled ";

    $str = "INSERT INTO tmp_appointment(doc_id,pat_id,name,appt_date,shift) VALUES
    ($doc_id,$pat_id,'$patient_name','".$date->format('Y-m-d')."',$shift)";
    // echo "$str\n";
    $result = $conn->query($str) or die ($str.'\n'.mysqli_error($conn));
    if(!$result)
      return false;
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
  $total_slots = 0;
  // $conn = mysqli_connect("localhost", "root","", "appointment") ;
  $str = "SELECT count(*) as max_appt from tb_appointment where doc_id = $doc_id AND appt_date='".$date->format('Y-m-d')."' and shift = $shift";
  $result = $conn->query($str) or die ("result not properltys") ;
  $row  = $result->fetch_array();
  $total_slots = $row[0];

  $str = "SELECT count(*) as max_appt from tmp_appointment where doc_id = $doc_id AND appt_date='".$date->format('Y-m-d')."' and shift = $shift";
  $result = $conn->query($str) or die ("result not properltys") ;
  $row  = $result->fetch_array();
  $total_slots += $row[0];

  return $total_slots;
  //  $conn->close();
}

?>

<main>
   
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="login-2">
         
        <h4 style="color:white" align = "center" >Thank You   <?= "<small><i>$patient_name</i></small>";?>   For Booking Appointment <br /> </h4>
        <p><h4 style="color:white" align = "center"><i>A Mail will be sent upon the confirmation of your appointment</i></p></h4>
      
         <table class="table table-bordered">
    <tbody>
      <tr>
        <td><h5> <b style='color:white'> Dr Name </b> </h5></td>
        <td><?= "<h5 style='color:white'> <i>$doc_name</i></h5>";?></td>
      </tr>
      <tr>
        <td><h5 style="color:white"> <b> Date </b> </h5></td>
        <td><?= "<h5 style='color:white'> <i>$appt_date</i></h5>";?></td>
      </tr>
       <tr>
        <td><h5 style="color:white"> <b> Shift </b> </h5></td>
        <td><?= "<h5 style= 'color:white'> <i>$shift_name</i></h5>";?></td>
      </tr>
    </tbody>
  </table>
         
      </div>

    </div>
  </div>
  <?php include("footer.php"); 




?>
</main>
</html>
