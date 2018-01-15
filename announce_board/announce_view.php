<?php
/*
 * File name: announce_view.php
 * Date: 18.01.15
 * Author: Jho
 * To-do: To get 'announce board's data, and show it.
 *
 */
if (!isset($_COOKIE["PHPSESSID"])) {
    session_start();
}
include_once '../jho.php';

if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/login.php');
}
$member_name = $_SESSION['member_id'];
$member_team = $_SESSION['member_team'];

$sql = "SELECT a_writer AS '작성자',
t_team AS '소속', 
a_title AS '제목', 
a_content AS '내용', 
a_wdate AS '작성일시', 
a_edate AS '수정일시' 
FROM announce_board
WHERE t_team = '$member_team'
ORDER BY a_id DESC";

$result = $db_conn->query($sql);

if ($result->num_rows > 0) { ?>
    <div data-role="collapsibleset" data-theme="a" data-content-theme="a" data-mini="true" data-collapsed-icon="carat-r"
         data-expanded-icon="carat-d">
        <?php while ($row = $result->fetch_assoc()) { ?>

            <div data-role="collapsible">
                <h3> <?php echo "  " . $row['제목'] . " ( 작성: " . $row['작성자'] . ", " . $row['작성일시'] ?> ) </h3>
                <p>
                <h6>제목: <?php echo $row['제목'] ?>
                    <br>작성자: <?php echo $row['작성자'] ?>
                    <br>최초 작성일: <?php echo $row['작성일시'] ?>
                    <br>최종 수정일: <?php echo $row['수정일시'] ?>
                </h6>
                <br><?php echo $row['내용']; ?>
                </p>
            </div>


            <?php
        } ?>
    </div><!--/collapsibleset-->
<?php } ?>
