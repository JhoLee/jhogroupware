<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 18:08
 */
session_start();
if (!isset($_SESSION['member_id'])) { // Not logged in
    header('Location: ../login/login.php');
} else {

    $my_id = $_SESSION['member_id'];
    $my_name = $_SESSION['member_name'];
    $my_team = $_SESSION['member_team'];
    $my_mobile = $_SESSION['member_mobile'];
    $my_birthday = $_SESSION['member_birthday'];
    switch ($_SESSION['member_permission']) {
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
    <link rel="stylesheet" href="../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->


    <title> <?php $_SESSION['member_name'] ?></title>
</head>

<body>
<!--Start of the my_info page-->
<div data-role="page" id="my_info" data-theme="c">
    <div data-role="panel" id="my_info_menu" data-display="reveal">
        <a href="#" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <li><a href="my_info_update.php" data-role="button" data-theme="a" data-icon="edit" data-ajax="false">Update
                    my Info.</a></li>
            <li><a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
                   data-ajax="false">Change
                    password</a></li>
        </ul>
        <a data-role="button" href="app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete" data-ajax="false">logout</a>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#my_info_menu" data-icon="bars"> menu</a>
        <h1>My Info</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">

        <?php if (isset($_SESSION['message'])) { ?>
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']);
        } ?>


        <table data-role="table" class="ui-responsive">
            <thead>
            <th>name</th>
            <th>team</th>
            <th>mobile</th>
            <th>birthday</th>
            </thead>
            <tobdy>
                <tr>
                    <td><?php echo $my_name . " - " . $my_rate ?></td>
                    <td><?php echo $my_team ?></td>
                    <td><?php echo $my_mobile ?></td>
                    <td><?php echo $my_birthday ?></td>
                </tr>
            </tobdy>
        </table>
        <a href="my_info_update.php" data-theme="a" data-role="button" value="Update my Info." data-icon="edit">Update
            my
            Info.</a>


    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../transaction/transaction_view_personal.php" data-icon="bullets"> transaction</a></li>
                <li>
                    <a href="../calendar/calendar.php" data-icon="calendar">calendar</a>
                </li>
                <li><a href="settings.php" data-theme="b" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->
</div>


</body>
</html>