<?php
session_start();
include '../connection/Db.php';
include '../includes/navbar.php';
if (!isset($_SESSION['username'])) {
    header("location: login.php");
} else {
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <div class="row my-2">
        <div class="col-md-3">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <div class="col-md-9 my-4">
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
            <div class="card col-md-10 bg-warning">
                <div class="card-header text-center">
                    Ajouter Produit
                </div>
            </div>
            <form method="post" action="../processing/addProductProcess.php" enctype="multipart/form-data">
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="name">Nom Produit: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom de Produit" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="category">Catégorie : </label>
                    </div>
                    <div class="col-md-7">
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Choisir Catégorie</option>
                            <?php
                            $query = "SELECT * FROM category";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                $category_id = $row['id'];
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="sub_category">Sous Catégorie : </label>
                    </div>
                    <div class="col-md-7">
                        <select name="sub_category" id="sub_category" class="form-control" required>
                            <option>Choisir Catégorie en Premier</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="manufacture">Marque: </label>
                    </div>
                    <div class="col-md-7">
                        <select name="manufacture" id="manufacture" class="form-control" required>
                            <option value="">Choisir Marque</option>
                            <?php
                            $query = "SELECT * FROM brand";
                            $result = $conn->query($query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="buying_price">Prix Achat: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" id="buying_price" name="buying_price" placeholder="Prix Achat" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="image">Image: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="selling_price">Prix Vente: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="selling_price" id="selling_price" placeholder="Prix Vente" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="quantity">Quantite: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantite" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="validity">Expiration: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control" name="validity" id="validity" placeholder="Expiration">
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-md-8 m-4">
                        <button type="submit" class="btn btn-warning">Ajouter</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <?php } ?>
    <script>
        $(document).ready(function() {
            $("#category").on("change", function() {
                var catId = $(this).val();
                if (catId) {
                    $.get(
                        "fetch.php", {
                            category: catId
                        },
                        function(data) {
                            $("#sub_category").html(data);
                        }
                    );
                } else {
                    $('#sub_category').html('<option>Choisir Catégorie en Premier</option>');
                }
            });

            $("#category").on("change", function() {
                var catId = $(this).val();
                if (catId) {
                    $.get(
                        "fetch2.php", {
                            category: catId
                        },
                        function(data) {
                            $("#manufacture").html(data);
                        }
                    );
                } else {
                    $('#manufacture').html('<option>Choisir Catégorie en Premier</option>');
                }
            });
        });
    </script>