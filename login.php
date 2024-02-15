<?php

// DB 연결
require_once 'config.php';

// Create Connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
// Check Connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

$userPassword = $_POST['userPassword'];
$userPassword = json_encode($userPassword);



$sql = "SELECT part0 from info WHERE part0 = $userPassword";
$result = mysqli_query($connect, $sql);

if(mysqli_num_rows($result) == 1){
    echo "로그인 성공";
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['user_login'] = true;
}

else{
    echo "비밀번호를 틀렸습니다.";
}

mysqli_close($connect);
