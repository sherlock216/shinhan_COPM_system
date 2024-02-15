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

$user_key = json_encode($_GET['user_key']);
$checking = "SELECT part0, result FROM info WHERE user_key = '$user_key'";

$count = mysqli_num_rows(mysqli_query($connect, $checking));

if ($count == 1) {
    $result = mysqli_query($connect, $checking);
    $data = mysqli_fetch_assoc($result);
    echo json_encode($data);
}


mysqli_close($connect);
?>