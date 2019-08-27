<?php
/**
 * @author    Silence <270377596@qq.com>
 * @date      2019/3/28 14:12
 * @copyright Copyright 2018 - 2019
 * @link      https://www.minicoding.cn
 * @git       https://gitee.com/minicoding
 * @version   1.0
 */

namespace App\Http\Controllers\Admin;


use App\Model\Article;
use App\Model\Category;
use App\Support\ChunkUpload;
use Illuminate\Http\Request;

/**
 * 文章管理
 * Class ArticleController
 * @package App\Http\Controllers\Admin
 */
class ArticleController extends BaseController
{
    /**
     * 文章列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $list = Article::paginate(config('site.other.paginate'));
        return backendView('article.index', compact('list'));
    }

    /**
     * 新增文章
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
                'thumb' => 'image',
                'content' => 'required',
                'author' => 'nullable|max:255',
                'resource' => 'nullable|max:255',
                'sort' => 'nullable|numeric',
            ], [], [
                'title' => '标题',
                'subtitle' => '副标题',
                'keywords' => '关键字',
                'description' => '描述',
                'thumb' => '封面',
                'content' => '内容',
                'author' => '作者',
                'resource' => '来源',
                'sort' => '排序',
            ]);

            $data = $request->only(['categories', 'title', 'subtitle', 'keywords', 'description', 'content', 'author', 'resource', 'sort', 'top', 'status']);
            if (!is_numeric($data['sort'])) {
                $data['sort'] = 0;
            }
            if (!is_numeric($data['top'])) {
                $data['top'] = 0;
            }
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $uploader = new ChunkUpload();
                $filePath = $uploader->setType('image')->upload($file);
                if ($filePath === false) {
                    return back()->withErrors(['thumb' => '封面上传失败'])->withInput();
                }
                $data['thumb'] = $filePath;
            }

            if (Article::add($data)) {
                return redirect()->route('admin.article.index')->with('success', __('Create success'));
            }

            return back()->with('error', __('Create failed'))->withInput();
        } else {
            $categories = Category::get();
            return backendView('article.add', compact('categories'));
        }
    }

    /**
     * 编辑文章
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Request $request, $id = null)
    {
        /**
         * @var $article Article
         */
        $article = Article::find($id);
        if (empty($article)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'title' => 'required|max:255',
                'subtitle' => 'required|max:255',
                'keywords' => 'nullable|max:255',
                'description' => 'nullable|max:255',
                'thumb' => 'image',
                'content' => 'required',
                'author' => 'nullable|max:255',
                'resource' => 'nullable|max:255',
                'sort' => 'nullable|numeric',
            ], [], [
                'title' => '标题',
                'subtitle' => '副标题',
                'keywords' => '关键字',
                'description' => '描述',
                'thumb' => '封面',
                'content' => '内容',
                'author' => '作者',
                'resource' => '来源',
                'sort' => '排序',
            ]);

            $data = $request->only(['categories', 'title', 'subtitle', 'keywords', 'description', 'content', 'author', 'resource', 'sort', 'top', 'status']);
            if (!is_numeric($data['sort'])) {
                $data['sort'] = 0;
            }
            if (!is_numeric($data['top'])) {
                $data['top'] = 0;
            }
            if ($request->hasFile('thumb')) {
                $file = $request->file('thumb');
                $uploader = new ChunkUpload();
                $filePath = $uploader->setType('image')->upload($file);
                if ($filePath === false) {
                    return back()->withErrors(['thumb' => '封面上传失败'])->withInput();
                }
                $data['thumb'] = $filePath;
            }

            if ($article->edit($data)) {
                return redirect()->route('admin.article.index')->with('success', __('Edit success'));
            }

            return back()->with('error', __('Edit failed'))->withInput();

        } else {
            $categories = Category::get();
            return backendView('article.edit', compact('categories', 'article'));
        }
    }

    /**
     * 查看文章
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id = null)
    {
        /**
         * @var $article Article
         */
        $article = Article::find($id);
        if (empty($article)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        return backendView('article.view', compact('article'));
    }

    /**
     * 删除文章
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id = null)
    {
        /**
         * @var $article Article
         */
        $article = Article::find($id);
        if (empty($article)) {
            return back()->with('error', __('The page you requested was not found'))->withInput();
        }

        try {

            if ($article->remove()) {
                return back()->with('success', __('Delete success'));
            }
        } catch (\Exception $e) {

        }

        return back()->with('error', __('Delete failed'));
    }
}