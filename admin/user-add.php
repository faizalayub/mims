<?php include "inc/app-top.php"; 
include "inc/admin2.php";

$admin = new Admins();

$result_role = $admin->getRole();
$array_role = json_decode($result_role,true);

$result_region = $admin->getRegion();
$array_region= json_decode($result_region,true);

?>

<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php";
       ?>

      <style>
        .user-form {
        display: inline-block !important;
        width: 100% !important;
        margin: 2px 0 !important;
        padding: 5px 10px !important;
    }

    .user-submit{
      margin-top: 20px;
      float: right;
    }

    .card-body{
      width: 60% !important;

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
                        <h1 class="m-0 text-dark">New User</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">New User</li>
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
                                  <input type="hidden" name="password" id="password" value="$2y$10$VZc43IAT/8E88TkgkBkD/eRi4uYbcksUYM/tKJ/jVYsSc2DBfrI0a">
                                    <div  class="col-12">
                                       <label for="user_id">Staff ID</label><br>
                                       <input type="text" id="user_id" name="user_id" class="form-control user-form">                                       
                                    </div>

                                    <div  class="col-12">
                                       <label for="username">Staff Name</label><br>
                                       <input type="text" id="username" name="username" class="form-control user-form">                                       
                                    </div>
                                    <div  class="col-12">
                                       <label for="department">Department</label><br>
                                       <input type="text" id="department" name="department" class="form-control user-form">
                                    </div>

                                    <div  class="col-sm-12">
                                       <label for="role_id">Role</label><br>
                                       <select class="form-control" id="role_id">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_role["data"]); $i++){  ?>
                                          <option value="<?php echo $array_role['data'][$i]['role_id']; ?>"><?php echo $array_role['data'][$i]['role_desc']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div>

                                    <div  class="col-sm-12">
                                       <label for="location">Location</label><br>
                                       <select class="form-control" id="location">
                                        <option value="">Select-</option>
                                         <?php for($i = 0; $i< count($array_region["data"]); $i++){  ?>
                                          <option value="<?php echo $array_region['data'][$i]['region_id']; ?>"><?php echo $array_region['data'][$i]['region_name']; ?></option>
                                        <?php } ?>
                                       </select>
                                    </div>

                                    </div>
                                    <br>
                                    <div class="row user-submit">
                                       <div class="col-xs-3" >
                                          <a href="user-add.php" class="btn btn-secondary">Cancel</a> &nbsp;
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
         var user_id = $('#user_id').val(); 
         var username = $('#username').val();
         var department = $('#department').val();
         var role_id = $('#role_id').val();
         var location = $('#location').val();
         var password = $("#password").val();         
              
         var form_data = new FormData();
         
         form_data.append('action', "addUser");
         form_data.append("user_id",user_id);
         form_data.append("username",username);
         form_data.append("department", department);
         form_data.append("password", password);
         form_data.append("role_id",role_id);
         form_data.append("location",location);       
         
         if(user_id == "" || username == "" || department == "" || role_id == "" || location == ""){
           swal({
             type: 'error',
             title: 'Oops...',
             text: "Please fill in all field!"
           });
         }else{
         $.ajax({
              type:'post',
              url: 'action2.php',
              data:form_data,
              cache: false,
              contentType: false,
              processData: false,
              success:function(result)  {
               var result_obj = JSON.parse(result);
               
                 if (result_obj.valid){
                            swal({
                                type : "success",
                                title : "Success!",
                                text : result_obj.msg,
                                animation : true
                            }).then(function () {
                                location.href="user-list.php";
                            });
                        }
                        else{
                            swal({
                                type : "error",
                                title : "Oh-oh!",
                                text : result_obj.msg,
                                animation : true
                            }).then(function () {
                                location.reload();
                            });
                        }
              }
         
         });
         }
         }
         
      </script>   
   </body>
</html>