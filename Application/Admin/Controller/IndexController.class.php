<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
use Org\Util\SmsBao;//引入类文件
class IndexController extends ABaseController{
    public function index(){
//        $this->assign('menu',$this->menu);
//        dump($this->menu);exit();
//    	 dump(getSystem());
//       $this->assign('smsNum',smsNum());
       $this->assign('system',getSystem());
//        print_r($_SERVER);exit;
//        $system['OS'] =$_SERVER['SERVER_SOFTWARE'];
//        $system['LOCAL_TIME'] =date('Y-m-d H:i:s',time());
//        $this->assign('system',$system);
       $this->display();
    }


    public function smsBuy(){
      $this->display();
    }

    public function sms(){ //短信接口测试
		
     //  $Mobiles=18669010872;
     //  $Content='ede';

     //      $res =   sendSms($Mobiles,$Content);
 		  // dump($res);    
      // $res = smsNum();
      // dump($res);
    	// $num = smsNum();
    	// dump($num);
    }
}