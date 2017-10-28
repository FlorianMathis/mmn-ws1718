<!DOCTYPE html>
<html>
<head lang="en">
 <meta charset="UTF-8">
 <title>What's wrong here?</title>
 <!--
problem:
  x form is not working because of missing input type submit -> type="submit"
  x GET-Protokoll für personenbezogene Daten (Mail,Passwort) -> solution: $_POST + add post method to form
  x check if the submit-button was pressed
 -->
</head>
<body>
<?php
function loginUser($email, $password){
 if($password === 'FlorianMathis') {
 echo '<p>You are now logged in.</p>';
 } else {
 echo '<p>Wrong password</p>';
 }
}
if (isset($_POST['submit'])) {
 loginUser($_POST['email'], $_POST['password']);
} else { ?>
 <form method="Post">  <!--  it is not necessary to set the action (analog lecture, because we are going to call the same file) -->
 <label>
 Email: <input type="email" name="email" />
 </label>
 <label>
 Password: <input type="password" name="password" />
 </label>
 <input type="submit" name="submit" />
 </form>
<?php } ?>
</body>
</html>
