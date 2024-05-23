<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipeId = intval($_POST['recipeId']);

    // Delete the recipe from the database
    $sql = "DELETE FROM recipes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo 'success';
    } else {
        echo 'failure';
    }

    $stmt->close();
    $conn->close();
}
?>
