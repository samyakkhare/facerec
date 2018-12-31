<?php
require_once('functions.php');
session_start();
get_conn();
$conn= get_conn();
//echo $_SESSION['counter'];
if ($_SESSION['counter']>0)
{
	header('Location: cam1.php?q=1');
}
else
{
$stmt = $conn->prepare("UPDATE employees SET photos = :photo where empid = :emp");
$stmt->bindValue(':photo',1,PDO::PARAM_INT);
$stmt->bindValue(':emp',$_SESSION['eid']);
$stmt->execute();
$message="";
$command="/home/samyak/.virtualenvs/cv/bin/python test.py ".$_SESSION['eid'];
$cmd=escapeshellcmd($command);
//$message=exec($cmd);
$message = shell_exec($cmd);
//echo $message;
 if ($message == 1){
 	//$command1="/home/samyak/.virtualenvs/cv/bin/python trainer.py ".$_SESSION['eid'];
 	//$cmd1=escapeshellcmd($command1);
 	//$message1 = shell_exec($cmd1);
 	//if ($message1 == 1)
 	header('Location: train.php');
 		//echo $_SESSION['eid']." successfully Registered. Please click the logout button below and login.";
 	//else
 		//echo "Error generating trainer file. Please contact system admin."
 }
 else
 {
 	header('Location: cam1.php?q=2');
 	//echo "Registration Failed. Please go back and try uploading photos again.";
 }
}

?>

<!-- <!DOCTYPE HTML>
<html>
<head>
	<title>Registration</title>

</head>

<body>
	<br>

<a href="logout.php">Logout</a>

</body>

</html> -->
