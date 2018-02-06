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

require_once '../resources/lang/get_lang.php';
require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/php/classes/Mysql/MysqlInfo.php';

if (isset($_SESSION['member'])) {
    header('Location: ../transactionHistory/view.php');
    exit();
} else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (empty($_POST['id'])) { // 'id' validation
            $idMsg = $lang['MESSAGE']['ENTER_THE_ID'];
        } else {
            $id = $_POST['id'];
        } // 'id' validation end

        if (empty($_POST['pw'])) { // 'pw' validation
            $pwMsg = $lang['MESSAGE']['ENTER_THE_PW'];
        } else {
            $pw = $_POST["pw"];
        } // 'pw' validation end

        if (isset($id) and isset($pw)) {

            /* Login Check */
            $db_conn = new \mysql\MysqlInfo('jho_groupware');

            $result = $db_conn->query("SELECT * FROM member WHERE m_id='$id'");
            if ($result->num_rows > 0) { // 일치하는 ID 존재
                $row = $result->fetch_assoc();
                if (password_verify($pw, $row['m_pw'])) { // ID & PW 일치

                    /*
                    $_SESSION['member_id'] = $row['m_id'];
                    $_SESSION['member_name'] = $row['m_name'];
                    $_SESSION['member_team'] = $row['t_team'];
                    $_SESSION['member_mobile'] = $row['m_mobile'];
                    $_SESSION['member_birthday'] = $row['m_birthday'];
                    $_SESSION['member_permission'] = $row['m_permission'];
                    */


                    $member = new Member\Member($row['m_id'], $row['m_name'], $row['t_team'], $row['m_mobile'],
                        $row['m_birthday'], $row['m_permission']);
                    $_SESSION['member'] = serialize($member);

                    header('Location: ../transactionHistory/view.php');


                }
            }
            // ID 미존재 혹은 PW 불일치
            $_SESSION['alert'] = "LOGIN_FAILED";
            /* */
        }

    } else {// Not POST
        $_SESSION['message'] = "";

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
    <!-- ...DO NOT EDIT -->

    <script type="text/javascript">
        $(document).ready(function () {
            $('#reset').click(function () {
                $('form').each(function () {
                    this.reset();
                });
            });
        });
    </script>

    <script type="text/javascript">
        // Validation Check for 'Sign Up'
        $('#signUp_form').ready(function () {

            $('#signUp_id').blur(function () {
                let $id = $('#signUp_id').val();
                $.ajax({
                    type: "POST",
                    url: "check_signUp.php",
                    data: {
                        type: "id_check",
                        id: $id
                    },
                    success: function (data) {
                        $('#id2Msg').html(data);
                    },
                    error: function (request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            });

            $('#signUp_pw1').blur(function () {
                let $pw1 = $('#signUp_pw1').val();
                $.ajax({
                    type: "POST",
                    url: "check_signUp.php",
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

            $('#signUp_pw2').blur(function () {
                let $pw1 = $('#signUp_pw1').val();
                let $pw2 = $('#signUp_pw2').val();
                $.ajax({
                    type: "POST",
                    url: "check_signUp.php",
                    data: {type: "pw_differenceCheck", pw1: $pw1, pw2: $pw2},
                    success: function (data) {
                        $('#pw2Msg').html(data);
                    },
                    error: function (request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });
            });

            $('#signUp_button').click(function () {
                let params = $('#signUp_form').serialize();

                $.ajax({
                    type: "POST",
                    url: "check_signUp.php",
                    data: {
                        type: "sign_up",
                        params
                    },
                    contentType: 'charset=UTF-8',
                    dataType: 'html',
                    success: function (data) {

                    },
                    error: function (request, status, error) {
                        alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                    }
                });


            })
        });

    </script>


    <script type="text/javascript">
        $('#login_form').ready(function () {

            $('#login_button').click(function (event) {

                let i_pw;
                let i_id;
                i_id = $('#name_input');
                i_pw = $('#pw_input');

                if (i_id.val() === "") {
                    i_id.focus();
                    $('#nameMsg').val(<?php echo $lang['MESSAGE']['ENTER_THE_NAME']; ?>);
                    event.preventDefault();

                }
                else if (i_pw.val() === "") {
                    i_pw.focus();
                    $('#pwMsg').val(<?php echo $lang['MESSAGE']['ENTER_THE_PW']; ?>);
                    event.preventDefault();

                } else {
                    $('#login_form').submit();
                }


            });
        })
        ;
    </script>

    <title><?php echo $lang['PAGE_TITLE']; ?></title>
</head>

<body>
<!-- Start of the login page -->
<div data-role="page" id="login" data-theme="c">

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <a href="#signUp" data-role="button"><?php echo $lang['SIGN_UP'] ?></a>
        <h1><?php echo $lang['LOGIN']; ?></h1>
        <a data-rel="back" data-icon="back">   <?php echo $lang['BACK_KEY']; ?></a>
    </div><!-- /header -->

    <div data-role="content">

        <?php if (isset($_SESSION['alert'])) { ?>
            <?php echo $lang['ALERT'] . $lang['MESSAGE'][$_SESSION['alert']]; ?>
            <?php unset($_SESSION['alert']); ?>
        <?php } ?>
        <?php if (isset($_SESSION['message'])) { ?>
            <?php echo $_SESSION['message'] ?>
            <?php unset($_SESSION['message']) ?>
        <?php } ?>

        <form id="login_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"
              data-ajax="false">

            <div id="id_form" class="ui-field-contain">
                <label for="id_input"><?php echo $lang['ID']; ?>: </label>

                <input data-clear-btn="true" name="id" id="id_input" value=""
                       placeholder="" type="text" autofocus>
                <div id="idMsg" class="alert"><?php
                    if (isset($idMsg)) {
                        echo "&nbsp;&nbsp;" . $idMsg;
                        unset($idMsg);
                    }
                    ?></div>
            </div>

            <div id="pw_form" class="ui-field-contain">
                <label for="pw_input"><?php echo $lang['PW']; ?>:</label>

                <input data-clear-btn="true" name="pw" id="pw_input" value=""
                       placeholder="<?php echo $lang['PW_EXAMPLE'] ?>"
                       type="password" minlength="4" maxlength="15">
                <div id="pwMsg" class="alert"><?php
                    if (isset($pwMsg)) {
                        echo "&nbsp;&nbsp;" . $pwMsg;
                        unset($pwMsg);
                    } ?></div>
            </div>

            <input data-theme="a" id="login_button" type="submit" data-icon="check"
                   value="<?php echo $lang['LOGIN'] ?>">
        </form><!--/form-->

    </div><!-- /content -->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../settings/info/app_info.php" data-role="button" data-icon="info" data-ajax="false">
                        <?php echo $lang['APP_INFO'] ?></a></li>
                <li><a href="../settings/change/change_lang.php" data-role="button" data-theme="a"
                       data-icon="eye">Language</a></li>
            </ul>
        </div><!--/navbar-->
    </div><!-- /footer -->
</div><!-- /page -->

<!-- Start of the signUp page -->
<div data-role="page" id="signUp" data-theme="c">

    <div data-role="header" data-theme="a" data-position="fixed" data-id="main_header">
        <button id="reset" data-role="button"><?php echo $lang['RESET'] ?></button>
        <h1><?php echo $lang['SIGN_UP'] ?></h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
    </div><!-- /header -->

    <div data-role="content">

        <?php if (isset($_SESSION['alert'])) { ?>
            <?php echo $lang['ALERT'] . $lang['MESSAGE'][$_SESSION['alert']]; ?>
            <?php unset($_SESSION['alert']);
        } ?>


        <form id="signUp_form" method="post" action="sign_up.php" data-ajax="false">

            <div id="signUp_id_form" class="ui-field-contain">
                <label for="signUp_id"><?php echo $lang['ID'] ?>: </label>
                <input name="signUp_id" id="signUp_id" value="" placeholder="ID" type="text" minlength="2"
                       maxlength="25">
                <div id="id2Msg" style="color:red" class="non-available">
                    <input type="hidden" value="0" name="id_available"/></div>
            </div>

            <div id="signUp_pw1_form" class="ui-field-contain">
                <label for="signUp_pw1"><?php echo $lang['PW'] ?>: </label>
                <input name="signUp_pw1" id="signUp_pw1" value="" placeholder="********" type="password" minlength="5"
                       maxlength="25">
                <div id="pw1Msg" style="color:red" class="non_available">
                    <input type="hidden" value="0" name="pw_length"/></div>
            </div>

            <div id="signUp_pw2_form" class="ui-field-contain">
                <label for="signUp_pw2"><?php echo $lang['PW'] . " " . $lang['RE_ENTER'] ?>: </label>
                <input name="signUp_pw2" id="signUp_pw2" value="" placeholder="********" type="password" minlength="5"
                       maxlength="25">
                <div id="pw2Msg" style="color:red" class="non_available">
                    <input type="hidden" value="0" name="pw_same"/></div>
            </div>

            <div id="signUp_name_form" class="ui-field-contain">
                <label for="signUp_name"><?php echo $lang['NAME'] ?>: </label>
                <input name="signUp_name" id="signUp_name" type="text" minlength="1" maxlength="25">
            </div>

            <div id="signUp_team_form" class="ui-field-contain">
                <label for="signUp_team"><?php echo $lang['TEAM'] ?>: </label>
                <input name="signUp_team" id="signUp_team" value="" placeholder="" type="text" minlength="1">
            </div>

            <div id="signUp_mobile_form" class="ui-field-contain">
                <label for="signUp_mobile"><?php echo $lang['MOBILE'] ?>: </label>
                <input name="signUp_mobile" id="signUp_mobile" value="" placeholder="010-1234-5678" type="tel">
            </div>

            <div id="signUp_birthday_form" class="ui-field-contain">
                <label for="signUp_birthday"><?php echo $lang['BIRTHDAY'] ?>: </label>
                <input name="signUp_birthday" id="signUp_birthday" type="date">
            </div>

            <input data-theme="a" id="signUp_button" type="submit" data-icon="check"
                   value="<?php echo $lang['SIGN_UP'] ?>">
        </form><!--/form-->

    </div><!-- /content -->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../settings/info/app_info.php" data-role="button" data-icon="info" data-ajax="false">
                        <?php echo $lang['APP_INFO'] ?></a></li>
                <li><a href="../settings/change/change_lang.php" data-role="button" data-theme="a"
                       data-icon="eye">Language</a></li>
            </ul>
        </div><!--/navbar-->
    </div><!--/footer-->
</div><!-- /page -->


</body>
</html>