<?php

//session_start();

include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
      // user_email and user_password sent from form
      $user_type =  mysqli_real_escape_string($conn,$_POST['user_type']);
      $user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
      $user_password = mysqli_real_escape_string($conn,$_POST['user_password']);
    
    if ( !empty($user_password) || !empty($user_email) )
        {    //create connection
            if (mysqli_connect_error()) 
            {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } 
        else 
                {

                    $hash = md5( rand(0,1000) );
                    $SELECT = "SELECT user_email From tb_user Where user_email = ? Limit 1";
                   
                    $INSERT = "INSERT Into tb_user (user_password,user_email,hash,user_type) values(?, ?,?,?)";
//                    Prepare statement
                    $stmt = $conn->prepare($SELECT);
                    $stmt->bind_param("s", $user_email);
                    $stmt->execute();
                    $stmt->bind_result($user_email);
                    $stmt->store_result();
                    $rnum = $stmt->num_rows;
                    if ($rnum==0) 
                     {
                        echo($user_type);
                        echo ($user_email);
                        echo($user_password);
                        echo($hash);
                        $stmt->close();
                        $stmt = $conn->prepare($INSERT);
                        $stmt->bind_param("ssss",$user_password,$user_email,$hash,$user_type);
                        $_SESSION['email'] = $user_email;
                        $stmt->execute();
                        if( $stmt->execute() == False)
                            {
                            echo '<script type="text/javascript">
                            alert("execution failed of sql")
//                            window.location = "index.php";
                                </script> ';
                            }
                       
                        echo '<script type="text/javascript">
                        alert("Registered Sucessfully please confirm your email id please check spam folder also")
//                        window.location = "index.php";
                        </script> ';

                    } 
                    else 
                    {
                        echo '<script type="text/javascript">
                        alert("Someone already register using this email")
//                        window.location = "./login.php";
                        </script> ';

                    }
                $stmt->close();
                $conn->close();
            }

   
    } 
    else 
    {
    echo "All field are required";
    die();
    }
    }
?>




<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div id="register">
					<h1>Join Healthcare</h1>
					<div class="row justify-content-center">
						<div class="col-md-5">
							<form action="" method="POST">
								<div class="box_form">
                  <div class="form-group">
                <label>Select User Type</label>
                <select id = "user_type" class="form-control" name ="user_type">
                  <option value = "p">User</option>
                  <option value = "d">Doctor</option>
                  <option value = "c">Clinic</option>
                </select>
              </div>

                  </select>
									<div class="form-group">
										<label>Email</label>
										<input type="email" name ="user_email"class="form-control" placeholder="Your Email Address" />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" name ="user_password" class="form-control" id="password1" placeholder="Your Password" />
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
<script src="./js/pw_strenght.js"></script>
	</main>