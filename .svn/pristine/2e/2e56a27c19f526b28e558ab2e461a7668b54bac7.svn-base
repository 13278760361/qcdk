<?php 
namespace Admin\Controller;
use Common\Controller\ABaseController;
class CacheController extends ABaseController { 
    public function ClearCache(){
      $Cache = array(
            "cache" => RUNTIME_PATH . 'Cache/',
            "data" => RUNTIME_PATH . 'Data/',
            "logs" => RUNTIME_PATH . 'Logs/',
            "temp" => RUNTIME_PATH . 'Temp/',
    );

    foreach($Cache as $val){
       del_files($val);
    }
      $this->success('成功清除缓存');
    }
}