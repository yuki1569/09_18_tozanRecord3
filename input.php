<?php
session_start();
include("functions.php");
$pdo = connect_to_db();
check_session_id();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  // 画像を取得
  $sql = 'SELECT * FROM tozan_record_table ORDER BY created_at DESC';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $images = $stmt->fetchAll();
} else {
  exit();
}
unset($pdo);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>Image Test</title>

  <!DOCTYPE html>
  <html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登山記録</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <style>
      .table {
        /* border-collapse: collapse; */
        table-layout: fixed;
      }

      .table th,
      .table td {
        /* border: 1px solid #CCCCCC; */
        padding: 5px 10px;
        text-align: left;
      }

      .table th {
        background-color: #FFFFFF;
      }
    </style>

  </head>


<body>
  <a href="logout.php">logout</a>
  <div class="container mt-5">
    <!-- <div id="res">戻り値が表示される</div> -->
    <div class="row">
      <div class="col-md-8 border-right">
        <ul class="list-unstyled">
          <?php for ($i = 0; $i < count($images); $i++) : ?>
            <li class="media mt-5">

              <!-- <img class="image-button" src="image.php?id=<?= $images[$i]['image_id']; ?>" data-id="<?= $images[$i]['image_id'] ?>" width="500px" height="auto" class="mr-3"> -->

              <a href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">
                <img src="images/<?php echo $images[$i]['image_name']; ?>" data-id="<?= $images[$i]['image_id'] ?>" width="500px" height="auto" class="mr-3">
              </a>

              <div class="media-body">
                <h5><?= $images[$i]['name']; ?> (<?= $images[$i]['maximumAltitude']; ?>m)</h5>
                <h5>日時 <?= $images[$i]['date']; ?></h5>
                <h5>活動時間 <?= $images[$i]['time']; ?></h5>
                <h5>歩いた距離 <?= $images[$i]['distance'] / 1000; ?>km</h5>
                <!-- 削除ボタン -->
                <a href="javascript:void(0);" onclick="var ok = confirm('削除しますか？'); if (ok) location.href='delete.php?id=<?= $images[$i]['image_id']; ?>'">
                  <i class="far fa-trash-alt"></i> 削除</a>
                <!-- 編集機能 -->
                <a href="edit.php?id=<?= $images[$i]["image_id"]; ?>">edit</a>

              </div>
            </li>
          <?php endfor; ?>
        </ul>
      </div>
      <div class="col-md-4 pt-4 pl-4">

        <form action="create.php" method="post" enctype="multipart/form-data">
          <a href="data.php">集計画面</a><br>
          <h3>登山記録</h3>

          <table class="table">
            <thead>

            </thead>
            <tbody>
              <tr>
                <td>山名:</td>
                <td><input type="text" name="name"></td>
              </tr>
              <tr>
                <td>日付:</td>
                <td><input type="date" name="date"></td>
              </tr>
              <tr>
                <td>時間:</td>
                <td><input type="time" value="00:00:00" step="300" name="time"></td>
              </tr>
              <tr>
                <td>距離:</td>
                <td><input type="text" name="distance"></td>
              </tr>
              <tr>
                <td>最大標高:</td>
                <td><input type="text" name="maximumAltitude"></td>
              </tr>
              <tr>
                <td>画像を選択</td>
                <td><input type="file" name="image" required></td>
              </tr>
            </tbody>

          </table>
          <button type="submit" class="btn btn-primary">保存</button>


        </form>

      </div>
    </div>
  </div>

  <!-- モーダル -->
  <div class="modal carousel slide" id="lightbox" tabindex="-1" role="dialog" data-ride="carousel">
    <div class="modal-dialog modal-dialog-centered" role="document">

      <div class="modal-content">

        <div class="modal-body">

          <ol class="carousel-indicators">
            <li data-target="#lightbox" data-slide-to="0" class="active"></li>
            <li data-target="#lightbox" data-slide-to="1" class="active"></li>
          </ol>

          <div class="carousel-inner">
            <!-- <div class="carousel-item active">
              <img src="image.php?id=<?= $images[0]['image_id']; ?>" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="image.php?id=<?= $images[0]['image_id']; ?>" class="d-block w-100">
              <p><?= $images[0]['name']; ?></p>
            </div>
            <div class="carousel-item">
              <img src="image.php?id=<?= $images[0]['image_id']; ?>" class="d-block w-100">
              <p><?= $images[0]['time']; ?></p>
            </div> -->
          </div>
          <ol class="carousel-indicators">
            <?php for ($i = 0; $i < count($images); $i++) : ?>
              <li data-target="#lightbox" data-slide-to="<?= $i; ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
            <?php endfor; ?>
          </ol>

          <div class="carousel-inner">
            <?php for ($i = 0; $i < count($images); $i++) : ?>
              <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                <img src="image.php?id=<?= $images[$i]['image_id']; ?>" class="d-block w-100">
                <p><?= $images[$i]['name']; ?></p>
              </div>
            <?php endfor; ?>
          </div>

          <a class="carousel-control-prev" href="#lightbox" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#lightbox" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
    //ajaxテスト用※使用してません
    $(".image-button").on('click', function(event) {
      id = $(this).data('id');
      console.log(id);
      $.ajax({
        type: "POST",
        url: "js-php.php",
        data: {
          "id": id
        },
        datatype: "json"
      }).done(function(data) {

        //値を取り出す
        $("#res").append('<p>値を個別に取り出す');
        console.log(data);

      }).fail(function(XMLHttpRequest, textStatus, error) {
        alert(error);
      });
    });
  </script>

  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>