<?php
/**
 *
 */

namespace app\admin\controller;

use think\Controller;
use think\facade\Session;

class Common extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Session::has('username')) {
            $this->error('您还未登录！请返回登录！','Login/Login');
        }
    }
}