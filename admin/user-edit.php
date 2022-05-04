<?php
include "inc/admin2.php";
$admin = new Admins();

$result_user_detail = $admin->getUserDetailByID($_GET["id"]);
$array_user_detail = json_decode($result_user_detail,true);

$result_role = $admin->getRole();
$array_role = json_decode($result_role,true);

$result_region = $admin->getRegion();
$array_region= json_decode($result_region,true);


?>

<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
      <?php $sidebar = "user-list"; ?>
         
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
                  <input type="hidden" name="user_id" id="id" value="<?php echo $array_user_detail["id"]; ?>">
                  <?php
                    if($array_user_detail["valid"]){
                      ?>

                      <p class="parallel_text_left">ID</p>
                      <p class="parallel_text_right"> <input type="text" class="form-control" name="id" value="<?php echo $array_user_detail["id"]; ?>" disabled></p>

                      <p class="parallel_text_left">User ID</p>
                      <p class="parallel_text_right"><input type="text" id="user_id" class="form-control" name="user_id" value="<?php echo $array_user_detail["user_id"]; ?>" disabled></p>

                      <p class="parallel_text_left">User Name</p>
                      <p class="parallel_text_right">
                        <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $array_user_detail["user_name"]; ?>"></p>
                      
                      <p class="parallel_text_left">Department</p>
                      <p class="parallel_text_right">
                      <input type="text" name="user_department" id="user_department" class="form-control" value="<?php echo $array_user_detail["user_department"]; ?>"></p>

                      <p class="parallel_text_left">Role</p>
                      <p class="parallel_text_right"> 
                        <select class="form-control" id="role_id">
                        <?php for($i = 0; $i < count($array_role["data"]); $i++){?>
                         <option value="<?php echo $array_role["data"][$i]["role_id"];?>"
                          <?php echo $array_user_detail["role_id"] == $array_role["data"][$i]["role_id"] ? "selected" : ""; ?>><?php echo $array_role["data"][$i]["role_desc"]; ?></option>
                        <?php } ?>
                       </select>

                      
                      <p class="parallel_text_left">Location</p>
                      <p class="parallel_text_right"> 
                        <select class="form-control" id="region_id">
                        <?php for($i = 0; $i < count($array_region["data"]); $i++){?>
                         <option value="<?php echo $array_region["data"][$i]["region_id"];?>"
                          <?php echo $array_user_detail["location"] == $array_region["data"][$i]["region_id"] ? "selected" : ""; ?>><?php echo $array_region["data"][$i]["region_name"]; ?></option>
                        <?php } ?>
                       </select> 

                      <p class="parallel_text_left"> Registered Date</p>
                      <p class="parallel_text_right"><input type="text" class="form-control" name="user_createdAt" value="<?php echo $array_user_detail["createdAt"]; ?>" disabled></p>
                      <br><br>
              
                     <?php
                    }else{
                      echo $array_user_detail["msg"];
                    }
                  ?>

                  <div align="right">
                      <button class="btn btn-danger general_btn" onclick="window.location.href='user-list.php'">Cancel</button>
                      <button class="btn btn-primary general_btn" onclick="submit();">Update</button>
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

        var id = $("#id").val();
        var user_id = $("#user_id").val();
        var user_name = $("#user_name").val();
        var user_department = $("#user_department").val();
        var role_id = $("#role_id").val();
        var location = $("#region_id").val();
                      
        var formData = new FormData();

        formData.append("action","updateUser");
        formData.append("id", id)
        formData.append("user_id", user_id);
        formData.append("user_name",user_name);
        formData.append("user_department",user_department);
        formData.append("role_id",role_id);
        formData.append("location",location);
        
        $.ajax({
          type:'post',
          url:'action2.php',
          data:formData,
          cache: false,
                contentType: false,
                processData: false,
                success:function(result){
                var result_obj = JSON.parse(result);
                console.log(result);
                if(result_obj.valid){
                  swal({
                    type:'success',
                    title:'Success!',
                    html:result_obj.msg
                   }).then(function(){
                     window.location = "user-list.php";
                    });
                  
                }else{
                  swal({
                    type:'error',
                    title:'Oops..',
                    text:"Failed To Update"
                  })
                }
              }
            })
      // }
    }
  
 
      </script>


      
   </body>
</html>