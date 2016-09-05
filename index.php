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
//    echo "<script type='text/javascript' >window.location.href='" . $web['url'] . "?" . $para . "';</script>";
}
if(strpos($para, "prd") === false){
    $url = '';
} else if (strpos($para, "&") === false) {
    $url = $web['url'];
} else {
//    $parameter = substr($para, strpos($para, "&") + 1);
//    $url = $web['url'] . "?" . $parameter;
    $url = preg_replace('/prd=[\w]+&/', "", $web['url'] . "?" . $para);
}
//var_dump($url);
header("location:$url");
exit;
?>