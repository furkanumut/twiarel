@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ARTICLES For') }} <b>{{ Str::upper($tag->tag) }}</b></div>
                <div class="card-body">
                    @foreach ($tagList=$tag->articles()->latest()->paginate(5) as $article)
                    <a href="{{ route('article.detail',$article->slug) }}">{{ $article->title }}</a><hr>
                    @endforeach
                    {{ $tagList->links() }}                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
