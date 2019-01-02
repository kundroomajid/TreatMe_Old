

<pre>

<form method="post" enctype="multipart/form-data">
	<input type ="text" name = "hola" />
	<input type="file" id="uploadImage" name="image" id="image" accept=".jpg, .jpeg, .png" />
	<input type="submit" value = "INSERT" />
</form>


<?php
include("config.php");
$user_email = $_GET['email'];




	$file = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	if($file!=null && $file!=""){
		$q = "UPDATE tb_user SET photo= '$file' where user_email = '$user_email'";
		$conn->query($q);
}


$str = "select photo from tb_user where user_email = '$user_email'";
$result = $conn->query($str);
if($result==null) echo "nonos";
while(($r = mysqli_fetch_array($result))!=null){
	echo "<img src = 'data:image/jpeg;base64,".base64_encode( $r[0])."' /><br/>";
}


?>

<script>
var uploadImage = document.getElementById("uploadImage");

uploadImage.onchange = function() {
    if(this.files[0].size > 131072){
       alert("File is too big!");
       this.value = "";
    };
};

</script>
</pre>
