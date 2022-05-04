<!DOCTYPE html>
<html>
<head>
  <title>MIMS | User Login</title>
    <?php include "inc/head.php"; ?>
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <img src="images/logo-MERS999.png" width="30%">
    <img src="images/TM.png" alt="IMG"width="50%">
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <h4 class="login-box-msg">User Login</h4>

      <form id="loginUserForm">
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
            <a href="#" style="display: flex;align-items: center;height: 100%;text-decoration: none;font-size:15px;" type="button" data-toggle="modal" data-target="#registeruser">Register New User</a>
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

<!-- Modal Register -->
<div class="modal fade" id="registeruser" tabindex="-1" role="dialog" aria-labelledby="registeruserTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Register New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="registerformUsername">Username</label>
                    <input type="text" class="form-control" id="registerformUsername" aria-describedby="registerformUsernamehelp" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="registerformUserFullname">Full Name</label>
                    <input type="text" class="form-control" id="registerformUserFullname" placeholder="Enter Full Name">
                </div>
                <div class="form-group">
                    <label for="registerUsernamePass">Password</label>
                    <input type="password" class="form-control" id="registerUsernamePass" placeholder="Password">
                </div>
                <div class="form-group" id="confirmpass-container">
                    <label for="registerUsernamePassConfirm">Confirm Password</label>
                    <input type="password" class="form-control" id="registerUsernamePassConfirm" aria-describedby="registerformUserconfirmpasshelp" placeholder="Confirm Password">
                    <small id="registerformUserconfirmpasshelp" class="form-text text-muted">Password Not Match</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submit-register-newuser-button">Register</button>
            </div>

        </div>

    </div>
</div>

<?php include "inc/js.php"; ?>
<script>
    $(document).ready(function () {
        $("#loginUserForm").submit(false);

        $("#loginUserForm").on("submit", function () {
            var username = $("#username").val();
            var password = $("#password").val();
            
            var formData = {
                "action" : "checkUserLogin",
                "username" : username,
                "password" : password
            }
            
            // console.log(formData);
            
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
                    url : "action2.php",
                    data : formData,
                    success : function (result){
                        var result_obj = JSON.parse(result);
                        // console.log(result);
                        if (result_obj.valid){
                            swal({
                                type : "success",
                                title : "Success!",
                                text : result_obj.message,
                                animation : true
                            }).then(function () {
                                location.href="item-list.php";
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
        });

        $('#submit-register-newuser-button').on('click', function(){
            let usernamevalue    = $('#registerformUsername').val();
            let passvalue        = $('#registerUsernamePass').val();
            let confirmpassvalue = $('#registerUsernamePassConfirm').val();
            let fullnamevalue    = $('#registerformUserFullname').val();

            if(usernamevalue.trim() == ''){
                swal({ type : "error", title : "Username Is Required", text : "Please enter username" });
            }else if(passvalue.trim() == ''){
                swal({ type : "error", title : "Password Is Required", text : "Please password username" });
            }else if(confirmpassvalue.trim() == ''){
                swal({ type : "error", title : "Confirm Password Is Required", text : "Please confirm password username" });
            }

            $.ajax({
                type : "POST",
                url  : "action2.php",
                data : {
                    "action" : "registerNewUser",
                    "username" : usernamevalue,
                    "password" : passvalue,
                    "fullname" : fullnamevalue,
                },
                success : function (result){
                    swal({
                        type : "success",
                        title : "Success!",
                        text : 'User Successfully Registered',
                        animation : true
                    }).then(function () {
                        location.href="item-list.php";
                    });
                }
            });
        });

        $('#registerUsernamePassConfirm').on('input', function(){
            let tomatchKey = $('#registerUsernamePass').val();
            let currentKey = $(this).val();
            let matchMessg = $('#registerformUserconfirmpasshelp');

            if(tomatchKey.trim() == '' || currentKey.trim() == ''){
                matchMessg.hide();
                $(this).removeClass('is-invalid');
                return false;
            }

            if(tomatchKey.trim() != currentKey.trim()){
                matchMessg.show();
                $(this).addClass('is-invalid');
            }else{
                matchMessg.hide();
                $(this).removeClass('is-invalid');
            }
        });

        $('#registerUsernamePass').on('input', function(){
            let currentKey = $(this).val();
            let confirmInputContainer = $('#confirmpass-container');
            let confirmInput = confirmInputContainer.find('input');

            if(currentKey.trim() == ''){
                confirmInputContainer.hide();
            }else{
                confirmInputContainer.show();
            }

            confirmInput.val('');
            confirmInput.trigger('input');
        });

        $('#registerUsernamePass').trigger('input');
        $('#registerUsernamePassConfirm').trigger('input');
    });
</script>
</body>
</html>
