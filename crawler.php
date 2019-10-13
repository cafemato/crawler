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
'<?php'.PHP_EOL.PHP_EOL.
"header('Content-Type: application/json; charset=utf-8');".PHP_EOL.PHP_EOL.
'define("DB_HOST", "127.0.0.1");'.PHP_EOL.
'define("DB_USERNAME", "root");'.PHP_EOL.
'define("DB_PASSWORD", "root");'.PHP_EOL.
'define("DB_NAME", "job_bank");'.PHP_EOL.PHP_EOL.
'$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);'.PHP_EOL.
'if(!$mysqli){die("Connection failed: " . $mysqli->error);}'.PHP_EOL.PHP_EOL.
'$query = sprintf("SELECT industry, count(*) AS counts FROM '.$t_name.' GROUP BY industry ");'.PHP_EOL.
'$result = $mysqli->query($query);'.PHP_EOL.PHP_EOL.
'$data = array();'.PHP_EOL.
'foreach ($result as $row) { $data[] = $row; }'.PHP_EOL.PHP_EOL.
'$posts = array();'.PHP_EOL.
'$posts[] = array('."'data1'".'=> $data);'.PHP_EOL.PHP_EOL.
'$result->close();'.PHP_EOL.PHP_EOL.
'$mysqli->close();'.PHP_EOL.PHP_EOL.
'print json_encode($posts);'.PHP_EOL.PHP_EOL.
'?>'
);
fclose($file);
echo "寫入檔案成功, 檔案大小為 " . $fileSize . " bytes";
?>