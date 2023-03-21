<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../forms/login.php");
} else {
    require '../connection/Db.php';
    $id = $_POST['id'];
    $name = $_POST['prod_name'];
    $buying_price = $_POST['buying_price'];
    $selling_price = $_POST['selling_price'];
    $quantity = $_POST['quantity'];
    $validity = $_POST['validity'];
    $buying_date = date('Y-m-d');
    if ($quantity <= 0) {
        $errMsg .= "La quantité n'est pas valide<br>";
        header("location: ../forms/updateProduct.php?errmsg=$errMsg&product_id=$id");
        exit;
    } else if ($buying_price >= $selling_price) {
        $errMsg .= "Le prix de vente doit etre superieur à celui d'achat<br>";
        header("location: ../forms/updateProduct.php?errmsg=$errMsg&product_id=$id");
        exit;
    } else {
        $query = "UPDATE product SET buying_price=$buying_price, 
        selling_price=$selling_price, quantity=$quantity, 
        buying_date='$buying_date', validity='$validity' WHERE id=$id";
        $result = $conn->query($query);
        if ($result) {
            $sucMsg .= "Le produit " . $name . " a été mis à jour avec succès!<br>";
            header("location: ../forms/updateProduct.php?sucmsg=$sucMsg&product_id=$id");
            exit;
        } else {
            $errMsg .= "Une erreur a été survenu lors de la mise à jour!<br>";
            header("location: ../forms/updateProduct.php?sucmsg=$sucMsg&product_id=$id");
            exit;
        }
    }
}
