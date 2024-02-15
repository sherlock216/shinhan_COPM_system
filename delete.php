<?php

// DB 연결
require_once 'config.php';

// Create Connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
// Check Connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_key = $_POST['delete_key'];
$user_key = json_encode($user_key);



$sql = "DELETE FROM info WHERE user_key = $user_key";
$result = mysqli_query($connect, $sql);

if($result){
    echo '삭제 성공';
}
else{
    echo '삭제 실패';
}
mysqli_close($connect);
