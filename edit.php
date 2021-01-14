<?php
session_start();
include("functions.php");
check_session_id();
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

$id = $_GET['id'];
//:idはユーザーから送られてきたidデータ
$sql = 'SELECT * FROM images WHERE image_id=:id';
$stmt = $pdo->prepare($sql);
//送られてきたidをバインド変数にする
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // fetch()で1レコード取得できる////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<body style="max-width: 700px; margin: 0 auto;">
  <a href="input.php">戻る</a>
  <div style="text-align:center">
    <img src="image.php?id=<?= $record['image_id']; ?>" width="500px" height="auto">
  </div>

  <!-- 写真をupすときはenctype="multipart/form-data"が必要みたい -->
  <form action="update.php" method="POST" enctype="multipart/form-data" style="width: 60%; margin:0 auto;">
    <table class="table">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td class="col-md-5">山名:</td>
          <td class="col-md-5"><input type="text" name="name" value="<?= $record["name"] ?>"></td>
        </tr>
        <tr>
          <td>日付:</td>
          <td><input type="date" name="date" value="<?= $record["date"] ?>"></td>
        </tr>
        <tr>
          <td>時間:</td>
          <td><input type="time" step="300" name="time" value="<?= $record["time"] ?>"></td>
        </tr>
        <tr>
          <td>距離:</td>
          <td><input type="text" name="distance" value="<?= $record["distance"] ?>"></td>
        </tr>
        <tr>
          <td>最大標高:</td>
          <td><input type="text" name="maximumAltitude" value="<?= $record["maximumAltitude"] ?>"></td>
        </tr>
        <tr>
          <td>画像を選択</td>
          <td><input type="file" name="image2" required></td>
        </tr>
      </tbody>
      <!-- ユーザーに編集されたくないデータはhiddenで隠す。たとえはidとか -->
      <input type="hidden" name="id" value="<?= $record['image_id'] ?>">
    </table>
    <button type="submit" class="btn btn-primary">保存</button>

  </form>
</body>