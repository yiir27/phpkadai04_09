<?php
//0. SESSION開始！！
session_start();
//DB接続
include("funcs.php");//セットで使う requireを使うことが多いエラーが出ると止まる/includeはエラーが出ても頑張ってくれる
//LOGINチェック
sschk();


//２．データ登録SQL作成
$pdo = db_conn(); //db_connを呼び出して$pdoで実行する
$sql = "SELECT * FROM hoiku_table;";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$values = "";
if($status == false) {
  sql_error($stmt);//関数sql_errorを実行
}

//全データ取得
$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
//JSONを渡す場合に使う
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);//文字化けしないようにJSON...がある

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>データ一覧</title>
<link href="select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<style>div{padding: 10px; font-size: 16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="login.php">LOGOUT</a>
      <a class="navbar-brand" href="post.php">REGISTER</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->
<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
        <table >
            <tr>
                <th>いつ</th>
                <th>天気</th>
                <th>機嫌</th>
                <th>昼食</th>
                <th>昼寝開始</th>
                <th>昼寝終了</th>
                <th>検温</th>  
            </tr>
            <?php foreach($values as $v) {?>
                <tr>
                    <td><?= h($v["date"]) ?></td>
                    <td><?= h($v["weather"])?></td>
                    <td><?= h($v["kigen"]) ?></td>
                    <td><?= h($v["lunch"]) ?></td>
                    <td><?= h($v["neru"]) ?></td>
                    <td><?= h($v["okita"]) ?></td>
                    <td><?= h($v["taion"]) ?>℃</td>
                    <td><a href="detail.php?id=<?=$v["id"]?>">📝</a></td>
                    <td><img src="./img/del.svg" data-id="<?=$v["id"]?>" class="trash" width="20px" class="pointer-cursor"></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<script>
  // JSON受取
  // const json = JSON.parse('');
  // console.log(json);  

$(document).ready(function(){
  $(".trash").on("click",function(){
    const dataId = $(this).data("id");
    console.log(dataId);
    Swal.fire({
      title: 'データを削除しますか？',
      text: '',
      icon:  'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'はい',
      cancelButtonText: 'キャンセル'
    }).then((result)=>{
      if(result.desmiss !== Swal.dismissReason.cancel){
        ajax(dataId);
      } else {
        Swal.fire(
          'キャンセルしました',
          '',
          'info'
        );
      }
    });
    });
    function ajax(dataId) {
      $.ajax({
        type: "GET",
        url: "delete.php",
        data: { id: dataId },
        dataType: "json"
      })
      .done(function(data){
        if(data.status === "success"){
        Swal.fire({
            title:'削除しました！',
            icon:'success',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            location.reload();
        });
        } else {
          Swal.fire({
            title: '削除に失敗しました',
            icon: 'error',
            timer: 1500,
            showconfirmButton: false
          });
        }
      });
    }
  }); 



//   function getID(id) {
//     const i = getIndex(id);
//     console.log(i);
//     //SweetAlert2
//     Swal.fire({
//       title: `${json[i].date}を削除しますか？`,
//       text: "元に戻せません！",
//       icon: 'warning',
//       showCancelButton: true,
//       confirmButtonColor: '#3085d6',
//       canselButtonColor: '#d33',
//       confirmButtonText: 'はい',
//       canselButtonText: 'キャンセル',
//     }).then((result)=>{
//       if(result.isConfirmed)  {
//         deleteData(id);
//       } else {
//         Swal.fire(
//           'キャンセルしました',
//           '',
//           'success',
//         );
//       }
//     });
//   }
//   function deleteData(id){
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', 'http://localhost/phpkadai04/delete.php?id=' + id, true);
//     xhr.onload = function(){
//       if(xhr.status === 200){
//         Swal.fire(
//           '削除しました！',
//           '',
//           'success'
//         ).then(() => {
//           location.relode();
//         });
//       } else {
//         Swal.fire(
//           'Error',
//           'Failed to delete the file',
//           'error'
//         );
//       }
//     };
//     xhr.send();
//   }
// });
</script>

<!-- <div class="chart">
  <?php
  // //DB接続
  // $pdo = db_conn(); //db_connを呼び出して$pdoで実行する
  // $sql_k = "SELECT * FROM hoiku_table";
  // $stmt_k = $pdo->prepare($sql_k);
  // $status_k = $stmt_k->execute();
  // //データ表示
  // $kigen_data = [0,0,0];
  // if($status_k == false) {
  //   sql_error($stmt_k);//関数sql_errorを実行
  // } else {
  //   while($row = $stmt_k->fetch(PDO::FETCH_ASSOC)) {
  //     $k = $row['kigen'];//$kの値を取得する
  //     // if($k && isset($kigen_data[$k]))
  //     switch($k){
  //       case '良い':
  //         $kigen_data[0]++;
  //         break;
  //       case '普通':
  //         $kigen_data[1]++;
  //         break;
  //       case '悪い':
  //         $kigen_data[2]++;
  //         break;
  //     }
  //   }
  // }
  // $php_data = json_encode($kigen_data,JSON_UNESCAPED_UNICODE);//文字化けしないようにJSON...がある
  ?>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    data1 = JSON.parse('<?= $php_data; ?>');//文字列   
    console.log(data1);

    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayDataTable([
          ['Feeling', 'Count'],
          ['良い', data[0]],
          ['普通', data[1]],
          ['悪い', data[2]]
        ])

        var options = {
          title: 'My Daily Activities',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
    <div id="donutchart" style="width: 900px; height: 500px;"></div>
  </div> -->
</body>
</html>

