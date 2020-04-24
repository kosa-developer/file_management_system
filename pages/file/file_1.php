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
                                    <div class="page-title">File(s) For <span  class="btn-warning"><?php echo $department_name; ?></span>  Department</div>
                                </div>
                                <div class="actions panel_actions pull-right">
                                    <a class="btn btn-primary" href="index.php?page=<?php echo "file" . '&mode=' . $modez = ($mode == 'registered') ? 'register' : 'registered'; ?>"><i class="fa fa-eye"></i><?php echo $modez = ($mode == 'registered') ? 'Register' : 'Registered'; ?> File(s)</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12" <?php echo $hidden; ?>>
                                <?php
                                $staff_id = $_SESSION['staff_id'];
                                $department_id = $_SESSION['department'];
                                if (Input::exists() && Input::get("submit_file") == "submit_file") {
                                    $file_name = Input::get('file_name');
                                    $file = $_FILES['file']['name'];
                                    $temp_file = $_FILES["file"]["tmp_name"];


                                    $duplicate = 0;
                                    $submited = 0;
                                    for ($i = 0; $i < sizeof($file_name); $i++) {
                                        $queryDup = DB::getInstance()->checkRows("select * from file where file_name='$file_name[$i]'");

                                        if ($file[$i] != "") {
                                            $starget_dir = "uploaded_files/";
                                            $starget_file = $starget_dir . $file[$i];
                                            move_uploaded_file($temp_file[$i], $starget_file);
                                        }
                                        if (!$queryDup) {
                                            DB::getInstance()->insert("file", array(
                                                "file_name" => $file_name[$i],
                                                "file" => $file[$i],
                                                "staff_id" => $staff_id,
                                                "department_id" => $department_id));
                                            $submited++;
                                        } else {
                                            $duplicate++;
                                        }
                                    }
                                    if ($submited > 0) {
                                        echo '<div class="alert alert-success">' . $submited . ' file(s) submitted successfully</div>';
                                    }
                                    if ($duplicate > 0) {
                                        echo '<div class="alert alert-warning">' . $duplicate . ' file(s) already exisits</div>';
                                    }
                                    Redirect::go_to("index.php?page=file&mode=" . $mode);
                                }
                                ?>
                                <form role="form" action="index.php?page=<?php echo "file" . '&mode=' . $mode; ?>"method="POST" enctype="multipart/form-data">
                                    <div class="card card-topline-yellow">
                                        <div class="card-head">
                                            <header>Upload file(s)</header>
                                        </div>
                                        <div class="card-body " id="bar-parent">

                                            <div id="question"><button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_element();">Add more</button>
                                                <div id="add_element" > 
                                                    <div class="form-group col-md-7" >
                                                        <label>File Name/description</label>
                                                        <textarea name="file_name[]" rows="2" class="form-control" required></textarea>

                                                    </div>
                                                    <div class="form-group col-md-2" id="add_element">
                                                        <label>File</label>
                                                        <input type="file" class="form-control" name="file[]" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf" required >
                                                    </div>

                                                    <br/> 
                                                </div>
                                            </div>
                                            <div class="box-footer">

                                                <button type="submit"  name="submit_file" value="submit_file" class="btn btn-primary pull-right">Submit</button>
                                                <button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_element();">Add more</button>
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

                                    $file_id = $_GET['file_id'];
                                    $query = DB::getInstance()->query("UPDATE file SET status=0 WHERE file_id='$file_id'");
                                    if ($query) {

                                        echo $message = "<center><h4 style='color:red'>data has been deleted successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=file&mode=" . $mode);
                                }
                                if (Input::exists() && Input::get("edit_file") == "edit_file") {
                                    $file_id = Input::get('file_id');
                                    $file_name = Input::get('file_name');
                                    $file = $_FILES['file']['name'];
                                    $temp_file = $_FILES["file"]["tmp_name"];
                                    $file_z = DB::getInstance()->displayTableColumnValue("select file from file where file_id='$file_id' ", "file");


                                    if ($file != "") {
                                        $starget_dir = "uploaded_files/";
                                        $starget_file = $starget_dir . $file;
                                        move_uploaded_file($temp_file, $starget_file);
                                        unlink("uploaded_files/" . $file_z);
                                        $editquestion = DB::getInstance()->update("file", $file_id, array(
                                            "file_name" => $file_name,
                                            "file" => $file), "file_id");
                                    } else {

                                        $editquestion = DB::getInstance()->update("file", $file_id, array(
                                            "file_name" => $file_name), "file_id");
                                    }

                                    if ($editquestion) {

                                        echo $message = "<center><h4 style='color:blue'>data has been edited successfully</h4></center>";
                                    } else {
                                        echo $error = "<center><h4 style='color:red'>there is a server error</h4></center>";
                                    }
                                    Redirect::go_to("index.php?page=file&mode=" . $mode);
                                }

                                if (Input::exists() && Input::get("send_email") == "send_email") {
                                    $file_id = Input::get('file_id');
                                    $email = Input::get('email');
                                    $code = generatePasswordz();
                                    $editquestion = DB::getInstance()->query("UPDATE file SET key='$code' WHERE file_id='$file_id'");
                                    if ($editquestion) {
                                        sendEmail($email, $code);
                                        $message = "File has been shared ";
                                    }
                                }
                                ?>

                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header><?php echo $modez = ($mode == 'registered') ? '' : 'Last entered 10 '; ?>File List</header><span id="email_result" class="center"></span>
                                    </div>
                                    <div class="card-body " id="bar-parent">
                                        <?php
                                        $queryfile = 'SELECT * FROM file WHERE status=1 and  department_id="' . $department_id . '" ORDER BY staff_id' . $limit;
                                        if (DB::getInstance()->checkRows($queryfile)) {
                                            ?>
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 1%;">#</th>
                                                        <th >File Name/Description</th>
                                                        <th >File</th>
                                                        <th style="width: 20%;"></th>
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
                                                            <td style="width: 20%;">
                                                                <div class="btn-group btn-xs <?php echo $hide; ?>">
                                                                    <button type="button" class="btn btn-success">Action</button>
                                                                    <button type="button" class="btn btn-success  dropdown-toggle" data-toggle="dropdown">
                                                                        <span class="caret"></span>
                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">

                                                                        <li><a  data-toggle="modal" data-target="#modal-<?php echo $file->file_id; ?>">Edit</a></li>
                                                                        <li><a href="index.php?page=<?php echo "file" . '&action=delete&file_id=' . $file->file_id . '&mode=' . $mode; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $file->Question; ?>?');">Delete</a></li>
                                                                        <li class="divider"></li>

                                                                    </ul>
                                                                    <a  data-toggle="modal" class="btn btn-primary btn-xs <?php echo $hide; ?>" data-target="#modal-share_<?php echo $file->file_id; ?>"><i class="fa fa-share"></i>Share</a>
                                                                </div>

                                                            </td>

                                                    <div class="modal fade" id="modal-<?php echo $file->file_id; ?>">
                                                        <div class="modal-dialog">
                                                            <form role="form" action="index.php?page=<?php echo "file" . '&mode=' . $mode; ?>" method="POST" enctype="multipart/form-data">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>

                                                                    </div> <div class="modal-body">
                                                                        <input type="hidden" name="file_id" value="<?php echo $file->file_id ?>">
                                                                        <div class="form-group">
                                                                            <label>File Name/description</label>
                                                                            <textarea name="file_name" rows="2" class="form-control" required><?php echo $file->file_name; ?></textarea>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>File</label>
                                                                            <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf"  >

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="edit_file" value="edit_file" class="btn btn-primary">Save changes</button>
                                                                    </div>


                                                                </div>
                                                            </form>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>

                                                    <div class="modal fade" id="modal-share_<?php echo $file->file_id; ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>

                                                                </div> 
                                                                <div class="modal-body">
                                                                    <div id="question"><button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_email();">Add more</button>
                                                                        <div id="add_email" > 
                                                                            <div class="form-group">
                                                                                <label>emails</label>
                                                                                <input type="text" class="form-control" name="email_sent[]"  required />
                                                                            </div>
                                                                        </div></div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                                                    <button type="submit" name="send_email" data-dismiss="modal" value="send_email" onclick="send_email('<?php echo $file->file_id ?>');" class="btn btn-primary">send</button>
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
        <script>

       function add_email() {
                
                var row_ids = Math.round(Math.random() * 300000000);
                document.getElementById('add_email').insertAdjacentHTML('beforeend',
                        '<div id="' + row_ids + '"><div class="form-group">\n\
    <input type="email"  name="email_sent[]" class="form-control" required/>\n\
<button type="button" value="' + row_ids + '" class="btn btn-danger btn-xs pull-right" onclick="delete_email(this.value);">\n\
<i class ="fa fa-times"></i></button>\n\
    </div>');

            }
            function delete_email(element_id) {
                jQuery('#' + element_id).html('');
            }
            
            function add_element() {
                var row_ids = Math.round(Math.random() * 300000000);
                document.getElementById('add_element').insertAdjacentHTML('beforeend',
                        '<div id="' + row_ids + '"><div class="form-group col-md-7">\n\
     <textarea name="file_name[]" rows="2" class="form-control" required></textarea> \n\
 </div>\n\
 <div class="form-group col-md-3" >\n\
    <input type="file"  name="file[]" class="form-control" required/>\n\
<button type="button" value="' + row_ids + '" class="btn btn-danger btn-xs pull-right" onclick="delete_item(this.value);">\n\
<i class ="fa fa-times"></i></button>\n\
</div>\n\
    </div>');

            }
            function delete_item(element_id) {
                jQuery('#' + element_id).html('');
            }


     
            
            
            function send_email(file_id) {

                var email_sent =  document.getElementsByName('email_sent[]');
            var    email_sent_data=[];
           
        for (var i = 0; i < email_sent.length; i++) {
            if(email_sent[i].value!=''){
      email_sent_data[i]=email_sent[i].value;
  }
        }  
          jQuery('#email_result').css({'color': 'red', 'font-style': 'italic', 'font-size': '150%'});
                        jQuery('#email_result').html('Sending....');
                      jQuery.ajax({
                type: 'POST',
                url: 'index.php?page=ajax_data',
                data: {submit_text: "send_email", file_id: file_id, email: email_sent_data},
                success: function (html) {
                     
                    var word = 'Emails has been successfully sent';
                    var wordz = 'Email could not be sent';
                    var regex = new RegExp('\\b' + word + '\\b');
                    var regexz = new RegExp('\\b' + wordz + '\\b');
                    if (regex.test(html)) {
                        jQuery('#email_result').css({'color': 'blue', 'font-style': 'italic', 'font-size': '150%'});
                        jQuery('#email_result').html(word);
                    } else if (regexz.test(html)) {
                        jQuery('#email_result').css({'color': 'red', 'font-style': 'italic', 'font-size': '150%'});
                        jQuery('#email_result').html(wordz);
                    } else {
                        jQuery('#email_result').css({'color': 'red', 'font-style': 'italic', 'font-size': '150%'});
                        jQuery('#email_result').html('communication error');
                    }
                }
            });

          
    }

        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>