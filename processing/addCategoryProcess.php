<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $name = $_POST['name'];
    $description = $_POST['description'];
    $all_cats_query = "SELECT * FROM category WHERE name='$name'";
    $all_cats_result = $conn->query($all_cats_query);
    if ($all_cats_result->num_rows == 0) {
        $query = "INSERT INTO category VALUES (null, '$name', '$description')";
        $result = $conn->query($query);
        if ($result) {
            $sucMsg .= "La categorie " . $name . " a été ajouté avec succès<br>";
            header("location: ../forms/addCategory.php?sucmsg=$sucMsg");
            exit;
        } else {
            $errMsg .= "La categorie n est pas inséré <br>";
            header("location: ../forms/addCategory.php?errmsg=$errMsg");
            exit;
        }
    } else {
        $errMsg .= "La categorie " . $name . " existe déja<br>";
        header("location: ../forms/addCategory.php?errmsg=$errMsg");
    }
    $conn->close();
}
