<?php
require '../connection/Db.php';
$status = $_GET['status'];
$id = $_GET['id'];
$requested_order_query = "SELECT * FROM orders WHERE id=$id";
$requested_order_result = $conn->query($requested_order_query);
$requested_order_row = $requested_order_result->fetch_assoc();
if ($status == 'waiting...' && $requested_order_row['status'] == 'completed') {
    $errMsg .= "Désolé vous ne pouvez pas passer de status complète à en attente <br>";
    header("location: ../forms/showOrders.php?errmsg=$errMsg");
    exit;
} elseif ($status == 'done' && $requested_order_row['status'] == 'waiting...') {
    $errMsg .= "Désolé vous ne pouvez pas passer directement de status en attente à fait <br>";
    header("location: ../forms/showOrders.php?errmsg=$errMsg");
    exit;
} elseif (($status == 'completed' && $requested_order_row['status'] == 'waiting...')
    || ($status == 'done' && $requested_order_row['status'] == 'completed')
) {
    $query = "UPDATE orders SET status='$status' WHERE id=$id";
    $result = $conn->query($query);
    if ($result) {
        $sucMsg .= "Status a été mis à jour avec succès <br>";
        header("location: ../forms/showOrders.php?sucmsg=$sucMsg");
    } else {
        $errMsg .= "Une erreur a été produite lors de la mise à jour du status <br>";
        header("location: ../forms/showOrders.php?errmsg=$errMsg");
    }
}
