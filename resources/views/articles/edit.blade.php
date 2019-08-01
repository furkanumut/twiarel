@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Popular Articles') }}</div>
                    <div class="card-body">
                        <ul class="list-inline">
                            
                            @foreach ($populararticles  as $articleInfo)
                                <li>
                                    <a href="{{ route('article.detail',$articleInfo->id) }}">{{ $articleInfo->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="card-header">{{ __('Add New Article') }}
                        <a href="{{ route('article.index')}}" class="btn btn-danger btn-sm float-sm-right"> {{ __('All Articles') }} </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('article.update',$article->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">{{__('Image Upload')}}</label><br>
                            <input type="file" name="image" class=" @error('image') is-invalid @enderror"><br>
                            <small>{{__('*If you do not upload an image, you will use the old image.')}}</small>
                            @error('image')
                                <div class="alert alert-danger">{{ __($message) }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="title">{{ __('Article Title') }}</label>
                            <input required type="text" value="{{ $article->title }}" name="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="alert alert-danger">{{ __($message) }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                                <label for="content">{{ __('Article Content') }}</label>
                                <textarea name="content" rows="10" class="form-control  @error('content') is-invalid @enderror">{{ $article->content }}</textarea>
                                @error('content')
                                    <div class="alert alert-danger">{{ __($message) }}</div>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags">{{ __('Article Tags') }}</label>
                            <input type="text" value="{{ $article->tags->implode('tag',',') }}" name="tags" class="form-control @error('tags') is-invalid @enderror">
                            @error('tags')
                                <div class="alert alert-danger">{{ __($message) }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary">{{ __('Update Article') }}</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
