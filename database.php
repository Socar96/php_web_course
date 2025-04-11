<?php 

$host = "localhost";
$database = "contacts_app";
$user = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
  // foreach($conn->query("SHOW DATABASES") as $row) {
  //   print_r($row);
  // }
} 
catch (PDOException $e) {
  die("PDO Connection Error: " . $e->getMessage());
}
