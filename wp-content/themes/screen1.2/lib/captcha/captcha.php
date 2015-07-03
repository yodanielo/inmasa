<?php
session_start();

/*************** create string ***************/
$string = strtoupper(substr(md5(microtime() * mktime()),0,8));
$_SESSION['captchatxt'] = md5($string);

/*************** create image ***************/
// dimensions
$w = 150;
$h = 40;
if(isset($_GET['w']) && !empty($_GET['w']) && is_numeric($_GET['w'])) $w = $_GET['w'];
if(isset($_GET['h']) && !empty($_GET['h']) && is_numeric($_GET['h'])) $h = $_GET['h'];
// create empty image
$img = imagecreatetruecolor($w, $h);
$bg = imagecolorallocate($img,rand(150,255),rand(150,255),rand(150,255));
imagefill($img, 0, 0, $bg);

/*************** add text ***************/
// random textcolour
$txt1 = imagecolorallocate($img,rand(75,150),rand(75,150),rand(75,150));
// shadow colour
$txt2 = imagecolorallocate($img, 75, 75, 75);
// random lines
for ($i=0;$i < 10;$i++) {
  $line = imagecolorallocate($img,rand(150,255),rand(150,255),rand(150,255));
  imageline($img,rand(-50,$w),rand(-50,$h),rand($w/2,$w+50),rand($h/2,$h+50),$line);
}
// choose font
$font = 'ARLRDBD.TTF';
// calculate x and y for centering
$arr = imagettfbbox(18, -1, $font, $string);
$x = (imagesx($img)-($arr[2] - $arr[0]))/2;
$y = (imagesy($img)-($arr[7] - $arr[1]))/2.4;
// place shadow
imagettftext($img, 18, -3, $x+2, $y+2, $txt2, $font, $string);
// place text
imagettftext($img, 18, -3, $x, $y, $txt1, $font, $string);
// show CAPTCHA
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
?>