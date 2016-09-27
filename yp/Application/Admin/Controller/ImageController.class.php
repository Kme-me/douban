<?php
/**
 * Created by PhpStorm.
 * User: WHadmin
 * Date: 2016/5/20
 * Time: 18:39
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class ImageController extends CommonController{
  private $_uploadObj;
  public function __construct(){

  }

  public function ajaxuploadimage(){
    $upload = D("UploadImage");
    $res = $upload->imageUpload();
    if($res===false){
      return show(0,"上传失败");
    }else{
      return show(1,"上传成功",$res);
    }
  }

  public function kindupload(){
    $upload = D("UploadImage");
    $res = $upload->upload();
    if($res === false){
      return showKind(1,'文本框上传失败');
    }else{
      return showKind(0,$res);
    }
  }

}