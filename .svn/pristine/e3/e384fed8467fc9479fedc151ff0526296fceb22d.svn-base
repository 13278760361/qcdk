//补全两位数
function toTwo(n) {
    if (parseInt(n) < 10) {
        return "0" + n;
    } else {
        return n;
    }
}

//页面返回
function goBack()
{
    if(url_back)
    {
        redirect(url_back);
    }else
    {
        window.history.go(-1);
    }
}

//时间格式函数
function formatDate(value) {
    var _temp = value.split(' ');
    var _date = _temp[0].split('-');
    var _time = _temp[1].split(':');
    if (_date[1].length === 1){
        _date[1] = '0' + _date[1];
    }
    if (_date[2].length === 1) {
        _date[2] = '0' + _date[2];
    }
    if (_time[0].length === 1) {
        _time[0] = '0' + _time[0];
    }
    if (_time[1].length === 1) {
        _time[1] = '0' + _time[1];
    }
    return _date[0] + '-' + _date[1] + '-' + _date[2] + 'T' + _time[0] + ':' + _time[1] + ':' + _time[2];
}

//符合条件的属性组成对象
//参数：两个都必填
//通过name判断是单个提交还是多个提交

//单个提交：获取当前元素属性，组成提交对象
//提交单个:<div url="index.php" class="poster" poster-id="10" poster-pid="1" />===>{id:10,pid:10}

//多个提交：通过属性获取元素，组成提交对象
//多个提交: <input info="name" value="张三" />
//          <span info="sex">男</span>                        =======>{name:'张三',sex:'男',age:25}
//          <input info="age" value="25" />
//          <button action="index.php" poster="info" value="提交" />
function getdatas(obj,name)
{
    if(!obj){return false;}if(!name){return false;}var data={};
    if(typeof(name)=='string')
    {//单个控件提交
        obj=$(obj)[0];var fun='';var reg='';var list=obj.attributes;
        fun=name.substr(0,1);name=name.substr(1,name.length-1);
        switch(fun){case '^':reg=eval("/^"+name+"/");break;case '$':reg=eval("/"+name+"$/");break;case '%':reg=eval("/"+name+"/");break;default:reg=eval("/^"+name+"$/");break;}
        for(var i=0;i<list.length;i++){var p=list[i].name;var v=list[i].value;if(reg.test(p)){p=p.split('-')[1];data[p]=v;}}
    }else
    {//多个控件提交
        if(typeof(obj)!=='string'){return false;}var inputs=[];$(':input').each(function(){inputs.push(this);});
        $("["+obj+"]").each(function(){
            if($.inArray(this,inputs)>=0)
            {
                var o=$(this);var key=o.attr(obj);var val=o.val();
                if(o.attr('type')=='radio'){if(this.checked){data[key]=val;}else{return true;}}else
                {
                    if(o.attr('type')=='checkbox'&&!this.checked){return true;}
                    if(data[key]){if($.isArray(data[key])){data[key].push(val);}else{data[key]=[data[key]];data[key].push(val);}}else{data[key]=val;}
                }
            }else
            {
                var o=$(this);var key=o.attr(obj);var val=o.text();
                if(data[key]){if($.isArray(data[key])){data[key].push(val);}else{data[key]=[data[key]];data[key].push(val);}}else{data[key]=val;}
            }
        });
    }
    //检测表单----空返回false,只有一个并且为空返回false.
    if($.isEmptyObject(data)){return false;}var count=0;var mykey='';for(var i in data){count++;mykey=i;}
    return count>1?data:(count>0?(data[mykey]!=''?data:false):false);
}

//获取元素绝对位置
function getabspos(e){var pos={top:0,left:0};while(e){pos.left+=e.offsetLeft;pos.top+=e.offsetTop;e=e.offsetParent;}return pos;};

//确定提交
function confirmit(msg,callback,parm)
{
    var p=parm?parm:[];
    layer.confirm(msg,{icon:3,title:'提示'},function(index){callback.apply(this,p);});
}

//重定向页面
function redirect(url){if(url){window.location.href=url;}else{window.location.reload();}}

