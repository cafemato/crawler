<?php  

header("Content-type: text/html; charset=utf-8");


$keyword = readline("請輸入您要在人力銀行搜尋的關鍵字: ");
$t_name = readline("請輸入您搜尋關鍵字對應資料表名稱(請輸入英文字母): ");
echo '您輸入的關鍵字是: '.$keyword."\n";
echo '您輸入的資料表名稱是: '.$t_name."\n";

// $keyword = "大數據" ;
// $t_name = "bigdata";
     // echo "您輸入的關鍵字為: ". $keyword . "<br />";
     // echo "您輸入的表格名稱為: ". $t_name . "<br />";
     // echo "Results from test...";
     // echo "</br>";
     $output = passthru('python job_bank_104.py '.$keyword.' '.$t_name);
     echo $output;

// $output = exec('python /Users/ffmatojp/Documents/GitHub/crawler/test.py');
// echo $output;

// sleep(20);

$file = fopen("datapool.php", "w");
$fileSize = fputs( $file, 
'<?php'.PHP_EOL.
"header('Content-Type: application/json; charset=utf-8');".PHP_EOL.PHP_EOL.
'define("DB_HOST", "127.0.0.1");'.PHP_EOL.
'define("DB_USERNAME", "root");'.PHP_EOL.
'define("DB_PASSWORD", "root");'.PHP_EOL.
'define("DB_NAME", "job_bank");'.PHP_EOL.PHP_EOL.

'$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);'.PHP_EOL.
'if(!$mysqli){die("Connection failed: " . $mysqli->error);}'.PHP_EOL.PHP_EOL.
//查訊各產業的職缺數量
'$query = sprintf("SELECT industry,count(*) AS counts FROM '.$t_name.' GROUP BY industry");'.PHP_EOL.PHP_EOL.
//查訊關鍵字各產業的最低起薪跟最高起薪

'$query2 = sprintf("SELECT company,salary_low,requirement from '.$t_name.'");'.PHP_EOL.PHP_EOL.
//查訊關鍵字各產業的最低起薪跟最高起薪
'$query3 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '."'資訊科技業'".' THEN salary_low END)) AS tech,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'電子電信業'".' THEN salary_low END)) AS  elec,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'金融業'".' THEN salary_low END)) AS  fin,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'傳產製造業'".' THEN salary_low END)) AS  manu,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'文化媒體業'".' THEN salary_low END)) AS  media,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'教育研究醫療生技業'".' THEN salary_low END)) AS  edu,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'一般商業'".' THEN salary_low END)) AS  biz,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'服務業'".' THEN salary_low END)) AS  service,'.PHP_EOL.     
                 'ROUND(AVG(CASE WHEN industry = '."'其他產業'".' THEN salary_low END)) AS  others'.PHP_EOL.
				 'FROM bigdata'.PHP_EOL.
				 'WHERE salary_low >1500 and salary_low < 150000 ");'.PHP_EOL.PHP_EOL.

'$query4 = sprintf("SELECT ROUND(AVG(CASE WHEN industry = '."'資訊科技業'".' THEN salary_high END)) AS  tech,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'電子電信業'".' THEN salary_high END)) AS  elec,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'金融業'".' THEN salary_high END)) AS  fin,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'傳產製造業'".' THEN salary_high END)) AS  manu,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'文化媒體業'".' THEN salary_high END)) AS  media,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'教育研究醫療生技業'".' THEN salary_high END)) AS  edu,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'一般商業'".' THEN salary_high END)) AS  biz,'.PHP_EOL.
                 'ROUND(AVG(CASE WHEN industry = '."'服務業'".' THEN salary_high END)) AS  service,'.PHP_EOL.   
                 'ROUND(AVG(CASE WHEN industry = '."'其他產業'".' THEN salary_high END)) AS  others'.PHP_EOL.
				 'FROM bigdata'.PHP_EOL.
				 'WHERE salary_high >3000 and salary_high < 250000 ");'.PHP_EOL.PHP_EOL.

'$query5 = sprintf("SELECT area, count(*) AS counts FROM '.$t_name.' GROUP BY area ");'.PHP_EOL.PHP_EOL.



'$result = $mysqli->query($query);'.PHP_EOL.
'$result2 = $mysqli->query($query2);'.PHP_EOL.
'$result3 = $mysqli->query($query3);'.PHP_EOL.
'$result4 = $mysqli->query($query4);'.PHP_EOL.
'$result5 = $mysqli->query($query5);'.PHP_EOL.PHP_EOL.


'$data = array();'.PHP_EOL.
'foreach ($result as $row) { $data[] = $row; }'.PHP_EOL.
'$data2 = array();'.PHP_EOL.
'foreach ($result2 as $row) { $data2[] = $row; }'.PHP_EOL.
'$data3 = array();'.PHP_EOL.
'foreach ($result3 as $row) { $data3[] = $row; }'.PHP_EOL.
'$data4 = array();'.PHP_EOL.
'foreach ($result4 as $row) { $data4[] = $row; }'.PHP_EOL.
'$data5 = array();'.PHP_EOL.
'foreach ($result5 as $row) { $data5[] = $row; }'.PHP_EOL.PHP_EOL.

'$key = '.'\''.$keyword.'\''.';'.PHP_EOL.PHP_EOL.
'$table = '.'\''.$t_name.'\''.';'.PHP_EOL.PHP_EOL.

'$sysvar = array(array(\'keyword\' => $key ,\'t_name\' => $table));'.PHP_EOL.PHP_EOL.


'$posts = array();'.PHP_EOL.
'$posts[] = array('."'data1'".'=> $data,'."'data2'".'=> $data2,'."'data3'".'=> $data3,'."'data4'".'=> $data4,'."'data5'".'=> $data5,'."'sysvar'".'=> $sysvar);'.PHP_EOL.PHP_EOL.


'$result->close();'.PHP_EOL.
'$mysqli->close();'.PHP_EOL.PHP_EOL.

'print json_encode($posts);'.PHP_EOL.PHP_EOL.


'?>'
);
fclose($file);
echo "寫入檔案成功, 檔案大小為 " . $fileSize . " bytes";
