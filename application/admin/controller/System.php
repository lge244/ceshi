<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/27
 * Time: 10:23
 */

namespace app\admin\controller;

use app\admin\model\SystemModel;
use think\facade\Request;
use app\admin\controller\Common;

class System extends Common
{
    public function index()
    {
        // 通过id为1来获取网站需要修改的信息
        $data = SystemModel::get(1);
        // 将数据赋值到模板
        $this->view->system = $data;
        // 渲染系统设置模板
        return $this->fetch();
    }

    public function DoEdit()
    {
        // 获取提交的数据
        $data = Request::param();
        // 实例化模型
        $system = new SystemModel();
        $info = $system->save([
            'site_name' => $data['site_name'],
            'about_title' => $data['about_title'],
            'about_content' => $data['about_content'],
            'ci_title' => $data['ci_title'],
            'ci_content' => $data['ci_content'],
            'cp_title' => $data['cp_title'],
            'cp_content' => $data['cp_content'],
        ], ['id' => 1]);
        if ($info) {
            return ['res' => 1, 'msg' => '保存成功！'];
        } else {
            return ['res' => 0, 'msg' => '保存失败！'];
        }
    }
}