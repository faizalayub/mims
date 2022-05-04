<?php
include "inc/admin2.php";
$admin = new Admins();

$result_role = $admin->getRole();
$array_role = json_decode($result_role,true);

$result_region = $admin->getRegion();
$array_region= json_decode($result_region,true);

$result_user_detail = $admin->getUserDetailByID($_GET["id"]);
$array_user_detail = json_decode($result_user_detail,true);

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
                        <h1 class="m-0 text-dark">User Detail</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item"><a href="user-list.php">User List</a></li>
                           <li class="breadcrumb-item active">User Detail</li>
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
                  <p>USER INFORMATION</p>
                  <?php
                    if($array_user_detail["valid"]){
                      ?>

                      <p class="parallel_text_left">ID</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["id"]; ?></p>

                      <p class="parallel_text_left">User ID</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["user_id"]; ?></p>
                      
                      <p class="parallel_text_left">User Name</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["user_name"]; ?></p>

                      <p class="parallel_text_left">Department</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["user_department"]; ?></p>

                      <p class="parallel_text_left">Role</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["role_desc"]; ?></p>

                       <p class="parallel_text_left">Location</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["region_name"]; ?></p>

                      <p class="parallel_text_left">User Register Date</p>
                      <p class="parallel_text_right">: <?php echo $array_user_detail["createdAt"]; ?></p>
                      <br><br><br><br><br><br><br>
              
                     <?php
                    }else{
                      echo $array_user_detail["msg"];
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