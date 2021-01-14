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

$id = filter_input(INPUT_POST, 'id');
// （DBから取得したり、何かしらの）2次元配列
$sql = 'SELECT * FROM images2 WHERE id=:id';
$stmt = $pdo->prepare($sql);
//送られてきたidをバインド変数にする
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// var_dump($status);

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // fetch()で1レコード取得できる////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
  header("Content-type: application/json; charset=UTF-8");
  echo json_encode($record);
  exit;
}


// $list = array(

//   0 => array(
//     'id' => $id + 10,
//     'name' => 'お名前',
//     'hoge' => 'ほげ'
//   ),
//   1 => array(
//     'id' => $id + 20,
//     'name' => 'ムームー',
//     'hoge' => 'hogehoge'
//   ),
//   2 => array(
//     'id' => $id + 30,
//     'name' => 'X',
//     'hoge' => 'ホゲホゲホゲ'
//   )
// );



