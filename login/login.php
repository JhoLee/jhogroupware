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
    header('Location: ../index.php');
}

require_once '../resources/lang/get_lang.php';
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
            <?php unset($_SESSION['alert']);
        } ?>

        <form id="login_form" method="post" action="../index.php" data-ajax="false">
            <div for="team_form" class="ui-field-contain">
                <label for="team_input"><?php echo $lang['TEAM']; ?>: </label>
                <input data-clear-btn="true" name="member_team" id="team_input" value=""
                       placeholder="<?php echo $lang['TEAM_EXAMPLE'] ?>" type="text">
            </div>
            <div for="id_form" class="ui-field-contain">
                <label for="name_input"><?php echo $lang['NAME']; ?>: </label>
                <input data-clear-btn="true" name="member_name" id="name_input" value=""
                       placeholder="<?php echo $lang['NAME_EXAMPLE'] ?>" type="text">
            </div>
            <div id="pw_form" class="ui-field-contain">
                <label for="pw_input"><?php echo $lang['PW']; ?>:</label>
                <input data-clear-btn="true" name="member_pw" id="pw_input" value=""
                       placeholder="<?php echo $lang['PW_EXAMPLE'] ?>"
                       type="password">
            </div>
            <input data-theme="a" id="login_button" type="submit" data-icon="check"
                   value="<?php echo $lang['LOGIN'] ?>">
        </form><!--/form-->

    </div><!-- /content -->

    <div data-role="footer" id="foot" data-position="fixed" data-theme="a">
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li><a href="../settings/app_info.php" data-role="button" data-icon="info">
                        <?php echo $lang['APP_INFO'] ?></a></li>
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
            <img src="../resources/images/under_construction.png" width="100%">
        <?php } else { ?>

            <form id="sign_up_form" method="post" action="sign_up.php" data-ajax="false">
                <div id="id_form_login" class="ui-field-contain">
                    <label for="sign_up_name_input">ID: </label>
                    <input name="sign_up_name" id="sign_up_name_input" value="" placeholder="Name" type="text">
                </div>
                <div id="pw_form_login" class="ui-field-contain">
                    <label for="sign_up_pw_inputt">PW: </label>
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