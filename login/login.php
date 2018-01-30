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
error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once '../resources/lang/get_lang.php';
require_once '../resources/php/classes/Member/Member.php';

if (isset($_SESSION['member'])) {
    header('Location: ../transactionHistory/view.php');
    exit();
} else {
    $_SESSION['message'] = " ";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['team'])) { // 'team' validation
            $teamMsg = $lang['MESSAGE']['ENTER_THE_TEAM'];
        } else {
            $team = $_POST['team'];

        } // 'team' validation end


        if (empty($_POST['name'])) { // 'name' validation
            $nameMsg = $lang['MESSAGE']['ENTER_THE_NAME'];
        } else {
            $name = $_POST['name'];
        } // 'name' validation end

        if (empty($_POST['pw'])) { // 'pw' validation
            $pwMsg = $lang['MESSAGE']['ENTER_THE_PW'];
        } else {
            $pw = $_POST["pw"];
        } // 'pw' validation end

        /* Login Check */
        require_once '../jho.php';

        $result = $db_conn->query("SELECT * FROM member WHERE m_name='$name' AND t_team='$team'");
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


            }
        }
        // ID 미존재 혹은 PW 불일치
        $_SESSION['alert'] = "LOGIN_FAILED";
        /* */

    } else {// Not POST
        $_SESSION['message'] = "not post";

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
        /*
        $('#login_form').ready(function () {

            $('#login_button').click(function (event) {

                var i_team = $('#team_input').val();
                var i_name = $('#name_input').val();
                var i_pw = $('#pw_input').val();

                if (i_team == "") {
                    $('#team_input').focus();
                    event.preventDefault();

                } else if (i_name == "") {
                    $('#name_input').focus();
                    event.preventDefault();

                } else if (i_pw == "") {
                    $('#pw_input').focus();
                    event.preventDefault();

                } else {
                    $('#login_form').submit();
                }


            });
        });
        */
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
            <div id="team_form" class="ui-field-contain">
                <label for="team_input"><?php echo $lang['TEAM']; ?>2: </label>

                <input data-clear-btn="true" name="team" id="team_input" value=""
                       placeholder="<?php echo $lang['TEAM_EXAMPLE'] ?>" type="text">
                <div class="alert"><?php
                    if (isset($teamMsg)) {
                        echo "&nbsp;&nbsp;" . $teamMsg;
                        unset($teamMsg);
                    } ?></div>
            </div>

            <div id="id_form" class="ui-field-contain">
                <label for="name_input"><?php echo $lang['NAME']; ?>: </label>

                <input data-clear-btn="true" name="name" id="name_input" value=""
                       placeholder="<?php echo $lang['NAME_EXAMPLE'] ?>" type="text">
                <div class="alert"><?php
                    if (isset($nameMsg)) {
                        echo "&nbsp;&nbsp;" . $nameMsg;
                        unset($nameMsg);
                    }
                    ?></div>
            </div>

            <div id="pw_form" class="ui-field-contain">
                <label for="pw_input"><?php echo $lang['PW']; ?>:</label>

                <input data-clear-btn="true" name="pw" id="pw_input" value=""
                       placeholder="<?php echo $lang['PW_EXAMPLE'] ?>"
                       type="password" minlength="4" maxlength="15">
                <div class="alert"><?php
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
                <li><a href="../settings/app_info.php" data-role="button" data-icon="info" data-ajax="false">
                        <?php echo $lang['APP_INFO'] ?></a></li>
                <li><a href="../settings/change_lang.php" data-role="button" data-theme="a"
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

        <?php if (true) { ?>
            <img src="../resources/images/under_construction.png">
        <?php } else { ?>

            <form id="sign_up_form" method="post" action="sign_up.php" data-ajax="false">
                <div id="id_form_login" class="ui-field-contain">
                    <label for="sign_up_name_input">ID: </label>
                    <input name="sign_up_name" id="sign_up_name_input" value="" placeholder="Name" type="text">
                </div>
                <div id="pw_form_login" class="ui-field-contain">
                    <label for="sign_up_pw_input">PW: </label>
                    <input name="sign_up_pw" id="sign_up_pw_input" value="" placeholder="********" type="password">
                </div>
                <input data-theme="a" id="login_button" type="submit" data-icon="check" value="sign up">
            </form><!--/form-->

        <?php } ?>

    </div><!-- /content -->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="main_footer">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="https://open.kakao.com/o/sZ4VgyF" data-icon="comment" data-ajax="false">contact admin<br>(KakaoTalk)</a>
                </li>
                <li><a href="mailto:jooho_lee@outlook.kr" data-icon="mail" data-ajax="false">contact
                        admin<br>(e-mail)</a>
                </li>

            </ul>
        </div>
        <a class="ui-bar" href="../settings/app_info.php" data-icon="info"><h6><?php echo $lang['APP_INFO'] ?></h6></a>
    </div><!-- /footer -->


</div><!-- /page -->


</body>
</html>