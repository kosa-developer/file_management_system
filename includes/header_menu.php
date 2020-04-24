<?php
if ((empty($_SESSION['staff_id'])) && (empty($_SESSION['immergencepassword']))) {
    Redirect::to('index.php?page=logout');
}

?>

<div class="page-header navbar navbar-fixed-top" onload="openModel()">
    <div class="page-header-inner ">
        <!-- logo start -->
        <div class="page-logo">
            <a href="index.php?page=dashboard">
                <span class="logo-icon fa fa-hospital-o fa-rotate-left"></span>
                <span class="logo-default" ><?php echo $HOSPITAL_NAME_ABREV ?></span> </a>
        </div>
        <!-- logo end -->
        <ul class="nav navbar-nav navbar-left in">
            <li><a href="javascript:void(0)" class="menu-toggler sidebar-toggler"><i class="icon-menu"></i></a></li>
        </ul>
        <!-- start mobile menu -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- end mobile menu -->
        <!-- start header menu -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <!-- start notification dropdown -->

              
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="profile" class="img-circle " src="images/default.jpg" />
                        <span class="username username-hide-on-mobile"><?php echo $_SESSION['staff_names']; ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                  
                        <li class="divider"> </li>
                        <li>
                            <a href="index.php?page=logout">
                                <i class="fa fa-lock"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

