<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */
?>
<?php
    require_once(__DIR__.'/database/dbs_controls.php');
    require_once(__DIR__.'/controllers/MenuController.php');
    require_once(__DIR__.'/controllers/OrderController.php');
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
    else{
        header("location:/foody/login.php");
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/foody/css/app.css">
    <title><?php if($_SESSION['user_type'] == "customer"){echo $_SESSION['c_name'];}else{echo $_SESSION['r_name'];} ?></title>
</head>
<body>
    <?php require_once(__DIR__.'/navbar.php'); ?>
    

    
    <?php if($_SESSION['user_type'] == "restaurant"){?>
        <div class="container" style="margin-top:50px;">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                
                <li class="nav-item">
                    <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-menu" role="tab" aria-controls="pills-profile" aria-selected="true">Update Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-order-history" role="tab" aria-controls="pills-profile" aria-selected="true">Orders</a>
                </li>
                
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-menu" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <?php 
                    $menu = new MenuController();
                    $result_menu = $menu->get_menu($result['r_id']);
                    if($result_menu['status']){
                        $menu_items = $result_menu['extra_data'];?>
                        <table border="1" cellspacing="10" cellpadding="10" style="width:100%;">
                            <thead>
                                <tr>
                                <th width="20%" style="text-align:center;">Item name</th>
                                <th width="20%" style="text-align:center;">Item type</th>
                                <th width="20%" style="text-align:center;">Item price</th>
                                <th width="20%" style="text-align:center;">Item measurment</th>
                                <th width="20%" style="text-align:center;">Controls</th>
                                </tr>
                            </thead>
                        <?php
                        foreach($menu_items as $indi_menu){?>
                            <form action="" method="post" class="update_menu_frm" id="update_menu_item_frm_<?php echo $indi_menu['item_id']; ?>">
                                <input type="hidden" name="ActionToCall" value="update_menu_item" />
                                <input type="hidden" name="r_id" value="<?php echo $_SESSION['r_id']; ?>" />
                                <input type="hidden" name="item_id" value="<?php echo $indi_menu['item_id']; ?>" />
                                <tr>
                                
                                    <td>
                                        <input type="text" name="item_name" required class="form-control" value="<?php echo $indi_menu['item_name']; ?>" />
                                    </td>
                                    <td>
                                        <select class="form-control" name="item_type" required>
                                            <option value="veg" <?php echo ($indi_menu['item_type'] == "veg")?'selected':''; ?>>veg</option>
                                            <option value="non-veg" <?php echo ($indi_menu['item_type'] == "non-veg")?'selected':''; ?>>non-veg</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="item_price" required class="form-control" value="<?php echo $indi_menu['item_price']; ?>" />
                                    </td>
                                    <td>
                                        <select class="form-control" name="item_measurment" required>
                                            <option value="" <?php echo isset($indi_menu['item_measurment'])?'':'selected'; ?>>select</option>
                                            <option value="kg" <?php echo ($indi_menu['item_measurment'] == "kg")?'selected':''; ?>>kg</option>
                                            <option value="unit" <?php echo ($indi_menu['item_measurment'] == "unit")?'selected':''; ?>>unit</option>
                                            <option value="plate" <?php echo ($indi_menu['item_measurment'] == "plate")?'selected':''; ?>>plate</option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <img style="display:none;" src="/foody/foodshala_images/loader.gif" id="loader_<?php echo $indi_menu['item_id'] ?>" width="30"/>
                                        <button type="submit" class="btn btn-primary btn-sm"><span title="update"><i class="fa fa-pencil" aria-hidden="true"></i></span></button>
                                    </td>
                                
                                </tr>
                            </form>
                        <?php } ?>
                        </table>
                        <?php 
                    }
                    else{
                        echo "no menu is there.";
                    }
                    ?>

                    <!-- dynamic form for adding menu items -->
                    <div class="row" style="margin-top:50px;">
                        <div class="col-md-12">
                            <button onclick="add_form()" class="btn btn-secondary btn-sm">Add items</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post" id="add_menu_item_frm" style="display:none;">
                                <div class="form-group">
                                    <div id="success_msg_alert" class="alert alert-success" style="display:none;"></div>
                                    <div id="error_msg_alert" class="alert alert-danger" style="display:none;"></div>
                                    <div id="warning_msg_alert" class="alert alert-warning" style="display:none;"></div>
                                </div>
                                <input type="hidden" name="ActionToCall" value="add_menu_item" />
                                <input type="hidden" name="r_id" value="<?php echo $result['r_id']; ?>" />
                                <div id="form_el_container" class="row"></div>
                                <input type="submit" class="btn btn-success btn-sm"/>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-order-history" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <?php
                        $orders = new OrderController();
                        $order_details = $orders->get_orders_for_restaurant($_SESSION['r_id']);
                        if($order_details['status']){?>
                            
                            <?php
                            foreach($order_details['extra_data'] as $indi_order){?>
                                <div class="card" style="margin-top:20px;box-shadow:0 0 10px rgba(0,0,0,0.12);">
                                    <div class="card-header">Order summary</div>
                                    <div class="card-body">
                                        <div><b>Order id</b><br/><?php echo $indi_order['o_id']; ?></div><br/>
                                        <div><b>Customer Name</b><br/><?php echo $indi_order['c_name']; ?></div><br/>
                                        <div><b>Customer Email</b><br/><?php echo $indi_order['c_email']; ?></div><br/>
                                        <div><b>Customer Phone no</b><br/><?php echo $indi_order['c_country_code'].''.$indi_order['c_cont_no']; ?></div><br/>
                                        
                                        <div><b>Order description</b><br/>
                                            <?php 
                                                //echo $indi_order['o_desc'];
                                                $desc = json_decode($indi_order['o_desc'],true);
                                                foreach($desc as $d){
                                                    echo "<b>Item title</b> : ".$d['item_title'].
                                                    ",\t <b>Item price</b> : ".$d['item_price'].
                                                    ",\t <b>Item type</b> : ".$d['item_type'].
                                                    ",\t <b>Item qty</b> : ".$d['item_qty'].
                                                    "<br/>";
                                                }
                                                    
                                            ?>
                                        </div><br/>
                                        <div><b>Order Amount</b><br/><?php echo $indi_order['o_amt']; ?></div><br/>
                                        <div><b>Order Date</b><br/><?php echo date('Y-m-d h:i a',strtotime($indi_order['o_date'])); ?></div>
                                    </div>
                                </div>   
                            <?php } ?>
                                
                        <?php
                        }
                        else{
                            echo "no orders";
                        }
                    ?>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="container" style="margin-top:50px;">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                
                <li class="nav-item">
                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-menu" role="tab" aria-controls="pills-profile" aria-selected="true">Update Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-order" role="tab" aria-controls="pills-profile" aria-selected="true">Order History</a>
                </li>
                
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-menu" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <form action="" method="post" id="customer_profile_update_frm">
                        <input type="hidden" name="ActionToCall" value="customer_profile_update"/>
                        <input type="hidden" name="c_id" value="<?php echo isset($result['c_id'])?$result['c_id']:0; ?>"/>

                        <div class="jumbotron jumbotron-fluid">
                            <div class="container">
                                <h1 class="display-4">Update Profile</h1>
                            </div>
                        </div>

                        <div class="form-group">
                            <div id="success_msg_alert" class="alert alert-success" style="display:none;"></div>
                            <div id="error_msg_alert" class="alert alert-danger" style="display:none;"></div>
                            <div id="warning_msg_alert" class="alert alert-warning" style="display:none;"></div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="c_name" value="<?php echo isset($result['c_name'])?$result['c_name']:''; ?>" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="c_email" value="<?php echo isset($result['c_email'])?$result['c_email']:''; ?>" class="form-control" readonly required/>
                        </div>

                        <div class="form-group">
                            <label>Mobile Number</label>
                            <input type="text" name="c_cont_no" value="<?php echo isset($result['c_cont_no'])?$result['c_cont_no']:''; ?>" class="form-control" required/>
                        </div>

                        <div class="form-group">
                            <label>Food Preference</label>
                            <select name="c_food_pref" class="form-control" required>
                                <option value="" <?php echo isset($result['c_food_preference'])?'':'selected'; ?>>Select</option>
                                <option value="veg" <?php echo ($result['c_food_preference']!=="" && $result['c_food_preference']=="veg")?'selected':''; ?>>Veg</option>
                                <option value="non-veg" <?php echo ($result['c_food_preference']!=="" && $result['c_food_preference']=="non-veg")?'selected':''; ?>>Non-veg</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-primary btn-md" />
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-order" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <?php
                        $orders = new OrderController();
                        $order_details = $orders->get_orders_for_customer($_SESSION['c_id']);
                        if($order_details['status']){?>
                            
                            <?php
                            foreach($order_details['extra_data'] as $indi_order){?>

                                <div class="card" style="margin-top:20px;box-shadow:0 0 10px rgba(0,0,0,0.12);">
                                    <div class="card-header">Order summary</div>
                                    <div class="card-body">
                                        <div><b>Order id</b><br/><?php echo $indi_order['o_id']; ?></div><br/>
                                        <div><b>Restaurant Name</b><br/><?php echo $indi_order['r_name']; ?></div><br/>
                                        <div><b>Restaurant Email</b><br/><?php echo $indi_order['r_email']; ?></div><br/>
                                        <div><b>Restaurant Phone no</b><br/><?php echo $indi_order['r_country_code'].''.$indi_order['r_cont_no']; ?></div><br/>
                                        <div><b>Restaurant Address</b><br/><?php echo $indi_order['r_address']; ?></div><br/>
                                        <div><b>Order description</b><br/>
                                            <?php 
                                                //echo $indi_order['o_desc'];
                                                $desc = json_decode($indi_order['o_desc'],true);
                                                foreach($desc as $d){
                                                    echo "<b>Item title</b> : ".$d['item_title'].
                                                    ",\t <b>Item price</b> : ".$d['item_price'].
                                                    ",\t <b>Item type</b> : ".$d['item_type'].
                                                    ",\t <b>Item qty</b> : ".$d['item_qty'].
                                                    "<br/>";
                                                }
                                                    
                                            ?>
                                        </div><br/>
                                        <div><b>Order Amount</b><br/><?php echo $indi_order['o_amt']; ?></div><br/>
                                        <div><b>Order Date</b><br/><?php echo date('Y-m-d h:i a',strtotime($indi_order['o_date'])); ?></div>
                                    </div>
                                </div>                                   
                            <?php } ?>
                        <?php
                        }
                        else{
                            echo "no orders";
                        }
                    ?>
                </div>
            </div>

            
        </div>
    <?php } ?>




    



    <!-- js scripting -->
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/foody/js/app.js"></script>
</body>
</html>