<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class SignController extends HBaseController {

	 function _initialize(){
	 	parent::_initialize();
        $this->db=M('Users');
        $this->db_sign_history = M('Sign_history');
        $this->db_depart = M('Depart');
        $this->db_wages = M('Wages');

        //开启测试
        // $this->user_id = 22;

        //以下是月历点击事件

        $this->assign('url','info/' ); //点击月历跳转
 
        $clickTime = I('get.clickTime'); //点击获取的时间格式 2016-9-1

        $this->clickTime = strtotime($clickTime); //点击获取的时间格式（时间戳）

        // dump($this->clickTime);


        $sDate =date('Y-m-01', strtotime(date("Y-m-d",$this->clickTime))) ; //获取点击日期月开始时间
        $eDate =  date('Y-m-d', strtotime("{$this->sDate} +1 month -1 day")) ;//获取点击日期结束时间

        $this->sDate = strtotime($sDate);
        $this->eDate = strtotime($eDate);


        $this->sTime = mktime(0,0,0,date("m",$this->clickTime),date("d",$this->clickTime),date("Y",$this->clickTime));//获取点击日期当天开始时间
        $this->eTime = mktime(23,59,59,date("m",$this->clickTime),date("d",$this->clickTime),date("Y",$this->clickTime));//获取点击日期当天结束时间

         //获取当前月份(月历)
          $thisMonth = date('n');
          $this->assign('thisMonth',$thisMonth); //获取当前月份 月历图片替换


          //获取点击月份（签到详情）
          $clickMonth = date('n',$this->clickTime);//获取点击月份 签到详情图片替换

          // dump($clickMonth);

          $this->assign('clickMonth',$clickMonth);


 
	 }

  public function index(){


    if ( empty($this->user_id) ) {
          redirect( U('Public/bind') );
      }

     
   

     $sDate = date('Y-m-01', strtotime(date("Y-m-d"))) ; //获取当月开始时间
     $eDate = date('Y-m-d', strtotime("$sDate +1 month -1 day")) ;//获取当月结束时间
    
     $startDate = strtotime($sDate);
     $endDate = strtotime($eDate);

     $where['user_id'] = $this->user_id;
     $where['time'] = array('between',array($startDate,$endDate+60*60*24));//特别注意 当月结束时间+24小时

     $wages_time = $this->db_wages->where($where)->getField('time');
      
     $wages_time = !empty($wages_time)?date('Y-n-j',$wages_time):'';//工资条发放时间  默认为当月16号  

     $this->assign('wages_time', $wages_time); //查询本月工资发放时间


     //查询本月该员工考勤 未签到的时间日期格式
  
 $date = array();
 $dateArr = getDateArr();
 foreach ($dateArr as $key => $val) {
      $date[] =  date('Y-n-j',strtotime($val['dt'])   ) ;
 }//当月所有日期时间格式 9-1

 // dump($date);


 //当月员工签到时间日期格式
$whereS['user_id'] = $this->user_id;
$whereS['sign_time'] = array('between',array($startDate,$endDate+60*60*24));//特别注意 当月结束时间+24小时
$whereS['sign_type'] = 1;

$sign_date = $this->db_sign_history->where($whereS)->getField('sign_date',true);

// dump($sign_date);

$arr = array_diff($date, $sign_date);
$arr= !empty($arr)?$arr:$date;
$arrA =array();
foreach ($arr as $key => $val) {
    $arrA[] = $val;
}
// dump($arrA);
// dump($arr);


// //当月该员工考勤未满考勤 的时间日期格式
// $sql  ="select sign_date from 
// (
// select sign_date,max(sign_time) as da,min(sign_time) as xiao from qcdk_sign_history  where user_id = {$this->user_id} and sign_time between {$startDate} and {$endDate} group by sign_date 
// ) as tab 
// where 
// TIMESTAMPDIFF(MINUTE,
// FROM_UNIXTIME(xiao,'%Y-%m-%d %H:%i:%s'),
// FROM_UNIXTIME(da, '%Y-%m-%d %H:%i:%s')
// )/60 <8" ;

//      $info =   $this->db_sign_history->query($sql);

//      $arr = array();
//       foreach ($info as $key => $val) {
//                $arr[] = $val['sign_date'];
//       }
//       dump($arr);

     $this->assign('arr',json_encode($arrA));

     $this->display();
          
  }

  public function info(){
       

     $whereS['user_id'] = $this->user_id;
     $whereS['sign_time'] = array('between',array($this->sTime,$this->eTime));
     $whereS['sign_type'] = 1; //当天上班打卡时间查询条件
         
     $start_time = $this->db_sign_history->where($whereS)->getField('sign_time');

   


     $whereE['user_id'] = $this->user_id;
     $whereE['sign_time'] = array('between',array($this->sTime,$this->eTime));
     $whereE['sign_type'] = 2; //当天下班打卡时间查询条件



     $end_time = $this->db_sign_history->where($whereE)->max('sign_time');

    
     $start_time = !empty($start_time)?date('H:i',$start_time):null;
     $end_time   = !empty($end_time)?date('H:i',$end_time):'未打卡';

     $now_time = time();
     if ( $start_time <  mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time)) ) { // 
         $time_diff = round(($end_time-mktime(9,0,0,date("m",$now_time),date("d",$now_time),date("Y",$now_time)))%86400/3600,2);
     }else{
         $time_diff = round(($end_time-$start_time)%86400/3600,2); 
     }

       if ( $time_diff <(float)C('worktime') ) { //打卡时间小于 8个小时的话 显示原因
          $reason = $this->db_sign_history->where($whereE)->getField('leave_reason');
          $this->assign('reason',$reason);
     }

   
     //查询今日是否发放工资
     $where['user_id'] = $this->user_id;
     $where['time'] = array('between',array($this->sTime,$this->eTime));
     if (  $this->db_wages->where($where)->find() ) {
          $wages_status = 1;
      }else{
          $wages_status = 0;
      } 


    
     $this->assign('start_time',$start_time);
     $this->assign('end_time',$end_time);
     $this->assign('wages_status',$wages_status);

    
     $this->assign('clickTimes',date('Y-n-j',$this->clickTime) );

   

     // dump(   date('Y年n月j日',$this->clickTime)  );
     $this->assign('date',date('Y年n月j日',$this->clickTime)); //标题

     $this->display();


  }

  public function wages(){

   
    


     $field="u.username,d.depart_name";
     $where = "u.depart_id = d.id and u.id = w.user_id and w.user_id = {$this->user_id} and w.time BETWEEN {$this->sTime} AND {$this->eTime}";

     $info = $this->db_wages->table('qcdk_wages w,qcdk_users u,qcdk_depart d')->where($where)->find();
    
     // dump($info);
     $this->assign('info',$info);
     $this->display();
  }
  
  //ajax获取点击月份数据
  public function getMonthDate(){
     $clickDate = strtotime( I('post.clickDate') );
    
     $sDate = date('Y-m-01', strtotime(date("Y-m-d",$clickDate))) ; //获取点击当月开始时间
     $eDate = date('Y-m-d', strtotime("$sDate +1 month -1 day")) ;//获取当月结束时间
    
     $startDate = strtotime($sDate);
     $endDate = strtotime($eDate);



     $where['user_id'] = $this->user_id;
     $where['time'] = array('between',array($startDate,$endDate+60*60*24)); //特别注意 当月结束时间+24小时


     $wages_time = $this->db_wages->where($where)->getField('time');
  
      
     $wages_time = !empty($wages_time)?date('Y-n-j',$wages_time):'';//工资条发放时间

//      $sql  ="select sign_date from 
// (
// select sign_date,max(sign_time) as da,min(sign_time) as xiao from qcdk_sign_history  where user_id = 1 and sign_time between {$startDate} and {$endDate} group by sign_date 
// ) as tab 
// where 
// TIMESTAMPDIFF(MINUTE,
// FROM_UNIXTIME(xiao,'%Y-%m-%d %H:%i:%s'),
// FROM_UNIXTIME(da, '%Y-%m-%d %H:%i:%s')
// )/60 <8" ;
 

 
//      $info =   $this->db_sign_history->query($sql);

         //查询本月该员工考勤 未签到的时间日期格式
  
 $date = array();
 $dateArr = getDateArr($eDate);
 foreach ($dateArr as $key => $val) {
      $date[] =  date('Y-n-j',strtotime($val['dt'])   ) ;
 }//当月所有日期时间格式 9-1




 //当月员工签到时间日期格式
$whereS['user_id'] = $this->user_id;
$whereS['sign_time'] = array('between',array($startDate,$endDate+60*60*24));//特别注意 当月结束时间+24小时
$whereS['sign_type'] = 1;

$sign_date = $this->db_sign_history->where($whereS)->getField('sign_date',true);

// dump($sign_date);
// dump( array_diff($date, $sign_date) );exit();

$arrA =  array_diff($date, $sign_date);
$arrA = !empty($arrA)?$arrA:$date;

    // dump($arrA);exit();

 $thisMonth = date('n',$clickDate);//获取当前月份 月历图片替换


     $arr = array();
     $arr['thisMonth'] = $thisMonth;
     $arr['wages_time'] = $wages_time;
      foreach ($arrA as $key => $val) {
               $arr['date'][] = $val;
      }
    

    
     // $this->assign('arr',json_encode($arr));  

     echo json_encode($arr);
  }

}
