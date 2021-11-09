var data = Mock.mock("data.php", {
    'data|1-5': [{
        //属性  规则  值
        'id|+1': 1,
        'name|1': '@name',
        'sex|1': ['男', '女'],
        'city|1': '@city'
    }]
})