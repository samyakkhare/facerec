<?php
session_start();
$eid=$_SESSION['eid'];
if ($_SESSION['counter']==0)
{

$success = 0;
header('Location: runner.php');

}
else {
$upload_dir = "/var/www/html/facerec/input/";
//$id = "none";
//$id = $_POST['name'];
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir . $eid . "_" .$_SESSION['counter']. ".png";
$success = file_put_contents($file, $data);
//echo $success;
}

if ($success)
{
	$success= 1;
	$_SESSION['counter']=$_SESSION['counter']-1;
}
else
{
$success=2;
}
print $success ? $file : 'Unable to save the file.';
//header('Location: dashboard.php');

?>