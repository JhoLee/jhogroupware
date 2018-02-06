<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-13
 * Time: 18:08
 */
session_start();

require_once '../../resources/lang/get_lang.php';
require_once '../../resources/php/classes/Member/Member.php';


if (!isset($_SESSION['member'])) { // Not logged in
    $_SESSION['member'] = 'guest';
} else {

    $member = unserialize($_SESSION['member']);
    $team = $member->getTeam();
    $name = $member->getName();
    $permission = $member->getPermission();
}

require_once '../settings_head.php';
?>


    <body>
    <!--Start of the app_info page-->
    <div data-role="page" id="app_info" data-theme="c">

        <div data-role="panel" id="app_info_menu" data-display="reveal">
            <?php if ($_SESSION['member'] == 'guest') { ?>
                <a href="../change/change_lang.php" data-role="button" data-theme="a"
                   data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a>
                <a data-role="button" href="app_info.php" data-theme="a"
                   data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
                <a data-role="button" href="../../login/login.php" data-theme="b" data-icon="check" data-ajax="false">
                    <?php echo $lang['GO_SIGN_IN'] ?></a>
            <?php } else {
                include_once '../settings_panel.php';
            } ?>
        </div><!--/panel-->

        <div data-role="header" data-theme="a" data-position="fixed" data-id="transaction_header">
            <a href="#app_info_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
            <h1><?php echo $lang['APP_INFO'] ?></h1>
            <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        </div><!-- /header-->

        <div data-role="content">

            <a href="https://open.kakao.com/o/sZ4VgyF" data-role="button" data-theme="a" data-icon="comment"
               data-ajax="false"><?php echo $lang['CONTACT_ADMIN'] ?><br>(<?php echo $lang['KAKAOTALK'] ?>)</a>
            <a href="mailto:jooho_lee@outlook.kr" data-role="button" data-theme="a" data-icon="mail"
               data-ajax="false"><?php echo $lang['CONTACT_ADMIN'] ?><br>(<?php echo $lang['E_MAIL'] ?>)</a>
            <a href="../change/change_lang.php" data-role="button" data-theme="a"
               data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a>
        </div><!-- /content-->

        <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-id="settings_footer">
            <?php if ($_SESSION['member'] == 'guest') { ?>
            <div data-role="navbar" data-position="fixed">
                <ul>

                    <li><a data-role="button" href="../../login/login.php" data-icon="check"
                           data-ajax="false">
                            <?php echo $lang['GO_SIGN_IN'] ?></a></li>
                    <?php } else { ?>
                        <div data-role="navbar" data-position="fixed">
                            <ul>
                                <li><a href="../../transactionHistory/view.php"
                                       data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></a></li>
                                <li><a href="../../contacts/index.php"
                                       data-icon="user"><?php echo $lang['CONTACTS'] ?></a></li>
                                <li><a href="../../calendar/index.php"
                                       data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>
                                <li>
                                    <button data-theme="b" data-icon="gear"><?php echo $lang['SETTINGS'] ?></button>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
            </div><!-- /footer-->
        </div><!-- /page#APP_INFO-->
    </body>

    </html>
<?php if ($_SESSION['member'] == 'guest') unset($_SESSION['member']) ?>