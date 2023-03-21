<?php
session_start();
require '../connection/Db.php';
$id = $_POST['product_id'];
$selling_price = $_POST['selling_price'];
$new_quantity = $_POST['quantity'];
$client_id = $_POST['client_id'];
$query = "SELECT * FROM product WHERE id=$id";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$quantity = $row['quantity'];
$buying_price = $row['buying_price'];
$selling_date = date('Y-m-d');
$revenue = ($selling_price - $buying_price) * $new_quantity;
$seller_name = $_SESSION['username'];
$seller_query = "SELECT * FROM user WHERE username='$seller_name'";
$seller_result = $conn->query($seller_query);
$seller_row = $seller_result->fetch_assoc();
$seller_id = $seller_row['id'];
$due_amount = $new_quantity * $selling_price;
$quantity -= $new_quantity;
$insert_query = "INSERT INTO credit VALUES (null, $client_id, $id, 
    $new_quantity, $buying_price, $selling_price, '$selling_date', $due_amount, $revenue, 
    $seller_id, 'credit')";
$insert_result = $conn->query($insert_query);
if ($insert_result) {
    $update_query = "UPDATE product SET quantity=$quantity WHERE id=$id";
    $update_result = $conn->query($update_query);
    $sucMsg .= "Le Crédit a été inséré avec succès<br />";
    $sucMsg .= "La quantité a été mise à jour avec succès<br />";
    header("location: ../index.php?sucmsg=$sucMsg");
    exit;
} else {
    $errMsg .= "Un problème a été survenu lors de l'insertion du crédit<br />";
    header("location: ../index.php?errmsg=$errMsg");
    exit;
}
