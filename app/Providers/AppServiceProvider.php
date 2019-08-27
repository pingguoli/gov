<?php

namespace App\Providers;

use App\Model\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* mysql 低于5.7去掉错误 执行migrate 时打开 */
//        Schema::defaultStringLength(191);

        /* 加载系统配置 */
        Setting::loadSetting();

        /* 设置多语言 */
        $this->app->setLocale(config('app.locale'));

        // 注册模板变量
        // 默认模板路径
        $defaultTheme = 'default';
        // 前台模板路径
        $frontendTheme = (isMobile() ? config('site.theme.mobile') : config('site.theme.web')) ?: $defaultTheme;
        $this->loadViewsFrom(resource_path('views/frontend/' . $frontendTheme), 'frontend');

        // 后台模板路径
        $backendTheme = config('site.theme.backend') ?: $defaultTheme;
        $this->loadViewsFrom(resource_path('views/backend/' . $backendTheme), 'backend');

        // 验证
        $this->_validate();

        // 打印SQL日志
        $this->_sqlLog();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * 验证
     */
    private function _validate()
    {
        // 添加自定义验证规则,必须完全是字母的字符。
        Validator::extend('only_alpha', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[a-zA-Z]+$/u', $value);
        });

        // 添加自定义验证规则,可能具有字母、数字、破折号（ - ）以及下划线（ _ ）。
        Validator::extend('only_alpha_dash', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[a-zA-Z0-9_-]+$/u', $value);
        });

        // 添加自定义验证规则,必须完全是字母、数字。
        Validator::extend('only_alpha_num', function ($attribute, $value, $parameters, $validator) {
            return is_string($value) && preg_match('/^[a-zA-Z0-9]+$/u', $value);
        });
    }

    /**
     * SQL日志
     */
    private function _sqlLog()
    {
        if (config('app.debug') && config('site.sql_log')) {
            DB::listen(
                function ($sql) {
                    foreach ($sql->bindings as $i => $binding) {
                        if ($binding instanceof \DateTime) {
                            $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                        } else {
                            if (is_string($binding)) {
                                $sql->bindings[$i] = "'$binding'";
                            }
                        }
                    }

                    // Insert bindings into query
                    $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);

                    $query = vsprintf($query, $sql->bindings);

                    // Save the query to file
                    $logFile = fopen(
                        storage_path('logs' . DIRECTORY_SEPARATOR . 'sql_' . date('Y-m-d') . '.log'),
                        'a+'
                    );
                    fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $query . PHP_EOL);
                    fclose($logFile);
                }
            );
        }
    }
}
