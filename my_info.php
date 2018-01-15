<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-15
 * Time: 오전 9:26
 */

session_start();
if (!isset($_SESSION['member_id'])) { // Not logged in
    header('Location: login.php');
}
?>

<!DOCTYPE html >
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="resources/js/jquery.js"></script>
    <script type="text/javascript" src="resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->

    <title>my_info</title>
</head>

<body>
<!--Start of the my_info page-->
<div data-role="page" id="my_info" data-theme="c">
    <div data-role="panel" id="myInfo_menu" data-display="reveal">
        <a href="my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
        </ui>
        <a data-role="button" href="login/logout.php" data-theme="d" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="#myInfo_menu" data-icon="bars"> menu</a>
        <h1>My Info</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        content
        <?php echo $_SESSION['member_id']; ?>
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="main_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="main.php" data-icon="home"> main</a></li>
                <li>
                    <button data-theme="b"  href="calendar.php" data-icon="calendar">calendar</button>
                </li>
                <li><a href="settings.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->