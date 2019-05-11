<?php

//with progress bar
include("header.php");
include("config.php");
$user_email =  mysqli_real_escape_string($conn,$_GET['email']);

$msg = $_SESSION['msg'];


?>
<script type="text/javascript" src="./js/jquery.form.min.js"></script>

<script type="text/javascript">
	 var email = " <?php echo $user_email ?> ";
	var url = "uploadFile.php?email="+email;
	url = url.replace(/\s/g,'');
$(document).ready(function () {
    $('#submitButton').click(function () {
    	    $('#uploadForm').ajaxForm({
    	        target: '#outputImage',
    	        url: url,
    	        beforeSubmit: function () {
    	        	  $("#outputImage").hide();
    	        	   if($("#uploadImage").val() == "") {
    	        		   $("#outputImage").show();
    	        		   $("#outputImage").html("<div class='error'>Choose a file to upload.</div>");
                    return false; 
                }
    	            $("#progressDivId").css("display", "block");
    	            var percentValue = '0%';

    	            $('#progressBar').width(percentValue);
    	            $('#percent').html(percentValue);
    	        },
    	        uploadProgress: function (event, position, total, percentComplete) {

    	            var percentValue = percentComplete + '%';
    	            $("#progressBar").animate({
    	                width: '' + percentValue + ''
    	            }, {
    	                duration: 5000,
    	                easing: "linear",
    	                step: function (x) {
                        percentText = Math.round(x * 100 / percentComplete);
    	                    $("#percent").text(percentText + "%");
                        if(percentText == "100") {
                        	   $("#outputImage").show();
                        }
    	                }
    	            });
    	        },
    	        error: function (response, status, e) {
    	            alert('Oops something went.');
    	        },
    	        
//    	        complete: function (xhr) {
//    	            if (xhr.responseText && xhr.responseText != "error")
//    	            {
//    	            	  $("#outputImage").html(xhr.responseText);
//    	            }
//    	            else{  
//    	               	$("#outputImage").show();
//        	            	$("#outputImage").html("<div class='error'>Problem in uploading file.</div>");
//        	            	$("#progressBar").stop();
//    	            }
//    	        }
    	    });
    });
});
</script>

<main>
  

<div class="bg_color_2">
    <div class="container margin_60_35">
      <div id="register">
        
        <h1>Upload Your Photo(optional)</h1>
        <div class="row justify-content-center">
          <div class="col-md-5">
            <form action="uploadFile.php?email=<?=$email?>" id="uploadForm" name="frmupload"
            method="post" enctype="multipart/form-data">
              <div class="box_form">
				  <div id="info" class="clearfix"> <?= "$msg";?> </div>
                <div class="form-group">
                   <input type="file" class="form-control" id="uploadImage" name="uploadImage" accept=".jpg, .jpeg, .png" required />
                </div>

                <input type="submit" id="submitButton" name="btnSubmit" class="btn_1" value="Upload" />
				  <br /><br />
				  <div class='progress' id="progressDivId">
            <div class='progress-bar' id='progressBar'></div>
            <div class='percent' id='percent'>0%</div>
        </div>
        <div style="height: 10px;"></div>
        <div id='outputImage'></div>
                <?= "$output";?>
                <?php
                                  if(isset($_SESSION['login_user']))
                                    {
                                   echo ('<p class="text-center"><a href="./welcome.php" class="btn_1 medium">Proceed</a></p>');
                                  }
                                  
                                  else
                                  {
                                    echo('<p class="text-center"><a href="./login.php" class="btn_1 medium">Proceed</a></p>');
                                  }
                                  
                                  ?>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
   
	
	
</main>
<?php
include("footer.php");
?>