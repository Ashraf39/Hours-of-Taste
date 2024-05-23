<?php
session_start();
include("connect.php");

$recipeId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($recipeId == 0) {
    echo "<p>Invalid recipe ID.</p>";
    exit;
}

// Fetch likes for the recipe
$sql_likes = "SELECT likes FROM recipes WHERE id = ?";
$stmt_likes = $conn->prepare($sql_likes);
$stmt_likes->bind_param("i", $recipeId);
$stmt_likes->execute();
$result_likes = $stmt_likes->get_result();
$likes = 0;
if ($result_likes->num_rows > 0) {
    $row_likes = $result_likes->fetch_assoc();
    $likes = $row_likes['likes'];
}
$stmt_likes->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        header {
            background: linear-gradient(0deg, rgba(229, 236, 64, 0.9612219887955182) 100%, rgba(252, 151, 0, 0.966) 40%);
            height: 55px;
        }
        body {
            background: linear-gradient(180deg, rgba(229, 236, 64, 0.9612219887955182) 10%, rgba(252, 151, 0, 0.966) 100%);
        }

        #t1 {
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
            color:rgba(0, 0, 0, 0.651);
        }

        .navbar {
            background: transparent !important;
        }
        
        .navbar-dark .navbar-nav .nav-link {
            color: rgba(0, 0, 0, 0.651);
            font-weight: bold;
        }
        
        .navbar-dark .navbar-brand {
            color: rgba(0, 0, 0, 0.651);
            font-weight: bold;
        }
        .footer {
            padding: 2px 0;
            margin-top: 320px;
        }

        .back-icon {
            font-size: 24px;
            margin-bottom: 20px;
            display: inline-block;
        }

        .like-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .like-section .likes-count {
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .like-section .like-icon {
            font-size: 24px;
            cursor: pointer;
            margin-left: 10px;
        }

        .like-section .like-icon .likes-number {
            margin-left: 5px;
            font-size: 18px;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeIcon = document.querySelector('.like-icon');
        
        likeIcon.addEventListener('click', function() {
            const recipeId = this.getAttribute('data-id');
            
            fetch('like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `recipeId=${recipeId}`
            })
            .then(response => response.text())
            .then(likes => {
                document.querySelector('.likes-number').textContent = likes;
            })
            .catch(error => console.error('Error:', error));
        });
    });
    </script>
</head>
<body>
    <header>
        <div class="container">
            <h1 class="text-center" id="t1">Hours of Taste</h1>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="browse.php">Browse Recipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="submit.html">Submit Recipe</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Profile
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="edit.php">Edit Profile</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="py-5">
        <div class="container">
            <a href="browse.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <div class="like-section">
                <div class="likes-count">
                    <i class="fas fa-heart" data-id="<?php echo $recipeId; ?>"> </i>
                    <span class="likes-number"><?php echo $likes; ?></span>
                </div>
            </div>
            <?php
            // Fetch the recipe details from the database
            $sql = "SELECT * FROM recipes WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $recipeId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $recipeTitle = $row["recipeTitle"];
                    $authorName = $row["authorName"];
                    $recipeImage = $row["recipeImage"];
                    $ingredients = explode(',', $row["ingredients"]);
                    $instructions = explode(',', $row["instructions"]);

                    echo '<div class="card mb-4">
                            <img src="' . htmlspecialchars($recipeImage) . '" class="card-img-top" alt="Recipe Image">
                            <div class="card-body">
                                <h2 class="card-title">' . htmlspecialchars($recipeTitle) . '</h2>
                                <p class="card-text">Author: ' . htmlspecialchars($authorName) . '</p>
                                <h3>Ingredients</h3>
                                <ul class="list-group">';
                    foreach ($ingredients as $ingredient) {
                        echo '<li class="list-group-item">' . htmlspecialchars($ingredient) . '</li>';
                    }
                    echo '</ul>
                                <h3>Instructions</h3>
                                <ol class="list-group">';
                    foreach ($instructions as $instruction) {
                        echo '<li class="list-group-item">' . htmlspecialchars($instruction) . '</li>';
                    }
                    echo '</ol>
                            </div>
                        </div>';
                }
            } else {
                echo "<p>No recipe found.</p>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </section>

    <footer class="footer bg-dark text-white text-center">
        <div class="container">
            <p>&copy; 2024 Hours of Taste</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
