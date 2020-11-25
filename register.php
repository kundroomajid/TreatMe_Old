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
                <!-- Start Tab view Author NAFFI -->
                <!-- start pills -->
                <style>
                  
                </style>

                <div class="justify-content-center">
                  <h6 class="text-center select-user-type_N">Select user type</h6>
                </div>
                
                <ul class="nav nav-pills justify-content-center">
                  <li class="nav-item">
                    <a class="nav-link border " data-toggle="pill" href="#user"><span class=" nav-pills_text_N">User</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link border " data-toggle="pill" href="#doctor"><span class="nav-pills_text_N">Doctor</span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link border " data-toggle="pill" href="#clinic"><span class="nav-pills_text_N">Clinic</span></a>
                  </li>
                </ul>
                <br>
                <!-- end pills -->
                <!-- start pills-content -->
                <div class="tab-content">
                  <div id="user" class="tab-pane fade">
                  <!-- user content start -->
                    <div class="form-group" hidden>
                      <label>Select User Type</label>
                      <select id="user_type" class="form-control" name="user_type">
                        <option value="p" selected>User</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <h6 class="">Selected user type User</h6>
                    </div>
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
                  <!-- user content end -->
                  </div>
                  <div id="doctor" class="tab-pane fade">
                  <!-- doctor content start -->
                    <div class="form-group" hidden>
                      <label>Select User Type</label>
                      <select id="user_type" class="form-control" name="user_type">
                        <option value="d" selected>Doctor</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <h6 class="">Selected user type Doctor</h6>
                    </div>
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
                  <!-- doctor content end -->
                  </div>
                  <div id="clinic" class="tab-pane fade">
                    <!-- clinic content start -->
                    <div class="form-group" hidden>
                      <label>Select User Type</label>
                      <select id="user_type" class="form-control" name="user_type">
                        <option value="c" selected>Clinic</option>
                      </select>
                    </div>
                    <div class="form-group">
                        <h6 class="">Selected user type Clinic</h6>
                    </div>
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
                  <!-- clinic content end -->
                  </div>
                </div>
                <!-- end pills-content -->

                <!-- End Tab view Author NAFFI -->
                
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

