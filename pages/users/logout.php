<?php

session_start();
unset($_SESSION['department']);
unset($_SESSION['username']);
unset($_SESSION['immergencepassword']);
unset($_SESSION['staff_id']);
unset($_SESSION['staff_names']);
unset($_SESSION['survey_code']);
unset($_SESSION['survey_id']);
unset($_SESSION['user_type']);

$user = new User();
$user->logout();
Redirect::to('index.php?page=login');
?>