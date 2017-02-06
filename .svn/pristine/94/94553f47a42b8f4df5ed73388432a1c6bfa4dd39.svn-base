<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: fangcms <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
 
namespace Home\Controller;
use Think\Controller; 
use Wechat\TPWechat;

class WeixinController extends Controller{
    /**
     * 微信消息接口入口
     * 所有发送到微信的消息都会推送到该操作
     * 所以，微信公众平台后台填写的api地址则为该操作的访问地址
     */

      // 微信SDK参数
    private $options = array();
    var $token;
    private $data = array ();

    function _initialize(){
        $this->options = array('appid'=>C('appid'),'appsecret'=>C('appsecret'),'token'=>C('token'),'encodingaeskey'=>C('encodingaeskey'));
        $this->wechatObj = new TPWechat($this->options);
        $this->chatMediaPath = $this->options['chatMediaPath'].date("Ym", time()).'/';

   
    }


    public function index(){
        // $this->options = C('WeixinConfig');
        /**
         * 微信接入验证
         */
        
        if (! empty ( $_GET ['echostr'] ) && ! empty ( $_GET ["signature"] ) && ! empty ( $_GET ["nonce"] )) {
            $this->wechatObj->valid();
            $this->wechatObj->getRev();
            exit();
        }

        // 删除微信传递的token干扰
        unset ( $_REQUEST ['token'] );

        $this->wechatObj->valid();
        $this->wechatObj->getRev();
        $data = $this->wechatObj->getRevData ();
        $this->data = $data;
        $this->token = $data ['ToUserName'];
      


        $this->reply ( $data );
    }

    /**
     * DEMO
     * @param  Object $wechat Wechat对象
     * @param  array  $data   接受到微信推送的消息
     */
    private function reply($data){

        switch ($data['MsgType']) {
            case TPWechat::MSGTYPE_EVENT://事件
                switch ($data['Event']) {
                    case TPWechat::EVENT_SUBSCRIBE://关注事件




                        break;



                    case TPWechat::EVENT_UNSUBSCRIBE://取消关注事件
                        //取消关注，记录日志
                        break;

                    // case TPWechat::EVENT_LOCATION://上报地理位置事件
                    //     $this->wechatObj->text("欢迎访问fangcms公众平台！您已经上报了地理位置，请你防火、防盗、防小三！")->reply();
                    //     break;    

                    default:
                        $this->wechatObj->text("欢迎访问fangcms公众平台！您的事件类型：{$data['Event']}，EventKey：{$data['EventKey']}")->reply();
                        break;
                }
                break;

            case TPWechat::MSGTYPE_TEXT://文本回复
                 
                break;
            
            default:
                # code...
                break;
        }
    }
    // public function wx_member_add(){ //用户入库
    //                     $openid = $this->data['FromUserName'];
    //                     $wx_member_info = $this->wechatObj->getUserInfo($openid);//获取用户信息
                
    //                     $channel = $this->data['EventKey'];
    //                     $channel =  $channel ? $channel : '';
    //                     $wx_member['nickname'] = $wx_member_info['nickname'];
    //                     $wx_member['sex'] = $wx_member_info['sex'];
    //                     $wx_member['province'] = $wx_member_info['province'];
    //                     $wx_member['city'] = $wx_member_info['city'];
    //                     $wx_member['headimgurl'] = $wx_member_info['headimgurl'];
    //                     $wx_member['time'] = time();
    //                     $wx_member['openid'] = $openid;
    //                     $wx_member['channel'] = $channel;

    //                     if ( M('Weixin_member')->where( array('openid'=>$openid) )->find() ) {
    //                         M('Weixin_member')->where( array('openid'=>$openid) )->save($wx_member);
    //                     }else{
    //                         M('Weixin_member')->add($wx_member);
    //                     }
    // }
  

}
