@extends('backend::layout')

@section('title', '查看文章')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                    <p>
                        <a href="javascript:history.back(-1);" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
                    </p>
                </div>
            </div>
            <h4 class="text-black f-20">查看文章</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <tbody>
                    <tr>
                        <th scope="row">文章标题</th>
                        <td>{{ $article->title }}</td>
                    </tr>
                    <tr>
                        <th scope="row">副标题</th>
                        <td>{{ $article->subtitle }}</td>
                    </tr>
                    <tr>
                        <th scope="row">关键字</th>
                        <td>{{ $article->keywords }}</td>
                    </tr>
                    <tr>
                        <th scope="row">描述</th>
                        <td>{{ $article->description }}</td>
                    </tr>
                    <tr>
                        <th scope="row">作者</th>
                        <td>{{ $article->author }}</td>
                    </tr>
                    <tr>
                        <th scope="row">来源</th>
                        <td>{{ $article->source }}</td>
                    </tr>
                    <tr>
                        <th scope="row">封面</th>
                        <td>
                            @if(\App\Model\File::hasFile($article->thumb))
                                <div class="profile_pic">
                                    <img src="{{ \App\Model\File::getFileUrl($article->thumb) }}" class="img-circle profile_img">
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">内容</th>
                        <td>{!! $article->content !!}</td>
                    </tr>
                    <tr>
                        <th scope="row">排序</th>
                        <td>{{ $article->sort }}</td>
                    </tr>
                    <tr>
                        <th scope="row">查看数</th>
                        <td>
                            {{ $article->view }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">是否置顶</th>
                        <td>{{ $article->getTop() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Status') }}</th>
                        <td>{{ $article->getStatus() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Create Time') }}</th>
                        <td>{{ $article->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="row">{{ __('Update Time') }}</th>
                        <td>{{ $article->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop