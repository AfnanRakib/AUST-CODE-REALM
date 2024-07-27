<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aust_code_realm";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>