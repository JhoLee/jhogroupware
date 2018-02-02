<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 18:08
 */
session_start();

require_once '../../resources/lang/get_lang.php';
require_once '../../resources/php/classes/Member/Member.php';

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
            $my_rate = "guest";
            break;
        case 1:
            $my_rate = "member";
            break;
        case 2:
            $my_rate = "leader";
            break;
        case 295:
            $my_rate = "admin";
            break;
        default:
            $my_rate = "unknown";
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


    <title> <?php echo $lang['PAGE_TITLE'] ?></title>
</head>

<body>
<!--Start of the my_info page-->
<div data-role="page" id="my_info" data-theme="c">
    <div data-role="panel" id="my_info_menu" data-display="reveal">
        <?php include_once '../settings_panel.php' ?>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#my_info_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['MY_INFO'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">

        <?php if (isset($_SESSION['message'])) { ?>
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']);
        } ?>


        <table data-role="table" class="ui-responsive">
            <thead>
            <th><?php echo $lang['NAME'] ?></th>
            <th><?php echo $lang['TEAM'] ?></th>
            <th><?php echo $lang['MOBILE'] ?></th>
            <th><?php echo $lang['BIRTHDAY'] ?></th>
            </thead>
            <tobdy>
                <tr>
                    <td><?php echo $name . " - " . $my_rate ?></td>
                    <td><?php echo $team ?></td>
                    <td><?php echo $mobile ?></td>
                    <td><?php echo $birthday ?></td>
                </tr>
            </tobdy>
        </table>
        <a href="../change/update_info.php?user_id=<?php echo $member->getId() ?>" data-theme="a" data-role="button"
           value="Update my Info."
           data-icon="edit" data-ajax="false"><?php echo $lang['UPDATE_MY_INFO'] ?></a>


    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../../transactionHistory" data-icon="bullets"
                       data-ajax="false"><?php echo $lang['TRANSACTION'] ?></a>
                </li>
                <li><a href="../../contacts/index.php" data-icon="user"></a><?php echo $lang['CONTACTS'] ?></li>
                <li>
                    <a href="../../calendar/index.php" data-icon="calendar"
                       data-ajax="false"><?php echo $lang['CALENDAR'] ?></a>
                </li>
                <li><a href="../index.php" data-theme="b" data-icon="gear"
                       data-ajax="false"><?php echo $lang['SETTINGS'] ?></a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->
</div>


</body>
</html>