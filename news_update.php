<?php require 'application/translator.php'; ?>
<?php 
    require_once 'header.php';
    $controller = new ControllerNews();
    $extras = new Extras();

    $news_id = $extras->decryptQuery1(KEY_SALT, $_SERVER['QUERY_STRING']);
    if($news_id == null)
      echo "<script type='text/javascript'>location.href='403.php';</script>";

    $news = $controller->getNewsByNewsId($news_id);
    $news_content = "";
    if($extras->is_base64($news->news_content)) {
      $news_content = base64_decode($news->news_content);
    }
    else {
      $news_content = $news->news_content;
    }

    if( isset($_POST['submit']) ) {
      $itm = $news;
      $itm->news_url = htmlspecialchars(trim(strip_tags($_POST['news_url'])));
      $itm->news_title = htmlspecialchars(trim(strip_tags($_POST['news_title'])));
      // $news_content = preg_replace('~[\r\n]+~', '', $_POST['news_content']);
      // $itm->news_content = htmlspecialchars(trim(strip_tags($news_content)));

      $itm->news_content = base64_encode($_POST['news_content']);
      $itm->updated_at = time();
      $itm->photo_url = trim(strip_tags($_POST['photo_url']));

      if( $_FILES["file_news"]["size"] > 0 )
        $itm->photo_url = $extras->uploadFile("file_news", "news_");
      
      $controller->updateNews($itm);
      echo "<script type='text/javascript'>location.href='news.php';</script>";

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

      <li class="nav-item active">
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

          <div class="row">

            <div class="col-lg-8">

              <!-- Circle Buttons -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo __EDIT_NEWS; ?></h6>
                </div>
                <div class="card-body">
                  <form class="user" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label><?php echo __NEWS_TITLE; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __NEWS_TITLE; ?>" name="news_title" required value="<?php echo $news->news_title; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __NEWS_URL; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __NEWS_URL; ?>" name="news_url" required value="<?php echo $news->news_url; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __NEWS_PHOTO_URL; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __NEWS_PHOTO_URL; ?>" name="photo_url" value="<?php echo $news->photo_url; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __NEWS_PHOTO_UPLOAD; ?></label>
                      <br/>
                      <input type="file" name="file_news" accept="image/*"/>
                    </div>

                    <div class="form-group">
                      <label><?php echo __NEWS_CONTENT; ?> <a href="#" data-toggle="modal" data-target="#help"><i class="fas fa-question-circle"></i></a></label>
                      <textarea type="text" class="form-control " placeholder="<?php echo __NEWS_CONTENT; ?>" name="news_content" rows="6"><?php echo $news_content; ?></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary "><?php echo __SAVE; ?></button>
                    <a href="news.php" class="btn btn-danger "><?php echo __CANCEL; ?></a>
                  </form>

                </div>
              </div>

              <div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel"><?php echo __STORE_DESC_INFO; ?></h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <ul>
                        <li><code>&lt;p&gt;</code></li>
                        <li><code>&lt;div&gt;</code> <?php echo __HANDLED_EXACTLY_LIKE; ?> <code>&lt;p&gt;</code></li>
                        <li><code>&lt;br&gt;</code></li>
                        <li><code>&lt;b&gt;</code></li>
                        <li><code>&lt;i&gt;</code></li>
                        <li><code>&lt;strong&gt;</code> <?php echo __BUG_ITALIC; ?></li>
                        <li><code>&lt;em&gt;</code> <?php echo __BUG_BOLD; ?></li>
                        <li><code>&lt;u&gt;</code></li>
                        <li><code>&lt;tt&gt;</code></li>
                        <li><code>&lt;dfn&gt;</code></li>
                        <li><code>&lt;sub&gt;</code></li>
                        <li><code>&lt;sup&gt;</code></li>
                        <li><code>&lt;blockquote&gt;</code></li>
                        <li><code>&lt;cite&gt;</code></li>
                        <li><code>&lt;big&gt;</code></li>
                        <li><code>&lt;small&gt;</code></li>
                        <li><code>&lt;font size="..." color="..." face="..."&gt;</code></li>
                        <li><code>&lt;h1&gt;</code>, <code>&lt;h2&gt;</code>, <code>&lt;h3&gt;</code>, <code>&lt;h4&gt;</code>, <code>&lt;h5&gt;</code>, <code>&lt;h6&gt;</code></li>
                        <li><code>&lt;a href="..."&gt;</code></li>
                        <li><code>&lt;img src="..."&gt;</code></li>
                        <li><code>&lt;ul&gt;</code></li>
                        <li><code>&lt;ol&gt;</code></li>
                        <li><code>&lt;li&gt;</code></li>
                        <li><code>&lt;code&gt;</code></li>
                        <li><code>&lt;center&gt;</code></li>
                        <li><code>&lt;strike&gt;</code></li>
                      </ul>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo __CLOSE; ?></button>
                    </div>
                  </div>
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
</body>

</html>
