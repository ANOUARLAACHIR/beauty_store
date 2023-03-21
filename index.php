<?php
session_start();
include __DIR__ . "/connection/Db.php";
include 'includes/navbar.php';
if (!isset($_SESSION['username'])) {
    header("location: forms/login.php");
} else { ?>
    <div class="row">
        <div class="col-md-3">
            <?php include 'includes/sidebar.php'; ?>
        </div>
        <div class="col-md-9 my-4 row">
            <div class="card col-md-12 bg-warning ">
                <div class="card-header text-center">
                    Tous Produits
                </div>
            </div>

            <div class="col-md-12 my-2">
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

            <?php
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $limit = 8;
            $offset = ($page - 1) * $limit;
            if (isset($_POST['search'])) {
                $search = $_POST['search'];
                $sql = "SELECT * FROM product WHERE name LIKE '%$search%' AND quantity > 0 LIMIT $offset, $limit";
                $count = "SELECT * FROM product WHERE name LIKE '%$search%' AND quantity > 0";
            } else if (isset($_GET['category'])) {
                $category = $_GET['category'];
                $cat_query = "SELECT * FROM category WHERE name='$category'";
                $cat_result = $conn->query($cat_query);
                $row_cat = $cat_result->fetch_assoc();
                $category_id = $row_cat['id'];
                $sql = "SELECT * FROM product WHERE category=$category_id AND quantity > 0 LIMIT $offset, $limit";
                $count = "SELECT * FROM product WHERE category=$category_id AND quantity > 0";
            } else if (isset($_GET['sub_category'])) {
                $sub_category = $_GET['sub_category'];
                $sub_cat_query = "SELECT * FROM sub_category WHERE name='$sub_category'";
                $sub_cat_result = $conn->query($sub_cat_query);
                $row_sub_cat = $sub_cat_result->fetch_assoc();
                $sub_cat_id = $row_sub_cat['id'];
                $sql = "SELECT * FROM product WHERE sub_category_id=$sub_cat_id AND quantity > 0 LIMIT $offset, $limit";
                $count = "SELECT * FROM product WHERE sub_category_id=$sub_cat_id AND quantity > 0";
            } else if (isset($_GET['quantity'])) {
                $quantity = $_GET['quantity'];
                $sql = "SELECT * FROM product WHERE quantity<=$quantity LIMIT $offset, $limit";
                $count = $sql = "SELECT * FROM product WHERE quantity<=$quantity";
            } else if (isset($_GET['brand'])) {
                $brand = $_GET['brand'];
                $brand_query = "SELECT * FROM brand WHERE name='$brand'";
                $brand_result = $conn->query($brand_query);
                $row_brand = $brand_result->fetch_assoc();
                $brand_id = $row_brand['id'];
                $sql = "SELECT * FROM product WHERE manufacture=$brand_id AND quantity > 0 LIMIT $offset, $limit";
                $count = "SELECT * FROM product WHERE manufacture=$brand_id AND quantity > 0";
            } else {
                $sql = "SELECT * FROM product WHERE quantity > 0 LIMIT $offset, $limit";
                $count = "SELECT * FROM product WHERE quantity > 0";
            }
            $result = $conn->query($sql);
            $count_result = $conn->query($count);
            $rows_number = $count_result->num_rows;
            $number_pages = ceil($rows_number / $limit);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card col-md-3 my-2''>
                        <img class='card-img-top' src='images/products/" . $row['image'] . "' alt='" . $row['image'] . "'>
                        <div class='card-body'>
                            <h5 class='card-title' style='" .  "height: 40px;" . "'>" . $row['name'] . "</h5>
                            <div class='card-text text-danger'>Prix: " . $row['selling_price'] . " Dhs</div>
                            <div class='card-text text-success'>Quantité: ";
                    if ($row['quantity'] == 0) echo "<div class='alert alert-danger'>rupture de stock</div>";
                    else echo $row['quantity'];
                    echo "</div>"; ?>
                    <div class='row'>

                        <?php
                        if ($row['quantity'] != 0)
                            echo "
                            <a href='forms/beforeSell.php?product_id=" . $row['id'] . "' class='btn btn-success'>Payé</a>
                            <a href='forms/beforeCredit.php?product_id=" . $row['id'] . "' class='btn btn-warning'>Credit</a>";
                        if ($_SESSION['username'] == 'admin')
                            echo "
                            <a href='forms/updateProduct.php?product_id=" . $row['id'] . "' class='btn btn-dark'>Modifier</a>";
                        echo "</div></div>";
                        ?>
                    </div>
            <?php
                }
            } else {
                echo "
                <div class='col-md-12 text-center'>
                <div class='alert alert-danger'>Il n y a pas de produit</div> 
                </div>";
            } ?>
            <?php
            $conn->close();
            ?>
        </div>
        <div class="row">
            <div class="col-md-12 my-4">
                <ul class="pagination justify-content-center">
                    <?php
                    for ($i = 1; $i <= $number_pages; $i++) {
                        echo "<li class='page-item ";
                        if ($i == $page) echo "disabled";
                        echo "' ><a class='page-link' href='/beauty_store/index.php?page=$i'>" . $i . "</a></li>";
                    } ?>
                </ul>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>