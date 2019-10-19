<?php
header('Content-Type: application/json; charset=utf-8');

define("DB_HOST", "127.0.0.1");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "job_bank");

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){die("Connection failed: " . $mysqli->error);}

$query1_1 = sprintf("SELECT industry,count(*) AS counts FROM ai GROUP BY industry");
$query1_2 = sprintf("SELECT industry,count(*) AS counts FROM bigdata GROUP BY industry");
$query1_3 = sprintf("SELECT industry,count(*) AS counts FROM d_marketing GROUP BY industry");
$query1_4 = sprintf("SELECT industry,count(*) AS counts FROM java_engineer GROUP BY industry");
$query1_5 = sprintf("SELECT industry,count(*) AS counts FROM front_engineer GROUP BY industry");


$query2_1 = sprintf("SELECT company,salary_low,requirement from ai");
$query2_2 = sprintf("SELECT company,salary_low,requirement from bigdata");
$query2_3 = sprintf("SELECT company,salary_low,requirement from d_marketing");
$query2_4 = sprintf("SELECT company,salary_low,requirement from java_engineer");
$query2_5 = sprintf("SELECT company,salary_low,requirement from front_engineer");

$query3_1 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END)) AS tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_low END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_low END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_low END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_low END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_low END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_low END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_low END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_low END)) AS  others
FROM ai
WHERE salary_low >1500 and salary_low < 150000 ");

$query3_2 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END)) AS tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_low END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_low END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_low END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_low END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_low END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_low END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_low END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_low END)) AS  others
FROM bigdata
WHERE salary_low >1500 and salary_low < 150000 ");

$query3_3 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END)) AS tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_low END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_low END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_low END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_low END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_low END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_low END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_low END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_low END)) AS  others
FROM d_marketing
WHERE salary_low >1500 and salary_low < 150000 ");

$query3_4 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END)) AS tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_low END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_low END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_low END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_low END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_low END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_low END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_low END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_low END)) AS  others
FROM java_engineer
WHERE salary_low >1500 and salary_low < 150000 ");

$query3_5 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END)) AS tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_low END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_low END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_low END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_low END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_low END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_low END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_low END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_low END)) AS  others
FROM front_engineer
WHERE salary_low >1500 and salary_low < 150000 ");

$query4_1 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_high END)) AS  tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_high END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_high END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_high END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_high END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_high END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_high END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_high END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_high END)) AS  others
FROM ai
WHERE salary_high >3000 and salary_high < 250000 ");

$query4_2 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_high END)) AS  tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_high END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_high END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_high END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_high END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_high END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_high END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_high END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_high END)) AS  others
FROM bigdata
WHERE salary_high >3000 and salary_high < 250000 ");

$query4_3 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_high END)) AS  tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_high END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_high END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_high END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_high END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_high END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_high END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_high END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_high END)) AS  others
FROM d_marketing
WHERE salary_high >3000 and salary_high < 250000 ");

$query4_4 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_high END)) AS  tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_high END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_high END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_high END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_high END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_high END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_high END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_high END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_high END)) AS  others
FROM java_engineer
WHERE salary_high >3000 and salary_high < 250000 ");

$query4_5 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_high END)) AS  tech,
ROUND(AVG(CASE WHEN industry = '電子電信業' THEN salary_high END)) AS  elec,
ROUND(AVG(CASE WHEN industry = '金融業' THEN salary_high END)) AS  fin,
ROUND(AVG(CASE WHEN industry = '傳產製造業' THEN salary_high END)) AS  manu,
ROUND(AVG(CASE WHEN industry = '文化媒體業' THEN salary_high END)) AS  media,
ROUND(AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_high END)) AS  edu,
ROUND(AVG(CASE WHEN industry = '一般商業' THEN salary_high END)) AS  biz,
ROUND(AVG(CASE WHEN industry = '服務業' THEN salary_high END)) AS  service,
ROUND(AVG(CASE WHEN industry = '其他產業' THEN salary_high END)) AS  others
FROM front_engineer
WHERE salary_high >3000 and salary_high < 250000 ");

$query5_1 = sprintf("SELECT area, count(*) AS counts FROM ai GROUP BY area ");
$query5_2 = sprintf("SELECT area, count(*) AS counts FROM bigdata GROUP BY area ");
$query5_3 = sprintf("SELECT area, count(*) AS counts FROM d_marketing GROUP BY area ");
$query5_4 = sprintf("SELECT area, count(*) AS counts FROM java_engineer GROUP BY area ");
$query5_5 = sprintf("SELECT area, count(*) AS counts FROM front_engineer GROUP BY area ");

$result1_1 = $mysqli->query($query1_1);
$result1_2 = $mysqli->query($query1_2);
$result1_3 = $mysqli->query($query1_3);
$result1_4 = $mysqli->query($query1_4);
$result1_5 = $mysqli->query($query1_5);


