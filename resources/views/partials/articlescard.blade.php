@forelse($articles as $article)
<div class="card">
        @if($article->image)
        <a href="{{ route('article.detail',$article->slug) }}">
            <img src="{{asset(Storage::url($article->image))}}" class="shadow-sm card-img-top img-fluid">
        </a>
        @endif
        <div class="card-body">
          <a href="{{ route('article.detail',$article->slug) }}">
            <h5 class="card-title"><b>{{$article->title}}</b></h5>
          </a>
          <p class="card-text text-small ml-2 pb-3">{{Str::words($article->username, 15)}}</p>
          <p class="card-text">
              <a href="{{route('user.articles',$article->user)}}">
                <small class="d-none d-md-block text-muted">
                      <img class="img-fluid rounded-circle col-md-2" src="{{asset(Storage::url($article->user->avatar))}}" alt="{{$article->user->name}}">
                    {{$article->user->name}}
                </small>
              </a>
              <small class="text-muted float-right">
                  {{$article->created_at->diffForHumans()}}
              </small>
          </p>
        </div>
     </div>
@empty
<a href="{{route('article.create')}}" class="btn btn-sm btn-primary">{{__('New Article')}}</a>
@endforelse