<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
        $db_name = "hoiku";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "root";      //パスワード：XAMPPはパスワード無し or MAMPはパスワード”root”に修正してください。
        $db_host = "localhost"; //DBホスト
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
        
        // if($_SERVER["HTTP_HOST"] != 'localhost'){
        //     $db_name = 'yiir_hoiku';    //データベース名
        //     $db_id   = 'yiir';      //アカウント名
        //     $db_pw   = '';      //パスワード：XAMPPはパスワード無しに修正してください。
        //     $db_host = 'mysql57.yiir.sakura.ne.jp'; //DBホスト
        //     return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
        //     }
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }    
}

//SQLエラー関数：sql_error($stmt)
function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}


//リダイレクト関数: redirect($file_name)
function redirect($page) {
    header("Location: ".$page);
    exit();
}

function sschk() {
    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
        exit("Login Error");
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}
?>