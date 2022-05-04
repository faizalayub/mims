<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<!-- Left navbar links -->
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
               <li class="nav-item d-none d-sm-inline-block">
                 <a href="logout.php" class="nav-link"> <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a>
               </li>
            </ul>
           <?php echo $_SESSION["username"]; ?>