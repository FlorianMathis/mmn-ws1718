<?php

class DBHandler
{
    const TABLE_USERS = 'users';
    var $connection;

    function __construct($host,$user,$password,$db){
        $this->connection = new mysqli($host,$user,$password,$db);
        $this->ensureUsersTable();
        $this->ensureNotesTable();
    }

    function createUser($username,$password){
        if($this->connection){
            $queryString = "INSERT INTO users (username,password) VALUES (?,?)";
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("ss",$username,$hashed_password );
            $statement->execute();
            if($statement->error){
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }
	function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}
	
    function checkUser($username,$pw){
        if($this->connection){
            $queryString = "SELECT password FROM users WHERE username='$username'";
			$statement = $this->connection->prepare($queryString);
			$statement->execute();
			$statement->bind_result($password);
			if($statement->fetch()){
				$this->debug_to_console($password);
				$this->debug_to_console($pw);
				if(password_verify($pw, $password)){
					return true; 
				} else return false;
				}
				else return false;
			}
    }
    function insertNote($title,$content){
        if($this->connection){
            $queryString = "INSERT INTO notes (title,content,refid) VALUES (?,?,?)";
            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("ssi",$title,$content,$_SESSION['id']);
            $statement->execute();
            if($statement->error){
                return false;
            }
            else{
                return true;
            }
        }
        return false;
    }

    function getUserID($user,$password){
      $idreturn=0;
      if($this->connection){
          $queryString = "SELECT id FROM users where username='$user' and password='$password'";
          $statement = $this->connection->prepare($queryString);
          $statement->execute();
          $statement->bind_result($id);

          while($statement->fetch()){
            $idreturn=$id;
          }
      }
      return $idreturn;
    }

    function fetchNotes(){
        $notes = array();
        if($this->connection){
            $queryString = "SELECT notes.id,title,content,refid FROM notes where notes.refid='" . $_SESSION['id'] . "'";
            $statement = $this->connection->prepare($queryString);
            $statement->execute();
            $statement->bind_result($id,$title,$content,$refid);
            while($statement->fetch()){
                $notes[] = array($id,$title,$content,$refid);
            }
        }
        return $notes;
    }
    function ensureUsersTable(){
        if($this->connection){
            $queryString = "CREATE TABLE IF NOT EXISTS users
              (id INT(3) PRIMARY KEY AUTO_INCREMENT,
               username VARCHAR(30) NOT NULL,
         password VARCHAR(255) NOT NULL)";
            $this->connection->query($queryString);
        }
    }
    function ensureNotesTable(){
        if($this->connection){
            $queryString = "CREATE TABLE IF NOT EXISTS notes
              (id INT(3) PRIMARY KEY AUTO_INCREMENT,
               title VARCHAR(300) NOT NULL,
         content VARCHAR(300) NOT NULL,
         refid INT(3))";
            $this->connection->query($queryString);
        }
    }

    function deleteNotes($array){
      if($this->connection){
          foreach($array as $note){
            $queryString = "DELETE from notes where notes.id ='". $note."'";
            $this->connection->query($queryString);
          }

      }
    }
}
