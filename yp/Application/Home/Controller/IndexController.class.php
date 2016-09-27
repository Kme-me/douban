<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
	public function index() {
		// $info = D('yp_time')
		// 	->alias('t')
		// 	->join('yp as y on t.id=y.time_id')
		// 	->field('t.time,y.*')
		// 	->select();
		$movie = D('yp')
			->field('distinct movie')
			->order('id desc')
			->select();
		$date = D('yp_time')->order('id desc')->select();
		// $this->assign('info', $info);
		$this->assign('date', $date);
		$this->assign('movie', $movie);
		$this->display();
		//$this->success('aaa', U('index/fenlei'), 9);
	}
	public function fenlei() {
		$movie = I('get.movie');
		$time = I('get.time');
		if ($movie) {
			$yp = D('yp')->where(array('movie' => $movie))->Distinct(true)->order('id desc')->field('title,id')->select();
		}
		if ($time) {
			$yp = D('yp_time')
				->alias('t')
				->join('yp as y on t.id=y.time_id')
				->where(array('t.time' => $time))
				->Distinct(true)
				->field('y.title,y.id,y.movie')
				->order('id desc')
				->select();
		}
		$this->assign('yp', $yp);
		$this->display();

	}

	public function content() {
		$id = I('get.movie_id');
		$info = D('yp')->find($id);
		$this->assign('info', $info);
		$this->display();
	}

}