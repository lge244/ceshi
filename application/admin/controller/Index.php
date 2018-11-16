<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\controller\Common;
use think\facade\Session;

class Index extends Common
{
    public function index()
    {
        $username = Session::get('username');
        $this->view->username=$username;
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }

}
