<?php 
$this->benchmark->mark('code_start');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/static/img/favicon.ico">

    <title><?=$title?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url("/static/css/bootstrap.css")?>" rel="stylesheet">
    <link href="<?=base_url("/static/css/style.css")?>" rel="stylesheet" type="text/css" >
    <link href="<?=base_url("/static/css/bootstrap-datetimepicker.min.css")?>" rel="stylesheet" type="text/css" >
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    <?php if (isset($style)) 
    {
      echo $style;
    }
    ?>
    </style>
  </head>
<body>
<?php if(!(isset($noNavbar) && $noNavbar==TRUE)): ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">薪酬管理系统</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a href="/home">
          <span class="glyphicon glyphicon glyphicon glyphicon-home"></span> Home</a>
      </li>
       <li><a href="/contacts">
          <span class=" glyphicon glyphicon-list"></span>
            通讯录</a>
       </li>
<?php 
$hrms = ($this->session->userdata('hrms'));
if ($hrms['priority']>1) :?>

        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-calendar"> </span> 考勤<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/attendance_controller/attendanceList">查看当月考勤</a></li>
          <li><a href="/attendance_controller/addRecord" >添加考勤信息</a></li>
          <li><a href="/attendance_controller/setCoefficient">设置考勤参数</a></li>
        </ul>
      </li>
       <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-user"> </span> 岗位<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/position_controller">职员列表</a></li>
          <li><a href="/position_controller/addStaffView" id="add_btn">增加员工</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="glyphicon glyphicon-list-alt"> </span> 薪酬<b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/salary_controller/getSummarySheet">已有薪酬表</a></li>
          <li><a href="/salary_controller/addSalaryList">新建薪酬表</a></li>
        </ul>
      </li>
<?php endif;?>
    <!-- 2016/12/07
      <li class="dropdown">
        <a href="/about">
          <span class=" glyphicon glyphicon-question-sign"></span> 关于
        </a>
      </li>
    -->


    </ul>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<?php

echo $hrms['name']; 
?>
        <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="/user/security">
             <span class="  glyphicon glyphicon-wrench"></span> 设置</a>
          </li>
          <li class="divider"></li>
          <li><a href="/user/logout">
            <span class="  glyphicon glyphicon-log-out"></span> 登出</a>
          </li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

<?php endif; ?>
<div class="container">
  <?php if ($this->session->flashdata('error')):?>
      <div class="alert alert-danger">
        <a class="close" data-dismiss="alert">×</a>
        <?php echo $this->session->flashdata('error');?>
      </div>
    <?php endif;?>
    
    <?php if (!empty($error)):?>
      <div class="alert alert-danger">
        <a class="close" data-dismiss="alert">×</a>
        <?php echo $error;?>
      </div>
    <?php endif;?>
 <?php if ($this->session->flashdata('success')):?>
      <div class="alert alert-success">
        <a class="close" data-dismiss="alert">×</a>
        <?php echo $this->session->flashdata('success');?>
      </div>
    <?php endif;?>
<?php if (!empty($success)):?>
      <div class="alert alert-success">
        <a class="close" data-dismiss="alert">×</a>
        <?php echo $success;?>
      </div>
    <?php endif;?>

