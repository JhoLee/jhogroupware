<?php
session_start();
require_once '../resources/php/classes/Member/Member.php';
require_once '../resources/php/classes/Mysql/mysqlInfo.php';
require_once '../resources/lang/get_lang.php';

$db_conn = new \Mysql\MysqlInfo('jho_groupware');

?>
<?php if (!empty($_POST['signUp_id'])) { ?>

    <?php
    $signUp_id = $_POST['signUp_id'];

    $sql = "SELECT * FROM member WHERE m_id = '$signUp_id'";
    $result = $db_conn->query($sql);
    ?>
    <?php if ($result->num_rows == 0) { ?>
        <div style="color:green" class="available"><?php echo $lang['MESSAGE']['AVAILABLE_ID'] ?><input type="hidden"
                                                                                                        value="1"
                                                                                                        name="use"/>
        </div>
    <?php } else { ?>
        <div style="color:red" class="non_available">
            <?php echo $lang['MESSAGE']['NON_AVAILABLE_ID'] ?>
            <input type="hidden" value="0" name="use"/>
        </div>
    <?php } ?>

<?php } else { // Empty "$_POST['signUp_id']" ?>
    <div style="color:red" class="non_available">
        <?php echo $lang['MESSAGE']['ENTER_THE_ID'] ?>
        <input type="hidden" value="0" name="use"/>
    </div>
<?php } ?>
