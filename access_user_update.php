<?php require 'application/translator.php'; ?>
<?php 
    require_once 'header.php';
    $controller = new ControllerAuthentication();
    $extras = new Extras();
    $authentication_id = $extras->decryptQuery1(KEY_SALT, $_SERVER['QUERY_STRING']);
    if($authentication_id == null)
      echo "<script type='text/javascript'>location.href='403.php';</script>";

    $user = $controller->getAccessUserByAuthenticationId($authentication_id);
    if( isset($_POST['submit']) ) {
      $itm = new Authentication();
      $itm->authentication_id = $user->authentication_id;
      $itm->name = trim(strip_tags($_POST['name']));
      $itm->username = $user->username;

      $pass = trim(strip_tags($_POST['password']));
      $password_confirm = trim(strip_tags($_POST['password_confirm']));
      $password_current = trim(strip_tags($_POST['password_current']));
      $itm->password = md5( $pass );
      
      if(strlen($pass) < 8) {
          echo "<script >alert('".__PASSWORD_ATLEAST_8_CHARS."');</script>";
      }
      else if($user->password != md5($password_current)) {
          echo "<script >alert('".__CURRENT_PASSWORD_DOES_NOT_MATCH."');</script>";
      }
      else if($pass != $password_confirm) {
          echo "<script >alert('".__PASSWORD_DOES_NOT_MATCH."');</script>";
      }
      else {
          $controller->updateAccessUser($itm);
          echo "<script type='text/javascript'>location.href='admin_access.php';</script>";
      }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo __WEBSITE_TITLE; ?></title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        
        <div class="sidebar-brand-text mx-3"><?php echo __WEBSITE_NAME; ?></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item ">
        <a class="nav-link" href="home.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span><?php echo __HOME; ?></span></a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" href="categories.php">
          <i class="fas fa-list"></i>
          <span><?php echo __CATEGORIES; ?></span></a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" href="stores.php">
          <i class="fas fa-clipboard-list"></i>
          <span><?php echo __STORES; ?></span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="news.php">
          <i class="far fa-newspaper"></i>
          <span><?php echo __NEWS; ?></span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="admin_access.php">
          <i class="fas fa-user-lock"></i>
          <span><?php echo __ADMIN_ACCESS; ?></span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="users.php">
          <i class="fas fa-user-friends"></i>
          <span><?php echo __USERS; ?></span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <li class="nav-item">
        <a class="nav-link" href="push.php">
          <i class="fas fa-bell"></i>
          <span><?php echo __PUSH; ?></span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

        
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['name']; ?></span>
                <img class="img-profile rounded-circle" src="css/placeholder-user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  <?php echo __LOGOUT; ?>
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="row">

            <div class="col-lg-8">

              <!-- Circle Buttons -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo __EDIT_ADMIN_USER; ?></h6>
                </div>
                <div class="card-body">
                  <form class="user" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label><?php echo __CURRENT_PASSWORD; ?></label>
                      <input type="password" class="form-control " placeholder="<?php echo __CURRENT_PASSWORD; ?>" name="password_current" required>
                    </div>

                    <div class="form-group">
                      <label><?php echo __PASSWORD; ?></label>
                      <input type="password" class="form-control " placeholder="<?php echo __PASSWORD; ?>" name="password" required>
                    </div>

                    <div class="form-group">
                      <label><?php echo __CONFIRM_PASSWORD; ?></label>
                      <input type="password" class="form-control " placeholder="<?php echo __CONFIRM_PASSWORD; ?>" name="password_confirm" required>
                    </div>

                    <div class="form-group">
                      <label><?php echo __FULLNAME; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __FULLNAME; ?>" name="name" required value="<?php echo $user->name; ?>">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary "><?php echo __SAVE; ?></button>
                    <a href="admin_access.php" class="btn btn-danger "><?php echo __CANCEL; ?></a>
                  </form>

                </div>
              </div>

            </div>

        
          </div>
          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span><?php echo __FOOTER_COPYRIGHT_TEXT; ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><?php echo __LOGOUT_TITLE; ?></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><?php echo __LOGOUT_MSG; ?></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo __CANCEL; ?></button>
          <a class="btn btn-primary" href="index.php"><?php echo __LOGOUT; ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script type="text/javascript">
    function validateField(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode( key );
        if(theEvent.keyCode == 8 || theEvent.keyCode == 127 || theEvent.keyCode == 9) {
            
        }
        else {
            var regex = /^([a-z0-9]+-)*[a-z0-9]+$/i;
            if( !regex.test(key) ) {
              theEvent.returnValue = false;
              if(theEvent.preventDefault) theEvent.preventDefault();
            }  
        }
    }
    </script>
</body>

</html>
