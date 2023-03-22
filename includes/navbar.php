<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Khalil's Beauty Store</title>
</head>

<body>
    <header class="p-3 bg-dark text-white">
        <div>
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="<?php echo "/beauty_store/index.php" ?>"
                    class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    {KBS}
                </a>
                <div class="dropdown mx-2">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Crédits
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <?php
                        include 'Db.php';
                        $credit_query = "SELECT DISTINCT client_id FROM credit WHERE status='credit'";
                        $credit_result = $conn->query($credit_query);
                        if ($credit_result->num_rows > 0) {
                            while ($credit_row = $credit_result->fetch_assoc()) {
                                $client_id = $credit_row['client_id'];
                                $clients_query = "SELECT * FROM clients WHERE id=$client_id";
                                $clients_result = $conn->query($clients_query);
                                if ($clients_result->num_rows > 0) {
                                    while ($row = $clients_result->fetch_assoc()) {
                                        $name = $row['name'];
                                        echo "<li><a class='dropdown-item' href='/beauty_store/forms/showCredit.php?client=$name'>" . $name . "</a></li>";
                                    }
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>

                <div class="dropdown mx-2">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Paiements
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <?php
                        include 'Db.php';
                        $clients_query = "SELECT * FROM clients";
                        $clients_result = $conn->query($clients_query);
                        if ($clients_result->num_rows > 0) {
                            while ($row = $clients_result->fetch_assoc()) {
                                $id = $row['id'];
                                $name = $row['name'];
                                echo "<li><a class='dropdown-item' href='/beauty_store/forms/showPayments.php?client=$id'>" . $name . "</a></li>";
                            }
                        }
                        ?>
                    </ul>
                </div>

                <div class="dropdown mx-2">
                    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Statistiques
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class='dropdown-item' href='/beauty_store/forms/productStats.php'>Produits</a></li>
                    </ul>
                </div>

                <div class="offset-md-4 d-flex">
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="post"
                        action="<?php echo "/beauty_store/index.php" ?>">
                        <input type="search" class="form-control form-control-dark text-white bg-dark" name="search"
                            placeholder="Chercher Produit" aria-label="Search">
                    </form>

                    <div class="text-end">
                        <?php
                        if (!isset($_SESSION['username'])) {
                            echo "<a href='/beauty_store/forms/login.php' class='btn btn-outline-light me-2'>Login</a>";
                        } else {
                            echo "<a href='/beauty_store/processing/logoutProcess.php' class='btn btn-outline-light me-2'>Log Out</a>";
                            echo "<button type='button' class='btn btn-warning'>" . $_SESSION['username'] . "</button>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>