<?php
// Create a connection object
$conn = mysqli_connect("localhost3306", "username", "password", ,"email" , "MYSQL.sql");

// Check the connection status
if (!$conn) {
  // Connection failed
  die("Connection error: " . mysqli_connect_error());
}

// Connection successful
echo "Connected successfully";
?>