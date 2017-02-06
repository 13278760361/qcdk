<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class ContactController extends HBaseController {

	 function _initialize(){
	 	parent::_initialize();
        $this->db=M('Users');
        $this->db_sign_history =M('Sign_history');
        $this->db_depart = M('Depart');

        //开启调试
        // $this->user_id = 22;
	 }

  public function index(){

    if ( empty($this->user_id) ) {
          redirect( U('Public/bind') );
      }

      $depart_lists = $this->db_depart->field('id,depart_name')->select();
      

      foreach ($depart_lists as $key => $val) {
            $users_lists = $this->db->field('username,phone')-> where( array('depart_id'=> $val['id']) )->select();
            $depart_lists[$key]['users_num'] = $this->db->where( array('depart_id'=> $val['id']) )->count();
          
            $depart_lists[$key]['users'] = $users_lists;

              unset($depart_lists[$key]['id']);

       } 

       // dump($depart_lists);


      $this->assign('depart_lists',$depart_lists);
      $this->display();
          
  }

  public function userSearch(){
       $keyword = I('post.keyword');
       $field ="username,phone";
       $where = "username like '%{$keyword}%'";
       $lists = $this->db->where($where)->select();
       $this->assign('lists',$lists);
       $this->assign('keyword',$keyword); 
       $this->display();
  }

  

}
