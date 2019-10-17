<?php
header('Content-Type: application/json; charset=utf-8');

define("DB_HOST", "127.0.0.1");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "job_bank");

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){die("Connection failed: " . $mysqli->error);}

$query = sprintf("SELECT industry,count(*) AS counts FROM front_engineer GROUP BY industry");

$query2 = sprintf("SELECT company,salary_low,requirement from front_engineer");

$query3 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END)) AS tech,
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

$query4 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '資訊科技業' THEN salary_high END)) AS  tech,
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

$query5 = sprintf("SELECT area, count(*) AS counts FROM front_engineer GROUP BY area ");

$result = $mysqli->query($query);
$result2 = $mysqli->query($query2);
$result3 = $mysqli->query($query3);
$result4 = $mysqli->query($query4);
$result5 = $mysqli->query($query5);

$data = array();
foreach ($result as $row) { $data[] = $row; }
$data2 = array();
foreach ($result2 as $row) { $data2[] = $row; }
$data3 = array();
foreach ($result3 as $row) { $data3[] = $row; }
$data4 = array();
foreach ($result4 as $row) { $data4[] = $row; }
$data5 = array();
foreach ($result5 as $row) { $data5[] = $row; }

$key = '前端工程師';

$table = 'front_engineer';

$sysvar = array(array('keyword' => $key ,'t_name' => $table));

$posts = array();
$posts[] = array('data1'=> $data,'data2'=> $data2,'data3'=> $data3,'data4'=> $data4,'data5'=> $data5,'sysvar'=> $sysvar);

$result->close();
$mysqli->close();

print json_encode($posts);

?>