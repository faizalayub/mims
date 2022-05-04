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
    <a href="#" class="brand-link">
      <img src="images/logo-TM.png" class="brand-image elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">MIMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                Item
                <i class="fas fa-angle-left right"></i>
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
                <i class="fas fa-angle-left right"></i>                
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
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="site-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send to Site</p>
                </a>
              </li>
            </ul>
            <!-- <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="subregion-to-site-list.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                 <p>Subregion to Site</p>
                </a>
              </li>
            </ul> -->
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="region-request.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Request</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
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
                <i class="fas fa-angle-left right"></i>
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
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>