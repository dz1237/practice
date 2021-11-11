<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>欢迎登录</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
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
<script src="js/jquery-1.11.0.min.js"></script>
<script>
  $(function(){
	  //点击登录按钮，进行登录验证
	   $("#bt1").click(function(){
		   $.ajax({
			   url:"check.php?action=login",
			   type:"POST",
			   data:{userName:$("#userName").val(),password:$("#password").val()},
			   dataType:"json",
			   success: function(data){
				//    验证成功，将jwt-token持久化到localStorage中
				   if(data.result=="success"){
					   localStorage.setItem("jwt",data.jwt);
					    $("#login").hide();
						$("#login_success").show(); 
						$("#user_tips").text(data.info.data.userName);
					}else{
					    $("#tips").text(data.msg);	
				     }   
			   }
			  
		   })   
		}); 
		//如果jwt不是空，则发送给接口进行验证
       var jwt=localStorage.getItem("jwt");
       if(!!jwt){
          $.ajax({
            url:"check.php",
			type:"GET",
			headers:{//request header中发送
				"X-token":localStorage.getItem("jwt")
			},
			dataType:"json",
			success:function(data){
				//验证通过-从负载中取出数据
				if(data.result=="success"){
					$("#login").hide();
					$("#login_success").show(); 
					$("#user_tips").text(data.info.data.userName)
				}else{
					$("#tips").text(data.msg);	
				}
			}

		  });

		  $("#userName").focus(function(){
			  $("#tips").text("");
		  });
		  $("#password").focus(function(){
			  $("#tips").text("");
		  });

	   }
//注销
	$("#login_out").click(function(){
		localStorage.removeItem("jwt");
		$("#login").show();
		$("#login_success").hide(); 
		$("#userName").val("").trigger("focus");
		$("#password").val("");
	
	});
  });
</script>
</head>

<body>
<div id="login">
<label for="userName">用户名:</label>
<input type="text" id="userName"><br>
<label for="password">密&nbsp;&nbsp;&nbsp;码:</label>
<input type="password" id="password"><br>
<div id="tips"></div>
<input type="button" id="bt1" class="btn btn-primary" value="登录">
</div>
<div id="login_success" style="display:none;">
  <p>欢迎<span id="user_tips"></span>光临！</p>
  <a href="javascript:;" id="login_out">注销</a>
</div>
</body>
</html>