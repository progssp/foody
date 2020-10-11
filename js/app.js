var url_to_request = window.location.origin+"/foody/common/commons.php";

if(document.getElementById('customer_register_frm') == null){}
else{
    document.getElementById('customer_register_frm').addEventListener('submit',function(e){
        e.preventDefault();
        
        $.ajax({
            url:url_to_request,
            type:'POST',
            data        : new FormData(this), // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true,
            contentType: false,
            cache: false,
            processData:false,
            success:function(r){
                //console.log(r);
                if(r.status == true){
                    $("#customer_register_frm #success_msg_alert").html("Successfully registered");
                    $("#customer_register_frm #success_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#customer_register_frm #success_msg_alert").fadeOut();
                    },1300);
                    window.location.href=window.location.origin + "/foody/login.php";
                }
                else{
                    $("#customer_register_frm #error_msg_alert").html("Error. Try again later");
                    $("#customer_register_frm #error_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#customer_register_frm #error_msg_alert").fadeOut();
                    },1300);
                }
            },
            error:function(err){ 
                //console.error(err);               
                $("#customer_register_frm #warning_msg_alert").html("Server internal error.");
                $("#customer_register_frm #warning_msg_alert").fadeIn();
                setTimeout(function(){
                    $("#customer_register_frm #warning_msg_alert").fadeOut();
                },1300);
            }
        });
    });
}

if(document.getElementById('restaurant_register_frm') == null){}
else{
    document.getElementById('restaurant_register_frm').addEventListener('submit',function(e){
        e.preventDefault();
        
        $.ajax({
            url:url_to_request,
            type:'POST',
            data        : new FormData(this), // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true,
            contentType: false,
            cache: false,
            processData:false,
            success:function(r){
                //console.log(r);
                if(r.status == true){
                    $("#restaurant_register_frm #success_msg_alert").html("successfully registered");
                    $("#restaurant_register_frm #success_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#restaurant_register_frm #success_msg_alert").fadeOut();
                    },1300);
                    
                    window.location.href=window.location.origin + "/foody/login.php";
                }
                else{
                    $("#restaurant_register_frm #error_msg_alert").html("Error. Try again later");
                    $("#restaurant_register_frm #error_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#restaurant_register_frm #error_msg_alert").fadeOut();
                    },1300);
                }
            },
            error:function(err){ 
                //console.error(err);               
                $("#restaurant_register_frm #warning_msg_alert").html("Server internal error.");
                $("#restaurant_register_frm #warning_msg_alert").fadeIn();
                setTimeout(function(){
                    $("#restaurant_register_frm #warning_msg_alert").fadeOut();
                },1300);
            }
        });
    });
}

if(document.getElementById('login_frm') == null){}
else{
    document.getElementById('login_frm').addEventListener('submit',function(e){
        e.preventDefault();
        
        $.ajax({
            url : url_to_request,
            type:'POST',
            data        : new FormData(this), // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true,
            contentType: false,
            cache: false,
            processData:false,
            success:function(r){
                //console.log(r);
                if(r.status == true){
                    $("#login_frm #success_msg_alert").html(r.msg);
                    $("#login_frm #success_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#login_frm #success_msg_alert").fadeOut();
                    },1300);
                    window.location.href = "/foody";
                }
                else{
                    $("#login_frm #error_msg_alert").html(r.msg);
                    $("#login_frm #error_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#login_frm #error_msg_alert").fadeOut();
                    },1300);
                }
            },
            error:function(err){ 
                console.error(err);               
                $("#login_frm #warning_msg_alert").html("Server internal error.");
                $("#login_frm #warning_msg_alert").fadeIn();
                setTimeout(function(){
                    $("#login_frm #warning_msg_alert").fadeOut();
                },1300);
            }
        });
    });
}

if(document.getElementById('customer_profile_update_frm') == null){}
else{
    document.getElementById('customer_profile_update_frm').addEventListener('submit',function(e){
        e.preventDefault();
        
        $.ajax({
            url:url_to_request,
            type:'POST',
            data        : new FormData(this), // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true,
            contentType: false,
            cache: false,
            processData:false,
            success:function(r){
                //console.log(r);
                if(r.status == true){
                    $("#customer_profile_update_frm #success_msg_alert").html("Successfully updated");
                    $("#customer_profile_update_frm #success_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#customer_profile_update_frm #success_msg_alert").fadeOut();
                        
                        window.location.reload();
                    },1300);
                }
                else{
                    $("#customer_profile_update_frm #error_msg_alert").html("Not updated. Try again later");
                    $("#customer_profile_update_frm #error_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#customer_profile_update_frm #error_msg_alert").fadeOut();
                    },1300);
                }
            },
            error:function(err){ 
                //console.error(err);               
                $("#customer_profile_update_frm #warning_msg_alert").html("Server internal error.");
                $("#customer_profile_update_frm #warning_msg_alert").fadeIn();
                setTimeout(function(){
                    $("#customer_profile_update_frm #warning_msg_alert").fadeOut();
                },1300);
            }
        });
    });
}

