<?php
/**
 *上传视频控制器
 *@author sunchao <[sss9892100@qq.com]>
 *
 */

namespace Admin\Controller;
use Think\Controller;

class VideoController extends CommonController {
	public function index() {
		$conds = array();
		$school_ls = $_GET['school_ls'];
		if ($school_ls) {
			$conds['school_ls'] = $school_ls;
		}
		if ($_GET['njkey']) {
			$conds['school_nj'] = intval($_GET['njkey']);
		}
		if ($_GET['km']) {
			$conds['km'] = intval($_GET['km']);
		}

		$page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
		$pageSize = 20;//每页显示一条
		$conds['status'] = array('neq', -1);
		$videos = D("Video")->getVideo($conds, $page, $pageSize);
		$count = D("Video")->getVideoCount($conds);

		$res = new \Think\Page($count, $pageSize);
		$pageres = $res->show();

		$this->assign('pageres', $pageres);
		$this->assign('videos', $videos);
		$school_nj = C("SCHOOL_NIANJI");
		$school_km = C("SCHOOL_KEMU");
		$this->assign('school_nj', $school_nj);
		$this->assign('school_km', $school_km);
		$this->display();
	}

	public function add() {
		if ($_POST) {

			if (!isset($_POST['school_ls']) || !$_POST['school_ls']) {
				return show(0, '老师不存在');
			}
			if (!isset($_POST['school_kt']) || !$_POST['school_kt']) {
				return show(0, '课题不能为空');
			}
			if (!isset($_POST['thumb']) || !$_POST['thumb']) {
				return show(0, '封面不能为空');
			}
			if (!isset($_POST['vurl']) || !$_POST['vurl']) {
				return show(0, '视频不能为空');
			}

			$videoId = D("Video")->insert($_POST);
			if ($videoId) {
				return show(1, '新增成功');
			} else {
				return show(0, '新增失败');
			}

		} else {
			$school_nj = C("SCHOOL_NIANJI");
			$school_km = C("SCHOOL_KEMU");
			$this->assign('school_nj', $school_nj);
			$this->assign('school_km', $school_km);
			$this->display();
		}
	}
//修改的展示
	public function showlist() {
		$video_id = I('get.id');
		if ($video_id) {
			$video_info = D('video')->where("id = $video_id")->find();
			$school_nj = C("SCHOOL_NIANJI");
			$school_km = C("SCHOOL_KEMU");
			$this->assign('school_nj', $school_nj);
			$this->assign('school_km', $school_km);
			$this->assign('info', $video_info);
		}

		$this->display();
	}
//修改执行
	public function upd() {
		if ($_POST) {
			if (!isset($_POST['school_ls']) || !$_POST['school_ls']) {
				return show(0, '老师不存在');
			}
			if (!isset($_POST['school_kt']) || !$_POST['school_kt']) {
				return show(0, '课题不能为空');
			}
			$id = I('post.id');
			$data['school_nj'] = $_POST['school_nj'];
			$data['school_km'] = $_POST['school_km'];
			$data['school_ls'] = $_POST['school_ls'];
			$data['school_kt'] = $_POST['school_kt'];
			$data['thumb'] = $_POST['thumb'];
			$data['vurl'] = $_POST['vurl'];
			//print_r($data);
			$videoId = M("Video")->where(array('id' => $id))->save($data);
			if ($videoId) {
				return show(1, '新增成功');
			} else {
				return show(0, '新增失败');
			}

		} else {
			$school_nj = C("SCHOOL_NIANJI");
			$school_km = C("SCHOOL_KEMU");
			$this->assign('school_nj', $school_nj);
			$this->assign('school_km', $school_km);
			$this->display();
		}

	}

//浏览
	public function liulan() {
		$video_id = I('get.id');
		if ($video_id) {
			$video_info = D('video')->where("id = $video_id")->find();
			$km = $video_info['school_km'];
			$school_km = C("SCHOOL_KEMU");
			$video_info['school_km'] = $school_km["$km"];
			//print_r($video_info);
			//die();
			$this->assign('info', $video_info);
		}

		$this->display();
	}

//按分类查询
	public function chaxun() {
		$nj = I('get.nj');
		$km = I('get.km');
		$search = I('get.search');
		if (!empty($search)) {
//
			$video_info = D('video')->where('school_ls like "%' . $search . '%" ')->select();
			$video_info['0']['search'] = '1';
			//SELECT * FROM `cms_video` WHERE school_ls like "%李%"
		} elseif (!empty($nj) && !empty($km)) {
			$video_info = D('video')->where(array('school_nj' => $nj, 'school_km' => $km))->select();

		} elseif (!empty($nj)) {
			$video_info = D('video')->where(array('school_nj' => $nj))->select();

		} elseif (!empty($km)) {
			$video_info = D('video')->where(array('school_km' => $km))->select();
		} else {
			$video_info = D('video')->select();
		}
		$school_km = C("SCHOOL_KEMU");
		foreach ($video_info as $k => $v) {
			$km = getKmById($v['school_km']);
			$video_info["$k"]['school_km'] = $km;//转换科目名称
			$video_info["$k"]['create_time'] = date("Y-m-d H:i", $v['create_time']);//格式化时间
		}

		echo json_encode($video_info);
	}

// 修改视频状态
	public function setStatus() {
		try {
			if ($_POST) {
				$id = $_POST['id'];
				$status = $_POST['status'];
				if (!$id) {
					return show(0, 'ID不存在');
				}
				$data['status'] = $status;
				$res = D("video")->where(array('id' => $id))->save($data);
				if ($res) {
					return show(1, '操作成功');
				} else {
					return show(0, '操作失败');
				}
			}
			return show(0, '没有提交内容');
		} catch (Exception $e) {
			return show(0, $e->getMessage());
		}
	}
}