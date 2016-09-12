<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("conn.php");
$repassword = $_POST['repassword'];
$repasswords = $_POST['repasswords'];
if (isset($_SESSION['admin'])) {
    if ($_POST['submit']) {
        if ($repasscode != $repasscodes) {
            echo "<script language='javascript'>alert('两次密码不一致！');location='resetpass.php';</script>";
        } else {
            $pass = md5($repassword);
            $user = $_SESSION['admin'];
            $sql = "UPDATE `admin` SET `pass`='$pass' where `user` = '$user';";
            $query = mysql_query($sql);
            echo "<script language='javascript'>alert('修改成功！请重新登录');location='login.php';</script>";
            unset($_SESSION['admin']);
        }
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>管理员密码修改</title>
        </head>
        <body bgcolor="#E7D4D4" align="center">
            <div align="right">
                <h3>管理员</h3>
                <a href="/admin.php" style="text-decoration: none">首页</a>|
                <?php if ($_SESSION['admin'] == "admin") { ?><a href="/admin_list.php" style="text-decoration: none">用户管理</a>|<a href="/register.php" style="text-decoration: none">添加用户</a>|<?php } ?>
                    <a href="resetpass.php" style="text-decoration: none">重置密码</a>|
                    <a href="logout.php" style="text-decoration: none">退出</a>
            </div>
            <hr/>
            <h1>重置密码</h1>
            <form method="post" onsubmit="return on_submit()">
                <div style="margin-top: 1.0em;">
                    新&nbsp;密&nbsp;码：<input type="password" name="repassword"/>
                </div>
                <div style="margin-top: 1.0em;margin-bottom: 2.0em;">
                    确认新密码：<input type="password" name="repasswords"/>
                </div>
                <input type="submit" name="submit" value="重置密码">
            </form>
        </body>
    </html>
    <?php
} else
    echo "<script language='javascript'>alert('请登录！');location='login.php';</script>";