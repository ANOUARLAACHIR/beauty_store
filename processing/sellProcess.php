<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $id = $_POST['product_id'];
    $selling_price = $_POST['selling_price'];
    $new_quantity = $_POST['quantity'];
    $query = "SELECT * FROM product WHERE id=$id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'];
    $buying_price = $row['buying_price'];
    $selling_date = date('Y-m-d');
    $revenue = ($selling_price - $buying_price) * $new_quantity;

    //get user
    $user = $_SESSION['username'];
    $userSql = "SELECT * FROM user WHERE username = '$user'";
    $userResult = $conn->query($userSql);
    $userRow = $userResult->fetch_assoc();
    $seller_id = $userRow['id'];

    //Processing
    if ($quantity >= $new_quantity) {
        $insert_query = "INSERT INTO orders VALUES (null, $id, $new_quantity, $buying_price, $selling_price, '$selling_date', $seller_id, $revenue,'waiting...')";
        $insert_result = $conn->query($insert_query);
        if ($insert_result) {
            $quantity -= $new_quantity;
            $update_query = "UPDATE product SET quantity=$quantity WHERE id=$id";
            $update_result = $conn->query($update_query);
            if ($update_result) {
                $sucMsg .= "L ordre a été inséré avec succès<br />";
                $sucMsg .= "La quantité a été mise à jour avec succès<br />";
                header("location: ../index.php?sucmsg=$sucMsg");
                exit();
            } else {
                $errMsg .= "Un problème a été survenu lors de la mise à jour de quantité<br />";
                header("location: ../index.php?errmsg=$errMsg");
                exit();
            }
        } else {
            $errMsg .= "Un problème a été survenu lors de l insertion de l ordre<br />";
            header("location: ../index.php?errmsg=$errMsg");
            exit();
        }
    } else {
        $errMsg .= "La quantité du stock est inférieure à la quantité demandé!<br />";
        header("location: ../index.php?errmsg=$errMsg");
        exit();
    }
}
?>