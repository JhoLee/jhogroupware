SET @balance := 0;
SELECT
  ql.날짜,
  ql.이름,
  ql.구분,
  ql.금액,
  ql.비고,
  (@balance := @balance + (ql.구분 * ql.금액)) AS '잔액',
  ql.입력일

FROM
  (SELECT
     m_name           AS '이름',
     d_category       AS '구분',
     d_ammount        AS '금액',
     d_rmks           AS '비고',
     d_date           AS '날짜',
     d_processed_date AS '입력일'
   FROM deposit_history
   WHERE t_team = 'NON'

   ORDER BY 날짜, 이름) AS ql

ORDER BY ql.날짜, ql.이름, ql.입력일 ASC;
