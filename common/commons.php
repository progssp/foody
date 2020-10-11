<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */

    /*
    This file accepts all the post request from the js ajax calls
    and decides which condition to execute according to ActionToCall
    value.
    */

    # requiring files
    require_once(__DIR__.'/../controllers/CustomerController.php');
    require_once(__DIR__.'/../controllers/RestaurantController.php');
    require_once(__DIR__.'/../controllers/OrderController.php');
    require_once(__DIR__.'/../controllers/MenuController.php');

    # checking the request is POST and then checking the ActionToCall for
    # correct snippet precossing

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        switch($_POST['ActionToCall']){
            case "customer_register" :
                $customer = new CustomerController();
                echo $customer->customer_register($_POST);
            break;
            
            case "restaurant_register" :                
                $restaurant = new RestaurantController();
                echo $restaurant->restaurant_register($_POST);
            break;

            case "login" :                
                if($_POST['user_type'] == "customer"){
                    $customer = new CustomerController();
                    echo $customer->customer_login($_POST);
                }
                else if($_POST['user_type'] == "restaurant"){                    
                    $restaurant = new RestaurantController();
                    echo $restaurant->restaurant_login($_POST);
                }
            break;

            case "customer_profile_update" :                
                $customer = new CustomerController();
                echo $customer->update($_POST);
            break;

            case "add_menu_item" :                
                $menu = new MenuController();
                echo $menu->add_menu_item($_POST);
            break;

            case "place_order" :             
                $new_order = new OrderController();
                echo $new_order->place_order($_POST);
            break;

            case "update_menu_item" :             
                $update_order = new MenuController();
                echo $update_order->update_menu_item($_POST);
            break;
        }
    }
    // if the request is get then the page is not accessible
    else if($_SERVER['REQUEST_METHOD'] === "GET"){
        echo "You are accessing the wrong page.";
        exit();
    }
    else{
        echo "You are accessing the wrong page.";
        exit();
    }
?>