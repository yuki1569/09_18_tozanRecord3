<?php
// DB接続情報//作成したデータベース名を指定
$dbn = 'mysql:dbname=gsacf_d07_18;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

print_r($_POST) . PHP_EOL;
print_r($_FILES) . PHP_EOL;
// exit();
if (
  //isset($var) varが存在してull以外の値をとればtrue,そうでなければfalse
  //ここでは!なので値がセットされていない場合となる
  !isset($_POST['name']) ||
  $_POST['name'] == '' ||
  !isset($_POST['date']) ||
  $_POST['date'] == ''
) {
  exit('ParamError');
}


// $image_name = $_FILES['image']['name'];
// $image_type = $_FILES['image']['type'];
// $image_content = file_get_contents($_FILES['image']['tmp_name']);
// $image_size = $_FILES['image']['size'];

$image = uniqid(mt_rand(), true); //ファイル名をユニーク化
$image .= '.' . substr(strrchr($_FILES['image']['name'], '.'), 1); //アップロードされたファイルの拡張子を取得
$file = "images/$image";
$name = $_POST['name'];
$date = $_POST['date'];
$time = $_POST['time'];
$distance = $_POST['distance'];
$maximumAltitude = $_POST['maximumAltitude'];

$sql = 'INSERT INTO images(image, created_at,name,date,time,distance,maximumAltitude)  VALUES (:image_name, :image_type, :image_content, :image_size, now(),:name,:date,:time,:distance,:maximumAltitude)';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':image_name', $image_name, PDO::PARAM_STR);
$stmt->bindValue(':image_type', $image_type, PDO::PARAM_STR);
$stmt->bindValue(':image_content', $image_content, PDO::PARAM_STR);
$stmt->bindValue(':image_size', $image_size, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':time', $time, PDO::PARAM_STR);
$stmt->bindValue(':distance', $distance, PDO::PARAM_STR);
$stmt->bindValue(':maximumAltitude', $maximumAltitude, PDO::PARAM_STR);
$stmt->execute();
// }
unset($pdo);
header('Location:input.php');
exit();

// 失敗時にエラーを出力し，成功時は登録画面に戻る
if ($status == false) {
  $error = $stmt->errorInfo();
  // データ登録失敗次にエラーを表示
  exit('sqlError:' . $error[2]);
} else {
  // 登録ページへ移動
  header('Location:user-login.php');
}
