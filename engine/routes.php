<?php

$config['routes'] = [
    // admin routes
    'AdminController:indexAction' => [
        'path' => '/admin/',
        'action' => '\AdminController:indexAction',
        'inMenu' => 'admin',
        'menuTitle' => '管理系统首页',
        'needAuth' => true
    ],
    'AdminController:systemAction' => [
        'path' => '/admin/system/',
        'action' => '\AdminController:systemAction',
        'inMenu' => 'admin',
        'menuTitle' => '网站系统设置',
        'needAuth' => true
    ],
    'AdminController:categoriesAction' => [
        'path' => '/admin/categories/[page-{page}/]',
        'action' => '\AdminController:categoriesAction',
        'inMenu' => 'admin',
        'menuTitle' => '模块设置',
        'needAuth' => true
    ],
    'AdminController:categoryAction' => [
        'path' => '/admin/category/[{id}/]',
        'action' => '\AdminController:categoryAction',
        'needAuth' => true
    ],
    'AdminController:articlesAction' => [
        'path' => '/admin/articles/[page-{page}/]',
        'action' => '\AdminController:articlesAction',
        'inMenu' => 'admin',
        'menuTitle' => '文章列表',
        'needAuth' => true
    ],
    'AdminController:articleAction' => [
        'path' => '/admin/article/[{id}/]',
        'action' => '\AdminController:articleAction',
        'needAuth' => true
    ],
    'AdminController:uploadAction' => [
        'path' => '/admin/upload/[{id}/]',
        'action' => '\AdminController:uploadAction',
        'needAuth' => true
    ],


    // front routes
    'MainController:aboutsAction' => [
        'method' => 'GET',
        'path' => '/abouts/',
        'action' => '\MainController:aboutsAction'
    ],
    'MainController:categoryAction' => [
        'method' => 'GET',
        'path' => '/{id}/[page-{page}/]',
        'action' => '\MainController:categoryAction'
    ],
    'MainController:articleAction' => [
        'method' => 'GET',
        'path' => '/{module}/{id}.html',
        'action' => '\MainController:articleAction'
    ],
    'MainController:indexAction' => [
        'method' => 'GET',
        'path' => '/[index]',
        'action' => '\MainController:indexAction'
    ],
    'MainController:errorAction' => [
        'method' => 'GET',
        'path' => '/{error}',
        'action' => '\MainController:indexAction'
    ],
];