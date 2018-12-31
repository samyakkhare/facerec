<?php
require_once('functions.php');
session_start();
// echo "yoyo";
// echo $_SESSION['eid'];
$command1="/home/samyak/.virtualenvs/cv/bin/python trainer.py ".$_SESSION['eid'];
$cmd1=escapeshellcmd($command1);
$message1 = shell_exec($cmd1);
//echo $message1;
 if ($message1 == 1){

 echo $_SESSION['eid']." successfully Registered. Please click the logout button below and login.";

 }
 else {
 	 echo "Error generating trainer file. Please contact system admin.";
 }


?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Registration</title>

</head>

<body>
	<br>

<a href="logout.php">Logout</a>

</body>

</html>
