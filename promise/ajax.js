/*param  #7777
{
  url:"接口地址",
  type:"GET/POST",
  contentType:"数据编码",
  data:"要发送的数据",
  dataType:"html/json返回的数据类型",	
  success:function(data返回的数据){//#1234
   //ajax请求成功，回调函数
 },
 error:function(message){//#2223
  //ajax请求过程中出错回调函数--onerror回调函数
	 alert(message); 
 },
 completed:function(){//#3334
	//ajax请求完成后回调函数--ajax排队的--onloadend回调函数 
 }
}*/
function ajax(param) {
    try {
        return new Promise((resolve, reject) => {
            if (typeof param == "object" && param != undefined) {

                //1. 创建 ajax对象
                var xmlHttp = new XMLHttpRequest();
                //2.设置请求方法和目标地址
                xmlHttp.open(param.type, param.url);
                //监听ajax请求过程错误处理
                xmlHttp.onerror = function(e) {
                        if (param.error != null && typeof param.error == "function") {
                            param.error(e);
                        }
                    }
                    //ajax请求完成后触发--ajax排对
                xmlHttp.onloadend = function() {
                        if (param.completed != null && typeof param.completed == "function") {
                            param.completed();
                        }
                    }
                    //3.设置数据编码:
                    //3.1 GET方法带参数请求
                if (param.type == "GET" && param.data != undefined) {
                    xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                }
                //3.2 POST带参数
                switch (param.contentType) {
                    case 'urlencoded':
                        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        break;
                    case 'json':
                        xmlHttp.setRequestHeader("Content-type", "application/json");
                        break;
                }

                //4. 监控ajax请求过程:
                xmlHttp.onreadystatechange = function() {
                        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                            //data回来的数据
                            var data = null;
                            switch (param.dataType) {
                                case "html":
                                    data = xmlHttp.responseText;
                                    break;
                                case "json":
                                    try {
                                        data = JSON.parse(xmlHttp.responseText);
                                    } catch (e) {
                                        reject(e);
                                    }

                                    break;
                                default:
                                    data = xmlHttp.responseText;
                            }
                            // param.success(data);//#1234	
                            resolve(data);
                        }
                    }
                    //5.发送请求:
                if (param.type == "POST" && param.data != undefined) {
                    xmlHttp.send(param.data);
                } else {
                    xmlHttp.send();
                }

            } else {
                throw new Error("参数类型不正确或参数为空");
            }
        })
    } catch (e) {
        reject(e);
    }

}