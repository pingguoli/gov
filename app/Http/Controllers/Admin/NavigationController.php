<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/29 9:18
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Category;
use App\Model\Navigation;
use App\Model\Page;
use Illuminate\Http\Request;

/**
 * 导航管理
 * Class NavigationController
 * @package App\Http\Controllers\Admin
 */
class NavigationController extends BaseController
{
    /**
     * 导航列表
     * @param null|string $position
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($position = null)
    {
        $positionCode = Navigation::getPositionCode($position);
        $list = Navigation::getTreeInfo(['position' => $positionCode]);
        return backendView('navigation.index', compact('list', 'positionCode'));
    }

    /**
     * 新增导航
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'parent_id' => 'nullable|numeric',
                'name' => 'required|max:50',
                'position' => 'required|numeric',
                'type' => 'required|numeric',
                'sort' => 'integer|min:0|max:999',
            ], [], [
                'parent_id' => '上级导航',
                'name' => '名称',
                'position' => '导航位置',
                'type' => '类型',
                'sort' => '排序',
            ]);

            $data = $request->only(['parent_id', 'name', 'position', 'type', 'target', 'link', 'category_id', 'page_id', 'article_id', 'is_show', 'sort']);
            if (!array_key_exists($data['type'], Navigation::$types)) {
                return back()->withErrors(['type' => '类型不存在'])->withInput();
            }
            switch ($data['type']) {
                case Navigation::TYPE_LINK:
                    if (empty($data['link'])) {
                        return back()->withErrors(['link' => '链接必须填写'])->withInput();
                    }
                    $data['category_id'] = 0;
                    $data['page_id'] = 0;
                    $data['article_id'] = 0;
                    break;
                case Navigation::TYPE_CATEGORY:
                    if (empty($data['category_id'])) {
                        return back()->withErrors(['link' => '分类必须填写'])->withInput();
                    }
                    $data['link'] = '';
                    $data['page_id'] = 0;
                    $data['article_id'] = 0;
                    break;
                case Navigation::TYPE_PAGE:
                    if (empty($data['page_id'])) {
                        return back()->withErrors(['page_id' => '单页必须填写'])->withInput();
                    }
                    $data['link'] = '';
                    $data['category_id'] = 0;
                    $data['article_id'] = 0;
                    break;
                case Navigation::TYPE_ARTICLE:
                    if (empty($data['article_id'])) {
                        return back()->withErrors(['article_id' => '文章必须填写'])->withInput();
                    }
                    $data['link'] = '';
                    $data['category_id'] = 0;
                    $data['page_id'] = 0;
                    break;
                default:
                    return back()->withErrors(['type' => '类型不存在'])->withInput();
                    break;
            }

            if (Navigation::create($data)) {
                return redirect()->route('admin.navigation.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            $position = old('position') ?: Navigation::POSITION_DEFAULT;
            $navigationOptions = Navigation::getOptions($position);
            $categories = Category::get();
            $pages = Page::get();
            return backendView('navigation.add', compact('navigationOptions', 'categories', 'pages'));
        }
    }

    /**
     * 编辑导航
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $navigation Navigation
         */
        $navigation = Navigation::find($id);
        if (empty($navigation)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'parent_id' => 'nullable|numeric',
                'name' => 'required|max:50',
                'position' => 'required|numeric',
                'type' => 'required|numeric',
                'sort' => 'integer|min:0|max:999',
            ], [], [
                'parent_id' => '上级导航',
                'name' => '名称',
                'position' => '导航位置',
                'type' => '类型',
                'sort' => '排序',
            ]);

            $data = $request->only(['parent_id', 'name', 'position', 'type', 'target', 'link', 'category_id', 'page_id', 'article_id', 'is_show', 'sort']);
            if (!array_key_exists($data['type'], Navigation::$types)) {
                return back()->withErrors(['type' => '类型不存在'])->withInput();
            }
            switch ($data['type']) {
                case Navigation::TYPE_LINK:
                    if (empty($data['link'])) {
                        return back()->withErrors(['link' => '链接必须填写'])->withInput();
                    }
                    $data['category_id'] = 0;
                    $data['page_id'] = 0;
                    $data['article_id'] = 0;
                    break;
                case Navigation::TYPE_CATEGORY:
                    if (empty($data['category_id'])) {
                        return back()->withErrors(['category_id' => '分类必须填写'])->withInput();
                    }
                    $data['link'] = '';
                    $data['page_id'] = 0;
                    $data['article_id'] = 0;
                    break;
                case Navigation::TYPE_PAGE:
                    if (empty($data['page_id'])) {
                        return back()->withErrors(['page_id' => '单页必须填写'])->withInput();
                    }
                    $data['link'] = '';
                    $data['category_id'] = 0;
                    $data['article_id'] = 0;
                    break;
                case Navigation::TYPE_ARTICLE:
                    if (empty($data['article_id'])) {
                        return back()->withErrors(['article_id' => '文章必须填写'])->withInput();
                    }
                    $data['link'] = '';
                    $data['category_id'] = 0;
                    $data['page_id'] = 0;
                    break;
                default:
                    return back()->withErrors(['type' => '类型不存在'])->withInput();
                    break;
            }

            if ($navigation->update($data)) {
                return redirect()->route('admin.navigation.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $position = old('position') ?: $navigation->position;
            $navigationOptions = Navigation::getOptions($position, $navigation);
            $categories = Category::get();
            $pages = Page::get();
            return backendView('navigation.edit', compact('navigation', 'navigationOptions', 'categories', 'pages'));
        }
    }

    /**
     * 查看导航
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id = null)
    {
        /**
         * @var $navigation Navigation
         */
        $navigation = Navigation::find($id);
        if (empty($navigation)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        return backendView('navigation.view', compact('navigation'));
    }

    /**
     * 删除导航
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = null)
    {
        /**
         * @var $navigation Navigation
         */
        $navigation = Navigation::find($id);
        if (empty($navigation)) {
            return back()->with('error', __('The page you requested was not found'));
        }

        try {
            $count = Navigation::where('parent_id', $navigation->id)->count();
            if ($count > 0) {
                return back()->with('error', '包含子导航不能删除');
            }

            if ($navigation->delete()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }

    /**
     * 获取上级导航
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParent(Request $request)
    {
        $json = [
            'status' => 200,
            'message' => '',
            'errors' => [],
            'lists' => []
        ];
        if (!$this->auth('navigation/add') && !$this->auth('navigation/edit')) {
            $json['status'] = 489;
            $json['message']['type'] = __('No authority');
            return response()->json($json);
        }

        $position = $request->input('position');
        $id = $request->input('id');
        $navigation = null;
        if (!empty($id)) {
            $navigation = Navigation::find($id);
        }

        $navigationOptions = Navigation::getOptions($position, $navigation);

        $lists = [];
        foreach ($navigationOptions as $item) {
            $lists[] = [
                'id' => $item->id,
                'name' => $item->name
            ];
        }
        $json['lists'] = $lists;

        return response()->json($json);
    }
}