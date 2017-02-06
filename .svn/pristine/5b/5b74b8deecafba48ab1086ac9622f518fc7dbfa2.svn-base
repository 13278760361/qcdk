function add_site(){
	var site_name =$("input[name='site_name']");
	var site_url = $("input[name='site_url']");
	var site_logo =$("input[name='site_logo']");
	var site_title=$("input[name='site_title']");
	var site_keywords=$("input[name='site_keywords']");
	var site_desc =$("textarea[name='site_desc']");
	var site_status =$("input[name='site_status']:checked");
	var site_maintain =$("textarea[name='site_maintain']");
	var site_watermark = $("input[name='site_watermark']");
	var site_watermarkposition = $("input[name='site_watermarkposition']:checked");
	var site_watermarkalignment =$("input[name='site_watermarkalignment']");
	var site_tel = $("input[name='site_tel']");
	var site_qq = $("input[name='site_qq']");
	var site_address = $("input[name='site_address']");
	var site_icp    =$("input[name='site_icp']");
	var site_rtel = $("input[name='site_rtel']");
    var site_email= $("input[name='site_email']");
    var site_qr= $("input[name='site_qr']");
	var file='site.php';

	if (site_name.val()=='') {

		site_name.focus();

		return false
	};

	if (site_url.val()=='') {

		site_url.focus();

		return false
	};

	if (site_logo.val()=='') {
        // layer.msg('请上传Logo');

		site_logo.focus();

		return false
	};

	if (site_title.val()=='') {

		site_title.focus();

		return false
	};
	if (site_keywords.val()=='') {

		site_keywords.focus();

		return false
	};

	if (site_desc.val()=='') {

		site_desc.focus();

		return false
	};

	if (site_status.val()=='') {

		site_status.focus();

		return false
	};


	 $('.button').attr("disabled","disabled");//防止重复提交


			$.post("{:U('System/index')}",{

				site_name:site_name.val(),

				site_url:site_url.val(),

				site_logo:site_logo.val(),

				site_title:site_title.val(),

				site_keywords:site_keywords.val(),

				site_desc:site_desc.val(),

				site_status:site_status.val(),

				site_maintain:site_maintain.val(),

				file:file,

				site_watermark:site_watermark.val(),

				site_watermarkposition:site_watermarkposition.val(),

				site_watermarkalignment:site_watermarkalignment.val(),

				site_tel:site_tel.val(),

				site_qq:site_qq.val(),

				site_address:site_address.val(),

				site_icp:site_icp.val(),

				site_rtel:site_rtel.val(),

				site_email:site_email.val(),

				site_qr:site_qr.val(),


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   


					
					 

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})			

	
}

function add_upload(){
	var UPLOAD_PATH =$("input[name='UPLOAD_PATH']");
	var UPlOAD_SIZE = $("input[name='UPlOAD_SIZE']");
	var UPLOAD_EXTS =$("input[name='UPLOAD_EXTS']");
	var file='upload.php';

	if (UPLOAD_PATH.val()=='') {

		UPLOAD_PATH.focus();

		return false
	};

	if (UPlOAD_SIZE.val()=='') {

		UPlOAD_SIZE.focus();

		return false
	};

	if (UPLOAD_EXTS.val()=='') {
        // layer.msg('请上传Logo');

		UPLOAD_EXTS.focus();

		return false
	};


	 $('.button').attr("disabled","disabled");//防止重复提交


			$.post("{:U('System/index')}",{

				UPLOAD_PATH:UPLOAD_PATH.val(),

				UPlOAD_SIZE:UPlOAD_SIZE.val(),

				UPLOAD_EXTS:UPLOAD_EXTS.val(),


				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   


					
					 

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})			
}

function add_backup(){
	var BACK_PATH =$("input[name='BACK_PATH']");
	var BACK_PART = $("input[name='BACK_PART']");
	var BACK_COMPRESS =$("input[name='BACK_COMPRESS']:checked");
	var BACK_LEVEL = $("select[name='BACK_LEVEL']");
	var file='backup.php';

	if (BACK_PATH.val()=='') {

		BACK_PATH.focus();

		return false
	};

	if (BACK_PART.val()=='') {

		BACK_PART.focus();

		return false
	};

	if (BACK_COMPRESS.val()=='') {
        // layer.msg('请上传Logo');

		BACK_COMPRESS.focus();

		return false
	};

	if (BACK_LEVEL.val()=='') {
        // layer.msg('请上传Logo');

		BBACK_LEVEL.focus();

		return false
	};


	 $('.button').attr("disabled","disabled");//防止重复提交


			$.post("{:U('System/index')}",{

				BACK_PATH:BACK_PATH.val(),

				BACK_PART:BACK_PART.val(),

				BACK_COMPRESS:BACK_COMPRESS.val(),

				BACK_LEVEL:BACK_LEVEL.val(),


				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   


					
					 

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})			
}


