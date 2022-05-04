<?php
include "inc/user2.php";
$user = new Users();

$result_item_detail = $user->getSendItemsDetailByID($_GET["item_id"]);
$array_item_detail = json_decode($result_item_detail,true);

$result_model = $user->getModel();
$array_model = json_decode($result_model, true);

$result_category = $user->getCategory();
$array_category = json_decode($result_category, true);

$result_brand = $user->getBrand();
$array_brand = json_decode($result_brand, true);

$result_region = $user->getRegion();
$array_region = json_decode($result_region, true);

$result_status = $user->getStatus();
$array_status = json_decode($result_status, true);

// $user = $_SESSION['username'];

?>

<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
      <?php $sidebar = "item-list"; ?>
         
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <?php include "inc/sidebar.php"; ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
               <div class="container-fluid">
                  <div class="row mb-2">
                     <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Send Item</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item"><a href="region-list.php">Send Item List</a></li>
                           <li class="breadcrumb-item active">Send Item</li>
                        </ol>
                     </div>
                     <!-- /.col -->
                  </div>
                  <!-- /.row -->
               </div>
               <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
               <div class="container-fluid">
                  <!-- Small boxes (Stat box) -->
                  <div class="row">
                  </div>
                  <!-- /.row -->
                  <!-- Main row -->
                  <div class="row">
                     <!-- Left col -->
                     <section class="col-lg-12 connectedSortable">
                        <div class="card">
                           <!-- /.card-header -->
                           <div class="card-body">
                            <div class="padding_div">
                            <div class="parallel_div">
                          
                <div class="parallel_align">
                <div class="parallel_left">
      
                <div class="parallel_content">
                  <p>ITEM INFORMATION</p>
                  <input type="hidden" name="item_id" id="item_id" value="<?php echo $array_item_detail["item_id"]; ?>">
                  <?php
                    if($array_item_detail["valid"]){
                      ?>
                      <p class="parallel_text_left">Item ID</p>
                      <p class="parallel_text_right"> <input type="text" class="form-control" name="item_id" value="<?php echo $array_item_detail["item_id"]; ?>" disabled></p>

                      <p class="parallel_text_left">Category</p>
                      <p class="parallel_text_right"> 
                        <select class="form-control" id="category_id">
                        <?php for($i = 0; $i < count($array_category["data"]); $i++){?>
                         <option value="<?php echo $array_category["data"][$i]["category_id"];?>"
                          <?php echo $array_item_detail["category_id"] == $array_category["data"][$i]["category_id"] ? "selected" : ""; ?>><?php echo $array_category["data"][$i]["category_desc"]; ?></option>
                        <?php } ?>
                       </select>

                       <p class="parallel_text_left">Brand</p>
                      <p class="parallel_text_right"> 
                        <select class="form-control" id="brand_id">                          
                        <?php for($i = 0; $i < count($array_brand["data"]); $i++){?>
                         <option value="<?php echo $array_brand["data"][$i]["brand_id"];?>"
                          <?php echo $array_item_detail["brand_id"] == $array_brand["data"][$i]["brand_id"] ? "selected" : ""; ?>><?php echo $array_brand["data"][$i]["brand_desc"]; ?></option>
                        <?php } ?>
                       </select>

                       <?php
                      if($array_item_detail["serial_no"] != ""){
                        $serial_no = $array_item_detail["serial_no"];
                      }else{
                        $serial_no = "Null";
                      }
                          ?>

                      <p class="parallel_text_left">Serial Number</p>
                      <p class="parallel_text_right">
                        <input type="text" name="serial_no" id="serial_no" class="form-control" value="<?php echo $serial_no; ?>" disabled></p>
                    
                      <p class="parallel_text_left">Model</p>
                      <p class="parallel_text_right"> 
                       <select class="form-control" id="model_id">
                        <?php for($i = 0; $i < count($array_model["data"]); $i++){?>
                         <option value="<?php echo $array_model["data"][$i]["model_id"];?>"
                          <?php echo $array_item_detail["model_id"] == $array_model["data"][$i]["model_id"] ? "selected" : ""; ?>><?php echo $array_model["data"][$i]["model_desc"]; ?></option>
                        <?php } ?>
                       </select>

                       <p class="parallel_text_left">Asset Name</p>
                      <p class="parallel_text_right"> 
                        <input type="text" name="asset_name" id="asset_name" class="form-control" value="<?php echo $array_item_detail["asset_name"]; ?>" ></p>

                        <p class="parallel_text_left">Barcode</p>
                      <p class="parallel_text_right"> 
                        <input type="text" name="barcode" id="barcode" class="form-control" value="<?php echo $array_item_detail["barcode"]; ?>"></p> 

                         <p class="parallel_text_left">Status</p>
                      <input type="hidden" name="status" id="status" class="form-control" value="<?php echo $array_item_detail["status_id"]?>">
                      <p class="parallel_text_right">
                         <select class="form-control" id="status_id">
                        <?php for($i = 0; $i < count($array_status["data"]); $i++){?>
                         <option value="<?php echo $array_status["data"][$i]["status_id"];?>"
                          <?php echo $array_item_detail["status_id"] == $array_status["data"][$i]["status_id"] ? "selected" : ""; ?>><?php echo $array_status["data"][$i]["status_desc"]; ?></option>
                        <?php } ?>
                       </select>  

                       <p class="parallel_text_left">Last Modified By</p>
                      <p class="parallel_text_right"> 
                        <input type="text" name="lastModifiedBy" id="lastModifiedBy" class="form-control" value="<?php echo $array_item_detail["lastModifiedBy"]; ?>" ></p>                               

                       <p class="parallel_text_left">Location</p>
                      <input type="hidden" name="region" id="region_from" class="form-control" value="<?php echo $array_item_detail["region_current"]?>">
                      <p class="parallel_text_right">
                         <select class="form-control" id="region_current">
                        <?php for($i = 0; $i < count($array_region["data"]); $i++){?>
                         <option value="<?php echo $array_region["data"][$i]["region_id"];?>"
                          <?php echo $array_item_detail["region_current"] == $array_region["data"][$i]["region_id"] ? "selected" : ""; ?>><?php echo $array_region["data"][$i]["region_name"]; ?></option>
                        <?php } ?>
                       </select>

                       <p class="parallel_text_left">Delivery Date</p>
                      <p class="parallel_text_right"> 
                        <input type="text" name="lastModifiedDt" id="lastModifiedDt" class="form-control" value="<?php echo $array_item_detail["lastModifiedDt"]; ?>" ></p>                      
              
                     <?php
                    }else{
                      echo $array_item_detail["msg"];
                    }
                  ?>

                  <div align="right">
                      <button class="btn btn-danger general_btn" onclick="window.location.href='region-list.php'">Cancel</button>
                      <button class="btn btn-primary general_btn" onclick="submit();">Send</button>
                    </div>
                </div>
            </div>


          </div>
                              
                           </div>
                           <!-- /.card-body -->
                        </div> 
                     </section>
                     <!-- right col -->
                  </div>
                  <!-- /.row (main row) -->
               </div>
               <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <!-- <footer class="main-footer">
            <?php include "inc/footer.php"; ?>
         </footer> -->
         <!-- Control Sidebar -->
         <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
         </aside>
         <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      <?php include "inc/js.php"; ?>
       <script type="text/javascript">
      function submit(){

        var item_id = $("#item_id").val();
        var is_id = $("#is_id").val();
        var category_id = $("#category_id").val();
        var brand_id = $("#brand_id").val();
        var serial_no = $("#serial_no").val();
        var model_id = $("#model_id").val();
        var asset_name = $("#asset_name").val();
        var barcode = $("#barcode").val();
        var status_id = $("#status_id").val();
        var lastModifiedBy = $("#lastModifiedBy").val();                                
        var region_current = $("#region_current").val();
        var agency_id = $("#agency_id").val();                        
        var region_from = $("#region_from").val();

              
        var formData = new FormData();

        formData.append("action","updateSendItem");
        formData.append("item_id", item_id);
        formData.append("is_id", is_id);
        formData.append("category_id",category_id);
        formData.append("brand_id",brand_id);
        formData.append("serial_no",serial_no);
        formData.append("model_id",model_id);                              
        formData.append("asset_name",asset_name);
        formData.append("barcode",barcode);
        formData.append("status_id",status_id);
        formData.append("lastModifiedBy",lastModifiedBy);
        formData.append("region_current",region_current);
        formData.append("region_from",region_from);
        formData.append("agency_id",agency_id);        
        

        if(region_from == region_current){
          swal({
                    type:'error',
                    title:'error!',
                    html:"Same Location"
                   }).then(function(){
                  });
        }else{
          $.ajax({
                type:"post",
                url:"action2.php",
                data:formData,
                cache: false,
                        contentType: false,
                        processData: false,
                success:function(result){
                  console.log(region_from);
                  console.log(region_current);
                  var result_obj = JSON.parse(result);

                  if(result_obj.valid){
                    swal({
                      type:"success",
                      title:'Success',
                      html:result_obj.msg
                    }).then(function(){
                      document.location = "region-list.php";
                    });
                  }else{
                    swal({
                      type:"error",
                      title:'Oops..',
                      html: result_obj.msg
                    });
                  }
                }

              })

        }

        
      // }
    }
  
 
      </script>


      
   </body>
</html>