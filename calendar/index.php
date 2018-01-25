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
}

require_once '../resources/lang/get_lang.php';

require_once '../resources/header.php';
?>

<body>
<!--Start of the calendar page-->
<div data-role="page" id="calendar" data-theme="c">
    <div data-role="panel" id="menu" data-display="reveal">
        <a href="../settings/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
        </ui>
        <a data-role="button" href="../settings/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-icon="delete" data-theme="b"
           data-ajax="false"><?php echo $lang['LOGOUT'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="calendar_header">
        <a href="#menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['CALENDAR'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">
        <img src="../resources/images/under_construction.png" width="100%">
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="calendar_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../transactionHistory/view.php"
                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                <li>
                    <button data-theme="b" href="calendar.php"
                            data-icon="calendar"><?php echo $lang['CALENDAR'] ?></button>
                </li>
                <li><a href="../settings/index.php" data-icon="gear"><?php echo $lang['SETTINGS'] ?></a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->