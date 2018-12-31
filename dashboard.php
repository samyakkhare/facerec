<?php
require_once('functions.php');
session_start();
$conn= get_conn();
	$stmt = $conn->prepare("SELECT name from employees where empid = :emp and loggedin = :logg");
	$stmt->bindValue(':logg',1,PDO::PARAM_INT);
	$stmt->bindValue(':emp',$_SESSION['eid']);
	$stmt->execute();
	//$result = $stmt->setFetchMode(PDO::FETCH_ALL);
	$result= $stmt->fetch();
echo "Welcome ". $result['name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Dashboard</title>
</head>
<body>
	<br>
	<br>
	<a href="logout.php">Logout</a>
</body>
</html>