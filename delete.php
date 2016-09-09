<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("conn.php");

if(isset($_SESSION['admin'])){
    $del = $_POST['del'];
    var_dump($del);
    foreach ($del as $value) {
        if (!empty($value['id'])) {
            $id = $value['id'];
            $sql = "delete from `url` WHERE id=$id";
            mysql_query($sql);
            echo "<script language=\"javascript\">alert('删除成功');location='admin.php';</script>";
        }
    }
}