<?php
$id = $_GET["id"];
include("funcs.php");//セットで使う requireを使うことが多いエラーが出ると止まる/includeはエラーが出ても頑張ってくれる
//２．データ登録SQL作成
$pdo = db_conn(); //db_connを呼び出して$pdoで実行する
$sql = "SELECT * FROM hoiku_user_table WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();
//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}
//データ取得
$v = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>USERデータ編集</title>
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
            <legend>編集</legend>
              <label>名前：<input type="text" name="name"></label><br>
              <label>LOGIN ID：<input type="text" name="lid"></label><br>
              <br>
              <input type="submit" value="送信">
              
        </fieldset>
    </div>
</form>
</body>
</html>
