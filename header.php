<!-- Header section of the page -->
<!DOCTYPE html>
<html lang="en">
<?php  $BrowTitles = $BrowTitle; ?>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?php echo $BrowTitles; ?> - My Website</title>
    <!-- MDB icon -->
    <link rel="icon" href="./img/mdb-favicon.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="./css/mdb.min.css" />

    <link rel="stylesheet" href="./css/ratings.css" />

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light center">
        <!-- Container wrapper -->
        <div class="container">
            <!-- Navbar brand -->
            <a class="navbar-brand me-2" href="./index.php">
                <img src="https://shotcoder.com/wp-content/uploads/2021/05/ShotCoder-Logo-Small.png" height="40" alt=""
                    loading="lazy" style="margin-top: -1px;" />
            </a>

            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <!-- Left links -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-right: 40px;">
                    <li class="nav-item">
                        <a class="nav-link active" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./search.php">Advance Search</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./browseimage.php">Browse Image</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./browsepost.php">Browse Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="./aboutus.php">About Us</a>
                    </li>
                </ul>
                <!-- Left links -->

                <div class="d-flex align-items-center">
                    <?php if(isset($_SESSION['user']))
                    {
                        echo "<a href='./favourite.php'><button type='button' class='btn btn-primary me-3'>
                        Favourites
                    </button></a>
                    <a href='./logout.php'><button type='button' class='btn btn-primary me-3'>
                        Logout
                    </button></a>";
                    }
                    else{
                    ?>
                    <a href="./login.php"><button type="button" class="btn btn-primary me-3">
                        Login
                    </button></a>
                    <a href="./signup.php"><button type="button" class="btn btn-primary me-3">
                        Sign up
                    </button></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>