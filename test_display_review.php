         <?php
                                $query="SELECT * FROM comments  WHERE doc_id= $doc_id";
                                $result=mysqli_query($conn,$query) or die ("Query to get data from first table failed: ".mysqli_error());
                                $count = mysqli_num_rows($result);
                                ?>
                                
                                <div class="col-md-6">
						<?php
						if($count >=10)
						{
							$disp = 10;// number of count displayed
						}
						else {
							$disp = $count;
						}
						?>
                                    
						<h6><strong>Showing <?= "$disp";?></strong> of <?= "$count";?> comments</h6>
					</div>
<!--                            end header no of comments-->

								<div class="review-box clearfix">
                                    <?php
							     if($count == "0"){
								$output = '<h2>No Comments Yet!</h2>';

								echo "<small>$output</small>";

							 }
							else
							{
                                while ($cdrow=mysqli_fetch_array($result)) {
                                $user_name=$cdrow["pat_id"];
                                $comments = $cdrow["comment"];
                                $date = $cdrow["date"];
//								$image = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow["photo"])."' />";

                            ?>
									<figure class="rev-thumb"><img src="./img/avatar3.jpg" alt="" />
									</figure>
									<div class="rev-content">
										<div class="rating">
											<i class="icon-star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star voted"></i><i class="icon_star"></i>
										</div>
										<div class="rev-info">
											<?= "<small>$user_name</small>";?> –  <?= "	<small>$date</small>";?>
										</div>
										<div class="rev-text">
											<p> <?= "	<small>$comments</small>";?>

											</p>
										</div>
									</div>
								</div>
                                <?php
                                }
                            }
                                    ?>
								<!-- End review-box -->  
							</div>