<?php
include("auth.php");
// this file holds the connection info in $host, $user, $password, $db;
include_once('connectionInfo.private.php');

// the DBHandler takes care of all the direct database interaction.
require_once('DBHandler.php');

$dbHandler = new DBHandler($host,$user,$password,$db);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome Home</title>
<link rel="stylesheet" href="css/style.css" />
<script src="https://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
  <?php
  if(isset($_POST['submit']) && !isset($_GET['delete'])){
  if($dbHandler->insertNote($_POST['title'],$_POST['content'],$_SESSION['id'])){
    echo '<div class="notification">note saved</div>';
  } else {
    echo '<div class="notification">bzzzz</div>';
  }

  }

   ?>
<div class="form">
  <p>Hi <?php echo $_SESSION['username']; ?>!
<a href="logout.php">Logout</a></p>
<form action="" method="post" name="save">
  <input type="text" name="title" placeholder="Title of your note." required />
  <input type="text" name="content" placeholder="Content of your note." required />
  <input name="submit" type="submit" id="save" value="Save" />
</form>
<!-- dynamic content -->
<?php
if(isset($_POST['submit']) && !isset($_GET['delete'])){
output($dbHandler);
}

if(!isset($_POST['submit']) && !isset($_GET['delete'])){
  output($dbHandler);
}
function output($dbHandler){
  $notes = $dbHandler->fetchNotes();
  if(count($notes) == 0){
      echo '<tr class="notification"><td colspan="3">There are no notes right now.</td></tr>';
  }
  else{
    echo '<form action="" method="get" name="delete">
      <input name="delete" type="submit" value="delete" />';

      foreach($notes as $note){
          echo '<div class="card">';
          echo '<input id="checkBox" name='.$note[0].' type="checkbox" value='.$note[0].'>';
          echo '<h2>'.$note[1].'</h2></br>';
          echo '<p>'.$note[2].'</p>';
          echo "</div>";
      }
      echo '</form>';
  }
}
if(isset($_GET['delete'])){
  $arr = array();
  foreach($_GET as $note){
    $arr[] = $note;
  }
  unset($arr[0]);
  $dbHandler->deleteNotes($arr);
  output($dbHandler);
  header('Location: '.$_SERVER['PHP_SELF']);
}
?>
</div>
</body>
</html>
