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
if (strpos($para, "prd") === false) {
    $url = '';
} else if (strpos($para, "&") === false) {
    $url = $web['url'];
    header("location:$url");
    exit;
} else {
//    $parameter = substr($para, strpos($para, "&") + 1);
//    $url = $web['url'] . "?" . $parameter;
    $url = preg_replace('/prd=[\w]+&/', "", $web['url'] . "?" . $para);
    header("location:$url");
    exit;
}
//var_dump($url);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>参数管理</title>
    </head>
    <body bgcolor="#E7D4D4" align="center">
        <h2 >参数管理</h2>
        <a href="login.php"><input style="margin-top:100px;" type="submit" name="login" value="管理员登录"/></a>
    </body>
</html>