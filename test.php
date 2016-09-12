<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script>
            function f1() {
                var chks = document.form.chk;

                var str = "";

                for (var i = 0; i < chks.length; i++) {
                    if (chks[i].checked == true) {
                        str += chks[i].value + ",";
                    }
                }
                //弹出多选框选中的结果
                alert("value" + str);
            }
        </script>
    </head>
    <body>
        <form name="form">
            <input type=checkbox name="chk" value=1>
            <input type=checkbox name="chk" value=2>
            <input type=checkbox name="chk" value=3>
            <input type="button" value="test" onclick="f1()"/>
        </form>
    </body>
</html>