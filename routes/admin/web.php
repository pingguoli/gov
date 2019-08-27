<?php

use Illuminate\Support\Facades\Route;

/**
 * 后台路由设置
 */

Route::group(['prefix' => config('admin.prefix'), 'namespace' => 'Admin', 'middleware' => ['locale']], function () {


    /* 后台登录页 */
    Route::get('/login', 'LoginController@index')->name('admin.login');
    Route::post('/login', 'LoginController@login');

    // 后台普通文件上传
    Route::post('/upload', 'CommonController@upload')->name('admin.upload');
    /* 后台分片上传文件 */
    Route::post('/process', 'CommonController@preProcess')->name('admin.process');
    Route::post('/uploading', 'CommonController@saveChunk')->name('admin.uploading');

    /* 需要登录验证地址 */
    Route::group(['middleware' => ['admin.auth', 'admin.menu']], function () {

        /* 退出登录 */
        Route::get('/logout', 'LoginController@logout')->name('admin.logout');
        /* 后台首页 */
        Route::get('/', 'HomeController@index')->name('admin.index');

        /* 个人中心 */
        Route::get('/profile/index', 'ProfileController@index')->name('admin.profile');
        Route::get('/profile/edit', 'ProfileController@edit')->name('admin.profile.edit');
        Route::post('/profile/edit', 'ProfileController@edit');

        /* 密码修改 */
        Route::get('/profile/password', 'ProfileController@password')->name('admin.profile.password');
        Route::post('/profile/password', 'ProfileController@password');

        /* 系统设置 */
        /* 系统设置 */
        Route::get('/setting/app', 'SettingController@app')->name('admin.setting.app');
        Route::post('/setting/app', 'SettingController@app');
        /* 站点设置 */
        Route::get('/setting/site', 'SettingController@site')->name('admin.setting.site');
        Route::post('/setting/site', 'SettingController@site');
        /* 登录设置 */
        Route::get('/setting/register', 'SettingController@register')->name('admin.setting.register');
        Route::post('/setting/register', 'SettingController@register');


        /* 权限设置 */
        /* 管理员管理 */
        Route::get('/manager/index', 'ManagerController@index')->name('admin.manager.index');
        Route::get('/manager/add', 'ManagerController@add')->name('admin.manager.add');
        Route::post('/manager/add', 'ManagerController@add');
        Route::get('/manager/edit/{id}', 'ManagerController@edit')->name('admin.manager.edit');
        Route::post('/manager/edit/{id}', 'ManagerController@edit');
        Route::get('/manager/delete/{id}', 'ManagerController@delete')->name('admin.manager.delete');
        Route::get('/manager/view/{id}', 'ManagerController@view')->name('admin.manager.view');

        Route::post('/manager/role', 'ManagerController@role')->name('admin.manager.role');

        /* 角色管理 */
        Route::get('/role/index', 'RoleController@index')->name('admin.role.index');
        Route::get('/role/add', 'RoleController@add')->name('admin.role.add');
        Route::post('/role/add', 'RoleController@add');
        Route::get('/role/edit/{id}', 'RoleController@edit')->name('admin.role.edit');
        Route::post('/role/edit/{id}', 'RoleController@edit');
        Route::get('/role/delete/{id}', 'RoleController@delete')->name('admin.role.delete');
        Route::get('/role/view/{id}', 'RoleController@view')->name('admin.role.view');
        Route::get('/role/permission/{id}', 'RoleController@permission')->name('admin.role.permission');
        Route::post('/role/permission/{id}', 'RoleController@permission');

        /* 菜单管理 */
        Route::get('/menu/index', 'MenuController@index')->name('admin.menu.index');
        Route::get('/menu/add', 'MenuController@add')->name('admin.menu.add');
        Route::post('/menu/add', 'MenuController@add');
        Route::get('/menu/edit/{id}', 'MenuController@edit')->name('admin.menu.edit');
        Route::post('/menu/edit/{id}', 'MenuController@edit');
        Route::get('/menu/delete/{id}', 'MenuController@delete')->name('admin.menu.delete');
        Route::get('/menu/view/{id}', 'MenuController@view')->name('admin.menu.view');

        /* 审核设置 */
        Route::get('/verify/index', 'VerifyController@index')->name('admin.verify.index');
        Route::get('/verify/add', 'VerifyController@add')->name('admin.verify.add');
        Route::post('/verify/add', 'VerifyController@add');
        Route::get('/verify/edit/{id}', 'VerifyController@edit')->name('admin.verify.edit');
        Route::post('/verify/edit/{id}', 'VerifyController@edit');
        Route::post('/verify/managers', 'VerifyController@manager')->name('admin.verify.manager');

        /* 运动员管理 */
        Route::get('/user/index', 'UserController@index')->name('admin.user.index');
        Route::get('/user/edit/{id}', 'UserController@edit')->name('admin.user.edit');
        Route::post('/user/edit/{id}', 'UserController@edit');
        Route::post('/user/check/{id}', 'UserController@check')->name('admin.user.check');
        Route::get('/user/view/{id}', 'UserController@view')->name('admin.user.view');
        Route::get('/user/history/{id}', 'UserController@history')->name('admin.user.history');
        Route::get('/user/detail/{id}', 'UserController@detail')->name('admin.user.detail');

        /* 导航管理 */
        Route::get('/navigation/index/{position?}', 'NavigationController@index')->name('admin.navigation.index');
        Route::get('/navigation/add', 'NavigationController@add')->name('admin.navigation.add');
        Route::post('/navigation/add', 'NavigationController@add');
        Route::get('/navigation/edit/{id}', 'NavigationController@edit')->name('admin.navigation.edit');
        Route::post('/navigation/edit/{id}', 'NavigationController@edit');
        Route::get('/navigation/delete/{id}', 'NavigationController@delete')->name('admin.navigation.delete');
        Route::get('/navigation/view/{id}', 'NavigationController@view')->name('admin.navigation.view');
        Route::post('/navigation/parent', 'NavigationController@getParent')->name('admin.navigation.parent');

        /* 分类管理 */
        Route::get('/category/index', 'CategoryController@index')->name('admin.category.index');
        Route::get('/category/add', 'CategoryController@add')->name('admin.category.add');
        Route::post('/category/add', 'CategoryController@add');
        Route::get('/category/edit/{id}', 'CategoryController@edit')->name('admin.category.edit');
        Route::post('/category/edit/{id}', 'CategoryController@edit');
        Route::get('/category/delete/{id}', 'CategoryController@delete')->name('admin.category.delete');
        Route::get('/category/view/{id}', 'CategoryController@view')->name('admin.category.view');

        /* 文章管理 */
        Route::get('/article/index', 'ArticleController@index')->name('admin.article.index');
        Route::get('/article/add', 'ArticleController@add')->name('admin.article.add');
        Route::post('/article/add', 'ArticleController@add');
        Route::get('/article/edit/{id}', 'ArticleController@edit')->name('admin.article.edit');
        Route::post('/article/edit/{id}', 'ArticleController@edit');
        Route::get('/article/delete/{id}', 'ArticleController@delete')->name('admin.article.delete');
        Route::get('/article/view/{id}', 'ArticleController@view')->name('admin.article.view');

        /* 单页管理 */
        Route::get('/page/index', 'PageController@index')->name('admin.page.index');
        Route::get('/page/add', 'PageController@add')->name('admin.page.add');
        Route::post('/page/add', 'PageController@add');
        Route::get('/page/edit/{id}', 'PageController@edit')->name('admin.page.edit');
        Route::post('/page/edit/{id}', 'PageController@edit');
        Route::get('/page/delete/{id}', 'PageController@delete')->name('admin.page.delete');
        Route::get('/page/view/{id}', 'PageController@view')->name('admin.page.view');

        /* 项目类型管理 */
        Route::get('/projecttype/index', 'ProjectTypeController@index')->name('admin.project_type.index');
        Route::get('/projecttype/add', 'ProjectTypeController@add')->name('admin.project_type.add');
        Route::post('/projecttype/add', 'ProjectTypeController@add');
        Route::get('/projecttype/edit/{id}', 'ProjectTypeController@edit')->name('admin.project_type.edit');
        Route::post('/projecttype/edit/{id}', 'ProjectTypeController@edit');
        Route::get('/projecttype/delete/{id}', 'ProjectTypeController@delete')->name('admin.project_type.delete');

        /* 项目管理 */
        Route::get('/project/index', 'ProjectController@index')->name('admin.project.index');
        Route::get('/project/add', 'ProjectController@add')->name('admin.project.add');
        Route::post('/project/add', 'ProjectController@add');
        Route::get('/project/edit/{id}', 'ProjectController@edit')->name('admin.project.edit');
        Route::post('/project/edit/{id}', 'ProjectController@edit');

        /* 战队管理 */
        Route::get('/team/index', 'TeamController@index')->name('admin.team.index');
        Route::get('/team/verify/{id}', 'TeamController@verify')->name('admin.team.verify');
        Route::post('/team/verify/{id}', 'TeamController@verify');
        Route::get('/team/view/{id}', 'TeamController@view')->name('admin.team.view');
    });
});