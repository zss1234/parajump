<?php
error_reporting(0);
header('Content-Type: text/html; charset=utf-8');
include_once ("conn.php");
$get = $_GET;
$para = http_build_query($get);
if (!empty($get['prd'])) {
    $prd = $get['prd'];
    $sql = "SELECT * FROM `url` where parameter = " . "'$prd'";
    $query = mysql_query($sql);
    $web = mysql_fetch_array($query);
    echo "<script type='text/javascript' >window.location.href='".$web['url']."?".$prd."';</script>";
}

?>