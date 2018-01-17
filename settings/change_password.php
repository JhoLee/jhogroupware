<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오후 12:51
 */

session_start();

if (!isset($_SESSION['member_name'])) { // Not logged in
    header('Location: ../login/login.php');
} else {

    $member_name = $_SESSION['member_name'];
    $member_team = $_SESSION['member_team'];

    if (!isset($_POST['current_pw'])) {
    } else {

        $member_pw = $_POST["current_pw"];

        if (!isset($_POST['change_pw1']) || !isset($_POST['change_pw2'])) {
            $_SESSION['message'] = '[ERROR] Please enter the password to change';
        } else {
            if ($_POST['change_pw1'] != $_POST['change_pw2']) {
                $_SESSION['message'] = '[ERROR] password not same error';
            } else {


                include_once '../jho.php';


                $result = $db_conn->query("SELECT * FROM member WHERE m_name='$member_name'");
                if ($result->num_rows <= 0) {

                    $_SESSION['message'] = '[ERROR] unknown error...';
                } else { // 일치하는 ID 존재
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if (!password_verify($member_pw, $row['m_pw'])) {

                        $_SESSION['message'] = '[ERROR] wrong password...';
                    } else { // ID & PW 일치

                        $change_pw = password_hash($_POST['change_pw1'], PASSWORD_DEFAULT, ["cost" => 12]);

                        $sql = "UPDATE member SET m_pw = '$change_pw' WHERE m_name = '$member_name' AND t_team = '$member_team'";

                        $db_conn->query($sql);

                        $_SESSION['message'] = '[system] password changed! ';

                    }
                }
            }
        }

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


    <script type="text/javascript">
        $('#change_password').ready(function () {

            $('#change_pw_button').click(function (event) {

                var current_pw = $('#current_pw_input').val();
                var pw1 = $('#change_pw1_input').val();
                var pw2 = $('#change_pw2_input').val();

                if (current_pw == "") {
                    $('#current_pw_input').focus();
                    event.preventDefault();

                } else if (pw1 == "") {
                    $('#change_pw1_input').focus();
                    event.preventDefault();

                } else if (pw1 != pw2) {
                    $('#change_pw2_input').focus();
                    event.preventDefault();

                } else {
                    $('#change_password_form').submit();
                }


            });
        });
    </script>


    <title> <?php $_SESSION['member_name'] ?></title>
</head>

<body>

<!--Start of the change_password page-->
<div data-role="page" id="change_password" data-theme="c">
    <div data-role="panel" id="change_password_menu" data-display="reveal">
        <a href="#my_info" data-theme="a" data-role="button"
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
        <a href="#change_password_menu" data-icon="bars"> menu</a>
        <h1>Change Password</h1>
        <a data-rel="back" data-icon="back"> back</a>
    </div><!-- /header-->

    <div data-role="content">

        <?php if (isset($_SESSION['message'])) { ?>
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']);
        } ?>


        <form id="change_password_form" method="post" action="change_password.php">

            <div id="current_pw" class="ui-field-contain">
                <label for="current_pw_input">current pw: </label>
                <input name="current_pw" id="current_pw_input" value="" placeholder="Enter your current password"
                       type="password">
                <br>
            </div>

            <div id="change_pw1" class="ui-field-contain">
                <!-- 유효성 검사 추가해야 함-->
                <label for="change_pw1_input">enter pw: </label>
                <input name="change_pw1" id="change_pw1_input" class="pw_change" value=""
                       placeholder="At least 5 characters"
                       type="password">
            </div>
            <div id="change_pw2" class="ui-field-contain">

                <label for="change_pw2_input">re-enter pw: </label>
                <input name="change_pw2" id="change_pw2_input" class="pw_change" value=""
                       placeholder="re-enter the same characters"
                       type="password">


            </div>


            <input data-theme="a" id="change_pw_button" type="submit" data-icon="check" value="change">

        </form>


    </div><!--/content-->

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


</div><!--/page#change_password-->

</body>
</html>