function add_page(){
	var pageNum =$("input[name='pageNum']");
	var w_pageNum =$("input[name='w_pageNum']");

	var file='page.php';

	if (pageNum.val()=='') {

		pageNum.focus();

		return false
	};

	if (w_pageNum.val()=='') {

	    w_pageNum.focus();

		return false
	};



	 $('.button').attr("disabled","disabled");//防止重复提交


			$.post("{:U('System/index')}",{

				pageNum:pageNum.val(),

				w_pageNum:w_pageNum.val(),

				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   


					
					 

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})			
}


function add_sms(){
	var worktime =$("input[name='worktime']");

	var file='worktime.php';

	if (worktime.val()=='') {

		worktime.focus();

		return false
	};
	//var z= /^[0-9]*$/;
	//if(!z.test(worktime.val())){
	//	worktime.focus();
    //
	//	return false
	//}

	$('.button').attr("disabled","disabled");//防止重复提交


			$.post("{:U('System/index')}",{

				worktime:worktime.val(),
				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()

					});
				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 ,//2秒关闭（如果不配置，默认是3秒）

					});

				}

			})			
}

function add_weixin(){
	var appid =$("input[name='appid']");
	var appsecret =$("input[name='appsecret']");
	var token =$("input[name='token']");
	var encodingaeskey =$("input[name='encodingaeskey']");
	var is_pic = $("input[name='is_pic']:checked");

	var file='weixin.php';

	if (appid.val()=='') {

		appid.focus();

		return false
	};

	if (appsecret.val()=='') {

		appsecret.focus();

		return false
	};

	if (token.val()=='') {

		token.focus();

		return false
	};

	if (encodingaeskey.val()=='') {

		encodingaeskey.focus();

		return false
	};



	 $('.button').attr("disabled","disabled");//防止重复提交


			$.post("{:U('System/index')}",{

				appid:appid.val(),

				appsecret:appsecret.val(),

				token:token.val(),

				encodingaeskey:encodingaeskey.val(),

				is_pic:is_pic.val(),

				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   


					
					 

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})			
}
function add_prize(){
	var scene_start =$("input[name='scene_start']");
	var scene_end =$("input[name='scene_end']");

	var is_scene = $("input[name='is_scene']:checked");
	var scene_id = $("#scene_id select");
	var file='prize.php';

	if (scene_start.val()=='') {

		scene_start.focus();

		return false
	};

	if (scene_end.val()=='') {

		scene_end.focus();

		return false
	};

	if (is_scene.val()=='') {

		is_scene.focus();

		return false
	};
	
	//var scene_start_v = ;
	var scene_start2  = Date.parse(new Date(scene_start.val().replace('/-/g', '/')))/1000;
	var scene_end2 = Date.parse(new Date(scene_end.val().replace('/-/g', '/')))/1000;
	if(scene_end2<scene_start2){
		
		alert('结束时间应该大于开始时间');
		return false
	}
	 $('.button').attr("disabled","disabled");//防止重复提交

			$.post("{:U('System/index')}",{

				scene_start:scene_start2,

				scene_end:scene_end2,

				is_scene:is_scene.val(),

				scene_id:scene_id.val(),

				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})
	}
//红包配置
function add_red(){
	var send_name = $("input[name='send_name']");
	var act_name = $("input[name='act_name']");
	var wishing = $("textarea[name='wishing']");
	var remark = $("textarea[name='remark']");
	var file='fission_red.php';
	//alert();
	if (send_name.val()=='') {

		send_name.focus();

		return false
	};
	if(act_name.val() == ''){
		act_name.focus();
		return false;
	}
	if(wishing.val() == ''){

		wishing.focus();
		return false;
	}
	if(remark.val() == ''){
		remark.focus();
		return false;
	}
	if(wishing.val().length>128){
		alert('祝福语最多128个字符');
		return false;
	}
	if(remark.val().length>256){
		alert('备注信息最多256个字符');
		return false;
	}
	$('.button').attr("disabled","disabled");//防止重复提交

			$.post("{:U('System/index')}",{

				send_name:send_name.val(),

				act_name:act_name.val(),

				wishing:wishing.val(),

				remark:remark.val(),

				file:file,


			},function(ret){

				// alert(ret);

				if(ret.status==1){
					
					 parent.layer.msg(ret.info, {

						offset: 200,

						shift: 1,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					}, function(){
						  parent.location.reload()
					      parent.layer.closeAll()			

					});   

				}else{

					layer.msg(ret.info, {

						offset: 200,

						shift: 2,

						time: 800 //2秒关闭（如果不配置，默认是3秒）

					});

				}

			})
}