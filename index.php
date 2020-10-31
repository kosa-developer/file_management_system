<?php

ob_start();
//error_reporting(E_ALL);
date_default_timezone_set('Africa/Nairobi');
$date_today = date("Y-m-d");
session_start();
include 'core/init.php';
$title = $hospital_main_title . " | ";
$title_survey = $hospital_survey_title . " | ";


$crypt = new Encryption();
//$encoded_page = isset($_GET['page']) ? $_GET['page'] : ('login');
$page = isset($_GET['page']) ? $_GET['page'] : ('login');
//$page = $crypt->decode($encoded_page);
$page_title = str_replace("_", " ", strtoupper($page));
//$page = $encoded_page;
//Delete all the pending drug prescriptions that have not been taken or paid within 12 hrs time
switch ($page) {
    default:
        $page = "login";
        include 'pages/users/login.php';
        break;

    case 'dashboard':
        if (file_exists('pages/' . $page . '.php'))
            include 'pages/' . $page . '.php';
        break;
    case 'department':
        if (file_exists('pages/settings/' . $page . '.php'))
            include 'pages/settings/' . $page . '.php';
        break;

    case 'fileaccess':
        if (file_exists('pages/settings/' . $page . '.php'))
            include 'pages/settings/' . $page . '.php';
        break;



    case 'add_user':
        if (file_exists('pages/users/' . $page . '.php'))
            include 'pages/users/' . $page . '.php';
        break;

    case 'view_users':
        if (file_exists('pages/users/' . $page . '.php'))
            include 'pages/users/' . $page . '.php';
        break;


    case 'add_staff':
        if (file_exists('pages/staff/' . $page . '.php'))
            include 'pages/staff/' . $page . '.php';
        break;



    //Hospital Settings

    case 'logout':
        if (file_exists('pages/users/' . $page . '.php'))
            include 'pages/users/' . $page . '.php';
        break;

    case 'ajax_data':
        if (file_exists('pages/' . $page . '.php'))
            include 'pages/' . $page . '.php';
        break;

    case 'file':
        if (file_exists('pages/file/' . $page . '.php'))
            include 'pages/file/' . $page . '.php';
        break;
    case 'shared_files':
        if (file_exists('pages/file/' . $page . '.php'))
            include 'pages/file/' . $page . '.php';
        break;

    case 'file_page':
        if (file_exists('pages/file/' . $page . '.php'))
            include 'pages/file/' . $page . '.php';
        break;
    //Payments and billing
}
ob_flush();
?>
