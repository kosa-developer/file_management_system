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
?>
