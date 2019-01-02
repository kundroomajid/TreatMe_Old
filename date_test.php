<?php
include("config.php");

$doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
$d ='2018-01-03';
$date = new DateTime($d);
echo $date->format('Y-m-d');
$query1=("SELECT * from tb_appointment where date(appt_date) ='".$date."'");
$result1=mysqli_query($conn,$query1) or die ("Query to get data from first table failed: ".mysqli_error());

if($result1 == null)
{
  echo ("error in query");
}
else {
  // code...

$cdrow1=mysqli_fetch_array($result1);

$appt_id = $cdrow1["apptt_id"];
$date1 = $cdrow1["appt_date"];

echo $appt_id;
echo $date1;
}
?>
