<?php
    /*
    Project : Foodshala
    Author : Shantanu Singh Parmar
    */

    /*
    This is menu controller to handle all the menu related queries.
    */
    require_once(__DIR__.'/../database/dbs_controls.php');

    class MenuController {

        // table name in mysql database
        private $table_name = "menu_item";

        // this method will return menu
        public function get_menu($r_id){
            $dbs = new DatabaseControls();
            $qry = "select * from ".$this->table_name." where r_id = ".$r_id." order by item_id";
            $result = $dbs->run_multi_data_select_qry($qry);
            return $result;
        }

        // add menu items
        public function add_menu_item($request_data){
            $return_arr = [];
            $item_num = 0;
            $r_id = $request_data['r_id'];
            // getting the no of array items from request data to run
            // the loop to run queries
            $max_size = count($request_data['menu_item_name']);

            // the loop
            for($i=0;$i < $max_size;$i++){
                $name = $_POST['menu_item_name'][$i];
                $price = $_POST['menu_item_price'][$i];
                $measurment = $_POST['menu_item_measurment'][$i];
                $type = $_POST['menu_item_type'][$i];
                $dbs = new DatabaseControls();
                // getting last ids for inserting new record
                $newid = $dbs->getLastId($this->table_name,'item_id') + 1;
                // issuing queries
                $qry = "insert into menu_item values(".$newid.",".$r_id.",'".$name."','".$type."','".$measurment."','".$price."')";
                $result = $dbs->run_insert_qry($qry);
                //echo $qry;
                if($result['status'] == true){$item_num++;}
                $return_arr[] = $result;
            }

            $result = array(
                "status"=>true,
                "msg"=>"Succssfully added ".count($return_arr)." item(s)",
                "extra_data"=>$return_arr
            );
            return json_encode($result);
        }

        // update menu items
        public function update_menu_item($req_data){
            $item_id = $req_data['item_id'];
            $item_name = $req_data['item_name'];
            $item_type = $req_data['item_type'];
            $item_price = $req_data['item_price'];
            $item_measurment = $req_data['item_measurment'];
            $r_id = $req_data['r_id'];
            $qry = "update ".$this->table_name." set item_name='".$item_name."',item_type='".$item_type."',item_price='".$item_price."',item_measurment='".$item_measurment."' where item_id=".$item_id." and r_id=".$r_id;
            $dbs = new DatabaseControls();
            $result = $dbs->run_update_qry($qry);
            
            return json_encode($result);
        }
    }
?>