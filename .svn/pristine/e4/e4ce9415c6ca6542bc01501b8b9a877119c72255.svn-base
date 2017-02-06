var System = { 
    add:function(title,url){ //添加
            layer.open({
                type: 2,
                area: ['850px', '560px'],
                fix: true, //不固定
                maxmin: true,
                title:title,
                content: url
            });
    },
    clear:function(url){
        layer.confirm('确定要清空这个月的工资信息?',{icon:3},function(){
            $.ajax({
                type:'POST',
                url:url,
                dataType:'json',
                beforeSend:function(){
                  layer.closeAll();
                  layer.load(2,{shade:[0.1,'#000']});
                },
                success:function(res){
                    layer.closeAll();
                    if (res.status == 1) {
                        layer.msg(res.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(res.info,{icon: 5});
                    }
                },
            });
        });
    },
    del:function(id,name,url){ //删除
        if(id == ''){
            layer.alert('请选择要删除的',{icon: 5});
            return false;
        }
        layer.confirm('确定要删除 "'+ name +'" 吗？', {icon: 3},function(){

            $.ajax({
                type: 'POST', 
                url: url,
                data:{
                    ids:id
                },
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },
    edit:function(title,url){ //修改
        layer.open({
            type: 2,
            area: ['850px', '560px'],
            fix: true, //不固定
            maxmin: true,
            title:title,
            content: url
        });
    },
      logout:function(url){ //退出
        layer.confirm('确定要退出吗？', {icon: 3},function(){

        parent.layer.msg('退出成功!', {

          shift: 2,

          time: 1000,

          shade: [0.1,'#000'],

          end: function(){

            window.location.href = url;

          }

        });

      });
    },

    clearCache:function(url){ //清除缓存
        layer.confirm('确定要清除缓存吗？', {icon: 3},function(){
            $.ajax({
                type: 'POST', 
                url: url,
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                 parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },
    data:function(table,title,operation,url){ //删除
        if(table == ''){
            layer.alert('请选择要'+operation+'的数据',{icon: 5});
            return false;
        }
        layer.confirm('确定要'+operation+' "'+ title +'"数据吗？', {icon: 3},function(){
            $.ajax({
                type: 'POST', 
                url: url,
                data:{
                    tables:table
                },
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },

    data_import:function(name,part,compress,url){ //删除
        if(name == ''){
            layer.alert('请选择要还原的数据',{icon: 5});
            return false;
        }
        layer.confirm('确定要还原 "'+ name +'"数据表吗？', {icon: 3},function(){
            $.ajax({
                type: 'POST', 
                url: url,
                data:{
                    name:name,
                    part:part,
                    compress:compress,
                },
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },
    file_del:function(file,name,url){ //删除
        if(file == ''){
            layer.alert('请选择要删除的文件',{icon: 5,offset:200});
            return false;
        }
        layer.confirm('确定要删除 "'+ name +'"文件？(请谨慎删除！否则网页图片无法显示)', {icon: 3,offset: 200},function(){
            $.ajax({
                type: 'POST', 
                url: url,
                data:{
                    files:file
                },
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },
    clearFiles:function(url){ //清除缓存
        layer.confirm('定期自动清理无用图片，可以让你的系统干干净净！', {icon: 3},function(){
            $.ajax({
                type: 'POST', 
                url: url,
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                 parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },
    del_menu:function(id,name,url){ //删除
        if(id == ''){
            layer.alert('请选择要删除的',{icon: 5});
            return false;
        }
        layer.confirm('确定要删除 "'+ name +'" 吗？,注:若删除一级菜单，其子菜单也会被删除！', {icon: 3},function(){

            $.ajax({
                type: 'POST', 
                url: url,
                data:{
                    ids:id
                },
                dataType: "json",
                beforeSend: function() {
                  layer.closeAll();
                  layer.load(2,{shade: [0.1,'#000']});
                },
                success: function(data){
                  layer.closeAll();
                    if (data.status == 1) {
                       layer.msg(data.info, {
                            shift: 2,
                            time: 1000,
                            shade: [0.1,'#000'],
                            end: function(){
                                // $("#tr"+id).remove();
                                parent.location.reload()
                            }
                        });
                    }else{
                        layer.alert(data.info,{icon: 5});
                    }
                }
            });
        });
    },
    
}


function getID(url){

    obj = $("input[name='id']")
    ids = [];
    for(k in obj){
        if(obj[k].checked)
            ids.push(obj[k].value);
    }
     parent.System.del(ids,'所勾选的么',url)
}

function getTable(operation,url){
    obj=$("input[name='table_name']");
    tables =[];
    for (k in obj) {
     if (obj[k].checked)
        tables.push(obj[k].value);
    }
    // alert(tables);
    parent.System.data(tables,'所勾选的',operation,url)
}

function getFile(url){
    obj=$("input[name='file_name']");
    files =[];
    for (k in obj) {
     if (obj[k].checked)
        files.push(obj[k].value);
    }
    // alert(tables);
    System.file_del(files,'所勾选的',url)
}

function getSearch(){
   $('#search').click();
}

$(document).ready(function(){
  var NodeName =  $(".active ul .active a").html();
   $(".admin-bread ul.bread li:last-child").html(NodeName);
})
