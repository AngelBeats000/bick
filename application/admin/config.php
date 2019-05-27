<?php
# @Author: huang longpan
# @Date:   2019-02-02T15:50:54+08:00
# @Email:  2404099751@qq.com
# @Last modified by:   huang longpan
# @Last modified time: 2019-03-19T20:55:37+08:00



// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    'template'               => [

        // 模板后缀
        'view_suffix'  => 'htm',

    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__PUBLIC__'   => '/public',
        '__ROOT__'     => '/',
        // '__ADMIN__'    => 'http://140.143.18.201/public/static/admin',
        // '__IMG__'      => 'http://140.143.18.201/',
        '__ADMIN__'    => 'http://localhost/bick/public/static/admin',
        '__IMG__'      => 'http://localhost/bick/',
    ],
];
