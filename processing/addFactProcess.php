<?php
require '../connection/Db.php';
$supplier_id = $_POST['name'];
$date = $_POST['date'];
$amount = $_POST['amount'];
$sql = "INSERT INTO facture VALUES (null, $supplier_id, $amount, '$date')";
$result = $conn->query($sql);
if ($result) {
    $sucMsg .= "Une Facture du Montant " . $amount . " a été ajouté avec succès<br>";
    header("location: ../forms/facture.php?op=addfact&sucmsg=$sucMsg");
    exit;
} else {
    $errMsg .= "Une erreur à été occurée!<br>";
    header("location: ../forms/facture.php?op=addfact&errmsg=$errMsg");
    exit;
}