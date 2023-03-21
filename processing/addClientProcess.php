<?php
require '../connection/Db.php';
$name = $_POST['name'];
$phone = $_POST['phone'];
$date = date("Y/m/d");
$find_client_query = "SELECT * FROM clients WHERE name='$name'";
$find_client_result = $conn->query($find_client_query);
if ($find_client_result->num_rows > 0) {
    $errMsg .= "Le client " . $name . " existe déja<br>";
    header("location: ../forms/addClient.php?errmsg=$errMsg");
    exit;
} else {
    $query = "INSERT INTO clients VALUES (null, '$name', $phone, 0, '$date')";
    $result = $conn->query($query);
    if ($result) {
        $sucMsg .= "Le client " . $name . " a été ajouté avec succès<br>";
        header("location: ../forms/addClient.php?sucmsg=$sucMsg");
        exit;
    } else {
        $errMsg .= "Le client " . $name . " n'a pas été ajouté, réessayer!<br>";
        header("location: ../forms/addClient.php?errmsg=$errMsg");
        exit;
    }
}
$conn->close();
