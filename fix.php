<?php
include("header.php");
include("config.php");

$query = "SELECT * from tb_doctor where sounds_like = ' ' order by doc_id";
$result1 = mysqli_query($conn,$query) or die ("Query to get data from firsttable failed: ".mysqli_error($conn));

$num_rows = mysqli_num_rows($result1);
echo($num_rows);

if($num_rows < 1)
{
	echo('finished');
}

while ($cdrow=mysqli_fetch_array($result1)) 
{
	$doc_id = $cdrow["doc_id"];
	$specalization = $cdrow["specialization"];
	$sql = "Select user_name from tb_user where user_id = $doc_id";
	$result2 = mysqli_query($conn,$sql) or die ("Query to get data from 2nd table failed: ".mysqli_error($conn));
	$cdrow2=mysqli_fetch_array($result2);
	$doc_name = $cdrow2['user_name'];
	$doc_name = $stripped = str_replace(' ', '', $doc_name);
	
	$data['user_name'] = $doc_name;
	$data['specialization'] = $specalization;
	
	$sound_like = make_sounds($data);
	echo ($doc_id );
	echo '<br>';
	echo($doc_name);
	echo '<br>';
//	echo($specalization);
	echo($sound_like);
	echo('<hr>');
	
	$insert = "update tb_doctor set sounds_like = '$sound_like' where doc_id = $doc_id";
	$result3 = mysqli_query($conn,$insert) or die ("Query to get data from 2nd table failed: ".mysqli_error($conn));
	
}

function make_sounds($data)
{
	$sounds_like = ' ';
	
	if(isset($data['user_name']))
	{
		$sounds_like .= metaphone($data['user_name']).' ';
	}
	
	if(isset($data['specialization']))
	{
		$sounds_like .= metaphone($data['specialization']) .' ';
	}
	
	return $sounds_like;
}


?>