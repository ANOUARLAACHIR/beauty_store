<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $client_id = $_GET['client'];
    $query = "SELECT * FROM credit WHERE status='paid'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $buying_price = $row['buying_price'];
            $selling_price = $row['selling_price'];
            $selling_date = $row['selling_date'];
            $seller_id = $row['seller_id'];
            $revenue = $row['revenue'];
            $insert_order_query = "INSERT INTO orders VALUES (null, $product_id, $quantity, $buying_price, $selling_price, '$selling_date', $seller_id, $revenue, 'waiting...')";
            $insert_order_result = $conn->query($insert_order_query);
            if ($insert_order_result) {
                $sucMsg .= "Les Paiements sont migrés avec succès<br>";
                $credit_id = $row['id'];
                $update_credit_query = "UPDATE credit SET status='migrated' WHERE id=$credit_id";
                $conn->query($update_credit_query);
                $sucMsg .= "Le status a été mis à jour à migré<br>";
                header("location: ../forms/showPayments.php?sucmsg=$sucMsg&client=$client_id");
                exit;
            } else {
                $errMsg .= "Une erreur a été produit lors de l'opération<br>";
                header("location: ../forms/showPayments.php?errmsg=$errMsg&client=$client_id");
                exit;
            }
        }
    } else {
        $errMsg .= "Pas de PaIements à migrer<br>";
        header("location: ../forms/showPayments.php?errmsg=$errMsg&client=$client_id");
        exit;
    }
}
