<?php include("header.php"); ?>
<?php

include("session.php");

include("config.php");
 if(isset($_SESSION['login_user']))
 {
$doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
$date1 = isset($_GET['date'])?$_GET['date']:null;
$date = (new DateTime($date1))->format('Y-m-d');
$shift = isset($_GET['shift'])?$_GET['shift']:null;
$pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;
if($doc_id!=null && $pat_id!=null && $shift!=null && $date!=null){
    if(bookAppointment($doc_id,$pat_id,new DateTime($date),$shift)){
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
      $queue_no = $cdrowofdetails["queue_no"];
      $appt_date = (new DateTime($cdrowofdetails['appt_date']))->format('d-m-Y');

      if($shift == '0')
      {
        $shift_name = "Morning";
      }
      else
      {
        $shift_name = "Evening";
      }

         echo "<script>alert('Appointment Booked Sucessfully');</script>";
         }
    else{

      echo '<script type="text/javascript">
   alert("Sorry Slots for this Date are filled Please select another date")
   window.location = "/shifa/detail-page.php?doc_id='.$doc_id.'";
   </script> ';

      }
    }
else
{
    echo "Something wrong somewhere";
}

 }
else
{
  echo '<script type="text/javascript">
   alert("Please Login To Book an Appontmnet")
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
    return true;
  }else{
    echo "slot not avaliable";
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
  $start = new DateTime($shift ? $row['morning_start_time']:$row['evening_start_time']);
  $end = new DateTime($shift ? $row['morning_end_time']:$row['evening_end_time']);
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
//  $conn->close();
  return $row[0];
  $conn->close();
}

?>




<!-- <?php

//query to get doctor name
    if(bookAppointment($doc_id,$pat_id,new DateTime($date),$shift)){
      $query = ("SELECT user_name from tb_user where user_id = $doc_id");
      $result1 = $conn->query($query) or die ("result not properltys") ;
      $row1  = $result1->fetch_array();
      $doc_name=$row1["user_name"];
      $pat_name = $_SESSION['login_user'];

      //query to get appointment details
      $query1=("SELECT * from tb_appointment where doc_id = $doc_id  AND shift = $shift AND pat_id =$pat_id  AND date(appt_date) ='".$date."'");
      $result1=mysqli_query($conn,$query1) or die ("Query to get data from first table failed: ".mysqli_error());
      $cdrow1=mysqli_fetch_array($result1);
      $appt_id = $cdrow1["apptt_id"];
      $queue_no = $cdrow1["queue_no"];
      $appt_date = (new DateTime($cdrow1['appt_date']))->format('d-m-Y');

      if($shift == '0')
      {
        $shift_name = "Morning";
      }
      else {
        $shift_name = "Evening";
      }
}
   //  else{
   //    echo '<script type="text/javascript">
   // alert("Sorry Slots for this Date are filled Please select another date")
   // window.location = "/shifa/detail-page.php?doc_id='.$doc_id.'";
   // </script> ';
   //
   //  }

?> -->

<html>
<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div id="login-2">
          	<?= "<h1>Hello $pat_name</h1>";?>
					<h1>Thank You For Booking Appointment</h1>

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
  </html>
