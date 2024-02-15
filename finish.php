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


// edition 결정
$edition_sql = "SELECT value FROM setting WHERE name = 'current_state'";
$edition_result = mysqli_query($connect, $edition_sql);
if ($edition_result === false) {
    echo ('회차 조회 실패 : ' . mysqli_error($connect));
    exit();
}
$edition_row = mysqli_fetch_assoc($edition_result);
$edition = $edition_row['value'];





$sql = "INSERT INTO info (user_key, edition, part0, part1, part2, part3, part4, score, result, nowtime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($connect, $sql);

$user_key = json_encode($dataarray['user_key']);
$part0 = json_encode($dataarray['part0'], JSON_UNESCAPED_UNICODE);
$part1 = json_encode($dataarray['part1'], JSON_UNESCAPED_UNICODE);
$part2 = json_encode($dataarray['part2'], JSON_UNESCAPED_UNICODE);
$part3 = json_encode($dataarray['part3'], JSON_UNESCAPED_UNICODE);
$part4 = json_encode($dataarray['part4'], JSON_UNESCAPED_UNICODE);
$score = json_encode($dataarray['score'], JSON_UNESCAPED_UNICODE);
$result = json_encode($dataarray['result']);
$nowtime = date("Y-m-d H:i:s");

$checking = "SELECT * FROM info WHERE user_key = '$user_key'";
$count = mysqli_num_rows(mysqli_query($connect, $checking));

if ($count) {
    /*echo "이미 데이터를 저장한 이력이 있기 때문에 추가 저장이 불가합니다. 방금 테스트하신 결과는 저장되지는 않지만 다음 페이지에서 결과는 확인 가능합니다.";*/
    echo "현재 테스트용입니다. 기존 데이터를 삭제하고 현재 데이터로 바꾸겠습니다.";
    $sql_delete = "DELETE FROM info WHERE user_key = '$user_key'";
    mysqli_query($connect, $sql_delete);
    /*mysqli_close($connect);
    exit();*/
}

// 뒤로 가기 했을때 중복 발생 우려 체킹


$bind = mysqli_stmt_bind_param($stmt, "sissssssss", $user_key, $edition, $part0, $part1, $part2, $part3, $part4, $score, $result, $nowtime);
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
