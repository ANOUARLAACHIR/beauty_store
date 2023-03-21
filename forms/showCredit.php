<?php
session_start();
include '../includes/navbar.php';
include '../connection/Db.php';
if (!isset($_SESSION['username'])) {
    header("location: login.php");
} else {
    $status = "";
    $total = $total_credit = $total_client = 0;
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <div class="row my-1">
        <div class="col-md-3">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <div class="col-md-8">
            <div class="card col-md-12 bg-warning my-4">
                <div class="card-header text-center">
                    <?php
                    if (isset($_GET['status'])) {
                        if ($_GET['status'] == 'paid')
                            echo "Crédits Payés";
                        else
                            echo "Crédits Non Payés";
                    } else if (isset($_GET['client'])) {
                        echo $_GET['client'] . " Crédit";
                    } else
                        echo "Tous les Crédits"
                    ?>
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
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
                $sql = "SELECT * FROM credit WHERE status='$status'";
            } else if (isset($_GET['client'])) {
                $client = $_GET['client'];
                $client_query = "SELECT * FROM clients WHERE name='$client'";
                $client_result = $conn->query($client_query);
                $client_row = $client_result->fetch_assoc();
                $client_id = $client_row['id'];
                $sql = "SELECT * FROM credit WHERE client_id=$client_id AND status='credit'";
            } else
                $sql = "SELECT * FROM credit";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix Achat</th>
                            <th>prix Vente</th>
                            <th>Date Vente</th>
                            <th>Vendeur</th>
                            <th>Gain</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            if (isset($status)) {
                                if ($row['status'] == 'credit')
                                    $total_credit += ($row['selling_price'] * $row['quantity']);
                                if (isset($_GET['client']))
                                    if ($client_id == $row['client_id'] && $row['status'] != 'paid')
                                        $total_client += $row['due_amount'];
                            }
                            $total += $row['selling_price'];
                            $client_id = $row['client_id'];
                            $client_query = "SELECT * FROM clients WHERE id=$client_id";
                            $client_result = $conn->query($client_query);
                            $client_row = $client_result->fetch_assoc();
                            $product_id = $row['product_id'];
                            $product_query = "SELECT * FROM product WHERE id=$product_id";
                            $product_result = $conn->query($product_query);
                            $product_row = $product_result->fetch_assoc();
                            $seller_id = $row['seller_id'];
                            $seller_query = "SELECT * FROM user WHERE id=$seller_id";
                            $seller_result = $conn->query($seller_query);
                            $seller_row = $seller_result->fetch_assoc();
                        ?>
                            <tr>
                                <td><?php echo $client_row['name'] ?></td>
                                <td><?php echo $product_row['name'] ?></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td><?php echo $row['buying_price'] ?></td>
                                <td><?php echo $row['selling_price'] ?></td>
                                <td><?php echo $row['selling_date'] ?></td>
                                <td><?php echo $seller_row['username'] ?></td>
                                <td><?php echo $row['revenue'] ?></td>
                                <td>
                                    <form action="<?php echo "/beauty_store/processing/changeStatusProcessCredit.php" ?>" class=" form-group">
                                        <input type="number" value="<?php echo $row['id'] ?>" name="id" hidden>
                                        <select name="status" id="status" onchange="this.form.submit()" class="form-control">
                                            <option value="credit" <?php if ($row['status'] == 'credit') echo "selected" ?>>Crédit</option>
                                            <option value="paid" <?php if ($row['status'] != 'credit') echo "selected" ?>>Payé</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                        if ($status == 'credit')
                            echo "<tr>
                            <td colspan='4' class='fw-bold fs-4 text-center'>Total:</td>
                            <td colspan='5' class='fw-bold fs-4 text-center'>" . $total_credit . " Dhs";
                        "</tr>";
                        if (isset($_GET['client']))
                            echo "<tr>
                            <td colspan='4' class='fw-bold fs-4 text-center'>Total:</td>
                            <td colspan='5' class='fw-bold fs-4 text-center'>" . $total_client . " Dhs
                        </tr>";
                        ?>

                    </tbody>
                </table>
            <?php
                if (isset($_GET['client'])) {
                    $client = $_GET['client'];
                    echo "<form action='../processing/subCreditprocess.php' method='post'>
                        <div class='form-group row'>
                        <input type='text' name='client' value='" . $client . "' hidden>
                        <div class='col-md-3'>
                        <label for='paid_amount'>Montant Payé</label>
                        </div>
                        <div class='col-md-7'>
                        <input type='number' step='0.5' class='form-control' name='paid_amount'>
                        </div>
                        <div class='col-md-2'>
                        <button type='submit' class='btn btn-warning'>Payer</button>
                        </div>
                        </div>
                    </form> ";
                }
            } else {
                echo "<div class='alert alert-danger fw-bold'>Il n'y a pas de crédit pour le moment!</div>";
            }

            if (isset($_GET['client'])) {
                echo "<a href='showPayments.php?client=" . $client_id . "' class='btn btn-outline-dark'>Afficher Paiements</a>";
            }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <?php } ?>