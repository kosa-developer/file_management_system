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
                <?php include_once 'includes/side_menu.php'; ?>
                <!-- end sidebar menu -->
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">
                        <div class="page-bar">
                            <div class="page-title-breadcrumb">
                                <div class=" pull-left">
                                    <div class="page-title">System users</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=view_users"><i class="fa fa-eye"></i> View Users</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-8">
                                <?php
                                if (Input::exists()) {
                                    if (Input::get("submit_user") == "submit_user") {
                                        $staff_id = Input::get("staff_id");
                                        $user = Input::get('user');
                                        $user_type = Input::get('user_type');
                                        $pass = md5(Input::get('pass'));
                                        $confirmpass = md5(Input::get('confirmpass'));
                                        if ($pass == $confirmpass) {
                                            $queryDup = DB::getInstance()->checkRows("select * from account where User_Name='$user' and Password='$pass'");
                                            if ($queryDup) {
                                                echo '<div class="alert alert-danger">The account credentials already exists</div>';
                                            } else {
                                                $query = DB::getInstance()->query("INSERT INTO account(Staff_Id,User_Name,User_Type,Password) VALUES($staff_id,'$user','$user_type','$pass')");
                                                if ($query) {
                                                    $message = "The account credentials have been set to username=  " . $user . "  password= " . Input::get('pass');
                                                    echo '<div class="alert alert-success">' . $message . '</div>';
                                                } else {
                                                    echo '<div class="alert alert-danger">there is an error</div>';
                                                }
                                            }
                                        } else {
                                            echo '<div class="alert alert-danger">password combination do not match</div>';
                                        }
                                        Redirect::go_to("index.php?page=add_user");
                                    }
                                }
                                ?>
                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header>User Account entry form</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <form role="form" action="" method="post">
                                                <div class="form-group">
                                                    <label>Staff Names:</label>
                                                    <select class="form-control select2" name="staff_id" style="width: 100%;">
                                                        <option value="">Select...</option>
                                                        <?php
                                                        $staffList = DB::getInstance()->querySample("SELECT * FROM staff WHERE Status=1");
                                                        foreach ($staffList AS $staffs) {
                                                            echo '<option value="' . $staffs->Staff_Id . '">(' . $staffs->Code . ') ' . $staffs->Staff_Name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Enter Username:</label>
                                                    <input type="text" class="form-control" name="user" placeholder="Enter username" required>
                                                </div>


                                                <div class="form-group">
                                                    <label>Enter User Type:</label>
                                                    <select class="form-control select2" name="user_type" style="width: 100%;">
                                                        <option value="">Select...</option>
                                                        <option value="Human Resource">Human Resource</option>
                                                        <option value="Staff">Other staff</option>
                                                        <option value="PAED">PAED User</option>
                                                        <option value="Admin">Admin</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Enter  password:</label>
                                                    <input type="password" name="pass" class="form-control"  placeholder="Enter password" required>

                                                </div>


                                                <div class="form-group">
                                                    <label>Confirm new Password:</label>
                                                    <input type="password" name="confirmpass" class="form-control"  placeholder="Confirm password" required>

                                                </div>

                                                <?php
                                                if (isset($_GET['error'])) {
                                                    $error = $_GET['error'];
                                                    echo "<h6 style='color:red;'><center>" . $error . "</center></h6>";
                                                }
                                                if (isset($_GET['message'])) {
                                                    $message = $_GET['message'];
                                                    echo "<h6 style='color:blue;'><center>" . $message . "</center></h6>";
                                                }
                                                ?>

                                                <div class="box-footer">
                                                    <button type="submit"  name="submit_user" value="submit_user" class="btn btn-primary pull-right">Submit</button>
                                                </div>


                                            </form>
                                        </form>
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
        <!-- start js include path -->
        <script>
            function modulesSelected() {
                var modulesAccessedElement = document.getElementById('modules_accessed');
                var selectedValues = new Array();
                for (var i = 0; i < modulesAccessedElement.options.length; i++) {
                    selectedValues.push(modulesAccessedElement.options[i].value);
                    modulesAccessedElement.getElementsByTagName('option')[i].selected = true;
                }
                selectedValues = (selectControl.innerHTML === "select all") ? selectedValues : null;
                $('#modules_accessed').val(selectedValues).trigger('change');
                selectControl.innerHTML = (selectControl.innerHTML === "select all") ? "unselect all" : 'select all';
            }
        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>