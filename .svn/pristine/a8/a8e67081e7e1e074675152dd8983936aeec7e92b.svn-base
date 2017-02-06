<?php
namespace Admin\Controller;
use Think\Controller;
class UploadController extends Controller  {
   public function index(){
              $Type = I('post.Type'); //上传文件
              $OldImg = "." . I('post.OldImg');
              if (!empty($OldImg)) { //删除原来的照片
                if (file_exists($OldImg)) {
                   unlink($OldImg);
                }
              }
              $upload = new \Think\Upload();// 实例化上传类    
              $upload->rootPath  =  C('UPLOAD_PATH');
              $upload->maxSize   =  C('UPlOAD_SIZE') ;// 设置附件上传大小    
              $upload->exts      =  explode(',', C('UPLOAD_EXTS'));// 设置附件上传类型    
              $upload->savePath  =  $Type; // 设置附件上传目录    // 上传文件     

              if ($Type == 'logo/' || $Type =='watermark/' || $Type =='qr/' || $Type == 'prize/') {
                
                 $upload->saveName= rtrim($Type,'/').'-'.time();//设置命名名称
                 $upload->replace = true;// 存在同名是否覆盖
                 $upload->autoSub = false;

              }

              $info   =   $upload->upload(); 


              if((int)C('site_watermarkposition') >0 && $Type !=='logo/' && $Type !=='watermark/' && $Type !=='qr/'){
             $image = new \Think\Image(); // 在图片左上角添加水印（水印文件位于./logo.png） 水印图片的透明度为50 并保存为water.jpg

              $source =WEB_ROOT.C('UPLOAD_PATH').$info['file']['savepath'] . $info['file']['savename'];
              $water = WEB_ROOT.C('site_watermark');
              $source_size =$image-> open($source)->size();//获取原图尺寸
              $water_size =$image->  open($water)->size();//获取水印尺寸
                  if ($water_size[0] >= $source_size[0] || $water_size[1] >= $source_size[1]) {//水印较大的情况
                    //创建缩放水印目录
                    $water_path =WEB_ROOT. C('UPLOAD_PATH').'watermark_thumb';
                    if (!file_exists($water_path)) {
                        mkdir($water_path, 0777, true);
                    }
                    $water_thumb =$water_path.'/thumb.jpg';

                    $image->open($water)->thumb($source_size[0]*0.3,$source_size[1]*0.3)->save($water_thumb);//按百分比缩放
                    // $image->open($water)->thumb($source_size[0]/($water_size[0]/$source_size[0]),$source_size[1]/($water_size[1]/$source_size[1]))->save($water_thumb);//按比例缩放

                    $image->open($source)->water($water_thumb,C('site_watermarkposition'),C('site_watermarkalignment'))->save($source); 
                  }else{
                  $image->open($source)->water($water ,C('site_watermarkposition'),C('site_watermarkalignment'))->save($source); 
                  }
              }   
              if(!$info) {// 上传错误提示错误信息        
              $this->error($upload->getError());   
               }else{// 上传成功     
                        foreach($info as $file){
                       

                        $imgurl = str_replace('./','/',C('UPLOAD_PATH').$file['savepath'].$file['savename']);
                    
                        echo $imgurl;

                    }
              }
   }
}