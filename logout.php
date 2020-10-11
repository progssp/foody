<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */
?>
<?php
if(session_start()){
    session_destroy();
}
header("location:/foody");
?>