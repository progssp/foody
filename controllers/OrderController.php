<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */

    /*
    This is order controller to handle all the orders related queries.
    */
    require_once(__DIR__.'/../database/dbs_controls.php');

    class OrderController {
        // table name in mysql database
        private $table_name = "orders";

        // return all orders for restaurant
        public function get_orders_for_restaurant($r_id){
            $dbs = new DatabaseControls();
            $qry = "select * from ".$this->table_name.",customer where orders.r_id = ".$r_id." and orders.c_id = customer.c_id order by o_id desc";
            $result = $dbs->run_multi_data_select_qry($qry);
            return $result;
        }

        // return all orders for customers
        public function get_orders_for_customer($c_id){
            $dbs = new DatabaseControls();
            $qry = "select * from ".$this->table_name.",restaurant where orders.c_id = ".$c_id." and orders.r_id = restaurant.r_id order by o_id desc";
            $result = $dbs->run_multi_data_select_qry($qry);
            return $result;
        }

        // place order
        public function place_order($req_data){
            $dbs = new DatabaseControls();
            
            $new_id = $dbs->getLastId($this->table_name,'o_id') + 1;
            $c_id = $req_data['c_id'];
            $r_id = $req_data['r_id'];
            $order_desc = substr($req_data['order_desc'],1,(strlen($req_data['order_desc'])-2));
            date_default_timezone_set('Asia/Kolkata');
            $order_date = date('Y-m-d H:i:s');
            $order_amt = $req_data['order_amt'];

            $qry = "insert into ".$this->table_name." values(".$new_id.",".$c_id.",".$r_id.",'".$order_desc."','".$order_date."',".$order_amt.")";
            $result = $dbs->run_insert_qry($qry);

            return json_encode($result);


        }
    }

?>