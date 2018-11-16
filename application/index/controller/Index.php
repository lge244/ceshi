<?php

namespace app\index\controller;
use app\admin\model\NewsModel;
use app\admin\model\ProductModel;
use app\admin\model\SlideModel;
use app\admin\model\SystemModel;
use think\Controller;
use think\facade\Request;

class Index extends Controller
{
    public function index()
    {
        // 查询轮播图
        $slide = new SlideModel();
        $slides = $slide->select()->toArray();
        $this->view->slides = $slides;

        // 查询头牌
        $product = new ProductModel();
        $products = $product->where('sort','1')->select()->toArray();
        $this->view->products = $products;
        // 查询新上花魁
        $NewProduct = $product->where('sort','2')->limit(1)->select()->toArray();
        $this->view->NewProduct = $NewProduct;

        // 查询最新资讯
        $new = new NewsModel();
        $news = $new->limit(4)->select()->toArray();
        $this->view->news=$news;

        // 渲染首页模板
        return $this->fetch();
    }

    public function about()
    {
        $system = new SystemModel();
        $systems = $system->select()->toArray();
        $this->view->systems = $systems;
        // 渲染首页模板
        return $this->fetch();
    }

    public function product()
    {
        $product = new ProductModel();
        $products = $product->order('id','desc')->paginate(4);
        $this->view->products=$products;
        // 渲染首页模板
        return $this->fetch();
    }

    public function news()
    {
        // 实例化模型
        $new = new NewsModel();
        // 查询数据按照id的顺序查询并且每页四条数据
        $news = $new->order('id','desc')->paginate(4);
        // 给模板继续赋值
        $this->view->news=$news;

        $hotNew = $new->limit(1)->select()->toArray();
        $this->view->hotNews = $hotNew;

        $newNews = $new->limit(6)->select()->toArray();
        $this->view->newNews=$newNews;
        // 渲染首页模板
        return $this->fetch();
    }

    public function ConNew()
    {
        $newId = Request::param('id');
        // 通过id查询对应的新闻详细
        $new = NewsModel::get($newId);
        $this->view->new= $new;

        $hotNew = $new->limit(1)->select()->toArray();
        $this->view->hotNews = $hotNew;

        $newNews = $new->limit(6)->select()->toArray();
        $this->view->newNews=$newNews;
        // 渲染首页模板
        return $this->fetch();
    }

    public function ConPro()
    {
        // 获取产品id
        $ProId = Request::param('id');
        $product = ProductModel::get($ProId);
        $this->view->product=$product;
        // 渲染首页模板
        return $this->fetch();
    }

}
