<!DOCTYPE html>
<html>
<head>
  <title>MIMS | Admin Login</title>
    <?php include "inc/head.php"; ?>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <img src="images/logo-MERS999.png" alt="IMG" width="30%">
    <img src="../images/TM.png" alt="IMG" width="50%">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <h4 class="login-box-msg">Admin Login</h4>

      <form id="loginAdminForm">
        <div class="input-group mb-3">
          <input type="text" id="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<?php include "inc/js.php"; ?>
<script>
    $(document).ready(function () {
        $("#loginAdminForm").submit(false);
        $("#loginAdminForm").on("submit", function () {
            var username = $("#username").val();
            var password = $("#password").val();
            
            var formData = {
                "action" : "checkAdminLogin",
                "username" : username,
                "password" : password
            }
            
            console.log(formData);
            
            if (username == ""){
                swal({
                    type : "error",
                    title : "Oops!",
                    text : "Username is empty",
                    animation : true
                }).then(function () {
                    
                })
            }
            else if (password == ""){
                swal({
                    type : "error",
                    title : "Oops!",
                    text : "Password is empty",
                    animation : true
                }).then(function () {
                    
                })
            }
            else{
                $.ajax({
                    type : "POST",
                    url : "action.php",
                    data : formData,
                    success : function (result){
                        var result_obj = JSON.parse(result);
                        console.log(result);
                        if (result_obj.valid){
                            swal({
                                type : "success",
                                title : "Success!",
                                text : result_obj.message,
                                animation : true
                            }).then(function () {
                                location.href="home.php";
                            });
                        }
                        else{
                            swal({
                                type : "error",
                                title : "Oh-oh!",
                                text : result_obj.message,
                                animation : true
                            }).then(function () {
                                location.reload();
                            });
                        }
                    }
                });
            }
        })
    })
</script>
</body>
</html>
