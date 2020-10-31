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

        <div class="col-md-8 hidden">
           
            <div class="col-md-6">  <h2 style="color:blue;" ><input type="hidden" id="page_id" value="<?php echo (isset($_GET['page'])&& $_GET['page']=='dashboard')?"dashboard":"otherpages";?>"> <input type="hidden" id="staff_id" value=""> <input type="hidden" id="duration" value="00:00:02"> </h2> </div> 
            <div class="col-md-6"> <h2 style="color:red" class="elapsed-time-text hidden">00:00:00</h2></div> 

        </div>
        <div class="top-menu" >
            <ul class="nav navbar-nav pull-right">
                
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="index.php?page=shared_files" class="dropdown-toggle" data-hover="dropdown" data-close-others="true">
                        <i class="fa fa-bell-o"></i>
                        <span class="badge orange-bgcolor"> <?php
                            $recz_id = $_SESSION['staff_id'];
                            echo DB::getInstance()->displayTableColumnValue("select count(Id) as shared_files from shared_files where Receiver_id='$recz_id' and Status='1' ", "shared_files");
                            ?> </span>
                    </a>
                       
                       
                </li>
                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                    <a href="index.php?page=dashboard" class="dropdown-toggle"  data-hover="dropdown" data-close-others="true">
                        <i class="fa fa-envelope-o"></i>
                        <span class="badge cyan-bgcolor"> <?php echo DB::getInstance()->displayTableColumnValue("select count(Id) as pendig_messages from messaging where Receiver_id='$recz_id' and Status='1' ", "pendig_messages");
                            ?> </span>
                    </a>
                </li>


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

