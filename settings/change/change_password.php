<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-17
 * Time: 오후 12:51
 */

session_start();

require_once '../../resources/lang/get_lang.php';
require_once '../../resources/php/classes/Member/Member.php';
require_once '../../resources/php/classes/Mysql/MysqlInfo.php';

$db_conn = new \mysql\MysqlInfo('jho_groupware');

if (empty($_SESSION['member'])) { // Not logged in
    header('Location: ../../login/login.php');
    exit();
} else {

    $member = unserialize($_SESSION['member']);
    $id = $member->getId();
    $name = $member->getName();
    $team = $member->getTeam();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['pw_length']) or empty($_POST['pw_same'])) {
        $_SESSION['alert'] = 'ERROR';

    } else {

        $current_pw = $_POST['current_pw'];
        $change_pw = $_POST['change_pw1'];

        $result = $db_conn->query("SELECT * FROM member WHERE m_id='$id'");
        if ($result->num_rows <= 0) {

            $_SESSION['alert'] = 'UNKNOWN_ERROR';
        } else { // 일치하는 ID 존재
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (!password_verify($current_pw, $row['m_pw'])) {

                $_SESSION['alert'] = 'PW_INCORRECT';
            } else { // ID & PW 일치

                $change_pw = password_hash($change_pw, PASSWORD_DEFAULT, ["cost" => 12]);

                $sql = "UPDATE member SET m_pw = '$change_pw' WHERE m_name = '$name' AND t_team = '$team'";

                $db_conn->query($sql);

                $_SESSION['alert'] = 'PW_CHANGE_SUCCESS';


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
    <link rel="stylesheet" href="../../resources/css/jquery.mobile-1.4.5.min.css">
    <script type="text/javascript" src="../../resources/js/jquery.js"></script>
    <script type="text/javascript" src="../../resources/js/jquery.mobile-1.4.5.min.js"></script>
    <!-- ...DO NOT EDIT-->


    <script type="text/javascript">
        // Validation Check for 'Sign Up'
        $('document').ready(function () {

            $('#change_pw1').blur(function () {
                let $pw1 = $('#change_pw1').val();
                $.ajax({
                    type: "POST",
                    url: "change_pw_check.php",
                    data: {
                        type: "pw_check",
                        pw1: $pw1
                    },
                    success: function (data) {
                        $('#pw1Msg').html(data);
                    },
                    error: function (request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            });

            $('#change_pw2').blur(function () {
                let $pw1 = $('#change_pw1').val();
                let $pw2 = $('#change_pw2').val();
                $.ajax({
                    type: "POST",
                    url: "change_pw_check.php",
                    data: {type: "pw_differenceCheck", pw1: $pw1, pw2: $pw2},
                    success: function (data) {
                        $('#pw2Msg').html(data);
                    },
                    error: function (request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            });


        });

    </script>


    <title> <?php $lang['PAGE_TITLE'] ?></title>
</head>

<body>

<!--Start of the change_password page-->
<div data-role="page" id="change_password" data-theme="c">
    <div data-role="panel" id="change_password_menu" data-display="reveal">
        <a href="../info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $name ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <li><a href="update_my_info.php" data-role="button" data-theme="a" data-icon="edit"
                   data-ajax="false"><?php echo $lang['UPDATE_MY_INFO'] ?></a></li>
            <li><a href="change_password.php" data-theme="a" data-role="button" data-icon="recycle"
                   data-ajax="false"><?php echo $lang['CHANGE_PW'] ?></a></li>
        </ul>
        <a data-role="button" href="../info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../../login/logout.php" data-theme="b" data-icon="delete"
           data-ajax="false"><?php echo $lang['LOGOUT'] ?></a>
    </div><!--/panel-->

    <div data-role="header" data-theme="a" data-position="fixed" data-id="my_info_header">
        <a href="#change_password_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['CHANGE_PW'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header-->

    <div data-role="content">

        <?php if (isset($_SESSION['alert'])) { ?>
            <?php echo $lang['ALERT'] . $lang['MESSAGE'][$_SESSION['alert']]; ?>
            <?php unset($_SESSION['alert']);
        } ?>


        <form id="change_password_form" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" data-ajxa="false">

            <div id="current_pw_form" class="ui-field-contain">
                <label for="current_pw"><?php echo $lang['CURRENT_PW'] ?>: </label>
                <input name="current_pw" id="current_pw" value="" placeholder="<?php echo $lang['PW_EXAMPLE'] ?>"
                       type="password" minlength="5" maxlength="22">

            </div>

            <div id="change_pw1_form" class="ui-field-contain">
                <label for="change_pw1"><?php echo $lang['CHANGE_TO'] ?>:</label>
                <input name="change_pw1" id="change_pw1" class="pw_change" value=""
                       placeholder="<?php echo $lang['AT_LEAST_5CHARACTERS'] ?>"
                       type="password" minlength="5" maxlength="22">
                <div id="pw1Msg" style="color:red" class="non_available">
                    <input type="hidden" value="0" name="pw_length"/></div>
            </div>

            <div id="change_pw2_form" class="ui-field-contain">

                <label for="change_pw2"><?php echo $lang['RE_ENTER'] ?>:</label>
                <input name="change_pw2" id="change_pw2" class="pw_change" value=""
                       placeholder="<?php echo $lang['RE_ENTER'] ?>"
                       type="password" minlength="5" maxlength="22">
                <div id="pw2Msg" style="color:red" class="non_available">
                    <input type="hidden" value="0" name="pw_length"/></div>
            </div>

            <input data-theme="a" id="change_pw_button" type="submit" data-icon="check"
                   value="<?php echo $lang['CHANGE'] ?>">

        </form>


    </div><!--/content-->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../../transactionHistory/view.php"
                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                <li><a href="../../contacts/index.php" data-icon="user"><?php echo $lang['CONTACTS'] ?></a></li>
                <li><a href="../../calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>
                <li>
                    <button data-theme="b" data-icon="gear"><?php echo $lang['SETTINGS'] ?></button>
                </li>
            </ul>
        </div>
    </div><!-- /footer-->


</div><!--/page#change_password-->

</body>
</html>