<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap" rel="stylesheet">
    <style>
        header {
            background: linear-gradient(180deg, rgb(49, 172, 49) 20%, rgb(218, 218, 42) 100%);
            height: 55px;
        }

        body {
            background: linear-gradient(180deg, rgb(218, 218, 42) 10%, rgba(24, 191, 21, 0.9500175070028011) 100%);
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
        .footer {
            padding: 2px 0px;
            margin-top: 470px;
        }
    </style>
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

    <section class="py-5">
        <div class="container">
            <h2 style="text-align: center; color: rgba(0, 0, 0, 0.651);">Edit Profile</h2>
            <?php
            include 'connect.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_email'])) {
                $email = $_POST['email'];

                // Prepare SQL to get the user ID based on the email
                $sql = "SELECT id, firstName, lastName, email FROM users WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    // Fetch the user details
                    $row = $result->fetch_assoc();
                    $userId = $row['id'];
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    ?>

                    <!-- Display the form to update user information -->
                    <form method="POST" action="">
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                        <div class="form-group">
                            <label for="fName">First Name:</label>
                            <input type="text" class="form-control" id="fName" name="fName" value="<?php echo $firstName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lName">Last Name:</label>
                            <input type="text" class="form-control" id="lName" name="lName" value="<?php echo $lastName; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_info" style="margin:0 40%; color: white;box-shadow:0 20px 35px rgba(0,0,1,0.9);">Save Changes</button>
                    </form>

                    <?php
                } else {
                    echo "User with the provided email not found";
                }

                $stmt->close();
            } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
                // Handle the form submission to update user information
                $userId = $_POST['userId'];
                $fName = $_POST['fName'];
                $lName = $_POST['lName'];
                $email = $_POST['email'];
                $password = md5($_POST['password']); // Encrypt the password using md5

                // Prepare SQL and bind parameters to update user information
                $stmt = $conn->prepare("UPDATE users SET firstName=?, lastName=?, email=?, pass=? WHERE id=?");
                $stmt->bind_param("ssssi", $fName, $lName, $email, $password, $userId);

                // Execute the query
                if ($stmt->execute()) {
                    echo "Profile information updated successfully";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                // Display the initial form to ask for the email
                ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="email">Enter your email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="check_email" style="margin:0 40%; color: white;box-shadow:0 20px 35px rgba(0,0,1,0.9);">Check Email</button>
                </form>
                <?php
            }

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
