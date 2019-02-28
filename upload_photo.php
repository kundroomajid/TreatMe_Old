<?php
function fn_resize($image_resource_id,$width,$height)
{

$target_width =300;
$target_height =300;
$target_layer=imagecreatetruecolor($target_width,$target_height);
imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
return $target_layer;
}
include("header.php");
include("config.php");
$user_email = $_GET['email'];
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
$file_size = $_FILES['image']['size'];

    if (($file_size > 655000))
    {
        $message = 'File too large. File must be less than 640 kb.';
        echo '<script type="text/javascript">alert("'.$message.'");</script>';
    }

if($file!=null && $file!="")
{
$file = $_FILES['image']['tmp_name'];
$source_properties = getimagesize($file);
$image_type = $source_properties[2];

if( $image_type == IMAGETYPE_JPEG )
{
$image_resource_id = imagecreatefromjpeg($file);
$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
imagejpeg($target_layer,'temp.jpg');
$blob = addslashes(file_get_contents('./temp.jpg', true));
   $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
  $conn->query($q);
}
elseif( $image_type == IMAGETYPE_GIF )
{
$image_resource_id = imagecreatefromgif($file);
$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
imagejpeg($target_layer,'temp.jpg');
$blob = addslashes(file_get_contents('./temp.jpg', true));
   $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
  $conn->query($q);

}
elseif( $image_type == IMAGETYPE_PNG )
{
$image_resource_id = imagecreatefrompng($file);
$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
imagejpeg($target_layer,'temp.jpg');
$blob = addslashes(file_get_contents('./temp.jpg', true));
$q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
  $conn->query($q);

}

}
}

$str = "select photo from tb_user where user_email = '$user_email'";
$result = $conn->query($str);
if($result==null) echo "nonos";
while(($r = mysqli_fetch_array($result))!=null){
  $output = "<br> <br> <img src = 'data:image/jpeg;base64,".base64_encode( $r[0])."' width='300' height='300' /><br> <br>";
}


?>

<!--
<script>
var uploadImage = document.getElementById("uploadImage");

uploadImage.onchange = function() {
  if(this.files[0].size > 131072){
     alert("File is too big!");
     this.value = "";
  };
};

</script>
-->

<!-- <pre> -->
<main>
		<div class="bg_color_2">
			<div class="container margin_60_35">
				<div id="register">
					<h1>Upload Your Photo(optional)</h1>
					<div class="row justify-content-center">
						<div class="col-md-5">
							<form method="POST" enctype="multipart/form-data">
								<div class="box_form">

									<div class="form-group">
                    <!-- <input type ="text" name = "hola" /> -->
  	                 <input type="file" class = "form-control" id="uploadImage" name="image" id="image" accept=".jpg, .jpeg, .png" />
                     	</div>

  	                  <input type="submit" class = "btn_1" value = "Upload" />
                      <?= "$output";?>
                      	<p class="text-center"><a href="./login.php" class="btn_1 medium">Proceed</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>








<!-- </pre> -->
</main>
<?php
include("footer.php");
?>
