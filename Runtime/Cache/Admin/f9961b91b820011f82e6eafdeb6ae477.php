<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php echo ($page); ?>
<script>
    function index(id){
        var id = id;
        //把数据传递到要替换的控制器方法中
        $.get('/goods/myinfolist', {'p':id}, function(data){
            //用get方法发送信息到index中的myinfo方法
            $("#server").replaceWith("<div  id='user7'>"
                +data.content+
                "</div>");
        });
    }
</script>
</body>
</html>