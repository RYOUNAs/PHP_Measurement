<?php
require_once '../../config.php';

$img_data = '';
$img_data_dir = '';
$db_text = '';


$img_data = $_GET['id'];

$link = mysqli_connect(HOST, USER_ID, PASSWORD, DB_NAME);

$result_list = $link->query('SELECT * FROM msg WHERE id =' . "$img_data");


foreach ($result_list as $key => $value) {
    // print_r('<pre>');
    // print_r($value);
    // print_r('</pre>');
    $img_val = $value;
}
$img_data_dir = DIR_IMG . $img_data . '.' . $value['ext'];
$db_text = $value['msg'];
mysqli_close($link);
require_once './view/show.php';
