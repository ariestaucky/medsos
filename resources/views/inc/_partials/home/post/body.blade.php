<div class="card gedf-card-post">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mr-2">
                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $poster->profile)}}" alt="">
                </div>
                <div class="ml-2">
                    <div class="h5 m-0"><a href="{{route('profile', [$poster->user_id])}}" class="card-link text-muted" title="profile">{{$poster->name}}</a></div>
                    @if(auth()->user()->id != $poster->user_id)
                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->user_id}}">{{$poster->username}}</a></div>
                    @else
                        <div class="h7">@<a href="/message" class="card-link" title="Inbox">{{$poster->username}}</a></div>
                    @endif
                </div>
            </div>
            <div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                        @if(auth()->user()->id == $poster->user_id)
                            <div class="h6 dropdown-header">Configuration</div>
                            @if($poster->images == null)
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$poster->id}}">Delete</a>   
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$poster->id}}">Edit</a>
                            @else
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDel{{$poster->id}}">Delete</a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcaption{{$poster->id}}">Edit Caption</a>
                            @endif 
                        @else
                            <div class="h6 dropdown-header">Configuration</div>
                            @if($poster->images == null)
                                @include('inc._partials.config.one') 
                            @else
                                @include('inc._partials.config.two')
                            @endif  
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($poster->images == null)
            <p class="card-text default-cursor">
                {{$poster->content}}
            </p>
            
            @include('inc._partials.post.modal.del')
            @include('inc._partials.post.modal.edit')
            @include('inc._partials.post.modal.report')

        @else
            <a class="card-link pointer" data-toggle="modal" data-target="#pic{{$poster->id}}">
                <h5 class="card-title text-primary">{{$poster->caption}}</h5>
            </a>
            <img class="card-img-top gal pointer" src="{{asset('/public/user_album/' . $poster->images)}}" alt="photo" data-toggle="modal" data-target="#pic{{$poster->id}}" title="pic-{{$poster->id}}">

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
                            <h3 class="text-primary" style="text-align:center;">{{$poster->caption}}</h3>
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
            @include('inc._partials.pic.modal.edit')
            @include('inc._partials.pic.modal.report')

        @endif   
    </div>
    <div class="card-footer">
        @include('inc._partials.config.footer_1')
    </div>

    <!-- Comment box -->
    @if($poster->images == null) 
        @include('inc._partials.comment_box.post')
    @else
        @include('inc._partials.comment_box.image')
    @endif
    <!-- End comment box -->

    @include('inc._partials.home.msg')
    @include('inc._partials.home.share')

</div>