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
                    Ajouter Fournisseur
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
            <form method="post" action="../processing/addSupplierProcess.php">
                <div class="form-group row my-3">
                    <div class="col-md-3">
                        <label for="name">Nom de Fournisseur: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de Fournisseur"
                            required>
                    </div>
                </div>
                <div class="form-group row my-3">
                    <div class="col-md-3">
                        <label for="Tel">Téléphone: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" id="tel" name="tel" placeholder="Numéro de Téléphone"
                            required>
                    </div>
                </div>
                <div class="form-group row my-3">
                    <div class="col-md-3">
                        <label for="city">Ville: </label>
                    </div>
                    <div class="col-md-7">
                        <select name="city" id="city" class="form-control">
                            <option value="0">Choisir Ville</option>
                            <option value="sale">Sale</option>
                            <option value="casa">Casa</option>
                        </select>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-md-8 m-4">
                        <button type="submit" class="btn btn-warning">Ajouter</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <?php } ?>