<?php include "inc/app-top.php"; 
include "inc/admin2.php";

$admin = new Admins();
$result_category = $admin->getCategory();
$array_category = json_decode($result_category,true);

$result_brand = $admin->getBrand();
$array_brand = json_decode($result_brand,true);

$result_model = $admin->getModel();
$array_model = json_decode($result_model,true);

$result_region = $admin->getRegion();
$array_region = json_decode($result_region,true);

$result_status = $admin->getStatus();
$array_status = json_decode($result_status,true);

$admin = $_SESSION['username'];

   ?>
<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
      <style>
        .user-form {
        display: inline-block !important;
        width: 60% !important;
        margin: 3px 0 !important;
        padding: 5px 10px !important;
    }

    .user-submit{
      margin-top: 20px;
      float: right;
    }

    .card-body{
      width: 100% !important;

    }

      </style>
    
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
                        <h1 class="m-0 text-dark">New Item</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">New Item</li>
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
                            
                                 <div class="row">
                                
                                    <div  class="col-sm-6">
                                       <label for="category_id">Category</label><br>
                                       <select class="form-control" id="category_id">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_category["data"]); $i++){  ?>
                                          <option value="<?php echo $array_category['data'][$i]['category_id']; ?>"><?php echo $array_category['data'][$i]['category_desc']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div>

                                    <div  class="col-sm-6">
                                       <label for="brand_id">Brand</label><br>
                                       <select class="form-control" id="brand_id">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_brand["data"]); $i++){  ?>
                                          <option value="<?php echo $array_brand['data'][$i]['brand_id']; ?>"><?php echo $array_brand['data'][$i]['brand_desc']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div> 

                                    <div  class="col-sm-6">
                                       <label for="serial_no">Serial Number</label><br>
                                       <input type="text" id="serial_no" name="serial_no" class="form-control item-form">
                                    </div>

                                    <div  class="col-sm-6">
                                       <label for="model_id">Model</label><br>
                                       <select class="form-control" id="model_id">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_model["data"]); $i++){  ?>
                                          <option value="<?php echo $array_model['data'][$i]['model_id']; ?>"><?php echo $array_model['data'][$i]['model_desc']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div>                                    

                                    <div  class="col-sm-6">
                                       <label for="createdBy">Created By</label><br>
                                       <input type="text" id="createdBy" name="createdBy" class="form-control item-form" value="<?php echo $admin; ?>" disabled>
                                    </div>

                                    <div  class="col-sm-6">
                                       <label for="region_id">Current Location</label><br>
                                       <select class="form-control" id="region_id">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_region["data"]); $i++){  ?>
                                          <option value="<?php echo $array_region['data'][$i]['region_id']; ?>"><?php echo $array_region['data'][$i]['region_name']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div>

                                     <div  class="col-sm-6">
                                       <label for="status_id">Status</label><br>
                                       <select class="form-control" id="status_id">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_status["data"]); $i++){  ?>
                                          <option value="<?php echo $array_status['data'][$i]['status_id']; ?>"><?php echo $array_status['data'][$i]['status_desc']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div>                                      
                                   
                                    </div>                                  
                                    <br>
                                    <div class="row admin-submit">
                                       <div class="col-xs-3" >
                                          <a href="item-list.php" class="btn btn-secondary">Cancel</a> &nbsp;
                                          <input type="submit" value="Submit" onclick="insert();" class="btn btn-success float-right">
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
         function insert(){
          
         var item_id = $("#item_id").val();
         var category_id = $("#category_id").val();
         var brand_id = $("#brand_id").val();
         var serial_no = $("#serial_no").val();
         var model_id = $("#model_id").val();
         var status_id = $("#status_id").val();                  
         var createdBy = $("#createdBy").val();
         var region_id = $("#region_id").val();
              
         var formData = new FormData();
         
         formData.append('action', "addItem");
         formData.append("item_id", item_id);
         formData.append("category_id", category_id);
         formData.append("brand_id", brand_id);         
         formData.append("serial_no", serial_no);
         formData.append("model_id", model_id);
         formData.append("status_id", status_id);                 
         formData.append("createdBy", createdBy);                        
         formData.append("region_id", region_id);
             
         
         if(category_id == "" ||  brand_id == "" || model_id == "" ||  createdBy == "" || region_id == "" || status_id == ""){
           swal({
             type: 'error',
             title: 'Oops...',
             text: "Please fill in all field!"
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
                  console.log(result);
                  var result_obj = JSON.parse(result);

                  if(result_obj.valid){
                    swal({
                      type:"success",
                      title:'Success',
                      html:result_obj.msg
                    }).then(function(){
                      document.location = "item-list.php";
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
         }
         
      </script>   
   </body>
</html>