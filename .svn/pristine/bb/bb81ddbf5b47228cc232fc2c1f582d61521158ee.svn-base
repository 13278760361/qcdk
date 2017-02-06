<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
class SystemController extends ABaseController{
    public function index(){
       if (IS_POST) {
     $file = I('post.file');
    		$post = I('post.');

    		if (isset($_POST['UPLOAD_PATH'])) {
    			if (!is_dir($_POST['UPLOAD_PATH'])) {
    				mkdir($_POST['UPLOAD_PATH']);
    			}
    		}
		      if (file_exists(CONF_PATH.$file)) {
		      	unset($post['file']);
				if ($this->update_conf(daddslashes($post),CONF_PATH.$file)) {
					 //日志记录
                        aWriteLog('修改配置文件--'.$file,1);
						$this->success('配置成功');
				}else{
					//日志记录
                        aWriteLog('修改配置文件--'.$file,0);
					$this->error('操作失败');
				}
			}

     	
     	}else{
     	$this->display();
     	}	
    }


     private function update_conf($config,$files){
		if (file_put_contents($files, "<?php\nreturn " .stripslashes(var_export($config, true))."; ")) {
			return true;
		}else{
			return false;
		}
	}
}