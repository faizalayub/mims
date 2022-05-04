<style type="text/css">
  .banner-text{
    font-size: 12px;
    color: lightskyblue;
  }
</style>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li>
         <a href="logout.php" class="nav-link" style="position: absolute;right: 10px;">
          <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a>
      </li>
    </ul>
  </nav>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
      <img src="../images/logo-TM.png" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">MIMS Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="home.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a> 
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
                User 
                <i class="right fas fa-angle-left"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="user-add.php " class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Item
                <i class="right fas fa-angle-left"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="item-add.php " class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>New Item</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="item-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Item List </p>
                </a>
              </li>               
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-globe-asia"></i>
              <p>
                Region
                <i class="right fas fa-angle-left"></i>                
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="region-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send to Region</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="site-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send to Site</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="subregion-to-site-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Subregion to Site</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="region-request.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="region-request-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Request List</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-exclamation-circle"></i>
              <p>
                Faulty Record 
                <i class="right fas fa-angle-left"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="faulty-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Faulty Record List</p>
                </a>
              </li>              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
                <!-- <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="report-summary.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summary</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report-monthly.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report-region.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Region</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report-agency.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Agency</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report-status.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report-delivery.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Delivery Status</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>