$result2_1 = $mysqli->query($query2_1);
$result2_2 = $mysqli->query($query2_2);
$result2_3 = $mysqli->query($query2_3);
$result2_4 = $mysqli->query($query2_4);
$result2_5 = $mysqli->query($query2_5);


$result3_1 = $mysqli->query($query3_1);
$result3_2 = $mysqli->query($query3_2);
$result3_3 = $mysqli->query($query3_3);
$result3_4 = $mysqli->query($query3_4);
$result3_5 = $mysqli->query($query3_5);

$result4_1 = $mysqli->query($query4_1);
$result4_2 = $mysqli->query($query4_2);
$result4_3 = $mysqli->query($query4_3);
$result4_4 = $mysqli->query($query4_4);
$result4_5 = $mysqli->query($query4_5);

$result5_1 = $mysqli->query($query5_1);
$result5_2 = $mysqli->query($query5_2);
$result5_3 = $mysqli->query($query5_3);
$result5_4 = $mysqli->query($query5_4);
$result5_5 = $mysqli->query($query5_5);



$data1_1 = array();
foreach ($result1_1 as $row) { $data1_1[] = $row; }
$data1_2 = array();
foreach ($result1_2 as $row) { $data1_2[] = $row; }
$data1_3 = array();
foreach ($result1_3 as $row) { $data1_3[] = $row; }
$data1_4 = array();
foreach ($result1_4 as $row) { $data1_4[] = $row; }
$data1_5 = array();
foreach ($result1_5 as $row) { $data1_5[] = $row; }

$data2_1 = array();
foreach ($result2_1 as $row) { $data2_1[] = $row; }
$data2_2 = array();
foreach ($result2_2 as $row) { $data2_2[] = $row; }
$data2_3 = array();
foreach ($result2_3 as $row) { $data2_3[] = $row; }
$data2_4 = array();
foreach ($result2_4 as $row) { $data2_4[] = $row; }
$data2_5 = array();
foreach ($result2_5 as $row) { $data2_5[] = $row; }


$data3_1 = array();
foreach ($result3_1 as $row) { $data3_1[] = $row; }
$data3_2 = array();
foreach ($result3_2 as $row) { $data3_2[] = $row; }
$data3_3 = array();
foreach ($result3_3 as $row) { $data3_3[] = $row; }
$data3_4 = array();
foreach ($result3_4 as $row) { $data3_4[] = $row; }
$data3_5 = array();
foreach ($result3_5 as $row) { $data3_5[] = $row; }

$data4_1 = array();
foreach ($result4_1 as $row) { $data4_1[] = $row; }
$data4_2 = array();
foreach ($result4_2 as $row) { $data4_2[] = $row; }
$data4_3 = array();
foreach ($result4_3 as $row) { $data4_3[] = $row; }
$data4_4 = array();
foreach ($result4_4 as $row) { $data4_4[] = $row; }
$data4_5 = array();
foreach ($result4_5 as $row) { $data4_5[] = $row; }

$data5_1 = array();
foreach ($result5_1 as $row) { $data5_1[] = $row; }
$data5_2 = array();
foreach ($result5_2 as $row) { $data5_2[] = $row; }
$data5_3 = array();
foreach ($result5_3 as $row) { $data5_3[] = $row; }
$data5_4 = array();
foreach ($result5_4 as $row) { $data5_4[] = $row; }
$data5_5 = array();
foreach ($result5_5 as $row) { $data5_5[] = $row; }

$key = '人工智慧';

$table = 'ai';

$sysvar = array(array('keyword' => $key ,'t_name' => $table));

$posts = array();
$posts[] = array('data1_1'=> $data1_1, 'data1_2'=> $data1_2, 'data1_3'=> $data1_3, 'data1_4'=> $data1_4, 'data1_5'=> $data1_5, 'data2_1'=> $data2_1, 'data2_2'=> $data2_2, 'data2_3'=> $data2_3, 'data2_4'=> $data2_4, 'data2_5'=> $data2_5,'data3_1'=> $data3_1,'data3_2'=> $data3_2,'data3_3'=> $data3_3,'data3_4'=> $data3_4,'data3_5'=> $data3_5,'data4_1'=> $data4_1,'data4_2'=> $data4_2,'data4_3'=> $data4_3,'data4_4'=> $data4_4,'data4_5'=> $data4_5,'data5_1'=> $data5_1,'data5_2'=> $data5_2,'data5_3'=> $data5_3,'data5_4'=> $data5_4,'data5_5'=> $data5_5,'sysvar'=> $sysvar);

// $result->close();
$mysqli->close();

print json_encode($posts);

?>