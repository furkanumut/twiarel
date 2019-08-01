@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Hoşgeldin {{Auth::user()->age}} yaşındaki okuyucumuz :*)</div>
                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach ($articles as $article)
                    <a href="{{ route('article.detail',$article->slug) }}" class="list-group-item list-group-item-action">{{ $article->title }}</a>
                    @endforeach

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
