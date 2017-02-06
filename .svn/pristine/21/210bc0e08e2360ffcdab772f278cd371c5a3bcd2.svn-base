<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class CenterController extends HBaseController {

	 function _initialize(){
	 	parent::_initialize();
        $this->db=M('Users');
        $this->db_sign_history =M('Sign_history');

        //调试开启
        // $this->user_id = 1;
	 }

  public function index(){
      if ( empty($this->user_id) ) {
          redirect( U('Public/bind') );
      }
      $field ="u.username,u.headimgurl,u.sex,u.phone,d.depart_name,job_number";
      $where="u.id = {$this->user_id} and u.depart_id = d.id";
      $info = $this->db->table('qcdk_users u,qcdk_depart d')->field($field)->where( $where )->find();
      $this->assign('info',$info);
      $this->display();
          
  }

  

}
