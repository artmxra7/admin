<?php require 'application/translator.php'; ?>
<?php 
    require_once 'header.php';
    $controller = new ControllerCategory();
    $categories = $controller->getCategoriesResult();

    if(!empty($_SERVER['QUERY_STRING'])) {
        $extras = new Extras();
        $category_id = $extras->decryptQuery1(KEY_SALT, $_SERVER['QUERY_STRING']);
        if( $category_id != null ) {
            $controller->deleteCategory($category_id, 1);
            $controller->updateCategoryPID($category_id);
            echo "<script type='text/javascript'>location.href='categories.php';</script>";
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

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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

      <li class="nav-item active">
        <a class="nav-link" href="categories.php">
          <i class="fas fa-list"></i>
          <span><?php echo __CATEGORIES; ?></span></a>
      </li>

      <li class="nav-item">
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
      <li class="nav-item">
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

        
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary"><?php echo __CATEGORIES; ?> <a href="category_insert.php" style="float:right;text-decoration:none;"><?php echo __ADD; ?> <i class="fas fa-plus"></i></a></h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <?php 
                  if($categories != null) {
                    function toUL(array $array) {
                        $html = '<ul>' . PHP_EOL;
                        foreach ($array as $value) {
                            $extras = new Extras();
                            $category_id = $value['category_id'];

                            $updateUrl = $extras->encryptQuery1(KEY_SALT, 'category_id', $value['category_id'], 'category_update.php');
                            $deleteUrl = $extras->encryptQuery1(KEY_SALT, 'category_id', $value['category_id'], 'categories.php');

                            $html .= "<li><blockquote><img src='".$value['map_icon']."' width='40' height='40'/>&nbsp;".$value['category'].

                                      "&nbsp;<a href='".$updateUrl."' class='btn btn-success btn-circle btn-sm'>
                                              <i class='fas fa-edit'></i>
                                            </a>
                                            <a class='btn btn-danger btn-circle btn-sm' href='#' data-toggle='modal' data-target='#category_modal_".$value['category_id']."'>
                                              <i class='fas fa-trash'></i>
                                            </a>
                                        </blockquote>";

                            echo '<div class="modal fade" id="category_modal_'.$value['category_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">'.__DELETE_CATEGORY_TITLE.'</h5>
                                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">??</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">'.__DELETE_CATEGORY_MSG.'</div>
                                        <div class="modal-footer">
                                          <button class="btn btn-secondary" type="button" data-dismiss="modal">'.__CANCEL.'</button>
                                          <a class="btn btn-primary" href="'.$deleteUrl.'">'.__PROCEED.'</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>';

                            if (!empty($value['children']))
                            {
                                $html .= toUL($value['children']);
                            }
                            $html .= '</li>' . PHP_EOL;
                        }

                        $html .= '</ul>' . PHP_EOL;

                        return $html;
                    }
                    echo toUL($categories);

                  }
              ?>
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
            <span aria-hidden="true">??</span>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
