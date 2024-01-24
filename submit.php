<?php
// DB 연결
$servername = "localhost";
$username = "developnehub";
$password = "develop123~";
$dbname = "developnehub";

// Create Connection
$connect = mysqli_connect($servername, $username, $password, $dbname);
// Check Connection
if (!$connect) {
    die("Connection failed: " .mysqli_connect_error());
}
else{
    echo "Connection successfully";
}

// POST 데이터 받기
$age = $_POST['age'];
$nickname = $_POST['nickname'];
$birthday = $_POST['bday'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$weight = $_POST['weight'];


// 데이터베이스에 삽입하는 SQL 쿼리
$sql = "INSERT INTO info (age, nickname, birthday, gender, height, weight)
VALUES ('$age', '$nickname', '$birthday', '$gender', '$height', '$weight')";

// 쿼리 실행
if (mysqli_query($connect, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: ".$sql."<br>" .mysqli_error($connect);
}

// 연결 종료
mysqli_close($connect);
?>