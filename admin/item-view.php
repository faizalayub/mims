<?php
include "inc/admin2.php";
$admin = new Admins();

$result_item_detail = $admin->getItemsDetailByID($_GET["item_id"]);
$array_item_detail = json_decode($result_item_detail,true);

$result_item_status = $admin->getItemStatusByID2($_GET["item_id"]);
$array_item_status = json_decode($result_item_status,true);

?>

<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
        
      <style type="text/css">
        .card-body{
              font-size: 13px;
        }

        .parallel_div{
      padding: 0;
    }

    .parallel_content{
      margin: 20px 30px 0 30px;
      padding: 30px;
      background-color: #ffffff;
      box-shadow: 0 0 3px #ccc;
      border-radius: 8px;
    }

    .parallel_content p:first-child{
      border-bottom: 1px solid #ccc;
      padding-bottom: 5px;
      font-weight: 600;
    }

    .parallel_content img{
      width:300px;
      height:300px;
    }

    .parallel_right{
      margin-top: 35px;
      width: 50%;
      float: right;
    }
    .parallel_left{
      margin-top: 35px;
      width: 100%;
      float: left;
    }

    .parallel_header{
      border: none;
    }

    .parallel_header{
  border-bottom: 1px solid #ccc;
  padding: 10px 0;
  font-size: 0.95em;
  font-weight: 600;
  margin: 0 30px;
  width: 95%;
}

.parallel_content{
  margin: 0 30px;
  font-size: 0.92em;
}

.parallel_text_left{
  display:inline-block;
  width:30%;
  margin: 2px 0;
  padding: 5px 0;
}

.parallel_text_right{
  display:inline-block;
  width:60%;
  margin: 2px 0;
  padding: 5px 0;
}

.parallel_align{

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
                        <h1 class="m-0 text-dark">Item Detail</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item"><a href="item-list.php">Item List</a></li>
                           <li class="breadcrumb-item active">Item Detail</li>
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
                  <?php
                    if($array_item_detail["valid"]){
                      ?>
                      <p class="parallel_text_left">Item ID</p>
                      <p class="parallel_text_right">: <?php echo $array_item_detail["item_id"]; ?></p>

                      <p class="parallel_text_left">Category</p>
                      <p class="parallel_text_right">: <?php echo $array_item_detail["category_desc"]; ?></p>

                      <p class="parallel_text_left">Brand</p>
                      <p class="parallel_text_right">: <?php echo $array_item_detail["brand_desc"]; ?></p>                    

                      <?php
                      if($array_item_detail["serial_no"] != ""){
                        $serial_no = $array_item_detail["serial_no"];
                      }else{
                        $serial_no = "Null";
                      }
                          ?>
                      <p class="parallel_text_left">Serial No</p>
                      <p class="parallel_text_right">: <?php echo $serial_no; ?></p>

                      <p class="parallel_text_left">Model</p>
                      <p class="parallel_text_right">: <?php echo $array_item_detail["model_desc"]; ?></p>

                      <?php
                      if($array_item_detail["status_desc"] != ""){
                        $status_desc = $array_item_detail["status_desc"];
                      }else{
                        $status_desc = "New";
                      }
                          ?>

                      <p class="parallel_text_left">Status</p>
                      <p class="parallel_text_right">: <?php echO $status_desc; ?></p>

                      <p class="parallel_text_left">Created By</p>
                      <p class="parallel_text_right">: <?php echo $array_item_detail["createdBy"]; ?></p>

                      <p class="parallel_text_left">Created Date</p>
                      <p class="parallel_text_right">: <?php echo $array_item_detail["createdDt"]; ?></p>

                      <?php
                      if($array_item_detail["lastModifiedBy"] != ""){
                        $lastModifiedBy = $array_item_detail["lastModifiedBy"];
                      }else{
                        $lastModifiedBy = "Null";
                      }
                          ?>
                      <p class="parallel_text_left">Last Modified By</p>
                      <p class="parallel_text_right">: <?php echo $lastModifiedBy; ?></p>                    

                      <?php
                      if($array_item_detail["lastModifiedDt"] != ""){
                        $lastModifiedDt = $array_item_detail["lastModifiedDt"];
                      }else{
                        $lastModifiedDt = "Null";
                      }
                          ?>
                      <p class="parallel_text_left">Last Modified Date</p>
                      <p class="parallel_text_right">: <?php echo $lastModifiedDt; ?></p>                      

                      <p class="parallel_text_left">Current Location</p>
                      <p class="parallel_text_right">: <?php echo $array_item_status["region_name"]; ?></p>
                      
                      <br><br><br><br><br><br><br>
              
                     <?php
                    }else{
                      echo $array_item_detail["msg"];
                    }
                  ?>
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
 


      
   </body>
</html>