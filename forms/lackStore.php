<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
} else {
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <?php
    include '../includes/navbar.php';
    include '../connection/Db.php';
    ?>
    <div class="row my-1">
        <div class="col-md-3">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <div class="col-md-8">
            <div class="card col-md-12 bg-warning my-4">
                <div class="card-header text-center">
                    Rupture Stock
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
            $total = 0;
            $sql = "SELECT * FROM product WHERE quantity=0";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
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
                            if ($row['status'] == 'completed') $total += $row['revenue'];
                            $product_id = $row['product_id'];
                            $prod_sql = "SELECT * FROM product WHERE id=$product_id";
                            $prod_result = $conn->query($prod_sql);
                            $prod_row = $prod_result->fetch_assoc();
                        ?>
                            <tr>
                                <td><?php echo $prod_row['name'] ?></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td><?php echo $row['buying_price'] ?></td>
                                <td><?php echo $row['selling_price'] ?></td>
                                <td><?php echo $row['selling_date'] ?></td>
                                <td><?php echo $row['seller_id'] ?></td>
                                <td><?php echo $row['revenue'] ?></td>
                                <td>
                                    <form action="<?php echo "/beauty_store/processing/changeStatusProcess.php" ?>" class=" form-groupe">
                                        <input type="number" value="<?php echo $row['id'] ?>" name="id" hidden>
                                        <select name="status" id="status" onchange="this.form.submit()">
                                            <option value="waiting..." <?php if ($row['status'] == 'waiting...') echo "selected" ?>>Waiting...</option>
                                            <option value="completed" <?php if ($row['status'] == 'completed') echo "selected" ?>>Completed</option>
                                            <option value="done" <?php if ($row['status'] == 'done') echo "selected" ?>>Done</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3" class="fw-bold fs-4 text-center">Total:</td>
                            <td colspan="5" class="fw-bold fs-4 text-center"><?php echo $total; ?>Dhs</td>
                        </tr>
                    </tbody>
                </table>
            <?php
            } else {
                echo "<div class='alert alert-danger fw-bold'>Il n'y a pas d'ordre pour en attente le moment!</div>";
            }
            ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <?php } ?>