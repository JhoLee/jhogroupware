<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오후 7:46
 */
session_start();

require_once '../resources/lang/get_lang.php';
require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/head.php';

if (empty($_SESSION['member'])) { // Not logged in
    header('Location: ../login/login.php');
    exit();
} else {

    $member = unserialize($_SESSION['member']);

    $id = $member->getId();
    $name = $member->getName();
    $team = $member->getTeam();
    $mobile = $member->mobile;
    $birthday = $member->birthday;
    $permission = $member->getPermission();
    switch ($permission) {
        case 0:
            $rate = "guest";
            break;
        case 1:
            $rate = "member";
            break;
        case 2:
            $rate = "leader";
            break;
        case 295:
            $rate = "admin";
            break;
        default:
            $rate = "unknown";
            break;


    }


}


?>


<!DOCTYPE html>
<html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->


    <title> <?php $_SESSION['member_name'] ?></title>
</head>

<body>

<!--Start of the my_info_update page-->
<div data-role="page" id="my_info_update" data-theme="c">

    <?php if ($_SESSION['member_permission'] != 295) { ?>
        <img src="../../resources/images/under_construction.png">
    <?php } else { ?>
    <div data-role="panel" id="my_info_update_menu" data-display="reveal">
        <a href="../info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <li><a href="update_my_info.php" data-role="button" data-theme="a" data-icon="edit" data-ajax="false">Update
                    my Info.</a></li>
            <li><a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
                   data-ajax="false">Change
                    password</a></li>
        </ul>
        <a data-role="button" href="../info/app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../../login/logout.php" data-theme="b" data-icon="delete" data-ajax="false">logout</a>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#my_info_update_menu" data-icon="bars"> menu</a>
        <h1>update my info</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        <form id="myInfo_form" method="post" action="update_my_info.php" data-ajax="false">

            <div id="my_name_info" class="ui-field-contain">
                <label for="my_name">name (read only): </label>
                <input name="my_name" id="my_name" value="<?php echo $name . " - " . $rate ?>"
                       placeholder="Input your name"
                       type="text" readonly>
            </div>

            <div id="my_team_info" class="ui-field-contain">
                <label for="my_team">team (read only): </label>
                <input name="my_team" id="my_team" value="<?php echo $team ?>"
                       placeholder="Input your team"
                       type="text" readonly>
            </div>

            <div id="my_mobile_info" class="ui-field-contain">
                <label for="my_mobile">mobile: </label>
                <input name="my_mobile" id="my_mobile" value="<?php echo $mobile ?>"
                       placeholder="<?php echo $mobile ?>" type="tel">
            </div>

            <div id="my_birthday_info" class="ui-field-contain">
                <label for="my_birthday">birthday: </label>
                <input name="my_birthday" id="my_birthday" value="<?php echo $birthday ?>"
                       placeholder="" type="date">
            </div>

            <input data-theme="a" id="edit_button" type="submit" data-icon="check" value="Edit">

        </form><!--/form-->
        <?php } ?>

    </div><!--/content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../../transactionHistory/view.php" data-icon="bullets"> transaction</a></li>
                <li>
                    <a href="../../calendar/index.php" data-icon="calendar">calendar</a>
                </li>
                <li><a href="../index.php" data-theme="b" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->


</div><!--/page#my_info_update-->

</body>

</html>