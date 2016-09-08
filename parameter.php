<?php

error_reporting(0);
include_once ("conn.php");
header('Content-Type: text/html; charset=utf-8');
//获得来自 URL 的 q 参数
$q = $_GET["q"];
$sql = "select parameter from url where parameter='$q'";
$row = mysql_fetch_array(mysql_query($sql));
//如果 q 大于 0，则查找数组中的所有提示
if (strlen($q) > 0) {
    $hint = $row[parameter];
}
if ($hint == "") {
    $response = "";
} else {
    $response = "该参数已经存在";
}
//输出响应
echo $response;
?>
