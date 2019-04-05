<?php include("header.php"); ?>
<?php

include("session.php");

include("config.php");
$doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
$clinic_id = isset($_GET['clinic_id'])?$_GET['clinic_id']:null;

$pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;
if(isset($_SESSION['login_user']))
{
    $date =getdate(date("U"));
  if($doc_id != null || $doc_id != "")
  {
    $query = "INSERT into comment (doc_id,pat_id,date,comment) VALUES ('$doc_id', '$pat_id', '$date, '$comment')";
  }
  else if($clinic_id != null )
  {
     $query = "INSERT into comment (doc_id,pat_id,date,comment) VALUES ('$clinic_id', '$pat_id', '$date, '$comment')";
  }
    $data = mysqli_query($conn,$query) or die(mysqli_error($conn));
     if($data)
     {

       echo '<script type="text/javascript">
//           alert("Comment Posted Sucessfully")
          // window.location = "/shifa/detail-page.php?doc_id='.$doc_id.'";
           </script> ';
     }

  else {
    echo '<script type="text/javascript">
    alert("Database Error")

    </script> ';
  }
  }
else
{
  echo '<script type="text/javascript">
//  alert("Please Login To Post Comment")
  window.location = "./login.php";
  </script> ';

}
