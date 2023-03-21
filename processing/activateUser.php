<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $user_id = $_GET['user_id'];
    $selectSql = "SELECT * FROM user WHERE id = $user_id";
    $selectResult = mysqli_query($conn, $selectSql);
    $row = mysqli_fetch_assoc($selectResult);
    if ($row['status'] != 'active') {
        $sql = "UPDATE user SET status = 'active' WHERE id = $user_id";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $sucMsg .= "L'utilisateur " . $row['username'] . " a été activé!<br>";
            header("location: ../forms/usersList.php?sucmsg=$sucMsg");
            exit;
        } else {
            $errMsg .= "Un problème à été occuré, réessayer!<br>";
            header("location: ../forms/usersList.php?errmsg=$errMsg");
            exit;
        }
    } else {
        $errMsg .= "L'utilisateur " . $row['username'] . " est déja active!<br>";
        header("location: ../forms/usersList.php?errmsg=$errMsg");
        exit;
    }
}
?>