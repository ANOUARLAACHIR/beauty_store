<?php
include '../connection/Db.php';
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category_id = $_GET['category'];
    $query = "SELECT * FROM brand WHERE category_id=$category_id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    } else {
        echo "<option>Pas de Marque</option>";
    }
}
