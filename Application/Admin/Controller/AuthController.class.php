<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
class AuthController extends ABaseController {
    public function index(){
    	// $this->assign('SysInfos',$_SERVER);
     //    $this->assign('sev_system',php_uname('s'));
     //    $this->assign('PHPversion',PHP_VERSION);
     //    $this->assign('upload_size',ini_get('upload_max_filesize'));
    	// $this->assign('menu',$this->menu);
    	$this->display();
    }

    public function role(){
    	$group_list = M('admin_auth_group')->select();
        $this->assign('list',$group_list);
        $this->display();
    }

    public function get_node(){
        if(IS_POST){
           $add = M('Admin_auth_rule')->field('id ,pid as pId,title as name')->select();
            //组装
                foreach ($add as $key=>$val) {
                   $add[$key]['pId'] = $val['pid'];
        
                }

       
           
           echo (json_encode($add));
         }else{
            $this->error('非法请求');
         }  
    }

     public function get_node2(){
        if(IS_POST){
           $id = I('post.id');
           $rules = M('admin_auth_group')->where(array('id'=>$id))->getField('rules');

           // echo M('admin_auth_group')->getlastsql();
           // exit();
           $e = explode(',', $rules); 
           $add = M('Admin_auth_rule')->field('id ,pid as pId,title as name')->select();
            //组装
                foreach ($add as $key=>$val) {
                   $add[$key]['pId'] = $val['pid'];
                
                
                   if (in_array($add[$key]['id'], $e)) {
                       $add[$key]['checked'] = 'true';
                   }
                }

       
           
           echo (json_encode($add));
         }else{
            $this->error('非法请求');
         }  
    }

    public function role_add(){
      if (IS_POST) {
         
        $data['rules'] = I('post.rules');
        $data['title'] = I('post.title');

            $ok          = M('admin_auth_group')->add($data);
            if($ok){
                //日志记录
                D('Admin_log')->write_log('创建角色',1);
                $this->success('创建成功');
            }else{
                //日志记录
                D('Admin_log')->write_log('创建角色',0);
                $this->error('创建失败');
            }
            

      
        }else{
            $this->display();
        }
    }

    public function role_edit(){
        $id = I('get.id');
        if (IS_POST) {
        $data['id'] = I('post.id'); 
        $data['rules'] = I('post.rules');
        $data['title'] = I('post.title');

         $ok          = M('admin_auth_group')->where(array('id'=>$data['id']))->save($data);
         // echo M('admin_auth_group')->getlastsql();
         // exit();
            if($ok){
                //日志记录
                D('Admin_log')->write_log('修改权限',1);
                $this->success('权限修改成功');
            }else{
                //日志记录
                D('Admin_log')->write_log('修改权限',0);
                $this->error('权限修改失败');
            }
        

      
        }else{
              // $add = M('Admin_auth_rule')->field('id ,pid,title as name')->select();
        // echo json_encode($add);
            $lists = M('admin_auth_group')->where(array('id'=>$id))->find();
            $this->assign('lists',$lists);
            $this->display();
        }
    }

    public function role_del(){
        $id = I('post.id');

        if (M('admin_auth_group_access')->where(array('group_id'=>$id))->find()) {
            $this->error('请先删除该角色下的对应管理员');
        }

        $re = M('admin_auth_group')->where(array('id'=>$id))->delete();

        // echo M('admin_auth_group')->getlastsql();
        // exit();

        if($re){
            //日志记录
            D('Admin_log')->write_log('删除角色',1);
            $this->success('成功删除角色');
        }else{
            //日志记录
            D('Admin_log')->write_log('删除角色',0);
            $this->error('删除角色失败');
        }

    }

