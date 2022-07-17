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
        
            $args_add = array("user_id" => $array["user_id"], "username" => $array["username"],"department" => $array["department"], "password" => $array["password"], "role_id" => $array["role_id"], "region_id" => $array["region_id"]);


            $sql_add = "INSERT INTO user SET user_id = :user_id, user_name = :username, user_department = :department, user_password = :password, role_id = :role_id, location = :region_id";
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
        LEFT JOIN role ON role.role_id = user.role_id
        LEFT JOIN region ON region.region_id = user.location
        ORDER BY id DESC";
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
                    <td style="text-align: center;">'.$value["role_desc"].'</td>
                    <td style="text-align: center;">'.$value["region_name"].'</td>';
                    $i++;
         
                $tableOnLoad .='
                        </select>
                    </td>
                    
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
            LEFT JOIN role ON role.role_id = user.role_id
            LEFT JOIN region ON region.region_id = user.location
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
                $result_data["role_id"] = $row->role_id;
                $result_data["role_desc"] = $row->role_desc; 
                $result_data["location"] = $row->location;
                $result_data["createdAt"] = $row->createdAt;
                $result_data["region_name"] = $row->region_name;                           
                
                
            }else{
                $result_data["valid"] = false;
                $result_data["msg"] = "No record found!";
            }

            return json_encode($result_data);

        }

        public function updateUser($array){

        $args = array("id" => $array["id"], "user_id" => $array["user_id"], "user_name" => $array["user_name"], "user_department" => $array["user_department"], "role_id" => $array["role_id"], "location" => $array["location"]);

        $sql = "UPDATE user SET user_id = :user_id, user_name = :user_name, user_department = :user_department, role_id = :role_id,  location = :location WHERE id = :id";

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

        //Checking if the email already register
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
   
       public function getItemsListOnLoad(){
           
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id
       LEFT JOIN region ON region.region_id = item.region_current
       GROUP BY item.item_id       
       ORDER BY item_id DESC
       ";
       $result= $this->conn->prepare($sql);
       $result->execute();
   
       $i = 1;
       if($result-> rowCount() > 0 ){
           $result_data["valid"] = true;
           $tableOnLoad = '';
   
           foreach ($result as $key => $value) {
   
               if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }
   
               //For loop data into table
               $tableOnLoad .= '
               
               <tr>
               <td style="text-align: center;">'.$i.'</td>
               <td style="text-align: center;">'.$value["category_desc"].'</td>
               <td style="text-align: center;">'.$value["brand_desc"].'</td>
               <td style="text-align: center;">'.$serial_no.'</td>
               <td style="text-align: center;">'.$value["model_desc"].'</td>               
               <td style="text-align: center;">'.$value["region_name"].'</td>
               <td style="text-align: center;">'.$value["createdBy"].'</td>
               <td style="text-align: center;">'.$value["createdDt"].'</td>';
                   $i++;
        
               $tableOnLoad .='
                       
               </select></td><td style="text-align: center;">
               <a href="item-view.php?item_id='.$value["item_id"].'" target="" style="color:#000">
               <i class="material-icons">pageview</i></a> | <a href="item-edit.php?item_id='.$value["item_id"].'" target="" style="color:#000">
               <i class="material-icons">edit</i></a> | <a id='.$value["item_id"].' onclick="deleteItem(this.id);" style="color:#000"><i class="material-icons">delete</i>
               </a></td></tr>';
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
       }
   
   
       return json_encode($result_data);
   }
   
   public function getSendItemsListOnLoad(){
       $sql = "SELECT * FROM item
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN region ON region.region_id = item.region_id
       LEFT JOIN agency ON agency.agency_id = item.agency_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item_status.is_status_id  
       LEFT JOIN site ON site.site_id = item.site_id
       ORDER BY item_id DESC";
       $result= $this->conn->prepare($sql);
       $result->execute();
   
       $i = 1;
       if($result-> rowCount() > 0 ){
           $result_data["valid"] = true;
           $tableOnLoad = '';
   
           foreach ($result as $key => $value) {
   
               if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }
   
               if ($value["status_id"] == ""){
                   $status_desc = "None";
               }else {
                   $status_desc = $value["status_desc"];
               }
   
               if ($value["agency_id"] == ""){
                   $agency_desc = "None";
               }else {
                   $agency_desc = $value["agency_desc"];
               }                
   
               if ($value["site_id"] == ""){
                   $site_desc = "None";
               }else {
                   $site_desc = $value["site_desc"];
               }                
   
               //For loop data into table
               $tableOnLoad .= '
               <tr><td style="text-align: center;">'.$i.'</td><td style="text-align: center;">'.$value["category_desc"].'</td><td style="text-align: center;">'.$value["brand_desc"].'</td><td style="text-align: center;">'.$value["serial_no"].'</td><td style="text-align: center;">'.$value["model_desc"].'</td><td style="text-align: center;">'.$status_desc.'</td><td style="text-align: center;">'.$value["region_name"].'</td><td style="text-align: center;">'.$agency_desc.'</td><td style="text-align: center;">'.$site_desc.'</td>                    ';
                   $i++;
        
               $tableOnLoad .='
                       </select></td><td style="text-align: center;"><button><a href="send-to-region.php?item_id='.$value["item_id"].'" target="" style="color:#000">
   <i class="material-icons">edit</i></a></button></td></tr>
               ';
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
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
               $data[$key]["serial_no"] =  $serial_no;  
               $data[$key]["model_desc"] = $value["model_desc"];
               // $data[$key]["asset_name"] = $value["asset_name"];
               // $data[$key]["barcode"] = $value["barcode"];
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
   
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN site ON site.site_id = item.site_id
       LEFT JOIN agency ON agency.agency_id = item.agency_id
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

               $data[$key]["category_desc"] = $value["category_desc"];
               $data[$key]["brand_desc"] = $value["brand_desc"];
               $data[$key]["serial_no"] =  $serial_no;  
               $data[$key]["model_desc"] = $value["model_desc"];
               $data[$key]["asset_name"] = $value["asset_name"];
               $data[$key]["barcode"] = $value["barcode"];
               $data[$key]["region_from"] =  $value["region_from"];
               $data[$key]["region_current"] =  $value["region_current"];
               $data[$key]["region_name"] =  $value["region_name"];
               $data[$key]["agency_desc"] =  $value["agency_desc"];
               $data[$key]["site_desc"] =  $value["site_desc"];
               $data[$key]["region_name"] =  $value["region_name"];
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

   //  public function getSendItemsToSiteListOnLoad($location){

   //     $args = array("location" => $location);
   //     // $args = array('location_id' => $location_id);
   
   //     $sql = "SELECT * FROM item      
   //     LEFT JOIN category ON category.category_id = item.category_id
   //     LEFT JOIN brand ON brand.brand_id = item.brand_id
   //     LEFT JOIN model ON model.model_id = item.model_id
   //     LEFT JOIN site ON site.site_id = item.site_id
   //     LEFT JOIN agency ON agency.agency_id = item.agency_id
   //     LEFT JOIN item_status ON item_status.is_item_id = item.item_id
   //     LEFT JOIN status ON status.status_id = item_status.is_status_id
   //     LEFT JOIN region ON region.region_id = item_status.is_region_current
   //     LEFT JOIN user ON user.location = region.region_id
   //     WHERE user.location = :location
   //     GROUP BY item.item_id       
   //     ORDER BY item_id DESC";
   //    $result = $this->conn->prepare($sql);
   //      $result->execute($args);

   //      if($result->rowCount() > 0){

   //           foreach ($result as $key => $value) {

   //            if ($value["serial_no"] == ""){
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

   //             if ($value["agency_desc"] == ""){
   //                 $agency_desc = "Null";
   //             }else {
   //                 $agency_desc = $value["agency_desc"];
   //             }

   //             if ($value["site_desc"] == ""){
   //                 $site_desc = "Null";
   //             }else {
   //                 $site_desc = $value["site_desc"];
   //             }

   //             $data[$key]["item_id"] = $value["item_id"];
   //             $data[$key]["category_desc"] = $value["category_desc"];
   //             $data[$key]["brand_desc"] = $value["brand_desc"]; 
   //             $data[$key]["serial_no"] =  $value["serial_no"];  
   //             $data[$key]["model_desc"] = $value["model_desc"];                                  
   //             $data[$key]["asset_name"] =  $value["asset_name"];
   //             $data[$key]["barcode"] =  $value["barcode"];
   //             $data[$key]["agency_desc"] =  $value["agency_desc"];
   //             $data[$key]["site_desc"] =  $value["site_desc"];
   //             $data[$key]["region_name"] =  $value["region_name"];

   //             }
   //          $result_data["valid"] =true;
   //          $result_data["data"] = $data;
   //      }else{
   //          $result_data["valid"] = false;
   //          $result_data["msg"] = "No record found.";
   //      }
   
   
   //     return json_encode($result_data);  
       
   // }     

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

        public function getItemStatusByID2($item_id){
   
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item 
          LEFT JOIN status ON status.status_id = item.status_id
          LEFT JOIN region ON region.region_id = item.region_current
           WHERE item.item_id = :item_id
           ORDER BY is_id DESC LIMIT 1";
           $result = $this->conn->prepare($sql);
           $result->execute($args);
           $row = $result->fetchObject();
   
           if($result->rowCount() > 0){
               $result_data["valid"] = true;
               $result_data["msg"] = "Get detail!!";
               
               $result_data["is_id"] = $row->is_id;                 
               $result_data["status_id"] = $row->status_id;
               $result_data["region_name"] = $row->region_name;    
               $result_data["region_current"] = $row->region_current;                                                                                        
               
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
               WHERE item_id = :item_id";
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
                   $result_data["region_name"] = $row->region_name;
                   $result_data ["agency_id"] = $row->agency_id;
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

   public function addRequest($array){
        
            $args_add = array("category_id" => $array["category_id"], "region_id" => $array["region_id"], "quantity" => $array["quantity"]);


            $sql_add = "INSERT INTO request SET category_id = :category_id, region_id = :region_id, quantity = :quantity";
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

   public function getRequestListOnLoad(){
           
   
       $sql = "SELECT * FROM request      
       LEFT JOIN category ON category.category_id = request.category_id
       LEFT JOIN region ON region.region_id = request.region_id
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
               <td style="text-align: center;">'.$value["category_desc"].'</td>              
               <td style="text-align: center;">'.$value["region_name"].'</td>
               <td style="text-align: center;">'.$value["quantity"].'</td>';
                   $i++;

               $tableOnLoad .='
                       
               </select></td><td style="text-align: center;">
               <a id='.$value["request_id"].' onclick="deleteRequest(this.id);" style="color:#000"><i class="material-icons">delete</i>
               </a></td></tr>';
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
       }
   
   
       return json_encode($result_data);
   }

   public function deleteRequest($array){
   
       //Delete from database
       $args_delete_request = array("request_id" => $array["request_id"]);
       $sql_delete_request = "DELETE FROM request WHERE request_id = :request_id";
       $result_delete_request = $this->conn->prepare($sql_delete_request);
       $result_delete_request->execute($args_delete_request);
   
       if($result_delete_request){
           $result_data["valid"] = true;
           $result_data["msg"] = "Item has been deleted.";
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "Something error!!";
       }
       return json_encode($result_data);
   }
   
   public function getCategoryListOnLoad(){
        $sql = "SELECT *,
                count(case when region_current='2' AND agency_id='' then 1 end),
                count(case when region_current='4' AND agency_id='' then 1 end),
                count(case when region_current='3' AND agency_id='' then 1 end),
                count(case when region_current='6' AND agency_id='' then 1 end),
                count(case when region_current='7' AND agency_id='' then 1 end),
                count(case when region_current='8' AND agency_id='' then 1 end),
                count(case when region_current='9' AND agency_id='' then 1 end),
                count(case when region_current='10' AND agency_id='' then 1 end),
                count(case when region_current='11' AND agency_id='' then 1 end),
                count(case when region_current='12' AND agency_id='' then 1 end),
                count(case when region_current='14' AND agency_id='' then 1 end),
                count(case when region_current='18' AND agency_id='' then 1 end),
                count(case when region_current='19' AND agency_id='' then 1 end)
                FROM item
                RIGHT JOIN category ON category.category_id=item.category_id
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
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Kedah" target="">'.$value["count(case when region_current='2' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Sabah" target="">'.$value["count(case when region_current='4' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Johor" target="">'.$value["count(case when region_current='3' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Terengganu" target="">'.$value["count(case when region_current='6' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Labuan" target="">'.$value["count(case when region_current='7' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Perak" target="">'.$value["count(case when region_current='8' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Kelantan" target="">'.$value["count(case when region_current='9' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Pulau Pinang" target="">'.$value["count(case when region_current='10' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Melaka" target="">'.$value["count(case when region_current='11' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Pahang" target="">'.$value["count(case when region_current='12' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Miri" target="">'.$value["count(case when region_current='14' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Kuching" target="">'.$value["count(case when region_current='18' AND agency_id='' then 1 end)"].'</a></td>
                    <td style="text-align: center;"><a href="home-view.php?category_desc='.$value["category_desc"].'&region_name=Perlis" target="">'.$value["count(case when region_current='19' AND agency_id='' then 1 end)"].'</a></td>';
                    $i++;   
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }
   
   public function getSummaryListOnLoad(){
        $sql = "SELECT *,
                count(case when region_current='2' AND agency_id='' then 1 end),
                count(case when region_current='4' AND agency_id='' then 1 end),
                count(case when region_current='3' AND agency_id='' then 1 end),
                count(case when region_current='6' AND agency_id='' then 1 end),
                count(case when region_current='7' AND agency_id='' then 1 end),
                count(case when region_current='8' AND agency_id='' then 1 end),
                count(case when region_current='9' AND agency_id='' then 1 end),
                count(case when region_current='10' AND agency_id='' then 1 end),
                count(case when region_current='11' AND agency_id='' then 1 end),
                count(case when region_current='12' AND agency_id='' then 1 end),
                count(case when region_current='14' AND agency_id='' then 1 end),
                count(case when region_current='18' AND agency_id='' then 1 end)
                FROM item
                RIGHT JOIN category ON category.category_id=item.category_id
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
                    <td style="text-align: center;">'.$value["count(case when region_current='2' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='4' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='3' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='6' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='7' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='8' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='9' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='10' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='11' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='12' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='14' AND agency_id='' then 1 end)"].'</td>
                    <td style="text-align: center;">'.$value["count(case when region_current='18' AND agency_id='' then 1 end)"].'</td>';
                    $i++;   
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

    public function getSummaryGraph(){
        $sql = "SELECT category_desc, 
                count(case when region_current='2' AND agency_id='0' then 1 end) as kedah, 
                count(case when region_current='4' AND agency_id='0' then 1 end) as sabah,
                count(case when region_current='3' AND agency_id='0' then 1 end) as johor,
                count(case when region_current='6' AND agency_id='0' then 1 end) as terengganu,
                count(case when region_current='7' AND agency_id='0' then 1 end) as labuan,
                count(case when region_current='8' AND agency_id='0' then 1 end) as perak,
                count(case when region_current='9' AND agency_id='0' then 1 end) as kelantan,
                count(case when region_current='10' AND agency_id='0' then 1 end) as penang,
                count(case when region_current='11' AND agency_id='0' then 1 end) as melaka,
                count(case when region_current='12' AND agency_id='0' then 1 end) as pahang,
                count(case when region_current='14' AND agency_id='0' then 1 end) as miri,
                count(case when region_current='18' AND agency_id='0' then 1 end) as kuching
        FROM item 
        RIGHT JOIN category ON category.category_id=item.category_id 
        GROUP BY category_desc 
        ORDER BY category_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();
        $result_data = array();
        foreach ($result as $row) {
          $result_data[] = $row;
        }
        return json_encode($result_data);
    }
   
    public function getMonthlyItemListOnLoad(){
        $result = [];
        $allcategory = $this->conn->prepare("SELECT * FROM category");
        $allcategory->execute();

        foreach($allcategory as $c){
            $categorycollection = [];
            $catid = $c['category_id'];

            $jan = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-01-%'");
            $feb = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-02-%'");
            $mac = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-03-%'");
            $apr = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-04-%'");
            $may = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-05-%'");
            $jun = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-06-%'");
            $jul = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-07-%'");
            $aug = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-08-%'");
            $sep = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-09-%'");
            $oct = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-10-%'");
            $nov = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-11-%'");
            $dec = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-12-%'");

            $jan->execute();
            $feb->execute();
            $mac->execute();
            $apr->execute();
            $may->execute();
            $jun->execute();
            $jul->execute();
            $aug->execute();
            $sep->execute();
            $oct->execute();
            $nov->execute();
            $dec->execute();

            $categorycollection['category_desc'] = $c['category_desc'];
            $categorycollection['one']    = count($jan->fetchAll());
            $categorycollection['two']    = count($feb->fetchAll());
            $categorycollection['three']  = count($mac->fetchAll());
            $categorycollection['four']   = count($apr->fetchAll());
            $categorycollection['five']   = count($may->fetchAll());
            $categorycollection['six']    = count($jun->fetchAll());
            $categorycollection['seven']  = count($jul->fetchAll());
            $categorycollection['eight']  = count($aug->fetchAll());
            $categorycollection['nine']   = count($sep->fetchAll());
            $categorycollection['ten']    = count($oct->fetchAll());
            $categorycollection['eleven'] = count($nov->fetchAll());
            $categorycollection['twelve'] = count($dec->fetchAll());
            $result[] = $categorycollection;
        }

       /*$sql = "SELECT category_desc,
               count(case when month(datetime)='1' then 1 end) as one,
               count(case when month(datetime)='2' OR month(datetime)='1' then 1 end) as two,
               count(case when month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as three,
               count(case when month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as four,
               count(case when month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as five,
               count(case when month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as six,
               count(case when month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as seven,
               count(case when month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as eight,
               count(case when month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as nine,
               count(case when month(datetime)='10' OR month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as ten,
               count(case when month(datetime)='11' OR month(datetime)='10' OR month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as eleven,
               count(case when month(datetime)='12' OR month(datetime)='11' OR month(datetime)='10' OR month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as twelve
               FROM monthly
               RIGHT JOIN category ON category.category_id=monthly.category_id
               GROUP BY category_desc
               ORDER BY category_desc ASC";
       $result = $this->conn->prepare($sql);
       $result->execute();*/
   
        $i = 1;
        if(count($result) > 0 ){
            $result_data["valid"] = true;
            $tableOnLoad = '';

            foreach ($result as $key => $value) { 

                //For loop data into table
                $tableOnLoad .= '
                <tr>
                    <td style="text-align: center;">'.$value["category_desc"].'</td>
                    <td style="text-align: center;">'.$value["one"].'</td>
                    <td style="text-align: center;">'.$value["two"].'</td>
                    <td style="text-align: center;">'.$value["three"].'</td>
                    <td style="text-align: center;">'.$value["four"].'</td>
                    <td style="text-align: center;">'.$value["five"].'</td>
                    <td style="text-align: center;">'.$value["six"].'</td>
                    <td style="text-align: center;">'.$value["seven"].'</td>
                    <td style="text-align: center;">'.$value["eight"].'</td>
                    <td style="text-align: center;">'.$value["nine"].'</td>
                    <td style="text-align: center;">'.$value["ten"].'</td>
                    <td style="text-align: center;">'.$value["eleven"].'</td>
                    <td style="text-align: center;">'.$value["twelve"].'</td>';
                    $i++;   
            }

            $result_data["html"] = $tableOnLoad;


        }else{
            $result_data["valid"] = false;
            $result_data["msg"] = "No record!";
        }
        return json_encode($result_data);
    }

     public function getMonthlyGraph(){
        $result = [];
        $allcategory = $this->conn->prepare("SELECT * FROM category");
        $allcategory->execute();

        foreach($allcategory as $c){
            $categorycollection = [];
            $catid = $c['category_id'];

            $jan = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-01-%'");
            $feb = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-02-%'");
            $mac = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-03-%'");
            $apr = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-04-%'");
            $may = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-05-%'");
            $jun = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-06-%'");
            $jul = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-07-%'");
            $aug = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-08-%'");
            $sep = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-09-%'");
            $oct = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-10-%'");
            $nov = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-11-%'");
            $dec = $this->conn->prepare("SELECT * FROM `category` JOIN item WHERE item.category_id = category.category_id AND category.category_id='".$catid."' AND item.createdDt LIKE '%-12-%'");

            $jan->execute();
            $feb->execute();
            $mac->execute();
            $apr->execute();
            $may->execute();
            $jun->execute();
            $jul->execute();
            $aug->execute();
            $sep->execute();
            $oct->execute();
            $nov->execute();
            $dec->execute();

            $categorycollection['category_desc'] = $c['category_desc'];
            $categorycollection['january']    = count($jan->fetchAll());
            $categorycollection['february']    = count($feb->fetchAll());
            $categorycollection['march']  = count($mac->fetchAll());
            $categorycollection['april']   = count($apr->fetchAll());
            $categorycollection['may']   = count($may->fetchAll());
            $categorycollection['june']    = count($jun->fetchAll());
            $categorycollection['july']  = count($jul->fetchAll());
            $categorycollection['august']  = count($aug->fetchAll());
            $categorycollection['september']   = count($sep->fetchAll());
            $categorycollection['october']    = count($oct->fetchAll());
            $categorycollection['november'] = count($nov->fetchAll());
            $categorycollection['december'] = count($dec->fetchAll());
            $result[] = $categorycollection;
        }
        
        /*$sql = "SELECT category_desc,
               count(case when month(datetime)='1' then 1 end) as january,
               count(case when month(datetime)='2' OR month(datetime)='1' then 1 end) as february,
               count(case when month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as march,
               count(case when month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as april,
               count(case when month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as may,
               count(case when month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as june,
               count(case when month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as july,
               count(case when month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as august,
               count(case when month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as september,
               count(case when month(datetime)='10' OR month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as october,
               count(case when month(datetime)='11' OR month(datetime)='10' OR month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as november,
               count(case when month(datetime)='12' OR month(datetime)='11' OR month(datetime)='10' OR month(datetime)='9' OR month(datetime)='8' OR month(datetime)='7' OR month(datetime)='6' OR month(datetime)='5' OR month(datetime)='4' OR month(datetime)='3' OR month(datetime)='2' OR month(datetime)='1' then 1 end) as december
               FROM monthly
               RIGHT JOIN category ON category.category_id=monthly.category_id
               GROUP BY category_desc
               ORDER BY category_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();*/
        $result_data = array();
        foreach ($result as $row) {
          $result_data[] = $row;
        }
        return json_encode($result_data);
    }

   public function getItemListByRegionOnLoad(){
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item.status_id
       LEFT JOIN region ON region.region_id = item.region_current
       GROUP BY item.item_id       
       ORDER BY region_name DESC
       ";
       $result= $this->conn->prepare($sql);
       $result->execute();
   
       $i = 1;
       if($result-> rowCount() > 0 ){
           $result_data["valid"] = true;
           $tableOnLoad = '';
   
           foreach ($result as $key => $value) {
   
               if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }
   
               //For loop data into table
               $tableOnLoad .= '
               
               <tr>
               <td style="text-align: center;">'.$i.'</td>
               <td style="text-align: center;">'.$value["category_desc"].'</td>
               <td style="text-align: center;">'.$value["brand_desc"].'</td>
               <td style="text-align: center;">'.$serial_no.'</td>
               <td style="text-align: center;">'.$value["model_desc"].'</td>               
               <td style="text-align: center;">'.$value["region_name"].'</td>';
                   $i++;
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
       }
   
   
       return json_encode($result_data);
   }

   public function getRegionGraph(){
        $sql = "SELECT region_name, 
                COUNT(region_name) as total 
                FROM item 
                LEFT JOIN region ON region.region_id=item.region_current 
                GROUP BY region_current";
        $result= $this->conn->prepare($sql);
        $result->execute();
        $result_data = array();
        foreach ($result as $row) {
          $result_data[] = $row;
        }
        return json_encode($result_data);
    }
   
   public function getItemListByAgencyOnLoad(){
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item.status_id
       LEFT JOIN region ON region.region_id = item.region_current
       LEFT JOIN agency ON agency.agency_id=item.agency_id
       LEFT JOIN site ON site.site_id=item.site_id
       GROUP BY item.item_id       
       ORDER BY agency_desc DESC
       ";
       $result= $this->conn->prepare($sql);
       $result->execute();
   
       $i = 1;
       if($result-> rowCount() > 0 ){
           $result_data["valid"] = true;
           $tableOnLoad = '';
   
           foreach ($result as $key => $value) {
   
               if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }

               if ($value["agency_id"] == ""){
                   $agency_desc = "Null";
               }else {
                   $agency_desc = $value["agency_desc"];
               }

               if ($value["site_id"] == ""){
                   $site_desc = "Null";
               }else {
                   $site_desc = $value["site_desc"];
               }
   
               //For loop data into table
               $tableOnLoad .= '
               
               <tr>
               <td style="text-align: center;">'.$i.'</td>
               <td style="text-align: center;">'.$value["category_desc"].'</td>
               <td style="text-align: center;">'.$value["brand_desc"].'</td>
               <td style="text-align: center;">'.$serial_no.'</td>
               <td style="text-align: center;">'.$value["model_desc"].'</td>               
               <td style="text-align: center;">'.$value["region_name"].'</td>
               <td style="text-align: center;">'.$agency_desc.'</td>
               <td style="text-align: center;">'.$site_desc.'</td>';
                   $i++;
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
       }
   
   
       return json_encode($result_data);
   }

   public function getAgencyGraph(){
        $sql = "SELECT agency_desc, 
                COUNT(agency_desc) as total 
                FROM item 
                JOIN agency ON agency.agency_id=item.agency_id 
                GROUP BY agency_desc";
        $result= $this->conn->prepare($sql);
        $result->execute();
        $result_data = array();
        foreach ($result as $row) {
          $result_data[] = $row;
        }
        return json_encode($result_data);
    }

   public function getItemListByStatusOnLoad(){
       $sql = "SELECT * FROM item      
       LEFT JOIN category ON category.category_id = item.category_id
       LEFT JOIN brand ON brand.brand_id = item.brand_id
       LEFT JOIN model ON model.model_id = item.model_id
       LEFT JOIN item_status ON item_status.is_item_id = item.item_id
       LEFT JOIN status ON status.status_id = item.status_id
       LEFT JOIN region ON region.region_id = item.region_current
       LEFT JOIN agency ON agency.agency_id=item.agency_id
       GROUP BY item.item_id          
       ORDER BY status_desc DESC
       ";
       $result= $this->conn->prepare($sql);
       $result->execute();
   
       $i = 1;
       if($result-> rowCount() > 0 ){
           $result_data["valid"] = true;
           $tableOnLoad = '';
   
           foreach ($result as $key => $value) {
   
               if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }
   
               //For loop data into table
               $tableOnLoad .= '
               
               <tr>
               <td style="text-align: center;">'.$i.'</td>
               <td style="text-align: center;">'.$value["category_desc"].'</td>
               <td style="text-align: center;">'.$value["brand_desc"].'</td>
               <td style="text-align: center;">'.$serial_no.'</td>
               <td style="text-align: center;">'.$value["model_desc"].'</td>               
               <td style="text-align: center;">'.$value["status_desc"].'</td>';
                   $i++;
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
       }
   
   
       return json_encode($result_data);
   }

   public function getStatusGraph(){
        $sql = "SELECT status_desc, 
                COUNT(status_desc) as total 
                FROM item 
                LEFT JOIN status ON status.status_id=item.status_id 
                GROUP BY status_desc";
        $result= $this->conn->prepare($sql);
        $result->execute();
        $result_data = array();
        foreach ($result as $row) {
          $result_data[] = $row;
        }
        return json_encode($result_data);
    }

    public function test(){
        $sql = "SELECT category_desc, 
                count(case when region_current='2' AND agency_id='0' then 1 end) as kedah, 
                count(case when region_current='4' AND agency_id='0' then 1 end) as sabah,
                count(case when region_current='3' AND agency_id='0' then 1 end) as johor,
                count(case when region_current='6' AND agency_id='0' then 1 end) as terengganu,
                count(case when region_current='7' AND agency_id='0' then 1 end) as labuan,
                count(case when region_current='8' AND agency_id='0' then 1 end) as perak,
                count(case when region_current='9' AND agency_id='0' then 1 end) as kelantan,
                count(case when region_current='10' AND agency_id='0' then 1 end) as penang,
                count(case when region_current='11' AND agency_id='0' then 1 end) as melaka,
                count(case when region_current='12' AND agency_id='0' then 1 end) as pahang,
                count(case when region_current='14' AND agency_id='0' then 1 end) as miri,
                count(case when region_current='18' AND agency_id='0' then 1 end) as kuching
        FROM item 
        RIGHT JOIN category ON category.category_id=item.category_id 
        GROUP BY category_desc 
        ORDER BY category_desc ASC";
        $result= $this->conn->prepare($sql);
        $result->execute();
        $result_data = array();
        foreach ($result as $row) {
          $result_data[] = $row;
        }
        return json_encode($result_data);
    }

   public function getItemListByDeliveryOnLoad(){
       $sql = "SELECT category_desc, brand_desc, serial_no, model_desc, region_name, MAX(`is_datetime`) AS receive, MIN(`is_datetime`) AS send, DATEDIFF(MAX(`is_datetime`), MIN(`is_datetime`)) AS duration 
               FROM item 
               LEFT JOIN category ON category.category_id = item.category_id 
               LEFT JOIN brand ON brand.brand_id = item.brand_id 
               LEFT JOIN model ON model.model_id = item.model_id 
               LEFT JOIN item_status ON item_status.is_item_id = item.item_id 
               LEFT JOIN status ON status.status_id = item_status.is_status_id 
               LEFT JOIN region ON region.region_id = item.region_current 
               LEFT JOIN agency ON agency.agency_id=item.agency_id 
               WHERE is_agency_id='0' 
               GROUP BY item.item_id 
               ORDER BY duration DESC
       ";
       $result= $this->conn->prepare($sql);
       $result->execute();
   
       $i = 1;
       if($result-> rowCount() > 0 ){
           $result_data["valid"] = true;
           $tableOnLoad = '';
   
           foreach ($result as $key => $value) {
   
               if ($value["serial_no"] == ""){
                   $serial_no = "Null";
               }else {
                   $serial_no = $value["serial_no"];
               }

               if ($value["send"] ==  $value["receive"]){
                   $duration = "Null";
               }else {
                   $duration = $value["duration"];
               }
   
               //For loop data into table
               $tableOnLoad .= '
               
               <tr>
               <td style="text-align: center;">'.$i.'</td>
               <td style="text-align: center;">'.$value["category_desc"].'</td>
               <td style="text-align: center;">'.$value["brand_desc"].'</td>
               <td style="text-align: center;">'.$serial_no.'</td>
               <td style="text-align: center;">'.$value["model_desc"].'</td> 
               <td style="text-align: center;">'.$value["send"].'</td>
               <td style="text-align: center;">'.$value["receive"].'</td>              
               <td style="text-align: center;">'.$value["region_name"].'</td>
               <td style="text-align: center;">'.$duration.'</td>';
                   $i++;
           }
   
           $result_data["html"] = $tableOnLoad;
   
   
       }else{
           $result_data["valid"] = false;
           $result_data["msg"] = "No record!";
       }
   
   
       return json_encode($result_data);
   }

   public function getDeliveryStatusGraph(){
        $sql = "SELECT category_desc, brand_desc, serial_no, model_desc, region_name, MAX(`is_datetime`) AS receive, MIN(`is_datetime`) AS send, DATEDIFF(MAX(`is_datetime`), MIN(`is_datetime`)) AS duration 
               FROM item 
               LEFT JOIN category ON category.category_id = item.category_id 
               LEFT JOIN brand ON brand.brand_id = item.brand_id 
               LEFT JOIN model ON model.model_id = item.model_id 
               LEFT JOIN item_status ON item_status.is_item_id = item.item_id 
               LEFT JOIN status ON status.status_id = item_status.is_status_id 
               LEFT JOIN region ON region.region_id = item.region_current 
               LEFT JOIN agency ON agency.agency_id=item.agency_id 
               WHERE is_agency_id='0' 
               GROUP BY item.item_id 
               ORDER BY duration DESC";
        $result= $this->conn->prepare($sql);
        $result->execute();
        $result_data = $result->fetchAll(PDO::FETCH_OBJ);
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

    public function getRole(){
       $sql_role = "SELECT * FROM role";
       $result_role = $this->conn->query($sql_role);
       if($result_role->rowCount() > 0 ){
           foreach ($result_role as $key => $value) {
               $data[$key]["role_id"] = $value["role_id"];
               $data[$key]["role_desc"] = $value["role_desc"];
   
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

    public function getFaultyStatus($item_id){
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

   public function getFaultyRecordByID($item_id){
         
           $args = array("item_id" => $item_id);
           $sql = "SELECT * FROM item
           LEFT JOIN model ON model.model_id = item.model_id
           LEFT JOIN brand ON brand.brand_id = item.brand_id
           LEFT JOIN category ON category.category_id = item.category_id
           LEFT JOIN region ON region.region_id = item.region_current
           -- LEFT JOIN agency ON agency.agency_id = item.agency_id
           -- LEFT JOIN item_status ON item_status.is_item_id = item.item_id
           -- LEFT JOIN status ON status.status_id = item_status.is_status_id           
           -- LEFT JOIN site ON site.site_id = item.site_id
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
               $result_data["asset_name"] = $row->asset_name;                                                                                        
               $result_data["barcode"] = $row->barcode;
               // $result_data["lastModifiedBy"] = $row->lastModifiedBy;
               $result_data["lastModifiedDt"] = $row->lastModifiedDt;
               $result_data["region_from"] = $row->region_from; 
               $result_data["region_current"] = $row->region_current;                                                                              
               
           }else{
               $result_data["valid"] = false;
               $result_data["msg"] = "No record found!";
           }
   
           return json_encode($result_data);
   
       }

       public function updateFaulty($array){
   
       $args = array("item_id" => $array["item_id"], "category_id" => $array["category_id"], "brand_id" => $array["brand_id"], "model_id" => $array["model_id"], "serial_no" => $array["serial_no"],  "asset_name" => $array["asset_name"], "barcode" => $array["barcode"], "lastModifiedBy" => $array["lastModifiedBy"],  "region_from" => $array["region_from"], "region_current" => $array["region_current"]);       
   
       $sql = "UPDATE item SET  category_id = :category_id, brand_id = :brand_id, serial_no = :serial_no, model_id = :model_id, asset_name = :asset_name, barcode = :barcode, lastModifiedBy = :lastModifiedBy, region_from = :region_from, region_current = :region_current WHERE item_id = :item_id"; 
   
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
   
   }
   ?>