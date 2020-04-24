<?php
if (isset($_GET['code'])) {
    if (isset($_GET['code'])) {
     $staff_code = $_GET['code'];
    $staffCheck = "SELECT staff.Image,CONCAT(staff.Title,'. ',staff.Staff_Name) AS Full_Name FROM survey_codes,staff WHERE survey_codes.Staff_Id=staff.Staff_Id AND survey_codes.Code='$staff_code' LIMIT 1";
    $staff_list = DB::getInstance()->query($staffCheck);
    $staff_id = DB::getInstance()->getName("survey_codes", $staff_code, "Staff_Id", "Code");
    if ($staff_id == "NA" || $staff_id == "N/A" || $staff_id == "") {
        $staff_id = "";
    }
    $profile_picture = DB::getInstance()->displayTableColumnValue($staffCheck, "Image");
    $names = DB::getInstance()->displayTableColumnValue($staffCheck, "Full_Name");

    if (empty($profile_picture)) {
        $profile_picture = 'person.jpg';
    } else {
        $profile_picture = $profile_picture;
    }

   
}$previous_page = $_SESSION["PREVIOUS_URL"];
    
}
?>


<div class="page-header navbar navbar-fixed-top" onload="openModel()">
    <div class="page-header-inner ">
        <!-- logo start -->
        <div class="page-logo">
            <a href="#">
                <span class="logo-icon fa fa-hospital-o fa-rotate-left"></span>
                <span class="logo-default" ><?php echo $HOSPITAL_NAME_ABREV?></span> </a>
        </div>
        <!-- logo end -->
        <ul class="nav navbar-nav navbar-left in">
            <li><a href="javascript:void(0)" class="menu-toggler sidebar-toggler"><i class="icon-menu"></i></a></li>
        </ul>
        <!-- start mobile menu -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- end mobile menu -->
        <!-- start header menu -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
           <!-- start notification dropdown -->
                
                <!-- end notification dropdown -->
                <!-- start manage user dropdown -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle " src="..\staff_image/<?php echo $profile_picture ?>" />
                        <span class="username username-hide-on-mobile"><?php echo $names; ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                  
                </li>
            </ul>
        </div>
    </div>
</div>


<script>
    function compare_password(confirm) {
        if (confirm !== "") {
            var old_password = document.getElementById("new_password").value;
            if (confirm === old_password) {
                document.getElementById("edit_my_account_button").disabled = false;
                document.getElementById("check_password").style.display = "none";
            } else {
                document.getElementById("edit_my_account_button").disabled = true;
                document.getElementById("check_password").style.display = "block";
            }

        } else {
            document.getElementById("edit_my_account_button").disabled = true;
            document.getElementById("check_password").style.display = "block";
        }
    }
    function emptyConfirm() {
        document.getElementById("confirm_password").value = "";
        document.getElementById("edit_my_account_button").disabled = true;
    }
</script>