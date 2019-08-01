@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Popular Articles') }}</div>
                    <div class="card-body">
                        <ul class="list-inline">
                            
                            @foreach ($populararticles  as $article)
                                <li>
                                    <a href="{{ route('article.detail',$article->slug) }}">{{ $article->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New Article') }}
                        <a href="{{ route('article.index')}}" class="btn btn-danger btn-sm float-sm-right"> {{ __('All Articles') }} </a>
                </div>
                

                <div class="card-body">
                    <form method="POST" action="{{ route('article.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">{{__('Image Upload')}}</label>
                            <input type="file" required name="image" class=" @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="alert alert-danger">{{ __($message) }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title">{{ __('Article Title') }}</label>
                            <input required type="text" name="title" class="form-control @error('title') is-invalid @enderror">
                            @error('title')
                                <div class="alert alert-danger">{{ __($message) }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                                <label for="content">{{ __('Article Content') }}</label>
                                <textarea name="content" rows="10" class="form-control  @error('content') is-invalid @enderror"></textarea>
                                @error('content')
                                    <div class="alert alert-danger">{{ __($message) }}</div>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags">{{ __('Tags') }}</label>
                            <input required id="taginput" type="text" name="tags" class="form-control @error('tags') is-invalid @enderror">
                            @error('tags')
                                <div class="alert alert-danger">{{ __($message) }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-primary">{{ __('Add Article') }}</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
$("#taginput").tagsinput()	
@endsection

@section('javascript')
    

@endsection