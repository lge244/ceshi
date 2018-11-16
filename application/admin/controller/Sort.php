<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/26
 * Time: 10:15
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\SortModel;
use think\facade\Request;
use think\facade\Session;

class Sort extends Common
{
    public function index()
    {
        // 实例化模型
        $sort = new SortModel();
        // 查询数据并按照id的顺序每页八条数据
        $sorts = $sort->order('id', 'desc')->paginate(8);
        // 蒋数据赋值给模板
        $this->view->sorts = $sorts;
        // 渲染分类列表
        return $this->fetch();
    }

    public function DoAdd()
    {
        // 获取提交过来的数据
        $data = Request::param();
        // 获取添加数据
        $data['time'] = time();
        // 获取发布管理员
        $data['username'] = Session::get('username');
        // 实例化模型
        $sort = new SortModel();
        // 存储并验证
        if ($sort->save($data)) {
            // 返回对应信息
            return ['res' => 1, 'msg' => '添加成功！'];
        } else {
            return ['res' => 0, 'msg' => '添加失败！'];
        }
    }

    public function edit()
    {
        // 获取需要修改的分类id
        $sortId = Request::param('id');
        // 使用分类的id查询对应的数据
        $sort = SortModel::get($sortId);
        // 将数据赋值给模板
        $this->view->sort = $sort;
        // 渲染修改界面
        return $this->fetch();
    }

    public function DoEdit()
    {
        // 获取提交数据
        $data = Request::param();
        // 实例化模型
        $sort = new SortModel();
        // 修改更新操作
        $info = $sort->save([
            'title' => $data['title'],
            'time' => time(),
            'username' => Session::get('username'),
        ], ['id' => $data['id']]);
        // 验证修改结果
        if ($info) {
            // 返回对应值
            return ['res' => 1, 'msg' => '修改成功！'];
        } else {
            return ['res' => 0, 'msg' => '修改失败！'];
        }
    }

    public function del()
    {
        // 获取需要删除的分类id
        $sortId = Request::param('id');
        // 实例化模型
        $sort = new SortModel();
        // 删除并验证
        if ($sort->destroy($sortId)) {
            return ['res'=>1,'msg'=>'删除成功！'];
        }

    }
}