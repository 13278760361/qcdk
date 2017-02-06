<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
class AdminController extends ABaseController {
      public function _initialize(){
      parent::_initialize();
      $this->db = M('Admin_user'); //当前模块数据库
      $this->db_auth_group = M('Admin_auth_group');
      $this->db_auth_access =M('Admin_auth_group_access');
      $this->groups = $this->db_auth_group->where(array('status'=>1))->getField('id,title');//角色组
      $this->assign('groups',$this->groups);
    } 

    public function index(){
        //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $group   = I('get.group')?I('get.group'):'';
      
        if (empty($keyword) && empty($group)) {
          $where = "u.id = a.uid and a.group_id = g.id";
        }elseif ($keyword && $group) {
          $where = "u.id = a.uid and a.group_id = g.id and g.id ={$group} and (u.username like '%{$keyword}%' OR u.nickname like  '%{$keyword}%')";
        }elseif ($keyword) {
          $where ="u.id = a.uid and a.group_id = g.id and (u.username like '%{$keyword}%' OR u.nickname like  '%{$keyword}%')";
        }elseif ($group) {
          $where ="u.id = a.uid and a.group_id = g.id and g.id ={$group}";
        }


        
       
        
        $count          =  $this->db ->table("qcdk_admin_user u,qcdk_admin_auth_group g,qcdk_admin_auth_group_access a")->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();

         $lists =  $this->db
        ->table("qcdk_admin_user u,qcdk_admin_auth_group g,qcdk_admin_auth_group_access a")
        ->field('u.id,u.username,u.nickname,u.last_login_time,u.login_count,u.email,u.status,g.title')
        ->limit($page->firstRow.','.$page->listRows)
        ->where($where)
        ->select();
        $this->assign('keyword',$keyword);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function add(){
        if (IS_POST) {
            $data['username']       = I('post.username');
            $data['nickname']       = I('post.nickname');
            $data['password']       = encrypt(I('post.password'));
            $data['email']          = I('post.email');          
            $data['create_time']    = time();
            $data['status']  = I('post.status'); 
            $this->db->startTrans();         
            $res                = $this->db->add($data);
            $res_1        = $this->db_auth_access->add(array('uid'=>$res,'group_id'=>I('post.group_id')));
            if($res and $res_1){
                $this->db->commit();
                //日志记录
                aWriteLog('添加管理员--'.$data['username'],1);
           
                $this->success('添加用户成功');
            }else{
                $this->db->rollback();
                 //日志记录
                aWriteLog('添加管理员--'.$data['username'],0);
                $this->error('添加用户失败');
            }
        }else{
        $this->display();
        }
    }

    public function edit(){
        if(IS_POST){
            $data['id']     =  I('post.id');
            $data['username'] = I('post.username');
            $data['nickname'] = I('post.nickname');
                if(I('post.password')){
                    $data['password'] = encrypt(I('post.password'));
                }
            $data['email']          = I('post.email'); 
            $data['status']         = I('post.status');          
            $data['update_time']    = time();
            $this->db->startTrans(); //开启事物   
            $res                = $this->db->save($data);
            $res_1        = $this->db_auth_access
                                    ->where(array('uid'=> I('post.id')))
                                    ->setField('group_id',I('post.group_id'));


            if($res!== false && $res_1!== false){
                $this->db->commit();//提交事物
                //日志记录
                aWriteLog('编辑管理员--'.$data['username'],1);
                $this->success('修改成功');
            }else{
                $this->db->rollback();//事物回滚
                //日志记录
                aWriteLog('编辑管理员--'.$data['username'],0);
                $this->error('修改失败');
            }

        }else{
            $id =I('get.id');
            // echo $id;
            $info    = $this->db->table('qcdk_admin_user u,qcdk_admin_auth_group_access a')
                                    ->field('u.id,u.username,u.password,u.nickname,u.email,u.status,a.group_id')
                                    ->where("u.id = {$id} and u.id = a.uid")
                                    ->find();
                   
         
            $this->assign('info',$info);
          

            $this->display();
        }
       
    }

    public function del(){
        $ids = I('post.ids');

         if (is_string($ids)) {
           if (in_array($ids, C('AUTH_CONFIG.AUTH_ADMINUID'))) { 
            $this->error('主要超级管理员不能删除,否则无法登陆');
         }
       }

       if(is_array($ids)){
           if (in_array(implode('', C('AUTH_CONFIG.AUTH_ADMINUID')), $ids)) { 
            $this->error('主要超级管理员不能删除,否则无法登陆,请去除超级管理员再批量删除');
         }
       }

       $map['id'] =array('IN',$ids);
       $map1['uid']=array('IN',$ids);

          // $model = M();
          // $model->startTrans();
         
         
        $this->db->startTrans(); //开启事物
        $res = $this->db->where($map)->delete();
        $res_1 = $this->db_auth_access->where($map1)->delete();

        if ($res && $res_1) {
             $this->db->commit();//提交事物
             //日志记录
             aWriteLog('删除管理员',1);
             $this->success('删除成功');
        }else{
             $this->db->rollback();//事物回滚
             //日志记录
             aWriteLog('删除管理员',0);
             $this->error('删除失败');
        }
    }
}