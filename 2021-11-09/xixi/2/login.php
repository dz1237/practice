<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
#login,#login_success{
	width:240px;
	height:140px;
	position:fixed;
	left:50%;
	top:50%;
	margin-left:-120px;
	margin-top:-50px;
	text-align:center;
}
#userName,#password{
	width:180px;
}
#tips{
	color:#ff0000;
	font-size:12px;
}
</style>
<script src="./JQurey.js"></script>
<script>
    $(function(){
        $("#bt1").click(function(){
            $.ajax({
                url:"check.php?action=login",
                type:"POST",
                data:{userName:$("#userName").val(),password:$("#password").val()},
                dataType:'json',
                success:function(data){
                    if(data.result=="success"){
                        localStorage.setItem("jtw",data.jwt);
                        $("#login").hide();
                        $("#login_success").show();
                        $("#user_tips").text(data.info.data.userName);
                    }
                    else{
                        $("#tips").text(data.msg);
                    }
                }

            });
        });
        //jwt不是空
        var jwt=localStorage.getItem("jwt");
        if(!!jwt){
            $.ajax({
                url:'check.php',
                type:"GET",
                headers:{
                    "X-token":localStorage.getItem('jwt')
                },
                dataType:"json",
                success:function(data){
                    if(data.result=="success"){
                        $("#login").hide();
                    $("#login_success").show();
                    $("#user_tips").text(data.info.data.userName)
                    }else{
                        $("#tips").text(data.msg);
                    }
                }
                

            });
        }
        $("#login_out").click(function(){
            localStorage.removeItem("jwt");
            $("#login").show();
            $("#login_success").hide();
            $("#userName").val("").trigger("focus");
            $("password").val("")
        });


    });
</script>
</head>
<body>
    <div id="login">
        <label for="userName">用户名:</label>
        <input type="text" name="" id="userName"><br>
        <lable for='password'>密码</lable>
        <input type="password" name="" id="password"><br>
        <div id="tips"></div>
        <input type="button" value="登录" id="bt1">
    </div>
    <div id="login_success" style="display: none;">
    <p>欢迎<span id="user_tips"></span>光临！</p>
    <a href="javascript:;" id="login_out">注销</a>
</div>
</body>
</html>