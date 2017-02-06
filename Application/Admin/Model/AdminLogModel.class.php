<?php 
namespace Admin\Model;
use Think\Model;
class AdminLogModel extends Model {
    protected $_auto = array (
        array('action_id', 'getAdminId', Model:: MODEL_BOTH, 'callback'),
        array('action_group', 'getAdminGroup', Model:: MODEL_BOTH, 'callback'),
        array('action_user','getAdminName', Model:: MODEL_BOTH,'callback'),
        array('action_ip', 'get_client_ip', Model:: MODEL_BOTH, 'function'),
        array('time','time',Model:: MODEL_BOTH,'function'), // 对update_time字段在更新的时候写入当前时间戳
    );

    public function write_log($msg,$status) {
        $info = array();
        // dump($msg);
        // exit();
        $info['remark'] = $msg; //操作说明
        $info['action_status'] = $status;//操作状态 0 失败 1成功
        if($info['remark']){

            if($info = $this->create($info)){
            $this->add($info);
            // echo $this->getlastsql();
            };
        };
        return TRUE;
    }

    public function getAdminId() {
        return session('admin_id');
    }

    public function getAdminName(){
        return session('admin_username');
    }

    public function getAdminGroup(){
        $group_name = M('admin_auth_group_access a')->join('__ADMIN_AUTH_GROUP__ g ON a.group_id=g.id')->where(array('a.uid'=>session('admin_id')))->getField('g.title');
        return $group_name;
    }

    // private function get_log_msg() {
    //     $sqlmap = array();
    
    //     $sqlmap['name'] = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
    //     $msg = M('Admin_auth_rule')->where($sqlmap)->getField('title');
    //     return $msg ? $msg : '';
    // }
}