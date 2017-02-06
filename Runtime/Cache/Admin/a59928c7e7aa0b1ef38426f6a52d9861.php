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
<link rel="stylesheet" href="<?php echo CS_PATH;?>depart.css">
<div class="admin">
    <form method="get">
        <div class="panel admin-panel">
            <div class="panel-head"><strong>摇一摇场景列表</strong></div>
            <div style="width:100%;" class="padding border-bottom form-inline">
                <div style="float:left;" class="x16">
                    <input type="button" class="button button-small checkall" name="checkall" checkfor="id" value="全选" />
                    <input type="button" class="button button-small border-green" value="添加场景" onclick="System.add('添加场景','<?php echo U('Prize/red_add');?>')">
                   <!-- <input type="button" class="button button-small border-blue UpdateOrder" value="更新排序"  />-->
                    <input type="button" class="button button-small border-yellow" value="批量删除" onclick="getID('<?php echo U('Prize/red_del');?>')" />
                    <div class="clear"></div>
                </div>
                <div style="float:right;" class="x16">
                    <div class="form-group">
                        <div class="field">
                            <input type="text" class="input" id="keyword" name="keyword" size="20" placeholder="场景名称" value="<?php echo ($keyword); ?>">
                        </div>
                    </div>
                    <!-- 筛选 -->
                    <div class="form-button">
                        <button class="button" type="submit" id="search">搜索</button>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <table class="table table-hover" id="table">
                <tr>
                    <th width="*">ID</th>
                    <th width="*">场景名称</th>
                    <!--<th width="*">创建时间</th>
                    <th width="*">修改时间</th>
                    <th width="*">排序</th>-->
                    <th width="*">状态</th>
                    <th width="*">操作</th>
                </tr>

                <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                        <td>
                            <input type="checkbox" name="id" value="<?php echo ($vo["id"]); ?>"/><?php echo ($vo["id"]); ?>
                        </td>
                        <td><?php echo ($vo["scene_name"]); ?></td>
                       <!-- <td><?php echo (date("Y-m-d H:i",$vo["create_time"])); ?></td>
                        <td><?php echo (date("Y-m-d H:i",$vo["update_time"])); ?></td>
                        <td>
                            <input type="text" class=" input text-center"  name="order[<?php echo ($vo["id"]); ?>]" value="<?php echo ($vo["orders"]); ?>">
                        </td>-->
                        <td>
                            <?php if($vo['status'] == '1'): ?>启用
                                <?php else: ?>禁用<?php endif; ?>
                        </td>
                        <td>
                        <a class="button border-blue button-little" href="<?php echo U('Prize/index',array('id'=>$vo['id'],'pid'=>$_GET['pid'],'leve'=>'on'));?>" >奖品列表</a>
                        <a class="button border-blue button-little" href="#" onclick="System.edit('编辑场景','<?php echo U('Prize/red_edit',array('id'=>$vo['id']));?>')">修改</a> <a class="button border-yellow button-little" href="#" onclick="System.del('<?php echo ($vo["id"]); ?>','<?php echo ($vo["scene_name"]); ?>','<?php echo U('Prize/red_del');?>')">删除</a></td>
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
    <!-- <script>
         $('.UpdateOrder').click(function(){
             $.post("<?php echo U('admin/Depart/order');?>",
             $('#table').find('input[type="text"].text-center').serialize(),
             function(res){
               if(res.status ==1){
                   parent.layer.msg(res.info,{
                               offset: 200,
                               shift: 2,
                               time: 800 //2秒关闭（如果不配置，默认是3秒）
                   }, function(){
                       parent.location.reload()
                       parent.layer.closeAll()
                   });
               }
             });
         });
    </script> -->
</div>
</body>

</html>