<?php /*a:1:{s:42:"C:\wamp64\www\tp-cms\view\login\login.html";i:1607261491;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理-登陆</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/lib/layui-v2.5.5/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/css/login.css" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="main-body">
    <div class="login-main">
        <div class="login-top">
            <span>班级管理系统登录</span>
            <span class="bg1"></span>
            <span class="bg2"></span>
        </div>
        <form class="layui-form login-bottom">
            <div class="center">
                <div class="item">
                    <span class="icon icon-2"></span>
                    <input type="text" name="account" value="<?php echo htmlentities($account); ?>" lay-verify="required" lay-reqtext="账号不能为空"  placeholder="请输入登录账号" maxlength="24"/>
                </div>

                <div class="item">
                    <span class="icon icon-3"></span>
                    <input type="password" name="password" value="<?php echo htmlentities($password); ?>" lay-verify="required"  lay-reqtext="密码不能为空"  placeholder="请输入密码" maxlength="20">
                    <span class="bind-password icon icon-4"></span>
                </div>

                <div id="validatePanel" class="item" style="width: 137px;">
                    <input type="text" name="captcha" lay-verify="required" lay-reqtext="验证码不能为空" placeholder="请输入验证码" maxlength="4">
                    <img id="refreshCaptcha" class="validateImg"  src="Login/getCaptcha" onclick="this.src='login/getCaptcha/'+Math.random()">
                </div>

            </div>
            <div class="tip">
                <span class="icon-nocheck"></span>
                <span class="login-tip">记住密码</span>
                <a href="javascript:" class="forget-password">忘记密码？</a>
            </div>
            <div class="layui-form-item" style="text-align:center; width:100%;height:100%;margin:0px;">
                <button class="login-btn" lay-submit="" lay-filter="login">立即登录</button>
            </div>
        </form>
    </div>
</div>
<script src="/static/lib/layui-v2.5.5/layui.js" charset="utf-8"></script>
<script>
    layui.use(['form','jquery'], function () {
        var $ = layui.jquery,
            form = layui.form,
            layer = layui.layer;

        // 登录过期的时候，跳出ifram框架
        if (top.location != self.location) top.location = self.location;

        $('.bind-password').on('click', function () {
            if ($(this).hasClass('icon-5')) {
                $(this).removeClass('icon-5');
                $("input[name='password']").attr('type', 'password');
            } else {
                $(this).addClass('icon-5');
                $("input[name='password']").attr('type', 'text');
            }
        });

        $('.icon-nocheck').on('click', function () {
            if ($(this).hasClass('icon-check')) {
                $(this).removeClass('icon-check');
            } else {
                $(this).addClass('icon-check');
            }
        });

        // 进行登录操作
        form.on('submit(login)', function (obj) {
            var data = obj.field;
            console.log(data);
            if (data.account == '') {
                layer.msg('账号不能为空',{icon:5});
                return false;
            }
            if (data.password == '') {
                layer.msg('密码不能为空',{icon:5});
                return false;
            }
            if (data.captcha == '') {
                layer.msg('验证码不能为空',{icon:5});
                return false;
            }

            //是否记住密码
            var state=0;
            var value=$('.icon-check').length;
            if(value>0) {
                state=1;
            } else {
                state=0;
            }


            $.ajax({
                url: "/Login/login",
                data: {
                    'account': data.account,
                    'password': data.password,
                    'captcha': data.captcha,
                    'state':state,
                },
                type: "post",
                success: function (data) {
                    console.log(data);
                    if (data.code == 1) {
                        layer.msg(data.msg,{icon:6}, function () {
                            //window.location = 'index';
                        });
                    }else{
                        layer.msg(data.msg,{icon:5}, function () {
                            //window.location = 'index';
                        });
                    }
                },
                error: function (data) {
                    console.log('==错误信息==');
                }
            });
            return false;
        });
    });
</script>
</body>
</html>