//提示信息并重定向
function messagego(msg,status,url,p)
{
    var icon=0;var shift=0;
    var func=typeof(url)=='function'?url:redirect;
    icon=status?1:2;shift=status?5:6;p=p?(typeof(p)=='string'?[p]:p):[];
    layer.msg(msg,{icon:icon,shade:[0.5,'#000'],time:1000,shift:shift},function(){layer.closeAll();p.unshift(url);func.apply(this,p);});
}
//提示信息
function message(msg,status,url,p)
{
    var icon=0;var shift=0;
    var func=status?(typeof(url)=='function'?url:redirect):function(u){};
    icon=status?1:2;shift=status?5:6;p=p?(typeof(p)=='string'?[p]:p):[];
    layer.msg(msg,{icon:icon,shade:[0.5,'#000'],time:1000,shift:shift},function(){layer.closeAll();p.unshift(url);func.apply(this,p);});
}
//提示信息，不做处理
function messagestop(msg,status,url,p)
{
    var icon=0;var shift=0;
    var func=typeof(url)=='function'?url:function(u){};
    icon=status?1:2;shift=status?5:6;p=p?(typeof(p)=='string'?[p]:p):[];
    layer.msg(msg,{icon:icon,shade:[0.5,'#000'],time:1000,shift:shift},function(){layer.closeAll();p.unshift(url);func.apply(this,p);});
}

//提示服务器返回信息--跳转或刷新
function returnmsggo(d){messagego(d.info,d.status,d.url);}
//提示服务器返回信息
function returnmsg(d){message(d.info,d.status,d.url);}
//提示服务器返回信息--永不刷新
function returnmsgstop(d){messagestop(d.info,d.status,d.url);}

//提交数据
function submiter(type,url,data,callback,p)
{
    callback=callback?callback:returnmsg;
    callback=typeof(callback)=='string'?eval('('+callback+')'):callback;
    p=p?p:[];
    $.ajax({type:type,url:url,data:data,success:function(d){p.unshift(d);callback.apply(this,p);}});
}

//下拉分页请求成功
function pagesuccess(txt){var html=$(this).html();$(this).html(html+txt);}
//下拉分页请求失败
function pageerror(e){message('请求失败！');}

