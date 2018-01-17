SET @balance := 0;
SELECT
  ql.비고,
  ql.구분,
  ql.금액,
  ql.날짜,
  ql.입력일,

  (@balance := @balance + (ql.구분 * ql.금액)) AS '잔액'

FROM
  (SELECT
     d_category       AS '구분',
     d_ammount        AS '금액',
     d_rmks           AS '비고',
     d_date           AS '날짜',
     d_processed_date AS '입력일'
   FROM deposit_history
   WHERE t_team = 'NON' AND m_name = 'tester'
   GROUP BY d_date, d_rmks
   ORDER BY d_date) AS ql
ORDER BY ql.날짜 ASC;