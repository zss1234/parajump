<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
unset($_SESSION['admin']);
echo "<script language='javascript'>alert('注销成功！');location='login.php';</script>";
?>