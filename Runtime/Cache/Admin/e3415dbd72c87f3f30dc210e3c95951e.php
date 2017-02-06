<?php if (!defined('THINK_PATH')) exit();?><link href="<?php echo CS_PATH;?>pintuer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CS_PATH;?>fangcms.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>jquery.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>pintuer.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>/lib/layer/layer.js" type="text/javascript"></script>

<div class="fangcms_box">
    <form method="post">
        <div class="form-group">
            <div class="label">
                <label for="scene_name">
                    场景名称:</label>
            </div>
            <div class="field">
                <input type="text" class="input" id="scene_name" name="scene_name" size="50" placeholder="场景名称" />
            </div>
        </div>
        <!--<div class="form-group">
            <div class="label">
                <label for="order">
                    排序:</label>
            </div>
            <div class="field">
                <input type="text" class="input text-left sort-input " id="order" name="order" size="50" value="0"/>
            </div>
        </div>-->
        <div class="form-group">
            <div class="label">
                <strong>状态</strong>
            </div>
            <div class="field">
                <div class="button-group radio">
                    <label class="button active">
                        <input name="status" value="1"  type="radio"><span class="icon icon-check text-green"></span> 启用
                    </label>
                    <label class="button">
                        <input name="status" value="-1" type="radio"><span class="icon icon-times"></span> 禁用
                    </label>
                </div>
            </div>
        </div>
        <div class="form-button">
            <button class="button" type="button" onclick="add()">
                提交</button>
        </div>
    </form>
</div>
<script>
    function add(){
        var scene_name = $("input[name='scene_name']");
        //var order = $("input[name='order']");
        var status = $(".active input[name='status']");
        if(scene_name.val()==''){
            layer.tips('必填*', scene_name);
            scene_name.focus();
            return false
        }
        var z= /^[0-9]*$/;
        // if(!z.test(order.val())){
        //     layer.tips('数字',order);
        //     order.focus();
        //     return false;
        // }
        $('.button').attr("disabled","disabled");//防止重复提交
        $.post("<?php echo U('Prize/red_add');?>",{
            scene_name:scene_name.val(),
            //order:order.val(),
            status:status.val(),
        },function(res){
            if(res.status==1){
                parent.layer.msg(res.info, {
                    offset: 200,
                    shift: 1,
                    time: 800 //2秒关闭（如果不配置，默认是3秒）

                }, function(){
                    parent.location.reload()
                    parent.layer.closeAll()
                });
            } else{
                layer.msg(res.info, {
                    offset: 200,
                    shift: 2,
                    time: 800 //2秒关闭（如果不配置，默认是3秒）
                });
            }
        });
    }
</script>