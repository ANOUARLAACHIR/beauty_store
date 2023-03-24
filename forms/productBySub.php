<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
} else {
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <?php include '../includes/navbar.php'; ?>
    <div class="row my-1">
        <div class="col-md-3">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <div class="col-md-9 my-4">
            <div class="card col-md-10 bg-warning">
                <div class="card-header text-center">
                    <?php
                    $id = $_GET['sub_cat'];
                    $sub_sql = "SELECT * FROM sub_category WHERE id=$id";
                    $sub_result = $conn->query($sub_sql);
                    $sub_row = $sub_result->fetch_assoc();
                    echo "Liste des " . $sub_row['name'];
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 my-2">
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
            <div class="row">
                <div class="col-md-10 my-2">
                    <?php
                    $prod_sql = "SELECT * FROM product WHERE sub_category_id=$id";
                    $prod_result = $conn->query($prod_sql);
                    if ($prod_result->num_rows > 0) {
                        echo "<table class='table table-bordered table-responsive'>
                        <tr>
                        <th>Nom</th>
                        <th>Prix Achat</th>
                        <th>Prix Vente</th>
                        <th>Quantité</th>
                        <th>Date Achat</th>
                        <th>Validité</th>
                        <th>Image</th>
                        <th>Total</th>
                        </tr>
                        ";
                        $total = 0;
                        $nbrProds = 0;
                        while ($row = $prod_result->fetch_assoc()) {
                            $total += $row['quantity'] * $row['buying_price'];
                            $totalRow = $row['quantity'] * $row['buying_price'];
                            $nbrProds += $row['quantity'];
                            echo "<tr>
                            <td ";
                            if ($row['quantity'] <= 2)
                                echo "class='bg-danger' style='color: white;'";
                            else if ($row['quantity'] <= 4)
                                echo "class='bg-warning'";
                            echo ">" . $row['name'] . "</td>
                            <td>" . $row['buying_price'] . "</td>
                            <td>" . $row['selling_price'] . "</td>
                            <td>" . $row['quantity'] . "</td>
                            <td>" . $row['buying_date'] . "</td>
                            <td>" . $row['validity'] . "</td>
                            <td><img src='/beauty_store/images/products/" . $row['image'] . "' width='40' height='40'></td>
                            <td>$totalRow</td>
                            </tr>";
                        }

                        echo "<tr style='font-size: 24px'>
                        <th colspan=2>Nombre Produits:</th>
                        <td colspan=2 class='text-center'>" . $nbrProds . "</td>
                        <th colspan=2>Total:</th>
                        <td colspan=2 class='text-center'>" . $total . "</td>
                        </tr>";
                    } else {
                        echo "<div class='alert alert-danger'>Pas de Produits pour cette catégorie</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <?php } ?>