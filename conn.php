<?php
$conn = @ mysql_connect("localhost", "root", "") or die("数据库链接错误");
mysql_select_db("parajump", $conn);
mysql_query("set names 'UTF8'"); //使用GBK中文编码;
?>