<?php
if (isset($_POST["submit_text"]) && $_POST['submit_text'] == "send_email") {

    $file_id = Input::get("file_id");
    $email = Input::get('email');
    $code = generatePasswordz();
    $editquery = DB::getInstance()->query("UPDATE file SET passcode='$code' WHERE file_id='$file_id'");
    if ($editquery) {
        sendEmail($email, $code);
        $message = "File has been shared ";
    }
//     echo send_policy_Email($staff_id,$email,$staff_name,$code,$system_email,$system_email_password);
}

if (isset($_POST["action"]) && $_POST['action'] == "returndepartmentalfiles") {
    $department = $_POST['departmentId'];
    $queryfile = 'SELECT * FROM file WHERE status=1 and department_id="' . $department . '" ORDER BY staff_id' . $limit;
    if (DB::getInstance()->checkRows($queryfile)) {
        ?>
        <div class="card-head">
            <header><a><?php echo DB::getInstance()->displayTableColumnValue("select department_name from department where id='$department' ", "department_name"); ?></a> File List</header><span id="email_result" class="center"></span>
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 1%;">#</th>
                    <th >File Name/Description</th>
                    <th >File</th>
                    <th >Box file No.</th>
                    <th >Shelve No.</th>

                    <th >Department</th>
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
                        <td><?php echo $file->Box_number; ?></td>
                        <td><?php echo $file->Shelve_number; ?></td>
                        <td><?php echo DB::getInstance()->displayTableColumnValue("select department_name from department where id='$file->department_id' ", "department_name"); ?></td>
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
                                        <input name="file_name" class="form-control" value="<?php echo $file->file_name; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.txt,.pdf"  >

                                    </div>
                                    <div class="form-group" >
                                        <label>Box file No.</label>
                                        <input type="text" name="box_number" value="<?php echo $file->Box_number; ?>" class="form-control"/>
                                    </div>
                                    <div class="form-group" >
                                        <label>Shelve No.</label>
                                        <input type="text" name="shelve" value="<?php echo $file->Shelve_number; ?>" class="form-control"/>
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
                                <div id="question"><button type="button" class="btn btn-success btn-xs pull-right" id="add_more" onclick="add_email('<?php echo $file->file_id; ?>');">Add more</button>
                                    <div id="add_email<?php echo $file->file_id; ?>" > 
                                        <div class="form-group">
                                            <label>emails</label>
                                            <input type="text" class="form-control" name="email_sent[]"  required />
                                        </div>
                                    </div>
                                </div>


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
}

if (isset($_POST["action"]) && $_POST['action'] == "downloadfile") {
    $file_id= $_POST['file_id'];
      DB::getInstance()->update("shared_files", $file_id, array("Status" => '0'), "Id");
}
if (isset($_POST["action"]) && $_POST['action'] == "returnmessages") {
    $staff_id = $_POST['staff_id'];

    if (isset($_POST["button"]) && $_POST['button'] == "sendmessage") {
        $staff_id = $_POST['receiver'];
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $message = $_POST['message'];
        DB::getInstance()->insert("messaging", array(
            "Sender_id" => $sender,
            "Receiver_id" => $receiver,
            "Message" => $message));
    }
    if (isset($_POST["remove"])&& $_POST['remove'] == "clear_activemessage"){
        DB::getInstance()->update("messaging", $staff_id, array("Status" => '0'), "Sender_id");
    }
     
     ?>



    <div class="card card-topline-red ">
        <div class="card-head">
            <div class="prog-avatar">
                <img src="images/default.jpg" alt="" width="40" height="40">
            </div>
            <header><?php echo $member_name= DB::getInstance()->displayTableColumnValue("select name from staff where staff_id='$staff_id' ", "name"); ?></header>

        </div>
        <div  data-spy="scroll"  class="card-body no-padding height-9" >
            <?php
            $staff_idd = $_SESSION['staff_id'];
           
            $message_got = DB::getInstance()->querySample("select * from messaging where (Sender_id='$staff_id'and Receiver_id='$staff_idd') OR  (Sender_id='$staff_idd'and Receiver_id='$staff_id') order by Time");
            $no = 1;
            foreach ($message_got as $message) {
                $class_color = ($message->Sender_id == $staff_idd) ? "out" : "in";
                $member_namez=($message->Sender_id == $staff_idd) ? "You" : $member_name;
                ?>
            
            
                <ul class="chat nice-chat">
                    <li class="<?php echo $class_color ;?>">
                        <img src="images/default.jpg" class="avatar" alt="">
                        <div class="message">
                            <span class="arrow"></span> <a class="name" href="#"><?php echo $member_namez;?> </a>  <span class="datetime">at <?php echo $message->Time; ?></span> <span class="body"> <?php echo $message->Message; ?> </span>
                        </div>
                    </li>
                  
                </ul>
            
            <?php } ?>
          
        </div>


        
        
        

    </div>
    <?php
}?>