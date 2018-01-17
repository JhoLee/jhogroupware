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
?>

<!DOCTYPE html >
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->

    <title> <?php $_SESSION['member_id'] ?></title>
</head>

<body>
<!--Start of the my_info page-->
<div data-role="page" id="my_info" data-theme="c">
    <div data-role="panel" id="my_info_menu" data-display="reveal">
        <a href=".php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
        </ul>
        <a data-role="button" href="o.php" data-icon="info">App Info</a>
        <a data-role="button" href="../../login/logout.php" data-theme="b" data-icon="delete" data-ajax="false">logout</a>

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#menu" data-icon="bars"> menu</a>
        <h1> header</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        <img src="../../resources/images/under_construction.png" width="100%">
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../../transaction/transaction_view_personal.php" data-icon="bullets"> transaction</a></li>
                <li>
                    <a href="../../calendar/calendar.php" data-icon="calendar">calendar</a>
                </li>
                <li><a href="../settings.php" data-theme="b" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->