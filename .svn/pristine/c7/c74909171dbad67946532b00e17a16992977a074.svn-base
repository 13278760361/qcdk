<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
use Wechat\TPWechat;
class AutoController extends BackController {

	 function _initialize(){
	 	parent::_initialize();
        $this->db=M('Users');
        $this->db_sign_history=M('Sign_history');

        $this->options = array('appid'=>C('appid'),'appsecret'=>C('appsecret'),'token'=>C('token'),'encodingaeskey'=>C('encodingaeskey'));
          $this->wechatObj = new TPWechat($this->options);

        //调试开启
        // $this->user_id = 1;
	 }

  public function index(){
    // */2 * * * * curl -i  http://check.easyitcn.cn/Home/Auto/index Crontab 定时任务
    ignore_user_abort(true);
    set_time_limit(0);

    $now_time = time();    
    // $where['depart_id'] = 3; 
    $userList = $this->db->field('id,depart_id,username,openid')->select();//用户列表
    $start_work = mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//当天上班时间
    $end_work = mktime(17,30,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time));//当天下班时间

    $depart_ids = array('12','13','20'); //非弹性部门

    $day= date('Ymd',$now_time);

    $attr =  $this->getDayAttr($day); //工作日对应结果为 0, 休息日对应结果为 1, 节假日对应的结果为 2

    if ($attr == 0) {  //工作日推送消息
            foreach ($userList as $key => $val) {
        
                    if ( $now_time < $start_work-60*5+60 && $now_time > $start_work-60*5-60 ) { //
                        if ( in_array($val['depart_id'], $depart_ids) ) {
                            $flag = "9:00";
                        }else{
                            $flag = "弹性工作制度，不固定(9点开始计时，8.5小时工作时间)";
                        }
                        $send = array(
                              'touser' => $val['openid'], //Openid
                              'template_id' => C('weixin_tpl'),
                              'url' => '', //点击模版消息跳转的连接
                              'topcolor' => "#FF0000",
                              'data' => array(
                                'first'    => array('value'=>'签到提醒', 'color'=> '#FF0000'),
                                'keyword1' => array('value'=>$val['username'], 'color'=> '#173177'), //签到姓名
                                'keyword2' => array('value'=>'上班签到', 'color'=> '#173177'), //签到内容
                                'keyword3' => array('value'=>$flag, 'color'=> '#173177'),//签到时间
                                'remark'   => array('value'=> '别忘记签到! 别忘记签到！别忘记签到！重要的事情说三遍', 'color'=> '#FF0000')
                              )
                            );

                      
                     }elseif ($now_time < $end_work+60 && $now_time > $end_work-60 ) {
                        if ( in_array($val['depart_id'], $depart_ids) ) {
                            $flag = "17:30";
                        }else{
                            $where['user_id'] = $val['id'];
                            $where['sign_type'] = 1;
                            $where['sign_date'] = date('Y-n-j',$now_time);
                            $start_sign = $this->db_sign_history->where($where)->getField('sign_time');
                            if ($start_sign < $start_work && !empty($start_sign) ) {
                               $start_sign = $start_work; 
                            }else{
                               $start_sign = $start_sign;
                            }
                            if ( !empty($start_sign) ) {
                                $flag ="弹性工作制度，为您计算下班应该签到时间：". date('H:i',($start_sign+3600*8+1800));
                            }else{
                                $flag ="呵呵，是不是上班没打卡";
                            }

                        }          
                        $send = array(
                              'touser' => $val['openid'], //Openid
                              'template_id' => C('weixin_tpl'),
                              'url' => '', //点击模版消息跳转的连接
                              'topcolor' => "#FF0000",
                              'data' => array(
                                'first'    => array('value'=> '签到提醒', 'color'=> '#FF0000'),
                                'keyword1' => array('value'=>$val['username'], 'color'=> '#173177'), //签到姓名
                                'keyword2' => array('value'=>'下班签到', 'color'=> '#173177'), //签到内容
                                'keyword3' => array('value'=>$flag, 'color'=> '#173177'),//签到时间
                                'remark'   => array('value'=> '别忘记签到! 别忘记签到！别忘记签到！重要的事情说三遍', 'color'=> '#FF0000')
                              )
                            );
                     } 

               $this->wechatObj->sendTemplateMessage($send);

           }
    }//elseif($attr == 1) //休息日
    
          
  }

  public function getDayAttr($day){ //day 格式：20160925 http://apistore.baidu.com/apiworks/servicedetail/1116.html
      $ch = curl_init();
    $url = "http://apis.baidu.com/xiaogg/holiday/holiday?d={$day}";//
    $header = array(
        'apikey: 373a6e1741570b32eb4e73db38b53f46',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 执行HTTP请求
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);

    return json_decode($res);
  }

  

}
