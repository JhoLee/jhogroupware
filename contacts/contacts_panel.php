<?php
/*
 * Template file for panel of '/settings/*.php'
 */
?>
<a href="../settings/info/my_info.php" data-theme="a" data-role="button"
   data-icon="user"><?php echo $member->getName() ?></a>
<ul data-role="listview" data-theme="a" data-inset="true">
    <li><a href="index.php" data-theme="a" data-ajxa="false"><?php echo $lang['CONTACTS'] ?></a></li>
    <?php if ($member->getPermission() >= 2) { ?>
        <li><a href="manage_members.php" data-theme="a"
               data-ajax="false"><?php echo $lang['MANAGE_MEMBERS'] ?></a></li>
    <?php } ?>
</ul>
<a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
<a data-role="button" href="../login/logout.php" data-theme="b" data-icon="delete"
   data-ajax="false"><?php echo $lang['LOGOUT'] ?></a>
