<?php
session_start();
include '../includes/navbar.php';
include '../connection/Db.php';
if (!isset($_SESSION['username'])) {
    header("location: login.php");
} else {
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
    <div class="row my-3">
        <div class="col-md-3">
            <?php include '../includes/sidebar.php'; ?>
        </div>
        <?php
        $id = $_GET['product_id'];
        $sql = "SELECT * FROM product WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        ?>

        <div class="col-md-3 my-4">
            <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>">
        </div>
        <div class="col-md-6 my-4">
            <div class="card col-md-10 bg-warning">
                <div class="card-header text-center">
                    Vendre Produit
                </div>
            </div>
            <form method="post" action="../processing/sellProcess.php" enctype="multipart/form-data">
                <div class="form-group row my-3">
                    <input type="number" class="form-control" id="product_id" name="product_id" value="<?php echo $row['id']; ?>" hidden>
                    <div class="col-md-3">
                        <label for="name">Nom Produit: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" disabled>
                    </div>
                </div>
                <div class="form-group row my-3">
                    <div class="col-md-3">
                        <label for="quantity">Quantité Vendue: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="quantity" id="quantiy" value="1">
                    </div>
                </div>
                <div class="form-group row my-3">
                    <div class="col-md-3">
                        <label for="selling_price">Prix Vente: </label>
                    </div>
                    <div class="col-md-7">
                        <input type="number" class="form-control" name="selling_price" id="selling_price" value="<?php echo $row['selling_price'] ?>">
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-md-10 m-4">
                        <button type="submit" class="btn btn-warning">Vendre</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <?php } ?>