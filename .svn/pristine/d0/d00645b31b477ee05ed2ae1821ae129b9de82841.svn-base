<?php
namespace Admin\Controller;
use Common\Controller\BackController;
class PublicController extends BackController{
    public function login(){
       $this->display();
    }

    

    public function  checkLogin(){
    	if (IS_POST) {
			if(!checkVerify(I('post.verify'))){
				$this->error('验证码错误');
			}
            $httppost = I('post.');
            $userinfo = M('admin_user')->where(array('username'=>$httppost['username']))->find();
            if (!$userinfo) {
                $this->error('用户不存在!');
            }
            if ($httppost['username']==$userinfo['username'] and encrypt($httppost['password'])==$userinfo['password']) {
                if ($userinfo['status']==0){
                    $this->error('帐户被冻结!');
                }
                session('admin_id',$userinfo['id']);
                session('admin_username',$userinfo['username']);
                session('admin_login_count',$userinfo['login_count']);
                session('admin_last_login_time',date("Y-m-d H:i:s",$userinfo['last_login_time']));
                session('admin_login_key',encrypt($userinfo['username'], true));//登录验证，防止两个人同时登录
                M('admin_user')->where(array('id'=>$userinfo['id']))->setField('login_key',session('admin_login_key'));
                //保存登录信息
                $data['last_login_time']  =   time();
                $data['last_login_ip']    =   get_client_ip();
                $data['login_count']      =   array('exp','(login_count+1)');
                M('admin_user')->where(array('id'=>$userinfo['id']))->save($data); 
                //日志记录
                D('Admin_log')->write_log('登录后台',1);
                $this->success('登录成功!',U('Admin/Index/index'));
            }else{
                //   //日志记录
                // D('Admin_log')->write_log('登录',0);
                $this->error('帐号或密码错误!');
            }
        }else{
            $this->display();
        }
    }


    public function verify(){
        ob_clean();
        $Verify             = new \Think\Verify();
        $Verify->codeSet  ='123456789';    
        $Verify->fontSize   = 18;
        $Verify->length     = 4;
        $Verify->imageW     = 127;
        $Verify->imageH     = 36;
        $Verify->useNoise   = false;
        $Verify->useCurve   =  false;          // 是否画混淆曲线
        $Verify->useNoise   =  false;            // 是否添加杂点  
        $Verify->entry();
    }

      public function logout(){
        //日志记录
        D('Admin_log')->write_log('退出后台',1);
        session('admin_id',null);
        session('admin_username',null);
        session('admin_login_count',null);
        session('admin_last_login_time',null);
        session('admin_login_key',null);
        session('[destroy]'); // 销毁session
        redirect(U('Admin/Public/login'));
    }
}