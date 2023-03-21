<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
require '../connection/Db.php';
$username = $_POST['username'];
$password = $_POST['password'];
$c_password = $_POST['c_password'];
$role = $_POST['role'];
if (strlen($password) < 6) {
    $errMsg .= "Le mot de passe doit contenir au moins 6 caractère<br>";
    header("location: ../forms/addUser.php?errmsg=$errMsg");
    exit;
} else if ($c_password != $password) {
    $errMsg .= "Les deux mots de passes doivent etre identiques<br>";
    header("location: ../forms/addUser.php?errmsg=$errMsg");
    exit;
} else {
    $find_user_query = "SELECT * FROM user WHERE username='$username'";
    $find_user_result = $conn->query($find_user_query);
    if ($find_user_result->num_rows > 0) {
        $errMsg .= "L'utilisateur " . $username . " existe déja<br>";
        header("location: ../forms/addUser.php?errmsg=$errMsg");
        exit;
    } else {
        $enc_password = md5($password);
        $query = "INSERT INTO user VALUES (null, '$username', '$enc_password', '$role', 'waiting...')";
        $result = $conn->query($query);
        if ($result) {
            $sucMsg .= "L'utilisateur " . $username . " a été ajouté avec succès<br>";
            header("location: ../forms/addUser.php?sucmsg=$sucMsg");
            exit;
        } else {
            $errMsg .= "L'utilisateur " . $username . " n'a pas été ajouté, réessayez!<br>";
            header("location: ../forms/addUser.php?errmsg=$errMsg");
            exit;
        }
    }
}

$conn->close();
