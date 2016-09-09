<?php ?>

<html> 
    <head> 
        <script type="text/javascript">
            function show_confirm()
            {
                var r = confirm("确定删除!");
                var name = document.getElementsByName("aa").valueOf();
                if (r == true)
                {
                    var value = document.getElementsByName(aa).value();
                    location = '/admin.php?action='+value;
                } else
                {
                    location = '/admin.php';
                }
            }
        </script> 
    </head> 
    <body> 
        <input type="button" name="aa" onclick="show_confirm()" value="Show a confirm box" /> 
        <form name="form1"> 
            <input name="t1" type="text" id='t1'><!--加上id号-->
            <input type='button' value="提交" onClick="chk('t1')">
        </form>
        <script language="javascript">
            function chk(id) {
                var value = document.getElementById(id).value;
                location = '/test.php?action='+value;
            }

        </script>
    </body> 
</html> 
