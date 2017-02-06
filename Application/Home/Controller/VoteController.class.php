<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class VoteController extends HBaseController {
     public $list_vost;
     function _initialize(){
        parent::_initialize();
        // $this->db=M('Users');
        // $this->db_sign_history =M('Sign_history');
        // $this->db_depart = M('Depart');
        //$this->user_id = 59;
        //开启调试
        // $this->user_id //当前用户ID
        $this->endTime = '2016-09-29 14:00:00';
      $this->list_vost = array(
          array('id'=>1,'img'=>'/vote/uploads/1a.jpg','bimg'=>'/vote/uploads/1.jpg'),
          array('id'=>2,'img'=>'/vote/uploads/2a.jpg','bimg'=>'/vote/uploads/2.jpg'),
          array('id'=>3,'img'=>'/vote/uploads/3a.png','bimg'=>'/vote/uploads/3.jpg'),
          array('id'=>4,'img'=>'/vote/uploads/4a.jpg','bimg'=>'/vote/uploads/4.jpg'),
          array('id'=>5,'img'=>'/vote/uploads/5a.jpg','bimg'=>'/vote/uploads/5.jpg'),
          array('id'=>6,'img'=>'/vote/uploads/6a.png','bimg'=>'/vote/uploads/6.jpg'),
          array('id'=>7,'img'=>'/vote/uploads/7a.jpg','bimg'=>'/vote/uploads/7.jpg'),
          array('id'=>8,'img'=>'/vote/uploads/8a.png','bimg'=>'/vote/uploads/8.jpg'),
          array('id'=>9,'img'=>'/vote/uploads/9a.png','bimg'=>'/vote/uploads/9.png'),
          array('id'=>10,'img'=>'/vote/uploads/10a.jpg','bimg'=>'/vote/uploads/10.jpg'),
          array('id'=>11,'img'=>'/vote/uploads/11a.png','bimg'=>'/vote/uploads/11.jpg')
      );
	 }

  public function index(){
      $endTime = $this->endTime;
      $timeNum = strtotime($endTime) - time();
      $where['user_id'] = $this->user_id;
      $vote = M('vote')->where($where)->find();
      $this->assign('user_id',$this->user_id);
      $this->assign('timeNum',$timeNum);
      $this->assign('vote',$vote);
      $list_vost = $this->list_vost;
      $allcount = M('vote')->count();
      foreach($list_vost as $key => $val){
          $resCount = M('vote')->where(array('sx_id'=>$val['id']))->count();
          $list_vost[$key]['count'] = $resCount;
          $list_vost[$key]['precent'] = $resCount/$allcount * 100;
      }
      $this->assign('allcount',$allcount);
      $this->assign('list_vost',$list_vost);
      $this->display();
          
  }
  public function addVote(){
      if(time() > strtotime($this->endTime)){
        $this->error('投票已经结束!');
      }
      $where['user_id'] = $this->user_id;
      $vote = M('vote')->where($where)->find();
      if($vote){
          $this->error('您已经投票!');
      } else {
          $content = $_POST['sendCon'];
          if($content == '' || strlen($content) < 8){
             $this->error('字数不够!');
          }
          $data['content'] = $content;
          $data['user_id'] = $this->user_id;
          $data['vote_id'] = 1;
          $data['sx_id'] = $_POST['id'];
          $data['time'] = time();
          $res = M('vote')->add($data);
          if($res){
            $this->success('您投票成功!');
          } else {
            $this->error('您投票失败!');
          }
      }
  }
  public function resultList(){
      if($this->user_id != 59){
          $this->error('无权限查看!');
      }
      $list_vost = $this->list_vost;
      $allcount = M('vote')->count();
      foreach($list_vost as $key => $val){
          $resList = M('vote')->where(array('sx_id'=>$val['id']))->select();
          $resCount = count($resList);
          $list_vost[$key]['count'] = $resCount;
          $list_vost[$key]['precent'] = $resCount/$allcount * 100;
          $list_vost[$key]['allcount'] = $allcount;
          foreach($resList as $k => $v){
            $resList[$k]['sj'] = date("Y-m-d H:i",$v['time']);
          }
          $list_vost[$key]['resList'] = $resList;
      }
      $this->success($list_vost);
  }
  

}
