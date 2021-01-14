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

// $id = $_GET['id'];
// //:idはユーザーから送られてきたidデータ
// $sql = 'SELECT * FROM images WHERE image_id=:id';
// $stmt = $pdo->prepare($sql);
// //送られてきたidをバインド変数にする
// $stmt->bindValue(':id', $id, PDO::PARAM_INT);
// $status = $stmt->execute();

// if ($status == false) {
//   // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
//   $error = $stmt->errorInfo();
//   echo json_encode(["error_msg" => "{$error[2]}"]);
//   exit();
// } else {
//   // fetch()で1レコード取得できる////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   $record = $stmt->fetch(PDO::FETCH_ASSOC);
// }

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<body style="max-width: 700px; margin: 0 auto;">
  <!-- <a href="input.php">戻る</a> -->
  <!-- <div style="text-align:center">
    <img src="image.php?id=<?= $record['image_id']; ?>" width="500px" height="auto">
  </div> -->
  <div style="text-align: center; margin-top:30px;">
    <h1>ログイン・登録</h1>
  </div>
  <form action="user-login.php" method="POST" style="width: 60%; margin:0 auto;">
    <table class="table">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td class="col-md-5">Name</td>
          <td class="col-md-5"><input type="text" name="username" value=""></td>
        </tr>
        <tr>
          <td class="col-md-5">Pass</td>
          <td class="col-md-5"><input type="text" name="password" value=""></td>
        </tr>

    </table>
    <button type="submit" class="btn btn-primary">登録</button>
    <button type="submit" name="login" class="btn btn-info">ログイン</button>


  </form>
</body>