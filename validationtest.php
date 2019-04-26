<?php include('header.php');








?>
<script>
jQuery(document).ready(function() {
   jQuery("#forms).validate({
      rules: {
         user_email: {
            required: true,
            email: true,//add an email rule that will ensure the value entered is valid email id.
            maxlength: 255,
         }
         
         
         
      }
      messages: {
   
   user_email: 'Enter a valid email',
    } 
   });
});

submitHandler: function(form) {
   form.submit();
}
</script>

<main>
  <div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="register">
        <h1>Join TreatMe</h1>
        <div class="row justify-content-center">
          <div class="col-md-5">
            <form action="" method="POST">
              <div class="box_form">
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
                  <input type="email" name="user_email" class="form-control" placeholder="Your Email Address" />
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="user_password" class="form-control" id="password1" placeholder="Your Password" />
                </div>
                <div class="form-group">
                  <label>Confirm password</label>
                  <input type="password" class="form-control" id="password2" placeholder="Confirm Password" />
                </div>
                <div id="pass-info" class="clearfix"></div>
                <div class="checkbox-holder text-left">
                  <div class="checkbox_2">
                    <input type="checkbox" value="accept_2" id="check_2" name="check_2" checked="" />
                    <label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
                  </div>
                </div>

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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
</main>