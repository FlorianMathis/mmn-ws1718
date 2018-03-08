<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Registration</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
	include_once('connectionInfo.private.php');
	require_once('DBHandler.php');
	$dbHandler = new DBHandler($host,$user,$password,$db);
    if (isset($_POST['username'])){
		$username = $_POST['username']; 
		$password = $_POST['password'];
        if($dbHandler->createUser($username,$password)){
            echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
        }
    }else{
?>
<div class="form">
<h1>Registration</h1>
<form name="registration" action="" method="post">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input type="submit" name="submit" value="Register" />
</form>
<?php } ?>
</body>
</html>