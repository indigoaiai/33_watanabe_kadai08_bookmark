<?php

require_once('funcs.php'); //select.phpの一番上に1行追記
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=bm_table;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";
echo '<table border="1"  width="80%" align="center" valign="middle" text-align="center" class=table1>
      <tr>
      <th  >記入日</th>
      <th>書籍名</th>
      <th>書籍URL</th>
      <th>コメント</th>
      <th>価格</th>
      <th></th>
      </tr>';
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
while( $r = $stmt->fetch(PDO::FETCH_ASSOC)){
  $bookname = $bookname . '"'. h($r['bookname']).'",';
  $price1 = $price1 . '"'. h($r['price']) .'",';
    $view .= "<p>";
    $view .= "<table>";
    echo '<tr class =table1>';
    echo '<td>'.$r['registerdate'].'</td>';
    echo '<td>'.$r['bookname'].'</td>';
    echo '<td>'.$r['bookurl'].'</td>';
    echo '<td>'.$r['bookcomment'].'</td>';
    echo '<td>'.$r['price'].'</td>';

    echo '</tr>';
    $view .= "</table>";
    $view .= "</p>";
}
$bookname = trim($bookname,",");
$price1 = trim($price1,",");
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>bookmark</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <!-- <div class="container jumbotron"><?= $view ?></div> -->
    <!-- <div class="container jumbotron"><?= 
    $view 
    ?></div> -->
</div>
<!-- Main[End] -->
<!-- chart --> 
<canvas id="myChart" style="position: relative; height:100px; width:150px"></canvas>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php echo $bookname ?>],//各棒の名前（name)
            // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'ほげ'],//各棒の名前（name)
            datasets: [{
                label: '# of Votes',
                data: [<?php  echo $price1 ?>],//各縦棒の高さ(値段)
                // data: [12, 19, 3, 5, 2, 20],//各縦棒の高さ(値段)
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    </script>

<!-- chart -->

</body>
</html>


