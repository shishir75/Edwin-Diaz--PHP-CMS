<?php 

// for more secure application data
$db['db_host'] = "localhost";
$db['db_user'] = "root";
$db['db_pass'] = "pass";
$db['db_name'] = "cms";

foreach ($db as $key => $value) {
	define(strtoupper($key), $value);
	
}

$connection =mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($connection) {
	//echo "We are connected";
} else {
	echo "Database connection failed";
}













 ?>