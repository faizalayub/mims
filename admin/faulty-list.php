<?php include "inc/app-top.php"; 
   ?>

<?php 
include "inc/admin2.php";
$admin = new Admins();

$location = (isset($_SESSION["location"]) ? $_SESSION["location"] : 1);

$result_item = $admin->getFaultyRecordOnLoad($location);
$array_item = json_decode($result_item,true);
?>

   
<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
      <style>
        .admin-form {
        display: inline-block !important;
        width: 100% !important;
        margin: 2px 0 !important;
        padding: 5px 0 !important;
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
                        <h1 class="m-0 text-dark">Faulty Record List</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Faulty Record List</li>
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
                             

                               <table id="example" class="table table-bordered table-striped"  style="text-align: center;">
                                 <thead>
                                    <tr>
                                      <th>No</th>
                                       <th>Category</th>
                                       <th>Brand</th>                                    
                                       <th>Serial No</th>
                                       <th>Model</th>                                       
                                      <!--  <th>Asset Name</th>
                                       <th>Barcode</th>                                                                            
                                       <th>Agency</th>                                       
                                       <th>Site</th> -->
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 
                                 <tbody>
                                   <?php 
                      if($array_item["valid"]){
                        $count =1;
                        for($a=0;$a<count($array_item["data"]);$a++){
                          ?> 
                          <tr>
                                  <td><?php echo $count; ?></td>
                                  <td><?php echo $array_item["data"][$a]["category_desc"]; ?></td>
                                  <td><?php echo $array_item["data"][$a]["brand_desc"]; ?></td>
                                  <td><?php echo $array_item["data"][$a]["serial_no"]; ?></td>
                                  <td><?php echo $array_item["data"][$a]["model_desc"]; ?></td>
                                  
                                 
                                  <td>
                                    <a href="faulty-record-view.php?item_id=<?php echo $array_item["data"][$a]["item_id"]; ?>" target="" style="color:#000">
                                      <i class="material-icons">pageview</i></a> | <a href="faulty-record-edit.php?item_id=<?php echo $array_item["data"][$a]["item_id"]; ?>" target="" style="color:#000">
                                      <i class="material-icons">edit</i></a> | <a id="<?php echo $array_item["data"][$a]["item_id"]; ?>" onclick="deleteItem(this.id);" style="color:#000"><i class="material-icons">delete</i>
                                     </a>
                                   </td>
                               </tr>                            
                                

                     <?php
                          $count++;
                        }
                      }else{
                        echo $array_item["msg"];
                      }

                      ?>
                                
                                 </tbody>
                                
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
      <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
         <script>
         function getFaultyRecordOnLoad(){
        
          $.ajax({
            type:'post',
            url:'action2.php',
            data:{"action":"getFaultyRecordOnLoad"},
            success:function(result){
              var result_obj = JSON.parse(result);
        
              if(result_obj.valid){
                document.getElementById("tableData").innerHTML = result_obj.html;
              $('#example').DataTable();
        
              }else{
        
              }
            }
          })
        }

      function deleteItem(item_id){
            swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
              if(result.value){
                var formData = {
                  "action"     : "deleteItem",
                  "item_id" : item_id
                };
        
                $.ajax({
                  type:'post',
                  url:'action2.php',
                  data:formData,
                  success:function(result){
                    var result_obj = JSON.parse(result);
        
                    if(result_obj.valid){
                      swal({
                        type:'success',
                        title:'Success',
                        html:result_obj.msg
                      }).then(function(){
                        location.reload();
                      });
                    }else{
                      swal({
                        type:'error',
                        title:'Oops..',
                        html:result_obj.msg
                      });
                    }
                  }
                })
              }
            });
        }

      $(document).ready(function(){
        setTimeout(() => {
          $('#example').DataTable();
        }, 100);
      })


    </script>  
   </body>
</html>