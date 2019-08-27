<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/28 17:22
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Page;
use Illuminate\Http\Request;

/**
 * 单页管理
 * Class PageController
 * @package App\Http\Controllers\Admin
 */
class PageController extends BaseController
{
    /**
     * 单页列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list = Page::paginate(config('site.other.paginate'));
        return backendView('page.index', compact('list'));
    }

    /**
     * 新增单页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'title' => 'required|max:255',
                'subtitle' => 'required|max:255',
                'keywords' => 'nullable|max:255',
                'description' => 'nullable|max:255',
                'content' => 'required',
                'author' => 'nullable|max:255',
                'resource' => 'nullable|max:255',
            ], [], [
                'title' => '标题',
                'subtitle' => '副标题',
                'keywords' => '关键字',
                'description' => '描述',
                'content' => '内容',
                'author' => '作者',
                'resource' => '来源',
            ]);

            $data = $request->only(['title', 'subtitle', 'keywords', 'description', 'content', 'author', 'resource', 'status']);

            if (Page::create($data)) {
                return redirect()->route('admin.page.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            return backendView('page.add');
        }
    }

    /**
     * 编辑单页
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $page Page
         */
        $page = Page::find($id);
        if (empty($page)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'title' => 'required|max:255',
                'subtitle' => 'required|max:255',
                'keywords' => 'nullable|max:255',
                'description' => 'nullable|max:255',
                'content' => 'required',
                'author' => 'nullable|max:255',
                'resource' => 'nullable|max:255',
            ], [], [
                'title' => '标题',
                'subtitle' => '副标题',
                'keywords' => '关键字',
                'description' => '描述',
                'content' => '内容',
                'author' => '作者',
                'resource' => '来源',
            ]);

            $data = $request->only(['title', 'subtitle', 'keywords', 'description', 'content', 'author', 'resource', 'status']);

            if ($page->update($data)) {
                return redirect()->route('admin.page.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            return backendView('page.edit', compact('page'));
        }
    }

    /**
     * 查看单页
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id = null)
    {
        /**
         * @var $page Page
         */
        $page = Page::find($id);
        if (empty($page)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        return backendView('page.view', compact('page'));
    }

    /**
     * 删除单页
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = null)
    {
        /**
         * @var $page Page
         */
        $page = Page::find($id);
        if (empty($page)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        try {

            if ($page->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }
}