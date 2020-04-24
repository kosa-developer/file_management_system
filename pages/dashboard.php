<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once 'includes/header_css.php'; ?>
    </head>
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-blue">
        <div class="page-wrapper">
            <!-- start header -->
            <?php include_once 'includes/header_menu.php'; ?>
            <!-- end header -->
            <!-- start page container -->
            <div class="page-container">
                <!-- start sidebar menu -->
                <?php
                include_once 'includes/side_menu.php';
                ?>
                <!-- end sidebar menu --> 
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">Dashboard</div>
                                </div>
                            </div>
                        </div>
                        <!-- start widget -->
                        
                        <div id="printable"> 
                            <div class="row">
                                <div class="col-md-12 hidden">
                                    <div class="card card-topline-red">
                                        <div class="card-head">
                                            <header></header>
                                        </div>
                                        <div class="card-body " id="chartjs_polar_parent">
                                            <div class="row">
                                                <canvas id="chartjs_line" height="100"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        </div>
                    </div>
                    <!-- end page content -->
                </div>
                <!-- end page container -->
                <!-- start footer -->
                <?php include_once 'includes/footer.php'; ?>
                <!-- end footer -->
            </div>
          
            <?php include_once 'includes/footer_js.php'; ?>
            <script type="text/javascript">

            </script>

            <script src="js/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
            <script src="js/counterup/jquery.counterup.min.js" type="text/javascript"></script>

            <script src="js/chart-js/Chart.bundle.js" type="text/javascript"></script>
            <script src="js/chart-js/utils.js" type="text/javascript"></script>
            <script src="js/chart-js/chartjs-data.js" type="text/javascript"></script>
    </body>

</html>