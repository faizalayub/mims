<?php include "inc/app-top.php"; 
include "inc/user.php";

$user = new Users();
$result_category = $user->getCategory();
$array_category = json_decode($result_category,true);

$result_region = $user->getRegion();
$array_region = json_decode($result_region,true);

$user = $_SESSION['username'];

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
                        <h1 class="m-0 text-dark">Request Item</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Request Item</li>
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
                                       <label for="region_id">Region</label><br>
                                       <select class="form-control" id="region_id">
                                        <option value="">Select-</option>
                                        <?php for($i = 1; $i< count($array_region["data"]); $i++){  ?>
                                          <option value="<?php echo $array_region['data'][$i]['region_id']; ?>"><?php echo $array_region['data'][$i]['region_name']; ?></option>
                                        <?php } ?>
                                       </select>
                                     </div>

                                     <div  class="col-sm-6">
                                       <label for="quantity">Quantity</label><br>
                                       <input type="text" id="quantity" name="quantity" class="form-control item-form">
                                    </div>

                                    </div>                                  
                                    <br>
                                    <div class="row user-submit">
                                       <div class="col-xs-3" >
                                          <a href="region-request-list.php" class="btn btn-secondary">Cancel</a> &nbsp;
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
          
         var category_id = $("#category_id").val();
         var region_id = $("#region_id").val();
         var quantity = $("#quantity").val();
              
         var formData = new FormData();
         
         formData.append('action', "addRequest");
         formData.append("category_id", category_id);                        
         formData.append("region_id", region_id);
         formData.append("quantity", quantity);
             
         
         if(category_id == "" || region_id == "" || quantity == ""){
           swal({
             type: 'error',
             title: 'Oops...',
             text: "Please fill in all field!"
           });
         }else{
      $.ajax({
                type:"post",
                url:"action.php",
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
                      document.location = "region-request-list.php";
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