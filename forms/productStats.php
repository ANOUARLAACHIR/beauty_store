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
                    Statistiques des Protuids
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
                    <a href="/beauty_store/forms/productStats.php?op=sub_cat" class="btn btn-primary col-md-3">Par Sous
                        Categorie</a>
                    <a href="/beauty_store/forms/productStats.php?op=cat" class="btn btn-success col-md-3">Par Categorie</a>
                </div>
                <div class="col-md-10 my-2">
                    <?php
                    if (isset($_GET['op'])) {
                        echo "<table class='table table-bordered table-responsive'>
                        <tr>";
                        if ($_GET['op'] == 'sub_cat') {
                            echo "<th>Sous Catégorie</th>";
                        } else if ($_GET['op'] == 'cat') {
                            echo "<th>Catégorie</th>";
                        }
                        echo "<th>Total Produits</th>
                        <th>Total Argent</th>
                        </tr>
                        ";
                        if ($_GET['op'] == 'sub_cat')
                            $sql = "SELECT * FROM sub_category";
                        else if ($_GET['op'] == 'cat')
                            $sql = "SELECT * FROM category";
                        $result = $conn->query($sql);
                        $totalGenMon = $totalGenProd = 0;
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            if ($_GET['op'] == 'sub_cat')
                                $prod_sql = "SELECT * FROM product WHERE sub_category_id=$id";
                            else if ($_GET['op'] == 'cat')
                                $prod_sql = "SELECT * FROM product WHERE category=$id";
                            $prod_result = $conn->query($prod_sql);
                            $totalProd = $totalMon = 0;
                            while ($prod_row = $prod_result->fetch_assoc()) {
                                $totalMon += $prod_row['buying_price'] * $prod_row['quantity'];
                                $totalProd += $prod_row['quantity'];
                            }
                            $totalGenMon += $totalMon;
                            $totalGenProd += $totalProd;
                            echo "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>$totalProd</td>
                            <td>$totalMon</td>
                            </tr>";
                        }

                        echo "<tr>
                            <th>Total</th>
                            <td>$totalGenProd</td>
                            <td>$totalGenMon</td>
                        </tr>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <?php } ?>