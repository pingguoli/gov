<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/**
 * 前端路由设置
 */

/* 多语言切换 */
Route::get('/locale/{locale}', 'LocaleController@lang')->name('locale');
/* 微信支付回调路由 */
Route::any('/wxpay/notify', 'WxPayController@notify')->name('wxpay.notify');

Route::group(['namespace' => 'Web', 'middleware' => ['locale']], function () {

    /* 首页 */
    Route::get('/', 'HomeController@index')->name('home');

    // 关于我们
    Route::get('/about', 'AboutController@index')->name('about');
    // 联系我们
    Route::get('/contact', 'ContactController@index')->name('contact');
    // 新闻列表
    Route::get('/news', 'NewsController@index')->name('news');
    // 新闻详情
    Route::get('/news/{id}', 'NewsController@detail')->name('news.detail');

    /* 登录 */
    Route::get('/login', 'LoginController@index')->name('login');
    Route::post('/login', 'LoginController@login');
    Route::post('/login/sms', 'LoginController@sendSms')->name('login.sms');
    Route::get('/logout', 'LoginController@logout')->name('logout');

    /* 注册 */
    Route::get('/register', 'RegisterController@first')->name('register');
    Route::post('/register', 'RegisterController@saveFirst');
    Route::get('/register/second/{key}', 'RegisterController@second')->name('register.second');
    Route::post('/register/second/{key}', 'RegisterController@saveSecond');
    Route::get('/register/third/{key}', 'RegisterController@third')->name('register.third');
    Route::post('/register/third/{key}', 'RegisterController@saveThird');
    Route::get('/register/last/{key}', 'RegisterController@last')->name('register.last');
    Route::post('/register/last/{key}', 'RegisterController@saveLast');
    Route::post('/register/process/{key}', 'RegisterController@preProcess')->name('register.process');
    Route::post('/register/uploading/{key}', 'RegisterController@saveChunk')->name('register.uploading');

    Route::post('/register/sms', 'RegisterController@sendSms')->name('register.sms');
    Route::post('/register/payment/{key}', 'RegisterController@payment')->name('register.payment');
    Route::post('/register/checkpay/{key}', 'RegisterController@checkPayment')->name('register.checkPayment');
    Route::post('/register/verify/{key}', 'RegisterController@verify')->name('register.verify');

    /* 忘记密码 */
    Route::get('/forget', 'ForgetPasswordController@index')->name('forget');
    Route::post('/forget', 'ForgetPasswordController@saveIndex');
    Route::get('/forget/change/{key}', 'ForgetPasswordController@change')->name('forget.change');
    Route::post('/forget/change/{key}', 'ForgetPasswordController@saveChange');
    Route::post('/forget/sms', 'ForgetPasswordController@sendSms')->name('forget.sms');

    /* 需要登录后看到的页面 */
    Route::group(['middleware' => ['auth']], function () {
        /* 个人中心主页 */
        Route::get('/member', 'MemberController@index')->name('member');
        /* 基本信息 */
        Route::get('/member/info', 'MemberController@info')->name('member.info');
        Route::post('/member/info', 'MemberController@changeInfo');
        /* 修改密码 */
        Route::get('/member/password', 'MemberController@password')->name('member.password');
        Route::post('/member/password', 'MemberController@changePassword');
        /* 账号绑定 */
        Route::get('/member/bind', 'MemberController@bind')->name('member.bind');
        /* 项目 */
        Route::get('/member/project', 'MemberController@project')->name('member.project');
        /* 我的消息 */
        Route::get('/member/message', 'MemberController@message')->name('member.message');

        /* 创建项目昵称(控制器验证项目不存在) */
        Route::get('/project/{code}/create', 'ProjectController@create')->name('project.create');
        Route::post('/project/{code}/create', 'ProjectController@saveCreate');

        /* 中间件验证项目是否已经创建昵称 */
        Route::group(['middleware' => ['has.project']], function () {
            /* 项目详细信息 */
            Route::get('/project/{code}', 'ProjectController@index')->name('project');
            /* 我的战队 */
            Route::get('/team/{code}', 'TeamController@index')->name('team');
            /* 创建战队 */
            Route::get('/team/{code}/create', 'TeamController@create')->name('team.create');
            Route::post('/team/{code}/create', 'TeamController@saveCreate');
            /* 解散战队 */
            Route::get('/team/{code}/disband', 'TeamController@disband')->name('team.disband');
            /* 战队邀请队员 */
            Route::get('/team/{code}/teaminvite', 'TeamController@teamInvite')->name('team.teaminvite');
            /* 发送邀请 */
            Route::get('/team/{code}/sendteaminvite/{id}', 'TeamController@sendTeamInvite')->name('team.sendteaminvite');
            /* 队员管理 */
            Route::get('/team/{code}/manage', 'TeamController@manage')->name('team.manage');
            /* 转让队长 */
            Route::post('/team/{code}/transfer/{id}', 'TeamController@transfer')->name('team.transfer');
            /* 踢人 */
            Route::post('/team/{code}/remove/{id}', 'TeamController@remove')->name('team.remove');
            /* 队员被战队邀请列表 */
            Route::get('/team/{code}/teamjoin', 'TeamController@teamJoin')->name('team.teamjoin');
            // 战队确认加入申请
            Route::post('/team/{code}/confirmteamjoin/{id}', 'TeamController@confirmTeamJoin')->name('team.confirmteamjoin');
            /* 加入战队 */
            Route::get('/team/{code}/join', 'TeamController@join')->name('team.join');
            /* 发送加入战队请求 */
            Route::get('/team/{code}/sendjoin/{id}', 'TeamController@sendJoin')->name('team.sendjoin');
            /* 队员被战队邀请列表 */
            Route::get('/team/{code}/invite', 'TeamController@invite')->name('team.invite');
            /* 队员被战队邀请确认 */
            Route::post('/team/{code}/confirminvite/{id}', 'TeamController@confirmInvite')->name('team.confirminvite');
        });
    });
});


/**
 * 引入后台路由
 */
if (file_exists(__DIR__ . '/admin/web.php')) {
    include_once __DIR__ . '/admin/web.php';
}
