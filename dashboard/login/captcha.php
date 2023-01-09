<?php
$length = 6;

$randomletter = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, $length);

  $_SESSION['captcha_code']=$randomletter;
?>