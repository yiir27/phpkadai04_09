<?php
$id = $_GET["id"];
include("funcs.php");//セットで使う requireを使うことが多いエラーが出ると止まる/includeはエラーが出ても頑張ってくれる
$pdo = db_conn(); //db_connを呼び出して$pdoで実行する
//２．データ登録SQL作成
$sql = "SELECT * FROM hoiku_table WHERE id=:id";
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

<html>
<head>
<meta charset="UTF-8">
<title>保育記録更新</title>
<link rel="stylesheet" herf="./style.css">
</head>
<body>
<form action="update.php" method="POST">
    <p>保育記録</p>
    いつ：<input type="date" name="date" value="<?=h($v["date"])?>"> 
    <br>
    天気：<input type="checkbox" name="weather" value="晴れ">晴れ
         <input type="checkbox" name="weather" value="曇り">曇り
         <input type="checkbox" name="weather" value="雨">雨
    <br>
    機嫌：<input type="checkbox" name="kigen" value="良い">良い
         <input type="checkbox" name="kigen" value="普通">普通
         <input type="checkbox" name="kigen" value="悪い">悪い
    <br>
    昼食：<input type="text" name="lunch" value="<?=h($v["lunch"])?>">
    <br>
    午睡：<input type="time" name="neru" value="<?=h($v["neru"])?>">〜
         <input type="time" name="okita" value="<?=h($v["okita"])?>">
    <br>
    検温：<input type="text" name="taion" value="<?=h($v["taion"])?>">Ｃ°
    <br>
    <input type="hidden" name="id" value="<?=$v["id"]?>">
    <input type="submit" value="送信">
</form>    
</body>
</html>