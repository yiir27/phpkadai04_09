<?php
session_start();
include("funcs.php");
// sschk();

//２．データ登録SQL作成
$pdo = db_conn(); //db_connを呼び出して$pdoで実行する
$sql = "SELECT * FROM hoiku_user_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$values = "";
if($status == false) {
  sql_error($stmt);//関数sql_errorを実行
}

//全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー一覧</title>
</head>
<body>
<div class="container">
    <table>
        <tr>
            <th>name</th>
            <th>ID</th>
        </tr>
        <?php foreach($values as $v) {?>
            <td><?= h($v["name"]) ?></td>
            <td><?= h($v["lid"]) ?></td>
            <td><a href="delete.php?id=<?=$v["id"]?>">🗑️</a></td>
        <?php } ?>
    </table>
</div>
    
</body>
</html>