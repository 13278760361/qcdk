<?php
namespace Admin\Controller;

use Common\Controller\ABaseController;

class DepartController extends ABaseController{
    public function index()
    {
        //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $where =1;
         if ($keyword) {
            $where ="depart_name like '%{$keyword}%'";
        }

        $depart = M('Depart');
        $count = $depart->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();
        $lists = $depart->where($where)->order('orders asc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('keyword',$keyword);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }
    //部门添加
    public function add()
    {
        $depart = M('Depart');
        if(IS_POST){
           $data['depart_name'] = I('post.depart_name');
           $data['orders'] = I('post.order');
           $data['status'] = I('post.status');
           $data['create_time'] = $data['update_time'] =time();

           $re = $depart->add($data);
            if($re){
                $this->success('添加成功!');
            } else {
                $this->error('添加失败!');
            }
        }else{
            $this->display();
        }
    }
    //部门编辑
    public function edit()
    {
       if(IS_POST){
           $data['depart_name'] = I('post.depart_name');
           $data['orders'] = I('post.order');
           $data['status'] = I('post.status');
           $data['update_time'] = time();
           $where['id'] = I('post.id');
           $re = M('Depart')->where($where)->save($data);
           if($re){
               $this->success('修改成功!');
           } else {
               $this->error('修改失败,请重试');
           }
       }else{
           $where['id'] = I('get.id');
           $info = M('Depart')->where($where)->find();
           $this->assign('info',$info);
           $this->display();
       }
    }
    //部门删除
    public function del()
    {
        $ids = I('post.ids');
        $map['id']=['in',$ids];
        $map1['depart_id']=['in',$ids];
        M('Depart')->startTrans();
        $re = M('Depart')->where($map)->delete();
        $re_1 = M('Users')->where($map1)->count();
        if($re && empty($re_1)){
            M('Depart')->commit();
            $this->success('删除成功');
        }elseif($re_1){
            M('Depart')->rollback();
            $this->success('部门下面有员工,请先删除员工');
        } else {
            M('Depart')->rollback();
            $this->error('删除失败,请重试!');
        }
    }
    public function order()
    {
        if(IS_POST){
            $order = $_POST['order'];
            ksort($order);
            foreach($order as $k=>$v){
                $data['orders'] = $v;
                $where['id'][] = $k;
                M('Depart')->where($where)->save($data);
            }
            
                $this->success('部门排序更新成功!');
        }
    }
}