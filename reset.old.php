<?php
session_start();
include("config.php");
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
include("header.php");
?>

<main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="login-2">
        <h1>Welcome to Healthcare</h1>
        <?php
        if(isset($_REQUEST['token']) and isset($_REQUEST['email']) and isset($_REQUEST['user_password'])){
          $email = $_REQUEST['email'];
          $hash = $_REQUEST['token'];
          $password = $_REQUEST['user_password'];
          $sql = "UPDATE tb_user SET user_password='$password' WHERE user_email = '$email' and hash='$hash'";
          $result = mysqli_query($conn,$sql);

        }else if(isset($_REQUEST['token']) and isset($_REQUEST['email'])){
          $email = $_REQUEST['email'];
          $hash = $_REQUEST['token'];
          $sql = "SELECT user_id FROM tb_user WHERE user_email = '$email' and hash='$hash'";
          $result = mysqli_query($conn,$sql);
          $count = mysqli_num_rows($result);
          if($count == 1) {
            ?>
            <form action="reset.php" method="post">
              <div class="box_form clearfix">
                <div class="box_login last">
                  <div class="form-group">
                    <input type="hidden" name="email" value="<?= $email ?>" />
                    <input type="hidden" name="token" value="<?= $hash ?>" />
                    <label>Password</label>
                    <input type="password" name ="user_password" class="form-control" id="password1" placeholder="Your Password" />
                  </div>
                  <div class="form-group">
                    <label>Confirm password</label>
                    <input type="password" class="form-control" id="password2" placeholder="Confirm Password" />
                  </div>
                  <div class="form-group">
                    <input class="btn_1" name ="submit" type="submit" value="Change" />
                  </div>
                </div>
              </div>
            </form>
            <?php

          }else{
            echo "<p> Invalid token or email</p>";
          }

        }else{
          echo "<p>You do not belong here</p>";
        }
        ?>
      </div>
      <!-- /login -->
    </div>
  </div>
  <?php include("footer.php"); ?>
</main>
<!-- /main -->

<?php
//TODO: change to acutal address from localhost
function send_email($user_email){
  $to      = $user_email; // Send email to our user
  $subject = 'Password Reset'; // Give the email a subject
  $hash = md5( rand(0,1000) );
  echo "hash : $hash";
  $update = "UPDATE tb_user SET hash='$hash'";
  mysqli_stmt_execute(mysqli_prepare($conn,$update));

  $message = '

  You are receiving this email because you had signed up on shifa.com and requested to recover your password.
  Please click the following link or paste it in your browser to reset yoru passowrd.

  localhost/reset.php?token='.$hash."&"; // Our message above including the link

  $headers = 'From:noreply@shifaddnn.000webhostapp.com/' . "\r\n"; // Set from headers
  echo($message);
  mail($to, $subject, $message, $headers);

}
?>