//页面加载事件
$(function(){
    /**********页面绑定事件***********/

    //点名自动跳转
    $('[callme]').each(function(){
        var daley=$(this).attr('callme');
        if(daley){window.setInterval(callme,daley*1000);}
        function callme()
        {
            submiter('post','/Home/Public/callme',{sign:user_sign},returnval);
        }
        function returnval(d)
        {
            if(d.status){layer.confirm(d.info,{icon:3,title:'提示'},function(){redirect(d.url);});}
        }
    });

    //自动上报地理位置
    $('[myposition]').each(function(){
        var tim=null;var num=0;
        var daley=$(this).attr('myposition');
        var usertype=$(this).attr('usertype');
        var times=$(this).attr('times');
        daley=parseInt(daley)>0?parseInt(daley):0;
        if(daley){tim=window.setInterval(getposition,daley*1000);}
        function getposition()
        {
            if(navigator.geolocation)
            {
                navigator.geolocation.getCurrentPosition(report,errorfunction);
            }else
            {
                message('浏览器不支持定位功能！');
                window.clearInterval(timer);timer=null;
            }
            num++;
            if(num>=times){closeit();}
        }
        function errorfunction(e)
        {
            if(e.code==1){message('您已拒绝定位，无法获得准确信息，敬请见谅！');closeit();}
        }
        function report(p)
        {
            type=usertype==1?1:2;
            var data={lng:p.coords.longitude,lat:p.coords.latitude,sign:user_sign,type:type};
            submiter('post','/Home/Public/myposition',data,function(d){});
        }
        function closeit(){window.clearInterval(tim);tim=null;}
    });

    //企业端订单改变修改数据
    $('[order-company]').each(function(){
        var self=this;
        var daley=$(this).attr('order-company');
        var oid=$(self).attr('oid');
        daley=parseInt(daley,10)>0?parseInt(daley,10):2;
        daley*=1000;
        
        window.setInterval(requester,daley);
        function requester()
        {
            var status=$(self).attr('ostatus');
            submiter('post','/Home/Public/companyorder',{oid:oid,status:status},resault);
        }
        function resault(d)
        {
            d=eval('('+d+')');
            if(d['changed']==1)
            {
                $(self).attr('ostatus',d.status);
                var str='';
                switch(parseInt(d['status']))
                {
                    case 1:
                        str='<p class="text">已拒绝</p>';
                    break;
                    case 2:
                        str='<a action="/Home/CompanyWorks/cancelorder.html" oid="'+oid+'" class="bt cancel ft14 tx-c">取消订单</a>';
                        str+='<p class="text">已接受</p>';
                        str+='<p class="text">等待到岗</p>';
                    break;
                    case 3:
                        str='<a action="/Home/CompanyWorks/startwork.html" oid="'+oid+'" class="bt startwork ft14 tx-c">查看详情</a>';
                        str+='<a action="/Home/CompanyWorks/cancelorder.html" oid="'+oid+'" class="bt cancel ft14 tx-c">取消订单</a>';
                    break;
                    case 4:
                        str='<a action="/Home/CompanyWorks/cancelorder.html" oid="'+oid+'" class="bt cancel ft14 tx-c">取消订单</a>';
                    break;
                    case 5:
                        str='<a action="/Home/CompanyWorks/finishwork.html" oid="'+oid+'" class="bt finishwork ft14 tx-c">查看详情</a>';
                    break;
                    default:str='';break;
                }
                $(self).html(str);
                $('.cancel').off().on('click',cancels);
                $('.startwork').off().on('click',startwork);
                $('.finishwork').off().on('click',finishwork);
            }
        }
    });

    //个人端订单改变修改数据
    $('[order-user]').each(function(){
        var self=this;
        var daley=$(this).attr('order-user');
        var oid=$(self).attr('oid');
        daley=parseInt(daley,10)>0?parseInt(daley,10):2;
        daley*=1000;
        setInterval(requester,daley);
        function requester()
        {
            var status=$(self).attr('ostatus');
            submiter('post','/Home/Public/userorder',{oid:oid,status:status},resault);
        }
        function resault(d)
        {
            if(d['status']>0){redirect(d.url);}
        }
    });

    //post提交
    $("[poster]").each(function(){
        $(this).click(function(){
            var self=this;
            var prop=$(this).attr('poster');
            var data=getdatas(prop,1);
            var url=$(this).attr('action');
            var func=$(this).attr('return');
            var parm=$(this).attr('parm');
            var confir=$(this).attr('confirm');
            parm=parm?eval('('+parm+')'):'';
            url=url?url:$(this).attr('url');
            if(!data){return false;}
            if(!url){return false;}
            if(confir)
            {
                confirmit(confir,function(){
                    $(self).attr('disabled','disabled');
                    submiter('post',url,data,func,parm);
                });
            }else
            {
                $(this).attr('disabled','disabled');
                submiter('post',url,data,func,parm);
            }
        });
    });
    

    //post提交当前对象信息
    $(".poster").each(function(){
        $(this).click(function(){
            var self=this;
            var data=getdatas(this,'^poster-');
            var url=$(this).attr('action');
            var func=$(this).attr('return');
            var parm=$(this).attr('parm');
            var confir=$(this).attr('confirm');
            parm=parm?eval('('+parm+')'):'';
            url=url?url:$(this).attr('url');
            if(!data){return false;}
            if(!url){return false;}
            if(confir)
            {
                confirmit(confir,function(){
                    $(self).attr('disabled','disabled');
                    submiter('post',url,data,func,parm);
                });
            }else
            {
                $(this).attr('disabled','disabled');
                submiter('post',url,data,func,parm);
            }
        });
    });
    

    //get提交
    $("[geter]").each(function(){
        $(this).click(function(){
            var self=this;
            var prop=$(this).attr('geter');
            var data=getdatas(prop,1);
            var func=$(this).attr('return');
            var url=$(this).attr('action');
            var parm=$(this).attr('parm');
            var confir=$(this).attr('confirm');
            parm=parm?eval('('+parm+')'):'';
            url=url?url:$(this).attr('url');
            if(!url){return false;}
            if(confir)
            {
                confirmit(confir,function(){
                    $(self).attr('disabled','disabled');
                    submiter('post',url,data,func,parm);
                });
            }else
            {
                $(this).attr('disabled','disabled');
                submiter('post',url,data,func,parm);
            }
        });
    });
    

    //get提交当前对象信息
    $(".geter").each(function(){
        $(this).click(function(){
            var self=this;
            var data=getdatas(this,'^geter-');
            var url=$(this).attr('action');
            var func=$(this).attr('return');
            var parm=$(this).attr('parm');
            var confir=$(this).attr('confirm');
            parm=parm?eval('('+parm+')'):'';
            url=url?url:$(this).attr('url');
            if(!url){return false;}
            if(confir)
            {
                confirmit(confir,function(){
                    $(self).attr('disabled','disabled');
                    submiter('post',url,data,func,parm);
                });
            }else
            {
                $(this).attr('disabled','disabled');
                submiter('post',url,data,func,parm);
            }
        });
    });
    

    //get获取当前对象信息
    $(".loader").each(function(){
        $(this).click(function(){
            var type=0;var button=[];var options={};
            var title=$(this).text();
            var url=$(this).attr('action');
            var shadeclose=$(this).attr('shadeclose');
            var area=$(this).attr('area');
            var btn=$(this).attr('buttons');
            var func=$(this).attr('return');
            url=url?url:$(this).attr('url');
            title=title?title:'提示！';
            shadeclose=shadeclose=='true'?true:false;
            area=area?split(area):['90%','90%'];
            btn=btn?btn.split(','):[];
            func=func?func.split(','):[];
            var len=Math.min(btn.length,func.length);
            
            if(!url){return false;}
            type=/\/+/.test(url)?2:1;
            url=type==1?$(url):url;
            options={type:type,title:title,shadeClose:shadeclose,shade:0.5,area:area,content:url};
            
            for(var i=0;i<len;i++)
            {
                button.push(btn[i]);
                if(i==0){options['yes']=eval('('+func[i]+')');}else{options['btn'+(i+1)]=eval('('+func[i]+')');}
            }
            options['btn']=button;
            layer.open(options);
            var init = $(this).data('init');
            if(init) {
                var a = eval('('+init+')');
                a.call();
            }
        });
    });
    

    //上传
    $("[uploader]").each(function(){
        var self=this;
        var prop=$(this).attr('uploader');
        var action=$(this).attr('action');
        var func=$(this).attr('return');
        var parm=$(this).attr('parm');
        var file=$("["+prop+"='file']");
        var returnval=$("["+prop+"='returnval']");
        var img=$("["+prop+"='img']");
        var point=getabspos(this);
        file.width($(this).width());
        file.height($(this).height());
        file.css({'position':'absolute','left':point.left+'px','top':point.top+'px'});
        parm=parm?eval('('+parm+')'):[];
        file.change(function(){
            var pa=$(this).parent();
            var id=pa.attr('id');
            id=typeof(id)!='undefined'?id:'';
            if(id!='myupload_'+prop)
            {
                $(file).wrap("<form id='myupload_"+prop+"' action='"+action+"' method='post' enctype='multipart/form-data'></form>");
            }
            $('#myupload_'+prop).ajaxSubmit({
                dataType:'json',
                beforeSend:function(){layer.load(1,{shade:[0.1,'#fff']});},
                success:function(d)
                {
                    parm.unshift(d);
                    if(func){eval('('+func+')').apply(self,parm);}else
                    {
                        returnmsgstop(d);
                        if(d.status==1)
                        {
                            if(img.size()>0){img.attr('src',d.url);img.show();}
                            if(returnval.size()>0){returnval.val(d.url);}
                        }
                    }
                }
            });
        });
    });

    //下拉滚动分页
    $('[pages]').each(function(){
        var url=$(this).attr('action');
        var start=$(this).attr('start');
        var success=$(this).attr('success');
        var error=$(this).attr('error');
        var attrs=this.attributes;
        var data={};var count=0;
        url=url?url:$(this).attr('url');
        start=parseInt(start)>0?parseInt(start):1;
        for(var i=0;i<attrs.length;i++)
        {
            if(!/page-/.test(attrs[i].name)){continue;}
            var key=attrs[i].name.split('-')[1];
            var val=attrs[i].value;
            data[key]=val;
        }
        success=success?eval('('+success+')'):pagesuccess;
        error=error?eval('('+error+')'):pageerror;

        var options={container:this,url:url,startPage:start,postdata:data,success:success,error:error};
        $(this).pageLoading(options);
    });

    //切换身份
    $("[changer]").each(function(){
        var usertype=$(this).attr('changer');
        var msg=usertype?(usertype==1?'您当前登录为企业用户，确定切换为个人用户吗？':'您当前登录为个人用户，确定切换为企业用户吗？'):'';
        if(msg)
        {
            layer.confirm(msg,{icon:3,title:'提示'},function(index){submiter('post','/Public/changetype',{type:usertype});});
        }
    });

    /**********页面绑定事件***********/
});

