<?php
session_start();
include "funcs.php";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>USERデータ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>
<form method="post"  action="user_insert.php">
    <header>
        <a href="login.php">LOGIN</a>
    </header>
    <div class="jumbotron">
        <fieldset>
            <legend>ユーザー登録</legend>
              <label>名前：<input type="text" name="name"></label><br>
              <label>LOGIN ID：<input type="text" name="lid"></label><br>
              <label>LOGIN PW：<input type="password" name="lpw"></label><br>
              <br>
              <input type="submit" value="送信">
              
        </fieldset>
    </div>
</form>
</body>
</html>
