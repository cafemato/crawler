<?php
ini_set('display_errors','1');
error_reporting(E_ALL);
//setting header to json
header('Content-Type: application/json; charset=utf-8');

//database
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'job_bank');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
  die("Connection failed: " . $mysqli->error);
}

//query to get data from the table
//查訊各產業的職缺數量
$query = sprintf("SELECT industry, count(*) AS counts FROM bigdata GROUP BY industry ");
//查訊關鍵字各產業的最低起薪跟最高起薪
$query2 = sprintf("SELECT company,salary_low,requirement from bigdata");
//查訊關鍵字各產業的最低起薪跟最高起薪
$query3 = sprintf("SELECT AVG(CASE WHEN industry = '資訊科技業' THEN salary_low END) AS  tech,
                 AVG(CASE WHEN industry = '電子電信業' THEN salary_low END) AS  elec,
                 AVG(CASE WHEN industry = '金融業' THEN salary_low END) AS  fin,
                 AVG(CASE WHEN industry = '傳產製造業' THEN salary_low END) AS  manu,
                 AVG(CASE WHEN industry = '文化媒體業' THEN salary_low END) AS  media,
                 AVG(CASE WHEN industry = '教育研究醫療生技業' THEN salary_low END) AS  edu,
                 AVG(CASE WHEN industry = '一般商業' THEN salary_low END) AS  biz,
                 AVG(CASE WHEN industry = '服務業' THEN salary_low END) AS  service,     
                 AVG(CASE WHEN industry = '其他產業' THEN salary_low END) AS  others
				 FROM bigdata
				 WHERE salary_low >1500 and salary_low < 150000 ");

//execute query
$result = $mysqli->query($query);
$result2 = $mysqli->query($query2);
$result3 = $mysqli->query($query3);

//loop through the returned data
$data = array();
foreach ($result as $row) {
  $data[] = $row;
}

$data2 = array();
foreach ($result2 as $row) {
  $data2[] = $row;
}

$data3 = array();
foreach ($result3 as $row) {
  $data3[] = $row;
}
$posts = array();
$posts[] = array('data1'=> $data, 'data2'=> $data2, 'data3'=> $data3);


// var myJSON = JSON.stringify(myObj);

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($posts);
// print json_encode($data2);

?>