<?php
require 'Db.php';
?>
<div class="flex-shrink-0 p-3 bg-light" style="width: 280px;">
    <a href="<?php __DIR__  ?>" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
        <svg class="bi pe-none me-2" width="30" height="24">
            <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-5 fw-semibold">Dashboard</span>
    </a>
    <ul class="list-unstyled ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                Produit
            </button>
            <div class="collapse show" id="home-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <?php
                    if (isset($_SESSION['username']))
                        if ($_SESSION['username'] == 'admin')
                            echo "<li><a href='/beauty_store/forms/addProduct.php' class='link-dark d-inline-flex text-decoration-none rounded'>Ajouter Produit</a></li>";
                    ?>
                    <li><a href="<?php echo "/beauty_store/index.php" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Tous Produits</a></li>
                    <li><a href="<?php echo "/beauty_store/index.php?quantity=0" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Rupture Stock</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                Categorie
            </button>
            <div class="collapse" id="dashboard-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <?php
                    if (isset($_SESSION['username']))
                        if ($_SESSION['username'] == 'admin')
                            echo "<li><a href='/beauty_store/forms/addCategory.php' class='link-dark d-inline-flex text-decoration-none rounded'>Ajouter Categorie</a></li>";
                    $query = "SELECT * FROM category";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0)
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><a href='/beauty_store/index.php?category=" . $row['name'] . "' class='link-dark d-inline-flex text-decoration-none rounded'>" . $row['name'] . "</a></li>";
                        } ?>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#subcat-collapse" aria-expanded="false">
                Sous Categorie
            </button>
            <div class="collapse" id="subcat-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <?php
                    if (isset($_SESSION['username']))
                        if ($_SESSION['username'] == 'admin')
                            echo "<li><a href='/beauty_store/forms/addSubCategory.php' class='link-dark d-inline-flex text-decoration-none rounded'>Ajouter Sous Categorie</a></li>";
                    $query = "SELECT * FROM sub_category";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0)
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><a href='/beauty_store/index.php?sub_category=" . $row['name'] . "' class='link-dark d-inline-flex text-decoration-none rounded'>" . $row['name'] . "</a></li>";
                        } ?>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#brand-collapse" aria-expanded="false">
                Marque
            </button>
            <div class="collapse" id="brand-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <?php
                    if (isset($_SESSION['username']))
                        if ($_SESSION['username'] == 'admin')
                            echo "<li><a href='/beauty_store/forms/addBrand.php' class='link-dark d-inline-flex text-decoration-none rounded'>Ajouter Marque</a></li>";
                    $query = "SELECT * FROM brand";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0)
                        while ($row = $result->fetch_assoc()) {
                            echo "<li><a href='/beauty_store/index.php?brand=" . $row['name'] . "' class='link-dark d-inline-flex text-decoration-none rounded'>" . $row['name'] . "</a></li>";
                        } ?>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
                Orders
            </button>
            <div class="collapse" id="orders-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="<?php echo "/beauty_store/forms/showOrders.php" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Toutes Ordres</a></li>
                    <?php
                    if (isset($_SESSION['username'])) {
                        $user = $_SESSION['username'];
                        echo "<li><a href='/beauty_store/forms/showOrders.php?user=$user' class='link-dark d-inline-flex text-decoration-none rounded'>Mes Ordres</a></li>";
                    }
                    ?>
                    <li><a href="<?php echo "/beauty_store/forms/showOrders.php?status=done" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Done</a></li>
                    <li><a href="<?php echo "/beauty_store/forms/showOrders.php?year=2022" ?>" class="link-dark d-inline-flex text-decoration-none rounded">2O22</a></li>
                    <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Returned</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#clients-collapse" aria-expanded="false">
                Client
            </button>
            <div class="collapse" id="clients-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="<?php echo "/beauty_store/forms/addClient.php" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Ajouter Client</a></li>
                    <li><a href='<?php echo "/beauty_store/forms/showCredit.php" ?>' class='link-dark d-inline-flex text-decoration-none rounded'>Afficher les Crédits</a></li>
                    <li><a href="<?php echo "/beauty_store/forms/showCredit.php?status=paid" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Payé</P></a></li>
                    <li><a href="<?php echo "/beauty_store/forms/showCredit.php?status=credit" ?>" class="link-dark d-inline-flex text-decoration-none rounded">Non Payé</a></li>
                </ul>
            </div>
        </li>
        <li class="border-top my-3"></li>
        <li class="mb-1">
            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                Account
            </button>
            <div class="collapse" id="account-collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="<?php echo "/beauty_store/forms/addUser.php"; ?>" class="link-dark d-inline-flex text-decoration-none rounded">Ajouter Utilisateur</a></li>
                    <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Profile</a></li>
                    <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Settings</a></li>
                    <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Sign out</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>