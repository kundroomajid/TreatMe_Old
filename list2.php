<?php include("header.php");
if(isset($_GET['q']))
{
$q = $_GET['q'];
}
else {
	$q=null;
}


$limit = 10;   
    if (isset($_GET["page"])) {  
      $pn  = $_GET["page"];  
    }  
    else {  
      $pn=1;  
    };   
  
    $start_from = ($pn-1) * $limit;   

if(isset($_GET['dist']))
{
$dist = $_GET['dist'];
$query ="SELECT * FROM vw_doctor WHERE district = '$dist' LIMIT $offset, $no_of_records_per_page";
$result=mysqli_query($conn,$query) or die ("Query to get data from firsttable failed: ".mysqli_error());
$count = mysqli_num_rows($result);
}
else if (isset($_GET['spec'])){
$spec = $_GET['spec'];
$query="SELECT * FROM vw_doctor  WHERE `specialization` LIKE '%$spec%' LIMIT $offset, $no_of_records_per_page";
$result=mysqli_query($conn,$query) or die ("Query to get data from firsttable failed: ".mysqli_error());
$count = mysqli_num_rows($result);
}

else if (isset($_GET['q']))
{
	$q = $_GET['q'];
	$query="SELECT * FROM vw_doctor WHERE `user_name` LIKE '%$q%' LIMIT $offset,$no_of_records_per_page";
$result=mysqli_query($conn,$query) or die ("Query to get data from firsttable failed: ".mysqli_error());
$count = mysqli_num_rows($result);
}

else
{
  $query="SELECT * FROM vw_doctor LIMIT $start_from, $limit";
$result=mysqli_query($conn,$query) or die ("Query to get data from firsttable failed: ".mysqli_error());
$count = mysqli_num_rows($result);
  
}

 // code to get total number of fields and pages

$sql = "SELECT COUNT(*) FROM vw_doctor";   
        $rs_result = mysqli_query($conn,$sql);   
        $row = mysqli_fetch_row($rs_result);   
        $total_records = $row[0];   
        $total_pages = ceil($total_records / $limit);
                

include("config.php");?>

<main>
		<div id="results">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<?php // TO DO
						if($count >=10)
						{
							$disp = 10;// number of coun displayed
						}
						else {
							$disp = $count;
						}
						?>
						<h4><strong>Showing <?= "$disp";?></strong> of <?= "$total_records";?> results</h4>
					</div>

					<div class="col-md-6">
						<div class="search_bar_list">
								<form method="GET" action="list.php"  id = "search"/>
							<input type="text" id = "search" name="q" class="form-control" placeholder="Search doctors, clinics, hospitals etc." />
							<input type="submit" value="Search" />
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /results -->

		<div class="filters_listing">
			<div class="container">
				<ul class="clearfix">
					<li>
						<h6>Type</h6>
						<div class="switch-field">
							<input type="radio" id="all" name="type_patient" value="all" checked="" />
							<label for="all">All</label>
							<input type="radio" id="doctors" name="type_patient" value="doctors" />
							<label for="doctors">Doctors</label>
							<input type="radio" id="clinics" name="type_patient" value="clinics" />
							<label for="clinics">Clinics</label>
						</div>
					</li>
					
					<li>
						<h6>Select By District</h6>
						<select name="dist"  id = "dist" class="selectbox">
							<option value = "">Select District</option>
                		<option value = "Anantnag">Anantnag</option>
                		<option value = "Bandipora">Bandipora</option>
							<option value = "Baramulla">Baramulla</option>
                		<option value = "Budgam">Budgam</option>
                			<option value = "Ganderbal">Ganderbal</option>
							<option value = "Kulgam">Kulgam</option>
							<option value = "Kupwara">Kupwara</option>
							<option value = "Pulwama">Pulwama</option>
                	<option value = "Shopain">Shopain</option>
                	<option value = "Srinagar">Srinagar</option>
                	<option value = "Doda">Doda</option>
                	<option value = "Jammu">Jammu</option>
                	<option value = "Kathua">Kathua</option>
                	<option value = "Kishtwar">Kishtwar</option>
                	<option value = "Poonch">Poonch</option>
                	<option value = "Rajouri">Rajouri</option>
                	<option value = "Reasi">Reasi</option>
                	<option value = "Ramban">Ramban</option>
                	<option value = "Samba">Samba</option>
                	<option value = "Udhampur">Udhampur</option>
                	<option value = "Kargil">Kargil</option>
                	<option value = "Leh">Leh</option>
              	</select>
					<script>
    document.getElementById("dist").onchange = function() {
        if (this.selectedIndex!==0) {
            window.location.href = './list.php?dist='+ this.value;
        }        
    };
</script>	
					</li>
<!--
					 <li>
						<h6>Layout</h6>
						<div class="layout_view">
							<a href="./grid-list.php"><i class="icon-th"></i></a>
							<a href="#0" class="active"><i class="icon-th-list"></i></a>
							<a href="./list-map.php"><i class="icon-map-1"></i></a>
						</div>
					</li> 
-->
					<li>
						<h6>Sort by</h6>
						<select name="orderby" class="selectbox">
						<option value="Closest" />Closest
						<option value="Best rated" />Best rated
						<option value="Men" />Men
						<option value="Women" />Women
						</select>
					</li>
				</ul>
			</div>
			<!-- /container -->
		</div>
		<!-- /filters -->

    <div class="container margin_60_35">




        <div class="row">
				<div class="col-lg-7">

