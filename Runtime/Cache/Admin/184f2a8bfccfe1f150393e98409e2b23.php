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
<script src="<?php echo JS_PATH;?>site.js"></script>
<!-- 包含头部模版header -->

<div class="admin">
	<form method="get">
		<div class="panel admin-panel">
			<div class="panel-head"><strong>内容列表</strong></div>
			<div style="width:100%;" class="padding border-bottom form-inline">
				<div style="float:left;" class="x16">
					<input type="button" class="button button-small checkall" name="checkall" checkfor="id" value="全选" />
					<input type="button" class="button button-small border-green" value="添加管理员" onclick="System.add('添加管理员','<?php echo U('Admin/add');?>')">
					<input type="button" class="button button-small border-yellow" value="批量删除" onclick="getID('<?php echo U('Admin/del');?>')" />
					<!--    <input type="button" class="button button-small border-blue" value="回收站" /> -->
					<div class="clear"></div>
				</div>
				<div style="float:right;" class="x16">
					<div class="form-group">
						<div class="field">
							<input type="text" class="input" id="keyword" name="keyword" size="20" placeholder="账号|昵称" value="<?php echo ($keyword); ?>">
						</div>
					</div>
					<!-- 筛选 -->
					<div class="form-group">
						<div class="field">
							<select class="input" name="group" onchange="getSearch()">
								<option value="">用户组</option>
								  <?php if(is_array($groups)): $i = 0; $__LIST__ = $groups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
					</div>
					<!-- 筛选 -->
					<div class="form-button">
						<button class="button" type="submit" id="search">搜索</button>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<table class="table table-hover">

				<tr>
					<th width="45">选择</th>
					<th width="120">账号</th>
					<th width="*">昵称</th>
					<th width="100">邮箱</th>
					<th width="*">最后登录时间</th>
					<th width="*">登录次数</th>
					<th width="*">用户组</th>
					<th width="*">状态</th>
					<th width="100">操作</th>
				</tr>

				<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td>
							<input type="checkbox" name="id" value="<?php echo ($vo["id"]); ?>" />
						</td>
						<td><?php echo ($vo["username"]); ?></td>
						<td><?php echo ($vo["nickname"]); ?></td>
						<td><?php echo ($vo["email"]); ?></td>
						<td><?php echo (date("Y-m-d H:i",$vo["last_login_time"])); ?></td>
						<td><?php echo ($vo["login_count"]); ?></td>
						<td><?php echo ($vo["title"]); ?></td>
						<td>
							<?php if($vo['status'] == '1'): ?>启用
								<?php else: ?>禁用<?php endif; ?>
						</td>
						<td><a class="button border-blue button-little" href="#" onclick="System.edit('编辑管理员','<?php echo U('Admin/edit',array('id'=>$vo['id']));?>')">修改</a> <a class="button border-yellow button-little" href="#" onclick="System.del('<?php echo ($vo["id"]); ?>','<?php echo ($vo["username"]); ?>','<?php echo U('Admin/del');?>')">删除</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>

			</table>
			<div class="panel-foot text-right" style="font-size:12px;">
				<?php echo ($page); ?>
			</div>
		</div>
	</form>
	<br />
	<p class="text-right text-gray"><a class="text-gray" target="_blank" href="<?php echo C('site_url');?>"><?php echo C('site_icp');?></a></p>
	<!-- 包含底部部模版footer -->
</div>
</body>

</html>