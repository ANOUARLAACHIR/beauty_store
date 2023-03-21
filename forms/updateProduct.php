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
                    $id = $_GET['product_id'];
                    $query = "SELECT * FROM product WHERE id=$id";
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();
                    ?>
                </div>
            </div>
            <div class="card col-md-10 bg-warning">
                <div class="card-header text-center">
                    Mise à jour du Produit <?php echo "<span class='fw-bold'> " . $row['name'] . "</span>" ?>
                </div>
            </div>
            <form method="post" action="../processing/updateProductProcess.php">
                <input type="number" name="id" value="<?php echo $id ?>" hidden>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="prod_name">Nom Produit: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" name="prod_name" class="form-control" id="prod_name" value="<?php echo $row['name'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="buying_price">Prix Achat: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" id="buying_price" name="buying_price" value="<?php echo $row['buying_price'] ?>" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="selling_price">Prix Vente: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="selling_price" id="selling_price" value="<?php echo $row['selling_price'] ?>" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="quantity">Quantite: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="quantity" id="quantity" value="<?php echo $row['quantity'] ?>" required>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <div class="col-md-3">
                        <label for="validity">Expiration: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="date" class="form-control" name="validity" id="validity" value="<?php echo $row['validity'] ?>">
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