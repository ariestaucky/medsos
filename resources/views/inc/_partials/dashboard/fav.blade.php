<div class="favorite" id="load-data" data-load-more="{{ $fav->nextPageUrl() }}">
    @if(count($fav) > 0)
        @foreach($fav as $favorite)
        <!-- <p>{{$favorite->created_at->format('M, d')}}</p> -->
        <div class="card gedf-card-post">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="mr-2">
                            <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $favorite->owner->profile_image)}}" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0"><a href="{{route('profile', [$favorite->owner->id])}}" class="card-link text-muted" title="profile">{{$favorite->owner->name}}</a></div>
                            <div class="h7">@<a href="{{route('profile', [$favorite->owner->id])}}" class="card-link" title="message">{{$favorite->owner->username}}</a></div>
                        </div>
                    </div>
                    <div>
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                <div class="h6 dropdown-header">Configuration</div>
                                @if($favorite->post_type == 'App\Image')
                                    <a class="dropdown-item" href="/image/unfavorite/{{$favorite->pos_id}}">UnFavorite</a> 
                                @else
                                    <a class="dropdown-item" href="/poster/unfavorite/{{$favorite->pos_id}}">UnFavorite</a> 
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($favorite->pos_type == 'App\Post')
                    <p class="card-text">
                        {{$favorite->pos->content}}
                    </p>
                @else
                    <a class="card-link">
                        <h5 class="card-title text-primary">{{$favorite->pos->caption}}</h5>
                    </a>
                    <img class="card-img-top" src="{{asset('/public/user_album/' . $favorite->pos->image)}}" alt="" style="width:50%; display:block; margin-left:auto; margin-right: auto;" data-toggle="modal" data-target="#pic{{$favorite->pos->id}}" title="pic-{{$favorite->pos->id}}">

                    <!-- Pic -->
                    <div class="modal fade" id="pic{{$favorite->pos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <div class="col-sm-6">
                                        <h5 class="modal-title" id="contact">Picture</h5>
                                        <div class="h7 text-muted">Uploaded by {{$favorite->owner->name}}</div>
                                    </div>
                                    <div class="col-sm-6">         
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <img class="card-img-top" src="{{asset('/public/user_album/' . $favorite->pos->image)}}" alt="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" title="close">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Pic -->
                @endif   
            </div>
            <div class="card-footer">
                <div class="text-muted h7 mb-2 pull-right">Posted by {{$favorite->owner->name}} <i class="fa fa-clock-o"></i> {{$favorite->pos->created_at->diffforHumans()}}</div>
            </div>
        </div>
        @endforeach
    @else
        No Favorite data record!
    @endif
    {!! $fav->links() !!}
</div>   