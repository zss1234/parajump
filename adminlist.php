<?php
error_reporting(0);
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once ("conn.php");
var_dump($_POST['edit']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>用户管理</title>
    </head>
    <body bgcolor="#E7D4D4" align="center">
        <h2>用户管理</h2>
        <form method="post">
            <h3 >超级管理员</h3>
            <?php
            $sql = "SELECT user FROM `admin` WHERE `user` = 'admin'";
            $query = mysql_query($sql);
            $row = mysql_fetch_array($query);
            ?>
            <input type="text" value="<?php echo $row['user'] ?>">
                <hr/>
                

                <div>
                    <h3>普通管理员</h3>
                    <input type="text" name="select" id="select" value="输入需要搜索的关键字...." onfocus="if (this.value == '输入需要搜索的关键字....') {
                                this.value = '';
                            }"  onblur="if (this.value == '') {
                                        this.value = '输入需要搜索的关键字....';
                                    }">
                        <input type="submit" name="confirmSelect" value="查询">
                            <input type="submit" name="selectall" value="显示全部">    
                                <?php
                                $sqll = "SELECT * FROM `admin` ";
                                if (!empty($_GET['para'])) {
                                    $sqll .= "WHERE user like '%" . $_GET['para'] . "%'";
                                }
                                $no = "admin.php?";
                                @$page = $_GET['page'];
                                if ($page == null)
                                    $page = 1;
                                $psize = 100; //每页记录数
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
                                $num = 0;
                                ?>
                                <?php
                                while (@$row = mysql_fetch_array($rerult)) {
                                    $num++;
                                    ?>
                                    <p>
                                        <span>
                                            <?php echo $num; ?><input type="checkbox" name="del[<?php echo $row[id]; ?>][id]" value="<?php echo $row[id]; ?>"  number="<?php echo $row[id]; ?>" onClick="Item(this, 'mmAll')"/>
                                            <input id="aa" readonly="value" type="text" name="del[<?php echo $row[id]; ?>][parameter]" value="<?php echo $row['user'] ?>">
                                                <input type="text" name="del[<?php echo $row[id]; ?>][url]" value="<?php echo $row['pass'] ?>" style="width:600px;">
                                                        </span>
                                                        </p>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php if ($num != 0) {
                                                        ?>
                                                        <input type="submit" name="edit" value="修改"/>
                                                        <?php if ($_SESSION['admin'] == "admin") { ?>
        <!--                                                            <script type="text/javascript">
                                                                    function show_confirm()
                                                                    {
                                                                        var r = confirm("确定删除!");
                                                                        if (r == true)
                                                                        {
                                                                            var del = document.getElementsByName(del);
                                                                            
                                                                            location = '/admin.php?action=del'+del;
                                                                        } else
                                                                        {
                                                                            location = '/admin.php';
                                                                        }
                                                                    }
                                                                </script>
                                                            <input type="button" value="删除" name="delete" onclick="show_confirm()"/>-->
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