<?php
/**
 * User: Jho
 * Date: 2018-01-10
 * Time: 08:17
 */
session_start();
if (!isset($_SESSION['member_id'])) {
    header('Location: ../login/login.php');
}
require_once('../jho.php');

require_once '../resources/lang/get_lang.php';


require_once '../resources/head.php';
?>

<body>
<!-- Start of the summary page -->
<div data-role="page" id="personal_summary" data-theme="c">
    <div data-role="panel" id="summary_menu" data-display="reveal">
        <a href="../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="transaction_view_admin.php" data-ajax="false">';
                echo $lang["TRANSACTION_VIEW_ADMIN"] . '</a></li>';
            } ?>
            <li><a href="transaction_view_personal.php"><?php echo $lang['TRANSACTION_VIEW_PERSONAL'] ?></a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info"><?php echo $lang['APP_INFO'] ?></a>
        <a data-role="button" href="../login/logout.php" data-theme="b"
           data-icon="delete"><?php echo $lang['LOGOUT_BUTTON'] ?></a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false">
        <a href="#summary_menu" data-icon="bars"><?php echo $lang['MENU'] ?></a>
        <h1><?php echo $lang['TRANSACTION_VIEW_PERSONAL'] ?>(<?php echo $lang['SUMMARY'] ?>)</h1>
        <a data-rel="back" data-icon="back"><?php echo $lang['BACK_KEY'] ?></a>
        <div data-role="navbar" id="summary_navbar">
            <ul>
                <li><a href="#personal_summary" data-ajax="false"><?php echo $lang['SUMMARY'] ?></a></li>
                <li><a href="#personal_details" data-ajaxa="false"><?php echo $lang['DETAILS'] ?></a></li>
                <li><a href="insert.php" data-ajaxa="false"><?php echo $lang['INSERT'] ?></a></li>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <table data-role="table" id="transaction_summary_personal_table" data-mode="reflow"
               class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist">이름</th>
                <th colspan="1">잔액</th>
                <th colspan="1">최종 변경일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $name = $_SESSION['member_name'];
            $team = $_SESSION['member_team'];
            $sql = "SELECT m_name AS '이름', SUM(d_category * d_ammount) AS '잔액', MAX(d_date) AS '최종 변경일'
                    FROM deposit_history WHERE t_team='$team' AND m_name = '$name'";
            $result = $db_conn->query($sql);
            if (isset($result)) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                    echo
                        "<tr>
                    <th>" . $row['이름'] . "</th>
                    <td>" . $row['잔액'] . "</td>
                    <td>" . $row['최종 변경일'] . "</td>
                </tr>";
                }
            } ?>
            </tbody>
        </table>
        <br>
        <br>
        <?php
        $sql = "SELECT da_depositor AS '예금주명', da_bank AS '은행', da_number AS '계좌번호'
                    FROM dues_account_information WHERE t_team='$team'";
        $result = $db_conn->query($sql);
        if (isset($result) && $result->num_rows > 0) {
            ?>
            <table data-role="table" id="duesAccount_info" data-mode="reflow" class="ui-responsive table-stroke">
                <thead>
                <tr>
                    <th data-priority="persist">회비 입금 계좌</th>
                    <th colspan="1">예금주명</th>
                    <th colspan="1">계좌 번호</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()) {
                    echo
                        "<tr>
            <th>" . $row['은행'] . "</th>
            <td>" . $row['예금주명'] . "</td>
            <td>" . $row['계좌번호'] . "</td>
            </tr>";
                } ?>
                </tbody>
            </table>
            <br>
            <!-- Announce Board -->
            <?php include_once '../announce_board/announce_view.php'; ?>
        <?php } ?>
    </div><!-- /content -->


    <div data-role="footer" id="foot" data-position="fixed" data-theme="a" data-tab-toggle="false"
         data-id="transaction_footer">
        <?php $sql = "
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
                <li><a href="../calendar/index.php" data-icon="calendar"><?php echo $lang['CALENDAR'] ?></a></li>

                <li><a href="../settings/index.php" data-icon="gear"><?php echo $lang['SETTINGS'] ?></a></li>
            </ul>
        </div>
    </div><!-- /footer -->
</div><!-- /page -->

