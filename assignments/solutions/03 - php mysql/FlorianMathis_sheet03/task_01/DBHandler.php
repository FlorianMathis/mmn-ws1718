<?php

class DBHandler
{
    const TABLE_CONTACTS = 'contacts';
    var $connection;

    function __construct($host,$user,$password,$db){
        $this->connection = new mysqli($host,$user,$password,$db);
        $this->ensureContactsTable();
    }


    function insertContact($fname,$lname,$street,$plz,$city,$mail){
        if($this->connection){
            $queryString = "INSERT INTO contacts (firstname,lastname,street,postalcode,city,mail) VALUES (?,?,?,?,?,?)";
            $statement = $this->connection->prepare($queryString);
            $statement->bind_param("sssiss",$fname,$lname,$street,$plz,$city,$mail); 
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

    function ensureContactsTable(){
        if($this->connection){
            $queryString = "CREATE TABLE IF NOT EXISTS contacts
							(id INT(3) PRIMARY KEY AUTO_INCREMENT,
               firstname VARCHAR(30) NOT NULL,
			   lastname VARCHAR(30) NOT NULL,street VARCHAR(30) NOT NULL,
			   postalcode INT(5) NOT NULL,
			   city VARCHAR(30) NOT NULL,
               mail VARCHAR(30) NOT NULL)";
            $this->connection->query($queryString);
        }
    }

    
    function fetchContacts(){
        $contacts = array();
        if($this->connection){
            $this->ensureContactsTable();
            $queryString = "SELECT firstname,lastname,street,postalcode,city,mail FROM contacts";
            $statement = $this->connection->prepare($queryString);
            $statement->execute();
            $statement->bind_result($fname,$lname,$street,$plz,$city,$mail);
            while($statement->fetch()){
                $contacts[] = array($fname,$lname,$street,$plz,$city,$mail);
            }
        }
        return $contacts;
    }

    function sanitizeInput(&$string){
        $string = $this->connection->real_escape_string($string);
    }

    function resetList(){
      $queryString ="DROP table contacts";
      $statement = $this->connection->prepare($queryString);
      $statement->execute();
    }
}
