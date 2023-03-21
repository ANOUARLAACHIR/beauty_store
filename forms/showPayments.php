<?php
session_start();
include '../includes/navbar.php';
include '../connection/Db.php';
if (!isset($_SESSION['username'])) {
    header("location: login.php");
} else {
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <div class="row my-1">
        <div class="col-md-3">
            <?php
            include '../includes/sidebar.php';
            if (isset($_GET['client'])) {
                $client_id = $_GET['client'];
                $client_query = "SELECT * FROM clients WHERE id=$client_id";
                $client_result = $conn->query($client_query);
                $client_row = $client_result->fetch_assoc();

            ?>
        </div>
        <div class="col-md-8">
            <div class="card col-md-12 bg-warning my-4">
                <div class="card-header text-center">
                    Les Paiements de <?php echo $client_row['name'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 my-2">
                    <?php
                    if (isset($_GET['errmsg'])) {
                        echo "<div class='alert alert-danger'>" .
                            $_GET['errmsg'] . "</div>";
                    }
                    if (isset($_GET['sucmsg'])) {
                        echo "<div class='alert alert-success'>" .
                            $_GET['sucmsg'] . "</div>";
                    }
                    ?>
                </div>
            </div>
            <?php
                $query = "SELECT * FROM payment WHERE client_id=$client_id";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
            ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Produit</th>
                            <th>Crédit</th>
                            <th>Montant Payé</th>
                            <th>Reste</th>
                            <th>Date Paiement</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            $credit_id = $row['credit_id'];
                            $credit_query = "SELECT * FROM credit WHERE id=$credit_id";
                            $credit_result = $conn->query($credit_query);
                            if ($credit_result->num_rows > 0) {
                                $credit_row = $credit_result->fetch_assoc();
                                $product_id = $credit_row['product_id'];
                                $find_product_query = "SELECT * FROM product WHERE id=$product_id";
                                $find_product_result = $conn->query($find_product_query);
                                $find_product_row = $find_product_result->fetch_assoc();
                        ?>
                                <tr>
                                    <td><?php echo $client_row['name'] ?></td>
                                    <td><?php echo $find_product_row['name'] ?></td>
                                    <td><?php echo $credit_row['quantity'] * $credit_row['selling_price'] ?></td>
                                    <td><?php echo $row['paid_amount'] ?></td>
                                    <td><?php echo $row['remains'] ?></td>
                                    <td><?php echo $row['payment_date'] ?></td>
                                    <td class="text-center"><a href="" class="btn btn-danger">Delete</a></td>
                                </tr>

                <?php }
                        }
                        echo "</tbody>
                     </table>
                     <a href='/beauty_store/processing/migratePaymentProcess.php?client=$client_id' class='btn btn-outline-dark'>Migrer les Crédits Payés</a>";
                    } else {
                        echo "<div class='card col-md-12 bg-success my-4'>
                        <div class='card-header fw-bold text-light'>
                            Pas de Payement
                        </div>
                    </div>";
                    }
                } ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <?php } ?>