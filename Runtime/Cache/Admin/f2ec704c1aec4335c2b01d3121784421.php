<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="renderer" content="webkit">
		<title><?php echo C(site_title);?>-后台管理</title>
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
		<script src="<?php echo JS_PATH;?>jquery.easyui.min.js"></script>
		<!-- <link type="image/x-icon" href="http://www.pintuer.com/favicon.ico" rel="shortcut icon" />
		<link href="http://www.pintuer.com/favicon.ico" rel="bookmark icon" /> -->
	</head>

	<body>
		<div class="lefter">
			<div class="logo">
				<a href="http://www.pintuer.com" target="_blank"><img src="<?php echo C('site_logo');?>" alt="后台管理系统" width="94px" height="40px" /></a>
			</div>
		</div>
		<div class="righter nav-navicon" id="admin-nav">
			<div class="mainer">
				<div class="admin-navbar">
					<span class="float-right">
                    <a class="button button-little bg-main" href="/" target="_blank">前台首页</a>

                     <a class="button button-little bg-green" href="#" onclick="System.clearCache('<?php echo U('Cache/ClearCache');?>')">清除缓存</a>

                    <a class="button button-little bg-yellow" href="#" onclick="System.logout('<?php echo U('Public/logout');?>')">注销登录</a>

                </span>
					<ul class="nav nav-inline admin-nav">
					<?php if(is_array($menu['top'])): $i = 0; $__LIST__ = $menu['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><li class="<?php echo ($v1["css"]); ?>">
							<a href="<?php echo ($v1["url"]); ?>" class="<?php echo ($v1["icon"]); ?>"> <?php echo ($v1["title"]); ?></a>
							<ul>
							    <?php if(is_array($menu['son'])): $i = 0; $__LIST__ = $menu['son'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><li class="<?php echo ($v2["css"]); ?>"><a href="<?php echo ($v2["url"]); ?>"><?php echo ($v2["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
<!-- 								<li><a href="system.html">系统设置</a></li>
								<li><a href="content.html">内容管理</a></li>
								<li><a href="#">订单管理</a></li>
								<li class="active"><a href="#">会员管理</a></li>
								<li><a href="#">文件管理</a></li> -->
								<!-- <li><a href="#">栏目管理</a></li> -->
							</ul>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
				<div class="admin-bread">
					<span>您好，<?php echo session('admin_username');?>，欢迎您的光临。</span>
					<ul class="bread">
						<li><a href="<?php echo U('Index/index');?>" class="icon-home"> 开始</a></li>
						<li>后台</li>
					</ul>
				</div>
			</div>
		</div>

<!-- 系统弹窗JS -->
<script src="<?php echo JS_PATH;?>system.js"></script>
<!-- 系统配置JS -->
<script src="<?php echo JS_PATH;?>site.js"></script>  <!-- 包含头部模版header -->

		<div class="admin">
			<div class="line-big">
				<div class="xm3">
					<div class="panel border-back">
						<div class="panel-body text-center">
							<img src="<?php echo IM_PATH;?>face.jpg" width="120" class="radius-circle" />
							<br /> admin
						</div>
						<div class="panel-foot bg-back border-back">您好，<?php echo session('admin_username');?>，这是您第<?php echo session('admin_login_count');?>次登录，上次登录为<?php echo session('admin_last_login_time');?>。</div>
					</div>
					<br />
					<!-- <div class="panel">
						<div class="panel-head"><strong>站点统计</strong></div>
						<ul class="list-group">
							<li><span class="float-right badge bg-red">88</span><span class="icon-user"></span> 部门</li>
						
							<li><span class="float-right badge bg-main">828</span><span class="icon-user"></span>员工 </li>
							<a href="#" onclick="System.add('购买短信','<?php echo U('Index/smsBuy');?>')"><li><span class="float-right <?php if($smsNum == 0): ?>badge bg-red <?php else: ?>badge bg-main<?php endif; ?>"><?php echo ($smsNum); ?></span><span class="icon-database"></span> 短信剩余条数</li></a>
						</ul>
					</div> -->
					<br />
				</div>
				<div class="xm9">
					<!-- <div class="alert alert-yellow"><span class="close"></span><strong>注意：</strong>您有5条未读信息，<a href="#">点击查看</a>。</div>
					<div class="alert">
						<h4>拼图前端框架介绍</h4>
						<p class="text-gray padding-top">拼图是优秀的响应式前端CSS框架，国内前端框架先驱及领导者，自动适应手机、平板、电脑等设备，让前端开发像游戏般快乐、简单、灵活、便捷。</p>
						<a target="_blank" class="button bg-dot icon-code" href="pintuer2.zip"> 下载示例代码</a>
						<a target="_blank" class="button bg-main icon-download" href="http://www.pintuer.com/download/pintuer.zip"> 下载拼图框架</a>
						<a target="_blank" class="button border-main icon-file" href="http://www.pintuer.com/"> 拼图使用教程</a>
					</div> -->
					<div class="panel">
						<div class="panel-head"><strong>系统信息</strong></div>
						<table class="table">
							<tr>
								<td width="110" align="right">操作系统：</td>
								<td><?php echo ($system["OS"]); ?></td>
								
							</tr>
							<tr>
								<td align="right">Web服务器：</td>
								<td><?php echo ($system["WEB"]); ?></td>
								<td align="right"><!-- 主页： --></td>
								<td><!-- <a href="<?php echo C('site_url');?>" target="_blank"><?php echo C('site_url');?></a> --></td>
							</tr>
							<tr>
								<td align="right">程序语言：</td>
								<td><?php echo ($system["PHP_VERSION"]); ?></td>
								<td align="right"><!-- 演示： --></td>
								<td><!-- <a href="http://www.pintuer.com/demo/" target="_blank">demo/</a> --></td>
							</tr>
							<tr>
								<td align="right">数据库：</td>
								<td><?php echo ($system["SQL"]); ?></td>
								<td align="right"><!-- 群交流： --></td>
								<td><!-- <a href="http://shang.qq.com/wpa/qunwpa?idkey=a08e4d729d15d32cec493212f7672a6a312c7e59884a959c47ae7a846c3fadc1" target="_blank">201916085</a> (点击加入) --></td>
							</tr>
							<tr>
								<td align="right">当前时间：</td>
								<td><?php echo ($system["LOCAL_TIME"]); ?></td>
								<td align="right"><!-- 群交流： --></td>
								<td><!-- <a href="http://shang.qq.com/wpa/qunwpa?idkey=a08e4d729d15d32cec493212f7672a6a312c7e59884a959c47ae7a846c3fadc1" target="_blank">201916085</a> (点击加入) --></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<p class="text-right text-gray"><a class="text-gray" target="_blank" href="<?php echo C('site_url');?>"><?php echo C('site_icp');?></a></p>  <!-- 包含底部部模版footer -->

		</div>
	</body>

</html>