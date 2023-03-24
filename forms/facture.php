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
                    Statistiques des Factures
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
                    <a href="/beauty_store/forms/facture.php?op=addfact" class="btn btn-primary col-md-3">Ajouter
                        Facture</a>
                    <a href="/beauty_store/forms/fournisseur.php?op=factures" class="btn btn-success col-md-3">Liste
                        Factures</a>
                    <a href="/beauty_store/forms/fournisseur.php?op=factpersup" class="btn btn-dark col-md-3">Factures
                        Par Fournisseur</a>
                </div>
                <div class="col-md-10 my-2">
                    <?php
                    if (isset($_GET['op'])) {
                        if ($_GET['op'] == 'addfact') {
                            echo "<form method='post' action='../processing/addFactProcess.php'>
                <div class='form-group row my-3'>
                    <div class='col-md-3'>
                        <label for='name'>Nom de Fournisseur: </label>
                    </div>
                    <div class='col-md-7'>
                        <select name='name' id='name' class='form-control'>
                            <option value='0'>Choisir Fournisseur</option>";
                            $supplierSql = "SELECT * FROM supplier";
                            $supplierResult = $conn->query($supplierSql);
                            while ($supplierRow = $supplierResult->fetch_assoc()) {
                                echo "<option value='" . $supplierRow['id'] . "'>" . $supplierRow['name'] . "</option>";
                            }
                            echo "</select>
                    </div>
                </div>
                <div class='form-group row my-3'>
                    <div class='col-md-3'>
                        <label for='date'>Date: </label>
                    </div>
                    <div class='col-md-7'>
                        <input type='date' class='form-control' id='date' name='date' placeholder='Date Facture'
                            required>
                    </div>
                </div>
                <div class='form-group row my-3'>
                    <div class='col-md-3'>
                        <label for='amount'>Montant: </label>
                    </div>
                    <div class='col-md-7'>
                        <input type='number' class='form-control' id='amount' name='amount' placeholder='Montant' step='0.01'
                            required>
                    </div>
                </div>

                <div class='row text-center'>
                    <div class='col-md-8 m-4'>
                        <button type='submit' class='btn btn-warning'>Ajouter</button>
                    </div>
                </div>
            </form>";
                        } else {
                            echo "<table class='table table-bordered table-responsive'>
                        <tr>";
                            if ($_GET['op'] == 'factures') {
                                echo "<th>Facture</th>";
                            } else if ($_GET['op'] == 'cat') {
                                echo "<th>Catégorie</th>";
                            }
                            echo "<th>Date</th>
                        <th>Montant</th>
                        </tr>
                        ";
                            if ($_GET['op'] == 'factures')
                                $sql = "SELECT * FROM facture";
                            else if ($_GET['op'] == 'cat')
                                $sql = "SELECT * FROM facture";
                            $result = $conn->query($sql);
                            //$totalGenMon = $totalGenProd = 0;
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                // if ($_GET['op'] == 'sub_cat')
                                //     $prod_sql = "SELECT * FROM product WHERE sub_category_id=$id";
                                // else if ($_GET['op'] == 'cat')
                                //     $prod_sql = "SELECT * FROM product WHERE category=$id";
                                // $prod_result = $conn->query($prod_sql);
                                // $totalProd = $totalMon = 0;
                                // while ($prod_row = $prod_result->fetch_assoc()) {
                                //     $totalMon += $prod_row['buying_price'] * $prod_row['quantity'];
                                //     $totalProd += $prod_row['quantity'];
                                // }
                                // $totalGenMon += $totalMon;
                                // $totalGenProd += $totalProd;
                                // $zakat = $totalGenMon / 40;
                                echo "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>0" . $row['tel'] . "</td>
                            <td>" . $row['city'] . "</td>
                            </tr>";
                            }

                            // echo "<tr>
                            //     <th>Total</th>
                            //     <td>$totalGenProd</td>
                            //     <td>$totalGenMon</td>
                            // </tr>
                            // <tr>
                            // <th>Zakat</th>
                            // <td colspan='2' class='text-center'>$zakat</td>
                            // </tr>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
                crossorigin="anonymous"></script>
        <?php }
} ?>