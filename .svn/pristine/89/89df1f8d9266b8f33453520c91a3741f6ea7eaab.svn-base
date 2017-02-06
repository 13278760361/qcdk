<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
use Wechat\TPWechat;
class DayController extends BackController { //API测试控制器

	

  public function index(){
    // $ch = curl_init();
    // $url = 'http://apis.baidu.com/xiaogg/holiday/holiday?d=20160925';//
    // $header = array(
    //     'apikey: 373a6e1741570b32eb4e73db38b53f46',
    // );
    // // 添加apikey到header
    // curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // // 执行HTTP请求
    // curl_setopt($ch , CURLOPT_URL , $url);
    // $res = curl_exec($ch);

    // var_dump(json_decode($res));//工作日对应结果为 0, 休息日对应结果为 1, 节假日对应的结果为 2

    $day = '20161009';
    $status =  $this->getDayAttr($day); //工作日对应结果为 0, 休息日对应结果为 1, 节假日对应的结果为 2
    dump($status);
          
  }

  public function getDayAttr($day){ //day 格式：20160925
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
