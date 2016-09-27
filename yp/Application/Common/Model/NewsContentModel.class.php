<?php
/**
*文章内容的存储操作
*@author sunchao <[sss9892100@qq.com]>
*/

namespace Common\Model;
use Think\Model;

class NewsContentModel extends Model{
    private $_db='';

    public function __construct(){
        $this->_db = M('news_content');
    }

    public function insert($data=array()){
        if(!$data || !is_array($data)){
            return 0;
        }
        $data['create_time'] = time();
        if(isset($data['content']) && $data['content']){
            $data['content'] = htmlspecialchars($data['content']);//数据库保存富文本编辑器的内容
        }
        //print_r($data);exit;
        return $this->_db->add($data);
    }

    public function find($id){
        if(!$id || !is_numeric($id)){
            return array();
        }
        $data = $this->_db->where('news_id='.$id)->find();
        return $data;
    }

    public function updateNewsById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception('更新数据不合法');
        }
        if(isset($data['content']) && $data['content']){
            $data['content'] = htmlspecialchars($data['content']);//数据库保存富文本编辑器的内容
        }

        return $this->_db->where('news_id='.$id)->save($data);
        
    }

}