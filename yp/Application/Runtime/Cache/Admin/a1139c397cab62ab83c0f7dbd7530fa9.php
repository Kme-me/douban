<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>后台管理平台</title>
    <!-- Bootstrap Core CSS -->
    <link href="/6x/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/6x/Public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/6x/Public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/6x/Public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/6x/Public/css/sing/common.css" />
    <link rel="stylesheet" href="/6x/Public/css/party/bootstrap-switch.css" />
    <link rel="stylesheet" type="text/css" href="/6x/Public/css/party/uploadify.css">

    <!-- jQuery -->
    <script src="/6x/Public/js/jquery.js"></script>
    <script src="/6x/Public/js/bootstrap.min.js"></script>
    <script src="/6x/Public/js/dialog/layer.js"></script>
    <script src="/6x/Public/js/dialog.js"></script>
    <script type="text/javascript" src="/6x/Public/js/party/jquery.uploadify.js"></script>

</head>

    



<body>
<div id="wrapper">

  <?php
 $navs = D("Menu")->getAdminMenus(); $username = getLoginUsername(); foreach($navs as $k=>$v) { if($v['c'] == 'admin' && $username != 'admin') { unset($navs[$k]); } } $index='index'; ?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    
    <a class="navbar-brand" >内容管理平台</a>
  </div>
  <!-- Top Menu Items -->
  <ul class="nav navbar-right top-nav">
    
    
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo getLoginUsername()?><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="./admin.php?c=admin&a=personal"><i class="fa fa-fw fa-user"></i> 个人中心</a>
        </li>
       
        <li class="divider"></li>
        <li>
          <a href="/6x/admin.php?c=login&a=loginout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
        </li>
      </ul>
    </li>
  </ul>
  <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav nav_list">
      <li <?php echo (getActive($index)); ?>>
        <a href="/6x/admin.php"><i class="fa fa-fw fa-dashboard"></i> 首页</a>
      </li>
      <?php if(is_array($navs)): $i = 0; $__LIST__ = $navs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><li <?php echo (getActive($nav["c"])); ?>>
        <a href="/6x/admin.php<?php echo (getAdminMenuUrl($nav)); ?>"><i class="fa fa-fw fa-bar-chart-o"></i><?php echo ($nav["name"]); ?></a>
      </li><?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>
  </div>
  <!-- /.navbar-collapse -->
</nav>
  <div id="page-wrapper">

    <div class="container-fluid" >

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">

          <ol class="breadcrumb">
            <li>
              <i class="fa fa-dashboard"></i>  <a href="/6x/admin.php?c=content">文章管理</a>
            </li>
            <li class="active">
              <i class="fa fa-table"></i>文章列表
            </li>
          </ol>
        </div>
      </div>
      <!-- /.row -->
      <div >
        <button  id="button-add" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true">
        </span>添加</button>
      </div>
      <br>


      <div class="row">
        <form action="/6x/admin.php" method="get">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon">年级</span>
              <select class="form-control" name="school_nj" onchange="list_nj()" id="nj">
                <option value='' selected="selected">全部分类</option>
                  <?php if(is_array($school_nj)): foreach($school_nj as $key=>$nj): ?><option value="<?php echo ($nj); ?>"><?php echo ($nj); ?></option><?php endforeach; endif; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-addon">科目</span>
              <select class="form-control" name="school_km" onchange="list_nj()" id="km">
                <option value=''selected="selected" >所有科目</option>
                  <?php if(is_array($school_km)): foreach($school_km as $k=>$km): ?><option value="<?php echo ($k); ?>"><?php echo ($km); ?></option><?php endforeach; endif; ?>
              </select>
            </div>
          </div>
     

          <input type="hidden" name="c" value="video"/>
          <input type="hidden" name="a" value="index"/>
          <div class="col-md-3">
            <div class="input-group">
              <input class="form-control" name="title" type="text" value="" placeholder="老师"  id="search"/>
                <span class="input-group-btn">
                  <button id="sub_data" class="btn btn-primary" type="button" onclick ="list_nj()"><i class="glyphicon glyphicon-search" ></i></button>
                </span>
            </div>
          </div>
        </form>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <h3></h3>
          <div class="table-responsive">
            <form id="singcms-listorder">
              <table class="table table-bordered table-hover singcms-table">
                <thead>
                <tr>
                  <th id="singcms-checkbox-all" width="10"><input type="checkbox"/></th>
                  <th width="14">排序</th>
                  <th>id</th>
                  <th>年级</th>
                  <th>科目</th>
                  <th>老师</th>
                  <th>课题</th>
                  <th>时间</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(is_array($videos)): $i = 0; $__LIST__ = $videos;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$video): $mod = ($i % 2 );++$i;?><tr id="video_<?php echo ($video["id"]); ?>">
                    <td><input type="checkbox" name="pushcheck" value="<?php echo ($video["id"]); ?>"/></td>
                    <td><input size=4 type='text'  name='listorder[<?php echo ($video["id"]); ?>]' value="<?php echo ($video["listorder"]); ?>"/></td><!--6.7-->
                    <td><?php echo ($video["id"]); ?></td>
                    <td><?php echo (getNjById($video["school_nj"])); ?></td>
                    <td><?php echo (getKmById($video["school_km"])); ?></td>
                    <td><?php echo ($video["school_ls"]); ?></td>
                    <td><?php echo ($video["school_kt"]); ?></td>
                    <td><?php echo (date("Y-m-d H:i",$video["create_time"])); ?></td>
                    <td>
                    <a href="/6x/admin.php?c=video&a=showlist&id=<?php echo ($video["id"]); ?>">
                    <span class="sing_cursor glyphicon glyphicon-edit" aria-hidden="true" id="singcms-edit" attr-id="<?php echo ($video_id); ?>" ></span>
                    </a>
                    <a href="javascript:;" id="singcms-delete"  attr-id="<?php echo ($video["id"]); ?>"  attr-message="删除" >
                        <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" ></span>
                    </a>
                      <a  href="/6x/admin.php?c=video&a=liulan&id=<?php echo ($video["id"]); ?>" class="sing_cursor glyphicon glyphicon-eye-open" aria-hidden="true"  ></a>
                    </td>
                  </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                </tbody>
              </table>
              <nav>

              <ul >
                
              </ul>

            </nav>
              

                    <nav>
                        <ul class="pagination">
                            <?php echo ($pageres); ?>
                        </ul>
                    </nav>


                        <!-- 排序按钮-->
                        <div>
                            <button  id="button-listorder" type="button" class="btn btn-primary dropdown-toggle pull-left" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>更新排序</button>
                        </div>

<br><br>
            <div class="input-group">
              <select class="form-control" name="position_id" id="select-push">
                <option value="0">请选择推荐位进行推送</option>
                <?php if(is_array($positions)): foreach($positions as $key=>$position): ?><option value="<?php echo ($position["id"]); ?>"><?php echo ($position["name"]); ?></option><?php endforeach; endif; ?>
              </select>
              <button id="singcms-push" type="button" class="btn btn-primary">推送</button>
            </div>
          </div>
        </div>
            </form>
      </div>
      <!-- /.row -->



    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<script>

    var SCOPE = {
        'add_url' : "/6x/admin.php?c=video&a=add",
        'set_status_url' : '/6x/admin.php?c=video&a=setStatus',
    }

</script>
<script src="/6x/Public/js/admin/common.js"></script>



</body>

</html>