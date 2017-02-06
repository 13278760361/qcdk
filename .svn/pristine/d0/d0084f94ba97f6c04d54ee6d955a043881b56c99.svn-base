//日历模块
var calendar = {
	nowMonth: null,
	nowYear: null,
	nowDate: null,
	getDates: function(Y,M) { //获取当前月有多少天	
		var D = new Date();
		//获取年份
		var year = Y;
		//获取当前月份
		var month = M + 1;
		//定义当月的天数；
		var days ;
	//当月份为二月时，根据闰年还是非闰年判断天数
	if(month == 2){
	        days= !(year % (year % 100 ? 4 : 400))  ? 29 : 28;
	    }
	    else if(month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12){
	        //月份为：1,3,5,7,8,10,12 时，为大月.则天数为31；
	        days= 31;
	    }
	    else{
	        //其他月份4,6,9,11 天数为：30.
	        days= 30;      
	    }
//		    console.log("year="+year);
//			console.log("month="+month);
//		    console.log("days="+days);
	    
	    return days
	},
	getMonthOne: function(M) { //获取当前月第一天是星期几
		var D = new Date();
		var D2 = new Date(D.getFullYear(), M, 1)
		return D2.getDay()
	},
	nowDate: function() {
		var D = new Date();
		calendar.nowMonth = D.getMonth();
		calendar.nowYear = D.getFullYear();
		calendar.nowDate = D.getDate();
		$(".datetime").html(calendar.nowYear + "年" + (calendar.nowMonth + 1) +"月")
	},
	nextMonth: function(arr,salaryDay) {
		if(calendar.nowMonth >= 11) {
			calendar.nowYear +=1;
			calendar.nowMonth =0;				
		} else {
			calendar.nowMonth += 1;
		}
		$(".datetime").html(calendar.nowYear + "年" + (calendar.nowMonth + 1) +"月")
		//calendar.renderHtml(arr,salaryDay);
	},
	preMonth: function(arr,salaryDay) {
		if(calendar.nowMonth <= 0) {
			calendar.nowYear -=1;
			calendar.nowMonth =11;			
		} else {
			calendar.nowMonth -= 1;
		}
		$(".datetime").html(calendar.nowYear + "年" + (calendar.nowMonth + 1) +"月")
		//calendar.renderHtml(arr,salaryDay);
	},
	getYearAndMonth: function(){
		return calendar.nowYear+"-"+(calendar.nowMonth+1);
	},
	renderHtml: function(arr,salaryDay) {
		//console.log(arr);
		var Da = new Date();
		var dates = calendar.getDates(calendar.nowYear, calendar.nowMonth)
		var day = calendar.getMonthOne(calendar.nowMonth)			
		var zHtml = "";
		var d = 0;
		if(day != 0) {
			for(p = 0; p < day; p++) {
				zHtml += "<li></li>"
			}
		}
		for(i = 0; i < dates; i++) {
			if(Da.getMonth() == calendar.nowMonth) {
				if(Da.getDate() == (i + 1)) {
					zHtml += "<li class='curday' data-date="+ calendar.nowYear+"-"+(calendar.nowMonth+1)+"-"+(i + 1) +" >" + (i + 1) + "</li>";
				} else {
					zHtml += "<li data-date="+ calendar.nowYear+"-"+(calendar.nowMonth+1)+"-"+(i + 1) +" >" + (i + 1) + "</li>";
				}
			} else {
				zHtml += "<li data-date="+ calendar.nowYear+"-"+(calendar.nowMonth+1)+"-"+(i + 1) +" >" + (i + 1) + "</li>";
			}

		}
		$(".calendar_days").html(zHtml)
		var dL = $(".calendar_days li").length;
		var zLeng = 42
		if(dL != zLeng) {
			for(k = 0; k < (zLeng - dL); k++) {
				$(".calendar_days").append("<li></li>")
			}
		}
		//拓展
		
		//发薪日
		if(salaryDay!=null && salaryDay!="undefine"){
			$(".calendar_days li").each(function(){
				if($(this).attr("data-date")==salaryDay){
					$(this).append("<i></i>").addClass("salary");
				}
			});
		}
		//未打卡日
		if(arr!=null && arr.length>0){
			for(var i=0,len=arr.length;i<len;i++){
				//console.log(arr[i]);
				$(".calendar_days li").each(function(){			
					if($(this).attr("data-date")==arr[i]){
						$(this).addClass("nosign");
					}
				});
			}
		};
		
	}
};	
