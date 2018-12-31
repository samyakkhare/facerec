<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if ($_GET['q']==1){
	echo "Duplicate entry. Employee id already exists";
}

?>
<head>
<title>REGISTER</title>
</head>
<body>	
	<form class="login100-form validate-form" method="post" name="form" action="reg.php">

					
					<div class="wrap-input100 validate-input" data-validate = "Name is required">
						Name: <input class="input100"  id ="name" type="text" name="name" placeholder="Name" value="<?php echo $_SESSION['name'] ?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						Email: <input class="input100"  id ="email" type="text" name="email" placeholder="Email" value="<?php echo $_SESSION['email'] ?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Employee id is required">
						Employee ID: <input class="input100"  id ="eid" type="text" name="eid" placeholder="Employee ID" value="<?php echo $_SESSION['eid'] ?>">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Submit
						</button>
					</div>
				</form>

</body>
</html>
