<?php
session_start();

//POST値
$lid = $_POST["lid"];//ID
$lpw = $_POST["lpw"];//PW

//DB接続
include("funcs.php");

//データ登録SQL作成
//* PasswordがHash化→条件はlidのみ！！
$pdo = db_conn();
$sql = "SELECT * FROM hoiku_user_table WHERE lid=:lid AND life_flg=0";
$stmt = $pdo->prepare($sql); 
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();         //1レコードだけ取得する方法
//$count = $stmt->fetchColumn(); //SELECT COUNT(*)で使用可能()

//5.該当１レコードがあればSESSIONに値を代入
//入力したPasswordと暗号化されたPasswordを比較！[戻り値：true,false]
$pw = password_verify($lpw, $val["lpw"]);
if($pw){
    //LOGIN成功
    $_SESSION["chk_ssid"] = session_id();
    $_SESSION["kanri_flg"] = $val['kanri_flg'];
    $_SESSION["name"] = $val['name'];
    redirect("post.php");
} else {
  //Login失敗時(Logoutを経由：リダイレクト)
  redirect("login.php");
}
exit();