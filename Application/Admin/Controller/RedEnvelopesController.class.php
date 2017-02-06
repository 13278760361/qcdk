<?php
/**
* 红包 
*/
namespace Admin\Controller;
use Common\Controller\ABaseController;

class RedEnvelopesController extends ABaseController
{
	
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

        $where =1;
         if ($keyword) {
            $where ="scene_name like '%{$keyword}%'";
        }
        $redenvel = M('Scene');
        $count          =  $redenvel->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();

         $lists =  $redenvel      
        ->limit($page->firstRow.','.$page->listRows)
        ->where($where)
        ->order('id ASC')
        ->select();
        $this->assign('keyword',$keyword);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
	}
	public function add(){
		$scene = M('Scene');
        if(IS_POST){
           $data['scene_name'] = I('post.scene_name');
          
           $data['status'] = I('post.status');
           $data['time'] = $data['update_time'] =time();
           $re = $scene->add($data);
            if($re){
                $this->success('添加成功!');
            } else {
                $this->error('添加失败!');
            }
        }else{
            $this->display();
        }
	}
	//删除场景
	public function del(){
		$ids = I('post.ids');
        $map['id']=['in',$ids];
        $map1['scene_id']=['in',$ids];
        M('Scene')->startTrans();
        $re = M('Scene')->where($map)->delete();
        $re_1 = M('Prize')->where($map1)->count();
        if($re && empty($re_1)){
            M('Scene')->commit();
            $this->success('删除成功');
        }elseif($re_1){
            M('Scene')->rollback();
            $this->success('场景下面有奖品,请先删除奖品');
        } else {
            M('Scene')->rollback();
            $this->error('删除失败,请重试!');
        }
	}
	//场景修改
	public function edit(){
		if(IS_POST){
           $data['scene_name'] = I('post.scene_name');
          // $data['orders'] = I('post.order');
           $data['status'] = I('post.status');
           $data['time'] = time();
           $where['id'] = I('post.id');
           $re = M('Scene')->where($where)->save($data);
           if($re){
               $this->success('修改成功!');
           } else {
               $this->error('修改失败,请重试');
           }
       }else{
           $where['id'] = I('get.id');
           $info = M('Scene')->where($where)->find();
           $this->assign('info',$info);
           $this->display();
       }
	}
	// //奖品列表
	// public function prize_index(){
 //    		$wehre['scene_id'] = I('get.id');
 //    		$prize = M('Prize');
 //        $count          =  $prize->where($where)->count();
 //        $page           = new \Think\Page($count,C('pageNum'));
 //        $show           = $page->show();

 //         $lists =  $prize      
 //        ->limit($page->firstRow.','.$page->listRows)
 //        ->where($where)
 //        ->order('id ASC')
 //        ->select();
 //        //$this->assign('keyword',$keyword);
 //        $this->assign('page',$show);
 //        $this->assign('lists',$lists);
 //        $this->display();
	// }

}
?>