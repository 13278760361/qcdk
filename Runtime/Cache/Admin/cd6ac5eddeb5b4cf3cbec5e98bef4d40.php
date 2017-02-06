<?php if (!defined('THINK_PATH')) exit();?>
<!--
	作者：大火兔 1979788761@qq.com
	时间：2015-11-24
-->
<!DOCTYPE html>
<html lang="zh-cn">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="renderer" content="webkit">
		<title><?php echo C(site_title);?>后台管理-管理员登录</title>
		<!--
        	作者：大火兔 1979788761@qq.com
        	时间：2015-11-17
        	描述：使用官网CSS/JS同步最新版
        -->
		<link rel="stylesheet" href="<?php echo CS_PATH;?>pintuer.css">
		<link rel="stylesheet" href="<?php echo CS_PATH;?>admin.css">
		<script src="<?php echo JS_PATH;?>jquery.min.js"></script>
		<script src="<?php echo JS_PATH;?>pintuer.js"></script>
		<script src="<?php echo JS_PATH;?>admin.js"></script>
		<script src="<?php echo JS_PATH;?>lib/layer/layer.js"></script>
	</head>
	<!--
	作者：1979788761@qq.com
	时间：2015-11-18
	描述：这里根据自己的需求设计一张1920×1080的背景图，不用担心加载问题，一般浏览器都支持缓存，首次加载以后会稍慢，加载速度由图片大小决定
	-->

	<body style="background-image: url(<?php echo IM_PATH;?>background.jpeg);" onkeydown="BindEnter(event)">
		<div class="container">
			<div class="line">
				<div class="xs6 xm4 xs3-move xm4-move">
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
				<!-- 	<form method="post"> -->
						<div class="panel padding">
							<div class="text-center">
								<br>
								<h2><strong><?php echo C(site_title);?>后台管理</strong></h2></div>
							<div class="" style="padding:30px;">
								<div class="form-group">
									<div class="field field-icon-right">
										<input type="text" class="input" name="username" placeholder="登录账号"  />
										<span class="icon icon-user"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="field field-icon-right">
										<input type="password" class="input" name="password" placeholder="登录密码" />
										<span class="icon icon-key"></span>
									</div>
								</div>
								<div class="form-group">
									<div class="field">
										<input type="text" class="input" name="verify" placeholder="填写右侧的验证码"/>
										<img src="<?php echo U('Public/verify');?>" width="80" height="32" class="passcode" id="verify_img" onclick="this.src='<?php echo U('Admin/Public/verify');?>?t='+Math.random();"/>
									</div>
								</div>
								<div class="form-group">
									<div class="field">
										<button id="login" class="button button-block bg-main text-big" >立即登录后台</button>
									</div>
								</div>
								<!-- <div class="form-group">
									<div class="field text-center">
										<p class="text-muted text-center"> <a class="" href="login.html#"><small>忘记密码了？</small></a> | <a class="" href="register.html">注册新账号</a>
										</p>
									</div>
								</div> -->
								<div class="text-right text-small text-gray padding-top"><a class="text-gray" target="_blank" href="<?php echo C('site_url');?>"><?php echo C('site_icp');?></a></div>
							</div>
						</div>
					<!-- </form> -->
				</div>
			</div>
		</div>
		<script type="text/javascript">
function verifys(id){
        document.getElementById(id).src="<?php echo U('Admin/Public/verify');?>?t="+Math.random(); 

}
function BindEnter(obj)
{
if(obj.keyCode == 13)

    {
        $("#login").click()
    }
}


$("#login").click(function(){

var username=$("input[name='username']");

var password=$("input[name='password']");
var verify=$("input[name='verify']");

if(username.val()==''){
    username.focus();
    return false

}

if(password.val()==''){
    password.focus();
    return false
}

if(verify.val()==''){
    verify.focus();
    return false

}


$.ajax({

    type: 'POST',
    url: '<?php echo U("Public/checkLogin");?>',
    data: {
        username:username.val(),
        password:password.val(),
        verify:verify.val(),

    },

    beforeSend:function(){

        layer.load(2,{shade: [0.1,'#fff']});

    },

    success:function(data){

        layer.closeAll();

        if(data.status==1){

           layer.msg('登录成功', {
                        time: 1000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){
                        window.location.href = data.url;    
                    });      

        }else{
            layer.msg(data.info);
            verifys('verify_img');
        }

    }
});

})

</script>


	</body>

</html>