<?php

							if($count == "0"){
								$output = '<h2>No result found!</h2>';

								echo "<small>$output</small>";

							}
							else
							{
            while ($cdrow=mysqli_fetch_array($result)) {
                $user_name=$cdrow["user_name"];
                $doc_id=$cdrow["doc_id"];
				$specialization = $cdrow["specialization"];
                $image = "<img src ='data:image/jpeg;base64,".base64_encode( $cdrow["photo"])."' />";
                $rate_times = $cdrow['rated_by'];
                 $avg_rating = $cdrow['avg_rating'];
            ?>
					<div class="strip_list wow fadeIn" >
						<a href="#0" class="wish_bt"></a>
						<figure>
							<a href="./detail-page.php"><img src="" alt="" /></a>
							<?= "$image";?>
						</figure>
						<?php if(strlen($specialization) > 24)
						{
							$spec_Array =  explode (",", $specialization);
							$spec1 = $spec_Array[0];
							$spec2 = $spec_Array[1];
							$spec3 = $spec_Array[2];
							$spec4 = $spec_Array[3];
							echo ("<small>$spec1,$spec2</small>");
							echo ("<small>$spec3,$spec4</small>");
							
						}
				else
				{
					echo ("<small>$specialization</small>");
				}
				?>

                       <?php 
               $query1="SELECT * FROM tb_qualifications where doct_id = $doc_id";
            $result1=mysqli_query($conn,$query1) or die ("Query to get data from firsttable failed: ".mysqli_error());
            $cdrow1=mysqli_fetch_array($result1);
              $degree = strtoupper($cdrow1['degree']);
              $institute = strtoupper($cdrow1['institute']);
              $experience = $cdrow1['experience'];
              
              ?>
                      
						<?= "<h3>$user_name</h3>";?>
                       <p><?= $degree ?> ( <?= $institute ?> ), <?= $experience ?> Years Experience</p>
						<span class="rating">
                           <?php  
                                            $x = 0;
                                        
                                            if($avg_rating < 5)
                                            {
                                            for ($x; $x < $avg_rating; $x++) 
                                            {
                                            echo "<i class='icon_star voted'></i>";
                                            }
                                              $diff = ceil(5-$x);
                                              for ($i = 0; $i < $diff; $i++) 
                                            {
                                            echo "<i class='icon_star'></i>";
                                            }
                                            }
                                            
                                          
                                              else 
                                              {
                                            echo ('<i class="icon_star"></i>
											<i class="icon_star"></i>
											<i class="icon_star"></i>
											<i class="icon_star"></i>
											<i class="icon_star "></i>');
                                              }
                                              
                                               
?>  
                          <small>(<?php echo $rate_times; ?>)</small></span>
<!--						<a href="./badges.php" data-toggle="tooltip" data-placement="top" data-original-title="Badge Level" class="badge_list_1"><img src="./img/badges/badge_1.svg" width="15" height="15" alt="" /></a>-->
						<ul>
							<li><a href="#0" onclick="onHtmlClick('Doctors', 0)" class="btn_listing">View on Map</a></li>
							<li><a href=" ">Directions</a></li>
							<li><a href="./detail-page.php?doc_id=<?= $doc_id ?>" class="btn_listing">View Profile</a></li>
						</ul>
					</div>


            <?php  
            }
}
					?>


                 
                  

					 <nav aria-label="" class="add_top_20"> 
						<ul class="pagination pagination-sm">
                          <?php
                          $k = (($pn+4>$total_pages)?$total_pages-4:(($pn-4<1)?5:$pn));         
        $pagLink = ""; 
        if($pn>=2){ 
            echo "<li class='page-item '><a class='page-link' href='list2.php?page=1'> First </a></li>"; 
            echo "<li class='page-item '><a class='page-link' href='list2.php?page=".($pn-1)."'> Previous </a></li>"; 
        } 
        for ($i=1; $i<=4; $i++) { 
          if($k+$i==$pn) 
            $pagLink .= "<li class='page-item active'><a class='page-link' href='list2.php?page=".($k+$i)."'>".($k+$i)."</a></li>"; 
          else
            $pagLink .= "<li class='page-item '><a class='page-link' href='list2.php?page=".($k+$i)."'>".($k+$i)."</a></li>";   
        };   
        echo $pagLink; 
        if($pn<$total_pages){ 
           echo "<li class='page-item '><a class='page-link' href='list2.php?page=".($pn+1)."'> Next </a></li>"; 
           echo "<li class='page-item '><a class='page-link' href='list2.php?page=".$total_pages."'> Last </a></li>"; 
        }     
      ?> 
      </ul> 

                          
              
                          
<!--
							<li class="page-item disabled">
								<a class="page-link" href="#" tabindex="-1">Previous</a>
							</li>
							<li class="page-item active"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="?page=2">2</a></li>
							<li class="page-item"><a class="page-link" href="#">3</a></li>
							<li class="page-item">
								<a class="page-link" href="#">Next</a>
							</li>
-->
						</ul>
					</nav>
					<!-- /pagination 

				</div>
				<!-- /col -->

<!--
map listinig sidebar
				<aside class="col-lg-5" id="sidebar">
					<div id="map_listing" class="normal_list">
					</div>
				</aside>
-->
				<!-- /aside -->

			</div>
			<!-- /row -->
		</div>


<!-- /container -->
<?php include("footer.php");?>
	</main>
	<!-- /main -->
