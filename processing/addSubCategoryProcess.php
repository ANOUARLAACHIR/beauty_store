<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category_id = $_POST['category'];

    $all_sub_cats_query = "SELECT * FROM sub_category WHERE name='$name'";
    $all_sub_cats_result = $conn->query($all_sub_cats_query);
    if ($all_sub_cats_result->num_rows == 0) {
        $query = "INSERT INTO sub_category VALUES (null, '$name', '$description', $category_id)";
        $result = $conn->query($query);
        if ($result) {
            $sucMsg .= "La sous categorie " . $name . " a été ajouté avec succès<br>";
            header("location: ../forms/addSubCategory.php?sucmsg=$sucMsg");
            exit;
        } else {
            $errMsg .= "La sous categorie n est pas inséré <br>";
            header("location: ../forms/addSubCategory.php?errmsg=$errMsg");
            exit;
        }
    } else {
        $errMsg .= "La sous categorie " . $name . " existe déja<br>";
        header("location: ../forms/addSubCategory.php?errmsg=$errMsg");
    }
    $conn->close();
}
