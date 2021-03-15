<?php require 'application/translator.php'; ?>
<?php 
    require_once 'header.php';
    $controller = new ControllerStore();
    $controllerCategory = new ControllerCategory();
    $categories = $controllerCategory->getCategoriesLeafNode();

    $extras = new Extras();
    $store_id = $extras->decryptQuery1(KEY_SALT, $_SERVER['QUERY_STRING']);
    if($store_id == null)
      echo "<script type='text/javascript'>location.href='403.php';</script>";

    $store = $controller->getStoreByStoreId($store_id);
    $store_desc = "";
    if($extras->is_base64($store->store_desc)) {
      $store_desc = base64_decode($store->store_desc);
    }
    else {
      $store_desc = $store->store_desc;
    }

    if( isset($_POST['submit']) ) {      
      $itm = $store;
      $itm->store_name = htmlspecialchars(trim(strip_tags($_POST['store_name'])));
      $itm->store_address = htmlspecialchars(trim(strip_tags($_POST['store_address'])));
      $store_desc = preg_replace('~[\r\n]+~', '', $_POST['store_desc']);
      $itm->store_desc = base64_encode($_POST['store_desc']);
      $delimiters = array(",", " ");
      $lat = str_replace($delimiters, "", htmlspecialchars(trim(strip_tags($_POST['lat'])), ENT_QUOTES) );
      $lon = str_replace($delimiters, "", htmlspecialchars(trim(strip_tags($_POST['lon'])), ENT_QUOTES) );
      $itm->lat = $lat;
      $itm->lon = $lon;
      $itm->website = $extras->removeHttp( htmlspecialchars(trim(strip_tags($_POST['website'])), ENT_QUOTES) );
      $itm->phone_no = htmlspecialchars(trim(strip_tags($_POST['phone_no'])), ENT_QUOTES);
      $itm->email = trim(strip_tags($_POST['email']));
      $itm->sms_no = trim(strip_tags($_POST['sms_no']));
      $itm->category_id = trim(strip_tags($_POST['category_id']));
      $itm->updated_at = time();
      $itm->featured = trim(strip_tags($_POST['featured']));

      $itm->mon_open = formatTime($_POST['mon_open']);
      $itm->mon_close = formatTime($_POST['mon_close']);

      $itm->tue_open = formatTime($_POST['tue_open']);
      $itm->tue_close = formatTime($_POST['tue_close']);

      $itm->wed_open = formatTime($_POST['wed_open']);
      $itm->wed_close = formatTime($_POST['wed_close']);

      $itm->thu_open = formatTime($_POST['thu_open']);
      $itm->thu_close = formatTime($_POST['thu_close']);

      $itm->fri_open = formatTime($_POST['fri_open']);
      $itm->fri_close = formatTime($_POST['fri_close']);

      $itm->sat_open = formatTime($_POST['sat_open']);
      $itm->sat_close = formatTime($_POST['sat_close']);

      $itm->sun_open = formatTime($_POST['sun_open']);
      $itm->sun_close = formatTime($_POST['sun_close']);

      $controller->updateStore($itm);
      echo "<script type='text/javascript'>location.href='stores.php';</script>";
    }

    $lat = !empty($store->lat) ? $store->lat : Constants::MAP_DEFAULT_LATITUDE;
    $lon = !empty($store->lon) ? $store->lon : Constants::MAP_DEFAULT_LONGITUDE;

    $mon_open = parseTime($store->mon_open);
    $mon_close = parseTime($store->mon_close);

    $tue_open = parseTime($store->tue_open);
    $tue_close = parseTime($store->tue_close);

    $wed_open = parseTime($store->wed_open);
    $wed_close = parseTime($store->wed_close);

    $thu_open = parseTime($store->thu_open);
    $thu_close = parseTime($store->thu_close);

    $fri_open = parseTime($store->fri_open);
    $fri_close = parseTime($store->fri_close);

    $sat_open = parseTime($store->sat_open);
    $sat_close = parseTime($store->sat_close);

    $sun_open = parseTime($store->sun_open);
    $sun_close = parseTime($store->sun_close);

    function formatTime($val) {
      $d=strtotime($val);
      $dd = date("H:i", $d);
      return $dd;
    }

    function parseTime($val) {
      $d=strtotime($val);
      $dd = date("h:i a", $d);
      return $dd;
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
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
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

      <li class="nav-item active">
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
          <form class="user" action="" method="POST">
          <div class="row">

            <div class="col-lg-6">

              <!-- Circle Buttons -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary"><?php echo __EDIT_STORE; ?></h6>
                </div>
                <div class="card-body">
                  
                    <div class="form-group">
                      <label><?php echo __STORE_NAME; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __STORE_NAME; ?>" name="store_name" required value="<?php echo $store->store_name; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __ADDRESS; ?></label>
                      <div class="input-group">
                        <input type="text" class="form-control " placeholder="<?php echo __ADDRESS; ?>" name="store_address" id="txtAddress" value="<?php echo $store->store_address; ?>">
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="forwardGeocode()">
                              <i class="fas fa-search fa-sm"></i>
                            </button>
                          </div>
                        </div>
                    </div>

                    <div class="form-group">
                      <label><?php echo __EMAIL; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __EMAIL; ?>" name="email" value="<?php echo $store->email; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __PHONE_NO; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __PHONE_NO; ?>" name="phone_no" value="<?php echo $store->phone_no; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __SMS_NO; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __SMS_NO; ?>" name="sms_no" value="<?php echo $store->sms_no; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __WEBSITE; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __WEBSITE; ?>" name="website" value="<?php echo $store->website; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __IS_STORE_FEATURED; ?></label>
                      <select class="form-control" name="featured">
                        <option value="1" <?php echo $store->featured == 1 ? "selected" : ""; ?>><?php echo __FEATURED; ?></option>
                        <option value="0" <?php echo $store->featured == 0 ? "selected" : ""; ?>><?php echo __NOT_FEATURED; ?></option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label><?php echo __STORE_CATEGORY; ?></label>
                      <select class="form-control" name="category_id">
                        <option value="-1"><?php echo __SELECT_CATEGORY; ?></option>
                        <?php
                            if($categories != null) {
                              foreach ($categories as $category)  {
                                $selected = "";
                                if($store->category_id == $category->category_id)
                                  $selected = "selected";

                                echo "<option value='$category->category_id' $selected>$category->category</option>";
                              }
                            }
                        ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label><?php echo __LATITUDE; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __LATITUDE; ?>" name="lat" id="txtLat" readonly required value="<?php echo $store->lat; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __LONGITUDE; ?></label>
                      <input type="text" class="form-control " placeholder="<?php echo __LONGITUDE; ?>" name="lon" id="txtLon" readonly required value="<?php echo $store->lon; ?>">
                    </div>

                    <div class="form-group">
                      <label><?php echo __STORE_DESC; ?> <a href="#" data-toggle="modal" data-target="#help"><i class="fas fa-question-circle"></i></a></label>
                      <textarea type="text" class="form-control " placeholder="<?php echo __STORE_DESC; ?>" name="store_desc" rows="6"><?php echo $store_desc; ?></textarea>
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary "><?php echo __SAVE; ?></button>
                    <a href="stores.php" class="btn btn-danger "><?php echo __CANCEL; ?></a>
                  

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

            <div class="col-lg-6">

              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo __STORE_LOCATION; ?></h6>
                  </div>
                  <div class="card-body">
                    <p><?php echo __STORE_LOCATION_MSG; ?></p>
                    <div id='mapbox-store' style="height:400px;"></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo __STORE_OPENING_HOURS; ?></h6>
                  </div>
                  <div class="card-body">
                  
                      <div class="form-group">
                        <label><?php echo __MONDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartMon" data-target-input="nearest">
                                        <input name="mon_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartMon" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $mon_open; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerStartMon" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndMon" data-target-input="nearest">
                                        <input name="mon_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndMon" readonly placeholder="<?php echo __CLOSING; ?>"  value="<?php echo $mon_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndMon" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><?php echo __TUESDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartTue" data-target-input="nearest">
                                        <input name="tue_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartTue" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $tue_open; ?>" />
                                        <div class="input-group-append" data-target="#datetimepickerStartTue" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndTue" data-target-input="nearest">
                                        <input name="tue_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndTue" readonly placeholder="<?php echo __CLOSING; ?>" value="<?php echo $tue_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndTue" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><?php echo __WEDNESDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartWed" data-target-input="nearest">
                                        <input name="wed_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartWed" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $wed_open; ?>" />
                                        <div class="input-group-append" data-target="#datetimepickerStartWed" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndWed" data-target-input="nearest">
                                        <input name="wed_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndWed" readonly placeholder="<?php echo __CLOSING; ?>" value="<?php echo $wed_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndWed" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><?php echo __THURSDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartThu" data-target-input="nearest">
                                        <input name="thu_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartThu" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $thu_open; ?>" />
                                        <div class="input-group-append" data-target="#datetimepickerStartThu" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndThu" data-target-input="nearest">
                                        <input name="thu_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndThu" readonly placeholder="<?php echo __CLOSING; ?>" value="<?php echo $thu_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndThu" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><?php echo __FRIDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartFri" data-target-input="nearest">
                                        <input name="fri_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartFri" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $fri_open; ?>" />
                                        <div class="input-group-append" data-target="#datetimepickerStartFri" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndFri" data-target-input="nearest">
                                        <input name="fri_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndFri" readonly placeholder="<?php echo __CLOSING; ?>" value="<?php echo $fri_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndFri" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><?php echo __SATURDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartSat" data-target-input="nearest">
                                        <input name="sat_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartSat" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $sat_open; ?>" />
                                        <div class="input-group-append" data-target="#datetimepickerStartSat" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndSat" data-target-input="nearest">
                                        <input name="sat_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndSat" readonly placeholder="<?php echo __CLOSING; ?>" value="<?php echo $sat_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndSat" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label><?php echo __SUNDAY; ?></label>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerStartSun" data-target-input="nearest">
                                        <input name="sun_open" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerStartSun" readonly placeholder="<?php echo __OPENING; ?>" value="<?php echo $sun_open; ?>" />
                                        <div class="input-group-append" data-target="#datetimepickerStartSun" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="input-group date" id="datetimepickerEndSun" data-target-input="nearest">
                                        <input name="sun_close" type="text" class="form-control datetimepicker-input" data-target="#datetimepickerEndSun" readonly placeholder="<?php echo __CLOSING; ?>" value="<?php echo $sun_close; ?>"/>
                                        <div class="input-group-append" data-target="#datetimepickerEndSun" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>                    
                  </div>
                </div>
              </div>

            </div>

          </div>
          
        </form>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"  crossorigin="anonymous" />

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
  <script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
  <script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
  <script>
        mapboxgl.accessToken = <?php echo '"'.Constants::MAP_BOX_ACCESS_TOKEN.'"'; ?>;
        var coordinates = document.getElementById('coordinates');
        var map = new mapboxgl.Map({
            container: 'mapbox-store',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [<?php echo $lon .','. $lat; ?>],
            zoom: 15
        });
      
        var marker = new mapboxgl.Marker( {draggable: true, color:<?php echo '"'.Constants::MARKER_COLOR.'"'; ?>} );
        marker.setLngLat([<?php echo $lon .','. $lat; ?>]);
        marker.addTo(map);

        var isAdded = true;
        var txtLat = document.getElementById('txtLat');
        var txtLon = document.getElementById('txtLon');
        var txtAddress = document.getElementById('txtAddress'); 

        map.on('load', function () {
            map.on('click', function (e) {
                if(!isAdded) {
                    marker.setLngLat(e.lngLat);
                    marker.addTo(map);
                    isAdded = true;
                    showBlock(e.lngLat);
                }
                else {
                    marker.setLngLat(e.lngLat);
                    showBlock(e.lngLat);
                }
            });
        });

        function onDragEnd() {
            var lngLat = marker.getLngLat();
            showBlock(lngLat);
        }

        function showBlock(lngLat) {
            txtLat.value = lngLat.lat;
            txtLon.value = lngLat.lng;
            reverseGeocode(lngLat);
        }
         
        marker.on('dragend', onDragEnd);

        function forwardGeocode() {
          var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
            mapboxClient.geocoding.forwardGeocode({
            query: txtAddress.value,
            autocomplete: false,
            limit: 1
          })
          .send()
          .then(function (response) {
            if (response && response.body && response.body.features && response.body.features.length) {
              var feature = response.body.features[0];
              if(!isAdded) {
                  marker.setLngLat(feature.center);
                  marker.addTo(map);
                  isAdded = true;
                  map.setCenter(feature.center);
              }
              else {
                  marker.setLngLat(feature.center);
                  map.setCenter(feature.center);
              }
            }
          });
        }

        function reverseGeocode(lngLat) {
          var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
            mapboxClient.geocoding.reverseGeocode({
            query: [lngLat.lng, lngLat.lat],
            limit: 1
          })
          .send()
          .then(function (response) {
            if (response && response.body && response.body.features && response.body.features.length) {
              var feature = response.body.features[0];
              txtAddress.value = feature.place_name;
            }
          });
        }
    </script>

    <script type="text/javascript">
        $(function () {
            $('#datetimepickerStartMon').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndMon').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });


            $('#datetimepickerStartTue').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndTue').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });


            $('#datetimepickerStartWed').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndWed').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });


            $('#datetimepickerStartThu').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndThu').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });


            $('#datetimepickerStartFri').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndFri').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });


            $('#datetimepickerStartSat').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndSat').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });


            $('#datetimepickerStartSun').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
            $('#datetimepickerEndSun').datetimepicker({
              format: "LT",
              ignoreReadonly: true
            });
        });
    </script>
</body>

</html>
