<?php
require '../connection/Db.php';
$status = $_GET['status'];
$id = $_GET['id'];
$requested_credit_query = "SELECT * FROM credit WHERE id=$id";
$requested_credit_result = $conn->query($requested_credit_query);
$requested_credit_row = $requested_credit_result->fetch_assoc();
if ($status == 'paid' && $requested_credit_row['status'] != 'credit') {
    $errMsg .= "Désolé ce crédit est déja payé <br>";
    header("location: ../forms/showCredit.php?errmsg=$errMsg");
    exit;
} else if ($status == 'credit' && $requested_credit_row['status'] != 'credit') {
    $errMsg .= "Désolé ce crédit est déja payé <br>";
    header("location: ../forms/showCredit.php?errmsg=$errMsg");
    exit;
} else {
    $query = "UPDATE credit SET status='$status' WHERE id=$id";
    $result = $conn->query($query);
    if ($result) {
        $client_id = $requested_credit_row['client_id'];
        $paid_amount = $requested_credit_row['due_amount'];
        $date = date('Y-m-d');
        $insert_payment_query = "INSERT INTO payment VALUES (null, $id, $client_id, $paid_amount, 0, '$date')";
        $conn->query($insert_payment_query);
        $sucMsg .= "Le crédit a été payé avec succès <br>";
        header("location: ../forms/showCredit.php?sucmsg=$sucMsg");
        exit;
    } else {
        $errMsg .= "Une erreur a été produite lors de la mise à jour du status <br>";
        header("location: ../forms/showCredit.php?errmsg=$errMsg");
        exit;
    }
}
