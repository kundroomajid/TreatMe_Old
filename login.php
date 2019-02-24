<?php
session_start();
include("config.php");

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  // email_id and password sent from form

  $myemail_id = mysqli_real_escape_string($conn,$_POST['email_id']);
  $mypassword = mysqli_real_escape_string($conn,$_POST['password']);

  //echo($myemail_id);
  //echo($mypassword);

  $sql = "SELECT user_id,user_type FROM tb_user WHERE user_email = '$myemail_id' and user_password = '$mypassword' and active='1'";

  $result = mysqli_query($conn,$sql);

  //echo($result);


  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $id = $row['user_id'];
  $user_type = $row['user_type'];
  $count = mysqli_num_rows($result);

  // If result matched $myemail_id and $mypassword, table row must be 1 row

  if($count == 1) {
    $_SESSION['login_user'] = $myemail_id;
    $_SESSION['id'] = $id;
    $_SESSION['user_type'] = $user_type;
    echo "<script language='javascript'> alert('$user_type') </script>";
    $user_type = $_SESSION['user_type'];
    if($user_type=='d')
    {
      header("location:   welcomed.php");
    }
    else
    {
      header("location:   welcomep.php");
    }
//    header("location:   welcome.php");
  }
  else
  {
    // $error = "Your Login Name or Password is invalid";

    echo '<script language="javascript">';
    echo 'alert("Your Login Name or Password is invalid")';
    echo '</script>';
    //echo("Your Login Name or Password is invalid");
  }
}
include("header.php");

?>
<main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="login-2">
        <h1>Welcome to Healthcare</h1>
        <form action="login.php" method="post">
          <div class="box_form clearfix">
            <!--	<div class="box_login">
            <a href="#0" class="social_bt facebook">Login with Facebook</a>
            <a href="#0" class="social_bt google">Login with Google</a>
            <a href="#0" class="social_bt linkedin">Login with Linkedin</a>
          </div>-->
          <div class="box_login last">
            <div class="form-group">
              <input type="email" name="email_id" class="form-control" placeholder="Your email address" />
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control" placeholder="Your password" />
              <a href="forgot.php" class="forgot"><small>Forgot password?</small></a>
            </div>
            <div class="form-group">
              <input class="btn_1" name ="submit" type="submit" value="Login" />
            </div>
          </div>
        </div>

      </form>
      <p class="text-center link_bright">Do not have an account yet? <a href="./register.php"><strong>Register now!</strong></a></p>
    </div>
    <!-- /login -->
  </div>
</div>
<?php include("footer.php"); ?>
</main>
<!-- /main -->
