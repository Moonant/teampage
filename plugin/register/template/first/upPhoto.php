<?php
header("content-type:text/html; charset=utf-8");
$name = $_FILES['file']['name'];
$type = $_FILES['file']['type'];
$size = $_FILES['file']['size'];
$tmp_name = $_FILES['file']['tmp_name'];
$error = $_FILES['file']['error'];
$al_type = array('image/jpg','image/jepg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
$al_size = 1000000;
$datetime = date("YmdHis");

if($error>0){
  echo "error:".$error;
  exit();
}

if(!in_array($type,$al_type)){
  echo "error:上传图片类型错误";
  exit();
}

if($size>$al_size){
  echo "error:上传图片过大";
  exit();
}

move_uploaded_file($tmp_name,"upload/".$datetime);
echo "success:".$datetime; 

?>
