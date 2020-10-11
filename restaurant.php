<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */
?>
<?php
    require_once(__DIR__.'/database/dbs_controls.php');

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
    else{}
    
    $view_r_id = (int)$_REQUEST['view_r_id'];
    if(isset($view_r_id) && $view_r_id !== '' && $view_r_id!==0){        
        // getting restaurant details
        $qry = "select * from restaurant where r_id = ".$view_r_id;
        $dbs = new DatabaseControls();
        $view_r_details = $dbs->run_select_qry($qry);
        if($view_r_details['status']){
        $view_r_details = $view_r_details['extra_data'];}
        else{header("location:/foody");}

        // getting that restaurant's menu details
        $qry = "select * from menu_item where r_id = ".$view_r_id;
        $view_r_menu_details = $dbs->run_multi_data_select_qry($qry);
        $view_r_menu_details = $view_r_menu_details['extra_data'];


    }
    else{
        header("location:/foody");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/foody/css/app.css">
    <title><?php echo $view_r_details['r_name']; ?></title>
</head>
<body>
    <?php require_once('navbar.php'); ?>


    <div class="container" style="margin-bottom:200px;">
        <?php foreach($view_r_menu_details as $menu_item){ ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="margin:10px 5px;padding:15px 10px;box-shadow:0 0 10px rgba(0,0,0,0.12);">
                        <div clss="card-body">                        
                            <div id="<?php echo $menu_item['item_id']; ?>_main">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div style="font-size:20px;" id="<?php echo $menu_item['item_id']; ?>_title"><?php echo $menu_item['item_name']; ?></div>
                                        <div id="<?php echo $menu_item['item_id']; ?>_price"><?php echo $menu_item['item_price']; ?></div>
                                        <div id="<?php echo $menu_item['item_id']; ?>_measurment">per <?php echo $menu_item['item_measurment']; ?></div>
                                        <div id="<?php echo $menu_item['item_id']; ?>_type"><?php echo $menu_item['item_type']; ?></div>
                                    </div>
                                    <?php if((empty($_SESSION)) || ((!empty($_SESSION) && $_SESSION['user_type'] === "customer"))){ ?>
                                    <div class="col-md">
                                        <br/>
                                        <h6>Qty</h6>
                                        <button type="button" class="btn btn-primary btn-md" id="<?php echo $menu_item['item_id']; ?>_dec_btn" onclick="dec_qty(this)">-</button>
                                        <input type="text" style="width:50px;height:35px;margin-top:1px;text-align:center;" readonly value="0" id="<?php echo $menu_item['item_id']; ?>_qty_box" />
                                        <button type="button" class="btn btn-primary btn-md" id="<?php echo $menu_item['item_id']; ?>_inc_btn" onclick="inc_qty(this)">+</button>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <textarea rows="5" cols="50" style="display:none;width:100%;font-size:20px;" type="text" id="items_to_order_box"></textarea>
    </div>
    <div style="width:100%;color:white;font-size:22px;padding:5px;background-color:rgba(56,100,200,1.0);text-align:center;position:fixed;bottom:0;">       
        <?php if(empty($_SESSION)){ ?>
            <div>You need to be logged in to place order</div>
            <a href="/foody/login.php" class="btn btn-secondary btn-md">Login</a>
        <?php } else if(!empty($_SESSION) && $_SESSION['user_type'] === "restaurant"){ ?>
            <div>You need to be logged in as customer to place order</div>
        <?php } else { ?>
            <div>Total amount</div>
            <div>Rs.</div><div id="total_amt_div">0</div>
            <button type="button" class="btn btn-success btn-lg" id="place_order_btn" onclick="place_order()">Place order</button>
        <?php } ?>
    </div>


<div class="modal fade" id="reply_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="display:none;" class="alert alert-success" id="success_msg_alert"></div>
                <div style="display:none;" class="alert alert-danger" id="error_msg_alert"></div>
                <div style="display:none;" class="alert alert-warning" id="warning_msg_alert"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <!-- js scripting -->
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/foody/js/app.js"></script>

    <script>
        var outer_arr = [];
        var inner_arr = {};
        var is_item_found = 0;
        var index_at_found = 0;
        var total_amt = 0;

        function inc_qty(evt){
            //console.log(evt.id);
            var id = evt.id;
            var sub = id.indexOf("_");
            var sub_str = id.substr(0,sub);
            //console.log(sub+" , "+sub_str);
            var cur_qty = parseInt($("#"+sub_str+"_qty_box").val()) + 1;
            $("#"+sub_str+"_qty_box").val(cur_qty);

            var cur_title = $("#"+sub_str+"_title").html();
            var cur_price = $("#"+sub_str+"_price").html();
            var cur_measurment = $("#"+sub_str+"_measurment").html();
            var cur_type = $("#"+sub_str+"_type").html();
            //console.log(cur_title+" at "+cur_price+" "+cur_measurment+" which is "+cur_type);

            if(outer_arr.length > 0){
                for(var i=0;i<outer_arr.length;i++){
                    if(outer_arr[i].item_title == cur_title){
                        is_item_found = 1;
                        index_at_found = i;
                        break;
                    }
                }
                if(is_item_found == 1){
                    console.log("index changing : " +index_at_found);
                    outer_arr[index_at_found].item_qty = cur_qty;
                }
                else{
                    inner_arr.item_title = cur_title;
                    inner_arr.item_price = cur_price;
                    inner_arr.item_measurment = cur_measurment;
                    inner_arr.item_type = cur_type;
                    inner_arr.item_qty = cur_qty;

                    outer_arr.push(inner_arr);
                    inner_arr = {};
                }
            }
            else{
                inner_arr.item_title = cur_title;
                inner_arr.item_price = cur_price;
                inner_arr.item_measurment = cur_measurment;
                inner_arr.item_type = cur_type;
                inner_arr.item_qty = cur_qty;

                outer_arr.push(inner_arr);
                inner_arr = {};
            }

            
            total_amt = 0;
            for(var i=0;i<outer_arr.length;i++){
                total_amt += (outer_arr[i].item_price * outer_arr[i].item_qty);
            }


            cur_title = null;
            cur_price = null;
            cur_measurment = null;
            cur_type = null;
            cur_qty = null;
            
            is_item_found = 0;
            index_at_found = 0;
            //finally show details in window
            $("#items_to_order_box").val(JSON.stringify(outer_arr));
            $("#total_amt_div").html(total_amt);
            //console.log("size of outer_arr : "+outer_arr.length);
            //console.log(total_amt);
        }

        function dec_qty(evt){
            //console.log(evt.id);
            var id = evt.id;
            var sub = id.indexOf("_");
            var sub_str = id.substr(0,sub);
            //console.log(sub+" , "+sub_str);
            var cur_qty = parseInt($("#"+sub_str+"_qty_box").val()) - 1;
            if(cur_qty < 0){
                alert("Qty cannot be less than zero");$("#"+sub_str+"_qty_box").val('0');
            }
            else{
                $("#"+sub_str+"_qty_box").val(cur_qty);
            }
            

            var cur_title = $("#"+sub_str+"_title").html();
            var cur_price = $("#"+sub_str+"_price").html();
            var cur_measurment = $("#"+sub_str+"_measurment").html();
            var cur_type = $("#"+sub_str+"_type").html();
            //console.log(cur_title+" at "+cur_price+" "+cur_measurment+" which is "+cur_type);

            if(outer_arr.length > 0){
                for(var i=0;i<outer_arr.length;i++){
                    if(outer_arr[i].item_title == cur_title){
                        is_item_found = 1;
                        index_at_found = i;
                        break;
                    }
                }
                if(is_item_found == 1){
                    
                    console.log("index changing : " +index_at_found);
                    if(cur_qty == 0){
                        outer_arr.splice(index_at_found,1);
                    }
                    else{
                        outer_arr[index_at_found].item_qty = cur_qty;
                    }
                }
            }

            total_amt = 0;
            for(var i=0;i<outer_arr.length;i++){
                total_amt += (outer_arr[i].item_price * outer_arr[i].item_qty);
            }

            cur_title = null;
            cur_price = null;
            cur_measurment = null;
            cur_type = null;
            cur_qty = null;
            is_item_found = 0;
            index_at_found = 0;
            
            //finally show details in window
            $("#items_to_order_box").val(JSON.stringify(outer_arr));
            $("#total_amt_div").html(total_amt);
        }

        function place_order(){
            var final_amt = parseFloat($("#total_amt_div").html());
            if(final_amt <= 0){alert('order amount cannot be zero');return false;}
            
            var final_order_desc = $("#items_to_order_box").val();
            final_order_desc = JSON.stringify(final_order_desc);
            var final_amt = parseFloat($("#total_amt_div").html());
            
            var fd = new FormData();
            fd.append('ActionToCall','place_order');
            fd.append('c_id',<?php echo isset($_SESSION['c_id'])?$_SESSION['c_id']:''; ?>);
            fd.append('r_id',<?php echo (int)$view_r_id ?>);
            fd.append('order_desc',final_order_desc);
            fd.append('order_amt',final_amt);

            $.ajax({
                url:window.location.origin+'/foody/common/commons.php',
                type:'POST',
                data : fd,
                dataType : 'json',
                encode : true,
                contentType: false,
                cache: false,
                processData:false,
                success:function(r){
                    console.log(r);
                    if(r.status == true){
                        $("#success_msg_alert").html("order successfully placed");
                        $("#success_msg_alert").show();
                        $("#error_msg_alert").hide();
                        $("#warning_msg_alert").hide();

                        $("#reply_modal").modal({
                            keyboard:false,
                            backdrop:false
                        });

                        setTimeout(function(){
                            window.location.reload();
                        },1200);
                    }
                    else{                        
                        $("#error_msg_alert").html("order placing error. try again later.");
                        $("#error_msg_alert").show();
                        $("#success_msg_alert").hide();
                        $("#warning_msg_alert").hide();

                        $("#reply_modal").modal({
                            keyboard:false,
                            backdrop:false
                        });
                    }
                },
                error:function(err){ 
                    
                    $("#warning_msg_alert").html("server error. try again later.");
                        $("#warning_msg_alert").show();
                        $("#error_msg_alert").hide();
                        $("#success_msg_alert").hide();

                        $("#reply_modal").modal({
                            keyboard:false,
                            backdrop:false
                        });
                }
            });
        }
    </script>


</body>
</html>