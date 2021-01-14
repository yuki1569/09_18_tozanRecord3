<?php
session_start();
include("functions.php");
check_session_id();
// DB接続情報//作成したデータベース名を指定
$dbn = 'mysql:dbname=gsacf_d07_18;
charset=utf8;
port=3306;
host=localhost';
$user = 'root';
$pwd = '';

// DB接続
try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

$id = $_POST['id'];

var_dump($_FILES['image2']['name']);
var_dump($_FILES['image2']['type']);
var_dump($_FILES['image2']['tmp_name']);
var_dump($_FILES['image2']['size']);
var_dump($_POST['name']);

$image_name = $_FILES['image2']['name'];
$image_type = $_FILES['image2']['type'];
$image_content = file_get_contents($_FILES['image2']['tmp_name']);
$image_size = $_FILES['image2']['size'];
$name = $_POST['name'];
$date = $_POST['date'];
$time = $_POST['time'];
$distance = $_POST['distance'];
$maximumAltitude = $_POST['maximumAltitude'];


// データ登録SQL作成
//update_atは更新した時間を入れる
$sql = "UPDATE images
            SET image_name=:image_name,
                  image_type=:image_type,
                  image_content=:image_content,
                  image_size=:image_size,
                  name=:name,
                  date=:date,
                  time=:time,
                  distance = :distance,
                  maximumAltitude=:maximumAltitude,
                  created_at=sysdate()
            WHERE image_id=:id";

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
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
// unset($pdo);
header('Location:input.php');
exit();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:input.php");
  exit();
}
