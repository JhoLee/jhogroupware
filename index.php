<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-07
 * Time: 오후 11:55
 */


session_start();
require_once 'resources/php/classes/Member/Member.php';

if (empty($_SESSION['member'])) { // Not logged in

    header('Location: ../login/login.php');

} else {

    $member = unserialize($_SESSION['member']);
    $team = $member->getTeam();
    $name = $member->getName();
    $permission = $member->getPermission();


}

require_once 'resources/head.php';

?>

<body>
<!--Start of the index page-->
<div data-role="page" id="index" data-theme="c">
    <div data-role="panel" id="index_menu" data-display="reveal">
        <a href="settings/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
        </ul>
        <a data-role="button" href="settings/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT'] ?></a>
    </div><!--/panel-->


    <div data-role="header" data-theme="a" data-position="fixed">
        <a href="#index_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['INDEX'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">
        <?php header('Location: transactionHistory/view.php'); ?>
        <img src="resources/images/under_construction.png">
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="transaction_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="transactionHistory/view.php"
                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                <li><a href="calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>
                <li>
                    <a href="settings/index.php" data-icon="gear"><?php echo $lang['SETTINGS'] ?></a>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#index-->