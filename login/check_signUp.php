<?php
session_start();
require_once '../resources/lang/get_lang.php';
require_once '../resources/php/classes/Mysql/MysqlInfo.php';
?>
<?php if ($_POST['type'] == "id_check") { ?>
    <?php $id = $_POST['id']; ?>
    <?php if (empty($id)) { ?>
        <div id="id2Msg" style="color:red" class="non-available">
            <input type="hidden" value="0" name="id_available"/>
        </div>
    <?php } else if (!preg_match("/^[a-z0-9_]{5,12}$/", $id)) { ?>
        <div id="id2Msg" style="color:red" class="non-available">
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
            <div id="pw1Msg" style="color:red" class="non-available">
                <?php echo $lang['MESSAGE']['PW_RULE'] ?>
                <input type="hidden" value="0" name="pw_length"/>
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

<?php if ($_POST['type'] == 'team_check') { ?>
    <?php $team = $_POST['team']; ?>
    <?php if (empty($team)) { ?>
        <div id="team2Msg" style="color:red" class="non-available">
            <input type="hidden" value="0" name="team_check"/>
        </div>
    <?php } else { ?>
        <?php $db_conn = new \mysql\MysqlInfo('jho_groupware'); ?>
        <?php $sql = "SELECT * FROM member WHERE t_team = '$team'"; ?>
        <?php $result = $db_conn->query($sql); ?>
        <?php /* check if it's exist */ ?>
        <?php if ($result->num_rows > 0) { // Already exist Team ?>
            <div id="team2Msg" style=" color:green" class="available">
                <?php echo $lang ['MESSAGE']['EXIST_TEAM'] ?>
                <input type="hidden" value="0" name="team_check"/>
            </div>
            <?php /* OK */ ?>
        <?php } else { ?>
            <div id="team2Msg" style=" color:darkgreen" class="available">
                <?php echo $lang ['MESSAGE']['NOT_EXIST_TEAM'] ?>
                <input type="hidden" value="1" name="team_check"/>
            </div>

        <?php } ?>
    <?php } ?>

<?php } ?>


