<?php

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

$data = file_get_contents("php://input");
if (!$data) {
    echo "Failed\n";
}

$dataarray = json_decode($data, true); // 수신 decode

if (!($dataarray)) {
    die("JSON decode failed");
}


$user_key = json_encode($dataarray['user_key']);
$part0 = json_encode($dataarray['part0'], JSON_UNESCAPED_UNICODE);

$sql = "UPDATE info SET part0 = ? WHERE user_key = ?";
$stmt = mysqli_prepare($connect, $sql);




$bind = mysqli_stmt_bind_param($stmt, "ss", $part0, $user_key);
if ($bind === false) {
    echo ('파라미터 바인드 실패 : ' . mysqli_error($connect));
    exit();
}


$exec = mysqli_stmt_execute($stmt);
if ($exec === false) {
    echo ('쿼리 실행 실패 : ' . mysqli_error($connect));
    exit();
}
echo "전체 데이터 전송에 성공하였습니다.";



mysqli_stmt_close($stmt);
mysqli_close($connect);
