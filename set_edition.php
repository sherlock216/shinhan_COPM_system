<?php

// DB 연결
require_once 'config.php';

// Create Connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
// Check Connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$edition = $_POST['edition'];

$sql = "UPDATE setting SET value = $edition WHERE name = 'current_state'";
$result = mysqli_query($connect, $sql);

if($result){
    echo "<script>alert('변경 성공.'); location.href='edition.php';</script>";
}
else{
    echo '변경 실패. 관리자에게 문의하세요.';
}

mysqli_close($connect);


?>