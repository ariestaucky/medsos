<div class="card gedf-card-post">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">
                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $poster->waller->profile_image)}}" alt="">
                </div>
                <div class="ml-2">
                    <div class="h5 m-0"><a href="{{route('profile', [$poster->waller_id])}}" class="card-link text-muted" title="profile">{{$poster->waller->name}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{route('profile', [$poster->user_id])}}" class="card-link text-muted" title="profile">{{$poster->name}}</a></div>
                    @if(auth()->user()->id == $poster->waller_id)
                        <div class="h7">@<a href="/message" class="card-link" title="Inbox">{{$poster->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->user_id}}">{{$poster->username}}</a></div>
                    @elseif(auth()->user()->id == $poster->user_id)
                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->waller_id}}">{{$poster->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="/message" class="card-link" title="Inbox">{{$poster->username}}</a></div>
                    @else
                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->waller_id}}">{{$poster->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->user_id}}">{{$poster->username}}</a></div>
                    @endif
                </div>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                        @if(auth()->user()->id == $poster->waller_id)
                            <div class="h6 dropdown-header">Configuration</div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$poster->id}}">Delete</a>   
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$poster->id}}">Edit</a>
                        @else
                            <div class="h6 dropdown-header">Configuration</div>
                            @include('inc._partials.config.one') 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p class="card-text">
            {{$poster->content}}
        </p>
        
        @include('inc._partials.post.modal.del')
        @include('inc._partials.post.modal.edit')
        @include('inc._partials.post.modal.report')

    </div>
    <div class="card-footer">        
        
        <a data-id="{{ $poster->id }}" id="like{{$poster->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($poster->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
            <i class="fa fa-gittip"></i> <span id="like{{$poster->id}}-bs3" class="thumb">{{ App\Post::find($poster->id)->likers()->get()->count() }}</span> Like
        </a>                

        
        <a data-id="{{ $poster->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
            <i class="fa fa-comment"></i> <span id="komen{{$poster->id}}-post" class="thumb">{{ App\Post::find($poster->id)->comments()->count() }}</span> Comment
        </a>

        <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($poster->posted)->diffforHumans()}}</div>
    </div>

    <!-- Comment box -->
    @include('inc._partials.comment_box.post')
    <!-- End comment box -->

    @include('inc._partials.home.msg')
    @include('inc._partials.home.msg_waller')

</div>