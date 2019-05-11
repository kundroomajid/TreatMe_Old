<?php
if (isset($_POST['btnSubmit'])) {
include("config.php");
$user_email =  mysqli_real_escape_string($conn,$_GET['email']);

$msg = $_SESSION['msg'];

function fn_resize($image_resource_id,$width,$height)
{

$target_width =300;
$target_height =300;
$target_layer=imagecreatetruecolor($target_width,$target_height);
imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
return $target_layer;
}


	
$msg_sucess = '<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> Photo Uploaded Sucessfully.
  </div>';	

if($_SERVER["REQUEST_METHOD"] == "POST")
{
$file = addslashes(file_get_contents($_FILES['uploadImage']['tmp_name']));
$file_size = $_FILES['uploadImage']['size'];
  if($file_size > 9500000)
  {
     $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     File too large. File must be less than 9.5 Mb
    </div>';
	  echo($msg);
  }
  else
  {

    if($file!=null && $file!="")
    {
      $file = $_FILES['uploadImage']['tmp_name'];
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
		  echo($msg_sucess);
		  
		  
}
      elseif( $image_type == IMAGETYPE_GIF )
        {
$image_resource_id = imagecreatefromgif($file);
$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
imagejpeg($target_layer,'temp.jpg');
$blob = addslashes(file_get_contents('./temp.jpg', true));
   $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
  $conn->query($q);
		  echo($msg_sucess);
		  

}
      elseif( $image_type == IMAGETYPE_PNG )
        {
        $image_resource_id = imagecreatefrompng($file);
        $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
        imagejpeg($target_layer,'temp.jpg');
        $blob = addslashes(file_get_contents('./temp.jpg', true));
        $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
          $conn->query($q);
		  echo($msg_sucess);
        
      }
      else
      {
        $image_resource_id = imagecreatefrompng($file);
        $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
        imagejpeg($target_layer,'temp.jpg');
        $blob = addslashes(file_get_contents('./temp.jpg', true));
        $q = "UPDATE tb_user SET photo= '$blob' where user_email = '$user_email'";
  $conn->query($q);
		  echo($msg_sucess);

      }
    }
$str = "select photo from tb_user where user_email = '$user_email'";
$result = $conn->query($str);
if($result==null) echo "nonos";
while(($r = mysqli_fetch_array($result))!=null)
{
  $output = "<br> <br> <img src = 'data:image/jpeg;base64,".base64_encode( $r[0])."' width='200' height='200' /><br> <br>";
	echo($output);

}
}
}
}
?>