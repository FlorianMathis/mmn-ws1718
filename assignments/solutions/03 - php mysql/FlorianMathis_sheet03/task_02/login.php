<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
	include_once('connectionInfo.private.php');
	require_once('DBHandler.php');
	$dbHandler = new DBHandler($host,$user,$password,$db);

    if (isset($_POST['username'])){

		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];

        if($dbHandler->checkUser($username,$password)){
			$_SESSION['username'] = $username;
			$_SESSION['id']= $dbHandler->getUserID($username,$password);
			header("Location: index.php");
		}
         else{
				echo "<div class='form'><h3>Username/password is incorrect.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
				}
    }else{
?>
<div class="form">
<h1>Log In</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<p> <a href='registration.php'>Register Here</a></p>

</div>
<?php } ?>


</body>
</html>
