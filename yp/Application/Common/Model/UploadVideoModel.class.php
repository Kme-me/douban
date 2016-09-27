<?php
namespace Common\Model;
use Think\Model;

/**
 * 上传图片类
 * @author  singwa
 */
class UploadVideoModel extends Model {
	private $_uploadObj = '';
	private $_uploadVideoData = '';

	const UPLOAD = 'upload';

	public function __construct() {
//		$this->fileName=$fileName;//上传文件时，浏览框的名字
		//		$this->maxSize=$maxSize;//服务器端对上传文件限制的最大值
		//		$this->allowMime=$allowMime;//支持上传文件的类型
		//		$this->allowExt=$allowExt;//允许上传文件的扩展名
		//		$this->uploadPath=$uploadPath;//上传文件的路径
		//		$this->imgFlag=$imgFlag;//检测是否为真实的图片
		//		$this->fileInfo=$_FILES[$this->fileName];//将上传文件的信息保存在这里

		$this->_uploadObj = new \Think\Upload();

		$this->_uploadObj->rootPath = './' . self::UPLOAD . '/';
		$this->_uploadObj->subName = date(Y) . '/' . date(m) . '/' . date(d);
	}

	public function upload() {
		$res = $this->_uploadObj->upload();

		if ($res) {
			return './' . self::UPLOAD . '/' . $res['imgFile']['savepath'] . $res['imgFile']['savename'];
		} else {
			return false;
		}
	}

	public function videoUpload() {
		$res = $this->_uploadObj->upload();

		if ($res) {
			return './' . self::UPLOAD . '/' . $res['file']['savepath'] . $res['file']['savename'];
		} else {
			return false;
		}
	}
}
