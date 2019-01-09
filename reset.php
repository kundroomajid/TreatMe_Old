<?php
session_start();
include("config.php");
include("header.php");
$show_form=false;
$invalid_link=false;
$email=null;
$hash=null;
$password=null;

if(isset($_REQUEST['token']) and isset($_REQUEST['email']) and isset($_REQUEST['user_password'])){
  $email = $_REQUEST['email'];
  $hash = $_REQUEST['token'];
  $password = $_REQUEST['user_password'];
  $sql = "UPDATE tb_user SET user_password='$password' WHERE user_email = '$email' and hash='$hash'";
  $result = mysqli_query($conn,$sql);
  echo "here is it";
}else if(isset($_REQUEST['token']) and isset($_REQUEST['email'])){
  $email = $_REQUEST['email'];
  $hash = $_REQUEST['token'];
  $sql = "SELECT user_id FROM tb_user WHERE user_email = '$email' and hash='$hash'";
  $result = mysqli_query($conn,$sql);
  $count = mysqli_num_rows($result);
  if($count == 1) {
    $show_form=true;
  }
}else{
  $invalid_link=true;
}

?>
<main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="register">
        <h1>Reset Password</h1>
        <div class="row justify-content-center">
          <div class="col-md-5">
            <?php if($count){ ?>
              <form action="reset.php" method="POST">
                <div class="box_form">
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
                  <div id="pass-info" class="clearfix"></div>

                  <div class="form-group text-center add_top_30">
                    <input class="btn_1" type="submit" value="Submit" />
                  </div>
                </div>
              </form>
            <?php } else if ($invalid_link){
              echo "<p>You do not belong here</p>";
            }else{
              echo "<p> Invalid token or email</p>";
            }
            ?>
          </div>
        </div>
        <!-- /row -->
      </div>
      <!-- /register -->
    </div>
  </div>


  <?php include("footer.php"); ?>
  <script src="./js/pw_strenght.js"></script>
</main>
