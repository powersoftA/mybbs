<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/> -->
    <script type="text/javascript" src="/Public/Admin/js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">用户管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="index.html">首页</a></li>
                <li><a href="http://www.mycodes.net/" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="#"><?= $_SESSION['userInfo']['uname'] ?></a></li>
                <li><a href="#">修改密码</a></li>
                <li><a href="/index.php?m=admin&c=login&a=logout">退出</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container clearfix">
    <div class="sidebar-wrap">
        <div class="sidebar-title">
            <h1>菜单</h1>
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li>
                    <a href="#"><i class="icon-font">&#xe003;</i>用户管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=user&a=create"><i class="icon-font">&#xe008;</i>添加用户</a></li>
                        <li><a href="/index.php?m=admin&c=user&a=index"><i class="icon-font">&#xe005;</i>显示用户</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>分区管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=part&a=create"><i class="icon-font">&#xe017;</i>添加分区</a></li>
                        <li><a href="/index.php?m=admin&c=part&a=index"><i class="icon-font">&#xe037;</i>显示分区</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="icon-font">&#xe018;</i>版块管理</a>
                    <ul class="sub-menu">
                        <li><a href="/index.php?m=admin&c=cate&a=create"><i class="icon-font">&#xe017;</i>添加版块</a></li>
                        <li><a href="/index.php?m=admin&c=cate&a=index"><i class="icon-font">&#xe037;</i>显示版块</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!--/sidebar-->
    
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="index.html">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">作品管理</span></div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="/index.php?m=admin&c=user&a=index&sex=<?php echo $_GET['sex'] ?>&uname=<?php echo $_GET['uname']; ?>" method="GET">
                    <input type="hidden" name="m" value="admin">
                    <input type="hidden" name="c" value="user">
                    <input type="hidden" name="a" value="index">
                    <table class="search-tab">
                        <tr>
                            <th width="120">性别:</th>
                            <td>
                                <select name="sex">
                                    <option value="w" <?php if($_GET['sex'] == 'w'){echo 'selected';} ?>>女</option>
                                    <option value="m" <?php if($_GET['sex'] == 'm'){echo 'selected';} ?>>男</option>
                                    <option value="x" <?php if($_GET['sex'] == 'x'){echo 'selected';} ?>>保密</option>
                                </select>
                            </td>
                            <th width="70">姓名:</th>
                            <td><input class="common-text" placeholder="输入姓名" name="uname" value="<?php echo $_GET['uname']; ?>" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="GET">
                <div class="result-title">
                    <div class="result-list">
                        <a href="insert.html"><i class="icon-font"></i>新增作品</a>
                        <a id="batchDel" href="javascript:void(0)"><i class="icon-font"></i>批量删除</a>
                        <a id="updateOrd" href="javascript:void(0)"><i class="icon-font"></i>更新排序</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>头像</th>
                            <th>性别</th>
                            <th>权限</th>
                            <th>注册时间</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach($users as $k=>$v): ?>
                        <tr>
                            <th class="tc" width="5%"><input class="allChoose" name="" type="checkbox"></th>
                            <td><?php echo $v['uid']; ?></td>
                            <td><?php echo $v['uname']; ?></td>

                            <td>
                                <img src="<?php echo getSm($users[$k]['uface']) ?>">
                            </td>
                            <td>
                                <?php  if($v['sex'] == 'w') { echo '女'; }else if($v['sex'] == 'm'){ echo '男'; }else if($v['sex'] == 'x') { echo '保密'; } ?>
                            </td>
                            <td>
                                <?php
 if($v['auth'] == 1) { echo '超级管理员'; } else if($v['auth'] == 2) { echo '管理员'; } else if($v['auth'] == 3) { echo '普通会员'; } ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s' ,$v['created_at']); ?></td>
                            <td>
                                <a class="link-update" href="/index.php?m=admin&c=user&a=edit&uid=<?php echo $v['uid']; ?>">修改</a>
                                <a class="link-del" href="/index.php?m=admin&c=user&a=del&uid=<?php echo $v['uid']; ?>">删除</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="list-page"><?php echo $page; ?></div>
                </div>
            </form>
        </div>
    </div>

    <!--/main-->
</div>
</body>
</html>