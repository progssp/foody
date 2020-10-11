<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */
?>
<?php 
    session_start();
    if(empty($_SESSION)){}
    else{
        header("location:/foody/profile.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/foody/css/app.css">
    <title>Foody - Restaurant Register</title>
</head>
<body>
    

<?php require_once('navbar.php'); ?>

    <div class="container">
        <form action="" method="post" id="restaurant_register_frm">
            <input type="hidden" name="ActionToCall" value="restaurant_register"/>

            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-4">Restaurant Register</h1>
                </div>
            </div>

            <div class="form-group">
                <div id="success_msg_alert" class="alert alert-success" style="display:none;"></div>
                <div id="error_msg_alert" class="alert alert-danger" style="display:none;"></div>
                <div id="warning_msg_alert" class="alert alert-warning" style="display:none;"></div>
            </div>

            

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="r_name" class="form-control" required/>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="r_address" class="form-control" required/>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="r_email" class="form-control" required/>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="r_password" class="form-control" required/>
            </div>

            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" name="r_cont_no" class="form-control" required/>
            </div>

            <div class="form-group">
                <label>Food Preference</label>
                <select name="r_food_pref" class="form-control" required>
                    <option value="">Select</option>
                    <option value="veg">Veg</option>
                    <option value="non-veg">Non-veg</option>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary btn-md" />
            </div>
        </form>
    </div>
    
  
    
    
    <!-- js scripting -->
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/foody/js/app.js"></script>
</body>
</html>