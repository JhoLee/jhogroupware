<?php
/*
 * Template file for panel of '/settings/*.php'
 */
?>
<a href="../info/my_info.php" data-theme="a" data-role="button"
   data-icon="user"><?php echo $member->getName() ?></a>
<ul data-role="listview" data-theme="a" data-inset="true">
    <li><a href="change_lang.php" data-role="button" data-theme="a"
           data-icon="eye"><?php echo $lang['CHANGE_LANG'] ?></a></li>
    <li><a href="../contacts/manage_members.php" data-role="button" data-theme="a" data-icon="edit"
           data-ajax="false"><?php echo $lang['MANAGE_MEMBERS'] ?></a></li>
    <li><a href="../change/change_password.php" data-theme="a" data-role="button" data-icon="recycle"
           data-ajax="false"><?php echo $lang['CHANGE_PW'] ?></a></li>
</ul>
<a data-role="button" href="../info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
<a data-role="button" href="../../login/logout.php" data-theme="b" data-icon="delete"
   data-ajax="false"><?php echo $lang['LOGOUT'] ?></a>
