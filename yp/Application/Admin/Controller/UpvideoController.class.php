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

class UpvideoController extends CommonController{
  private $_uploadObj;
  public function __construct(){

  }

  public function ajaxuploadvideo(){
    $upload = D("UploadVideo");
    $res = $upload->videoUpload();
    if($res===false){
      return show(0,"上传失败");
    }else{
      return show(1,"上传成功！！",$res);
    }
	
//	$dest=$upload->uploadFile();
//echo "$dest";exit;
  }

}