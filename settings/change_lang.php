<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-23
 * Time: 17:33
 */
session_start();
if (!isset($_SESSION['member_id'])) { // Not logged in
    header('Location: ../login/login.php');
}

if (empty($_COOKIE['_lang'])) {

    require '../resources/lang/get_lang.php';

} else {
    $lang = unserialize($_COOKIE['_lang']);
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
<!--Start of the change_lang page-->
<div data-role="page" id="change_lang" data-theme="c">

    <div data-role="panel" id="change_lang_menu" data-display="reveal">

        <a href="my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <li><a href="#change_lang" data-role="button" data-theme="a"
                   data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a></li>

            <li><a href="my_info_update.php" data-role="button" data-theme="a" data-icon="edit" data-ajax="false">Update
                    my Info.</a></li>
            <li><a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
                   data-ajax="false">Change
                    password</a></li>
        </ul>
        <a data-role="button" href="app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete" data-ajax="false">logout</a>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="transaction_header">
        <a href="#change_lang_menu" data-icon="bars"> menu</a>
        <h1><?php echo $lang['CHANGE_LANG'] ?></h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        <a href="?lang=ko-kr" id="ko-kr" data-theme="a" data-role="button"
           data-icon="user">ko-kr</a>
        <a href="?lang=en-uk" id="en-uk" data-theme="a" data-role="button"
           data-icon="user">en-uk</a>

    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../transaction/transaction_view_personal.php" data-icon="bullets"> transaction</a></li>
                <li><a href="../calendar/calendar.php" data-icon="calendar">calendar</a></li>
                <li>
                    <button data-theme="b" data-icon="gear">settings</button>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#change_lang-->

</body>
</html>