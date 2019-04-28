<?php
include("header.php");
include("config.php");
$id =  mysqli_real_escape_string($conn,$_SESSION['id']);
echo($id);

$msg = $_SESSION['msg'];
function fn_resize($image_resource_id,$width,$height)
{

$target_width =300;
$target_height =300;
$target_layer=imagecreatetruecolor($target_width,$target_height);
imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
return $target_layer;
}

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
imagejpeg($target_layer,'document.jpg');
$blob = addslashes(file_get_contents('./document.jpg', true));
   $q = "INSERT INTO tb_verification(`doc_id`,`document`,`status`) VALUES ($id,'$blob',1)";
   
if($conn->query($q))
  {
    $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Document uploaded Sucessfully
    </div>';
    echo '<script>window.location = "welcomep.php";</script>';
    
}
    
    
    else
    {
        $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Error in Uploading documnets.
    </div>';
    echo '<script>window.location = "welcomep.php";</script>';
        
    }
}
elseif( $image_type == IMAGETYPE_GIF )
{
$image_resource_id = imagecreatefromgif($file);
$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
imagejpeg($target_layer,'document.jpg');
$blob = addslashes(file_get_contents('./document.jpg', true));
   $q = "INSERT INTO tb_verification(`doc_id`,`document`,`status`) VALUES ($id,'$blob',1)";
   
if($conn->query($q))
  {
    $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Document uploaded Sucessfully
    </div>';
    echo '<script>window.location = "welcomep.php";</script>';
    
}
    
    
    else
    {
        $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Error in Uploading documnets.
    </div>';
    echo '<script>window.location = "welcomep.php";</script>';
        
    }

}
elseif( $image_type == IMAGETYPE_PNG )
{
$image_resource_id = imagecreatefrompng($file);
$target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
imagejpeg($target_layer,'document.jpg');
$blob = addslashes(file_get_contents('./document.jpg', true));
 $q = "INSERT INTO tb_verification(`doc_id`,`document`,`status`) VALUES ($id,'$blob',1)";
   
if($conn->query($q))
  {
    $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Document uploaded Sucessfully
    </div>';
    echo '<script>window.location = "welcomep.php";</script>';
    
}
    
    
    else
    {
        $msg = '<div class="alert alert-danger alert-dismissible">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     Error in Uploading documnets.
    </div>';
    echo '<script>window.location = "welcomep.php";</script>';
        
    }

}

}
}
$_SESSION['msg'] = $msg;


?>


