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
                    Factures de Mr.
                    <?php
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM supplier";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    echo $row['name']; ?>
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
                    $factSql = "SELECT * FROM facture WHERE id_supplier=$id";
                    $factRes = $conn->query($factSql);
                    if ($factRes->num_rows > 0) {
                        echo "<table class='table table-bordered table-responsive'>
                        <tr>";

                        echo "<th>Facture</th>
                        <th>Montant</th>
                        <th>Date</th>
                        </tr>
                        ";
                        while ($row = $factRes->fetch_assoc()) {
                            $i = 1;
                            echo "<tr>
                            <td>$i</td>
                            <td>" . $row['montant'] . "</td>
                            <td>" . $row['date'] . "</td>
                            </tr>";
                            $i++;
                        }
                    } else {
                        echo "<div class='alert alert-danger text-center'>Pas de Facture à L'instant</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <?php } ?>