<?php

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeType = $_POST['recipeType'];
    $recipeTitle = $_POST['recipeTitle'];
    $authorName = $_POST['authorName'];
    $recipeDescription = $_POST['recipeDescription'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $recipeImage = $_FILES['recipeImage'];

    // Handle file upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($recipeImage["name"]);
    move_uploaded_file($recipeImage["tmp_name"], $target_file);

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO recipes (recipeType, recipeTitle, authorName, recipeDescription, ingredients, instructions, recipeImage) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $recipeType, $recipeTitle, $authorName, $recipeDescription, $ingredients, $instructions, $target_file);

    // Execute the query
    if ($stmt->execute()) {
        echo "New recipe submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>