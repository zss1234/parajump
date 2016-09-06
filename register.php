<?php
error_reporting(0);
include_once ("conn.php");
header('Content-Type: text/html; charset=utf-8');
$username = $_POST["username"];
$repasscode = $_POST["repasscode"];
$repasscodes = $_POST["repasscodes"];
$sql = "select *from admin where user='$username'";
$row = mysql_fetch_array(mysql_query($sql));
$n = strlen($username);
$p = strlen($repasscode);
if (!empty($row)) {
    echo "<h3>该用户已经存在</h3>";
} elseif ($n == 0) {
    echo "<h3>请输入用户名</h3>";
} elseif (!($n >= 5 && $n <= 16)) {
    echo "<h3>用户名长度为5-16位</h3>";
} elseif ($p == 0) {
    echo "<h3>请输入密码</h3>";
} elseif (!($p >= 5 && $p <= 16)) {
    echo "<h3>密码长度为5-16位</h3>";
} elseif ($repasscode != $repasscodes) {
    echo "<h3>两次密码不一致</h3>";
} else {
    $conn = mysql_connect("localhost", "root", "") or die("数据库连接失败");
    mysql_select_db("parajump");
    mysql_query("set names utf8");
    $pass = md5($repasscode);
    $sql = "insert into admin(user,pass)values('{$username}','{$pass}')";
    mysql_query($sql);
    $row = mysql_affected_rows($conn);
    if ($row > 0) {
        echo "<script type='text/javascript' >alert('注册成功请登录');window.location.href='login.php';</script>";
    } else {
        echo "<script type='text/javascript' >alert('注册失败请重新注册');window.location.href='register.php';</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>参数跳转后台登录</title>
    </head>
    <body bgcolor="#E7D4D4" align="center">
        <form method="post">
            <div align="center">
                <div style="margin-top: 1.0em">账&nbsp;&nbsp;号：<input type="text" name="username" value="在这里输入用户名...." onfocus="if (this.value == '在这里输入用户名....') {
                        this.value = '';
                    }"  onblur="if (this.value == '') {
                                this.value = '在这里输入用户名....';
                            }" />
                </div>
                <div style="margin-top: 1.0em">密&nbsp;&nbsp;码：<input type="password" name="repasscode" value="在这里输入密码..." onfocus="if (this.value == '在这里输入密码...') {
                        this.value = '';
                    }"  onblur="if (this.value == '') {
                                this.value = '在这里输入密码...';
                            }" />
                </div>
                <div style="margin-top: 1.0em">确认密码：<input type="password" name="repasscodes" value="在这里确认密码...." onfocus="if (this.value == '在这里确认密码....') {
                        this.value = '';
                    }"  onblur="if (this.value == '') {
                                this.value = '在这里确认密码....';
                            }" />
                </div>
                <input style="margin-top: 1.0em;" type="submit" name="register" value="注册">
            </div>
        </form>
    </body>
</html>
