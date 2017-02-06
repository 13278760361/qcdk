<?php if (!defined('THINK_PATH')) exit();?><link href="<?php echo CS_PATH;?>pintuer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CS_PATH;?>fangcms.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>jquery.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>pintuer.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>/lib/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>jquery.easyui.min.js" type="text/javascript"></script>
<div class="fangcms_box">
    <form method="post">
        <div class="form-group">
            <div class="label">
                <label>
                    奖品名称:</label>
            </div>
            <div class="field">
                <input type="text" class="input" id="prize_name" name="prize_name" size="50" placeholder="奖品名称" value="<?php echo ($info["prize_name"]); ?>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="label">
                <label >
                    奖品场景:</label>
            </div>
            <div class="field" id="scene_id">
                <select name="scene_id" class="input" id="">
                    <option value="0" >请选择</option>
                    <?php if(is_array($sceneList)): $i = 0; $__LIST__ = $sceneList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($info["scene_id"]) == $vo["id"]): ?>selected<?php endif; ?>><?php echo ($vo["scene_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="label">
                <label >
                    奖品类型:</label>
            </div>
            <div class="field" id="type_id">
                <select name="type" class="input" id="">
                    <option value="0" >请选择</option>
                    <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>" <?php if(($info["type"]) == $vo): ?>selected<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="label">
                <label for="prize">奖品图片<font color="red" style="font-size:10px;">[*建议上传的图]</font></label>
            </div>
            <div class="field">
                <a class="button input-file" href="javascript:void(0);">+ 浏览文件<input name="file" id="prize" size="100" type="file" data-validate="required:请上传奖品图片"/></a>
                <input type="hidden" id="site_prize" name="site_prize" value="<?php echo ($info["pic"]); ?>">
            </div>
        </div>
        <img src="<?php echo ($info["pic"]); ?>" width="100" height="100" class="img-border radius-small" id="prize_img" />
        <div class="form-group">
            <div class="label">
                <label >
                    奖品金额:&nbsp;&nbsp;<font color="red" style="font-size:10px;">[*每个红包金额必须大于1元，小于200元（可联系微信支付wxhongbao@tencent.com申请调高额度）]</font></label>
            </div>
            <div class="field">
                <input type="text" class="input" id="money" name="money" size="50" placeholder="奖品金额"  value="<?php echo ($info["money"]); ?>"/>
            </div>
        </div>

        <div class="form-group">
            <div class="label">
                <label >
                    奖品数量:</label>
            </div>
            <div class="field">
                <input type="text" class="input" id="num" name="num" size="50" placeholder="奖品数量" value="<?php echo ($info["num"]); ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="label">
                <label >
                    奖品概率:</label>
            </div>
            <div class="field">
                <input type="text" class="input" id="prob" name="prob" size="50" placeholder="奖品概率" value="<?php echo ($info["prob"]); ?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="label">
                <strong>状态</strong>
            </div>
            <div class="field">
                <div class="button-group radio">
                    <label class="button <?php if(($info["status"]) == "1"): ?>active<?php endif; ?>">
                        <input name="status" value="1"  type="radio"><span class="icon icon-check text-green"></span> 启用
                    </label>
                    <label class="button <?php if(($info["status"]) == "-1"): ?>active<?php endif; ?>">
                        <input name="status" value="-1"  type="radio"><span class="icon icon-check text-green"></span> 禁用
                    </label>
                </div>
            </div>
            <input type="text" name="ids" hidden="hidden" value="<?php echo ($ids); ?>">
        </div>
        <div class="form-button">
            <button class="button" type="button" onclick="edit()">
                提交</button>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
<script>
$(function () {

        $("#prize").wrap("<form id='upload'  method='post' enctype='multipart/form-data'></form>");

        $("#prize").change(function(){

        $('#upload').form('submit', {      
                      type: 'POST',
                      url: "<?php echo U('Upload/index');?>",
                         onSubmit: function(param){
                            param.Type   = 'prize/';   //图片存储路径
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

                                $("#prize_img").attr('src',data);

                                $("input[name='site_prize']").val(data);

                                layer.closeAll()

                            }
                        }
                });

        });

    });
    function edit(){
        var prize_name = $("input[name='prize_name']");
        var money = $("input[name='money']");
        var status = $(".active input[name='status']");
        var type_id = $("#type_id select");
        var num = $("input[name='num']");
        var prob = $("input[name='prob']");
        var scene_id = $("#scene_id select");
        var prize_pic = $("input[name='site_prize']");
        //var ids = $("input[name='ids']");
        if(prize_name.val()==''){
            layer.tips('必填*', prize_name);
            prize_name.focus();
            return false
        }
        if(type_id.val()=='0'){
            layer.tips('必填*',type_id);
            type_id.focus();
            return false
        }
        // if(money.val()==''){
        //     layer.tips('必填*',money);
        //     money.focus();
        //     return false
        // }
        if(money.val()<1 && money.val()!=""){
            layer.tips('大于1*',money);
            money.focus();
            return false
        }
        if(money.val()>200 && money.val()!=""){
            layer.tips('小于200*',money);
            money.focus();
            return false
        }
        var z= /^[0-9]*$/;
        if(!z.test(num.val())){
            layer.tips('数字*',num);
            num.focus();
            return false;
        }
        if(!z.test(prob.val())){
            layer.tips('数字*',prob);
            prob.focus();
            return false;
        }
        if(scene_id.val() == '0'){
            layer.tips('必填*',scene_id);
            scene_id.focus();
            return false
        }
        // if(!z.test(money.val())){
        //     layer.tips('数字*',money);
        //     money.focus();
        //     return false
        // }
        $('.button').attr("disabled","disabled");//防止重复提交
        $.post("<?php echo U('Prize/edit');?>",{
            prize_name:prize_name.val(),
            //order:order.val(),
            status:status.val(),
            money:money.val(),
            type_id:type_id.val(),
            num:num.val(),
            prob:prob.val(),
            scene_id:scene_id.val(),
            id:<?php echo ($_GET['id']); ?>,
            prize_pic:prize_pic.val(),
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
                    time: 1600 //2秒关闭（如果不配置，默认是3秒）
                });
                $('.button').removeAttr('disabled');//防止重复提交
            }
        });
    }
</script>