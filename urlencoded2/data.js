var data = Mock.mock("check.php", "psot", function(options) {
    var url = new URLSearchParams(options.body);
    var userName = url.get("userName");
    var pwd = url.get("pwd");
    if (userName == "tom" && pwd == "123") {
        return Mock.mock({ "status": "10001", "msg": "ok" });
    } else {
        return Mock.mock({ "status": "30001", "msg": "用户名或密码错误" });
    }
});