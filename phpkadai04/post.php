<?php
session_start();
include "funcs.php";
sschk();
?>

<html>
<head>
<meta charset="UTF-8">
<title>保育記録</title>
<link rel="stylesheet" herf="./style.css">
</head>
<body>
<header>
    <?php
    //管理者画面
    if($_SESSION["kanri_flg"] == 1){ ?>
     <div class="kanri">
          <a href="kanri.php">ADMIN</a>
     </div>
    <?php } ?>
    <div class="logout">
          <a href="login.php">LOGOUT</a>
    </div>
    <div class="list">
          <a href="select.php">LIST</a>
    </div>
</header>
<form action="insert.php" method="post">
    <p>保育日誌</p>
    いつ：<input type="date" name="date"> 
    <br>
    天気：<input type="radio" name="weather" value="晴れ">晴れ
         <input type="radio" name="weather" value="曇り">曇り
         <input type="radio" name="weather" value="雨">雨
    <br>
    機嫌：<input type="radio" name="kigen" value="良い">良い
         <input type="radio" name="kigen" value="普通">普通
         <input type="radio" name="kigen" value="悪い">悪い
    <br>
    昼食：<input type="text" name="lunch">
    <br>
    午睡：<input type="time" name="neru">〜
         <input type="time" name="okita">
    <br>
    検温：<input type="text" name="taion">Ｃ°
    <input type="submit" value="送信">
</form>    
</body>
</html>