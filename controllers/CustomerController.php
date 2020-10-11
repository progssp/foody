<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */

    /*
    This is customer controller to handle all the customer related queries.
    */

    require_once(__DIR__.'/../database/dbs_controls.php');

    class CustomerController {

        // table name in mysql database
        private $table_name = "customer";


        // customer login method
        public function customer_login($data){
            $email = $data['email'];
            $password = sha1($data['password']);

            $dbs = new DatabaseControls();
            $qry = "select * from ".$this->table_name." where c_email = '".$email."' and c_password = '".$password."'";
            $result = $dbs->run_select_qry($qry);
            
            if($result['status']){
                $session_val_arr = array(
                    "c_id"=>$result['extra_data']['c_id'],
                    "c_name"=>$result['extra_data']['c_name'],
                    "c_food_preference"=>$result['extra_data']['c_food_preference'],
                    "c_country_code"=>$result['extra_data']['c_country_code'],
                    "c_cont_no"=>$result['extra_data']['c_cont_no'],
                    "c_email"=>$result['extra_data']['c_email'],
                    "user_type"=>"customer"
                );
                session_start();
                foreach($session_val_arr as $key=>$value){
                    $_SESSION[$key] = $value;
                }
            }
            return json_encode($result);
        }

        // customer register/sign up method
        public function customer_register($request_data){
            
            $dbs = new DatabaseControls();
            
            $newid = $dbs->getLastId($this->table_name,'c_id') + 1;

            //getting data from $request_data
            $c_name = $request_data['c_name'];
            $c_email = $request_data['c_email'];
            $c_cont_no = $request_data['c_cont_no'];
            $c_pass = sha1($request_data['c_password']);
            $c_food_pref = $request_data['c_food_pref'];
            $c_cty_code = "+91";
            $qry = "insert into ".$this->table_name." values ('".$newid."','".$c_name."','".$c_email."','".$c_cty_code."','".$c_cont_no."','".$c_pass."','".$c_food_pref."')";
            
            $result = $dbs->run_insert_qry($qry);
            return json_encode($result);
        }

        // customer update details method
        public function update($request_data){
            $c_id = $request_data['c_id'];

            //getting data from $request_data
            $c_name = $request_data['c_name'];
            $c_cont_no = $request_data['c_cont_no'];
            $c_food_pref = $request_data['c_food_pref'];

            $dbs = new DatabaseControls();
            $qry = "update ".$this->table_name." set c_name = '".$c_name."',c_cont_no = '".$c_cont_no."',c_food_preference = '".$c_food_pref."' where c_id = ".$c_id;
            $result = $dbs->run_update_qry($qry);        
            
            
            return json_encode($result);
        }
    }
?>