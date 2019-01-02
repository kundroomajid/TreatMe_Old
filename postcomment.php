<?php include("header.php"); ?>
<?php

include("session.php");

include("config.php");
$doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
//$comment = isset($_GET['comment'])?$_GET['comment']:null;
print $doc_id;
//print $comment;
// $doc_id = isset($_GET['doc_id'])?$_GET['doc_id']:null;
$pat_id = isset($_SESSION['id'])?$_SESSION['id']:null;
if(isset($_SESSION['login_user']))
{
    $date =getdate(date("U"));

    $query = "INSERT into comment (doc_id,pat_id,date,comment) VALUES ('$doc_id', '$pat_id', '$date, '$comment')";

    $data = mysqli_query($conn,$query) or die(mysqli_error($conn));
     if($data)
     {

       echo '<script type="text/javascript">
           alert("Comment Posted Sucessfully")
          // window.location = "/shifa/detail-page.php?doc_id='.$doc_id.'";
           </script> ';
     }

// Read more: http://mrbool.com/how-to-create-a-sign-up-form-registration-with-php-and-mysql/28675#ixzz5ZCluXXWp
//     $str =
//     $result = $conn->query($str);
//     if($conn->query($str) != null)
//     {
//     echo '<script type="text/javascript">
//     alert("Comment Posted Sucessfully")
//     window.location = "/shifa/detail-page.php?doc_id='.$doc_id.'";
//     </script> ';
//   }
  else {
    echo '<script type="text/javascript">
    alert("Database Error")

    </script> ';
  }
  }
else
{
  echo '<script type="text/javascript">
  alert("Please Login To Post Comment")
  window.location = "/shifa/login.php";
  </script> ';

}
