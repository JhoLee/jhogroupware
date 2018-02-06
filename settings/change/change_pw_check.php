<?php
session_start();
require_once '../../resources/lang/get_lang.php';
require_once '../../resources/php/classes/Member/Member.php';
require_once '../../resources/php/classes/Mysql/MysqlInfo.php';
$db_conn = new \mysql\MysqlInfo('jho_groupware');
?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>


    <?php if ($_POST['type'] == "pw_check") { ?>
        <?php if (empty($_POST['pw1'])) { ?>
            <div id="pw1Msg" style="color:red" class="non_available">
                <input type="hidden" value="0" name="pw_length"/></div>
        <?php } else { ?>
            <?php if (!preg_match("/^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-]|.*[0-9]).{6,24}$/", $_POST['pw1'])) { ?>
                <div id="pw1Msg" style="color:red" class="non-available">
                    <?php echo $lang['MESSAGE']['PW_RULE'] ?>
                    <input type="hidden" value="0" name="pw_length"/>
                </div>
            <?php } else { ?>
                <div id="pw1Msg" style="color:green" class="available">O
                    <input type="hidden" value="1" name="pw_length"/></div>
            <?php } ?>
        <?php } ?>
    <?php } else if ($_POST['type'] == "pw_differenceCheck") { // Checking pw for sign up
        if (empty($_POST['pw1']) or empty($_POST['pw2'])) { ?>
            <div id="pw2Msg" style="color:red" class="non_available">
                <input type="hidden" value="0" name="pw_same"/></div>
        <?php } else { // All variables set
            if ($_POST['pw1'] != $_POST['pw2']) { ?>
                <div id="pw2Msg" style="color:red" class="non_available"><?php echo $lang['NOT_SAME'] ?>
                    <input type="hidden" value="0" name="pw_same"/></div>

            <?php } else { // Same  ?>
                <div id="pw2Msg" style="color:green" class="available"><?php echo $lang['SAME'] ?>
                    <input type="hidden" value="1" name="pw_same"/></div>

            <?php } ?>
        <?php } ?>
    <?php }
}