if(document.getElementById('add_menu_item_frm') == null){}
else{
    document.getElementById('add_menu_item_frm').addEventListener('submit',function(e){
        e.preventDefault();
        
        $.ajax({
            url:url_to_request,
            type:'POST',
            data        : new FormData(this), // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode      : true,
            contentType: false,
            cache: false,
            processData:false,
            success:function(r){
                //console.log(r);
                if(r.status == true){
                    $("#add_menu_item_frm #success_msg_alert").html(r.msg);
                    $("#add_menu_item_frm #success_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#add_menu_item_frm #success_msg_alert").fadeOut();
                        
                        window.location.reload();
                    },1300);
                }
                else{
                    $("#add_menu_item_frm #error_msg_alert").html(r.msg);
                    $("#add_menu_item_frm #error_msg_alert").fadeIn();
                    setTimeout(function(){
                        $("#add_menu_item_frm #error_msg_alert").fadeOut();
                    },1300);
                }
            },
            error:function(err){ 
                //console.error(err);               
                $("#add_menu_item_frm #warning_msg_alert").html("Server internal error.");
                $("#add_menu_item_frm #warning_msg_alert").fadeIn();
                setTimeout(function(){
                    $("#add_menu_item_frm #warning_msg_alert").fadeOut();
                },1300);
            }
        });
    });
}




function add_form(){
    if($("#add_menu_item_frm").show()){}
    else{$("#add_menu_item_frm").show();}
    var formElements = 
        "<div class='col-lg-4'>"+
            "<div class='card' style='margin:5px;'>"+
                "<div class='card-body'>"+
                    "<div class='form-group'>"+
                        "<label>Item name</label>"+
                        "<input type='text' name='menu_item_name[]' class='form-control' required/><br/>"+
                    "</div>"+

                    "<div class='form-group'>"+
                        "<label>Item price</label>"+
                        "<input type='number' name='menu_item_price[]' class='form-control' required/><br/>"+
                    "</div>"+
                    
                    "<div class='form-group'>"+
                        "<label>Item price per</label>"+
                        "<select name='menu_item_measurment[]' class='form-control' required>"+
                            "<option value=''>select</option>"+
                            "<option value='kg'>kg</option>"+
                            "<option value='plate'>plate</option>"+
                            "<option value='unit'>unit</option>"+
                        "</select>"+
                    "</div>"+

                    "<div class='form-group'>"+
                        "<label>Item type</label>"+
                        "<select name='menu_item_type[]' class='form-control' required>"+
                            "<option value=''>select</option>"+
                            "<option value='veg'>Veg</option>"+
                            "<option value='veg'>non-veg</option>"+
                        "</select>"+
                    "</div><br/>"+
                "</div>"+
            "</div>"+
        "</div>";
    $("#form_el_container").append(formElements);
}


if((document.getElementsByClassName('update_menu_frm')).length == 0){}
else{
    $(".update_menu_frm").each(function(){
        var frm_id = this.id;
        $("#"+frm_id).submit(function(e){
            e.preventDefault();
            var loader_id = "loader_"+frm_id.substr((frm_id.lastIndexOf("_")+1),frm_id.length);
            

            $("#"+loader_id).fadeIn();

            $.ajax({
                url:url_to_request,
                type:'POST',
                data        : new FormData(this), // our data object
                dataType    : 'json', // what type of data do we expect back from the server
                encode      : true,
                contentType: false,
                cache: false,
                processData:false,
                success:function(r){
                    //console.log(r);
                    if(r.status == true){                        
                        setTimeout(function(){
                            //$("#update_menu_item_frm #success_msg_alert").fadeOut();
                            $("#"+loader_id).fadeOut();
                            window.location.reload();
                        },1300);
                    }
                    else{
                    }
                },
                error:function(err){ 
                    alert("Menu item not updated. Try again later.");      
                }
            });
        });
    });
}