<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-07
 * Time: 오후 11:55
 */
session_start();
if (!isset($_SESSION['member_id'])) { // Not logged in
    header('Location: login/login.php');
}
?>

<!DOCTYPE html >
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->

    <title> <?php $_SESSION['member_id'] ?></title>
</head>

<body>
<!--Start of the first page-->
<div data-role="page" id="first" data-theme="c">
    <div data-role="panel" id="first_menu" data-display="reveal">
        <a href="my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
            <?php if ( $_SESSION['member_permission'] >= 2 ) {
                echo '<li><a href="account/account_view(admin).php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="#first">first</a></li>
            <li><a href="#second">second</a></li>
        </ui>
        <a data-role="button" href="info.php" data-icon="info">App Info</a>
        <a data-role="button" href="login/logout.php" data-theme="d" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="#first_menu" data-icon="bars"> menu</a>
        <h1> header</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        content
        <?php echo $_SESSION['member_id']; ?>
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li>
                    <button data-icon="home" data-theme="b">main</button>
                </li>
                <li><a href="calendar.php" data-icon="calendar">calendar</a></li>
                <li><a href="settings.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page#first-->

<!--Start of the second page-->
<div data-role="page" id="second" data-theme="c">
    <div data-role="panel" id="second_menu" data-display="reveal">
        <a href="my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_id']; ?></a>
        <ui data-role="listview" data-theme="a" data-inset="true">
            <li><a href="#first">first</a></li>
            <li><a href="#second">second</a></li>
        </ui>
        <a data-role="button" href="info.php" data-icon="info">App Info</a>
        <a data-role="button" href="login/logout.php" data-theme="d" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="#second_menu" data-icon="bars"> menu</a>
        <h1> header</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">
        content
    </div><!-- /content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><button href="main.php" data-icon="home" data-theme="b"> main</button></li>
                <li><a href="calendar.php" data-icon="calendar">calendar</a></li>
                <li><a href="settings.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer-->
</div><!-- /page-->

</body>
</html>