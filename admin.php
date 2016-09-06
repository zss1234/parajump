<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("conn.php");
if (isset($_SESSION['admin'])) {
    if ($_POST['sub']) {
        if (!empty($_POST['parameter'])) {
            if (!empty($_POST['url'])) {
                $isexist = "select * from `url` where parameter = '$_POST[parameter]'";
                $exist = mysql_query($isexist);
                $row = mysql_fetch_array($exist);
                if (!empty($row)) {
                    echo "<script language=\"javascript\">alert('该参数已经存在了');location='admin.php';</script>";
                    exit;
                }
                $sql = "INSERT INTO `url` (`id`, `parameter`, `url` ) VALUES (NULL, '$_POST[parameter]', '$_POST[url]');";
                mysql_query($sql);
                echo "<script language=\"javascript\">alert('发布成功');location='admin.php';</script>";
            } else {
                echo "<script language=\"javascript\">alert('必须添加url');</script>";
            }
        } else {
            echo "<script language=\"javascript\">alert('必须添加参数');</script>";
        }
    }
    if ($_POST['delete']) {
        $del = $_POST['del'];
        foreach ($del as $value) {
            if (!empty($value['id'])) {
                $id = $value['id'];
                $sql = "delete from `url` WHERE id=$id";
                mysql_query($sql);
                echo "<script language=\"javascript\">alert('删除成功');location='admin.php';</script>";
            }
        }
    }

    if ($_POST['edit']) {
        $del = $_POST['del'];
        foreach ($del as $value) {
            if (!empty($value['id'])) {

                $para = $value['parameter'];
                $urls = $value['url'];
                $id = $value['id'];
                $sql = "UPDATE `url` SET `parameter`='$para' , `url`='$urls'  WHERE id=$id";
                mysql_query($sql);
                echo "<script language=\"javascript\">alert('修改成功');location='admin.php';</script>";
            }
        }
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>添加跳转参数以及跳转地址</title>
        </head>
        <body bgcolor="#E7D4D4" align="center">

            <form method="post">
                <div align="right">
                    <h3>管理员</h3>
                    <a href="resetpass.php">重置密码</a>|
                    <a href="logout.php">退出</a>
                </div>
                <div style="margin-bottom: 50px;">
                    <h4>添加跳转参数</h4>
                    
                    <input type="text" name="parameter" value="请输入参数...." onfocus="if (this.value == '请输入参数....') {
                                this.value = '';
                            }"  onblur="if (this.value == '') {
                                        this.value = '请输入参数....';
                                    }" />
                    <input type="text" name="url" value="在这里输入跳转地址...." onfocus="if (this.value == '在这里输入跳转地址....') {
                                this.value = '';
                            }"  onblur="if (this.value == '') {
                                        this.value = '在这里输入跳转地址....';
                                    }" />
                    <input type="submit" name="sub" value="提交">
                </div>
                
                <hr/>
                <div>
                    <h4>跳转参数</h4>
                    <?php
                    $sqll = "SELECT * FROM `url` ";
                    $no = "admin.php?";
                    @$page = $_GET['page'];
                    if ($page == null)
                        $page = 1;
                    $psize = 20; //每页记录数
                    $str = "$sqll";
                    $query = mysql_query($str);
                    $num = @mysql_num_rows($query); //总记录数
                    $pcunt = ceil($num / $psize); //总页数
                    $nextpage = $page + 1;
                    $qianpage = $page - 1;
                    $start = ($page - 1) * $psize;

                    $str = "$sqll ORDER BY id DESC limit $start,$psize";
                    $query = mysql_query($str);
                    while (@$arr = mysql_fetch_array($query)) {//print_r($arr);
                        $array[] = $arr;
                    }
                    if ($page > 1)
                        $str1 = "<a href=admin.php?page=$qianpage>上一页</a>　";
                    if ($page < $pcunt)
                        $str2 = "<a href=admin.php?page=$nextpage>下一页</a>　";
                    $sql = "$sqll ORDER BY id DESC limit $start,$psize ";
                    $rerult = mysql_query($sql, $conn);
                    while (@$row = mysql_fetch_array($rerult)) {
                        ?>

                        <p>
                            <span>
                                <input type="checkbox" name="del[<?php echo $row[id]; ?>][id]" value="<?php echo $row[id]; ?>"  number="<?php echo $row[id]; ?>" onClick="Item(this, 'mmAll')"/>
                                <input readonly="value" type="text" name="del[<?php echo $row[id]; ?>][parameter]" value="<?php echo $row['parameter'] ?>">
                                    <input type="text" name="del[<?php echo $row[id]; ?>][url]" value="<?php echo $row['url'] ?>">
                                        </span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php if ($num != 0) {
                                        ?>

                                        <input type="submit" name="edit" value="修改"/>
                                        <input type="submit" name="delete" value="删除"/>
                                        <p align="center" style="line-height:30px;"><span>一共<?php echo $num ?>条数据</span><span style=" padding-left:14px;">总<?php echo $pcunt ?></span>页　当前为第<span><?php echo $page ?></span>页　<a href="<?php echo $no ?>">首页</a>
                                            <?php
                                            if ($page < 5) {
                                                if ($page + 5 < $pcunt) {
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        echo "<a id='page988' href='$no&page=$i'>$i</a>";
                                                    }
                                                } elseif ($page + 5 > $pcunt) {
                                                    if ($page == 1) {
                                                        for ($i = $page; $i <= $pcunt; $i++) {
                                                            echo "<a id='page988' href='$no&page=$i'>$i</a>";
                                                        }
                                                    } elseif ($page > 1) {

                                                        for ($i = $page - 1; $i <= $pcunt; $i++) {
                                                            echo "<a id='page988' href='$no&page=$i'>$i</a>";
                                                        }
                                                    }
                                                }
                                            } elseif ($page >= 5 and $page < $pcunt) {
                                                if ($page + 4 > $pcunt) {

                                                    for ($i = $page - 1; $i <= $pcunt; $i++) {
                                                        echo "<a id='page988' href='$no&page=$i'>$i</a>";
                                                    }
                                                } else {
                                                    for ($i = $page - 1; $i <= $page + 4; $i++) {
                                                        echo "<a id='page988' href='$no&page=$i'>$i</a>";
                                                    }
                                                }
                                            } elseif ($page >= $pcunt) {
                                                for ($i = $page - 1; $i <= $page; $i++) {
                                                    echo "<a id='page988' href='$no&page=$i'>$i</a>";
                                                }
                                            }
                                            ?>
                                            <span  style=" padding-left:14px;"><a href="<?php echo $no ?>&page=<?php echo $pcunt ?>">最后一页</a> </span> </p>
                                        </div>
                                        </form>
                                        </body>
                                        </html>
                                        <?php
                                    }
                                } else
                                    echo "<script language='javascript'>alert('请登录！');location='login.php';</script>";
                                ?>
