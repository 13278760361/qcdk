var App = function(){
	
	//获取不同设备的body高度
	var setDeviceHeight = function(){
		//console.log(window.screen.availHeight);
		//var screenH = window.screen.height;//677
		var winH = $(window).height();
		if($(".logo").length>0){		
			$("body").css({height:winH});
		}else{
			$("body").css({height:winH});
		}
	}
	
	/*
	 * 签到状态
	 * flag:boolean
	 * */
	var setSignStateSuccess = function(flag){
		if(flag){
			//停顿1s，开始动画
			setTimeout(function(){
				$(".sign_state_spark").addClass("active");
			},1000)	
		}
	}
	
	//设置通讯录展开
	var setAddressListToggle = function(){
		$(".address_list dt").on("click",function(){		
			var display = $(this).next("dd").css("display");
			var len = $(this).next("dd").find("a").size();
			if(len == 0) return;//如果部门下面没有人员，不进行展开操作
			if(display=="none"){
				$(".address_list").find("dd").hide();
				$(".address_list").find("dt").removeClass("active");
				$(this).addClass("active");
				$(this).next("dd").slideDown();
			}else{				
				$(".address_list").find("dt").removeClass("active");
				$(this).removeClass("active");
				$(this).next("dd").slideUp();
			}
		})
	}
	
	
	
	return{
		init:function(){
			setDeviceHeight();
		},
		handleSparkFly:function(flag){
			setSignStateSuccess(flag);
		},
		handleAddressListToggle:function(){
			setAddressListToggle();
		}
	}
}();

//全局调用
$(function(){
	App.init();
})
