<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
class ImagesController extends ABaseController{
	public function _initialize(){
      parent::_initialize();
      $this->db_ad =M('Ad');
      $this->db_article = M('Article');
      $this->db_article_category = M('Article_category');
      $this->db_richtext =M('Richtext');
      $this->db_multi =M('Multi');
    } 

    public function index(){
    	$lists =  my_scandir(C('UPLOAD_PATH'));//遍历上传文件夹
        foreach ($lists as $key => $val) {
           unset($lists[$key]);//去除多余项
           if ($key == 'ad'){$lists[$key]['intro'] ='广告位';}
           if ($key == 'article'){$lists[$key]['intro'] ='文章封面';}
           if ($key == 'category'){$lists[$key]['intro'] ='栏目封面';}
           if ($key == 'content'){$lists[$key]['intro'] ='文章内容';}
           if ($key == 'logo'){$lists[$key]['intro'] ='网站LOGO';}
           if ($key == 'qr'){$lists[$key]['intro'] ='微信二维码';}
           if ($key == 'watermark'){$lists[$key]['intro'] ='网站水印';}
           if ($key == 'watermark_thumb'){$lists[$key]['intro'] ='网站水印缩率图';}
           if ($key == 'richtext'){$lists[$key]['intro'] ='微信图文回复封面';}
           if ($key == 'rich_content'){$lists[$key]['intro'] ='微信图文回复详情内容';}

        }
 		$this->assign('lists',$lists);	 
    	$this->display();
    }


    public function path_1(){
    	$path = I('get.path');
    	$lists =my_scandir(C('UPLOAD_PATH').$path); //遍历

    	$level =  arrayLevel($lists);//获取目录层级
        $this->assign('lists',$lists);
    	if ($level == 2) {
    	  $this->assign('path',$path);
    	  $this->display();
    	}elseif ($level == 1) {
    	  $img_path = C('UPLOAD_PATH').$path;
    	  $this->assign('path_root',ltrim($img_path,'.'));//图片路径
    	  $this->assign('path',$path);//二级目录
    	  $this->display('path_2');
    	}
    	
    } 

    public function path_2(){
    	$path =I('get.path');
    	$path_p = isset($_GET['path_p'])?I('get.path_p'):'';
    	$img_path = C('UPLOAD_PATH').$path_p.'/'.$path;
    	$lists = my_scandir($img_path);
    	$this->assign('path_root',ltrim($img_path,'.'));
    	$this->assign('path',$path);//二级目录
    	$this->assign('path_p',$path_p);//顶级目录
    	$this->assign('lists',$lists);
    	$this->display();
    }

    public function file_del(){//文件夹删除
    	$files = I('post.files');

    	if (is_array($files)) {

    		foreach ($files as $val) {
    			 $res =  del_files(C('UPLOAD_PATH').$val,true);//循环删除目录
    		}
    			if ($res) {
    				$this->success('批量删除文件夹成功');
    			}else{
    				$this->error('批量删除文件夹失败');
    			}
    	}elseif (is_string($files)) {

    		if(del_files(C('UPLOAD_PATH').$files,true)){
    			$this->success('删除文件夹成功');
    		}else{
    		$this->error('删除文件夹失败');
    		}
    	}
    	
    }

    public function img_del(){ //图片删除
    	$files = I('post.files');
    
    	if (is_array($files)) {
    	
    		foreach ($files as $val) {

    			 $res =  del_files(C('UPLOAD_PATH').$val);//循环删除目录
    		}
    			if ($res) {
    				$this->success('批量删除图片夹成功');
    			}else{
    				$this->error('批量删除图片失败');
    			}
    	}elseif (is_string($files)) {
    		
    		if(del_files(C('UPLOAD_PATH').$files)){
    			$this->success('删除图片成功');
    		}else{
    		$this->error('删除图片失败');
    		}
    	}
    }

    public function file_auto_clear(){//自动过滤多余图片


    	if (IS_POST) {
    		$lists =  my_scandir(C('UPLOAD_PATH'));//遍历上传文件夹
            foreach ($lists as $key => $val) {
            	$path_root = $key.'/';//图片二级目录
               foreach ($val as $key1 => $val1) {
                      // dump($val);exit();
               	      if (empty($val[$key1])) {
               	      	  del_files(C('UPLOAD_PATH').$path_root.$key1,true);
               	      }
	               	  if (is_string($key1)) {
	               	  	 $path_root_2 = $key1.'/';
	               	  	 foreach ($val1 as $val2) {
	               	  	  	        $images = $val2;
	               	  	
					               	  $res_1 = $this->db_ad->where("img like '%{$images}%'")->find();//广告位
				               	    $res_2 = $this->db_article->where("img like '%{$images}%' OR content like '%{$images}%'")->find();//文章
				               	    $res_3 = $this->db_article_category->where("img like '%{$images}%'")->find();//栏目
                            $res_4 = $this->db_richtext->where("pic like '%{$images}%' OR content like '%{$images}%'")->find(); //图文回复
				                
				                    $res_5 =$this->db_multi->where("pic like '%{$images}%' OR content like '%{$images}%'")->find(); //多图文回复
				               	  
				                        if (!$res_1 && !$res_2 && !$res_3 && !$res_4 && !$res_5) {
				               	        
				               	    	   $res = del_files(C('UPLOAD_PATH').$path_root.$path_root_2.$images);
				               	    	}
				                    
				               	    
	               	  	  } 
	               	  }else{
	               	  	 $path_root_2 = '';
	               	  	 $images = $val1;

	               	  	 			// $res_1 = $this->db_ad->where("img like '%{$images}%'")->find();
				               	    // $res_2 = $this->db_article->where("img like '%{$images}%' OR content like '%{$images}%'")->find();
				               	    // $res_3 = $this->db_article_category->where("img like '%{$images}%'")->find();
                        //        $res_4 = $this->db_richtext->where("pic like '%{$images}%' OR content like '%{$images}%'")->find(); //图文回复

				                
				               	    if (strpos(C('site_logo'), $images) ==false && strpos(C('site_qr'), $images) ==false && strpos(C('site_watermark'), $images) ==false) {
				               	  
				               	   
				               	        
				               	    	   $res = del_files(C('UPLOAD_PATH').$path_root.$path_root_2.$images);
				                    
				               	    }
	               	  }
	               	 
               	    
               	   

               }
             
              
            }

             if ($res) {
               	$this->success('自动清理完成');
            }else{
            	$this->error('自动清理完成，已无残余图片');
            }
            
    	}else{
    		$this->error('非法请求');
    	}
    }

   
}