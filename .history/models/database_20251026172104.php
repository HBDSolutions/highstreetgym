<?php

//database connection details
$servername = "localhost";
$username = "connect_hsg";
$password = "HighStreetGym1!";
$database = "highstreetgym";

//connect to the database
try {
	//connect to the database
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username,	$password);
	//set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    throw new Exception("Database connection failed: " . $e->getMessage());
}

?>