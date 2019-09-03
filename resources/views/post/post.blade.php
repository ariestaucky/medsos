@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('inc.alert')
        <div class="col-md-8">
            @if(empty($post->waller_id))
                <div class="card gedf-card-post">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $post->user->profile_image)}}" alt="">
                                </div>
                                <div class="ml-2">
                                @if(\auth::check())
                                    <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted pointer" title="profile">{{$post->user->name}}</a></div>
                                    <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->user->username}}</a></div>
                                @else
                                    <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted pointer" title="profile">{{$post->user->name}}</a></div>
                                    <div class="h7">@<a class="card-link">{{$post->user->username}}</a></div>
                                @endif
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                        @if(\auth::check())
                                            @if(auth()->user()->id == $post->user_id)
                                                <div class="h6 dropdown-header">Configuration</div>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$post->id}}">Delete</a>  
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$post->id}}">Edit</a> 
                                            @else
                                                <div class="h6 dropdown-header">Configuration</div>
                                                @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $post->id)->where('pos_type', 'App\Post')->first())
                                                    <a class="dropdown-item" href="/poster/unfavorite/{{$post->id}}">UnFavorite</a> 
                                                @else
                                                    <a class="dropdown-item" href="/poster/favorite/{{$post->id}}">Save as Favorite</a>
                                                @endif   

                                                @if(auth()->user()->isBlocking(App\Post::find($post->id)))
                                                <a class="dropdown-item" href="/poster/unblock/{{$post->id}}">Unblock</a>
                                                @else
                                                <a class="dropdown-item" href="/poster/block/{{$post->id}}">Block</a>
                                                @endif
                                                
                                                @if(auth()->user()->report()->where('reported_id', $post->id)->where('reported_type', 'App\Post')->first())
                                                <a class="dropdown-item default-cursor">Reported</a>
                                                @else
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$post->id}}">Report</a>     
                                                @endif
                                            @endif
                                        @else
                                            <a class="dropdown-item pointer" href="{{route('login')}}">Login for more option.</a> 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">                   
                        <p class="card-text">
                            {{$post->content}}
                        </p>
                        
                        <!-- Hidden confirmation modal -->
                        <div class="modal fade" id="confirmDelpos{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete Confirmation</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p style="text-align:center;">Do you want to delete this poster?</p>
                                        <h4 class="text-primary" style="text-align:center;">{{$post->content}}</h4> 
                                    </div>
                                    <div class="modal-footer">   
                                        {!!Form::open(['route' => ['post_delete', $post->id], 'method' => 'POST'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                            {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                        {!!Form::close()!!}          
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Hidden modal -->

                        <!-- Hidden edit modal -->
                        <div class="modal fade" id="editpos{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="col-sm-6">
                                            <h4 class="modal-title">Edit</h4>
                                        </div>
                                        <div class="col-sm-6">         
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('editpos', [$post->id]) }}" id="editpost">
                                            @csrf
                                            <div class="form-group">
                                                <label class="sr-only" for="content">post</label>
                                                <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$post->content}}</textarea>
                                            </div>
                                            <div class="btn-toolbar justify-content-between">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">Done</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-globe" title="public"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right pointer" aria-labelledby="btnGroupDrop1" id="choose">
                                                        <a class="dropdown-item pointer" value="public" title="public"><i class="fa fa-globe"></i> Public</a>
                                                        <a class="dropdown-item pointer" value="followers" title="followers"><i class="fa fa-users"></i> Followers</a>
                                                        <a class="dropdown-item pointer" value="me" title="just me"><i class="fa fa-lock"></i> Just me</a>
                                                    </div>
                                                    <input type="hidden" name="post_type" value="">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Hidden modal -->   

                        <!-- Hidden report modal -->
                        <div class="modal fade" id="report{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    {!!Form::open(['route' => ['post_report'], 'method' => 'POST'])!!}
                                    <div class="modal-header">
                                        <h4 class="modal-title">Report Poster content</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="radio" name="reason" value="abusive" checked> Sexual, hateful or violent content<br>
                                        <input type="radio" name="reason" value="spam"> Spam or misleading<br>
                                        <input type="radio" name="reason" value="danger"> Harmfull or dangerous act
                                    </div>
                                    <div class="modal-footer">   
                                        {{Form::hidden('post_id', $post->id)}}   
                                        {{Form::submit('Report', ['class' => 'btn btn-primary delete'])}}
                                        {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                    </div>
                                    {!!Form::close()!!}   
                                </div>
                            </div>
                        </div>
                        <!-- End of Hidden modal -->            
                    </div>
                    <div class="card-footer">           
                    @if(\auth::check()) 
                        <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                            <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                        </a>     
                    @else
                        <a class="card-link text-primary default-cursor">
                            <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                        </a>  
                    @endif                

                        <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                            <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-post" class="thumb">{{ $post->comments()->count() }}</span> Comment
                        </a>

                        <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{$post->created_at->diffforHumans()}}</div>
                    </div>

                    <!-- Comment box -->
                    <div class="card-footer" id="show-{{$post->id}}">
                        @if(\auth::check())
                            <form method="post" action="{{ route('comment') }}" id="comment-box" class="d-flex add-comment">
                            @csrf
                                <div class="form-group col-sm-10 padat">
                                    <label class="sr-only" for="content">post</label>
                                    <input class="form-control" style="" name="content" id="content input-{{$post->id}}" placeholder="What are you thinking?">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                    <input type="hidden" name="user_id" value="{{ $post->user->id }}" />
                                </div>
                                <div class="btn-group col-sm-2 padat segaris">
                                    <button type="submit" class="btn btn-primary segaris">Comment</button>
                                </div>
                            </form>
                        @endif
                        @if($post->comments()->count() > 0)
                            @foreach($post->comments()->get() as $comment)
                                <div class="d-flex comment-baru">
                                    <div class="col-sm-2 img padat">
                                        <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $comment->user->profile_image)}}" alt="">
                                    </div>
                                    <div class="col-sm-10 padat break"> 
                                        <div class="h5 m-0">
                                            <a href="{{route('profile', [$comment->user->id])}}" class="card-link text-primary" title="profile">{{$comment->user->name}}</a>
                                            <span class="mr-2 h6 small"> <small class="text-muted h6 small"> {{$comment->created_at->diffforHumans()}}</small></span>
                                            <div class="card-link dropdown pull-right">
                                                <button class="btn btn-link dropdown-toggle" style="padding:0 !important" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                    @if(\auth::check())
                                                        @if(auth()->user()->id == $comment->user->id)
                                                            <div class="h6 dropdown-header">Configuration</div>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#comDel{{$comment->id}}">Delete</a>   
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcom{{$comment->id}}">Edit</a>
                                                        @else
                                                            <div class="h6 dropdown-header">Configuration</div> 
                                                            <a class="dropdown-item card-link" href="#" title="message" data-toggle="modal" data-target="#contact-{{$comment->user->id}}">Message</a>
                                                            
                                                            @if(auth()->user()->isBlocking($comment))
                                                            <a class="dropdown-item" href="/comment/unblock/{{$comment->id}}">Unblock</a>
                                                            @else
                                                            <a class="dropdown-item" href="/comment/block/{{$comment->id}}">Block</a>
                                                            @endif
                                                            
                                                            @if(auth()->user()->report()->where('reported_id', $comment->id)->where('reported_type', 'App\Comment')->first())
                                                            <a class="dropdown-item default-cursor">Reported</a>
                                                            @else
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$comment->id}}">Report</a>     
                                                            @endif
                                                        @endif
                                                    @else
                                                        <a class="dropdown-item pointer" href="{{route('login')}}">Login for more option.</a>
                                                    @endif
                                                </div>
                                            </div> 
                                        </div>  
                                        @if(\auth::check())
                                            @if(auth()->user()->isBlocking($comment))
                                                <P class="text-mute default-cursor"><i class="fa fa-ban" aria-hidden="true"></i> Blocked</P>
                                            @else
                                                <p> {{$comment->comment}}</p>
                                            @endif
                                        @else
                                            <p> {{$comment->comment}}</p>
                                        @endif
                                    </div>
                                </div>  

                                <!-- Hidden confirmation modal -->
                                <div class="modal fade" id="comDel{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p style="text-align:center;">Do you want to delete this?</p> 
                                            </div>
                                            <div class="modal-footer">   
                                                {!!Form::open(['route' => ['com_delete', $comment->id], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                                    {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                                {!!Form::close()!!}          
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Hidden modal -->

                                <!-- Hidden edit modal -->
                                    <div class="modal fade" id="editcom{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-sm-6"> 
                                                        <h4 class="modal-title">Edit</h4>
                                                    </div>
                                                    <div class="col-sm-6">         
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('editcom', [$comment->id]) }}" id="editcom">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="sr-only" for="content">post</label>
                                                            <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$comment->comment}}</textarea>
                                                        </div>
                                                        <div class="btn-toolbar justify-content-between">
                                                            <div class="btn-group">
                                                                <button type="submit" class="btn btn-primary">Done</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- End of Hidden modal -->  

                                <!-- Hidden message -->
                                    <div class="modal fade" id="contact-{{$comment->user->id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="contact">Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['url' => 'message/submit']) !!}
                                                        <div class="form-group">
                                                            {{Form::label('receiver', 'Send to')}}
                                                            {{Form::text('receiver', $comment->user->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{Form::label('subject', 'Subject')}}
                                                            {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{Form::label('message', 'Massage')}}
                                                            {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                                                        </div>
                                                        <div>
                                                            {{ Form::hidden('receiver_id', $comment->user->id) }}
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- End hidden message -->   

                                <!-- Hidden report modal -->
                                <div class="modal fade" id="report{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            {!!Form::open(['route' => ['comment_report'], 'method' => 'POST'])!!}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Report comment content</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="radio" name="reason" value="abusive" checked> Sexual, hateful or violent content<br>
                                                <input type="radio" name="reason" value="spam"> Spam or misleading<br>
                                                <input type="radio" name="reason" value="danger"> Harmfull or dangerous act
                                            </div>
                                            <div class="modal-footer">   
                                                {{Form::hidden('post_id', $comment->id)}}   
                                                {{Form::submit('Report', ['class' => 'btn btn-primary delete'])}}
                                                {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                            </div>
                                            {!!Form::close()!!}   
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Hidden modal -->      
                            @endforeach    
                        @endif
                    </div>
                    <!-- End comment box -->
                </div>
            @else
                <div class="card gedf-card-post">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $post->waller->profile_image)}}" alt="">
                                </div>
                                <div class="ml-2">
                                @if(\auth::check())
                                    <div class="h5 m-0"><a href="{{route('profile', [$post->waller_id])}}" class="card-link text-muted" title="profile">{{$post->waller->name}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->user->name}}</a></div>
                                    @if(auth()->user()->id == $post->waller_id)
                                        <div class="h7">@<a href="/message" class="card-link" title="Inbox">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->user->username}}</a></div>
                                    @elseif(auth()->user()->id == $post->user_id)
                                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->waller_id}}">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="/message" class="card-link" title="Inbox">{{$post->user->username}}</a></div>
                                    @else
                                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->waller_id}}">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->user->username}}</a></div>
                                    @endif
                                @else
                                    <div class="h5 m-0"><a href="{{route('profile', [$post->waller_id])}}" class="card-link text-muted" title="profile">{{$post->waller->name}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->user->name}}</a></div>
                                    <div class="h7">@<a href="#" class="card-link default-cursor">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link default-cursor">{{$post->user->username}}</a></div>
                                @endif
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                        @if(\auth::check())
                                            @if(auth()->user()->id == $post->user_id)
                                                <div class="h6 dropdown-header">Configuration</div>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$post->id}}">Delete</a>  
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$post->id}}">Edit</a> 
                                            @else
                                                <div class="h6 dropdown-header">Configuration</div>
                                                @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $post->id)->where('pos_type', 'App\Post')->first())
                                                    <a class="dropdown-item" href="/poster/unfavorite/{{$post->id}}">UnFavorite</a> 
                                                @else
                                                    <a class="dropdown-item" href="/poster/favorite/{{$post->id}}">Save as Favorite</a>
                                                @endif   
                                                
                                                @if(auth()->user()->isBlocking(App\Post::find($post->id)))
                                                <a class="dropdown-item" href="/poster/unblock/{{$post->id}}">Unblock</a>
                                                @else
                                                <a class="dropdown-item" href="/poster/block/{{$post->id}}">Block</a>
                                                @endif
                                                
                                                @if(auth()->user()->report()->where('reported_id', $post->id)->where('reported_type', 'App\Post')->first())
                                                <a class="dropdown-item default-cursor">Reported</a>
                                                @else
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$post->id}}">Report</a>     
                                                @endif
                                            @endif
                                        @else
                                            <a class="dropdown-item pointer" href="{{route('login')}}">Login for more option.</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{$post->content}}
                        </p>
                        
                        <!-- Hidden confirmation modal -->
                        <div class="modal fade" id="confirmDel{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete Confirmation</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p style="text-align:center;">Do you want to delete this?</p> 
                                    </div>
                                    <div class="modal-footer">   
                                        {!!Form::open(['route' => ['post_delete', $post->id], 'method' => 'POST'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                            {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                        {!!Form::close()!!}          
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Hidden modal -->

                        <!-- Hidden edit modal -->
                        <div class="modal fade" id="editpos{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="col-sm-6">
                                            <h4 class="modal-title">Edit</h4>
                                        </div>
                                        <div class="col-sm-6">         
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('editpos', [$post->id]) }}" id="editpost">
                                            @csrf
                                            <div class="form-group">
                                                <label class="sr-only" for="content">post</label>
                                                <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$post->content}}</textarea>
                                            </div>
                                            <div class="btn-toolbar justify-content-between">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">Done</button>
                                                </div>
                                                <div class="btn-group">
                                                    <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-globe" title="public"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right pointer" aria-labelledby="btnGroupDrop1" id="choose">
                                                        <a class="dropdown-item pointer" value="public" title="public"><i class="fa fa-globe"></i> Public</a>
                                                        <a class="dropdown-item pointer" value="followers" title="followers"><i class="fa fa-users"></i> Followers</a>
                                                        <a class="dropdown-item pointer" value="me" title="just me"><i class="fa fa-lock"></i> Just me</a>
                                                    </div>
                                                    <input type="hidden" name="post_type" value="">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Hidden modal -->

                        <!-- Hidden report modal -->
                        <div class="modal fade" id="report{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    {!!Form::open(['route' => ['post_report'], 'method' => 'POST'])!!}
                                    <div class="modal-header">
                                        <h4 class="modal-title">Report Poster content</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="radio" name="reason" value="abusive" checked> Sexual, hateful or violent content<br>
                                        <input type="radio" name="reason" value="spam"> Spam or misleading<br>
                                        <input type="radio" name="reason" value="danger"> Harmfull or dangerous act
                                    </div>
                                    <div class="modal-footer">   
                                        {{Form::hidden('post_id', $post->id)}}   
                                        {{Form::submit('Report', ['class' => 'btn btn-primary delete'])}}
                                        {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                    </div>
                                    {!!Form::close()!!}   
                                </div>
                            </div>
                        </div>
                        <!-- End of Hidden modal -->  
                    </div>
                    <div class="card-footer">       
                    @if(\auth::check()) 
                        <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                            <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                        </a>     
                    @else
                        <a class="card-link text-primary default-cursor">
                            <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                        </a>  
                    @endif             

                        
                        <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                            <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span> Comment
                        </a>

                        <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
                    </div>

                    <!-- Comment box -->
                    <div class="card-footer" id="show-{{$post->id}}">
                        @if(\auth::check()) 
                            <form method="post" action="{{ route('comment') }}" id="comment-box" class="d-flex add-comment">
                            @csrf
                                <div class="form-group col-sm-10 padat">
                                    <label class="sr-only" for="content">post</label>
                                    <input class="form-control" style="" name="content" id="content input-{{$post->id}}" placeholder="What are you thinking?">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                    <input type="hidden" name="user_id" value="{{ $post->user_id }}" />
                                </div>
                                <div class="btn-group col-sm-2 padat segaris">
                                    <button type="submit" class="btn btn-primary segaris">Comment</button>
                                </div>
                            </form>
                        @endif  
                        @if(App\Post::find($post->id)->comments()->count() > 0)
                            @foreach(App\Post::find($post->id)->comments()->get() as $comment)
                                <div class="d-flex comment-baru">
                                    <div class="col-sm-2 img padat">
                                        <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $comment->user->profile_image)}}" alt="">
                                    </div>
                                    <div class="col-sm-10 padat break"> 
                                        <div class="h5 m-0">
                                            <a href="{{route('profile', [$comment->user->id])}}" class="card-link text-primary" title="profile">{{$comment->user->name}}</a>
                                            <span class="mr-2 h6 small"> <small class="text-muted h6 small"> {{$comment->created_at->diffforHumans()}}</small></span>
                                            <div class="card-link dropdown pull-right">
                                                <button class="btn btn-link dropdown-toggle" style="padding:0 !important" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                    @if(\auth::check()) 
                                                        @if(auth()->user()->id == $comment->user->id)
                                                            <div class="h6 dropdown-header">Configuration</div>
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#comDel{{$comment->id}}">Delete</a>   
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcom{{$comment->id}}">Edit</a>
                                                        @else
                                                            <div class="h6 dropdown-header">Configuration</div>   
                                                            <a class="dropdown-item card-link" href="#" title="message" data-toggle="modal" data-target="#contact-{{$comment->user->id}}">Message</a>
                                                            
                                                            @if(auth()->user()->isBlocking($comment))
                                                            <a class="dropdown-item" href="/comment/unblock/{{$comment->id}}">Unblock</a>
                                                            @else
                                                            <a class="dropdown-item" href="/comment/block/{{$comment->id}}">Block</a>
                                                            @endif
                                                            
                                                            @if(auth()->user()->report()->where('reported_id', $comment->id)->where('reported_type', 'App\Comment')->first())
                                                            <a class="dropdown-item default-cursor">Reported</a>
                                                            @else
                                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$comment->id}}">Report</a>     
                                                            @endif
                                                        @endif
                                                    @else
                                                        <a class="dropdown-item pointer" href="{{route('login')}}">Login for more option.</a>
                                                    @endif
                                                </div>
                                            </div> 
                                        </div>  
                                        @if(\auth::check())
                                            @if(auth()->user()->isBlocking($comment))
                                                <P class="text-mute default-cursor"><i class="fa fa-ban" aria-hidden="true"></i> Blocked</P>
                                            @else
                                                <p> {{$comment->comment}}</p>
                                            @endif
                                        @else
                                            <p> {{$comment->comment}}</p>
                                        @endif
                                    </div>
                                </div>  

                                <!-- Hidden confirmation modal -->
                                <div class="modal fade" id="comDel{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p style="text-align:center;">Do you want to delete this?</p> 
                                            </div>
                                            <div class="modal-footer">   
                                                {!!Form::open(['route' => ['com_delete', $comment->id], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                                    {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                                {!!Form::close()!!}          
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Hidden modal -->

                                <!-- Hidden edit modal -->
                                    <div class="modal fade" id="editcom{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-sm-6"> 
                                                        <h4 class="modal-title">Edit</h4>
                                                    </div>
                                                    <div class="col-sm-6">         
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('editcom', [$comment->id]) }}" id="editcom">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="sr-only" for="content">post</label>
                                                            <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$comment->comment}}</textarea>
                                                        </div>
                                                        <div class="btn-toolbar justify-content-between">
                                                            <div class="btn-group">
                                                                <button type="submit" class="btn btn-primary">Done</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- End of Hidden modal -->   

                                <!-- Hidden message -->
                                    <div class="modal fade" id="contact-{{$comment->user->id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="contact">Message</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {!! Form::open(['url' => 'message/submit']) !!}
                                                        <div class="form-group">
                                                            {{Form::label('receiver', 'Send to')}}
                                                            {{Form::text('receiver', $comment->user->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{Form::label('subject', 'Subject')}}
                                                            {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                                                        </div>
                                                        <div class="form-group">
                                                            {{Form::label('message', 'Massage')}}
                                                            {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                                                        </div>
                                                        <div>
                                                            {{ Form::hidden('receiver_id', $comment->user->id) }}
                                                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!-- End hidden message -->   

                                <!-- Hidden report modal -->
                                <div class="modal fade" id="report{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            {!!Form::open(['route' => ['comment_report'], 'method' => 'POST'])!!}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Report comment content</h4>
                                            </div>
                                            <div class="modal-body">
                                                <input type="radio" name="reason" value="abusive" checked> Sexual, hateful or violent content<br>
                                                <input type="radio" name="reason" value="spam"> Spam or misleading<br>
                                                <input type="radio" name="reason" value="danger"> Harmfull or dangerous act
                                            </div>
                                            <div class="modal-footer">   
                                                {{Form::hidden('post_id', $comment->id)}}   
                                                {{Form::submit('Report', ['class' => 'btn btn-primary delete'])}}
                                                {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                            </div>
                                            {!!Form::close()!!}   
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Hidden modal -->
                            @endforeach    
                        @endif
                    </div>
                    <!-- End comment box -->

                    <!-- Hidden message -->
                    <div class="modal fade" id="contact{{$post->user->id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="contact">Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['url' => 'message/submit']) !!}
                                        <div class="form-group">
                                            {{Form::label('receiver', 'Send to')}}
                                            {{Form::text('receiver', $post->user->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('subject', 'Subject')}}
                                            {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('message', 'Massage')}}
                                            {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                                        </div>
                                        <div>
                                            {{ Form::hidden('receiver_id', $post->id) }}
                                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End hidden message -->
                    <!-- Hidden message -->
                    <div class="modal fade" id="contact{{$post->waller_id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="contact">Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {!! Form::open(['url' => 'message/submit']) !!}
                                        <div class="form-group">
                                            {{Form::label('receiver', 'Send to')}}
                                            {{Form::text('receiver', $post->waller->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('subject', 'Subject')}}
                                            {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('message', 'Massage')}}
                                            {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                                        </div>
                                        <div>
                                            {{ Form::hidden('receiver_id', $post->id) }}
                                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End hidden message -->
                </div>
            @endif
        </div>
    </div>
</div>
@endsection