    public function users(){
        $count          =  M('Admin_user') ->table("fangcms_admin_user u,fangcms_admin_auth_group g,fangcms_admin_auth_group_access a")->where("u.id = a.uid and a.group_id = g.id")->count();
        $page           = new \Think\Page($count,10);
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show           = $page->show();
        $this->assign('page',$show);
        $lists =  M('Admin_user')
        ->table("fangcms_admin_user u,fangcms_admin_auth_group g,fangcms_admin_auth_group_access a")
        ->field('u.id,u.username,u.nickname,u.last_login_time,u.login_count,u.email,u.status,g.title')
        ->limit($page->firstRow.','.$page->listRows)
        ->where("u.id = a.uid and a.group_id = g.id")
        ->select();
        // dump($lists);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function user_add(){
        if (IS_POST) {
       
            //print_r($HttpPost);
            $data['username']       = I('post.username');
            $data['nickname']       = I('post.nickname');
            $data['password']       = encrypt(I('post.password'));
            $data['email']          = I('post.email');          
            $data['create_time']    = time();
            $data['status']  = I('post.status');          
            $useradd                = M('admin_user')->add($data);
            $group_accessadd        = M('admin_auth_group_access')->add(array('uid'=>$useradd,'group_id'=>I('post.group_id')));
            if($useradd and $group_accessadd){
                //日志记录
                D('Admin_log')->write_log('添加用户',1);
                $this->success('添加用户成功');
            }else{
                //日志记录
                D('Admin_log')->write_log('添加用户',0);
                $this->error('添加用户失败');
            }
        }else{
        $groups = M('admin_auth_group')->getField('id,title');
        $this->assign('groups',$groups);  
        $this->display();
        }
    }

    public function user_edit(){
        if(IS_POST){
                $HttpPost       = I('post.');
            $data['id']     =  $HttpPost['id'];
            // if(!in_array($data['id'],C('AUTH_CONFIG.AUTH_ADMINUID')) || $data['id']!=session('admin_uid')){
            //     $this->error('你没有权限');
            // }
            $data['username'] = $HttpPost['username'];
            $data['nickname'] = $HttpPost['nickname'];
                if($HttpPost['password']){
                    $data['password'] = encrypt($HttpPost['password']);
                }
            $data['email']          = $HttpPost['email']; 
            $data['status']         = $HttpPost['status'];          
            $data['update_time']    = time();   
            $useradd                = M('admin_user')->save($data);
            $group_accessadd        = M('admin_auth_group_access')
                                    ->where(array('uid'=> $HttpPost['id']))
                                    ->setField('group_id',$HttpPost['group_id']);


            if($useradd){
                //日志记录
                D('Admin_log')->write_log('编辑用户',1);
                $this->success('修改成功');
            }else{
                //日志记录
                D('Admin_log')->write_log('编辑用户',0);
                $this->error('修改失败');
            }

        }else{
            $id =I('get.id');
            // echo $id;
            $users    = M('admin_user u')
                                    ->join('__ADMIN_AUTH_GROUP_ACCESS__ a ON a.uid=u.id')
                                    ->where(array('u.id'=>$id))
                                    ->find();
            // echo M('admin_user')->getlastsql();                        
            // dump($users);                        
            $groups = M('admin_auth_group')->getField('id,title');
            $this->assign('users',$users);
            $this->assign('groups',$groups);   

            $this->display();
        }
       
    }

    public function user_del(){
        $id = I('post.id');
        if (in_array($id, C('AUTH_CONFIG.AUTH_ADMINUID'))) { 
            $this->error('主要超级管理员不能删除,否则无法登陆');
        }
          // $model = M();
          // $model->startTrans();
         
        $Admin = M('Admin_user'); 
        $Admin->startTrans(); //开启事物
        $re = M('Admin_user')->where(array('id'=>$id))->delete();
        $re2 = M('admin_auth_group_access')->where(array('uid'=>$id))->delete();

        if ($re && $re2) {
             $Admin->commit();//提交事物
             //日志记录
            D('Admin_log')->write_log('删除用户',1);
             $this->success('删除成功');
        }else{
             $Admin->rollback();//事物回滚
             //日志记录
            D('Admin_log')->write_log('删除用户',0);
             $this->error('删除失败');
        }
    }
}