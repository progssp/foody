<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */

    /*
    This is restaurant controller to handle all the restaurant related queries.
    */

    require_once(__DIR__.'/../database/dbs_controls.php');

    class RestaurantController {
        // table name in mysql database
        private $table_name = "restaurant";

        // login
        public function restaurant_login($data){
            $email = $data['email'];
            $password = sha1($data['password']);

            $dbs = new DatabaseControls();
            $qry = "select * from ".$this->table_name." where r_email = '".$email."' and r_password = '".$password."'";
            $result = $dbs->run_select_qry($qry);
            
            if($result['status']){

                $session_val_arr = array(
                    "r_id"=>$result['extra_data']['r_id'],
                    "r_name"=>$result['extra_data']['r_name'],
                    "r_email"=>$result['extra_data']['r_email'],
                    "r_address"=>$result['extra_data']['r_address'],
                    "r_food_preference"=>$result['extra_data']['r_food_preference'],
                    "r_country_code"=>$result['extra_data']['r_country_code'],
                    "r_cont_no"=>$result['extra_data']['r_cont_no'],
                    "user_type"=>"restaurant"
                );
                session_start();
                foreach($session_val_arr as $key=>$value){
                    $_SESSION[$key] = $value;
                }
            }
            return json_encode($result);
        }

        // sign up/register
        public function restaurant_register($request_data){
            $dbs = new DatabaseControls();
            
            $newid = $dbs->getLastId($this->table_name,'r_id') + 1;

            //getting data from $request_data
            $r_name = $request_data['r_name'];
            $r_email = $request_data['r_email'];
            $r_cont_no = $request_data['r_cont_no'];
            $r_pass = sha1($request_data['r_password']);
            $r_address = $request_data['r_address'];
            $r_food_pref = $request_data['r_food_pref'];
            $r_cty_code = "+91";
            $qry = "insert into ".$this->table_name." values ('".$newid."','".$r_name."','".$r_address."','".$r_email."','".$r_cty_code."','".$r_cont_no."','".$r_pass."','".$r_food_pref."')";
            
            $result = $dbs->run_insert_qry($qry);
            
            return json_encode($result);
        }

        // getting all restaurants
        public function get_all_restaurant(){
            $dbs = new DatabaseControls();
            $qry = "select * from ".$this->table_name;
            $result = $dbs->run_multi_data_select_qry($qry);
            return json_encode($result);
        }
    }
?>