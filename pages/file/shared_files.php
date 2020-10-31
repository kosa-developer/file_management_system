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
                ?>
                <!-- end sidebar menu -->
                <!-- start page content -->
                <div class="page-content-wrapper">
                    <div class="page-content">

                        <div class="row">

                            <!-- /.col (left) -->
                            <div  class="col-md-12">


                                <div class="card card-topline-yellow">
                                    <div class="card-head">
                                        <header>Shared files</header><span id="email_result" class="center"></span>
                                    </div>
                                    <div class="card-body " id="shared_files_id">
                                        <?php
                                        $queryfile = 'SELECT shared_files.Time,file.file_name,file.file,file.department_id,file.Box_number,file.Shelve_number,shared_files.Sender_id,shared_files.Id,shared_files.Status FROM file,shared_files WHERE file.file_id=shared_files.File_id and shared_files.Receiver_id="' . $recz_id . '" and  file.status=1  ORDER BY shared_files.Status desc';
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
                                                        <th >Shared by</th>
                                                        <th >Date</th>
                                                        <th >Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $data_got = DB::getInstance()->querySample($queryfile);
                                                    $no = 1;
                                                    foreach ($data_got as $file) {
                                                        ?>
                                                        <tr> 
                                                            <td style="width: 1%;"><?php echo $no; ?></td>
                                                            <td><?php echo $file->file_name; ?></td>

                                                            <td><a href="uploaded_files/<?php echo $file->file; ?>" onclick="downloadedfile('<?php echo $file->Id; ?>');" target="_blank"><span class="fa fa-download"></span><?php echo $file->file; ?></a></td>
                                                            <td><?php echo $file->Box_number; ?></td>
                                                            <td><?php echo $file->Shelve_number; ?></td>
                                                            <td><?php echo DB::getInstance()->displayTableColumnValue("select department_name from department where id='$file->department_id' ", "department_name"); ?></td>
                                                            <td style="width: 20%;">
                                                                <?php echo DB::getInstance()->displayTableColumnValue("select name from staff where staff_id='$file->Sender_id' ", "name"); ?>
                                                            </td>
                                                            <td><?php echo english_date_time($file->Time); ?></td>
                                                            <td><?php echo ($file->Status == 1) ? "<span class='btn btn-circle btn-warning btn-xs'>Pending</span>" : "<span class='btn btn-circle btn-info btn-xs'>Seen</span>"; ?></td>


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
                                                        <th>Shared by</th>
                                                        <th >Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                            <?php
                                        } else {
                                            echo '<div class="alert alert-danger">No shared file yet</div>';
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

            function add_email(id) {

                var row_ids = Math.round(Math.random() * 300000000);
                document.getElementById('add_email' + id).insertAdjacentHTML('beforeend',
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
                        '<div id="' + row_ids + '"><div class="form-group col-md-3">\n\
            <input type="text" name="file_name[]"  class="form-control" required>\n\
        </div>\n\
        <div class="form-group col-md-2" >\n\
           <input type="file"  name="file[]" class="form-control" required/></div>\n\
        <div class="form-group col-md-3" >\n\
            <input type="text" name="box_number[]" class="form-control"/>\n\
        </div>\n\
        <div class="form-group col-md-3" >\n\
            <input type="text" name="shelve[]" class="form-control"/>\n\
<button type="button" value="' + row_ids + '" class="btn btn-danger btn-xs pull-right" onclick="delete_item(this.value);">\n\
<i class ="fa fa-times"></i></button>\n\
</div>\n\
    </div>');

            }
            function delete_item(element_id) {
                jQuery('#' + element_id).html('');
            }





            function send_email(file_id) {

                var email_sent = document.getElementsByName('email_sent[]');
                var email_sent_data = [];

                for (var i = 0; i < email_sent.length; i++) {
                    if (email_sent[i].value != '') {
                        email_sent_data[i] = email_sent[i].value;
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
                            jQuery('#email_result').html('Connection erorr');
                        }
                    }
                });


            }
            function downloadedfile(file_id) {

                $.ajax({
                    type: 'POST',
                    url: 'index.php?page=<?php echo "ajax_data"; ?>',
                    data: {action: "downloadfile", file_id: file_id},
                    success: function (html) {
                        $("#shared_files_id").load(window.location.href + " #shared_files_id");
                    }
                });
            }

        </script>
        <?php include_once 'includes/footer_js.php'; ?>
        <!-- end js include path -->
    </body>

</html>