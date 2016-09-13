<?php

$mysqli = new mysqli('localhost', 'root', '', 'parajump');
mysqli_query($mysqli, "set names 'UTF8'");
if (mysqli_connect_errno()) {
    die('数据库连接失败');
}
//$conn = @ mysql_connect("localhost", "root", "") or die("数据库链接错误");
//mysql_select_db("parajump", $conn);
//mysql_query("set names 'UTF8'"); //使用GBK中文编码;
?>