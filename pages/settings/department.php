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
                                    <div class="page-title">Department(s)</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "department". '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> department(s)</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-5" <?php echo $hidden; ?>>
                                <?php
                                if (Input::exists() && Input::get("submit_department") == "submit_department") {
                                    $department = Input::get('department');
                                    $duplicate = 0;
                                    $submited = 0;
                                    for ($i = 0; $i < sizeof($department); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from department where department_name='$department[$i]'");
                                        if (!$queryDup) {
                                            DB::getInstance()->insert("department", array(
                                                "department_name" => $department[$i]));
                                            $submited++;
                                           } else {
                                            $duplicate++;
                                        }
                                       
                                    }
                                     if ($submited > 0) {
                                            echo '<div class="alert alert-success">' . $submited . ' department(s) submitted successfully</div>';
                                        }
                                        if ($duplicate > 0) {
                                            echo '<div class="alert alert-warning">' . $duplicate . ' departments already exisits</div>';
                                        }
                                    Redirect::go_to("index.php?page=department&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo "department" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Register department</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                            <div id="department"><button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_element();">Add more</button>
                                                <div class="form-group" id="add_element">
                                                    <label>department(s)</label>
                                                    <input type="text" name="department[]"  class="form-control" required>

                                                    <br/> </div>
                                            </div>
                                            <div class="box-footer">
                                                <button type="submit"  name="submit_department" value="submit_department" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                </form>

                            </div>
                            <!-- /.col (left) -->
                            <div  class="col-md-12" <?php echo $hidden2; ?>>
                                <?php
                                if (isset($_GET['action']) && $_GET['action'] == 'delete') {

                                    $id = $_GET['id'];
                                    $query = DB::getInstance()->query("UPDATE department SET Status=0 WHERE id='$id'");
                                    if ($query) {

                                        $department = DB::getInstance()->displayTableColumnValue("select department_name from department where id='$id' ", "department");
                                       
                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=department&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("edit_department") == "edit_department") {
                                    $id = Input::get('id');
                                    $department = Input::get('department');
                                    $department_z = DB::getInstance()->displayTableColumnValue("select department_name from department where id='$id' ", "department_name");

                                    $editdepartment = DB::getInstance()->update("department", $id, array(
                                        "department_name" => $department), "id");


                                    if ($editdepartment) {
                                            echo $message = "<center><h4 style='color:blue'>data has been edited successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=department&mode=" . $mode);
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>departments List</header>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $querydepartment = 'SELECT * FROM department WHERE Status=1 ORDER BY id' . $limit;
                                        if (DB::getInstance()->checkRows($querydepartment)) {
                                            ?>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th >Department</th>
                                                        <th style="width: 20%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($querydepartment);
                                                    $no = 1;
                                                    foreach ($data_got as $departmentx) {
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td><?php echo $departmentx->department_name; ?></td>
                                                            <td style="width: 20%;">
                                                                <div class="btn-group xs">
                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a  data-toggle="modal" data-target="#modal-<?php echo $departmentx->id; ?>">Edit</a></li>
                                                                        <li><a href="index.php?page=<?php echo "department" . '&action=delete&id=' . $departmentx->id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $departmentx->department_name; ?>?');">Delete</a></li>
                                                                        <li class="divider"></li>

                                                                    </ul>
                                                                </div>

                                                            </td>

                                                    <div class="modal fade" id="modal-<?php echo $departmentx->id; ?>">
                                                        <div class="modal-dialog">
                                                            <form role="form" action="index.php?page=<?php echo"department" . '&mode=' . $mode; ?>" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>

                                                                    </div> <div class="modal-body">
                                                                        <input type="hidden" name="id" value="<?php echo $departmentx->id ?>">
                                                                        <div class="form-group">
                                                                            <label>department(s)</label>
                                                                            <textarea name="department" rows="2" class="form-control" required><?php echo $departmentx->department_name ?></textarea>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit_department" value="edit_department" class="btn btn-primary">Save changes</button>
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
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th>department</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No department registered</div>';
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
        <script>
            function add_element() {
                var row_ids = Math.round(Math.random( ) * 300000000);
                document.getElementById('add_element').insertAdjacentHTML('beforeend',
                        '<div id="' + row_ids + '">\n\
     <input type="text" name="department[]"  class="form-control" required> \n\
 <button type="button" value="' + row_ids + '" class="btn btn-danger btn-xs pull-right" onclick="delete_item(this.value);">\n\
<i class ="fa fa-times"></i></button> </div>');

            }
            function delete_item(element_id) {
                $('#' + element_id).html('');
            }

        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>