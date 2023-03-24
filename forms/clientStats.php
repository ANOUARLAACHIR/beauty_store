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
                    Statistiques des Clients
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
                    <a href="/beauty_store/forms/clientStats.php?op=fidelity" class="btn btn-primary col-md-3">Fidélité Par
                        Client</a>
                    <a href="/beauty_store/forms/clientStats.php?op=buying" class="btn btn-success col-md-3">Achat Par
                        Client</a>
                </div>
                <div class="col-md-10 my-2">
                    <?php
                    if (isset($_GET['op'])) {
                        $sql = "SELECT * FROM clients";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<table class='table table-bordered table-responsive'>
                            <tr>
                            <th>Client</th>
                            <th>Total Achat</th>
                            <th>Total Gain</th>
                            <th>Points Fidélité</th>
                            </tr>";
                            $totalAchat = $totalGain = 0;
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['id'];
                                $credit_sql = "SELECT * FROM credit WHERE client_id=$id";
                                $credit_result = $conn->query($credit_sql);
                                $totalcredit = $totalMon = 0;
                                while ($credit_row = $credit_result->fetch_assoc()) {
                                    $totalAchat += $credit_row['selling_price'] * $credit_row['quantity'];
                                    $totalGain += $credit_row['revenue'];
                                }
                                $points = $totalGain / 10;
                                echo "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>$totalAchat</td>
                            <td>$totalGain</td>
                            <td>" . $row['fidelity'] . "</td>
                            </tr>";
                            }
                        } else {
                            echo "<div class='alert alert-danger text-center'>Pas de Clients</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <?php } ?>