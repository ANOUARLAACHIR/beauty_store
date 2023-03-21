<?php
session_start();
require '../connection/Db.php';
$username = $_POST['username'];
$password = md5($_POST['password']);
$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = $conn->query($query);
$row = $result->fetch_assoc();
if ($result->num_rows == 0) {
    $errMsg .= "username ou mot de passe incorrecte!<br>";
    header("location: ../forms/login.php?errmsg=$errMsg");
    exit;
} else if ($row['status'] != 'active') {
    $errMsg .= "votre compte est bloqué ou pas encore activé, contacter l'administarteur!<br>";
    header("location: ../forms/login.php?errmsg=$errMsg");
    exit;
} else {
    $_SESSION['username'] = $username;
    $sucMsg .= "vous etes connecté en tant que " . $username . "<br>";
    header("location: ../index.php?sucmsg=$sucMsg&username=$username");
}