//异步请求下拉分页
$.fn.extend({
    pageLoading: function(a)
    {
        a = jQuery.extend({url: "",container:window,event: "scroll",startPage:1,bottomHeight: 100,success: function() {},error: function() {}},a || {});
        if (a.url === undefined || a.url === null || a.url === "") {return ;}
        var e = $(this);
        var boo=false;
        var height=0;
        if(a.container==window||a.container.nodeName.toLowerCase()=='body')
        {
            a.container=$(document);
            height=$(document).height();
        }else
        {
            $(a.container).children().each(function(){height+=$(this).height();});
        }
        $(a.container).bind(a.event,
        function(){
            if ( height - $(a.container).height() - $(a.container).scrollTop() < a.bottomHeight) {
                f()
            }
        });
        function f()
        {
            if(boo){return ;}
            boo=true;
            a.postdata.page = a.startPage;
            $.ajax({
                url:  a.url,
                data: a.postdata,
                type: 'post',
                cache:false,
                dataType: 'json',
                beforeSend:function(){layer.closeAll();layer.load(2,{shade: [0.1, '#fff']})},
                error:function(XMLHttpRequest, textStatus, errorThrown){a.error.call(a.container,XMLHttpRequest);},
                success:function(txt){boo=false;a.startPage++;a.success.call(a.container,txt);layer.closeAll();}
            });
        }
    }
});