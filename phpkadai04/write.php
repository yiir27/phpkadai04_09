<?php
//文字を作るのに変数を作成
$date = $_POST["date"];
$weather = $_POST["weather"];
$kigen = $_POST["kigen"];
$lunch = $_POST["lunch"];
$neru = $_POST["neru"];
$okita = $_POST["okita"];
$taion = $_POST["taion"];
$c = ",";
//書き込みたい文字作成 .は接続
$str = $date.$c.$weather.$c.$kigen.$c.$lunch.$c.$neru.$c.$okita.$c.$taion;

//javascriptに渡す
$jt = json_encode($taion,JSON_UNESCAPED_UNICODE);
$jd = json_encode($date,JSON_UNESCAPED_UNICODE);

// ファイル書き込み
if($_SERVER["REQUST_METHOD"] == "POST") {
    $file = fopen("data/hoiku.txt","a"); //ファイル追加書き込み
    fwrite($file, $str."\n");
    fclose($file);
    
    header("Location:read.php");
    exit;
}


// $form = $POST["form"];

?>

<html>
<head>
<meta charset="UTF-8">
<title>保育記録</title>
<link rel="stylesheet" herf="./style.css">
</head>
<body>
<?php
    $file = fopen('data/hoiku.txt','r');
    $array = [];
    while(($txt = fgets($file)) !== false) {
        $ar = explode(",", $txt);
        $date = $ar[0]++;
        $weather = $ar[1]++;
        $kigen = $ar[2]++;
        $lunch = $ar[3]++;
        $neta = $ar[4]++;
        $okita = $ar[5]++;
        $taion = $ar[6]++;
    }
?>
npm install chart.js



<form>
    <table border="1" width="100%">
        <tr>
            <th>いつ</th>
            <th>天気</th>
            <th>機嫌</th>
            <th>昼食</th>
            <th>昼寝開始</th>
            <th>昼寝終了</th>
            <th>検温</th>
        </tr>
        <tr>
            <td><?= $date ?></td>
            <td><?= $weather ?></td>
            <td><?= $kigen ?></td>
            <td><?= $lunch ?></td>
            <td><?= $neta ?></td>
            <td><?= $okita ?></td>
            <td><?= $taion ?>Ｃ°</td>
        </tr>
    </table>
</form>
<a href="post.php">戻る</a>

<canvas id="t_chart"></canvas>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script>
let t = JSON.parse('<?= $jt ?>');
let d = JSON.parse('<?= $date ?>');

const ctx = document.getElementById("t_chart");
const t_chart = new Chart(ctx, {
    type: 'line',
    data: {
        labers: d,
        datasets: [
            {
                label: '体温',
                data: t,
                borderColor: "rgba(255,0,0,1)",
                backgroundColor: "rgba(0,0,0,0)"
            }
        ],
    },
    options: {
      title: {
        display: true,
        text: '検温グラフ'
      },
      scales: {
        yAxes: [{
            ticks: {
                suggestedMax: 38,
                suggestedmin: 36,
                stepSize: 0.5,
                callback: function(value, index, values){
                    return value + 'cm'
                }
            }
        }]
      },
    }
});
</script>
</body>
</html>


