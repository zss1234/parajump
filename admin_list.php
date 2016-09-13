<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("connect.php");
if ($_SESSION['admin'] == 'admin') {
    if (isset($_SESSION['admin'])) {
        if ($_POST['sub']) {
            if (!empty($_POST['parameter'])) {
                if (!empty($_POST['url'])) {
                    $isexist = "select * from `url` where parameter = '$_POST[parameter]'";
                    $exist = $mysqli->query($isexist);
                    $row = $exist->fetch_array();
                    if (!empty($row)) {
                        echo "<script language=\"javascript\">location='admin.php';</script>";
                        exit;
                    }
                    $sql = "INSERT INTO `url` (`id`, `parameter`, `url` ) VALUES (NULL, '$_POST[parameter]', '$_POST[url]');";
                    $mysqli_query($sql);
                    echo "<script language=\"javascript\">location='admin.php';</script>";
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
                    $id .= $value['id'] . ",";
                }
            }
            echo "<script language=\"javascript\">var r = confirm('是否删除');if(r==true){location='admin_list.php?id=" . $id . "';}else{location='admin_list.php';}</script>";
        }
        if (!empty($_GET[id])) {
            $str = $_GET[id];
            $arr = explode(',', $str);
            for ($index = 0; $index < count($arr); $index++) {
                $sql = "delete from `admin` WHERE id=$arr[$index]";
                $mysqli->query($sql);
            }
        }
        if ($_POST['confirmSelect']) {
            $key = $_POST['select'];
            echo "<script language=\"javascript\">location='/admin_list.php/?para=" . $key . "';</script>";
        }
        if ($_POST['selectall']) {
            echo "<script language=\"javascript\">location='/admin_list.php/?para=';</script>";
        }
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>添加跳转参数以及跳转地址</title>
                <script src="isset/js/register.js"></script>
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
                    <div>
                        <h3>管理员</h3>

                        <input type="text" name="select" id="select" value="输入需要搜索的关键字...." onfocus="if (this.value == '输入需要搜索的关键字....') {
                                    this.value = '';
                                }"  onblur="if (this.value == '') {
                                            this.value = '输入需要搜索的关键字....';
                                        }">
                            <input type="submit" name="confirmSelect" value="查询">
                                <input type="submit" name="selectall" value="显示全部">    
                                    <?php
                                    $sqll = "SELECT * FROM `admin` WHERE `user` != 'admin'";
                                    if (!empty($_GET['para'])) {
                                        $sqll .= " and user like '%" . $_GET['para'] . "%'";
                                    }
                                    $no = "admin_list.php?";
                                    @$page = $_GET['page'];
                                    if ($page == null)
                                        $page = 1;
                                    $psize = 100; //每页记录数
                                    $str = "$sqll";
                                    $query = $mysqli->query($str);
                                    $num = @mysqli_num_rows($query); //总记录数
                                    $pcunt = ceil($num / $psize); //总页数
                                    $nextpage = $page + 1;
                                    $qianpage = $page - 1;
                                    $start = ($page - 1) * $psize;

                                    $str = "$sqll ORDER BY id DESC limit $start,$psize";
                                    $query = $mysqli->query($str);
                                    while (@$arr = $query->fetch_array()) {//print_r($arr);
                                        $array[] = $arr;
                                    }
                                    if ($page > 1)
                                        $str1 = "<a href=admin.php?page=$qianpage>上一页</a>　";
                                    if ($page < $pcunt)
                                        $str2 = "<a href=admin.php?page=$nextpage>下一页</a>　";
                                    $sql = "$sqll ORDER BY id DESC limit $start,$psize ";
                                    $rerult = $mysqli->query($sql);
                                    $num = 0;
                                    ?>
                                    <?php
                                    while (@$row = $rerult->fetch_array()) {
                                        $num++;
                                        ?>
                                        <p>
                                            <span>
                                                <?php echo $num; ?><input type="checkbox" name="del[<?php echo $row[id]; ?>][id]" value="<?php echo $row[id]; ?>"  number="<?php echo $row[id]; ?>" onClick="Item(this, 'mmAll')"/>
                                                <input id="aa" type="text" name="del[<?php echo $row[id]; ?>][parameter]" value="<?php echo $row['user'] ?>">
                                            </span>
                                        </p>
                                        <?php
                                    }
                                    ?>
                                    <?php if ($num != 0) {
                                        ?>
                                        <?php if ($_SESSION['admin'] == "admin") { ?>
                                            <input type="submit" name="delete" value="删除"/>
                                        <?php } ?>
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
                                } else {
                                    echo "<script language='javascript'>location='login.php';</script>";
                                }
                            } else {
                                echo $_SESSION['admin']."您没有权限";
                            }
                            ?>
