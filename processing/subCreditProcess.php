<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $client = $_POST['client'];
    $paid_amount = $_POST['paid_amount'];
    $find_client_query = "SELECT * FROM clients WHERE name='$client'";
    $find_client_result = $conn->query($find_client_query);
    $find_client_row = $find_client_result->fetch_assoc();
    $client_id = $find_client_row['id'];
    $find_credit_query = "SELECT * FROM credit WHERE client_id=$client_id AND status='credit'";
    $find_credit_result = $conn->query($find_credit_query);
    $total_credit = 0;
    $date = date('Y-m-d');
    if ($find_credit_result)
        while ($row = $find_credit_result->fetch_assoc()) {
            $id = $row['id'];
            if ($paid_amount >= $row['due_amount']) {
                $query = "UPDATE credit SET status='paid', due_amount=0 WHERE id=$id";
                $result = $conn->query($query);
                if ($result) {
                    $payment_query = "INSERT INTO payment VALUES (null, $id, $client_id, $paid_amount, 0, '$date')";
                    $conn->query($payment_query);
                    $paid_amount -= $row['due_amount'];
                    $id_prod = $row['product_id'];
                    $prod_query = "SELECT * FROM product WHERE id=$id_prod";
                    $prod_result = $conn->query($prod_query);
                    $prod_row = $prod_result->fetch_assoc();
                    $sucMsg .= "Le crédit " . $prod_row['name'] . " de montant "
                        . $row['due_amount'] . " Dhs a été payé<br>";
                    header("location: ../forms/showCredit.php?client=$client&sucmsg=$sucMsg");
                } else {
                    $errMsg .= "Une erreur a été survenue<br>";
                    header("location: ../forms/showCredit.php?client=$client&errmsg=$errMsg");
                    exit;
                }
            } else {
                $remains = $row['due_amount'] - $paid_amount;
                $payment_query = "INSERT INTO payment VALUES (null, $id, $client_id, $paid_amount, $remains, '$date')";
                $payment_result = $conn->query($payment_query);
                $query = "UPDATE credit SET due_amount=$remains WHERE id=$id";
                $result = $conn->query($query);
                $id_prod = $row['product_id'];
                $prod_query = "SELECT * FROM product WHERE id=$id_prod";
                $prod_result = $conn->query($prod_query);
                $prod_row = $prod_result->fetch_assoc();
                $sucMsg .= "Le crédit " . $prod_row['name'] . " de montant "
                    . $row['due_amount'] . " Dhs a été soustris de "
                    . $paid_amount . " Dhs<br>";
                header("location: ../forms/showCredit.php?client=$client&sucmsg=$sucMsg");
                exit;
            }
        }
}
