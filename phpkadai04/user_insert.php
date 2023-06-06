<?php
session_start();
include "funcs.php";
//データ取得
$name = $_POST["name"];
$lid  = $_POST["lid"];
$lpw  = $_POST["lpw"];
$kanri_flg = $_POST["kanri_flg"];
$lpw = password_hash($lpw, PASSWORD_DEFAULT);//hash化
//データ登録SQL作成
$pdo = db_conn();
$sql = "INSERT INTO hoiku_user_table(name,lid,lpw,life_flg)VALUES(:name,:lid,:lpw,0)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("login.php");
}

?>