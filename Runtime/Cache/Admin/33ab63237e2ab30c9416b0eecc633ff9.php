<?php if (!defined('THINK_PATH')) exit();?><link href="<?php echo CS_PATH;?>pintuer.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CS_PATH;?>fangcms.css" rel="stylesheet" type="text/css" />
<script src="<?php echo JS_PATH;?>jquery.min.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>pintuer.js" type="text/javascript"></script>
<script src="<?php echo JS_PATH;?>/lib/layer/layer.js" type="text/javascript"></script>

<div class="fangcms_box">
    <form method="post" action="<?php echo U('Admin/ExcelSalary/impsalary');?>" enctype="multipart/form-data">
        <div class="form-group">
            <div class="label">
                <label>
                    导入工资条:</label>
            </div>
            <div class="field">
                <input type="file" name="salary"/>
            </div>
        </div>
        <div class="form-button">
            <input class="button" type="submit" value="导入">
        </div>
    </form>
</div>