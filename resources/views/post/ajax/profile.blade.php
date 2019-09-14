@foreach($poster as $post)
    @if($post->waller_id == null)
        @if($post->type == 'public')
            <div class="card gedf-card-post">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mr-2">
                                <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $post->profile)}}" alt="">
                            </div>
                            <div class="ml-2">
                                @if(\auth::check())
                                    <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->name}}</a></div>
                                    <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                @else
                                    <div class="h5 m-0"><a class="card-link text-muted" title="profile">{{$post->name}}</a></div>
                                    <div class="h7">@<a class="card-link">{{$post->username}}</a></div>
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
                                            @if($post->images == null)
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$post->id}}">Delete</a>  
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$post->id}}">Edit</a> 
                                            @else
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelimg{{$post->id}}">Delete</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcaption{{$post->id}}">Edit</a>
                                            @endif 
                                        @else
                                            <div class="h6 dropdown-header">Configuration</div>
                                            @if($post->images == null)
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
                                            @else
                                                @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $post->id)->where('pos_type', 'App\Image')->first())
                                                    <a class="dropdown-item" href="/image/unfavorite/{{$post->id}}">UnFavorite</a> 
                                                @else
                                                    <a class="dropdown-item" href="/image/favorite/{{$post->id}}">Save as Favorite</a>
                                                @endif 
                                                
                                                @if(auth()->user()->isBlocking(App\Image::find($post->id)))
                                                <a class="dropdown-item" href="/image/unblock/{{$post->id}}">Unblock</a>
                                                @else
                                                <a class="dropdown-item" href="/image/block/{{$post->id}}">Block</a>
                                                @endif
                                                
                                                @if(auth()->user()->report()->where('reported_id', $post->id)->where('reported_type', 'App\Image')->first())
                                                <a class="dropdown-item default-cursor">Reported</a>
                                                @else
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$post->id}}">Report</a>     
                                                @endif
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
                    @if($post->images == null)
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
                    @else
                        <a class="card-link">
                            <h5 class="card-title text-primary">{{$post->caption}}</h5>
                        </a>
                        <img class="card-img-top" src="{{asset('/public/user_album/' . $post->images)}}" alt="" style="width:50%; display:block; margin-left:auto; margin-right: auto;" data-toggle="modal" data-target="#pic{{$post->id}}" title="pic-{{$post->id}}">

                        <!-- Pic -->
                            <div class="modal fade" id="pic{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-sm-6">
                                                <h5 class="modal-title" id="contact">Picture</h5>
                                                <div class="h7 text-muted">Uploaded by {{$post->name}}</div>
                                            </div>
                                            <div class="col-sm-6">         
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <img class="card-img-top" src="{{asset('/public/user_album/' . $post->images)}}" alt="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="close">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End Pic -->

                        <!-- Hidden confirmation modal -->
                            <div class="modal fade" id="confirmDelimg{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p style="text-align:center;">Do you want to delete this?</p>
                                            <br>
                                            <h3 class="text-primary" style="text-align:center;">{{$post->caption}}</h3>
                                        </div>
                                        <div class="modal-footer">
                                            {!!Form::open(['route' => ['img_delete', $post->id], 'method' => 'POST'])!!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                                {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                            {!!Form::close()!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End of Hidden modal -->

                        <!-- Hidden report modal -->
                            <div class="modal fade" id="report{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        {!!Form::open(['route' => ['image_report'], 'method' => 'POST'])!!}
                                        <div class="modal-header">
                                            <h4 class="modal-title">Report Image content</h4>
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
                    @endif   
                </div>
                <div class="card-footer">
                    @if(\auth::check())
                        @if($post->images == null)            
                            <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span>
                            <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                <i class="fa fa-gittip"></i> Like
                            </a>                
                        @else
                            <span id="love{{$post->id}}-bs3" class="thumb">{{ App\Image::find($post->id)->likers()->get()->count() }}</span>
                            <a data-id="{{ $post->id }}" id="love{{$post->id}}" class="card-link text-primary panel-love {{ auth()->user()->hasLiked(App\Image::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                <i class="fa fa-gittip"></i> Like
                            </a>
                        @endif
                    @else
                        @if($post->images == null)            
                            <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span>
                            <a class="card-link text-primary pointer">
                                <i class="fa fa-gittip"></i> Like
                            </a>                
                        @else
                            <span id="love{{$post->id}}-bs3" class="thumb">{{ App\Image::find($post->id)->likers()->get()->count() }}</span>
                            <a class="card-link text-primary pointer">
                                <i class="fa fa-gittip"></i> Like
                            </a>
                        @endif
                    @endif

                    @if($post->images == null) 
                        <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span>
                        <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                            <i class="fa fa-comment"></i> Comment
                        </a>
                    @else
                        <span id="komen{{$post->id}}-image" class="thumb">{{ App\Image::find($post->id)->comments()->count() }}</span>
                        <a data-id="{{ $post->id }}" class="card-link text-primary panel-image" style="cursor: pointer;">
                            <i class="fa fa-comment"></i> Comment
                        </a>
                    @endif
                    
                    @if(\auth::check())
                        @if($post->images == null)                                   
                            <a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                                <i class="fa fa-share"></i> Share
                            </a>
                            <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Share with</div>
                                <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $post->id)}}" data-pos="{{$post->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('share', $post->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                            </div>
                        @else
                            <a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                                <i class="fa fa-share"></i> Share
                            </a>
                            <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Share with</div>
                                <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $post->id)}}" data-pos="{{$post->caption}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('sharing', $post->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                            </div>
                        @endif
                    @endif
                    <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i>{{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
                </div>

                <!-- Comment box -->
                @if($post->images == null) 
                <div class="card-footer d-none" id="show-{{$post->id}}">
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
                        <hr style="margin-bottom:5px; margin-top:5px;">
                        <span class="text-primary h7">
                            <a href="/posts/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                        </span>
                        <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                    @else
                        <p>No comment</p>
                    @endif
                </div>
                @else
                <div class="card-footer d-none" id="show-image-{{$post->id}}">
                    @if(\auth::check())
                        <form method="post" action="{{ route('imagecomment') }}" id="comment" class="d-flex">
                        @csrf
                            <div class="form-group col-sm-10 padat">
                                <label class="sr-only" for="content">post</label>
                                <input class="form-control" style="" name="content" id="content input-{{$post->id}}" placeholder="What are you thinking?">
                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                <input type="hidden" name="user_id" value="{{ $post->user_id }}" />
                            </div>
                            <div class="btn-group col-sm-2 padat segaris">
                                <button type="submit" class="btn btn-primary img-add-comment segaris">Comment</button>
                            </div>
                        </form>
                    @endif
                    @if(App\Image::find($post->id)->comments()->count() > 0)
                        @foreach(App\Image::find($post->id)->comments()->get() as $comment)
                            <div class="d-flex">
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
                        <hr style="margin-bottom:5px; margin-top:5px;">
                        <span class="text-primary h7">
                            <a href="/Image/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                        </span>
                        <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                    @else
                        <p>No comment</p>
                    @endif
                </div>
                @endif
                <!-- End comment box -->
            </div>
        @elseif($post->type == 'followers')
            @if(\auth::check())
                @if(auth()->user()->isFollowing($user))
                <div class="card gedf-card-post">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="mr-2">
                                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $post->profile)}}" alt="">
                                </div>
                                <div class="ml-2">
                                    <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->name}}</a></div>
                                    <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                </div>
                            </div>
                            <div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                        @if(auth()->user()->id == $post->user_id)
                                            <div class="h6 dropdown-header">Configuration</div>
                                            @if($post->images == null)
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$post->id}}">Delete</a> 
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$post->id}}">Edit</a>  
                                            @else
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelimg{{$post->id}}">Delete</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcaption{{$post->id}}">Edit</a>
                                            @endif 
                                        @else
                                            <div class="h6 dropdown-header">Configuration</div>
                                            @if($post->images == null)
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
                                            @else
                                                @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $post->id)->where('pos_type', 'App\Image')->first())
                                                    <a class="dropdown-item" href="/image/unfavorite/{{$post->id}}">UnFavorite</a> 
                                                @else
                                                    <a class="dropdown-item" href="/image/favorite/{{$post->id}}">Save as Favorite</a>
                                                @endif 
                                                
                                                @if(auth()->user()->isBlocking(App\Image::find($post->id)))
                                                <a class="dropdown-item" href="/image/unblock/{{$post->id}}">Unblock</a>
                                                @else
                                                <a class="dropdown-item" href="/image/block/{{$post->id}}">Block</a>
                                                @endif
                                                
                                                @if(auth()->user()->report()->where('reported_id', $post->id)->where('reported_type', 'App\Image')->first())
                                                <a class="dropdown-item default-cursor">Reported</a>
                                                @else
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$post->id}}">Report</a>     
                                                @endif
                                            @endif 
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($post->images == null)
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
                        @else
                            <a class="card-link">
                                <h5 class="card-title text-primary">{{$post->caption}}</h5>
                            </a>
                            <img class="card-img-top" src="{{asset('/public/user_album/' . $post->images)}}" alt="" style="width:50%; display:block; margin-left:auto; margin-right: auto;" data-toggle="modal" data-target="#pic{{$post->id}}" title="pic-{{$post->id}}">

                            <!-- Pic -->
                                <div class="modal fade" id="pic{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="col-sm-6">
                                                    <h5 class="modal-title" id="contact">Picture</h5>
                                                    <div class="h7 text-muted">Uploaded by {{$post->name}}</div>
                                                </div>
                                                <div class="col-sm-6">         
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <img class="card-img-top" src="{{asset('/public/user_album/' . $post->images)}}" alt="">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" title="close">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- End Pic -->

                            <!-- Hidden confirmation modal -->
                                <div class="modal fade" id="confirmDelimg{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p style="text-align:center;">Do you want to delete this?</p>
                                                <br>
                                                <h3 class="text-primary" style="text-align:center;">{{$post->caption}}</h3>
                                            </div>
                                            <div class="modal-footer">
                                                {!!Form::open(['route' => ['img_delete', $post->id], 'method' => 'POST'])!!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                                    {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                                {!!Form::close()!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- End of Hidden modal -->

                            <!-- Hidden report modal -->
                                <div class="modal fade" id="report{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            {!!Form::open(['route' => ['image_report'], 'method' => 'POST'])!!}
                                            <div class="modal-header">
                                                <h4 class="modal-title">Report Image content</h4>
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
                        @endif   
                    </div>
                    <div class="card-footer">
                        @if($post->images == null)            
                            <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span>
                            <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                <i class="fa fa-gittip"></i> Like
                            </a>                
                        @else
                            <span id="love{{$post->id}}-bs3" class="thumb">{{ App\Image::find($post->id)->likers()->get()->count() }}</span>
                            <a data-id="{{ $post->id }}" id="love{{$post->id}}" class="card-link text-primary panel-love {{ auth()->user()->hasLiked(App\Image::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                <i class="fa fa-gittip"></i> Like
                            </a>
                        @endif

                        @if($post->images == null) 
                            <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span>
                            <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                                <i class="fa fa-comment"></i> Comment
                            </a>
                        @else
                            <span id="komen{{$post->id}}-image" class="thumb">{{ App\Image::find($post->id)->comments()->count() }}</span>
                            <a data-id="{{ $post->id }}" class="card-link text-primary panel-image" style="cursor: pointer;">
                                <i class="fa fa-comment"></i> Comment
                            </a>
                        @endif
                        
                        @if($post->images == null)                                   
                            <a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                                <i class="fa fa-share"></i> Share
                            </a>
                            <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Share with</div>
                                <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $post->id)}}" data-pos="{{$post->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('share', $post->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                            </div>
                        @else
                            <a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                                <i class="fa fa-share"></i> Share
                            </a>
                            <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Share with</div>
                                <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $post->id)}}" data-pos="{{$post->caption}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('sharing', $post->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                            </div>
                        @endif
                        <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i>{{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
                    </div>

                    <!-- Comment box -->
                    @if($post->images == null) 
                    <div class="card-footer d-none" id="show-{{$post->id}}">
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
                                                </div>
                                            </div> 
                                        </div>  
                                        @if(auth()->user()->isBlocking($comment))
                                        <P class="text-mute default-cursor"><i class="fa fa-ban" aria-hidden="true"></i> Blocked</P>
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
                            <hr style="margin-bottom:5px; margin-top:5px;">
                            <span class="text-primary h7">
                                <a href="/post/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                            </span>
                            <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                        @endif
                    </div>
                    @else
                    <div class="card-footer d-none" id="show-image-{{$post->id}}">
                        <form method="post" action="{{ route('imagecomment') }}" id="comment" class="d-flex">
                        @csrf
                            <div class="form-group col-sm-10 padat">
                                <label class="sr-only" for="content">post</label>
                                <input class="form-control" style="" name="content" id="content input-{{$post->id}}" placeholder="What are you thinking?">
                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                <input type="hidden" name="user_id" value="{{ $post->user_id }}" />
                            </div>
                            <div class="btn-group col-sm-2 padat segaris">
                                <button type="submit" class="btn btn-primary img-add-comment segaris">Comment</button>
                            </div>
                        </form>
                        @if(App\Image::find($post->id)->comments()->count() > 0)
                            @foreach(App\Image::find($post->id)->comments()->get() as $comment)
                                <div class="d-flex">
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
                                                </div>
                                            </div> 
                                        </div>  
                                        @if(auth()->user()->isBlocking($comment))
                                            <P class="text-mute default-cursor"><i class="fa fa-ban" aria-hidden="true"></i> Blocked</P>
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
                        <hr style="margin-bottom:5px; margin-top:5px;">
                        <span class="text-primary h7">
                            <a href="/Image/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                        </span>
                        <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                        @endif
                    </div>
                    @endif
                    <!-- End comment box -->
                </div>
                @endif
            @endif
        @endif
    @else
        <div class="card gedf-card-post">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $post->waller->profile_image)}}" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0"><a href="{{route('profile', [$post->waller_id])}}" class="card-link text-muted" title="profile">{{$post->waller->name}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->name}}</a></div>
                            @if(\auth::check())
                                @if(auth()->user()->id == $post->waller_id)
                                    <div class="h7">@<a href="/message" class="card-link" title="Inbox">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                @elseif(auth()->user()->id == $post->user_id)
                                    <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->waller_id}}">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="/message" class="card-link" title="Inbox">{{$post->username}}</a></div>
                                @else
                                    <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->waller_id}}">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                @endif
                            @else
                                <div class="h7">@<a href="#" class="card-link">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link">{{$post->username}}</a></div>
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
                                @if(auth()->user()->id == $post->waller_id)
                                    <div class="h6 dropdown-header">Configuration</div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDel{{$post->id}}">Delete</a>   
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
                    <a class="card-link text-primary" style="cursor: pointer;">
                        <i class="fa fa-gittip"></i> Like
                    </a>  
                @endif              

                <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span>
                <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                    <i class="fa fa-comment"></i> Comment
                </a>

                <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i>{{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
            </div>

            <!-- Comment box -->
            <div class="card-footer d-none" id="show-{{$post->id}}">
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
                    <hr style="margin-bottom:5px; margin-top:5px;">
                    <span class="text-primary h7">
                        <a href="/posts/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                    </span>
                    <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                @else
                    <p>No comment</p>
                @endif
            </div>
            <!-- End comment box -->

            <!-- Hidden message -->
                <div class="modal fade" id="contact{{$post->user_id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
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
                                        {{Form::text('receiver', $post->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                                        {{ Form::hidden('receiver_id', $post->user_id) }}
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
                                        {{ Form::hidden('receiver_id', $post->waller_id) }}
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
@endforeach