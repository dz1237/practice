<?php 
    header("Content-type:text/html;charset=utf-8");
    date_default_timezone_set("PRC");//设置时间
    require("JWT.php");//引入JWT库
    use \Firebase\JWT\JWT;//使用JWT命名空间
    define("KEY",'234rfuyiwehbj879p34uow');//定义秘钥
    $res['result']='failed';
    $action=@$_GET['action'];
    if($action=='login'){//判断是不是登录操作
        if($_SERVER['REQUEST_METHOD']=='POST'){
            $userName=$_POST['userName'];
            $password=$_POST['password'];
            if($userName=="tom"&& $password="123"){
                $nowtime=time();
                $token=[
                    'iss'=>'http://localhost',//签发者
                    'aud'=>'http://localhost',//jwt所面向的用户
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
    }else{//不是登录操作，是验证操作
        $jwt=@$_SERVER['HTTP_X_TOKEN'];
        if(empty($jwt)){
            $res['msg']="非法登录";
            echo json_encode($res);
            exit; 
        }
        try{
                JWT::$leeway=60;
                $decoded=JWT::decode($jwt,KEY,['HS256']);
                $arr=(array)$decoded;
                if($arr['exp']<time()){
                    $res['msg']="请重新登录";
                }
                else{
                    $res['result']='success';
                    $res['info']=$arr;
                }
        }
        catch(Exception $e){
            $res['msg']="Token验证失败，请重新登录";
        }
        echo json_encode($res);

    }


?>