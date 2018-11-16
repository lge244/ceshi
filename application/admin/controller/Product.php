<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/23
 * Time: 10:44
 */

namespace app\admin\controller;

use app\admin\controller\Common;
use app\admin\model\ProductModel;
use app\admin\model\SortModel;
use think\facade\Request;
use think\facade\Session;

class Product extends Common
{
    public function index()
    {
        // 实例化模型
        $product = new ProductModel();
        // 查询数据并按照id进行排序每页八条数据
        $products = $product->order('id', 'desc')->paginate(8);
        // 将数据赋值给模板
        $this->view->products = $products;
        // 渲染产品列表
        return $this->fetch();
    }

    public function add()
    {
        // 实例化并查询分类
        $sorts = SortModel::all();
        // 将数据赋值到模板
        $this->view->sorts = $sorts;
        //渲染产品添加界面
        return $this->fetch();
    }

    public function upload()
    {
        // 获取上传图片信息
        $file = Request::file('img');
        // 验证图片信息并移动到指定目录
        if ($info = $file->validate(['ext' => 'jpg,jpeg,png,gif'])->move('upload')) {
            // 返回成功的提示信息
            return json(['errno' => 0, 'data' => ['/upload/' . $info->getSaveName()]]);
        } else {
            // 返回失败的提示信息
            return $file->getError();
        }
    }


    public function DoAdd()
    {
        // 获取提交出来的数据
        $data = Request::param();
        // 将产品名独立出来
        $title = $data['title'];
        // 利用产品名作为查询条件查询对应的数据
        $info = ProductModel::where('title', $title)->find();
        // 判断是否查询到相同的产品名称
        if ($info == true) {
            // 返回提示信息
            return ['res' => 0, 'msg' => '产品标题重复！'];
        }
        // 加入添加时间
        $data['time'] = time();
        // 添加发布管理员
        $data['username'] = Session::get('username');
        // 实例化模型
        $product = new ProductModel();
        // 进行添加并验证
        if ($product->save($data)) {
            // 返回提示信息
            return ['res' => 1, 'msg' => '发布成功！'];
        } else {
            // 返回提示信息
            return ['res' => 0, 'msg' => '发布失败！'];
        }
    }

    public function edit()
    {
        $proId = Request::param('id');
        $product = ProductModel::get($proId);
        $this->view->product = $product;
        // 渲染产品修改界面
        return $this->fetch();
    }

    public function DoEdit()
    {
        // 获取提交过来的数据
        $data = Request::param();
        $product = new ProductModel();
        $data['time'] = time();
        $data['username'] = Session::get('username');
        $info = $product->save([
            'title' => $data['title'],
            'desc' => $data['desc'],
            'content' => $data['content'],
            'once' => $data['once'],
            'over_night' => $data['over_night'],
            'time' => $data['time'],
            'username' => $data['username'],
        ], ['id' => $data['id']]);
        if ($info) {
            return ['res' => 1, 'msg' => '更新成功！'];
        } else {
            return ['res' => 0, 'msg' => '更新失败！'];
        }
    }

    public function del()
    {
        // 获取需要删除的产品id
        $proId = Request::param('id');
        $product = new ProductModel();
        if ($product->destroy($proId)) {
            return ['res'=>1,'msg'=>'删除成功！'];
        }
    }
}