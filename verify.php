<?php include("header.php"); ?>

<!-- start PHP code -->
<?php
include("config.php");
//create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
if (mysqli_connect_error()) {
  die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
} else {

  if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = mysqli_escape_string($conn,$_GET['email']); // Set email variable
    $hash = mysqli_escape_string($conn,$_GET['hash']); // Set hash variable


    $search = mysqli_query($conn,"SELECT user_email, hash, active FROM tb_user WHERE user_email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
    $match  = mysqli_num_rows($search);


    if($match > 0)
    {
      $sql = "SELECT * FROM tb_user WHERE user_email = '$email'";
      $result = mysqli_query($conn,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      //  $user_email = $row['user_email'];
      $user_type = $row['user_type'];
      // We have a match, activate the account
      mysqli_query($conn,"UPDATE tb_user SET active='1' WHERE user_email='".$email."' AND hash='".$hash."' AND active='0'") or die(mysqli_error($conn));
      if($user_type == 'd')
      {
        echo '<script type="text/javascript">
        alert("Thanks for registering.click to complete profile ")
        window.location = "./register-doctor2.php?email='.$email.'";
        </script> ';
      }
      else {
        echo '<script type="text/javascript">
        alert("Thanks for registering.click to complete profile ")
        window.location = "./register2.php?email='.$email.'";
        </script> ';
      }

    }else{
      // No match -> invalid url or account has already been activated.
      echo '<script type="text/javascript">
      alert("The url is either invalid or you already have activated your account")
      window.location = "./login.php";
      </script> ';
    }

  }else{
    // Invalid approach
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
  }
}

?>
