@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Recently Added Articles') }}</div>
                    <div class="card-body">
                        <ul class="list-inline">
                            
                            @foreach ($lastArticles  as $articleInfo)
                                <li>
                                    <a href="{{ route('article.detail',$articleInfo->slug) }}">{{ $articleInfo->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

        </div>
        <div class="col-md-8">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card">

                <div class="card-header">{{ $article->title }}
                        <a href="{{ route('article.index')}}" class="btn btn-danger btn-sm float-sm-right"> {{ __('All Articles') }} </a>
                </div>
                <div class="card-img-top p-3 mb-5">
                        <img src="{{asset(Storage::url($article->image))}}" class="shadow-lg bg-white img-fluid">
                        </div>

                <div class="card-body">
                    <p>{!! nl2br($article->content) !!}</p>
                </div>
                
                <div class="card-footer">
                        @if($tags = $article->tags()->get() and $tags->count() > 0)
                            {{ __('Tags') }} :
                            
                            @foreach ($tags as $tag)
                                <a href="{{ route('tag.articles',$tag->tag) }}">{{ $tag->tag }}</a>  
                                {{-- son gönderi değilse pipe koy --}}
                                @if(!$loop->last)
                                |
                                @endif 
                            @endforeach
                            <hr>
                        @endif
                        {{ count($article->user->articles) }} <small>{{ __(' Article for ') }}</small>
                        <a href="{{ route('user.articles',$article->user->username) }}">{{ $article->user->name }}</a>  | 
                    <small>{{ __('Last Updated') }} : {{ $article->updated_at->diffForHumans() }}</small>
                    
                    @auth
                        @if(Auth::user()->id == $article->user->id)
                        <a href="{{ route('article.edit',$article->id)}}" class="btn btn-primary btn-sm float-sm-right"> {{ __('Edit Article') }} </a>   
                        <button class="btn btn-danger btn-sm float-sm-right mr-1 openModal" data-deleteurl="{{ route('article.delete',$article->id) }}" data-toggle="modal" data-target="#deleteFormModal"><i class="fas fa-trash-alt"></i> {{ __('Delete Article') }} </button>   
                        
                        @endif
                    @endauth
                    
                </div>
                
            </div>
            <hr>

            <div class="card">
                <div class="card-header" id="openCommentForm">{{ __('Comment Form') }}</div>
                <div class="card-body" id="addNewComment">
                    @auth  
                        <form  action="{{ route('article.addcomment',$article->slug) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea name="body" tabindex="1" class="form-control" rows="5" id="comment"></textarea>
                            </div>
                            <div class="form-group">
                                <button tabindex="2" class="btn btn-lg btn-primary ">{{ __('Add Comment') }}</button>
                            </div>
                        </form>
                    @endauth
                    @guest
                        {{ __('Please Login First') }}
                    @endguest
                    
                </div>
            </div>

            <hr>
            <div class="card">
                @if($article->comments()->count()>0)   
                <div class="card-header">{{ __('Comments') }}</div>
                <div class="card-body">
                    
                    @include('partials._comment_replies', ['comments' => $article->comments()->where("parent_id",0)->latest()->get(), 'isSub' => false])
                </div>
                @else
                <div class="card-body">{{ __('No Comment Added Yet') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="deleteFormModal">
        <div class="modal-dialog">
          <div class="modal-content">
      
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('Are you sure ?') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
      
            <!-- Modal body -->
            <div class="modal-body">
                {{ __('Lan gerçekten bunu silecek misin ?') }}
                
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('İptal Et') }}</button>
                    <form method="POST" id="deleteFormAction" action="">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger" >{{ __('Evet Sil') }}</button>
                    </form>
                </div>
      
          </div>
        </div>
      </div>
    </div>
    
      <div class="modal fade" id="addCommentModal">
            <div class="modal-dialog">
              <div class="modal-content">
                    <form  action="{{ route('article.addcomment',$article->slug) }}" id="replyCommentAction" method="POST">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Reply Comment') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
          
                <!-- Modal body -->
                <div class="modal-body">
                    
                        
                                @csrf
                                <input type="hidden" id="replyCommentParentID" name="parent_id" class="hidden" value="0">
                                <div class="form-group">
                                    <label for="comment">Comment:</label>
                                    <textarea name="body" class="form-control" rows="5" id="replycomment"></textarea>
                                </div>
                                
                            
                        
                  
                </div>
          
                <!-- Modal footer -->
                <div class="modal-footer">
                        <button type="submit" class="btn btn-success">{{ __('Send Comment') }}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Cancel') }}</button>

                </div>
            </form>
          
              </div>
            </div>
          </div>
        </div>
@endsection

@section('javascript')
    $(".openModal").click(function(){
        var deleteUrl = $(this).attr('data-deleteurl');
        $('#deleteFormAction').attr('action',deleteUrl);
    });

    $(".openCommentModal").click(function(){
        var parent_id = $(this).attr('dataid');
        $('#replycomment').focus();
        $('#replyCommentParentID').attr('value',parent_id);
        
    });

    
    if($("#addNewComment").length > 0){
        $('#openCommentForm').click(function(){
            $("#addNewComment").toggle('slow')
        });
    }
    
@endsection
