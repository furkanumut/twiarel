<!-- _comment_replies.blade.php -->
@if($isSub)  <div class="ml-4"> @endif

@foreach ($comments as $commentInfo)
    <div id="commentRow_{{ $commentInfo->id }}">
    
        @auth
            @if(Auth::user()->id == $commentInfo->user->id)
                <button class="btn btn-danger btn-sm float-sm-right mr-1 openModal" data-deleteurl="{{ route('article.deletecomment',$commentInfo->id) }}" data-toggle="modal" data-target="#deleteFormModal"> {{ __('Delete Comment') }} </button>   
            @endif
                <button class="btn btn-success btn-sm float-sm-right mr-1 openCommentModal" dataid="{{ $commentInfo->id }}" data-url="{{ route('article.addcomment',$commentInfo->id) }}" data-toggle="modal" data-target="#addCommentModal"> {{ __('Reply') }} </button>       
        @endauth
        <a href="{{ route('user.articles',$commentInfo->user->username) }}">{{ $commentInfo->user->name }}</a>  | 
        <small>{{ __('Last Updated') }} : {{ $commentInfo->updated_at->diffForHumans() }}</small> <hr>
        {{ $commentInfo->body }}  <hr>
        @includewhen($commentInfo->comments,'partials._comment_replies', ['comments' => $commentInfo->comments, 'isSub' => true])
    </div>
@endforeach
@if($isSub)  </div> @endif