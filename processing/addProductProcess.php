<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<?php
require '../connection/Db.php';
$name = $_POST['name'];
$category = $_POST['category'];
$sub_category = $_POST['sub_category'];
$manufacture = $_POST['manufacture'];
$buying_price = $_POST['buying_price'];
$selling_price = $_POST['selling_price'];
$image = $_FILES['image']['name'];
$quantity = $_POST['quantity'];
$buying_date = date('Y-m-d');
$validity = $_POST['validity'];

//uploading images
$target_dir = "../images/products/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $errMsg .= "le Fichier n est pas une image<br>";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $errMsg .= "Désole, l'image existe déja.<br>";
    $uploadOk = 0;
}

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    $errMsg .= "Seulement les formats: JPG, JPEG, PNG & GIF sont autorisés.<br>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errMsg .= "Désolé, l image n est pas telechargé. <br>";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sucMsg .= "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded<br>";
    } else {
        $errMsg .= "Désolé, un problème a occuré durant le telechargement de l image. <br>";
    }
}
$all_prods_query = "SELECT * FROM product WHERE name='$name'";
$all_prods_result = $conn->query($all_prods_query);
if ($all_prods_result->num_rows == 0) {
    $query = "INSERT INTO product VALUES (null, '$name', $category, $sub_category, '$manufacture', $buying_price, $selling_price, $quantity, '$buying_date', '$validity', '$image')";
    if ($uploadOk != 0) {
        if ($conn->query($query) === TRUE) {
            $sucMsg .= "Le Produit " . $name . " a été ajouté avec succès<br>";
            header("location: ../forms/addProduct.php?sucmsg=$sucMsg");
            exit;
        }
    } else {
        $errMsg .= "Le produit n est pas inséré <br>";
        header("location: ../forms/addProduct.php?errmsg=$errMsg");
        exit;
    }
} else {
    $errMsg .= "Le produit " . $name . " existe déja<br>";
    header("location: ../forms/addProduct.php?errmsg=$errMsg");
    exit;
}
$conn->close();
