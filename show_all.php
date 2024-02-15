<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB 연결
require_once 'config.php';

// Create Connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
// Check Connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
/*else {
    echo "Connection successfully\n";
}*/

$checking = "SELECT * FROM info WHERE user_key != 'admin'";


$result = mysqli_query($connect, $checking);

$rows=[];

while($row = mysqli_fetch_assoc($result)){
    $row['user_key'] = json_decode($row['user_key'], true);
    $row['part0'] = json_decode($row['part0'], true);
    $row['part1'] = json_decode($row['part1'], true);
    $row['part2'] = json_decode($row['part2'], true);
    $row['part3'] = json_decode($row['part3'], true);
    $row['part4'] = json_decode($row['part4'], true);
    $row['score'] = json_decode($row['score'], true);
    $row['result'] = json_decode($row['result'], true);
    $rows[] = $row; 
}


echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


mysqli_close($connect);
?>