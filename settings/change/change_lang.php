<?php
/**
 * Created by PhpStorm.
 * User: Jho
 * Date: 2018-01-23
 * Time: 17:33
 */
session_start();

require_once '../../resources/lang/get_lang.php';
require_once '../../resources/php/classes/Member/Member.php';


if (empty($_SESSION['member'])) { // Not logged in
    $_SESSION['member'] = 'guest';
} else {
    $member = unserialize($_SESSION['member']);
    $name = $member->getName();
}
require_once '../settings_head.php';

?>
    <body>
    <!--Start of the change_lang page-->
    <div data-role="page" id="change_lang" data-theme="c">

        <div data-role="panel" id="change_lang_menu" data-display="reveal">

            <?php if ($_SESSION['member'] == 'guest') { ?>

                <a href="change_lang.php" data-role="button" data-theme="a"
                   data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a>
                <a data-role="button" href="../info/app_info.php" data-theme="a"
                   data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
                <a data-role="button" href="../../login/login.php" data-theme="b" data-icon="check" data-ajax="false">
                    <?php echo $lang['LOGIN'] ?></a>
            <?php } else {
                include_once '../settings_panel.php';
            } ?>

        </div><!--/panel-->

        <div data-role="header" data-theme="a" data-position="fixed" data-id="transaction_header">
            <a href="#change_lang_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
            <h1><?php echo $lang['CHANGE_LANG'] ?></h1>
            <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        </div><!-- /header-->

        <div data-role="content">

            <?php foreach ($json as $_language) { ?>

                <?php $language = $_language['LANGUAGE'] ?>

                <a href="?lang=<?php echo $language ?>" id="<?php echo $language ?>" data-theme="a" data-role="button"
                   data-icon="user"><?php echo $language ?></a>
            <?php } ?>
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
                                       dataicon="user"></a><?php echo $lang['CONTACTS'] ?></li>
                                <li>
                                    <a href="../../calendar/index.php"
                                       data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a>
                                </li>
                                <li><a href="../index.php" data-theme="b"
                                       data-icon="gear"><?php echo $lang['SETTINGS'] ?></a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
            </div><!-- /footer-->
        </div><!-- /page#change_lang-->

    </body>
    </html>

<?php if ($_SESSION['member'] == 'guest') unset($_SESSION['member']) ?>