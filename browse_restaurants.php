<?php
    require_once(__DIR__.'/controllers/RestaurantController.php');
    session_start();

    // getting all restaurant from menu controller
    $res = new RestaurantController();
    $restaurant_list = $res->get_all_restaurant();
    $restaurant_list = json_decode($restaurant_list,true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/foody/css/app.css">
    <title>Foody - Browse restaurants</title>
</head>
<body>

    <?php require_once(__DIR__.'/navbar.php'); ?>

    <?php if(($restaurant_list['status'])){
        $restaurant_list = $restaurant_list['extra_data'];
    ?>
        <div class="container">
            <?php foreach($restaurant_list as $rest){?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header"><?php echo $rest['r_name']; ?></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <?php if($rest['r_food_preference'] === "veg"){?>
                                            <h5>Food prefernce </h5>
                                            <img src="/foody/foodshala_images/veg_imag.jpg" width="25"/>
                                            <h6>Veg</h6>
                                        <?php } else { ?>
                                            <h5>Food preference </h5>
                                            <img src="/foody/foodshala_images/non_veg_imag.jpg"  width="25"/>
                                            <h6>Non Veg</h6>
                                        <?php } ?>
                                    </div>
                                </div>
                                
                                <br/>
                                <div class="row">
                                    <div class="col-md-8" style="margin:5px;">
                                        <h5>Address</h5>
                                        <h6><?php echo $rest['r_address']; ?></h6>
                                    </div>
                                    <div class="col-md" style="margin:5px;">
                                        <h5>Contact no</h5>
                                        <h6><?php echo $rest['r_country_code'].''.$rest['r_cont_no']; ?></h6>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">                                    
                                    <br/>
                                    <div class="col-lg" style="margin:5px;">
                                        <button type="button" class="btn">
                                            Parking available <span class="badge badge-light"><i class="fa fa-car" aria-hidden="true"></i></span>
                                            <span class="sr-only">unread messages</span>
                                        </button>
                                    </div>
                                    <div class="col-lg" style="margin:5px;">
                                        <button type="button" class="btn">
                                            Wifi available <span class="badge badge-light"><i class="fa fa-wifi" aria-hidden="true"></i></span>
                                            <span class="sr-only">unread messages</span>
                                        </button>
                                    </div><div class="col-lg" style="margin:5px;">
                                        <button type="button" class="btn">
                                            Easy payment <span class="badge badge-light"><i class="fa fa-money" aria-hidden="true"></i></span>
                                            <span class="sr-only">unread messages</span>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="card-footer" style="margin-top:10px;">
                                    <?php if(empty($_SESSION)){?>
                                        <a href="/foody/restaurant.php?view_r_id=<?php echo $rest['r_id']; ?>" class="btn btn-success btn-md">View</a>
                                    <?php } else{ if($_SESSION['user_type'] === "restaurant"){ ?>                                        
                                        <a href="/foody/restaurant.php?view_r_id=<?php echo $rest['r_id']; ?>" class="btn btn-success btn-md">View</a>
                                    <?php } else{?>
                                        <a href="/foody/restaurant.php?view_r_id=<?php echo $rest['r_id']; ?>" class="btn btn-success btn-md">Order food</a>
                                    <?php } } ?>
                                </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    
    
    
    <?php
    } else { ?>
        <div>No restaurants found</div>
    <?php } ?>
    


    <!-- js scripting -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/foody/js/app.js"></script>
</body>
</html>