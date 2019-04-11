<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function create()
    {
    	$this -> display();
    }

    public function index()
    {
        $condition = [];
        //判断性别是否为空
        if(!empty($_GET['sex'])) {
            $condition['sex'] = ['eq', $_GET['sex']];
        }

        //判断姓名是否为空
        if(!empty($_GET['uname'])) {
            $condition['uname'] = ['like', "%{$_GET['uname']}%"];
        }

        //统计所有记录数
        $User = M('bbs_user');
        $count = $User->where($condition)->count();
        //分页
        $Page = new \Think\Page($count, 3);
        $show = $Page -> show(); 
    	$cnt = $User->where($condition)->limit($Page->firstRow, $Page->listRows)->select();

        //遍历获得缩略图结果集
        // foreach($cnt as $k=>$v) {
        //     $uface = explode('/', $v['uface']);
        //     $uface[3] = 'sm_' . $uface[3];
        //     $sm_uface = implode('/', $uface);
        //     $cnt[$k]['uface'] = '/'.$sm_uface;
        // }

    	$this -> assign('users', $cnt);
        $this -> assign('page', $show);
    	$this -> display();
    }

    public function save()
    {
    	//判断账号或密码是否为空
    	if(empty($_POST['uname']) || empty($_POST['upwd']) || empty($_POST['reupwd'])) {
    		$this -> error('账号或密码不能为空');
    	}

    	//判断两次密码是否一致
    	if($_POST['upwd'] !== $_POST['reupwd']) {
    		$this -> error('两次密码输入不一致');
    	}
    	$_POST['created_at'] = time();

    	//对密码加密
    	$_POST['upwd'] = password_hash($_POST['upwd'], PASSWORD_DEFAULT);

        //上传图片
        $fileName = $this -> doUp();
        //生成缩略图文件名
        $this -> doSm($fileName);
        //取得文件名
        $_POST['uface'] = $fileName;

    	//插入数据
    	$row = M('bbs_user')->add($_POST);
    	if($row) {
    		$this -> success('添加用户成功', '/index.php?m=admin&c=user&a=index');
    	} else {
    		$this -> error('添加用户失败');
    	}
    }

    public function del()
    {
    	//删除数据
    	$row = M('bbs_user')->delete($_GET['uid']);
    	if($row) {
    		$this -> success('删除数据成功');
    	} else {
    		$this -> error('删除数据失败');
    	}
    }

    public function edit()
    {
    	//先把对应id的数据查询出来
    	$uid = $_GET['uid'];
    	$user = M('bbs_user')->where("uid=$uid")->find();
        //缩略图
        $uface = explode('/', $user['uface']);
        $uface[3] = 'sm_'.$uface[3];
        $user['uface'] = implode('/', $uface);

    	$this -> assign('user', $user);
    	$this -> display(); 
    }

    public function update()
    {
    	//接收id
        $uid = $_GET['uid'];
        $data = $_POST;
        if($_FILES['uface']['error'] !== 4) {
            //获取原图文件名
            $fileName = $this->doUp();
            //获取缩略图文件名
            // $thumb_name = getSm($fileName);
            //上传缩略图
            $this->doSm($fileName);

            $data['uface'] = $fileName; 
        }
        // echo '<pre>';
        // var_dump($data);
        // die;

    	$rows = M('bbs_user')->where("uid=$uid")->save($data);
    	if($rows) {
    		$this -> success('修改数据成功', '/index.php?m=admin&c=user&a=index');
    	} else {
    		$this -> error('修改数据失败');
    	}
    }

    private function doUp()
    {
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 3145728 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './'; // 设置附件上传根目录
        $upload->savePath = 'public/Upload/'; // 设置附件上传（子）目录
        // 上传文件
        $info = $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }

        //获取文件名
        return $this->fileName = $info['uface']['savepath'] . $info['uface']['savename'];
    }

    private function doSm($fileName)
    {
        //生成缩略图
        $image = new \Think\Image();
        $image->open($fileName);
        // 生成一个缩放后填充大小150*150的缩略图并保存为thumb.jpg
        $image->thumb(150, 150,\Think\Image::IMAGE_THUMB_FILLED)->save('./'.getSm($fileName));
    }

}