<!-- Start of the details page -->
<div data-role="page" id="personal_details" data-theme="c">
    <div data-role="panel" id="details_menu" data-display="reveal">
        <a href="../settings/info/my_info.php" data-theme="a" data-role="button"
           data-icon="user"><?php echo $_SESSION['member_name']; ?></a>
        <ul data-role="listview" data-theme="a" data-inset="true">
            <?php if ($_SESSION['member_permission'] >= 2) {
                echo '<li><a href="transaction_view_admin.php" data-ajax="false">전체 조회(관리자)</a></li>';
            } ?>
            <li><a href="#personal_summary">개별 조회</a></li>
        </ul>
        <a data-role="button" href="../settings/info/app_info.php" data-icon="info">App Info</a>
        <a data-role="button" href="../login/logout.php" data-theme="d" data-icon="delete" data-ajax="false">logout</a>

    </div><!-- /panel#menu-->

    <div data-role="header" data-theme="a" data-position="fixed" data-tab-toggle="false" data-id="personal_header">
        <a href="#details_menu" data-icon="bars">menu</a>
        <h1>Personal View(details)</h1>
        <a data-rel="back" data-icon="back">back</a>
        <div data-role="navbar" id="details_navbar">
            <ul>
                <li><a href="#personal_summary" data-ajax="false">summary</a></li>
                <li><a href="#personal_details" data-ajaxa="false">details</a></li>
                <li><a href="insert.php" data-ajaxa="false">insert</a></li>
            </ul>
        </div>
    </div><!-- /header -->

    <div data-role="content">

        <script language="javascript">

            $(document).on("pageshow", "#dataTablesExample1", function () {

                if ($.fn.DataTable.isDataTable('#example')) {
                    $('#example').DataTable().columns.adjust();
                    return;
                }

                $('#example').dataTable({
                    "scrollX": true,
                    "scrollXollapse": true,
                    "ajax": 'assets/files/demos/jquery_mobile/datatables/dt_ajax_example.json',
                    "pagingType": "full"
                });
            });

            $(document).on("pageremove", function (event) {
                $('#example').DataTable().destroy(false);
            })

        </script>


        <table data-role="table" id="transaction_details_personal_table" data-mode="reflow"
               class="ui-responsive table-stroke">
            <thead>
            <tr>
                <th data-priority="persist">날짜</th>
                <th colspan="1">+</th>
                <th colspan="1">-</th>
                <th colspan="1">내용</th>
                <th colspan="1">잔액</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $id = $_SESSION['member_id'];
            $name = $_SESSION['member_name'];
            $team = $_SESSION['member_team'];
            $db_conn->query("SET @balance := 0;");
            $sql = "
            SELECT
              ql.d_id,
              ql.비고,
              ql.구분,
              ql.금액,
              ql.날짜,
              ql.입력일,
            
              (@balance := @balance + (ql.구분 * ql.금액)) AS '잔액'
            
            FROM
              (SELECT
                 d_id,
                 d_category       AS '구분',
                 d_ammount        AS '금액',
                 d_rmks           AS '비고',
                 d_date           AS '날짜',
                 d_processed_date AS '입력일'
               FROM deposit_history
               WHERE t_team = '$team' AND m_name = '$name'
               GROUP BY d_id, d_date
               ORDER BY d_date, d_id) AS ql
            ORDER BY ql.날짜, ql.d_id ASC;";
            $result = $db_conn->query($sql);
            if (isset($result)) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                    echo "<tr >
                    <th>" . $row['날짜'] . "</th>";
                    if ($row['구분'] > 0) {
                        echo "<td>" . $row['금액'] . "원</td>
                            <td>0원</td>";
                    } else if ($row['구분'] < 0) {
                        echo "<td>0원</td>
                             <td>" . $row['금액'] . "원</td>";

                    } else {
                        echo "<td>0원</td>
                                <td>0원</td>";
                    }
                    echo "<td>" . $row['비고'] . "</td>
                    <td>" . $row['잔액'] . "원</td>
                  </tr>";
                }
            } ?>
            </tbody>
        </table>
        <br>

    </div><!-- /content -->


    <div data-role="footer" data-position="fixed" data-theme="a" data-tab-toggle="false"
         data-id="transaction_footer">
        <?php $sql = "
                SELECT MAX(d_processed_date) AS 'last updated date' 
                FROM deposit_history 
                WHERE deposit_history.t_team = '$team'
                ";
        $result = $db_conn->query($sql);
        $row = $result->fetch_assoc();
        ?>
        <h2>Data Last Updated at : <?php echo $row['last updated date']; ?></h2>
        <div data-role="navbar" data-position="fixed">
            <ul>
                <li>
                    <button data-theme="b" data-icon="bullets">transaction</button>
                </li>
                <li><a href="../calendar/index.php" data-icon="calendar">calendar</a></li>

                <li><a href="../settings/index.php" data-icon="gear">settings</a></li>
            </ul>
        </div>
    </div><!-- /footer -->
</div><!-- /page -->


</body>
</html>