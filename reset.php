<?php
session_start();
include("config.php");
include("header.php");
//$show_form=false;
//$invalid_link=false;
//$email=null;
//$hash=null;
//$password=null;
$email =  mysqli_real_escape_string($conn,$_GET['email']);
  $hash =  mysqli_real_escape_string($conn,$_GET['token']);

if(isset($_GET['token']) && isset($_GET['email']) && $_SERVER["REQUEST_METHOD"] == "POST")
{
  
  $password =  mysqli_real_escape_string($conn,$_REQUEST['user_password']);
  $password = md5($password);
  $sql = "UPDATE tb_user SET user_password='$password' WHERE user_email = '$email' and hash='$hash'";
  if(mysqli_query($conn, $sql))
  {
    $msg = '<div class= "alert alert-info alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Password changed Sucessfully Login Here</div>';
    echo '<script type="text/javascript">
//        alert("password changed")
    window.location = "./login.php";
    </script> ';
  } else 
  {

    $msg ='<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Something went Wrong
    </div>';

  }
  $_SESSION['msg'] = $msg;
  
}

?>
<main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="register">
        <div id="info2" class="clearfix">  <?= "$msg";?> </div>
        <h1>Reset Password</h1>
        <div class="row justify-content-center">
          <div class="col-md-5">
              <form action="" method="POST">
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
