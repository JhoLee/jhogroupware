<?php


require_once '../resources/php/classes/Mysql/MysqlInfo.php';


?>
<!--/div data-role="content"-->
<div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-tab-toggle="false"
     data-id="transaction_footer">
    <?php
    $sql = "
                SELECT MAX(d_processed_date) AS 'last updated date' 
                FROM deposit_history 
                WHERE deposit_history.t_team = '$team'
                ";
    $result = $db_conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
    <h2><?php echo $lang['LAST_UPDATE'] . ": " . $row['last updated date']; ?></h2>
    <div data-role="navbar" data-position="fixed">
        <ul>
            <li>
                <button data-theme="b" data-icon="bullets"><?php echo $lang['TRANSACTION'] ?></button>
            </li>
            <li><a href="../contacts/index.php" data-icon="user"><?php echo $lang['CONTACTS'] ?></a>
            </li>
            <li><a href="../calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>

            <li><a href="../settings/index.php" data-icon="gear"><?php echo $lang['SETTINGS'] ?></a></li>
        </ul>
    </div>
</div><!-- /footer -->
<!--/div data-role="page"-->