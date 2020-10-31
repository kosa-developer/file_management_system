<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once 'includes/header_css.php'; ?>
    </head>
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-blue" >
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
                        <?php
                        $hiddenclass = "hidden";
                        if ((isset($_SESSION['user_type']) && $_SESSION['user_type'] != "Admin") && !isset($_SESSION['immergencepassword'])) {
                            $hiddenclass = "hidden";
                        } else {
                            $hiddenclass = "";
                        }
                        ?>
                        <div id="printable"> 
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="card card-topline-red <?php echo $hiddenclass ?>">
                                        <div class="card-head">
                                            <div class="form-group col-md-4">
                                                <label class="control-label col-md-6">Departments:</label>
                                                <div class="col-md-6">
                                                    <select class="form-control select2" onchange="selectDepartment(this.value, 'returnedfiles');"  style="width: 100%;">
                                                        <option value="">Select...</option>
                                                        <?php
                                                        $departmentList = DB::getInstance()->querySample("SELECT * FROM department WHERE Status=1");
                                                        foreach ($departmentList AS $departmentss) {
                                                            echo '<option value="' . $departmentss->id . '">' . $departmentss->department_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body " id="chartjs_polar_parent">
                                            <div class="row" id="returnedfiles">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-sm-12" >

                                    <div style="max-height:400px; overflow-y: scroll;" id="returned_message"></div>
                                    <div class="chat-txt-form ">

                                        <div id="sendtextbutton" class="form-inline hidden" >
                                            <div class="form-group">
                                                <input type="text" id="txtmessage"  style="width: 100%" placeholder="Type a message here..." class="form-control">
                                            </div>
                                            <button onclick="sendmessage('<?php echo $_SESSION['staff_id']; ?>', 'txtmessage');" class="btn btn-primary" type="submit">Send</button>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $staff_idd = $_SESSION['staff_id'];
                                $queryStaff = 'SELECT * FROM staff WHERE Status=1 and staff_id!="' . $staff_idd . '" ORDER BY staff_id desc ' . $limit;
                                if (DB::getInstance()->checkRows($queryStaff)) {
                                    ?> 
                                    <div class="col-md-4 col-sm-12 pull-right">
                                        <div class="card  card-topline-red">
                                            <div class="card-head">
                                                <header>Chat</header>

                                            </div>




                                            <div id="divtoreload" class="card-body no-padding height-9">
                                                <div class="row">
                                                    <ul class="docListWindow">
                                                        <?php
                                                        $data_got = DB::getInstance()->querySample($queryStaff);
                                                        $no = 1;
                                                        foreach ($data_got as $staff) {
                                                            ?>
                                                            <li onclick="messaging('<?php echo $staff->staff_id; ?>');">
                                                                <div class="prog-avatar">
                                                                    <img src="images/default.jpg" alt="" width="40" height="40">
                                                                </div>
                                                                <div class="details">
                                                                    <div class="title">
                                                                        <a ><?php echo $staff->name; ?></a>  
                                                                    </div>
                                                                    <div>
                                                                        <span class="clsAvailable"><?php echo $staff->staff_title; ?> : <?php echo DB::getInstance()->displayTableColumnValue("select department_name from department where id='$staff->department_id' ", "department_name"); ?></span>
                                                                        <?php
                                                                        $activemessage = DB::getInstance()->displayTableColumnValue("select count(Id) as active_message from messaging where Sender_id='$staff->staff_id' and Receiver_id='$staff_idd' and Status='1' ", "active_message");
                                                                        if ($activemessage > 0) {
                                                                            $class_hidden = "badge blue-bgcolor pull-right";
                                                                        } else {
                                                                            $class_hidden = "hidden";
                                                                        }
                                                                        ?>
                                                                        <span  class="<?php echo $class_hidden; ?>">
                                                                            <?php echo $activemessage; ?> 
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <?php
                                                            $no++;
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo '<div class="alert alert-danger">No staff registered</div>';
                                }
                                ?>
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
        <script type="text/javascript">


            function selectDepartment(department, returnid) {
                if (department !== "") {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=<?php echo "ajax_data"; ?>',
                        data: {action: "returndepartmentalfiles", departmentId: department},
                        success: function (html) {
                            $('#' + returnid).html(html);

                        }
                    });
                } else {
                    $('#' + returnid).html("<h5 style='color:red'>No department selected</h5>");
                }
            }
        
        </script>
    </body>

</html>