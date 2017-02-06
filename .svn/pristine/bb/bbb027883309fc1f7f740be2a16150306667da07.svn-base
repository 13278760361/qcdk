<?php
namespace Home\Controller;
use Think\Controller; 
use Common\Controller\HBaseController;
use Common\Controller\BackController;
class RedController extends HBaseController {
    function _initialize(){
        parent::_initialize();
        //$this->user_id = 59;
        //开启调试
        // $this->user_id //当前用户ID
    }
    public function index(){
        $pcount = M('pack')->count();
        if($pcount > 2){
            echo '<div style="font-size:40px;padding:200px 20px;text-align:center; color:red;">您来晚了，红包已经派完了哦！</div>';exit;
        }
        $u = M('pack')->field('id')->where(array('user_id'=>$this->user_id))->find();
        if($u){
            echo '<div style="font-size:40px;padding:200px 20px;text-align:center; color:red;">不知足，还想抽哦！</div>';exit;
        }
        $p = M('users')->field('openid')->where(array('id'=>$this->user_id))->find();
        $data['MchBillno'] = $this->orderSn();
        $data['TotalAmount'] = 100;
        $data['openid'] = $p['openid'];
        $data['SendName'] = '青才科技'; // 商户名称
        $data['ActName'] = '青才摇一摇抽奖';
        $data['Wishing'] = '您的运气爆棚了，新的一天开开心心！'; //祝福语
        $data['Remark'] = '每人都有机会，别忘记打卡奥！'; //备注
        //echo 'http://'.$_SERVER['HTTP_HOST'].C('SSLCERT_PATH');
        $list = A('Pack')->JsApi($data); 
        $g['user_id'] = $this->user_id;
        $g['money'] = $data['TotalAmount']/100;
        $g['type'] = 1;
        $g['order_sn'] = $data['MchBillno'];
        $g['wx_order'] = $list['mch_billno'];
        $g['time'] = time();
        $g['content'] = json_encode($list);
        M('pack')->add($g);
        if( $list['result_code'] == 'SUCCESS' ){
            echo '<div style="font-size:50px;padding:200px 20px;text-align:center;color:#ff6600;">您已经抽中<font color="red" style="font-size:80px;">￥'.round($g['money'],2).'</font>元！<br><br><br><a href="" style="text-decoration:none;font-size:25px;padding-top:15px;color:blue;">刷新即可重新抽！</a></div>';exit;
        }
        dump($list);
    }
    // 订单号
    public function orderSn(){ 
        return (intval(date('Y'))-2015).strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%d',rand(0,99));
    }
    /**
     * 获取唯一值
     */
    public function userKey() {
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
