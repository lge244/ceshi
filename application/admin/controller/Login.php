<?php
/**
 *
 */

namespace app\admin\controller;

use app\admin\model\UserModel;
use think\Controller;
use think\facade\Request;
use think\facade\Session;

class Login extends Controller
{
    public function login()
    {
        // 渲染登录页面
        return $this->fetch();
    }

    public function DoLogin()
    {
        // 获取前台提交的数据
        $data = Request::param();
        $username = $data['username'];
        // 使用变量作为查询条件到数据库中查询对应的数据
        $user = UserModel::where('username', $username)->find();
        if ($user != true) {
            $info = ['res' => 0, 'msg' => '用户名不存在！'];
        } elseif ($data['password'] != $user['password']) {
            $info = ['res' => 0, 'msg' => '密码错误！'];
        } else {
            $info = ['res' => 1, 'msg' => '登录成功！'];
            Session::set('username', $user['username']);
        }
        return $info;
    }

    public function LoginOut()
    {
        // 删除用户名
        Session::delete('username');
        // 退出跳转
        $this->redirect('login');
    }
}