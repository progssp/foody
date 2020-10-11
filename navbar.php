<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */
?>

<!-- navbar -->
<nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/foody">FOODY</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="nav nav-tabs"> 
                    <li class="nav-item">
                        <a class="nav-link" href="/foody/browse_restaurants.php">Browse Restaurants</a>
                    </li>
                </ul>

                
                <ul class="nav nav-tabs">
                    <?php if(empty($_SESSION)){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/foody/login.php">Login</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Register
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/foody/customer_register.php">Customer Register</a>
                            <a class="dropdown-item" href="/foody/restaurant_register.php">Restaurant Register</a>
                        </div>
                    </li>
                    <?php } ?>

                    <?php if(!empty($_SESSION)){ ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="foodshala_images/def_prof_photo.jpg" style="width:20px;" alt="..." class="rounded-circle">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/foody/profile.php">
                            <?php if($_SESSION['user_type'] == "customer"){echo $_SESSION['c_name'];}else{echo $_SESSION['r_name'];} ?></a>
                            <a class="dropdown-item" href="/foody/logout.php">Logout</a>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            
            </div>
        </div>
    </nav>