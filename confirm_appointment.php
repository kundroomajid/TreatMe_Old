<?php
include("session.php");
include("config.php");
if (isset($_SESSION['login_user']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'd' || $_SESSION['user_type'] == 'c') {
  if (isset($_REQUEST['confirmed']) && isset($_REQUEST['appt_id'])) {
    $confirmed = $_REQUEST['confirmed'];
    $appt_id = $_REQUEST['appt_id'];
    if ($confirmed)
      $q = "UPDATE appointment SET confirmed=1 WHERE id=$appt_id";
    else
      $q = "DELETE FROM appointment WHERE id=$appt_id";

    if (mysqli_query($conn, $q))
      $msg = "Operation Successful :)";
    else
      $msg = "Operation Unsuccessful;";
  } else {
    $msg = "Operation Unsuccessful :(";
  }
  $_SESSION['msg'] = "<div class='alert alert-danger alert-dismissible'>
  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
  $msg </div>";
  header("Location:welcomed.php");
} else {
  header("Location:login.php");
}
?>