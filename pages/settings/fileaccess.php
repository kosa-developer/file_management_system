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
                if (isset($_GET['mode'])) {
                    echo $mode = $_GET['mode'];
                    $hidden = "";
                    $hidden2 = "";
                    if ($mode == 'register') {

                        $hidden = "";
                        $hidden2 = "hidden";
                        $class_width = "col-md-7";
                        $limit = "limit 10";
                    } else {
                        $hidden2 = "";
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
                                    <div class="page-title">File Access rights</div>
                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <!-- /.col (left) -->
                            <div  class="col-md-12" <?php echo $hidden2; ?>>
                                <?php
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $right_id = $_GET['right_id'];
                                    $query = DB::getInstance()->query("Delete from restrict_member WHERE Id='$right_id'");
                                    if ($query) {

                                        echo $message = "<center><h4 style='color:red'>Member can now access this file</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=fileaccess&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("removerights") == "removerights") {

                                    $file = Input::get('file_id');
                                    $staff_id = Input::get('staff_id');

                                    $submited = 0;
                                    $duplicate=0;
                                    if (!empty($staff_id)) {
                                        for ($i = 0; $i < sizeof($staff_id); $i++) {
                                            $queryDup = DB::getInstance()->checkRows("select * from restrict_member where  Staff_id='$staff_id[$i]' and File_id ='$file'");
                                            if (!$queryDup) {
                                                DB::getInstance()->insert("restrict_member", array(
                                                    "Staff_id" => $staff_id[$i],
                                                    "File_id" => $file));
                                                $submited++;
                                            } else {
                                                $duplicate++;
                                            }
                                        }
                                        if ($submited > 0) {
                                            echo '<div class="alert alert-success">' . $submited . ' members blocked</div>';
                                        }
                                          if ($duplicate > 0) {
                                        echo '<div class="alert alert-warning">' . $duplicate . ' member(s) already blocked</div>';
                                    }
                                    } else {
                                        echo '<div class="alert alert-warning">Select members and try again</div>';
                                    }
                                    Redirect::go_to("index.php?page=fileaccess&mode=" . $mode);
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>File List</header><span id="email_result" class="center"></span>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $addedQuery = "";
                                        if ((isset($_SESSION['user_type']) && $_SESSION['user_type'] != "Admin") && !isset($_SESSION['immergencepassword'])) {
                                            $addedQuery = " and department_id=" . $department_id . " ";
                                        } else {
                                            $addedQuery = "";
                                        }
                                        $queryfile = 'SELECT * FROM file WHERE status=1   ' . $addedQuery . ' ORDER BY staff_id' . $limit;
                                        if (DB::getInstance()->checkRows($queryfile)) {
                                            ?>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th >File Name/Description</th>
                                                        <th >File</th>
                                                        <th >Box file No.</th>
                                                        <th >Shelve No.</th>

                                                        <th >Department</th>
                                                        <th style="width: 20%;">Remove rights</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($queryfile);
                                                    $no = 1;
                                                    foreach ($data_got as $file) {
                                                        $hide = ($file->staff_id == $staff_id) ? "" : "hidden";
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td><?php echo $file->file_name; ?></td>

                                                            <td><a href="uploaded_files/<?php echo $file->file; ?>" target="_blank"><span class="fa fa-download"></span><?php echo $file->file; ?></a></td>
                                                            <td><?php echo $file->Box_number; ?></td>
                                                            <td><?php echo $file->Shelve_number; ?></td>
                                                            <td><?php echo DB::getInstance()->displayTableColumnValue("select department_name from department where id='$file->department_id' ", "department_name"); ?></td>
                                                            <td style="width: 20%;">
                                                                <a class="btn btn-danger"  data-toggle="modal" data-target="#modal-<?php echo $file->file_id; ?>">Remove access rights</a>
                                                                <a class="btn btn-warning"  data-toggle="modal" data-target="#restrict_modal-<?php echo $file->file_id; ?>">view Restricted members</a>
                                                            </td>

                                                    <div class="modal fade" id="modal-<?php echo $file->file_id; ?>">
                                                        <div class="modal-dialog">
                                                            <form role="form" action="index.php?page=<?php echo "fileaccess" . '&mode=' . $mode; ?>" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>

                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="file_id" value="<?php echo $file->file_id ?>">

                                                                        <div class="form-group">
                                                                            <label>Staff Names:</label>
                                                                            <select id="multiple" class="form-control select2" multiple name="staff_id[]" style="width: 80%;">
                                                                                <option value="">Select...</option>
                                                                                <?php
                                                                                $staffList = DB::getInstance()->querySample("SELECT * FROM staff WHERE user_type!='Admin' and Status=1");
                                                                                foreach ($staffList AS $staffs) {
                                                                                    echo '<option value="' . $staffs->staff_id . '">' . $staffs->name . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="removerights" value="removerights" class="btn btn-danger">Block members</button>
                                                                    </div>


                                                                </div>
                                                            </form>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>


                                                    <div class="modal fade" id="restrict_modal-<?php echo $file->file_id; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <header style="font-weight: bolder; color:red;">Members restricted from accessing <?php echo $file->file_name; ?></header>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>

                                                                </div>
                                                                <div class="modal-body table-bordered">
                                                                    <div class="col-md-5 table-bordered" style="font-weight: bolder">Member</div> 
                                                                    <div class="col-md-5 table-bordered" style="font-weight: bolder">Department</div>
                                                                    <div class="col-md-2 table-bordered">Allow</div>
                                                                    <?php
                                                                    $member_got = DB::getInstance()->querySample("select * from restrict_member where File_id='" . $file->file_id . "'");
                                                                    $no = 1;
                                                                    foreach ($member_got as $member) {
                                                                        ?>
                                                                        <div class="col-md-5 table-bordered" ><?php echo DB::getInstance()->displayTableColumnValue("select name from staff where staff_id='$member->Staff_id' ", "name"); ?></div> 
                                                                        <div class="col-md-5 table-bordered"  ><?php echo DB::getInstance()->displayTableColumnValue("select department_name from department,staff where staff.department_id=department.id and  staff.staff_id='$member->Staff_id'   ", "department_name"); ?></div>

                                                                        <div class="col-md-2 table-bordered"><a class="btn-xs btn-success" href="index.php?page=<?php echo "fileaccess" . '&action=delete&right_id=' . $member->Id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to grant access to <?php echo DB::getInstance()->displayTableColumnValue("select name from staff where staff_id='$member->Staff_id' ", "name"); ?>?');">access</a></div>  <?php
                                                        }
                                                        ?>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                                                                </div>


                                                            </div>

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
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th>File name/Description</th>
                                                        <th>file</th>
                                                        <th >Box file No.</th>
                                                        <th >Shelve No.</th>
                                                        <th>Department</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No file uploads</div>';
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