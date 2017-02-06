<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class PublicController extends HBaseController {

	 function _initialize(){
	 	parent::_initialize();
        $this->db=M('Users');
        $this->db_sign_history =M('Sign_history');
        $this->db_depart=M('Depart');

        //调试开启
        // $this->user_id  =22;
	 }
  //签到绑定用户页面（个人）
  public function bind(){ 

      if (IS_POST) {
           $_data = I('post.');
              //基础数据
              $username = $_data['username'];
              $phone = $_data['phone'];
              $sex = $_data['sex'];
              $depart_id = $_data['depart_id'];
              if ( empty($username) ) {
                   $this->error('员工姓名不能为空');
              }

              if ( empty($sex) ) {
                 $this->error('请选择性别');
              }

              if ( empty($phone) ) {
                  $this->error('员工电话不能为空');
              }else{

                  $isMob="/^1[3-5,8]{1}[0-9]{9}$/";
                   if(!preg_match($isMob,$phone)){
                      $this->error('电话号码格式不正确，请重新输入'); 
                    }else{
                       if ( $this->db->where(array('phone'=>$data['phone']))->find() ) {
                          $this->error('电话号码已经存在！');
                       }
                    }
              }

              

              if ( empty($depart_id) ) {
                 $this->error('请选择部门');
              }
            

              if ( $info = $this->db->where( array('username'=>$username,'phone'=>$phone) )->find() ) {
                //用户数据存在的话授权
                      $data['id'] = $info['id'];
                      $data['openid']  = $this->wx_info['openid'];
                      $data['wx_nickname'] = deal_emoji($this->wx_info['nickname'],0);
                      $data['province'] = $this->wx_info['province'];
                      $data['city'] = $this->wx_info['city'];
                      $data['country'] = $this->wx_info['country'];
                      $data['headimgurl'] = $this->wx_info['headimgurl'];

                      $res = $this->db->save($data);

                      if ( $res !== false ) {
                          $this->success('绑定成功',U('Center/index',array( 'id'=>$data['id']) ));
                      }else{
                          $this->error('绑定失败'); 
                      }


              }else{
                //用户数据不存在
                $this->error('用户不存在！');
              }
            
      }else{
         $departs =  $this->db_depart->field('id,depart_name')->order('orders ASC')->select();
         $this->assign('departs',$departs);
         $this->display();
      }
  }
  
  //签到成功页面（个人） 
  public function signSuccess(){
  
    $field='u.username,d.depart_name';
    $where="u.depart_id = d.id and u.id = {$this->user_id}";
    $info = $this->db->table('qcdk_users u,qcdk_depart d')->field($field)->where($where)->find();
    $this->assign('info',$info);
    $this->display();
  }

  //签到记录(个人)

  public function signInfo(){
    if ( empty($this->user_id) ) { //没有用户信息
          redirect( U('Public/bind') );
      }

     $now_time = time(); //当前时间
     $start = mktime(0,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//获取今天开始时间
     $end = mktime(23,59,59,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//获取进入结束时间
    

     $whereS['user_id'] = $this->user_id;
     $whereS['sign_time'] = array('between',array($start,$end));
     $whereS['sign_type'] = 1; //上班打卡时间查询条件

     if ( !$this->db_sign_history->where($whereS)->find() ) { //如果没有今天打卡记录的话 提示页面
           redirect( U('Index/signPrompt') );    
     }
         
     $start_time = $this->db_sign_history->where($whereS)->getField('sign_time');


     $whereE['user_id'] = $this->user_id;
     $whereE['sign_time'] = array('between',array($start,$end));
     $whereE['sign_type'] = 2; //下班打卡时间查询条件

     $end_time = $this->db_sign_history->where($whereE)->max('sign_time');

   if ( empty($end_time) ) { //火箭飞起状态判断
        $rocketStatus = false;
     }else{
        $rocketStatus = true;
     }

     $start_time = !empty($start_time)?date('H:i',$start_time):null;
     $end_time   = !empty($end_time)?date('H:i',$end_time):null;


     
     $this->assign('start_time',$start_time); 
     $this->assign('end_time',$end_time);
     $this->assign('rocketStatus',$rocketStatus);

     $this->display();

  }






}
