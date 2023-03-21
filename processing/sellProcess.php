    <?php
    require '../connection/Db.php';
    $id = $_POST['product_id'];
    $selling_price = $_POST['selling_price'];
    $new_quantity = $_POST['quantity'];
    $query = "SELECT * FROM product WHERE id=$id";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'];
    if ($quantity > 0) $quantity -= $new_quantity;
    $update_query = "UPDATE product SET quantity=$quantity WHERE id=$id";
    $update_result = $conn->query($update_query);
    $buying_price = $row['buying_price'];
    $selling_date = date('Y-m-d');
    $revenue = ($selling_price - $buying_price) * $new_quantity;
    //make it dynamic
    $seller_id = 2;
    $insert_query = "INSERT INTO orders VALUES (null, $id, $new_quantity, $buying_price, $selling_price, '$selling_date', $seller_id, $revenue,'waiting...')";
    $insert_result = $conn->query($insert_query);
    if ($update_result && $insert_result) {
        $sucMsg .= "L ordre a été inséré avec succès<br />";
        $sucMsg .= "La quantité a été mise à jour avec succès<br />";
        header("location: ../index.php?sucmsg=$sucMsg");
    } else {
        $errMsg .= "Un problème a été survenu lors de l insertion de l ordre<br />";
        $errMsg .= "Un problème a été survenu lors de la mise à jour de quantité<br />";
        header("location: ../index.php?errmsg=$errMsg");
    }
    ?>