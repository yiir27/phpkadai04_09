<?php
$id = $_GET["id"]

//2. DB接続します
include("funcs.php");
$pdo = db_conn();

//データ登録
$sql = "DELETE FROM hoiku_user_table WHERE id=:id";
$stmt = $pdo->prepare("$sql");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

////４．データ登録処理後
if($status==false){
    sql_error($stmt);
  }else{
    redirect("kanri.php");
  }  
?>