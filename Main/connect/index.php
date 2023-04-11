<?php

require_once '../../config.php';

// ⇓===================⇓変数管理⇓===================⇓


$file_error = '';
$img_error = '';

// エラー表示用

$title_val = '';
$msg = '';

$file_id = '';
$format = '';
$error_img_extention = '0';

$before_img_width = '';
$before_img_height = '';
$canvas_width = '';
$canvas_height = '';
$ideal_img_width = '';
$ideal_img_height = '';
$optimum_img_width = '';
$optimum_img_hight = '';

$calculation_img_width = '';
$calculation_img_hight = '';
$coordinate_img_width = '';
$coordinate_img_hight = '';


$result_list = '';

// ⇑===================⇑変数管理⇑===================⇑

// ⇓===============⇓画像形式確認部⇓===============⇓

// print_r('<pre>');
// print_r($_FILES['img']);
// print_r('</pre>');

if (isset($_FILES['img'])) {
    if ($_FILES['img']['error'] == 0) {
        // move_uploaded_file($upload_file['tmp_name'], $upload_file_data);



        // $img_size = getimagesize($_FILES['img']['tmp_name']);

        // echo $_FILES['img']['name'] . '<br>';

        $img_file_type = $_FILES['img']['type'];

        // echo $img_file_type;

        if ($img_file_type == 'image/gif') {
            $format = 'gif';
            // echo 'この画像は:gif<br>';
        } elseif ($img_file_type == 'image/jpeg') {
            $format = 'jpg';
            // echo 'この画像は:jpeg<br>';
        } elseif ($img_file_type == 'image/png') {
            $format = 'png';
            // echo 'この画像は:png<br>';
        } else {
            $img_error = 'この形式には対応しておりません';
            $error_img_extention = 1;
        }

        // ⇑===============⇑画像形式確認部⇑===============⇑

        // ⇓===============⇓DBデータ登録⇓===============⇓


        if (isset($_POST['msg'])) {
            $msg = $_POST['msg'];
        }

        $file_img_data = $_FILES['img'];

        //画像データ確認用
        // print_r('<pre>');
        // print_r($file_img_data);
        // print_r('</pre>');


        if ($error_img_extention == 0) {


            $link = mysqli_connect(HOST, USER_ID, PASSWORD, DB_NAME);
            mysqli_set_charset($link, 'utf8');
            mysqli_query(
                $link,
                // "INSERT INTO `msg` (`msg`, `ext`) VALUES('永山先生ラブ', 'jpg');"
                "INSERT INTO msg (`msg`, `ext`) VALUES('" . $msg . "', '" . $format . "');"
            );
            // printf("New record has ID %d.\n", mysqli_insert_id($link));

            $file_id = mysqli_insert_id($link);

            mysqli_close($link);
        }


        // ⇑===============⇑DBデータ登録⇑===============⇑


        // ⇓===============⇓画像登録⇓===============⇓

        if ($error_img_extention == 0) {
            move_uploaded_file($_FILES['img']['tmp_name'], DIR_IMG . $file_id . '.' . $format);


            $img_size = getimagesize(DIR_IMG . $file_id . '.' . $format);
            // echo '<hr><br>';
            // print_r('<pre>');
            // print_r($img_size);
            // print_r('</pre>');

            // ⇑===============⇑画像登録⇑===============⇑

            // ⇓===============⇓画像縮小⇓===============⇓
            // ⇓-------------⇓画像縮小計算式⇓-------------⇓


            $before_img_width = $img_size[0];
            $before_img_height = $img_size[1];
            $canvas_width = 200;
            $canvas_height = 150;
            $ideal_img_width = $canvas_width;
            $ideal_img_height = $canvas_height;


            $optimum_img_width = floor($canvas_height / $before_img_height * $before_img_width);
            $optimum_img_hight = floor($canvas_width / $before_img_width * $before_img_height);


            if ($optimum_img_width <= $canvas_width) {
                $calculation_img_width = $optimum_img_width;
                $calculation_img_hight = $canvas_height;
                // $coordinate_img_width = floor($canvas_width - $optimum_img_width) / 2;
                // $coordinate_img_hight = 0;
                // echo '枠に収まった、高さに合わせた場合の横幅：' . $optimum_img_width . '✕' . floor($canvas_height) . '<br>';
            } elseif ($optimum_img_hight <= $canvas_height) {
                $calculation_img_width = $canvas_width;
                $calculation_img_hight = $optimum_img_hight;
                // $coordinate_img_width = 0;
                // $coordinate_img_hight = floor($canvas_height - $optimum_img_hight) / 2;
                // echo '枠に収まった、横幅に合わせた場合の高さ：' . floor($canvas_width) . '✕' . $optimum_img_hight . '<br>';
            }

            // echo '横幅の半分：' . $coordinate_img_width . '<br>';
            // echo '高さの半分' . $coordinate_img_hight . '<br>';
            // echo '理想ー横幅：' . $canvas_width . '<br>';
            // echo '理想ー高さ：' . $canvas_height . '<br>';
            // echo '理想のドット数：' . $canvas_width * $canvas_height . '<br>';
            // echo 'アップロードー横幅：' . $before_img_width . '<br>';
            // echo 'アップロードー高さ：' . $before_img_height . '<br>';
            // echo '横幅に合わせた場合の高さ：' . floor($canvas_width) . '✕' . $optimum_img_hight . '<br>';
            // echo '横幅に合わせた場合ののドット数：' . floor($canvas_width) * $optimum_img_hight . '<br>';
            // echo '高さに合わせた場合の横幅：' . $optimum_img_width . '✕' . floor($canvas_height) . '<br>';
            // echo '横幅に合わせた場合ののドット数：' . $optimum_img_width * floor($canvas_height) . '<br>';




            // ⇑-------------⇑画像縮小計算式⇑-------------⇑

            switch ($format) {
                case 'gif':
                    $file_name = mb_convert_encoding(DIR_IMG . $file_id . '.' . $format, 'sjis', 'utf8');

                    $img_in = imagecreatefromgif($file_name);
                    $img_out = imagecreatetruecolor($calculation_img_width, $calculation_img_hight);

                    imagealphablending($img_out, false);
                    imagesavealpha($img_out, true);
                    imageCopyResampled($img_out, $img_in,  0, 0, 0, 0, $calculation_img_width, $calculation_img_hight, $before_img_width, $before_img_height);
                    Imagegif($img_out, DIR_IMG . 'thumb_' . $file_id . '.gif');

                    imagedestroy($img_in);
                    imagedestroy($img_out);
                    break;


                case 'jpg':
                    $file_name = mb_convert_encoding(DIR_IMG . $file_id . '.' . $format, 'sjis', 'utf8');

                    $img_in = imagecreatefromjpeg($file_name);
                    $img_out = imagecreatetruecolor($calculation_img_width, $calculation_img_hight);

                    imagealphablending($img_out, false);
                    imagesavealpha($img_out, true);
                    imageCopyResampled($img_out, $img_in, 0, 0, 0, 0, $calculation_img_width, $calculation_img_hight, $before_img_width, $before_img_height);
                    Imagejpeg($img_out, DIR_IMG . 'thumb_' . $file_id . '.jpg');

                    imagedestroy($img_in);
                    imagedestroy($img_out);
                    break;


                case 'png':
                    $file_name = mb_convert_encoding(DIR_IMG . $file_id . '.' . $format, 'sjis', 'utf8');

                    $img_in = imagecreatefrompng($file_name);
                    $img_out = imagecreatetruecolor($calculation_img_width, $calculation_img_hight);

                    imagealphablending($img_out, false);
                    imagesavealpha($img_out, true);
                    imageCopyResampled($img_out, $img_in, 0, 0, 0, 0, $calculation_img_width, $calculation_img_hight, $before_img_width, $before_img_height);
                    Imagepng($img_out, DIR_IMG . 'thumb_' . $file_id . '.png');

                    imagedestroy($img_in);
                    imagedestroy($img_out);
                    break;


                default:
            };
            // ⇑===============⇑画像縮小⇑===============⇑
        }
    } else {
        $img_error = 'ファイルを選択してください';
    }
}
$link = mysqli_connect(HOST, USER_ID, PASSWORD, DB_NAME);

$result_list = $link->query('SELECT * FROM msg ORDER BY created_at DESC');
require_once './view/index.php';
