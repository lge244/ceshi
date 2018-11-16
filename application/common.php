<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function GetTitle($news_id)
{
    return Db::connect('qiyewang')->table('news')->where('id', $news_id)->value('title');
}

function GetProTitle($product_id)
{
    return Db::connect('qiyewang')->table('product')->where('id', $product_id)->value('title');
}

function GetSortTitle($sort)
{
    return Db::connect('qiyewang')->table('sort')->where('id', $sort)->value('title');
}

function GetNewsPic($news_id)
{
    return Db::connect('qiyewang')->table('news_pic')->where('news_id', $news_id)->value('pic');
}

function GetProPic($product_id)
{
    return Db::connect('qiyewang')->table('product_pic')->where('product_id', $product_id)->value('pic');
}