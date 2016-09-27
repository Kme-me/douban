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
		<script src="/6x/Public/js/kindeditor/kindeditor-all.js"></script>
		<div id="page-wrapper">

			<div class="container-fluid">

				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">

						<ol class="breadcrumb">
							<li>
								<i class="fa fa-dashboard"></i> <a href="/6x/admin.php?c=menu">菜单管理</a>
							</li>
							<li class="active">
								<i class="fa fa-table"></i>上传视频
							</li>
						</ol>
					</div>
				</div>

				<!-- /.row -->

				<div class="row">
					<div class="col-lg-6">

						<form class="form-horizontal" id="singcms-form">
							<!--
              	作者：sss9892100@qq.com
              	时间：2016-07-25
              	描述：
              -->
            <div class="form-group">
              <label for="inputname" class="col-sm-2 control-label">年级:</label>
              <div class="col-sm-5">
                <input class="form-control" name="school_nj" value="<?php echo ($info["school_nj"]); ?>" disabled="true"> 
              </div>
            </div>

            <div class="form-group">
              <label for="inputname" class="col-sm-2 control-label">科目:</label>
              <div class="col-sm-5">             
         <input class="form-control" name="school_km" value="<?php echo ($info["school_km"]); ?>" disabled="true"> 
              </div>
            </div>


            <div class="form-group">
              <label for="inputname" class="col-sm-2 control-label">老师:</label>
              <div class="col-sm-5">
                <input type="text" name="school_ls" class="form-control" id="inputname" placeholder="请填写老师姓名" value="<?php echo ($info["school_ls"]); ?>" disabled="true">
              </div>
            </div>
            <div class="form-group">
              <label for="inputname" class="col-sm-2 control-label">课题:</label>
              <div class="col-sm-5">
                <input type="text" name="school_kt" class="form-control" id="inputname" placeholder="请填写课题" value="<?php echo ($info["school_kt"]); ?>" disabled="true">
              </div>
            </div>
			<div class="form-group">
				<label for="inputname" class="col-sm-2 control-label">封面:</label>

				<div class="col-sm-5">             
                     <video width="100%" height="100%" poster="<?php echo ($info["thumb"]); ?>" controls preload="none" controls="controls">
                     <source src="<?php echo ($info["vurl"]); ?>"/>不支持当前浏览器</video>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
								<a href="/6x/admin.php?c=video&a=showlist&id=<?php echo ($info["id"]); ?>">
									<button type="button" class="btn btn-default" id="singcms-button-submit">编辑</button>
								</a>
								</div>
							</div>
						</form>

					</div>

				</div>
				<!-- /.row -->

			</div>
			<!-- /.container-fluid -->

		</div>
		<!-- /#page-wrapper -->

	</div>
	<script>
		var SCOPE = {
			'save_url': '/6x/admin.php?c=video&a=upd',
			'jump_url': '/6x/admin.php?c=video',
		    'ajax_upload_image_url' : '/6x/admin.php?c=image&a=ajaxuploadimage',
			'ajax_upload_video_url': '/6x/admin.php?c=upvideo&a=ajaxuploadvideo',
			'ajax_upload_swf': '/6x/Public/js/party/uploadify.swf',
		};
	</script>
	<!-- /#wrapper -->
	<script src="/6x/Public/js/admin/image.js"></script>
	<script src="/6x/Public/js/admin/video.js"></script>
	<script src="/6x/Public/js/admin/common.js"></script>



</body>

</html>