<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
class RoleController extends ABaseController {
	 public function _initialize(){
      parent::_initialize();
      $this->db =M('Admin_auth_group'); //当前模块数据库
      $this->db_auth_rule = M('Admin_auth_rule');
      $this->db_auth_access =M('Admin_auth_group_access');
      $this->assign('status',C('Admin_Status'));
    
    } 

    public function index(){
    	
         //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $status   = isset($_GET['status'])?$_GET['status']:'';

      
        if (empty($keyword) && $status == '') {
          $where = "";
        }elseif ($keyword && $status !=='') {
          $where = "status ={$status} and title like '%{$keyword}%'";
        }elseif ($keyword) {
          $where ="title like '%{$keyword}%'";
        }elseif ($status !== '') {
          $where ="status ={$status}";
        }

        $count          =  $this->db->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();

         $lists =  $this->db      
        ->limit($page->firstRow.','.$page->listRows)
        ->where($where)
        ->order('create_time DESC')
        ->select();
        $this->assign('keyword',$keyword);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }

    public function getNode(){
        if(IS_POST){
           $add = $this->db_auth_rule->field('id ,pid as pId,title as name')->select();
            //组装
                foreach ($add as $key=>$val) {
                   $add[$key]['pId'] = $val['pid'];
        
                }

       
           
           echo (json_encode($add));
         }else{
            $this->error('非法请求');
         }  
    }

     public function getNodeByEdit(){
        if(IS_POST){
           $id = I('post.id');
           $rules =$this->db->where(array('id'=>$id))->getField('rules');
           $e = explode(',', $rules); 
           $add = $this->db_auth_rule->field('id ,pid as pId,title as name')->select();
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

    public function add(){
      if (IS_POST) {
         
        $data['rules'] = I('post.rules');
        $data['title'] = I('post.title');
        $data['status']= I('post.status');
        $data['describe'] =I('post.describe');
        $data['create_time'] =time();

            $res    =$this->db->add($data);
            if($res){
                //日志记录
                aWriteLog('创建角色--'.$data['title'],1);
                $this->success('创建成功');
            }else{
                //日志记录
                aWriteLog('创建角色--'.$data['title'],0);
                $this->error('创建失败');
            }
      
        }else{
            $this->display();
        }
    }

    public function edit(){
        $id = I('get.id');
        if (IS_POST) {
        $data['id'] = I('post.id'); 
        $data['rules'] = I('post.rules');
        $data['status'] = I('post.status');
        $data['title'] = I('post.title');
        $data['describe'] =I('post.describe');

         $res   =$this->db->where(array('id'=>$data['id']))->save($data);
         // echo$this->db->getlastsql();
         // exit();
            if($res!==false){
                //日志记录
                aWriteLog('编辑角色--'.$data['title'],1);
                $this->success('编辑角色成功');
            }else{
                //日志记录
                aWriteLog('编辑角色--'.$data['title'],0);
                $this->error('编辑角色失败');
            }
       
        }else{
            $info =$this->db->where(array('id'=>$id))->find();
            $this->assign('info',$info);
            $this->display();
        }
    }

    public function del(){
        $ids = I('post.ids');
        $map['group_id'] = array('IN',$ids);

        if ($this->db_auth_access->where($map)->find()) {
            $this->error('请先删除该角色下的对应管理员,再删除角色');
        }

        $map1['id'] =array('IN',$ids);

        $res =$this->db->where($map1)->delete();

        if($res){
            //日志记录
             aWriteLog('删除角色',1);
            $this->success('成功删除角色');
        }else{
            //日志记录
            aWriteLog('删除角色',0);
            $this->error('删除角色失败');
        }

    }

}