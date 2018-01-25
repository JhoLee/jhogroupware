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
<!--Start of the settings page-->
<div data-role="page" id="settings" data-theme="c">

    <div data-role="panel" id="settings_menu" data-display="reveal">

        <a href="my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <li><a href="change_lang.php" data-role="button" data-theme="a"
                   data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a></li>

            <li><a href="my_info_update.php" data-role="button" data-theme="a" data-icon="edit" data-ajax="false">
                    <?php echo $lang['UPDATE_MY_INFO'] ?></a></li>
            <li><a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
                   data-ajax="false"><?php echo $lang['CHANGE_PW'] ?></a></li>
        </ul>
        <a data-role="button" href="app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete" data-ajax="false">
            <?php echo $lang['LOGOUT'] ?></a>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="transaction_header">
        <a href="#settings_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['SETTINGS'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">
        <a href="change_lang.php" data-role="button" data-theme="a"
           data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a>
        <a href="my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $lang['VIEW_MY_INFO'] ?></a>
        <a href="my_info_update.php" data-role="button" data-theme="a" data-icon="edit" data-ajax="false">
            <?php echo $lang['UPDATE_MY_INFO'] ?></a>
        <a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
           data-ajax="false"><?php echo $lang['CHANGE_PW'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete"
           data-ajax="false"><?php echo $lang['LOGOUT'] ?></a>
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../transactionHistory/view.php"
                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                <li><a href="../calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>
                <li>
                    <button data-theme="b" data-icon="gear"><?php echo $lang['SETTINGS'] ?></button>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#settings-->

</body>

</html>