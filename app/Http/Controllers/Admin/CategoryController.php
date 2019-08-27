<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/28 13:56
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Category;
use App\Model\CategoryArticle;
use Illuminate\Http\Request;

/**
 * 分类管理
 * Class CategoryController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends BaseController
{
    /**
     * 分类列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list = Category::paginate(config('site.other.paginate'));
        return backendView('category.index', compact('list'));
    }

    /**
     * 新增分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name' => 'required|max:255',
            ], [], [
                'name' => '分类名称',
            ]);

            $data = $request->only(['name']);

            if (Category::create($data)) {
                return redirect()->route('admin.category.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            return backendView('category.add');
        }
    }

    /**
     * 编辑分类
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $category Category
         */
        $category = Category::find($id);
        if (empty($category)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name' => 'required|max:255',
            ], [], [
                'name' => '分类名称',
            ]);

            $data = $request->only(['name']);

            if ($category->update($data)) {
                return redirect()->route('admin.category.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            return backendView('category.edit', compact('category'));
        }
    }

    /**
     * 查看分类
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id = null)
    {
        /**
         * @var $category Category
         */
        $category = Category::find($id);
        if (empty($category)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        return backendView('category.view', compact('category'));
    }

    /**
     * 删除分类
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = null)
    {
        /**
         * @var $category Category
         */
        $category = Category::find($id);
        if (empty($category)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        try {
            $count = CategoryArticle::where('category_id', $category->id)->count();
            if ($count > 0) {
                return back()->with('error', '已使用的分类不能删除');
            }

            if ($category->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }
}