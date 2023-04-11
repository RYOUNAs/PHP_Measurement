<!DOCTYPE html>
<html lang="jp">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/style.css" />
  <title>画像サイズ自動編集サイト</title>
</head>

<body>
  <header>
    <h1>画像採寸サイト</h1>
    <div>
      <div>
        <h2 class="error"><?php echo $img_error; ?></h2>
        <form method="POST" action="./index.php" enctype="multipart/form-data">
          <h2>メッセージ内容</h2>
          <input type="text" placeholder="" name="msg" value="<?php echo $title_val; ?>">
          <h2>アップロード画像</h2>
          <input type="file" name="img" class="fileinput" multiple="multiple">
          <p class="error"><?php echo $file_error; ?></p>
          <button type="submit" class="button" name="send" value="form_simple1">送信</button>
        </form>
      </div>
      <div>
        <table>
          <tr>
            <th class="tb-img">画像</th>
            <th>メッセージ</th>
          </tr>
          <?php foreach ($result_list as $row) : ?>
            <tr>
              <td class="img"><a href="./show.php?id=<?= "{$row['id']}" ?>"><img src="<?= DIR_IMG . 'thumb_' . "{$row['id']}" ?>.<?= "{$row['ext']}"; ?>" alt="<?= "{$row['id']}" ?>"></a></td>
              <td><?= "{$row['msg']}" ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
  </header>
</body>

</html>