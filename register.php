<?php


include("header.php");

?>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="register">
        <h1>Join TreatMe</h1>
        <div class="row justify-content-center">
          <div class="col-md-5">
            <form action="register_controller.php" method="POST" id="myForm" name="myForm">
              <div class="box_form">
                  <?php if(isset($_SESSION['msg']))
                  {
                      $msg = $_SESSION['msg'];
                      unset($_SESSION['msg']);
                  }
                      ?>
                <div id="info" class="clearfix"> <?= "$msg";?> </div>
                <div class="form-group">
                  <label>Select User Type</label>
                  <select id="user_type" class="form-control" name="user_type">
                    <option value="p">User</option>
                    <option value="d">Doctor</option>
                    <option value="c">Clinic</option>
                  </select>
                </div>
                </select>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="user_email" class="form-control" placeholder="Your Email Address"/>
                </div>
                  <div class="form-group">
                      <label>Mobile</label>
                      <input type="number" name="user_mobile" class="form-control" placeholder="Your Mobile Number"/>
                  </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="user_password" class="form-control" id="password1" placeholder="Your Password" />
                </div>
                <div class="form-group">
                  <label>Confirm password</label>
                  <input type="password" class="form-control" id="password2" name = "password2" placeholder="Confirm Password"/>
                </div>
                  <div class="form-group" >
                      <div class="g-recaptcha" data-sitekey="6Lch9KsUAAAAAMIljdmAvJlICCPWwa2yFy5PNzyM"></div>
                  </div>
                <div id="pass-info" class="clearfix"></div>
                <div class="checkbox-holder text-left">
                  <div class="checkbox_2">
                    <input type="checkbox" value="false" id="check_2" name="check_2" required/>
                    <label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
                  </div>
                </div>

                <div class="form-group text-center add_top_30">
                  <input class="btn_1" type="submit" value="Submit"/>

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

<!--jquery validator-->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="./js/formvalidator.js"></script>


<!--validator ends-->

  <?php include("footer.php"); ?>
  <script src="./js/pw_strenght.js"></script>
</main>
