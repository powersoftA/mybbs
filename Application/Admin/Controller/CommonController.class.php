<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct()
    {
    	parent::__construct();
    	if (empty($_SESSION['flag'])) {
    		$this -> error('您还未登录', '/index.php?m=admin&c=login&a=login');
    	}
    }
}