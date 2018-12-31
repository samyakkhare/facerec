<?php
require_once('functions.php');
session_start();
$conn=get_conn();
$stmt = $conn->prepare("UPDATE employees SET loggedin = :logg where empid = :emp");
$stmt->bindValue(':logg',0,PDO::PARAM_INT);
$stmt->bindValue(':emp',$_SESSION['eid']);
$stmt->execute();
session_unset();
session_destroy();
header('Location: test.html');
?>