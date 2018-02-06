<?php
session_start();
require_once '../resources/lang/get_lang.php';
require_once '../resources/php/classes/Mysql/MysqlInfo.php';
?>

<?php if ($_POST['type'] == "id_check") { ?>
    <?php $id = $_POST['id']; ?>
    <?php setcookie('len', $id, time() + 9999, '/'); ?>
    <?php if (empty($id)) { ?>
        <div id="id2Msg" style="color:red" class="non-available">
            <input type="hidden" value="0" name="id_available"/>
        </div>
    <?php } else if (!preg_match("/^[a-z0-9_]{5,12}$/", $id)) { ?>
        <div id="pw1Msg" style="color:red" class="non-available">
            <?php echo $lang['MESSAGE']['ID_RULE'] ?>
            <input type="hidden" value="0" name="id_available"/>
        </div>
    <?php } else { ?>
        <?php $db_conn = new \mysql\MysqlInfo('jho_groupware'); ?>
        <?php $sql = "SELECT * FROM member WHERE m_id = '$id'"; ?>
        <?php $result = $db_conn->query($sql); ?>
        <?php /* check if it's exist */ ?>
        <?php if ($result->num_rows > 0) { // Already exist ID ?>
            <div id="id2Msg" style="color:red" class="non-available">
                <?php echo $lang ['MESSAGE']['ALREADY_EXISTS'] ?>
                <input type="hidden" value="0" name="id_available"/>
            </div>
            <?php /* OK */ ?>
        <?php } else { ?>
            <div id="id2Msg" style="color:green" class="available">
                <?php echo $lang ['MESSAGE']['AVAILABLE_ID'] ?>
                <input type="hidden" value="1" name="id_available"/>
            </div>

        <?php } ?>
    <?php } ?>
<?php } ?>

<?php if ($_POST['type'] == "pw_check") { ?>
    <?php if (empty($_POST['pw1'])) { ?>
        <div id="pw1Msg" style="color:red" class="non_available">
            <input type="hidden" value="0" name="pw_length"/></div>
    <?php } else { ?>
        <?php if (!preg_match("/^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-]|.*[0-9]).{6,24}$/", $_POST['pw1'])) { ?>
            <div id="id2Msg" style="color:red" class="non-available">
                <?php echo $lang['MESSAGE']['PW_RULE'] ?>
                <input type="hidden" value="0" name="id_available"/>
            </div>
        <?php } else { ?>
            <div id="pw1Msg" style="color:green" class="available">
                <input type="hidden" value="1" name="pw_length"/></div>
        <?php } ?>
    <?php } ?>
<?php } ?>


<?php
if ($_POST['type'] == "pw_differenceCheck") { // Checking pw for sign up
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
<?php } ?>

<?php if ($_POST['type'] == 'sign_up') { // Sign up
    if (!($_POST['id_available']) or !($_POST['pw_length']) or !($_POST['pw_check'])) {
        $_SESSION['alert'] = "SIGN_UP_FAILED";
    } else {
        $id = $_POST['signUp_id'];
        $pw = $_POST['signUp_pw1'];
        $name = $_POST['signUp_name'];
        $team = $_POST['signUp_team'];
        $mobile = $_POST['mobile'];
        $birthday = $_POST['birthday'];
        $permission = 0;

        $pw = password_hash($pw, PASSWORD_DEFAULT, ["cost" => 12]);

        setcookie('hi', $id . $pw . $name . $team . $mobile . $birthday . $permission, time() + 999, '/');

        $sql = "INSERT INTO `member` (`m_id`, `m_name`, `t_team`, `m_mobile`, `m_birthday`, `m_permission`, `m_pw`) VALUES ('$id', '$name', '$team', '$mobile', '$birthday', '$permission', '$pw')";

        if (!($result = $db_conn->query($sql))) {
            $_SESSION['alert'] = "SIGN_UP_FAILED";
            exit();

        } else {
            $_SESSION['alert'] = "SIGN_UP_SUCCESS";
            header('Location:#login');
            exit();
        }


    }

}
