@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-columns">
            @include('partials.articlescard', ['articles' => $articles])
            {{ $articles->links() }}
    </div>
</div>
@endsection
