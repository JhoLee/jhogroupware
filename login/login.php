<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-10
 * Time: 오전 8:17
 *
 * +) File for login with session
 */
session_start();
if (isset($_SESSION['member_id'])) {
    header('Location: ../main.php');
}


?>
<!DOCTYPE html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT -->


    <title> Login Page </title>
</head>

<body>
<!-- Start of the login page -->
<div data-role="page" id="login" data-theme="c">

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="sign_up.php" data-role="button" data-ajax="false">sign up</a>
        <h1>header</h1>
        <a data-rel="back" data-icon="back">back</a>
    </div><!-- /header -->

    <div data-role="content">

        <?php if (isset($_SESSION['message'])) { ?>
             <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']);
        } ?>

        <form method="post" action="login_check.php" data-ajax="false">
            <div for="id_form" class="ui-field-contain">
                <label for="id_input">ID: </label>
                <input name="member_id" id="id_input" value="" type="text">
            </div>
            <div id="pw_form" class="ui-field-contain">
                <label for="pw_input">PW: </label>
                <input name="member_pw" id="pw_input" value="" type="password">
            </div>
            <input id="login_button" type="submit" value="login">
        </form><!--/form-->

    </div><!-- /content -->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="main_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="sms:+82-10-3310-3784" data-icon="mail" data-ajax="false">contact admin<br>(SMS)</a></li>
                <li><a href="https://open.kakao.com/o/sZ4VgyF" data-icon="comment" data-ajax="false">contact admin<br>(KakaoTalk)</a>
                </li>
            </ul>
        </div>
        <h2>footer</h2>
    </div><!-- /footer -->
</div><!-- /page -->