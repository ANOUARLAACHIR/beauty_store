<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $city = $_POST['city'];
    if ($city == '0') {
        $errMsg .= "Choisir une ville SVP! <br>";
        header("location: ../forms/addSupplier.php?errmsg=$errMsg");
        exit;
    } else {
        $all_suppliers_query = "SELECT * FROM supplier WHERE name='$name'";
        $suppliers_result = $conn->query($all_suppliers_query);
        if ($suppliers_result->num_rows == 0) {
            $query = "INSERT INTO supplier VALUES (null, '$name', $tel, '$city')";
            $result = $conn->query($query);
            if ($result) {
                $sucMsg .= "Le fournisseur " . $name . " a été ajouté avec succès<br>";
                header("location: ../forms/addSupplier.php?sucmsg=$sucMsg");
                exit;
            } else {
                $errMsg .= "Le fournisseur n est pas inséré <br>";
                header("location: ../forms/addSupplier.php?errmsg=$errMsg");
                exit;
            }
        } else {
            $errMsg .= "Le fournisseur " . $name . " existe déja<br>";
            header("location: ../forms/addSupplier.php?errmsg=$errMsg");
        }
    }
}