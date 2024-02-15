<?php
// DB 연결
require_once 'config.php';

// Create Connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
// Check Connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
/*else{
    echo "Connection successfully";
}*/


$user_key = $_GET['user_key'];
$checking = "SELECT * FROM info WHERE user_key = '$user_key'";


$count = mysqli_num_rows(mysqli_query($connect, $checking));

// 뒤로 가기 했을때 중복 발생 우려 체킹
if ($count == 0) {
    // 데이터베이스에 삽입하는 SQL
    $sql = "INSERT INTO info (user_key) VALUES ('$user_key')";

    mysqli_query($connect, $sql);
}

// 연결 종료
mysqli_close($connect);
