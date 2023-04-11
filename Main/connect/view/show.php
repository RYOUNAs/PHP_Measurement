<!DOCTYPE html>
<html lang="jp">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./css/show.css" />
  <title>元サイズ</title>
</head>

<body>
  <div class="img">
    <h1>元サイズイメージ</h1>
    <p>コメント内容：<?php echo $db_text ?></p>
    <img src="<?php echo $img_data_dir; ?>" alt="">
  </div>
</body>

</html>