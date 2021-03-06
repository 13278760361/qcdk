<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo CS_PATH;?>pintuer.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo CS_PATH;?>fangcms.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo CS_PATH;?>bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo CS_PATH;?>bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="fangcms_box">

<div class="form-group">
    <div>
        <label>
            非弹性工作部门导出:</label>
    </div>
    <div class="field" style="margin-top: 1px">
        <select name="depart_id" class="input" id="" >
            <option value="0" >请选择部门</option>
            <?php if(is_array($departs)): $i = 0; $__LIST__ = $departs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" ><?php echo ($vo["depart_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>

    <div class="form-group">
        <p style="color: darkgray;">开始时间:</p>
        <input class="input" data-date="" data-date-format="dd MM yyyy" size="16" type="text" id="form_dstime" readonly style="margin-left: -1px;"   >
        <p style="color: darkgray;">结束时间:</p>
        <input class="input" size="16" type="text" id="form_detime" readonly style="margin-left: -1px;" >
        <button class="buttont" type="button" id="DepartExt" style="margin-top: 5px">
            导出</button>
    </div>

</div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="margin-left: -15px;">弹性工作部门导出:</label>
        <br>
            <p style="color: darkgray;">开始时间:</p>
            <input class="input" data-date="" data-date-format="dd MM yyyy" size="16" type="text" id="form_stime" readonly style="margin-left: -1px;"   >
            <p style="color: darkgray;">结束时间:</p>
            <input class="input" size="16" type="text" id="form_etime" readonly style="margin-left: -1px;" >
        <button class="buttont" type="button" id="MonthExt" style="margin-top: 5px">
        导出</button>
    </div> 


</div>
</body>
</html>
<script src="<?php echo JS_PATH;?>jquery.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>pintuer.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>/lib/layer/layer.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>

<script type="text/javascript">
    //部门
    $('#form_dstime').datetimepicker({
        format: 'yyyy-mm-dd',
        language:  'zh',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#form_detime').datetimepicker({
        format: 'yyyy-mm-dd',
        language:  'zh',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#DepartExt').on('click',function(){
        var st = $('#form_dstime');
        var et = $('#form_detime');
        var did = $('select option:selected');
        if(st.val()==''){
            layer.tips('请选择', st);
            st.focus();
            return false
        }
        if(et.val()==''){
            layer.tips('请选择',et);
            et.focus();
            return false;
        }
        if(et.val() < st.val()){
            parent.layer.msg('开始时间不能小于结束时间,请重新选择', {
                offset: 200,
                shift: 1,
                time: 1200, //2秒关闭（如果不配置，默认是3秒）
            });
            return false;
        }
        if(did.val()==0){
            parent.layer.msg('请选择部门', {
                offset: 200,
                shift: 1,
                time: 1200, //2秒关闭（如果不配置，默认是3秒）
            });
            return false;
        }
        var dstime = st.val();
        var detime = et.val();
        window.location.href ="/Admin/Work/DepartExt/dst/"+dstime+'/det/'+detime+'/did/'+did.val();
    })
    //时间
    $('#form_stime').datetimepicker({
        format: 'yyyy-mm-dd',
        language:  'zh',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#form_etime').datetimepicker({
        format: 'yyyy-mm-dd',
        language:  'zh',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('#MonthExt').on('click',function(){
        var st = $('#form_stime');
        var et = $('#form_etime');
        if(st.val()==''){
            layer.tips('请选择', st);
            st.focus();
            return false
        }
        if(et.val()==''){
            layer.tips('请选择',et);
            et.focus();
            return false;
        }
        if(et.val() < st.val()){
            parent.layer.msg('开始时间不能小于结束时间,请重新选择', {
                offset: 200,
                shift: 1,
                time: 1200, //2秒关闭（如果不配置，默认是3秒）
            });
            return false;
        }
        var stime = st.val();
        var etime = et.val();
        window.location.href ="/Admin/Work/MonthExt/st/"+stime+'/et/'+etime;
    })

</script>