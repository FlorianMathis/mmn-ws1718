<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phonebook</title>
    <style>
        body,html{
            font-family: 'Helvetica Neue','Helvetica', 'Arial', sans-serif;
            font-size: 20px;
            margin:0;
            padding:0;
            background-color: #333;
            color: white;
        }
        .error{
            color: red;
        }
        .success{
            color: greenyellow;
        }
        .notification{
            color: coral;
        }
        .error,.success, .notification{
            margin: 2em 0;
            border: 2px dotted white;
            padding: 2em;
        }

        #container{
            width: 90%;
            min-width: 700px;
            margin:auto;
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
        }

        table.contacts{
            margin: 2em 0;
            width: 100%;
        }

        #formContainer{
            width: 100%;
        }
        label{
            margin-right: 2em;
        }
    </style>
</head>
<body>

<div id="container">

<?php

// this file holds the connection info in $host, $user, $password, $db;
include_once('connectionInfo.private.php');

// the DBHandler takes care of all the direct database interaction.
require_once('DBHandler.php');

$dbHandler = new DBHandler($host,$user,$password,$db);

if(isset($_POST['submit'])){
    $dbHandler->sanitizeInput($_POST['fname']);
    $dbHandler->sanitizeInput($_POST['lname']);
	$dbHandler->sanitizeInput($_POST['street']);
    $dbHandler->sanitizeInput($_POST['plz']);
	$dbHandler->sanitizeInput($_POST['city']);
    $dbHandler->sanitizeInput($_POST['mail']);
    if($dbHandler->insertContact($_POST['fname'],$_POST['lname'],$_POST['street'],$_POST['plz'],$_POST['city'],$_POST['mail'])){
        echo '<div class="success">contact was successfully added</div>';
    }
    else{
        echo '<div class="error">contact was not added. duplicated mail?-</div>';
    }
}

if(isset($_POST['delete'])){
  $dbHandler->resetList();
  echo '<div class="error">The whole table got deleted.</div>';
}

?>
<table class="contacts">
    <thead>
    <tr>
        <td>First name</td>
        <td>Last name</td>
        <td>Street address</td>
		<td>Street address</td>
	    <td>City</td>
		<td>Email address</td>

    </tr>
    </thead>
    <tbody>
    <?php
    $contacts = $dbHandler->fetchContacts();
    if(count($contacts) == 0){
        echo '<tr class="notification"><td colspan="3">There are no contacts right now.</td></tr>';
    }
    else{
        foreach($contacts as $contact){
            echo "<tr>";
            foreach($contact as $data){
                echo "<td>$data</td>";
            }
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>

<div id="formContainer">
    <form method="post">
        <label>
           First name:
            <input type="text"  required name="fname"/>
        </label>
        <label>
            Last name:
            <input type="text"  name="lname"/>
        </label>
		<label>
            Street address:
            <input type="text"  name="street"/>
        </label>
		<label>
            Postal code:
            <input type="text"  name="plz"/>
        </label>
		<label>
            City:
            <input type="text"  name="city"/>
        </label>
		<label>
            Email address:
            <input type="text"  required name="mail"/>
        </label>
        <input type="submit" name="submit" value="Add to phonebook"/>
    </form>
</div>

</div>
</body>
</html>
