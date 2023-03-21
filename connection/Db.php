<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "beauty_store";
$errMsg = "";
$sucMsg = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
  $msg .= die("<div class='alert alert-danger'>Connection failed: " . $conn->connect_error . "</div><br />");
}
