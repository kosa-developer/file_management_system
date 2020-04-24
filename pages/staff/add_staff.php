<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->

    <head>
        <?php include_once 'includes/header_css.php'; ?>
    </head>
    <!-- END HEAD -->
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

                $query_number = DB::getInstance()->displayTableColumnValue("select Code from staff order by staff_id desc Limit 1", "Code");
                $number = $query_number + 1;
                if (isset($_GET['mode'])) {
                    echo $mode = $_GET['mode'];

                    if ($mode == 'register') {
                        $hidden = "";
                        $class_width = "col-md-7";
                        $limit = "limit 10";
                        $delete_button="hidden";
                    } else {
                        $delete_button="";
                        $hidden = "hidden";
                        $class_width = "col-md-12";
                        $limit = "";
                    }
                }
                ?>
                <!-- end sidebar menu -->
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">Staff</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "add_staff" . '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> Staff</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-5" <?php echo $hidden; ?>>
                                <?php
                                if ((isset($_SESSION['hospital_role']) && ($_SESSION['hospital_role'] == "Staff")) && !isset($_SESSION['immergencepassword'])) {
                                    $type = "Policy";
                                } else {
                                    $type = "Survey";
                                }

                                if (Input::exists() && Input::get("add_staff") == "add_staff") {
                                    $department_id = Input::get('department_id');
                                    $name = Input::get('name');
                                    $staff_title = Input::get("staff_title");
                                    $username = Input::get("username");
                                    $usertype = Input::get("usertype");
                                    $password = md5(Input::get('password'));
                                    $confirm_password = md5(Input::get('confirm_password'));
                                    if ($password !== $confirm_password) {
                                        echo "<h4 style='color:red;'><center>Password do not match. please try again</center></h4>";
                                    } else {
                                        $queryDup = DB::getInstance()->checkRows("select * from staff where name='$name' and department_id='$department_id'");
                                        if (!$queryDup) {
                                            DB::getInstance()->insert("staff", array(
                                                "name" => $name,
                                                "department_id" => $department_id,
                                                "user_name" => $username,
                                                "staff_title" => $staff_title,
                                                "password" => $password,
                                                "user_type" => $usertype
                                            ));
                                            $message = "" . $name . " has been successfull regestered";
                                            echo "<h4 style='color:blue;'><center>" . $message . "</center></h4>";
                                          
                                        } else {
                                            echo "<h4 style='color:red;'><center>Staff already exists</center></h4>";
                                        }
                                        Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                    }
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo "add_staff" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register staff</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                            <div class="form-group">
                                                <label>Staff Name</label>
                                                <input type="text" class="form-control" name="name" placeholder="Enter staff names" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input type="text" class="form-control" name="staff_title" placeholder="Enter staff title" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select class="form-control select2" name="department_id" style="width: 100%;">
                                                    <option value="">Select...</option>
                                                    <?php
                                                    $departmentList = DB::getInstance()->querySample("SELECT * FROM department WHERE Status=1");
                                                    foreach ($departmentList AS $department) {
                                                        echo '<option value="' . $department->id . '"> ' . $department->department_name . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>User Type</label>
                                                <select class="form-control select2" name="usertype" style="width: 100%;">
                                                    <option value="">Select...</option>
                                                    <option value="Admin">Admin</option>
                                                    <option value="User">User</option>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>User name</label>
                                                <input type="text" class="form-control" name="username" placeholder="Enter username" >
                                            </div>

                                            <div class="form-group">
                                                <label>password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Enter password" >
                                            </div>

                                            <div class="form-group">
                                                <label>Confirm password</label>
                                                <input type="password" class="form-control" name="confirm_password" placeholder="confirm password" >
                                            </div>

                                            <div class="box-footer">
                                                <button type="submit"  name="add_staff" value="add_staff" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <!-- /.col (left) -->
                            <div class="<?php echo $class_width; ?>">
                                <?php
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $staff_id = $_GET['staff_id'];

                                    $query = DB::getInstance()->query("UPDATE staff SET Status=0 WHERE staff_id='$staff_id'");
                                    if ($query) {

                                        $name = DB::getInstance()->displayTableColumnValue("select name from staff where staff_id='$staff_id' ", "name");
                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("edit_staff") == "edit_staff") {
                                    $staff_id = Input::get('staff_id');
                                    $department_id = Input::get('department_id');
                                    $name = Input::get('name');
                                    $staff_title = Input::get("staff_title");
                                    $usertype = Input::get("usertype");
                                    $password = md5(Input::get('password'));

                                   if (Input::get('password') == "") {
                                        $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                            "name" => $name,
                                            "department_id" => $department_id,
                                            "staff_title" => $staff_title,
                                            "user_type" => $usertype
                                                ), "staff_id");
                                    } else {
                                        $editStaff = DB::getInstance()->update("staff", $staff_id, array(
                                            "name" => $name,
                                            "department_id" => $department_id,
                                            "staff_title" => $staff_title,
                                            "password" => $password,
                                            "user_type" => $usertype
                                                ), "staff_id");
                                    }




                                    if ($editStaff) {
                                        echo $message = "<center><h4 style='color:blue'>data has been edited successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    $test_mode = (isset($_GET["mode"])) ? "&mode=view" : "";
                                    Redirect::go_to("index.php?page=add_staff&mode=" . $mode);
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>staff List</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <center>   <span style="color:red;" id="result"></span></center>
                                        <?php
                                        $queryStaff = 'SELECT * FROM staff WHERE Status=1 ORDER BY staff_id desc ' . $limit;
                                        if (DB::getInstance()->checkRows($queryStaff)) {
                                            ?>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th style="width: 25%;">Staff Name</th>
                                                        <th style="width: 15%;">Title</th>
                                                        <th style="width: 15%;">Department</th>
                                                        <th style="width: 15%;">Username</th>
                                                        <th style="width: 15%;" <?php echo $delete_button?>></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($queryStaff);
                                                    $no = 1;
                                                    foreach ($data_got as $staff) {
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td style="width: 25%;"><?php echo $staff->name; ?></td>
                                                            <td style="width: 15%;"><?php echo $staff->staff_title; ?></td>
                                                            <td style="width: 15%;"><?php echo DB::getInstance()->displayTableColumnValue("select department_name from department where id='$staff->department_id' ", "department_name"); ?></td>
                                                            <td style="width: 15%;"><?php echo $staff->user_name; ?></td>
                                                            <td style="width: 25%;"  <?php echo $delete_button?>><div class="btn-group xs">

                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a  data-toggle="modal" data-target="#modal-<?php echo $staff->staff_id; ?>">Edit</a></li>
                                                                        <?php
                                                                        if ((isset($_SESSION['user_type']) && ($_SESSION['user_type'] == "user")) && !isset($_SESSION['immergencepassword'])) {
                                                                            
                                                                        } else {
                                                                            ?>
                                                                            <li><a href="index.php?page=<?php echo "add_staff" . '&action=delete&staff_id=' . $staff->staff_id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $staff->name; ?>?');">Delete</a></li>
                                                                        <?php } ?> <li class="divider"></li>

                                                                    </ul>
                                                                </div>

                                                            </td>


                                                    <div class="modal fade" id="modal-<?php echo $staff->staff_id; ?>">
                                                        <div class="modal-dialog">
                                                            <form role="form" action="index.php?page=<?php echo "add_staff" . '&mode=' . $mode; ?>" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Edit <?php echo $staff->name; ?>'s Information</h4>
                                                                    </div> <div class="modal-body">

                                                                        <div class="form-group">
                                                                            <label>Staff Name</label>
                                                                            <input type="text" class="form-control" value="<?php echo $staff->name; ?>" name="name" placeholder="Enter staff names" required>
                                                                          <input type="hidden" class="form-control" value="<?php echo $staff->staff_id; ?>" name="staff_id" >
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Title</label>
                                                                            <input type="text" class="form-control" value="<?php echo $staff->staff_title; ?>" name="staff_title" placeholder="Enter staff title" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Department</label>
                                                                            <select class="form-control select2" name="department_id" style="width: 100%;">
                                                                                <option value="">Select...</option>
                                                                                <?php
                                                                                $departmentList = DB::getInstance()->querySample("SELECT * FROM department WHERE Status=1");
                                                                                foreach ($departmentList AS $department) {
                                                                                    $selected = ($staff->department_id == $department->id ) ? "selected" : "";
                                                                                    echo '<option value="' . $department->id . '" ' . $selected . '> ' . $department->department_name . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label>User Type</label>
                                                                            <select class="form-control select2" name="usertype" style="width: 100%;">
                                                                                <option value="">Select...</option>
                                                                                <option  value="Admin" <?php echo $selected = ($staff->user_type == "Admin" ) ? "selected" : ""; ?>>Admin</option>
                                                                                <option value="User" <?php echo $selected = ($staff->user_type == "User" ) ? "selected" : ""; ?>>User</option>

                                                                            </select>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label>password</label>
                                                                            <input type="password" class="form-control" value="" name="password" placeholder="Enter password" >
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit_staff" value="edit_staff" class="btn btn-primary">Save changes</button>
                                                                    </div>


                                                                </div>
                                                            </form>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                    </tr>
                                                    <?php
                                                    $no++;
                                                }
                                                ?>
                                                </tbody>

                                            </table>
                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No staff registered</div>';
                                        }
                                        ?>






                                        <!-- /.box-body -->
                                    </div>
                                </div>
                                <!-- /.col (right) -->
                            </div>
                            <!-- /.row -->
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
        <!-- start js include path -->

        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>