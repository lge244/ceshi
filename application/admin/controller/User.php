<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/13 0013
 * Time: 下午 3:04
 */

namespace app\admin\controller;

use app\admin\model\UserModel;
use think\facade\Request;
use app\admin\controller\Common;
class User extends Common
{
    public function index()
    {
        // 实例化模型
        $user = new UserModel();
        // 按id降序排列，并且每一页设为八条数据
        $users = $user->order('id', 'desc')->paginate(8);
        // 将数据赋值给模板
        $this->view->users = $users;
        // 渲染管理员界面
        return $this->fetch();
    }

    public function add()
    {
        // 渲染管理员添加界面
        return $this->fetch();
    }

    public function DoAdd()
    {
        // 获取前台提交过来的数据
        $data = Request::param();
        // 获取添加的时间
        $data['time'] = time();
        $username = $data['username'];
        // 使用用户名来查询数据库是否有对应的数据
        $res = UserModel::where('username', $username)->find();
        // 判断数据是否存在
        if ($res == true) {
            return ['res' => 0, 'msg' => '用户名已存在！'];
        }
        // 实例化模型
        $user = new UserModel();
        // 验证数据是否存入数据库
        if ($user->save($data)) {
            return ['res' => 1, 'msg' => '添加成功！'];
        } else {
            return ['res' => 0, 'msg' => '添加失败！'];
        }

    }

    public function edit()
    {
        // 获取前台提交过来的数据
        $userId = Request::param('id');
        // 通过用户id查询需要更新用户的所有数据
        $user = UserModel::get($userId);
        // 将数据赋值给模板
        $this->view->user = $user;

        // 渲染编辑页面
        return $this->fetch();
    }

    public function DoEdit()
    {
        // 获取前台提交过来的数据
        $data = Request::param();
        // 实例化模型
        $user = new UserModel();
        // 对数据库中的数据进行修改更新
        $res = $user->save([
            'username' => $data['username'],
            'time' => time(),
        ], ['id' => $data['id']]);
        if ($res) {
            return ['res' => 1, 'msg' => '修改成功！'];
        }
    }

    public function del()
    {
        // 获取需要删除管理员的id
        $userId = Request::param('id');
        // 实例化模型
        $user = new UserModel();
        // 进行删除并验证操作
        if ($user->destroy($userId)) {
            // 返回提示信息
            return['res'=>1,'msg'=>'删除成功！'];
        }
    }

}