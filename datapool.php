<?php

header('Content-Type: application/json; charset=utf-8');

define("DB_HOST", "127.0.0.1");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "job_bank");

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){die("Connection failed: " . $mysqli->error);}

$query = sprintf("SELECT industry, count(*) AS counts FROM java_engineer GROUP BY industry ");
$result = $mysqli->query($query);

$data = array();
foreach ($result as $row) { $data[] = $row; }

$posts = array();
$posts[] = array('data1'=> $data);

$result->close();

$mysqli->close();

print json_encode($posts);

?>