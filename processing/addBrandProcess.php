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
    $sub_category_id = $_POST['sub_category'];
    $all_brands_query = "SELECT * FROM brand WHERE name='$name'";
    $all_brands_result = $conn->query($all_brands_query);
    if ($all_brands_result->num_rows == 0) {
        $query = "INSERT INTO brand VALUES (null, '$name', '$description', $category_id, $sub_category_id)";
        $result = $conn->query($query);
        if ($result) {
            $sucMsg .= "La Marque " . $name . " a été ajouté avec succès<br>";
            header("location: ../forms/addBrand.php?sucmsg=$sucMsg");
        } else {
            $errMsg .= "La Marque n est pas inséré <br>";
            header("location: ../forms/addBrand.php?errmsg=$errMsg");
        }
    } else {
        $errMsg .= "La marque " . $name . " existe déja<br>";
        header("location: ../forms/addBrand.php?errmsg=$errMsg");
    }
    $conn->close();
}
