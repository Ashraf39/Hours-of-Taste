<?php
include "connect.php";

if (isset($_POST['recipeId'])) {
    $recipeId = $_POST['recipeId'];

    // Sanitize input to prevent SQL injection
    $recipeId = intval($recipeId);
    
    // Update the likes in the database
    $sql = "UPDATE recipes SET likes = likes + 1 WHERE id = $recipeId";
    if ($conn->query($sql) === TRUE) {
        // Fetch the updated number of likes
        $sql = "SELECT likes FROM recipes WHERE id = $recipeId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo $row['likes'];
        } else {
            echo "0";
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No recipe ID received.";
}

$conn->close();
?>
