
<div class="sidebar-container">
    <div class="sidemenu-container navbar-collapse collapse fixed-menu">
        <div id="remove-scroll">
            <ul class="sidemenu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                <li class="sidebar-toggler-wrapper hide">
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                </li>
                <li class="sidebar-user-panel">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="images/default.jpg" class="img-circle user-img-circle" alt="profile" />
                        </div>
                        <div class="pull-left info">
                            <h5>
                                <a href=""><?php echo $_SESSION['staff_names']; ?></a>
                                <span class="profile-status online"></span>
                            </h5>
                            <p class="profile-title"><?php
                                $department_id = $_SESSION['department'];
                                echo $department_name= DB::getInstance()->displayTableColumnValue("select department_name from department where id='$department_id'", "department_name");
                                ?></p>
                        </div>
                    </div>
                </li>
                <li class="nav-item start active open">
                    <a href="index.php?page=dashboard">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <?php
                if ((isset($_SESSION['user_type']) && $_SESSION['user_type'] != "Admin") && !isset($_SESSION['immergencepassword'])) {
                    
                } else {
                    ?>
                    <li class="nav-item"> 
                        <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-gear"></i>
                            <span class="title">Settings</span><span class="arrow "></span>
                        </a>
                        <ul class="sub-menu" >

                            <li class="nav-item">
                                <a href="index.php?page=department&mode=register" >Department</a>
                            </li>

                            <li class="nav-item">
                                <a href="index.php?page=add_staff&mode=register" >Add Staff Member</a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?page=add_staff&mode=registered" >All Staff Members</a>

                            </li>
                            <li class="nav-item">
                                <a href="index.php?page=fileaccess&mode=registered" >File access rights</a>

                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li class="nav-item"> 
                    <a href="javascript:;" class="nav-link nav-toggle"><i class="fa fa-user"></i>
                        <span class="title">Files</span><span class="arrow "></span>
                    </a>
                    <ul class="sub-menu" >
                        <li class="nav-item">
                            <a href="index.php?page=file&mode=register" >Upload files</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=file&mode=registered" >Uploaded files</a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=logout">
                        <i class="fa fa-power-off"></i>
                        <span class="title">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>