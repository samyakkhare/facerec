<?php
require_once('functions.php');
$eid = $_POST['eid'];
check_regno($eid);
$upload_dir = "/var/www/html/facerec/tryrecog/";
//$id = "none";
//$id = $_POST['name'];
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = $upload_dir . $eid . ".png";
$success = file_put_contents($file, $data);
if ($success)
{
	$success= 1;
	//header('Location: run_script.php');
	
}
 else
 {
 $success= 0;
// header('Location: logout.php');
 print $success ? $file : 'Unable to save the file.';
}

$command="/home/samyak/.virtualenvs/cv/bin/python recog.py ".$eid;
$cmd=escapeshellcmd($command);
$message = shell_exec($cmd);

if ($message==1){
	session_start();
	$_SESSION['eid']=$eid;
	$conn= get_conn();
	$stmt = $conn->prepare("UPDATE employees SET loggedin = :logg where empid = :emp");
	$stmt->bindValue(':logg',1,PDO::PARAM_INT);
	$stmt->bindValue(':emp',$eid);
	$stmt->execute();
}
echo $message;
//header('Location: dashboard.php');

?>