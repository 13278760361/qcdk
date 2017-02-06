<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class IndexController extends HBaseController {

	 function _initialize(){
	 	parent::_initialize();
        $this->db=M('Users');
        $this->db_sign_history =M('Sign_history');
        $this->db_pack = M('Pack');


	 }


	public function index() {


		
		 $classR = I('get.classR'); //获取教室信息

         $ticket = I('get.ticket');//获取 ticket 信息



         $info =  $this->wechatObj->getShakeInfoShakeAroundUser($ticket); //获取摇一摇周边信息
         if ( empty($info) ) {
              $this->error('请重新摇一摇 -0-');
         }

         $openid = $info['data']['openid'];
         // dump($openid);exit();

         $now_time = time(); //当前时间

		 $start = mktime(0,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//获取今天开始时间
		 $end = mktime(23,59,59,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//获取进入结束时间



         if ( $this->db->where(array('openid'=>$openid))->find() ) { //找到该用户
	         	   $where['user_id'] = $this->user_id;
	         	   $where['sign_time'] = array('between',array($start,$end));
	         	   $where['sign_type'] = 1; 
              if ( $sign_info =  $this->db_sign_history->where($where)->find()  ) {//当日第一次打卡有的话，进行第二次打卡
                    $whereE['user_id'] = $this->user_id;
                    $whereE['sign_time'] = array('between',array($start,$end));
                    $whereE['sign_type'] = 2;

                    if ( $this->db_sign_history->where($whereE)->find() ) { //如果有第二次打卡，跳转详情页面
                        redirect( U('Public/signInfo') );
                     }
                         if ( $sign_info['sign_time'] <  mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time)) ) { //计算签到时间是否小于 9点 小于9点 按9点计算 大于9点 按签到时间算
                            $time_diff = round(($now_time-mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time)))%86400/3600,2);
                         }else{
                            $time_diff = round(($now_time-$sign_info['sign_time'])%86400/3600,2);
                         }
                  if (  $time_diff <(float)C('worktime') ) {//时间小于8小时 请提交理由
                     // //抽奖算法
                     //     if ($this->user_id = 22) { // 测试
                     //        $data['MchBillno'] = orderSn();
                     //        $data['TotalAmount'] = 100; //分
                     //        $data['openid'] = $this->db->where( array('id'=>$this->user_id) )->getField('openid');
                     //        $data['SendName'] = '青才科技'; // 商户名称
                     //        $data['ActName'] = '青才摇一摇抽奖';
                     //        $data['Wishing'] = '您的运气爆棚了，新的一天开开心心！'; //祝福语
                     //        $data['Remark'] = '每人都有机会，别忘记打卡奥！'; //备注
                     //        //echo 'http://'.$_SERVER['HTTP_HOST'].C('SSLCERT_PATH');
                     //        $list = A('Pack')->JsApi($data); 
                     //        $g['user_id'] = $this->user_id;
                     //        $g['money'] = $data['TotalAmount']/100;
                     //        $g['type'] = 1;
                     //        $g['order_sn'] = $data['MchBillno'];
                     //        $g['wx_order'] = $list['mch_billno'];
                     //        $g['time'] = time();
                     //        $g['content'] = json_encode($list);
                     //        M('pack')->add($g);
                     //     }
                            
                     //   //抽奖算法
                         redirect( U('Index/leave',array('classR'=>$classR) ) ); //跳转提交理由
                    }else{
		                   $data['user_id'] = $this->user_id;
		                   $data['sign_address'] = $classR;
		                   $data['sign_time'] =$now_time;
		                   $data['sign_type'] = 2;
                       $data['sign_date'] = date('Y-n-j',$now_time);
                         
                       $res = $this->db_sign_history->add($data);

                      
		                    if ($res) {
		                    	 redirect( U('Public/signSuccess') );//成功打卡跳转成功页面
		                    }else{
		                    	$this->error('打卡失败');
		                    }

                    }  
                 	
                 }else{ //没有的话 进行第一次打卡
                   $data['user_id'] = $this->user_id;
                   $data['sign_address'] = $classR;

                   // if ($now_time<mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time))){
                   //   $data['sign_time'] = mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time)); //如果上班打卡时间未到9点 算9点
                   // }else{
                   //   $data['sign_time'] =$now_time;
                   // }
                   $data['sign_time'] = $now_time;
                  
                   $data['sign_type'] = 1;
                   $data['sign_date'] = date('Y-n-j',$now_time);

                   $res = $this->db_sign_history->add($data);

                    if ($res) {
                    	 redirect( U('Public/signSuccess') );//成功打卡跳转成功页面
                    }else{
                    	$this->error('打卡失败');
                    }
                 }   

         }else{
         	redirect( U('Public/bind') ); //用户不存在，跳转绑定页面
         }
	}


    public function leave(){
      if (IS_POST) {
          $leave_reason = I('post.leave_reason');
          $classR  =I('post.classR');
          // dump($_POST);exit();
          if ( empty($leave_reason) ) {
             $this->error('不填写理由可不能走！');
          }


       $now_time = time(); 
       $start = mktime(0,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//获取今天开始时间
       $end = mktime(23,59,59,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//获取进入结束时间

        $whereE['user_id'] = $this->user_id;
        $whereE['sign_time'] = array('between',array($start,$end));
        $whereE['sign_type'] = 2;

        if ( $this->db_sign_history->where($whereE)->find() ) { //如果有第二次打卡，跳转详情页面
                        $this->error('不能重复提交理由');
        }

                       $data['user_id'] = $this->user_id;
                       $data['sign_address'] = $classR;
                       $data['sign_time'] =time();
                       $data['sign_type'] = 2;
                       $data['leave_reason'] = $leave_reason;
                       $data['sign_date'] = date('Y-n-j',time());  
                        $res = $this->db_sign_history->add($data);

                           // echo $this->db_sign_history->getLastSql();exit();

                        if ($res) {
                          $this->success('成功',U('Public/signInfo'));
                            // redirect( U('Public/signSuccess') );//成功打卡跳转成功页面
                        }else{
                          $this->error('打卡失败');
                        }
       
      }else{
        $classR = I('get.classR');
        $this->assign('classR',$classR);
        $this->display();
      }
  }

  public function signPrompt(){

    $this->display();
  }

}
