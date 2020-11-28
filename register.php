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
            <div class="box_form">
              <?php if (isset($_SESSION['msg'])) {
                $msg = $_SESSION['msg'];
                unset($_SESSION['msg']);
              }
              ?>
              <div id="info" class="clearfix"> <?= "$msg"; ?> </div>
              <!-- Start Tab view Author NAFFI -->
              <!-- start pills -->
              <div class="justify-content-center">
                <h6 class="text-center select-user-type_N">Select user type</h6>

                <a href="./reg_user.php" class="btn_1">User</a>
                <a href="./reg_doc.php" class="btn_1">Doctor</a>
                <a href="./reg_clinic.php" class="btn_1">Clinic</a>

              </div>

              <!-- end pills -->

              <!-- End Tab view Author NAFFI -->

            </div>

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