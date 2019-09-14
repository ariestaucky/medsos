<div class="card gedf-card-post">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">
                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $poster->profile)}}" alt="">
                </div>
                <div class="ml-2">
                    @if(\auth::check())
                        <div class="h5 m-0"><a href="{{route('profile', [$poster->user_id])}}" class="card-link text-muted pointer" title="profile">{{$poster->name}}</a></div>
                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->user_id}}">{{$poster->username}}</a></div>
                    @else
                        <div class="h5 m-0"><a href="{{route('profile', [$poster->user_id])}}" class="card-link text-muted pointer" title="profile">{{$poster->name}}</a></div>
                        <div class="h7">@<a class="card-link">{{$poster->username}}</a></div>
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
                            @if(auth()->user()->id == $poster->user_id)
                                <div class="h6 dropdown-header">Configuration</div>
                                @if($poster->images == null)
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$poster->id}}">Delete</a>  
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$poster->id}}">Edit</a> 
                                @else
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelimg{{$poster->id}}">Delete</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcaption{{$poster->id}}">Edit</a>
                                @endif 
                            @else
                                <div class="h6 dropdown-header">Configuration</div>
                                @if($poster->images == null)
                                    @include('inc._partials.config.one')
                                @else
                                    @include('inc._partials.config.two')
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
        @if($poster->images == null)
            <p class="card-text">
                {{$poster->content}}
            </p>
            
            @include('inc._partials.post.modal.del')
            @include('inc._partials.post.modal.edit')
            @include('inc._partials.post.modal.report')

        @else
            <a class="card-link">
                <h5 class="card-title text-primary">{{$poster->caption}}</h5>
            </a>
            <img class="card-img-top" src="{{asset('/public/user_album/' . $poster->images)}}" alt="" style="width:50%; display:block; margin-left:auto; margin-right: auto;" data-toggle="modal" data-target="#pic{{$poster->id}}" title="pic-{{$poster->id}}">

            <!-- Pic -->
                <div class="modal fade" id="pic{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="col-sm-6">
                                    <h5 class="modal-title" id="contact">Picture</h5>
                                    <div class="h7 text-muted">Uploaded by {{$poster->name}}</div>
                                </div>
                                <div class="col-sm-6">         
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <img class="card-img-top" src="{{asset('/public/user_album/' . $poster->images)}}" alt="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" title="close">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- End Pic -->

            @include('inc._partials.pic.modal.del')
            @include('inc._partials.pic.modal.report')

        @endif   
    </div>
    <div class="card-footer">
        @if(\auth::check())
            @if($poster->images == null)            
                <a data-id="{{ $poster->id }}" id="like{{$poster->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($poster->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                    <i class="fa fa-gittip"></i> <span id="like{{$poster->id}}-bs3" class="thumb">{{ App\Post::find($poster->id)->likers()->get()->count() }}</span> Like
                </a>                
            @else
                <a data-id="{{ $poster->id }}" id="love{{$poster->id}}" class="card-link text-primary panel-love {{ auth()->user()->hasLiked(App\Image::find($poster->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                    <i class="fa fa-gittip"></i> <span id="love{{$poster->id}}-bs3" class="thumb">{{ App\Image::find($poster->id)->likers()->get()->count() }}</span> Like
                </a>
            @endif
        @else
            @if($poster->images == null)            
                <a class="card-link text-primary pointer">
                    <i class="fa fa-gittip"></i> <span id="like{{$poster->id}}-bs3" class="thumb">{{ App\Post::find($poster->id)->likers()->get()->count() }}</span> Like
                </a>                
            @else
                <a class="card-link text-primary pointer">
                    <i class="fa fa-gittip"></i> <span id="love{{$poster->id}}-bs3" class="thumb">{{ App\Image::find($poster->id)->likers()->get()->count() }}</span> Like
                </a>
            @endif
        @endif

        @if($poster->images == null) 
            <a data-id="{{ $poster->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                <i class="fa fa-comment"></i> <span id="komen{{$poster->id}}-post" class="thumb">{{ App\Post::find($poster->id)->comments()->count() }}</span> Comment
            </a>
        @else
            <a data-id="{{ $poster->id }}" class="card-link text-primary panel-image" style="cursor: pointer;">
                <i class="fa fa-comment"></i> <span id="komen{{$poster->id}}-image" class="thumb">{{ App\Image::find($poster->id)->comments()->count() }}</span> Comment
            </a>
        @endif

        @if($poster->images == null)                                   
            <a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                <i class="fa fa-share"></i> Share
            </a>
            <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                <div class="h6 dropdown-header">Share with</div>
                {{-- <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $poster->id)}}" data-pos="{{$poster->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a> --}}
                <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('share', $poster->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
            </div>
        @else
            <a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                <i class="fa fa-share"></i> Share
            </a>
            <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                <div class="h6 dropdown-header">Share with</div>
                {{-- <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $poster->id)}}" data-pos="{{$poster->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a> --}}
                <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('sharing', $poster->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
            </div>
        @endif
        <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($poster->posted)->diffforHumans()}}</div>
    </div>

    <!-- Comment box -->
    @if($poster->images == null) 
        @include('inc._partials.comment_box.post')
    @else
        @include('inc._partials.comment_box.image')
    @endif
    <!-- End comment box -->

</div>