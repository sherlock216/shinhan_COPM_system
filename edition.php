<?php
session_start();

if(!isset($_SESSION['user_login'])){
    header('Location: login.html');
    exit;
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>신한대학교 COPM System</title>
    <link rel="icon" type="image/jpg" href="image/favicon.jpg">
    <link rel="stylesheet" href="/css/show_result.css">
    <link rel="stylesheet" href="/css/button.css">

</head>


<body>

    <form action="set_edition.php" method="post">
        <select name="edition">
          <option value="1">1회</option>
          <option value="2">2회</option>
          <option value="3">3회</option>
        </select>
        <button type="submit">설정하기</button>
      </form>

      <br><br>
      <button type="button" onclick="location.href='show_all_result.php';">이전</button>
  

</body>