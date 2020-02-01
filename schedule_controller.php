<?php
// print_r($_REQUEST);

include_once('config.php');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
switch ($action) {
   case 'save_schedule':
      echo save_schedule();
      break;
   case 'get_schedule':
      // header("Content-Type: text/json; charset=UTF-8");
      echo get_schedule($_REQUEST['doc_id']);
      break;
   case 'book_appointment':
      echo (book_appointment($_REQUEST)) ? 'true' : 'false';
      break;
   case 'get_booking_details':
      $doc_id = isset($_REQUEST['doc_id'])?$_REQUEST['doc_id']:null;
      $date = isset($_REQUEST['date'])?$_REQUEST['date']:null;
      echo get_booking_details($doc_id, $date);
      break;
   default:

      break;
}

function get_booking_details($doc_id, $date)
{
   global $conn;
   if (!$doc_id && !$date)
      return 'nothing';
   $q = "SELECT * FROM vw_booking_details where doc_id=$doc_id AND appt_date='$date'";
   // echo "$q ||";
   $r = mysqli_query($conn, $q);
   if ($r) {
      $d = mysqli_fetch_all($r, MYSQLI_ASSOC);
      // return json_encode($d,JSON_PRETTY_PRINT);
      return json_encode($d, JSON_PRETTY_PRINT);
   } else {
      return mysqli_error($conn);
   }
}

function book_appointment($data)
{
   global $conn;
   $slot_shift = strstr($data['slot'], "-", true) == 'm' ? 0 : 1;
   $slot_no = substr($data['slot'], 2, strlen($data['slot']) - 2);
   $q = "INSERT INTO appointment (doc_id,pat_id,appt_date,shift,slot_no,name,confirmed) VALUES 
    ($data[doc_id],$data[pat_id],'$data[date]',$slot_shift,$slot_no,'$data[name]',0)";
   if (mysqli_query($conn, $q))
      return true;
   else {
      echo mysqli_error($conn);
      return false;
   }
}

function get_schedule($doc_id)
{
   global $conn;
   if (!$doc_id)
      return '';
   $q = "SELECT * FROM vw_schedule where doc_id=$doc_id";
   $r = mysqli_query($conn, $q);
   if ($r) {
      $d = mysqli_fetch_all($r, MYSQLI_ASSOC);
      // return json_encode($d,JSON_PRETTY_PRINT);
      return json_encode($d, JSON_PRETTY_PRINT);
   } else {
      return mysqli_error($conn);
   }
}

function save_schedule()
{
   global $conn;
   $str_mstart = ($_REQUEST['mstart']);
   $str_mend = ($_REQUEST['mend']);

   $str_estart = ($_REQUEST['estart']);
   $str_eend = ($_REQUEST['eend']);


   $mstart = strtotime($_REQUEST['mstart']);
   $mend = strtotime($_REQUEST['mend']);

   $estart = strtotime($_REQUEST['estart']);
   $eend = strtotime($_REQUEST['eend']);
   $doc_id = $_REQUEST['doc_id'];
   $week = $_REQUEST['week'];
   $num_patients = 3;


   $mtime = ($mend - $mstart) / 60;
   $etime = ($eend - $estart) / 60;

   if ($mtime < 30 || $etime < 30)
      return "Error";


   $q = "INSERT INTO doc_schedule (doc_id,week,morning_start,morning_end,evening_start,evening_end,num_patients) VALUES 
            ($doc_id,$week,'$str_mstart','$str_mend','$str_estart','$str_eend',$num_patients)";

   if (mysqli_query($conn, $q))
      return "success";
   else
      return mysqli_error($conn);
}
