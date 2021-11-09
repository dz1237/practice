var data = Mock.mock("check.php", "post", function(options) {
    var url = new URLSearchParams(options.body);
    var userName = url.get("userName");
    var pwd = url.get("pwd");
    if (userName == "lgd" && pwd == "123") {
        return Mock.mock({
            "status": "10001",
            "msg": "ok"
        })
    } else {
        return Mock.mock({
            "status": "30001",
            "msg": "用户名或者密码错误"
        });
    }
});