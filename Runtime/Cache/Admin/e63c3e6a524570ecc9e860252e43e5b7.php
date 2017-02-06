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
<div class="admin">
	<form method="get">
		<div class="panel admin-panel">
			<div class="panel-head"><strong>考勤列表</strong></div>
			<div style="width:100%;" class="padding border-bottom form-inline">
				<div style="float:left;margin-top:2px;" class="x16">
					<a href="javascript:;" onclick="System.add('考勤信息导出','<?php echo U("Admin/Work/abnormal");?>')"><input type="button" class="button button-small border-green" value="导出异常考勤信息" ></a>
					<div class="clear"></div>
				</div>

				<div style="float:right;" class="x16">
					<div style="margin-top:10px;float:right;" class="x16">
					<!-- 筛选 -->
					<div class="form-group">
						<div class="form-group">
							<div class="field">
								<input type="datetime"  id="keyword" name="keyword" placeholder="工号|姓名" value="<?php echo ($keyword); ?>"style="border: solid 1px #ddd; border-radius: 4px;margin-bottom: 4px">
							</div>
						</div>
						<div class="field"  style="margin-left: 5px " >
							<select  name="departs"style="border: solid 1px #ddd; border-radius: 4px;">
								<option value="">部门</option>
								<?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($key == $departss): ?>selected<?php endif; ?> ><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</div>
						<div class="field" style="margin-left: 5px">
							<select name="sex" style="border: solid 1px #ddd; border-radius: 4px;">
								<option value="">姓别</option>
								<option value="1"  <?php if(1 == $sex): ?>selected<?php endif; ?> >男</option>
								<option value="2"<?php if(2 == $sex): ?>selected<?php endif; ?> >女</option>
								<option value="3" <?php if(3 == $sex): ?>selected<?php endif; ?> >保密</option>
							</select>
						</div>
						<div class="field" style="margin-left: 5px">
							<input type="datetime" name="start_date" class="text date" value="<?php echo ($start_time); ?>" placeholder="请选择开始时间" style="border: solid 1px #ddd; border-radius: 4px;" /> -
						</div>
						<div class="field " style="margin-left: 5px">
								<input type="datetime" name="end_date" class="text date" value="<?php echo ($end_time); ?>" placeholder="请选择结束时间" style="border: solid 1px #ddd; border-radius: 4px;"  />
						</div>
					</div>
					<!-- 筛选 -->
					<div class="form-button">
						<button type="submit" id="search"  style="border: solid 1px #ddd; border-radius: 4px; margin-bottom: 4px" >搜索</button>
					</div>
					</div>
					<!--<div class="clear"></div>-->
				</div>
			</div>
			<table class="table table-hover">

				<tr>
					<th width="*">工号</th>
					<th width="*">姓名</th>
					<th width="*">性别</th>
					<th width="*">部门</th>
					<th width="*">上班时间</th>
					<th width="*">下班时间</th>
					<th width="*">日期</th>
				</tr>
				<?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["job_number"]); ?></td>
						<td><?php echo ($vo["username"]); ?></td>
						<td>
							<?php if($vo["sex"] == 1): ?>男
								<?php elseif($vo["sex"] == 2): ?>女
								<?php else: ?>保密<?php endif; ?>
						</td>

						<td><?php echo ($vo["depart_name"]); ?></td>
						<td><?php if(empty($vo["sign_time"])): ?>**：**<?php else: echo (date('H:i',$vo["sign_time"])); endif; ?></td>
						<td><?php if(empty($vo["xtime"])): ?>**：**<?php else: echo (date('H:i',$vo["xtime"])); endif; ?></td>
						<td><?php echo ($vo["sign_date"]); ?></td>
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
<link href="<?php echo ORG_PATH;?>datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">

<link href="<?php echo ORG_PATH;?>datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo ORG_PATH;?>datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo ORG_PATH;?>datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script type="text/javascript">
	$(function(){
		$('.date').datetimepicker({
			format: 'yyyy-mm-dd',
			language:"zh-CN",
			minView:2,
			autoclose:true
		});
	});
	$('.date').datetimepicker({
		format: 'yyyy-mm-dd',
		language:"zh-CN",
		minView:2,
		autoclose:true
	});
</script>