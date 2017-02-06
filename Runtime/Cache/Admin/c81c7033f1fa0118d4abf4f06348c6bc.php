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
   	<link href="<?php echo CS_PATH;?>bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="<?php echo CS_PATH;?>pintuer.css">
		<link rel="stylesheet" href="<?php echo CS_PATH;?>admin.css">
    <link href="<?php echo CS_PATH;?>fangcms.css" rel="stylesheet" media="screen">
    <link href="<?php echo CS_PATH;?>bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		<div class="admin">

			<div class="tab">
				<div class="tab-head">
					<ul class="tab-nav">
						<li class="active"><a href="#tab-set">系统设置</a></li>
						<li><a href="#tab-upload">上传设置</a></li>
						<li><a href="#tab-backup">备份设置</a></li>
						<li><a href="#tab-page">分页设置</a></li>
						<li><a href="#tab-sms">工作时间设置</a></li>
						<li><a href="#tab-weixin">微信配置</a></li>
						<li><a href="#tab-prize">摇一摇奖品配置</a></li>
						<li><a href="#tab-red">红包配置</a></li>
					</ul>
				</div>
				<div class="tab-body">
					<br />
					<div class="tab-panel active" id="tab-set">
					<!-- 	<form method="post" class="form-tips" action="system.html" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="sitename">网站名称</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_name" name="site_name" size="50" placeholder="网站名称" value="<?php echo C('site_name');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="siteurl">网址</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_url" name="site_url" size="50" placeholder="请填写网址" value="<?php echo C('site_url');?>" data-validate="required:请填写,url:格式不正确"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="logo">网站Logo<font color="red" style="font-size:10px;">[*建议上传94*40,透明背景]</font></label>
								</div>
								<div class="field">
									<a class="button input-file" href="javascript:void(0);">+ 浏览文件<input name="file" id="logo" size="100" type="file" data-validate="required:请上传Logo图片"/></a>
									<input type="hidden" id="site_logo" name="site_logo" value="<?php echo C('site_logo');?>">
								</div>
							</div>
							<img src="<?php echo C('site_logo');?>" width="100" height="100" class="img-border radius-small" id="logo_img" />


							<div class="form-group">
								<div class="label">
									<label for="qr">微信二维码<font color="red" style="font-size:10px;"></font></label>
								</div>
								<div class="field">
									<a class="button input-file" href="javascript:void(0);">+ 浏览文件<input name="file" id="qr" size="100" type="file" data-validate="required:请上传二维码"/></a>
									<input type="hidden" id="site_qr" name="site_qr" value="<?php echo C('site_qr');?>">
								</div>
							</div>
							<img src="<?php echo C('site_qr');?>" width="100" height="100" class="img-border radius-small" id="qr_img" />


							<div class="form-group">
								<div class="label">
									<label for="watermark">水印图片</label>
								</div>
								<div class="field">
									<a class="button input-file" href="javascript:void(0);">+ 浏览文件<input name="file" id="watermark" size="100" type="file"/></a>
									<input type="hidden" id="site_watermark" name="site_watermark" value="<?php echo C('site_watermark');?>">
								</div>
							</div>
							<img src="<?php echo C('site_watermark');?>" width="100" height="100" class="img-border radius-small" id="watermark_img" />

						   <div class="form-group">
								<div class="label">
									<strong>水印位置</strong>
								</div>
								<div class="field">
									<div class="button-group radio">
										<label class="button <?php if (C('site_watermarkposition') == 0) {?>active<?php }?>">
											<input name="site_watermarkposition" value="0" type="radio" <?php if (C('site_watermarkposition') == 0) {?>checked="checked"<?php }?>>关闭
										</label>
										<label class="button <?php if (C('site_watermarkposition') == 1) {?>active<?php }?>">
											<input name="site_watermarkposition" value="1" type="radio" <?php if (C('site_watermarkposition') == 1) {?>checked="checked"<?php }?>>左上
										</label>
										<label class="button <?php if (C('site_watermarkposition') == 7) {?>active<?php }?>">
											<input name="site_watermarkposition" value="7" type="radio" <?php if (C('site_watermarkposition') == 7) {?>checked="checked"<?php }?>>左下
										</label>
										<label class="button <?php if (C('site_watermarkposition') == 3) {?>active<?php }?>">
											<input name="site_watermarkposition" value="3" type="radio" <?php if (C('site_watermarkposition') == 3) {?>checked="checked"<?php }?>>右上
										</label>
										<label class="button <?php if (C('site_watermarkposition') == 9) {?>active<?php }?>">
											<input name="site_watermarkposition" value="9" type="radio" <?php if (C('site_watermarkposition') == 9) {?>checked="checked"<?php }?>>右下
										</label>
										<label class="button <?php if (C('site_watermarkposition') == 5) {?>active<?php }?>">
											<input name="site_watermarkposition" value="5" type="radio" <?php if (C('site_watermarkposition') == 5) {?>checked="checked"<?php }?>>居中
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="site_watermarkalignment">水印融合度</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_watermarkalignment" name="site_watermarkalignment" size="50" placeholder="1-100值越大水印透明度越低" value="<?php echo C('site_watermarkalignment');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="title">优化标题</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_title" name="site_title" size="50" placeholder="title标题内容，用于搜索引擎优化" value="<?php echo C('site_title');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="keywords">关键词</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_keywords" name="site_keywords" size="50" placeholder="站点关键词，用于搜索引擎优化" value="<?php echo C('site_keywords');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="readme">网站描述</label>
								</div>
								<div class="field">
									<textarea class="input" name="site_desc" rows="5" cols="50" placeholder="请填写网站描述" data-validate="required:请填写"><?php echo C('site_desc');?></textarea>
								</div>
							</div>



							<div class="form-group">
								<div class="label">
									<label for="tel">联系电话</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_tel" name="site_tel" size="50" placeholder="多个电话请以逗号分隔" value="<?php echo C('site_tel');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="rtel">座机</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_rtel" name="site_rtel" size="50" placeholder="多个电话请以逗号分隔" value="<?php echo C('site_rtel');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="email">邮箱</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_email" name="site_email" size="50" placeholder="邮箱" value="<?php echo C('site_email');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="qq">客服QQ</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_qq" name="site_qq" size="50" placeholder="多个QQ请以逗号分隔" value="<?php echo C('site_qq');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="address">联系地址</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_address" name="site_address" size="50" placeholder="详细地址" value="<?php echo C('site_address');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="icp">网站备案号</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="site_icp" name="site_icp" size="50" placeholder="网站备案号" value="<?php echo C('site_icp');?>" data-validate="required:请填写"/>
								</div>
							</div>
							

							<div class="form-group">
								<div class="label">
									<label>网站状态</label>
								</div>
								<div class="field">
									<div class="button-group button-group-small radio">
										<label class="button <?php if (C('site_status') == 1) {?>active<?php }?>">
											<input name="site_status" value="1"  type="radio" <?php if (C('site_status') == 1) {?>checked="checked"<?php }?>><span class="icon icon-check"></span> 开启</label>
										<label class="button <?php if (C('site_status') == 0) {?>active<?php }?>">
											<input name="site_status" value="0" type="radio" <?php if (C('site_status') == 0) {?>checked="checked"<?php }?>><span class="icon icon-times"></span> 关闭</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="readme">维护说明</label>
								</div>
								<div class="field">
									<textarea name="site_maintain" class="input" rows="5" cols="50" placeholder="请填写维护说明"><?php echo C('site_maintain');?></textarea>
								</div>
							</div>


							<div class="form-button">
								<button class="button" type="buttom" onclick="add_site()">提交</button>
							</div>
						<!-- </form> -->
					</div>
				
					<!-- 一块 -->
					<div class="tab-panel" id="tab-upload">
						<!-- <form method="post" class="form-tips" action="" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="UPLOAD_PATH">上传目录</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="UPLOAD_PATH" name="UPLOAD_PATH" size="50" placeholder="文件上传目录" value="<?php echo C('UPLOAD_PATH');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="UPlOAD_SIZE">允许上传文件大小</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="UPlOAD_SIZE" name="UPlOAD_SIZE" size="50" placeholder="文件大小" value="<?php echo C('UPlOAD_SIZE');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="UPLOAD_EXTS">允许上传文件类型</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="UPLOAD_EXTS" name="UPLOAD_EXTS" size="50" placeholder="允许类型" value="<?php echo C('UPLOAD_EXTS');?>" data-validate="required:请填写"/>
								</div>
							</div>
						


							<div class="form-button">
								<button class="button" type="buttom" onclick="add_upload()">提交</button>
							</div>
						<!-- </form> -->

					</div>

					<!-- 一块 -->
					<div class="tab-panel" id="tab-backup">
						
						<!-- <form method="post" class="form-tips" action="" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="BACK_PATH">数据备份路径<font color="red" style="font-size:10px;">[*路径必须以 / 结尾]</font></label>
								</div>
								<div class="field">
									<input type="text" class="input" id="BACK_PATH" name="BACK_PATH" size="50" placeholder="数据备份路径" value="<?php echo C('BACK_PATH');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="BACK_PART">数据备份卷大小<font color="red" style="font-size:10px;">[*该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M]</font></label>
								</div>
								<div class="field">
									<input type="text" class="input" id="BACK_PART" name="BACK_PART" size="50" placeholder="数据备份卷大小" value="<?php echo C('BACK_PART');?>" data-validate="required:请填写"/>
								</div>
							</div>
							 <div class="form-group">
								<div class="label">
									<strong>数据库备份文件是否启用压缩<font color="red" style="font-size:10px;">[*压缩备份文件需要PHP环境支持gzopen,gzwrite函数]</font></strong>
								</div>
								<div class="field">
									<div class="button-group radio">
										<label class="button <?php if (C('BACK_COMPRESS') == 0) {?>active<?php }?>">
											<input name="BACK_COMPRESS" value="0" type="radio" <?php if (C('BACK_COMPRESS') == 0) {?>checked="checked"<?php }?>>不压缩
										</label>
										<label class="button <?php if (C('BACK_COMPRESS') == 1) {?>active<?php }?>">
											<input name="BACK_COMPRESS" value="1" type="radio" <?php if (C('BACK_COMPRESS') == 1) {?>checked="checked"<?php }?>>启用压缩
										</label>
										
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="BACK_LEVEL">
										数据库备份文件压缩级别<font color="red" style="font-size:10px;">[*数据库备份文件的压缩级别，该配置在开启压缩时生效]</font></label>
								</div>
								<div class="field">
									<select class="input" name="BACK_LEVEL" data-validate="required:请填写">
						
									
											<option value="1"<?php if(C('BACK_LEVEL') == 1 ){?>selected='selected' <?php }?> >普通</option>
											<option value="4"<?php if(C('BACK_LEVEL') == 4 ){?>selected='selected' <?php }?> >一般</option>
											<option value="9"<?php if(C('BACK_LEVEL') == 9 ){?>selected='selected' <?php }?> >最高</option>
								
									</select>
								</div>
							</div>
						


							<div class="form-button">
								<button class="button" type="buttom" onclick="add_backup()">提交</button>
							</div>
						<!-- </form> -->
					</div>
			

					<!-- 一块 -->
					<div class="tab-panel" id="tab-page">
						<!-- <form method="post" class="form-tips" action="" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="pageNum">后台每页记录数</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="pageNum" name="pageNum" size="50" placeholder="后台每页记录数" value="<?php echo C('pageNum');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="w_pageNum">前台每页记录数</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="w_pageNum" name="w_pageNum" size="50" placeholder="后台每页记录数" value="<?php echo C('w_pageNum');?>" data-validate="required:请填写"/>
								</div>
							</div>
						
							<div class="form-button">
								<button class="button" type="buttom" onclick="add_page()">提交</button>
							</div>
						<!-- </form> -->

					</div>

					<!-- 一块 -->

					<!-- 一块 -->
					<div class="tab-panel" id="tab-sms">
					<!-- 	<form method="post" class="form-tips" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="worktime">工作时长<font color="red" style="font-size:10px;">[*每天工作时长/小时]</font></label>
								</div>
								<div class="field">
									<input type="text" class="input" id="worktime" name="worktime" size="50" placeholder="每天上班时长" value="<?php echo C('worktime');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-button">
								<button class="button" onclick="add_sms()">提交</button>
							</div>
						<!-- </form> -->

					</div>

					<!-- 一块 -->

					<!-- 一块 -->
					<div class="tab-panel" id="tab-weixin">
						<!-- <form method="post" class="form-tips" action="" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="appid">appid</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="appid" name="appid" size="50" placeholder="填写高级调用功能的app id" value="<?php echo C('appid');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="appsecret">appsecret</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="appsecret" name="appsecret" size="50" placeholder="填写高级调用功能的密钥" value="<?php echo C('appsecret');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="token">token</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="token" name="token" size="50" placeholder="填写你设定的key" value="<?php echo C('token');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="encodingaeskey">encodingaeskey</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="encodingaeskey" name="encodingaeskey" size="50" placeholder="填写加密用的EncodingAESKey" value="<?php echo C('encodingaeskey');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="url">生成URL</label>
								</div>
								<div class="field">
									<input type="text" class="input" id="url" name="url" size="50" placeholder="" value="<?php echo C('site_url');?>/Home/Weixin/index/token/<?php echo C('token');?>"/>
								</div>
							</div>

							<hr/>

							<div class="form-group">
								<div class="label">
									<label>群发封面显示</label>
								</div>
								<div class="field">
									<div class="button-group button-group-small radio">
										<label class="button <?php if (C('is_pic') == 1) {?>active<?php }?>">
											<input name="is_pic" value="1"  type="radio" <?php if (C('is_pic') == 1) {?>checked="checked"<?php }?>><span class="icon icon-check"></span> 开启</label>
										<label class="button <?php if (C('is_pic') == 0) {?>active<?php }?>">
											<input name="is_pic" value="0" type="radio" <?php if (C('is_pic') == 0) {?>checked="checked"<?php }?>><span class="icon icon-times"></span> 关闭</label>
									</div>
								</div>
							</div>


						
							<div class="form-button">
								<button class="button" type="buttom" onclick="add_weixin()">提交</button>
							</div>
						<!-- </form> -->

					</div>

					<!-- 一块 -->
					<div class="tab-panel" id="tab-prize">
						<!-- <form method="post" class="form-tips" action="" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="appid">开始时间</label>
								</div>
								<div class="field">
									<input class="input" data-date="" data-date-format="dd MM yyyy" type="text" name="scene_start" id="form_dstime" placeholder="请选择开始时间" readonly  value="<?php echo date('Y-m-d H:i',C('scene_start'));?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="appsecret">结束时间</label>
								</div>
								<div class="field">
									<input class="input" size="16" type="text" id="form_detime" readonly style="margin-left: -1px;" placeholder="请选择结束时间" name="scene_end" value="<?php echo date('Y-m-d H:i',C('scene_end'));?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="appsecret">奖品场景</label>
								</div>
								<div class="field" id="scene_id">
									<select name="sceneList" class="input" id="">
					                   
					                    <?php if(is_array($sceneList)): $i = 0; $__LIST__ = $sceneList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($scene_id) == $vo["id"]): ?>selected<?php endif; ?>><?php echo ($vo["scene_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					                </select>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="appsecret">场景状态</label>
								</div>
								<div class="field">
									<div class="button-group button-group-small radio">
										<label class="button <?php if (C('is_scene') == 1) {?>active<?php }?>">
											<input name="is_scene" value="1"  type="radio" <?php if (C('is_scene') == 1) {?>checked="checked"<?php }?>><span class="icon icon-check"></span> 开启</label>
										<label class="button <?php if (C('is_scene') == 0) {?>active<?php }?>">
											<input name="is_scene" value="0" type="radio" <?php if (C('is_scene') == 0) {?>checked="checked"<?php }?>><span class="icon icon-times"></span> 关闭</label>
									</div>
								</div>
							</div>
							<div class="form-button">
								<button class="button" type="buttom" onclick="add_prize()">提交</button>
							</div>
						<!-- </form> -->

					</div>
					<!-- 一块 -->
					<!-- 红包配置 S -->
					<div class="tab-panel" id="tab-red">
						<!-- <form method="post" class="form-tips" action="" > -->
							
							<div class="form-group">
								<div class="label">
									<label for="appid">红包发送者名称</label>
								</div>
								<div class="field">
									<input class="input" type="text" name="send_name" placeholder="填写红包发送者名称"  value="<?php echo C('send_name');?>" data-validate="required:请填写"/>
								</div>
							</div>

							<div class="form-group">
								<div class="label">
									<label for="appsecret">活动名称</label>
								</div>
								<div class="field">
									<input class="input" size="16" type="text" id="form_detime"  style="margin-left: -1px;" placeholder="请填写活动名称" name="act_name" value="<?php echo C('act_name');?>" data-validate="required:请填写"/>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="appsecret">红包祝福语&nbsp;&nbsp;<font color="red" style="font-size:10px;">[*最多128个字符]</font></label>
								</div>
								<div class="field">
									<textarea class="input" name="wishing" data-validate="required:请填写" placeholder="请填红包祝福语，最多128个字符" ><?php echo C('wishing');?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="label">
									<label for="appsecret">红包备注信息&nbsp;&nbsp;<font color="red" style="font-size:10px;">[*最多256个字符]</font></label>
								</div>
								<div class="field">
									<textarea class="input" name="remark" data-validate="required:请填写" placeholder="请填写红包备注信息，做多256个字符"><?php echo C('remark');?></textarea>
								</div>
							</div>
							<div class="form-button">
								<button class="button" type="buttom" onclick="add_red()">提交</button>
							</div>
						<!-- </form> -->

					</div>
					<!-- 红包配置 E -->
				</div>
			</div>
			<p class="text-right text-gray"><a class="text-gray" target="_blank" href="<?php echo C('site_url');?>"><?php echo C('site_icp');?></a></p>  <!-- 包含底部部模版footer -->
		</div>
		<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap-datetimepicker.js"></script>
		<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
		
			

		<script type="text/javascript">
	    $(function () {

      	$("#logo").wrap("<form id='upload'  method='post' enctype='multipart/form-data'></form>");

      	$("#logo").change(function(){

      	$('#upload').form('submit', {
								
					  type: 'POST',
					  url: "<?php echo U('Upload/index');?>",
					     onSubmit: function(param){
					        param.Type   = 'logo/';   //图片存储路径
					    },  
					  
					  success: function(data){
							if(data.status==0){

		      					layer.open({

		      						content:data.info,

		      						btn:['好的'],

		      						yes:function(){

		      							layer.closeAll()

		      						}

		      					})

		      				}else{

		      					$("#logo_img").attr('src',data);

		      					$("input[name='site_logo']").val(data);

		      					layer.closeAll()

		      				}
						}
				});

      	});

    });

	     $(function () {

	    $("#watermark").wrap("<form id='upload_water'  method='post' enctype='multipart/form-data'></form>");

      	$("#watermark").change(function(){

      	$('#upload_water').form('submit', {
								
					  type: 'POST',
					  url: "<?php echo U('Upload/index');?>",
					     onSubmit: function(param){
					        param.Type   = 'watermark/';   //图片存储路径
					    },  
					  
					  success: function(data){
							if(data.status==0){

		      					layer.open({

		      						content:data.info,

		      						btn:['好的'],

		      						yes:function(){

		      							layer.closeAll()

		      						}

		      					})

		      				}else{
		      					$("#watermark_img").attr('src',data);

		      					$("input[name='site_watermark']").val(data);

		      					layer.closeAll()

		      				}
						}
				});

      	});
    });

     $(function () {

      	$("#qr").wrap("<form id='upload_qr'  method='post' enctype='multipart/form-data'></form>");

      	$("#qr").change(function(){

      	$('#upload_qr').form('submit', {
								
					  type: 'POST',
					  url: "<?php echo U('Upload/index');?>",
					     onSubmit: function(param){
					        param.Type   = 'qr/';   //图片存储路径
					    },  
					  
					  success: function(data){
							if(data.status==0){

		      					layer.open({

		      						content:data.info,

		      						btn:['好的'],

		      						yes:function(){

		      							layer.closeAll()

		      						}

		      					})

		      				}else{

		      					$("#qr_img").attr('src',data);

		      					$("input[name='site_qr']").val(data);

		      					layer.closeAll()

		      				}
						}
				});

      	});

    }); 
$('#form_dstime').datetimepicker({
		        format: 'yyyy-mm-dd hh:ii',
		        language:  'zh',
		        weekStart: 1,
		        todayBtn:  1,
		        autoclose: 1,
		        todayHighlight: 1,
		        startView: 2,
		        minView: 0,
		        forceParse: 0
		    });
		    $('#form_detime').datetimepicker({
		        format: 'yyyy-mm-dd hh:ii',
		        language:  'zh',
		        weekStart: 1,
		        todayBtn:  1,
		        autoclose: 1,
		        todayHighlight: 1,
		        startView: 2,
		        minView: 0,
		        forceParse: 0
		    });
		</script>	

	</body>

</html>