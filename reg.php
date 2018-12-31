<?php
require_once('functions.php');
session_start();
$conn= get_conn();

$eid = $_POST['eid'];
$email = $_POST['email'];
$name = $_POST['name'];
check_mail($email);
check_regno($eid);
check_name($name);

$_SESSION['name']=$name;
$_SESSION['email']=$email;
$_SESSION['eid']=$eid;
$_SESSION['register']=1;
$_SESSION['nopics']=10;
$_SESSION['counter']=10;

try {
		$stmt = $conn->prepare('INSERT INTO employees(empid,name,email) VALUES(:empid,:name,:email)');
		$stmt->bindValue(':name',$name);
		$stmt->bindValue(':empid',$eid);
		$stmt->bindValue(':email',$email);
		$stmt->execute();
		//$delid = $conn->lastInsertId();
		// echo "<h1>Please Wait</h1>";
		// header("location: index.php#login");
		$response = array('status' => 1, 'message'=>'Registered successfully.');
		header('Location: cam1.php?q=0');		
		//die(json_encode($response));
		
	}
	catch(PDOException $e) {
		$response = array('status' => 0, 'message'=>'Duplicate entry. Emp id already exists');
		header('Location: register.php?q=1');
		//die(json_encode($response));
	}


?>