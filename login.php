<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-10
 * Time: 오전 8:17
 *
 * +) File for login with session
 */
?>

<!DOCTYPE html>
<head>
    <!-- DO NOT EDIT... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT -->

    <title> Login Page </title>
</head>

<body>
<!-- Start of the login page -->
<div data-role="page" id="login" data-theme="c">
    <div data-role="panel" id="loginMenu" data-display="reveal">
        fwejfiowefj
        wefewjoif

    </div><!-- /panel -->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="#menu" data-icon="bars">menu</a>
        <h1>header</h1>
        <a data-rel="back" data-icon="back">back</a>
    </div><!-- /header -->

    <div data-role="content">
        <form method="post" action="login_check.php">
            <div for="id_form" class="ui-field-contain">
                <label for="id_input">ID: </label>
                <input name="member_id" id="id_input" value="" type="text">
            </div>
            <div id="pw_form" class="ui-field-contain">
                <label for="pw_input">PW: </label>
                <input name="member_pw" id="pw_input" value="" type="password">
            </div>
            <input id="submit_button" type="submit" value="submit">
            <input id="login_button" type="button" value="login">
        </form>
    </div><!-- /content -->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="main_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="#first" data-icon="home">main</a></li>
                <li><a href="#second" data-icon="home">main</a></li>
                <li><a href="#" data-icon="home">main</a></li>
            </ul>
        </div>
        <h2>footer</h2>
    </div><!-- /footer -->
</div><!-- /page -->