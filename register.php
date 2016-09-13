<?php
error_reporting(0);
session_start();
include_once ("connect.php");
header('Content-Type: text/html; charset=utf-8');
$username = $_POST["username"];
$repasscode = $_POST["repasscode"];
$repasscodes = $_POST["repasscodes"];
$sql = "select * from admin where user='$username'";
$query = $mysqli->query($sql);
$row = $query->fetch_array();
//$row = mysql_fetch_array(mysql_query($sql));
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
    $pass = md5($repasscode);
    $sql = "insert into admin(user,pass)values('{$username}','{$pass}')";
    $query = $mysqli->query($sql);
    $row = mysqli_affected_rows($mysqli);
    if ($row > 0) {
        echo "<script type='text/javascript' >alert('添加用户成功');window.location.href='admin.php';</script>";
    } else {
        echo "<script type='text/javascript' >alert('添加用户失败');window.location.href='register.php';</script>";
    }
}
if ($_SESSION['admin'] != "admin") {
    echo "<script type='text/javascript' >window.location.href='admin.php';</script>";
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
            <div align="right">
                <h3>管理员</h3>
                <a href="/admin.php" style="text-decoration: none">首页</a>|
                <?php if ($_SESSION['admin'] == "admin") { ?><a href="/admin_list.php" style="text-decoration: none">用户管理</a>|<a href="/register.php" style="text-decoration: none">添加用户</a>|<?php } ?>
                    <a href="resetpass.php" style="text-decoration: none">重置密码</a>|
                    <a href="logout.php" style="text-decoration: none">退出</a>
            </div>
            <hr/>
            <div align="center">
                <h4>添加用户</h4>
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
