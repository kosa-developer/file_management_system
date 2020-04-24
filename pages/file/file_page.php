<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Responsive Admin Template" />
        <meta name="author" content="SeffyHospital" />
        <title>file Management</title>

        <!-- icons -->
        <link href="js/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

        <!--bootstrap -->
        <link href="js/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="js/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

        <!-- theme style -->
        <link href="css/theme_style.css" rel="stylesheet" id="rt_style_components" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/plugins.min.css" rel="stylesheet" type="text/css" />
        <link href="css/responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/theme-color.css" rel="stylesheet" type="text/css" />

        <!-- favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.png" /> 
    </head>
    <!-- END HEAD -->
    <body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-full-width page-md header-blue">
        <div class="page-wrapper">
            <!-- start header -->
            <?php
            include_once 'includes/policy_header_menu.php';
            ?>
            <!-- end header -->
            <!-- start page container -->

            <!-- end sidebar menu --> 
            <!-- start page content -->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="page-title center">welcome to File management system </div>
                        <div class="col-md-12">

                            <div class="card card-topline-green">
                                <div class="card-head">
                                    <header>File(s) </header>

                                </div>

                                <div class="card-body " id="bar-parent">
                                    <?php
                                    $code=(isset($_GET['code']))?$_GET['code']:"";
                                    $queryfile = 'SELECT * FROM file WHERE status=1 and  passcode="' . $code . '"';
                                    if (DB::getInstance()->checkRows($queryfile)) {
                                        ?>
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th >File Name/Description</th>
                                                    <th >File</th>
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
                                                </tr>
                                            </tfoot>

                                        </table>
                                        <?php
                                    } else {
                                        echo '<div class="alert alert-danger">No file uploads</div>';
                                    }
                                    ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function check(answer_id, question_id, staff_id, choice, count) {


                if (answer_id != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=<?php echo "ajax_data"; ?>',
                        data: {question_id: question_id, answer: answer_id, type: "submit_policy_answer", staff_id: staff_id, choice: choice},
                        success: function (html) {
                            if (document.getElementById(answer_id).checked == false) {
                                $('#' + question_id + '_' + count + '_answer').attr({
                                    "style": "color:black"        // values (or variables) here
                                });
                            }
                            if (document.getElementById(answer_id).checked == true && document.getElementById(answer_id).value != '') {
                                $('#' + question_id + '_' + count + '_answer').attr({
                                    "style": "color:blue"        // values (or variables) here
                                });
                            }

                        }
                    });
                } else {
                }
            }


            function radio(answer_id, question_id, staff_id, choice, count) {

                if (answer_id != '') {
                    $.ajax({
                        type: 'POST',
                        url: 'index.php?page=<?php echo "ajax_data"; ?>',
                        data: {question_id: question_id, answer: answer_id, type: "submit_policy_answer", staff_id: staff_id, choice: choice},
                        success: function (html) {
                            for (i = 1; i <= 10; i++) {
                                if (i != count) {

                                    $('#' + question_id + '_' + i + '_answer').attr({
                                        "style": "color:black"        // values (or variables) here
                                    });

                                } else {
                                    $('#' + question_id + '_' + count + '_answer').attr({
                                        "style": "color:blue"        // values (or variables) here
                                    });
                                }
                            }

                        }
                    });
                } else {
                }
            }

        </script>
        <!-- end page content -->
        <!-- end page container -->
        <!-- start footer -->
        <?php include_once 'includes/footer.php'; ?>
        <!-- end footer -->
        <!-- start js include path -->
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery.blockui.min.js" type="text/javascript"></script>
        <!-- bootstrap -->
        <script src="js/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="js/jquery.slimscroll.js"></script>
        <script src="js/app.js" type="text/javascript"></script>
        <script src="js/layout.js" type="text/javascript"></script>
        <script src="js/theme-color.js" type="text/javascript"></script>


        <!-- end js include path -->
    </body>
</html>