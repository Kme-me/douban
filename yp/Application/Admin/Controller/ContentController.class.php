<?php
/**
 *文章管理控制器
 *@author sunchao <[sss9892100@qq.com]>
 *
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class ContentController extends Controller
{
     public function index(){
        $conds = array();
        $title = $_GET['title'];
        if($title){
            $conds['title'] = $title;
        }
        if($_GET['catid']){
            $conds['catid'] = intval($_GET['catid']);
        }

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 5;
        $conds['status'] = array('neq',-1);
        $news = D("News")->getNews($conds,$page,$pageSize);
        $count = D("News")->getNewsCount($conds);

//        print_r($news);

        $res = new \Think\Page($count,$pageSize);
        $pageres = $res->show();

        $positions = D("Position")->getNormalPositions();//这里是推荐位相关代码

        $this->assign('pageres',$pageres);
        $this->assign('news',$news);
        $this->assign('positions',$positions);//这里是推荐位相关代码

        $this->assign('title',$conds['title']);//自己加上的，否则16-19行的代码就无意义了
        $this->assign('catid',$conds['catid']);//自己加上的，否则16-19行的代码就无意义了
        $this->assign('webSiteMenu',D("Menu")->getBarMenus());
        $this->display();
     }

    public function add(){
        if ($_POST) {
            if(!isset($_POST['title']) || !$_POST['title']){
                return show(0,'标题不存在');
            }
            if(!isset($_POST['small_title']) || !$_POST['small_title']){
                return show(0,'短标题不存在');
            }
            if(!isset($_POST['catid']) || !$_POST['catid']){
                return show(0,'文章栏目不存在');
            }
            if(!isset($_POST['keywords']) || !$_POST['keywords']){
                return show(0,'关键字不存在');
            }
            if(!isset($_POST['content']) || !$_POST['content']){
                return show(0,'content不存在');
            }

            if($_POST['news_id']){
                return $this->save($_POST);
            }
            $newsId = D('News')->insert($_POST);

            if($newsId){
                $newsContentData['content']=$_POST['content'];
                $newsContentData['news_id']=$newsId;
                $cId = D("NewsContent")->insert($newsContentData);
                if($cId){
                    return show(1,'新增成功');
                }else{
                    return show(1,'主表插入成功，副表插入失败');
                }
            }else{
                return show(0,'新增失败');
            }
        } else {

            $webSiteMenu = D("Menu")->getBarMenus();
            //print_r($webSiteMenu);exit;
            $titleFontColor = C("TITLE_FONT_COLOR");
            $copyFrom = C("COPY_FROM");
            //print_r($copyFrom);exit;
            $this->assign('webSiteMenu',$webSiteMenu);
            $this->assign('titleFontColor',$titleFontColor);
            $this->assign('copyfrom',$copyFrom);
            $this->display();
       }
        
    }

    /**
     * 编辑要修改的已发表文章的记录
     */
    public function edit(){

        $newsId = $_GET['id'];
        if(!newsId){
            //执行跳转
            $this->redirect('/tyhcms/admin.php?c=content');
        }
        $news = D("News")->find($newsId);
        if(!$news){
            //执行跳转
            $this->redirect('/tyhcms/admin.php?c=content');
        }
        $newsContent = D("NewsContent")->find($newsId);
//        print_r($newsContent);exit;
        if($newsContent){
            $news['content'] = $newsContent['content'];
        }

        $webSiteMenu = D("Menu")->getBarMenus();
        $this->assign('webSiteMenu',$webSiteMenu);
        $this->assign('titleFontColor',C("TITLE_FONT_COLOR"));
        $this->assign('copyfrom',C("COPY_FROM"));

        $this->assign('news',$news);
        $this->display();
    }

    public function save($data){
        $newsId = $data['news_id'];
        unset($data['news_id']);

        try{
            $id = D("News")->updateById($newsId,$data);
            $newsContentData['content'] = $data['content'];
            $condId = D("NewsContent")->updateNewsById($newsId,$newsContentData);
            if($id === flase || $condId === flase){
                return show(0,'更新失败!');
            }
            return show(1,'更新成功');
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }
    }

    public function setStatus(){
        try{
        if($_POST){
            $id = $_POST['id'];
            $status = $_POST['status'];
            if(!$id){
                return show(0,'ID不存在');
            }
            $res = D("News")->updateStatusById($id,$status);
            if($res){
                return show(1,'操作成功');
            }else{
                return show(0,'操作失败');
            }
        }
        return show(0,'没有提交内容');
    }catch(Exception $e){
        return show(0,$e->getMessage());
    }
    }


    /*仿的菜单排序*/
    public function listorder(){
        $listorder = $_POST['listorder'];
        $jumpUrl =$_SERVER['HTTP_REFERER'];
        $errors=array();
        if($listorder){
            try {
                foreach ($listorder as $newId => $v) {
                    //执行更新
                    $id = D('News')->updataNewsListorderById($newId, $v);
                    if ($id === flase) {
                        $errors[] = $newId;
                    }
                }
            }catch(Exception $e){
                return show(0,$e->getMessage(),array('jump_url'=>$jumpUrl));

            }
            if($errors){
                return show(0,'排序失败-'.implode(',',$errors),array('jump_url'=>$jumpUrl));
            }
            return show(1,'排序成功',array('jump_url'=>$jumpUrl));
        }
        return show(0,'排序数据失败',array('jump_url'=>$jumpUrl));
    }


    public function push(){
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $positionId = intval($_POST['position_id']);
        $newsId = $_POST['push'];

        if (!$newsId || !is_array($newsId)) {
            return show(0,'请选择要推荐的文章ID进行推荐');
        }
        if (!$positionId) {
            return show(0,'没有选择推荐位');
        }
        //print_r($push);exit;
        try {
            
        $news = D("News")->getNewsByNewsIdIn($newsId);
        if(!news){
            return show(0,'没有相关内容');
        }

        foreach($news as $new){
            $data = array(
                'position_id' => $positionId,
                'title' => $new['title'],
                'thumb' => $new['thumb'],
                'news_id' => $new['news_id'],
                'status' =>1,
                'create_time' => $new['create_time'],
            );
            $position = D("PositionContent")->insert($data);
        }
        } catch (Exception $e) {
            return show(0,$e->getMessage());
        }
        return show(1,'推荐成功',array('jump_url'=>$jumpUrl));
    }

    public function insert($data = array()){
        if(!$data || !is_array($data)){
            return 0;
        }
        return $this->_db->add($data);
    }



}