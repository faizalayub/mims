<?php

    // require_once "././libs/swiftmailer/lib/swift_required.php";
    
    class Admins{
        private $host = "localhost";
        private $database = "inventory_management";
        private $username = "root";
        private $password = "";
        private $conn;
        
        public function __construct() {
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->username, $this->password);
            $this->conn->exec("SET NAMES 'utf8';");

        }
        
            
        public function checkAdminLogin($array){
            $args_check = array("username" => $array["username"]);
            $sql_check = "SELECT * FROM admin WHERE admin_username = :username";
            $result_check = $this->conn->prepare($sql_check);
            $result_check->execute($args_check);
            
            if ($result_check->rowCount() > 0){
                $row = $result_check->fetchObject();
                if (password_verify($array["password"], $row->admin_password)){
                    session_start();
                    $_SESSION["admin_id"] = $row->admin_id;
                    $_SESSION["username"] = $row->admin_username;
                    $_SESSION["admin_login"] = true;
                    session_write_close();
                    
                    $result_data["valid"] = true;
                    $result_data["message"] = "Successfully Verify Admin Login";
                }
                else{
                    $result_data["valid"] = false;
                    $result_data["message"] = "Username or Password is incorrect";
                }
            }
            else{
                $result_data["valid"] = false;
                $result_data["message"] = "Unable to verify admin login. Please try again later";
            }
            
            return json_encode($result_data);
        }

         public function addUser($array){
        
            $args_add = array("user_id" => $array["user_id"], "username" => $array["username"],"department" => $array["department"], "password" => $array["password"], "role" => $array["role"], "location" => $array["location"]);


            $sql_add = "INSERT INTO user SET user_id = :user_id, user_name = :username, user_department = :department, user_password = :password, role = :role, location = :location";
            $result = $this->conn->prepare($sql_add);
            $result->execute($args_add);
            if($result){
                $result_data["valid"] = true;
                $result_data["msg"] = "Successfully Submit";

            }else{
                $result_data["valid"] = false;
                $result_data["msg"] = "Something Error.";
            }
            
            return json_encode($result_data);
        }

        public function getUserListOnLoad(){
        $sql = "SELECT * FROM user
         LEFT JOIN user.location = 
         ORDER BY id DESC
        ";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) { 

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$i.'</td>
                    <td style="text-align: center;">'.$value["user_id"].'</td>                    
                    <td style="text-align: center;">'.$value["user_name"].'</td>                    
                    <td style="text-align: center;">'.$value["user_department"].'</td>
                    <td style="text-align: center;">'.$value["role"].'</td>
                    <td style="text-align: center;">'.$value["location"].'</td>';
                    $i++;
         
                $tableOnLoad .='
                        </select>
                    </td>
                    <td style="text-align: center;">'.$value["createdAt"].'</td>
                    <td style="text-align: center;">
                    <a href="user-view.php?id='.$value["id"].'" target="" style="color:#000"><i class="material-icons">pageview</i></a> | <a href="user-edit.php?id='.$value["id"].'" target="" style="color:#000"><i class="material-icons">edit</i></a> | <a id='.$value["id"].' onclick="deleteUser(this.id);" style="color:#000"> <i class="material-icons">delete</i></a>
                    </td>
                </tr>
                ';
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }


        return json_encode($result_data);
    }

    public function getUserDetailByID($id){

            //Get merchant detail
            $args = array("id" => $id);
            $sql = "SELECT * FROM user
            WHERE id = :id";
            $result = $this->conn->prepare($sql);
            $result->execute($args);
            $row = $result->fetchObject();

            if($result->rowCount() > 0){
                $result_data["valid"] = true;
                $result_data["msg"] = "Get detail!!";
                 $result_data["id"] = $row->id;
                $result_data["user_id"] = $row->user_id;
                $result_data["user_name"] = $row->user_name;
                $result_data["user_department"] = $row->user_department;
                $result_data["role"] = $row->role; 
                $result_data["location"] = $row->location;
                $result_data["createdAt"] = $row->createdAt;                           
                
            }else{
                $result_data["valid"] = false;
                $result_data["msg"] = "No record found!";
            }

            return json_encode($result_data);

        }

        public function updateUser($array){

        $args = array("id" => $array["id"], "user_id" => $array["user_id"], "user_name" => $array["user_name"], "user_department" => $array["user_department"], "role" => $array["role"]);

        $sql = "UPDATE user SET user_id = :user_id, user_name = :user_name, user_department = :user_department, role = :role, location = :location WHERE id = :id";

        $result = $this->conn->prepare($sql);
        $result->execute($args);

            if($result){
                $result_data["valid"] = true;
                $result_data["msg"] = "Update Successful!";
            }else{
                $result_data["valid"] = false;
                $result_data["msg"] = "Something error!!";
            }
        return json_encode($result_data);

    }

    public function deleteUser($array){

        //Delete from database
        $args_delete_user = array("id" => $array["id"]);
        $sql_delete_user = "DELETE FROM user WHERE id = :id";
        $result_delete_user = $this->conn->prepare($sql_delete_user);
        $result_delete_user->execute($args_delete_user);

        if($result_delete_user){
            $result_data["valid"] = true;
            $result_data["msg"] = "User has been deleted.";
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "Something error!!";
        }
        return json_encode($result_data);
    }

     public function addItem($array){

           $args_check = array("serial_no" => $array["serial_no"]);
           $sql_check = "SELECT serial_no FROM item WHERE serial_no = :serial_no";
           $result_check = $this->conn->prepare($sql_check);
           $result_check->execute($args_check);

        if($result_check-> rowCount() > 0){
            $result_data["valid"] = false;
            $result_data["msg"] = "Serial number already exist!";
        }else{
       
           $args_add = array("category_id" => $array["category_id"],  "brand_id" => $array["brand_id"], "serial_no" => $array["serial_no"], "model_id" => $array["model_id"], "createdBy" => $array["createdBy"],  "region_id" => $array["region_id"], "status_id" => $array["status_id"]);
   
           $sql_add = "INSERT INTO item SET category_id = :category_id, brand_id = :brand_id, serial_no = :serial_no, model_id = :model_id, createdBy = :createdBy, region_current = :region_id, region_from = :region_id, status_id = :status_id";
           $result = $this->conn->prepare($sql_add);
           $result->execute($args_add);
           if($result){
               $result_data["valid"] = true;
               $result_data["msg"] = "Successfully Submit";
   
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "Something Error.";
           }
       }
           
           return json_encode($result_data);
       }

       public function getItemsListOnLoad($location){

       $args = array("location" => $location);
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN region ON region.region_id = item.region_current
       LEFT JOIN user ON user.location = region.region_id
       WHERE user.location = :location
       GROUP BY item.item_id       
       ORDER BY item_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {

              if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }

               $data[$key]["category_desc"] = $value["category_desc"];
               $data[$key]["brand_desc"] = $value["brand_desc"];
               $data[$key]["serial_no"] =  $value["serial_no"];  
               $data[$key]["model_desc"] = $value["model_desc"];                                                              
               $data[$key]["region_current"] =  $value["region_current"];
               $data[$key]["region_name"] =  $value["region_name"];
               $data[$key]["createdBy"] =  $value["createdBy"];
               $data[$key]["createdDt"] =  $value["createdDt"];  
               $data[$key]["item_id"] =  $value["item_id"];                               
              
               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }

       public function getSendItemsToRegionListOnLoad($location){

       $args = array("location" => $location);
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN region ON region.region_id = item.region_current
       LEFT JOIN user ON user.location = region.region_id
       WHERE user.location = :location
       GROUP BY item.item_id       
       ORDER BY item_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {

              if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }         

               if ($value["asset_name"] == ""){
                   $asset_name = "Null";
               }else {
                   $asset_name = $value["asset_name"];
               }

               if ($value["barcode"] == ""){
                   $barcode = "Null";
               }else {
                   $barcode = $value["barcode"];
               }

               $data[$key]["category_desc"] = $value["category_desc"];
               $data[$key]["brand_desc"] = $value["brand_desc"];
               $data[$key]["serial_no"] =  $value["serial_no"];  
               $data[$key]["model_desc"] = $value["model_desc"];
               $data[$key]["asset_name"] = $value["asset_name"];
               $data[$key]["barcode"] = $value["barcode"];
               $data[$key]["region_from"] =  $value["region_from"];
               $data[$key]["region_current"] =  $value["region_current"];
               $data[$key]["region_name"] =  $value["region_name"];
               // $data[$key]["createdBy"] =  $value["createdBy"];
               // $data[$key]["createdDt"] =  $value["createdDt"];
               $data[$key]["item_id"] = $value["item_id"];                                                                                       

                }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }

   public function getItemStatus($item_id){
       $args = array("item_id" => $item_id);
   
       $sql = "SELECT * FROM item_status
       LEFT JOIN item ON item_status.is_item_id = item.item_id
       LEFT JOIN region ON region.region_id = item_status.is_region_current
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       WHERE item_status.is_item_id = :item_id    
       ORDER BY item_status.is_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {
               $data[$key]["item_id"] = $value["item_id"];  
               $data[$key]["is_id"] = $value["is_id"];                
               $data[$key]["region_id"] = $value["region_id"]; 
               $data[$key]["region_name"] =  $value["region_name"];   
               $data[$key]["status_id"] =  $value["status_id"];
               $data[$key]["status_desc"] =  $value["status_desc"]; 
               $data[$key]["is_datetime"] =  $value["is_datetime"];
               // $data[$key]["is_region_from"] =  $value["is_region_from"];
               $data[$key]["is_region_current"] =  $value["is_region_current"]; 

               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   } 

    public function getSendItemsToSiteListOnLoad($location){

       $args = array("location" => $location);
       // $args = array('location_id' => $location_id);
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN site ON site.site_id = item.site_id
       LEFT JOIN agency ON agency.agency_id = item.agency_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       LEFT JOIN region ON region.region_id = item_status.is_region_current
       LEFT JOIN user ON user.location = region.region_id
       WHERE user.location = :location
       GROUP BY item.item_id       
       ORDER BY item_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

             foreach ($result as $key => $value) {

              if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }         

               if ($value["asset_name"] == ""){
                   $asset_name = "Null";
               }else {
                   $asset_name = $value["asset_name"];
               }

               if ($value["barcode"] == ""){
                   $barcode = "Null";
               }else {
                   $barcode = $value["barcode"];
               }

               if ($value["agency_desc"] == ""){
                   $agency_desc = "Null";
               }else {
                   $agency_desc = $value["agency_desc"];
               }

               if ($value["site_desc"] == ""){
                   $site_desc = "Null";
               }else {
                   $site_desc = $value["site_desc"];
               }

               $data[$key]["item_id"] = $value["item_id"];
               $data[$key]["category_desc"] = $value["category_desc"];
               $data[$key]["brand_desc"] = $value["brand_desc"]; 
               $data[$key]["serial_no"] =  $value["serial_no"];  
               $data[$key]["model_desc"] = $value["model_desc"];                                  
               $data[$key]["asset_name"] =  $value["asset_name"];
               $data[$key]["barcode"] =  $value["barcode"];
               $data[$key]["agency_desc"] =  $value["agency_desc"];
               $data[$key]["site_desc"] =  $value["site_desc"];
               $data[$key]["region_name"] =  $value["region_name"];

              
               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }     

   public function getItemSiteStatus($item_id){
       $args = array("item_id" => $item_id);
   
       $sql = "SELECT * FROM item_status
       LEFT JOIN item ON item_status.is_item_id = item.item_id
       LEFT JOIN site ON site.site_id = item_status.is_site_id
       LEFT JOIN agency ON agency.agency_id = item_status.is_agency_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       WHERE item_status.is_item_id = :item_id    
       ORDER BY item_status.is_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {
               $data[$key]["item_id"] = $value["item_id"];  
               $data[$key]["is_id"] = $value["is_id"];                
               $data[$key]["site_id"] = $value["site_id"]; 
               $data[$key]["site_desc"] =  $value["site_desc"];
               $data[$key]["agency_id"] = $value["agency_id"]; 
               $data[$key]["agency_desc"] =  $value["agency_desc"];    
               $data[$key]["status_id"] =  $value["status_id"];
               $data[$key]["status_desc"] =  $value["status_desc"]; 
               $data[$key]["is_datetime"] =  $value["is_datetime"];                

               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }
   
   public function getSendItemsSubregionToSiteListOnLoad($location){

       $args = array("location" => $location);
       // $args = array('location_id' => $location_id);
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN site ON site.site_id = item.site_id
       LEFT JOIN agency ON agency.agency_id = item.agency_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       LEFT JOIN region ON region.region_id = item_status.is_region_current
       LEFT JOIN user ON user.location = region.region_id
       WHERE user.location = :location
       GROUP BY item.item_id       
       ORDER BY item_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {

              if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }         

               if ($value["asset_name"] == ""){
                   $asset_name = "Null";
               }else {
                   $asset_name = $value["asset_name"];
               }

               if ($value["barcode"] == ""){
                   $barcode = "Null";
               }else {
                   $barcode = $value["barcode"];
               }

               if ($value["agency_desc"] == ""){
                   $agency_desc = "Null";
               }else {
                   $agency_desc = $value["agency_desc"];
               }

               if ($value["site_desc"] == ""){
                   $site_desc = "Null";
               }else {
                   $site_desc = $value["site_desc"];
               }

               $data[$key]["item_id"] = $value["item_id"];
               $data[$key]["category_desc"] = $value["category_desc"];
               $data[$key]["brand_desc"] = $value["brand_desc"]; 
               $data[$key]["serial_no"] =  $value["serial_no"];  
               $data[$key]["model_desc"] = $value["model_desc"];                                  
               $data[$key]["asset_name"] =  $value["asset_name"];
               $data[$key]["barcode"] =  $value["barcode"];
               $data[$key]["agency_desc"] =  $value["agency_desc"];
               $data[$key]["site_desc"] =  $value["site_desc"];
              
               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }     

       public function getItemDetailByID($item_id){
            
           //Get merchant detail
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item
           LEFT JOIN model ON model.model_id = item.model_id
           LEFT JOIN brand ON brand.brand_id = item.brand_id
           LEFT JOIN category ON category.category_id = item.category_id
           LEFT JOIN status ON status.status_id = item_status.is_status_id
           LEFT JOIN region ON region.region_id = item.region_current 
           WHERE item_id = :item_id";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject(); 
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               $result_data["item_id"] = $row->item_id;
               $result_data["category_id"] = $row->category_id;
               $result_data["category_desc"] = $row->category_desc;
               $result_data["brand_id"] = $row->brand_id;
               $result_data["brand_desc"] = $row->brand_desc;
               $result_data["serial_no"] = $row->serial_no;
               $result_data["model_id"] = $row->model_id;
               $result_data["model_desc"] = $row->model_desc;               
               $result_data["createdBy"] = $row->createdBy;
               $result_data["createdDt"] = $row->createdDt;
               $result_data["lastModifiedBy"] = $row->lastModifiedBy;
               $result_data["lastModifiedDt"] = $row->lastModifiedDt;
               $result_data["region_id"] = $row->region_id; 
               $result_data["region_name"] = $row->region_name;   
               $result_data["status_id"] = $row->status_id;
               $result_data["status_desc"] = $row->status_desc;                                 
               
           }else{            
   
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }            
   
           return json_encode($result_data);
   
       // }
   }
   
       public function updateItem($array){
   
       $args = array("item_id" => $array["item_id"], "category_id" => $array["category_id"], "brand_id" => $array["brand_id"], "serial_no" => $array["serial_no"],"model_id" => $array["model_id"], "createdBy" => $array["createdBy"], "createdDt" => $array["createdDt"], "region_id" => $array["region_id"]);
   
       $sql = "UPDATE item SET category_id = :category_id, brand_id = :brand_id, serial_no = :serial_no, model_id = :model_id, createdBy = :createdBy, createdDt = :createdDt,  region_current = :region_id WHERE item_id = :item_id";


       
   
       $result = $this->conn->prepare($sql);
       $result->execute($args);
   
           if($result){
               $result_data["valid"] = true;
               $result_data["msg"] = "Update Successful!"; 


               $args_insert = array("item_id" => $array["item_id"], "status_id" => $array["status_id"], "region_id" => $array["region_id"], "region_from" => $array["region_from"]);
   
       $sql_insert = "INSERT INTO item_status SET is_status_id = :status_id, is_item_id =:item_id, is_region_current = :region_id, is_region_from = :region_from";
       $result_insert = $this->conn->prepare($sql_insert);
       $result_insert->execute($args_insert);
   
           
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "Something error!!";
           }
       return json_encode($result_data);
   }
   
   public function getItemsDetailByID($item_id){
   
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item
           LEFT JOIN model ON model.model_id = item.model_id
           LEFT JOIN brand ON brand.brand_id = item.brand_id
           LEFT JOIN category ON category.category_id = item.category_id
           LEFT JOIN item_status ON item_status.is_item_id = item.item_id
           LEFT JOIN status ON status.status_id = item_status.is_status_id
           LEFT JOIN region ON region.region_id = item.region_current            
           LEFT JOIN agency ON agency.agency_id = item.agency_id
           LEFT JOIN site ON site.site_id = item.site_id
           WHERE item_id = :item_id
           ORDER BY item_status.is_id DESC
           LIMIT 1";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject();
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               $result_data["item_id"] = $row->item_id;
               $result_data["category_id"] = $row->category_id;
               $result_data["category_desc"] = $row->category_desc;
               $result_data["brand_id"] = $row->brand_id;                               
               $result_data["brand_desc"] = $row->brand_desc;
               $result_data["serial_no"] = $row->serial_no;
               $result_data["model_id"] = $row->model_id;
               $result_data["model_desc"] = $row->model_desc;
               $result_data["asset_name"] = $row->asset_name; 
               $result_data["barcode"] = $row->barcode;
               $result_data["is_id"] = $row->is_id;                 
               $result_data["status_id"] = $row->status_id;
               $result_data["status_desc"] = $row->status_desc;                                                
               $result_data["createdBy"] = $row->createdBy;
               $result_data["createdDt"] = $row->createdDt;
               $result_data["lastModifiedBy"] = $row->lastModifiedBy;
               $result_data["lastModifiedDt"] = $row->lastModifiedDt;
               $result_data["is_region_current"] = $row->is_region_current; 
               $result_data["region_id"] = $row->region_id; 
               $result_data["region_current"] = $row->region_current; 
               $result_data["region_name"] = $row->region_name;
               $result_data["agency_id"] = $row->agency_id;
               $result_data ["agency_desc"] = $row->agency_desc;                                   
               $result_data["site_id"] = $row->site_id;
               $result_data["site_desc"] = $row->site_desc;                                 
               
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }
   
           return json_encode($result_data);
   
       }

        public function getItemStatusByID($item_id){
   
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item_status 
          LEFT JOIN status ON status.status_id = item_status.is_status_id
          LEFT JOIN region ON region.region_id = item_status.is_region_current
           WHERE item_status.is_item_id = :item_id
           ORDER BY is_id DESC LIMIT 1";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject();
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               
               $result_data["is_id"] = $row->is_id;                 
               $result_data["status_id"] = $row->status_id;
               $result_data["is_status_id"] = $row->is_status_id;
               $result_data["region_name"] = $row->region_name;                                                                                          
               
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }
   
           return json_encode($result_data);
   
       }

        public function getSiteStatusByID($item_id){
   
           //Get merchant detail
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item_status 
          LEFT JOIN status ON status.status_id = item_status.is_status_id
          LEFT JOIN site ON site.site_id = item_status.is_site_id
          LEFT JOIN agency ON agency.agency_id = item_status.is_agency_id
           WHERE item_status.is_item_id = :item_id
           ORDER BY is_id DESC LIMIT 1";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject();
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               
               $result_data["is_id"] = $row->is_id;                 
               $result_data["status_id"] = $row->status_id;
               $result_data["status_desc"] = $row->status_desc;
               $result_data["agency_desc"] = $row->agency_desc;
               $result_data["site_desc"] = $row->site_desc;                                                                                            
               
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }
   
           return json_encode($result_data);
   
       }

   
       public function getSendItemsDetailByID($item_id){
   
               $args = array("item_id" => $item_id);
               $sql = "SELECT * FROM item
               LEFT JOIN model ON model.model_id = item.model_id
               LEFT JOIN brand ON brand.brand_id = item.brand_id
               LEFT JOIN category ON category.category_id = item.category_id
               LEFT JOIN item_status ON item_status.is_item_id = item.item_id
               LEFT JOIN status ON status.status_id = item_status.is_status_id
               LEFT JOIN region ON region.region_id = item_status.is_region_current          
               LEFT JOIN agency ON agency.agency_id = item.agency_id
               LEFT JOIN site ON site.site_id = item.site_id
               WHERE item_id = :item_id
                ORDER BY item_status.is_id DESC
           LIMIT 1";
               $result = $this->conn->prepare($sql);
               $result->execute($args);
               $row = $result->fetchObject();
   
               if($result->rowCount() > 0){
                   $result_data["valid"] = true;
                   $result_data["msg"] = "Get detail!!";
                   $result_data["item_id"] = $row->item_id;
                   $result_data["is_id"] = $row->is_id;
                   $result_data["category_id"] = $row->category_id;
                   $result_data["category_desc"] = $row->category_desc;
                   $result_data["brand_id"] = $row->brand_id;                               
                   $result_data["brand_desc"] = $row->brand_desc;
                   $result_data["serial_no"] = $row->serial_no;
                   $result_data["model_id"] = $row->model_id;
                   $result_data["model_desc"] = $row->model_desc;
                   $result_data["asset_name"] = $row->asset_name;
                   $result_data["barcode"] = $row->barcode;                
                   $result_data["status_id"] = $row->status_id;
                   $result_data["status_desc"] = $row->status_desc;                                                
                   $result_data["createdBy"] = $row->createdBy;
                   $result_data["createdDt"] = $row->createdDt;
                   $result_data["lastModifiedBy"] = $row->lastModifiedBy;
                   $result_data["lastModifiedDt"] = $row->lastModifiedDt;
                   $result_data["region_id"] = $row->region_id; 
                    $result_data["region_current"] = $row->region_current; 
                   $result_data["region_name"] = $row->region_name;
                   $result_data ["agency_id"] = $row->agency_id;
                   $result_data ["is_agency_id"] = $row->is_agency_id;
                   $result_data ["agency_desc"] = $row->agency_desc;                                   
                   $result_data["site_id"] = $row->site_id;
                   $result_data["site_desc"] = $row->site_desc;                                 
                   
               }else{
                   $result_data["valid"] = false;
                   $result_data["msg"] = "No record found!";
               }
   
               return json_encode($result_data);
   
           }
   
       public function updateSendItem($array){

       $args = array("item_id" => $array["item_id"],  "category_id" => $array["category_id"], "brand_id" => $array["brand_id"], "serial_no" => $array["serial_no"], "model_id" => $array["model_id"], "asset_name" => $array["asset_name"], "barcode" => $array["barcode"], "agency_id" => $array["agency_id"], "lastModifiedBy" => $array["lastModifiedBy"],  "region_from" => $array["region_from"]);        
   
       $sql = "UPDATE item SET category_id = :category_id, brand_id = :brand_id, serial_no = :serial_no, model_id = :model_id, asset_name = :asset_name, barcode = :barcode, agency_id = :agency_id, lastModifiedBy = :lastModifiedBy, region_from = :region_from WHERE item_id = :item_id";
       $result = $this->conn->prepare($sql);
       $result->execute($args);
       if($result){
               $result_data["valid"] = true;
               $result_data["msg"] = "Send Successful!";
   
       $args_insert = array("item_id" => $array["item_id"], "status_id" => $array["status_id"], "region_current" => $array["region_current"], "region_from" => $array["region_from"]);
   
       $sql_insert = "INSERT INTO item_status SET is_status_id = :status_id, is_item_id =:item_id, is_region_current = :region_current, is_region_from = :region_from";
       $result_insert = $this->conn->prepare($sql_insert);
       $result_insert->execute($args_insert);
   
           
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "Something error!!";
           }
              
       return json_encode($result_data);
   }

    public function updateItemSite($array){   

    $args = array("item_id" => $array["item_id"], "asset_name" => $array["asset_name"], "barcode" => $array["barcode"]);        
   
       $sql = "UPDATE item SET asset_name = :asset_name, barcode = :barcode WHERE item_id = :item_id";
       $result = $this->conn->prepare($sql);
       $result->execute($args);

       
        if($result){
               $result_data["valid"] = true;
               $result_data["msg"] = "Send Successful!";

               $args_insert = array("item_id" => $array["item_id"], "status_id" => $array["status_id"], "site_id" => $array["site_id"], "agency_id" => $array["agency_id"]);
   
       $sql_insert = "INSERT INTO item_status SET is_status_id = :status_id, is_item_id =:item_id, is_site_id = :site_id, is_agency_id = :agency_id";
       $result_insert = $this->conn->prepare($sql_insert);
       $result_insert->execute($args_insert);
           
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "Something error!!";
           }
             
       return json_encode($result_data);
   }   
   
   public function deleteItem($array){
   
       //Delete from database
       $args_delete_item = array("item_id" => $array["item_id"]);
       $sql_delete_item = "DELETE FROM item WHERE item_id = :item_id";
       $result_delete_item = $this->conn->prepare($sql_delete_item);
       $result_delete_item->execute($args_delete_item);
   
       if($result_delete_item){
           $result_data["valid"] = true;
           $result_data["msg"] = "Item has been deleted.";
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "Something error!!";
       }
       return json_encode($result_data);
   }

    public function getCategoryListOnLoad(){
        $sql = "SELECT category_desc,
                count(case when region_id='1' then 1 end),
                count(case when region_id='2' then 1 end),
                count(case when region_id='3' then 1 end),
                count(case when region_id='4' then 1 end),
                count(case when region_id='5' then 1 end),
                count(case when region_id='6' then 1 end),
                count(case when region_id='7' then 1 end),
                count(case when region_id='8' then 1 end),
                count(case when region_id='9' then 1 end),
                count(case when region_id='10' then 1 end),
                count(case when region_id='11' then 1 end),
                count(case when region_id='12' then 1 end),
                count(item_id)
                FROM item i 
                right join category c
                on i.category_id=c.category_id
                GROUP BY category_desc
                ORDER BY category_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) { 

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=1" target="">'.$value["count(case when region_id='1' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=2" target="">'.$value["count(case when region_id='2' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=3" target="">'.$value["count(case when region_id='3' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=4" target="">'.$value["count(case when region_id='4' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=5" target="">'.$value["count(case when region_id='5' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=6" target="">'.$value["count(case when region_id='6' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=7" target="">'.$value["count(case when region_id='7' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=8" target="">'.$value["count(case when region_id='8' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=9" target="">'.$value["count(case when region_id='9' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=10" target="">'.$value["count(case when region_id='10' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=11" target="">'.$value["count(case when region_id='11' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="item-view.php?region_id=12" target="">'.$value["count(case when region_id='12' then 1 end)"].'</a></td>
                    <td style="text-align: center;">'.$value["count(item_id)"].'</td>';
                    $i++;   
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

public function getRegionListOnLoad(){
        $sql = "SELECT i.*, m.*, b.*, c.*, r.*, s.*, a.* 
                FROM item i 
                left join model m on m.model_id=i.model_id
                left join brand b on b.brand_id=i.brand_id
                left join category c on c.category_id=i.category_id
                left join region r on r.region_id=i.region_id
                left join site s on s.site_id=i.site_id
                left join agency a on a.agency_id=i.agency_id
                ORDER BY region_name ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) {

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["region_name"].'</td>
                    <td style="text-align: center;">'.$value["site_desc"].'</td>
                    <td style="text-align: center;">'.$value["agency_desc"].'</td>
                    <td style="text-align: center;">'.$value["model_desc"].'</td>
                    <td style="text-align: center;">'.$value["serial_no"].'</td>
                    <td style="text-align: center;">'.$value["brand_desc"].'</td>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>';
                    $i++;
         
                $tableOnLoad .='
                        </select>
                    </td>
                    <td style="text-align: center;">'.$value["date"].'</td>
                    <td style="text-align: center;">
                    <a href="item-view.php?item_id='.$value["item_id"].'" target="" style="color:#000"><i class="material-icons">pageview</i></a> | <a href="item-edit.php?item_id='.$value["item_id"].'" target="" style="color:#000"><i class="material-icons">edit</i></a> | <a id='.$value["item_id"].' onclick="deleteItem(this.id);" style="color:#000"> <i class="material-icons">delete</i></a>
                    </td>
                </tr>
                ';
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

    public function getReportCategoryListOnLoad(){
        $sql = "SELECT category_desc,
                count(case when region_id='1' then 1 end),
                count(case when region_id='2' then 1 end),
                count(case when region_id='3' then 1 end),
                count(case when region_id='4' then 1 end),
                count(case when region_id='5' then 1 end),
                count(case when region_id='6' then 1 end),
                count(case when region_id='7' then 1 end),
                count(case when region_id='8' then 1 end),
                count(case when region_id='9' then 1 end),
                count(case when region_id='10' then 1 end),
                count(case when region_id='11' then 1 end),
                count(case when region_id='12' then 1 end),
                count(item_id)
                FROM item i 
                right join category c
                on i.category_id=c.category_id
                GROUP BY category_desc
                ORDER BY category_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) { 

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='1' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='2' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='3' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='4' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='5' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='6' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='7' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='8' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='9' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='10' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='11' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_id='12' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(item_id)"].'</td>';
                    $i++;   
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

    public function getItemListByStoreOnLoad(){
        $sql = "SELECT i.*, m.*, b.*, c.*, r.* 
                FROM item i 
                join model m on m.model_id=i.model_id
                join brand b on b.brand_id=i.brand_id
                join category c on c.category_id=i.category_id
                join region r on r.region_id=i.region_id
                ORDER BY region_name ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) {

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["region_name"].'</td>
                    <td style="text-align: center;">'.$value["item_id"].'</td>
                    <td style="text-align: center;">'.$value["model_desc"].'</td>
                    <td style="text-align: center;">'.$value["serial_no"].'</td>
                    <td style="text-align: center;">'.$value["brand_desc"].'</td>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>';
                    $i++;
         
                $tableOnLoad .='
                        </select>
                    </td>
                    <td style="text-align: center;">'.$value["date"].'</td>
                </tr>
                ';
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

    public function getMonthlyItemListOnLoad(){
        $sql = "SELECT category_desc,
                count(case when month(date)='1' then 1 end),
                count(case when month(date)='2' then 1 end),
                count(case when month(date)='3' then 1 end),
                count(case when month(date)='4' then 1 end),
                count(case when month(date)='5' then 1 end),
                count(case when month(date)='6' then 1 end),
                count(case when month(date)='7' then 1 end),
                count(case when month(date)='8' then 1 end),
                count(case when month(date)='9' then 1 end),
                count(case when month(date)='10' then 1 end),
                count(case when month(date)='11' then 1 end),
                count(case when month(date)='12' then 1 end),
                count(item_id)
                FROM item i 
                right join category c
                on i.category_id=c.category_id
                GROUP BY category_desc
                ORDER BY category_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) { 

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='1' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='2' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='3' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='4' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='5' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='6' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='7' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='8' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='9' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='10' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='11' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when month(date)='12' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(item_id)"].'</td>';
                    $i++;   
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

    public function getItemListByAgencyOnLoad(){
        $sql = "SELECT i.*, m.*, b.*, c.*, r.*, a.* 
                FROM item i 
                join model m on m.model_id=i.model_id
                join brand b on b.brand_id=i.brand_id
                join category c on c.category_id=i.category_id
                join region r on r.region_id=i.region_id
                join agency a on a.agency_id=i.agency_id
                ORDER BY agency_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();

        $i = 1;
        if($result-> rowCount() > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) {

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["agency_desc"].'</td>
                    <td style="text-align: center;">'.$value["region_name"].'</td>
                    <td style="text-align: center;">'.$value["model_desc"].'</td>
                    <td style="text-align: center;">'.$value["serial_no"].'</td>
                    <td style="text-align: center;">'.$value["brand_desc"].'</td>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>';
                    $i++;
         
                $tableOnLoad .='
                        </select>
                    </td>
                    <td style="text-align: center;">'.$value["date"].'</td>
                </tr>
                ';
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

   public function getCategory(){
       $sql_category = "SELECT * FROM category";
       $result_category = $this->conn->query($sql_category);
       if($result_category->rowCount() > 0 ){
           foreach ($result_category as $key => $value) {
               $data[$key]["category_id"] = $value["category_id"];
               $data[$key]["category_desc"] = $value["category_desc"];
   
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;
       }else{
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }
   
   public function getBrand(){
       $sql_brand = "SELECT * FROM brand";
       $result_brand = $this->conn->query($sql_brand);
       if($result_brand->rowCount() > 0 ){
           foreach ($result_brand as $key => $value) {
               $data[$key]["brand_id"] = $value["brand_id"];
               $data[$key]["brand_desc"] = $value["brand_desc"];
   
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;
       }else{
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }
   
   public function getModel(){
       $sql_model = "SELECT * FROM model";
       $result_model = $this->conn->query($sql_model);
       if($result_model->rowCount() > 0 ){
           foreach ($result_model as $key => $value) {
               $data[$key]["model_id"] = $value["model_id"];
               $data[$key]["model_desc"] = $value["model_desc"];
   
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;
       }else{
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }
   
   public function getRegion(){
       $sql_region = "SELECT * FROM region";
       $result_region = $this->conn->query($sql_region);
       if($result_region->rowCount() > 0 ){
           foreach ($result_region as $key => $value) {
               $data[$key]["region_id"] = $value["region_id"];
               $data[$key]["region_name"] = $value["region_name"];
   
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;
       }else{
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }
   
   public function getStatus(){
       $sql_status = "SELECT * FROM status";
       $result_status = $this->conn->query($sql_status);
       if($result_status->rowCount() > 0 ){
           foreach ($result_status as $key => $value) {
               $data[$key]["status_id"] = $value["status_id"];
               $data[$key]["status_desc"] = $value["status_desc"];
   
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;
       }else{
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }
   
   public function getAgency(){
       $sql_agency = "SELECT * FROM agency";
       $result_agency = $this->conn->query($sql_agency);
       if ($result_agency->rowCount() > 0 ) {
           foreach ($result_agency as $key => $value) {
               $data[$key]["agency_id"] = $value["agency_id"];
               $data[$key]["agency_desc"] = $value["agency_desc"];
               
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;        
       }else {
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }
   
   public function getSite(){
       $sql_site = "SELECT * FROM site";
       $result_site = $this->conn->query($sql_site);
       if ($result_site->rowCount() > 0 ) {
           foreach ($result_site as $key => $value) {
               $data[$key]["site_id"] = $value["site_id"];
               $data[$key]["site_desc"] = $value["site_desc"];
               
           }
           $result_data["valid"] = true;
           $result_data["data"] = $data;        
       }else {
           $result_data["valid"] = false;
       }
       return json_encode($result_data);
   }

   public function getFaultyRecordOnLoad($location){

       $args = array("location" => $location);
       // $args = array('location_id' => $location_id);
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       LEFT JOIN region ON region.region_id = item_status.is_region_current
       LEFT JOIN user ON user.location = region.region_id
       WHERE user.location = :location AND item_status.is_status_id = 3
       GROUP BY item.item_id       
       ORDER BY item_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {
               $data[$key]["category_desc"] = $value["category_desc"];  
               $data[$key]["model_desc"] = $value["model_desc"];                
               $data[$key]["brand_desc"] = $value["brand_desc"]; 
               $data[$key]["serial_no"] =  $value["serial_no"];   
               $data[$key]["is_region_current"] =  $value["is_region_current"];
               $data[$key]["region_name"] =  $value["region_name"];
               $data[$key]["item_id"] =  $value["item_id"];
              

               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }
   
   //     public function getFaultyRecordOnLoad(){
   //     $sql = "SELECT * FROM item
   //     LEFT JOIN category ON category.category_id = item.category_id
   //     LEFT JOIN brand ON brand.brand_id = item.brand_id
   //     LEFT JOIN model ON model.model_id = item.model_id
   //     LEFT JOIN item_status ON item_status.is_item_id = item.item_id
   //     LEFT JOIN agency ON agency.agency_id = item_status.is_agency_id
   //     LEFT JOIN site ON site.site_id = item_status.is_site_id 
   //     GROUP BY item.item_id              
   //     ORDER BY item_id DESC";
   //     $result= $this->conn->prepare($sql);
   //     $result->execute();
   
   //     $i = 1;
   //     if($result-> rowCount() > 0 ){
   //         $result_data["valid"] = true;
   //         $tableOnLoad = '';
   
   //         foreach ($result as $key => $value) {
   
   //             if ($value["serial_no"] == ""){
   //                 $serial_no = "Null";
   //             }else {
   //                 $serial_no = $value["serial_no"];
   //             }   

   //             if ($value["asset_name"] == ""){
   //                 $asset_name = "Null";
   //             }else {
   //                 $asset_name = $value["asset_name"];
   //             }

   //             if ($value["barcode"] == ""){
   //                 $barcode = "Null";
   //             }else {
   //                 $barcode = $value["barcode"];
   //             }

   //             if ($value["agency_id"] == ""){
   //                 $agency_desc = "Null";
   //             }else {
   //                 $agency_desc = $value["agency_desc"];
   //             }                
   
   //             if ($value["site_id"] == ""){
   //                 $site_desc = "Null";
   //             }else {
   //                 $site_desc = $value["site_desc"];
   //             }  
                             
   //             //For loop data into table
   //             $tableOnLoad .= '
   //             <td style="text-align: center;">'.$i.'</td>               
   //             <td style="text-align: center;">'.$value["category_desc"].'</td>
   //             <td style="text-align: center;">'.$value["brand_desc"].'</td>
   //             <td style="text-align: center;">'.$serial_no.'</td>
   //             <td style="text-align: center;">'.$value["model_desc"].'</td>
   //             <td style="text-align: center;">'.$asset_name.'</td>
   //             <td style="text-align: center;">'.$barcode.'</td>
   //             <td style="text-align: center;">'.$agency_desc.'</td>
   //             <td style="text-align: center;">'.$site_desc.'</td>';
   //                 $i++;
                             
        
   //             $tableOnLoad .='

   //             </select></td><td style="text-align: center;">
   //             <a href="faulty-record-view.php?item_id='.$value["item_id"].'" target="" style="color:#000">
   //             <i class="material-icons">pageview</i></a> | <a href="faulty-record-edit.php?item_id='.$value["item_id"].'" target="" style="color:#000">
   //             <i class="material-icons">edit</i></a> | <a id='.$value["item_id"].' onclick="deleteItem(this.id);" style="color:#000"><i class="material-icons">delete</i>
   //             </a></td></tr>
   //             ';
                                                                     
   //         }
   
   //         $result_data["html"] = $tableOnLoad;
   
   
   //     }else{
   //         $result_data["valid"] = false;
   //         $result_data["msg"] = "No record!";
   //     }
   
   
   //     return json_encode($result_data);
   // }   

    public function getItemFaultyStatus($item_id){
       $args = array("item_id" => $item_id);
   
       $sql = "SELECT * FROM item_status
       LEFT JOIN item ON item_status.is_item_id = item.item_id
       LEFT JOIN site ON site.site_id = item_status.is_site_id
       LEFT JOIN agency ON agency.agency_id = item_status.is_agency_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       WHERE item_status.is_item_id = :item_id    
       ORDER BY item_status.is_id DESC";
      $result = $this->conn->prepare($sql);
        $result->execute($args);

        if($result->rowCount() > 0){

            foreach ($result as $key => $value) {
               $data[$key]["item_id"] = $value["item_id"];  
               $data[$key]["is_id"] = $value["is_id"];                
               $data[$key]["site_id"] = $value["site_id"]; 
               $data[$key]["site_desc"] =  $value["site_desc"];
               $data[$key]["agency_id"] = $value["agency_id"]; 
               $data[$key]["agency_desc"] =  $value["agency_desc"];    
               $data[$key]["status_id"] =  $value["status_id"];
               $data[$key]["status_desc"] =  $value["status_desc"]; 
               $data[$key]["is_datetime"] =  $value["is_datetime"];                

               }
            $result_data["valid"] =true;
            $result_data["data"] = $data;
        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record found.";
        }
   
   
       return json_encode($result_data);  
       
   }
   
    public function getItemFaultyByID($item_id){
   
           //Get merchant detail
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item_status 
          LEFT JOIN status ON status.status_id = item_status.is_status_id
          LEFT JOIN region ON region.region_id = item_status.is_region_current
           WHERE item_status.is_item_id = :item_id
           ORDER BY is_id DESC LIMIT 1";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject();
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               
               $result_data["is_id"] = $row->is_id;                 
               $result_data["status_id"] = $row->status_id;
               $result_data["status_desc"] = $row->status_desc;
               $result_data["region_name"] = $row->region_name;                                                                                          
               
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }
   
           return json_encode($result_data);
   
       }

       public function getFaultyStatusByID($item_id){
   
           //Get merchant detail
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item_status 
          LEFT JOIN status ON status.status_id = item_status.is_status_id
          LEFT JOIN site ON site.site_id = item_status.is_site_id
          LEFT JOIN agency ON agency.agency_id = item_status.is_agency_id
           WHERE item_status.is_item_id = :item_id
           ORDER BY is_id DESC LIMIT 1";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject();
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               
               $result_data["is_id"] = $row->is_id;                 
               $result_data["status_id"] = $row->status_id;
               $result_data["status_desc"] = $row->status_desc;
               $result_data["agency_desc"] = $row->agency_desc;
               $result_data["site_desc"] = $row->site_desc;                                                                                            
               
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }
   
           return json_encode($result_data);
   
       }
   
    public function updateItemFaulty($array){      

       $args_insert = array("item_id" => $array["item_id"], "status_id" => $array["status_id"], "site_id" => $array["site_id"], "agency_id" => $array["agency_id"]);
   
       $sql_insert = "INSERT INTO item_status SET is_status_id = :status_id, is_item_id =:item_id, is_site_id = :site_id, is_agency_id = :agency_id";
       $result_insert = $this->conn->prepare($sql_insert);
       $result_insert->execute($args_insert);
        if($result_insert){
               $result_data["valid"] = true;
               $result_data["msg"] = "Send Successful!";
           
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "Something error!!";
           }
             
       return json_encode($result_data);
   } 
   
   }
   ?>