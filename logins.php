<?php
error_reporting(0);
include_once ("connect.php");
//获取用户输入
$username = $_POST['username'];
$passcode = md5($_POST['passcode']);
//执行SQL语句获得Session的值
//$query = mysql_query("SELECT * FROM  admin WHERE user = '$username' and pass = '$passcode'")
//        or die("SQL链接失败");
        $query = $mysqli->query("SELECT * FROM  admin WHERE user = '$username' and pass = '$passcode'");
//判断用户是否存在，密码是否正确
//if ($_POST['submit']) {
//    if ($row = mysql_fetch_array($query)) {
//        session_start();       //标志Session的开始
//        //判断用户的权限信息是否有效，如果为1或0则说明有效
//        if ($row['user']) {
//            $_SESSION['admin'] = $row['user'];
//            $_SESSION['adminpass'] = $row['pass'];
//            echo "<script language='javascript'>location='admin.php';</script>";
//        } else {         //如果权限信息无效输出错误信息
//            echo "用户权限信息不正确";
//        }
//    } else {          //如果用户名和密码不正确，则输出错误
//        echo "<script language='javascript'>alert('用户名或密码错误！');location='login.php';</script>";
//    }
//}
if ($_POST['submit']) {
    if ($row = $query->fetch_array()) {
        session_start();       //标志Session的开始
        //判断用户的权限信息是否有效，如果为1或0则说明有效
        if ($row['user']) {
            $_SESSION['admin'] = $row['user'];
            $_SESSION['adminpass'] = $row['pass'];
            echo "<script language='javascript'>location='admin.php';</script>";
        } else {         //如果权限信息无效输出错误信息
            echo "用户权限信息不正确";
        }
    } else {          //如果用户名和密码不正确，则输出错误
        echo "<script language='javascript'>alert('用户名或密码错误！');location='login.php';</script>";
    }
}
mysql_close($conn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>后台登录</title>
    </head>
    <body bgcolor="#E7D4D4" align="center">
        <h2>登录</h2>

        <form method="post">
            <div style="margin-top: 1.0em">
                账号：<input type="text" name="username" value="在这里输入用户名...." onfocus="if (this.value == '在这里输入用户名....') {
                            this.value = '';
                        }"  onblur="if (this.value == '') {
                                    this.value = '在这里输入用户名....';
                                }" />
            </div>
            <div style="margin-top: 1.0em;margin-bottom: 2.0em;">
                密码：<input type="password" name="passcode" value="在这里输入密码...." onfocus="if (this.value == '在这里输入密码....') {
                            this.value = '';
                        }"  onblur="if (this.value == '') {
                                    this.value = '在这里输入密码....';
                                }" />
            </div>
            <input type="submit" name="submit" value="登陆">
        </form>
    </body>
</html>
