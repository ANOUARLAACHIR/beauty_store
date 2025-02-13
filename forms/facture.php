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
                    <a href="/beauty_store/forms/facture.php?op=factures" class="btn btn-success col-md-3">Liste
                        Factures</a>
                    <a href="/beauty_store/forms/facture.php?op=factpersup" class="btn btn-dark col-md-3">Factures
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
                                echo "<option value=" . $supplierRow['id'] . ">" . $supplierRow['name'] . "</option>";
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
                        } else if ($_GET['op'] == 'factures') {
                            $sql = "SELECT * FROM facture";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered table-responsive'>
                                <tr>
                                <th>Facture</th>
                                <th>Date</th>
                                <th>Montant</th>
                                </tr>
                                ";
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id_supplier'];
                                    $supplier_sql = "SELECT * FROM supplier WHERE id=$id";
                                    $supplier_result = $conn->query($supplier_sql);
                                    $supplier_row = $supplier_result->fetch_assoc();
                                    echo "<tr>
                                    <td>" . $supplier_row['name'] . "</td>
                                    <td>" . $row['date'] . "</td>
                                    <td>" . $row['montant'] . "</td>
                                    </tr>";
                                }
                            } else {
                                echo "<div class='alert alert-danger text-center'>La liste est vide!</div>";
                            }
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