<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */
?>
<?php
    require_once(__DIR__.'/database/dbs_controls.php');
?>

<?php
    session_start();
    if(!empty($_SESSION)){
        //print_r($_SESSION);
        if($_SESSION['user_type'] == "restaurant"){
            $r_email = $_SESSION['r_email'];
            $r_id = $_SESSION['r_id'];
            $dbs = new DatabaseControls();
            $qry = "select * from restaurant where r_email = '".$r_email."' and r_id = '".$r_id."'";
            $result = $dbs->run_select_qry($qry);
            $result = $result['extra_data'];
        }
        else if($_SESSION['user_type'] == "customer"){
            $c_email = $_SESSION['c_email'];
            $c_id = $_SESSION['c_id'];
            $dbs = new DatabaseControls();
            $qry = "select * from customer where c_email = '".$c_email."' and c_id = '".$c_id."'";
            $result = $dbs->run_select_qry($qry);
            $result = $result['extra_data'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/foody/css/app.css">
    <title>Foody - Home</title>
</head>
<body>
    <?php require_once('navbar.php'); ?>


    <?php if(empty($_SESSION)){?>
    <div class="jumbotron" style="text-align:center;">
        <h1 class="display-4">Welcome to FOODY!</h1>
        <h4>Delicious food. Great experience.</h4>
        <p class="lead"></p>
        <hr class="my-4">
        <p>Please Login/Register to continue...</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="/foody/login.php" role="button">Login</a>
            <a class="btn btn-primary btn-lg" href="/foody/customer_register.php" role="button">Customer Register</a>
            <a class="btn btn-primary btn-lg" href="/foody/restaurant_register.php" role="button">Restaurant Register</a>
        </p>
    </div>
    <?php 
    } else {
        if($_SESSION['user_type'] === "restaurant"){ ?>
          <div class="jumbotron" style="text-align:center;">
                <h1 class="display-4">Welcome to FOODY <?php echo $result['r_name']; ?>!</h1>
                <h4>Delicious food. Great experience.</h4>
                <p class="lead"></p>
                <hr class="my-4">
                <p>You can manage menu dashboard and view orders</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/foody/profile.php" role="button">Profile</a>
                </p>
            </div>  
        <?php } else { ?>
            <div class="jumbotron" style="text-align:center;">
                <h1 class="display-4">Welcome to FOODY <?php echo $result['c_name']; ?>!</h1>
                <h4>Delicious food. Great experience.</h4>
                <p class="lead"></p>
                <hr class="my-4">
                <p>You can view restaurants and order tasty food and view past orders</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="/foody/profile.php" role="button">Profile</a>
                    <a class="btn btn-primary btn-lg" href="/foody/browse_restaurants.php" role="button">Browse restaurants</a>
                </p>
            </div>
        <?php } ?>
    <?php } ?>
    

    
    
    
    
    
    
    
    
    
    
    
    <!-- js scripting -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/foody/js/app.js"></script>
</body>
</html>