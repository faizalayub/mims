<?php include "inc/app-top.php"; 
   ?>

<?php 
include "inc/user2.php";
$user = new Users();

$location = $_SESSION["location"];

$result_item = $user->getFaultyRecordOnLoad($_SESSION['location']);
$array_item = json_decode($result_item,true);

?>

   
<!DOCTYPE html>
<html>
   <head>
      <?php include "inc/head.php"; ?>
      <style>
        .user-form {
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
                        <h1 class="m-0 text-dark">Change Password</h1>
                     </div>
                     <!-- /.col -->
                     <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                           <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                           <li class="breadcrumb-item active">Change Password</li>
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
                        
                              <div class="form-group">
                                  <label for="oldpasskey">Old Password</label>
                                  <input type="password" class="form-control" id="oldpasskey" placeholder="Old Password">
                              </div>
                              <div class="form-group" id="confirmpass-container">
                                  <label for="newpasskey">New Password</label>
                                  <input type="password" class="form-control" id="newpasskey" placeholder="New Password">
                              </div>

                              <button type="button" class="btn btn-primary" id="submit-register-newuser-button">Save</button>
                                
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

         <input type="hidden" value="<?php echo $_SESSION['id'] ?>" id="username_identifier"/>
      </div>
      <!-- ./wrapper -->
      <?php include "inc/js.php"; ?>
      <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
      <script>
        $('#submit-register-newuser-button').on('click', function(){
            let oldpass = $('#oldpasskey').val();
            let newpass = $('#newpasskey').val();

            if(newpass.trim() == ''){
                swal({ type : "error", title : "New Password Is Required", text : "Please new password" }); return false;
            }
            
            if(oldpass.trim() == ''){
                swal({ type : "error", title : "Old Password Is Required", text : "Please old password" }); return false;
            }

            $.ajax({
                type : "POST",
                url  : "action2.php",
                data : {
                    "action" : "changeuserpassword",
                    "oldvalue" : oldpass,
                    "newvalue" : newpass,
                    "userid" : $('#username_identifier').val()
                },
                success : function (result){
                    let messageresult = {};

                    let resultfinal = JSON.parse(result);

                    if(resultfinal.statuscode == 400){
                        messageresult = {
                            type : "error",
                            text : "Please enter correct old password",
                        }
                    }

                    if(resultfinal.statuscode == 200){
                        messageresult = {
                          type : "success",
                          text : 'Password updated',
                        }
                    }

                    swal({
                        ...messageresult,
                        title: resultfinal.status,
                        animation : true
                    }).then(function () {
                        location.reload();
                    });
                }
            });
        });
      </script>  
   </body>
</html>