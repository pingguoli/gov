<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 单页
 * Class Page
 * @package App\Model
 */
class Page extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'subtitle', 'keywords', 'description', 'author', 'source', 'content', 'status'];

    /**
     * 获取状态
     * @return string
     */
    public function getStatus()
    {
        $status = [
            0 => __('Close'),
            1 => __('Open'),
        ];

        return array_key_exists($this->status, $status) ? $status[$this->status] : '';
    }
}
