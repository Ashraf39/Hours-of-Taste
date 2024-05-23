<?php
include "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Recipes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeButtons = document.querySelectorAll('.like-btn');
        
        likeButtons.forEach(button => {
            button.addEventListener('click', function() {
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
                    this.nextElementSibling.textContent = likes;
                })
                .catch(error => console.error('Error:', error));
            });
        });

        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const recipeId = this.getAttribute('data-id');
                const card = this.closest('.card');
                
                fetch('delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `recipeId=${recipeId}`
                })
                .then(response => response.text())
                .then(result => {
                    if (result === 'success') {
                        card.remove();
                    } else {
                        alert('Failed to delete recipe.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
    </script>
    <style>
        header {
            background: linear-gradient(180deg, rgb(49, 172, 49) 20%, rgb(218, 218, 42) 100%);
            height: 55px;
        }
        body {
            background: linear-gradient(180deg, rgb(218, 218, 42) 10%, rgb(49, 172, 49) 90%);
        }

        #t1 {
            font-family: "Poetsen One", sans-serif;
            font-weight: 400;
            font-style: normal;
            color: rgba(0, 0, 0, 0.651);
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

        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card {
            width: 100%;
            max-width: 265px;
            padding-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 20px 35px rgba(0, 0, 1, 0.9);
            margin-bottom: 30px;
        }

        .footer {
            padding: 2px 0;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .centered-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        .btn-primary {
            display: block;
            margin: 10px auto;
        }

        .like-btn, .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
        }

        .like-btn {
            color: #e74c3c;
        }

        .like-btn:hover {
            color: #c0392b;
        }

        .delete-btn {
            color: #e74c3c;
        }

        .delete-btn:hover {
            color: #c0392b;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 70px;
}
    </style>
</head>
<body>
    <header>
        <div class="container" id="t1">
            <h1 class="text-center">Hours of Taste</h1>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
    <section class="py-5 centered-section">
        <div class="container">
            <h2 class="text-center" style="margin-bottom: 5%; color:rgba(0, 0, 0, 0.651);">Browse Recipes</h2>
            <div class="row card-container">
            <?php
                $sql = "SELECT id, recipeTitle, authorName, recipeImage, likes FROM recipes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $recipeId = $row["id"];
                        $recipeTitle = $row["recipeTitle"];
                        $authorName = $row["authorName"];
                        $recipeImage = $row["recipeImage"];
                        $likes = $row["likes"];
                        
                        echo '<div class="col-md-4">
                                <div class="card">
                                    <img src="' . htmlspecialchars($recipeImage) . '" class="card-img-top" alt="Recipe Image">
                                    <div class="card-body">
                                        <h5 class="card-title">' . htmlspecialchars($recipeTitle) . '</h5>
                                        <p class="card-text">Author: ' . htmlspecialchars($authorName) . '</p>
                                        <div class="btn-container">
                                            <button class="like-btn" data-id="' . $recipeId . '"><i class="fas fa-heart"></i></button>
                                            <span class="likes-count">' . $likes . '</span>
                                            <button class="delete-btn" data-id="' . $recipeId . '"><i class="fas fa-trash-alt"></i></button>
                                        </div>
                                        <a href="recipe.php?id=' . $recipeId . '" class="btn btn-primary">View Recipe</a>
                                    </div>
                                </div>
                              </div>';
                    }
                } else {
                    echo "<p>No recipes found.</p>";
                }
                $conn->close();
                ?>
            </div>
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
