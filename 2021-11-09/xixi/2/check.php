<?php 
header("Context-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");//设置时间
require("JWT.php");//引入JWT文件
use \Firebase\JWT\JWT;//使用Firebase下的JWT
defined("KEY" ,'qwefsdsd2as89465asdfdgrfe6a15dQR23');//定义加密秘钥
$res['result']='failed';//定义result初始值["result"=>"failed]
$action=@$_GET['action'];//check.php?action=login   get方法传值
if($action== 'login'){//判断是不是登录操作
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $userName=$_POST['userName'];
        $userName=$_POST['userName'];
        if($userName=="tom"&& $pwd="123"){
            $nowtime=time();
            $token=[
                'iss'=>'http://localhost',//签发者
                'aud'=>'http://localhost',
                'iat'=>$nowtime,
                'nbf'=>$nowtime+10,
                'exp'=>$nowtime+600,
                'data'=>[
                    'userId'=>1,
                    'userName'=>$userName
                ]
           ];
           $jwt=JWT::encode($token,KEY);//创建jwt
           $res['result']='success';
           $res['jwt']=$jwt;

        }else{
            $res['msg']='用户名或密码错误';
        }
    }
    echo json_encode($res);
}else{//解密操作
    $jwt=$_SERVER['HTTP_X_TOKEN'];
    if(empty($jwt)){
        $res['msg']='非法登录';
        echo json_encode($res);
        exit;
    }
    try{
        JWT::$leeway=60;
        $decoded=JWT::encode($jwt,KEY,['HS256']); 
        $arr=(array)$decoded;
        if($arr['exp']<time()){
            $res['msg']='请重新登陆';

        }
        else{
            $res['result']='success';
            $res['info']=$arr;
        }
    }catch(Exception $e){
        $res['msg']='TOken验证失败，请重新登录';
    }
    echo json_encode($res);
}



?>