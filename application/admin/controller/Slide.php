<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27
 * Time: 16:50
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\SlideModel;
use think\facade\Request;
use think\facade\Session;

class slide extends Common
{
    public function index()
    {
        // 实例化模型
        $slide = new SlideModel();
        // 查询数据按照id排序并且每页四条数据
        $slides = $slide->order('id', 'desc')->paginate(4);
        // 将数据赋值到模型
        $this->view->slides = $slides;
        // 渲染模板
        return $this->fetch();
    }

    public function add()
    {
        // 渲染模板
        return $this->fetch();
    }

    public function upload()
    {
        // 获取上传图片的信息
        $file = Request::file('file');
        // 验证图片并移动到指定目录
        if ($info = $file->validate(['ext' => 'jpg,jpeg,png,gif'])->move('upload')) {
            // 拼接图片路径
            $fileName = '/upload/' . $info->getSaveName();
            // 返回上传成功的提示信息
            return json([1, '上传成功！', 'data' => $fileName]);
        } else {
            // 返回上传失败的错误信息
            return $file->getError();
        }
    }

    public function DoAdd()
    {
        // 获取提交过来的数据
        $data = Request::param();
        // 加入添加时间
        $data['time'] = time();
        // 加入添加管理员
        $data['username'] = Session::get('username');
        // 实例化模型
        $slide = new SlideModel();
        // 存储并验证
        if ($slide->save($data)) {
            // 返回对应信息
            return ['res' => 1, 'msg' => '添加成功！'];
        } else {
            return ['res' => 0, 'msg' => '添加失败！'];
        }
    }

    public function del()
    {
        // 获取需要删除的id
        $slideId = Request::param('id');
        // 实例化模型
        $slide = new SlideModel();
        // 删除并验证
        if ($slide->destroy($slideId)) {
            return ['res' => 1];
        }

    }
}