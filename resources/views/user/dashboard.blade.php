@extends('layouts.app')

@section('content')
    <div class="container main-secction">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 image-section">
                <img src="{{ asset('/public/bg_images/' .auth()->user()->bg_image) }}">
            </div>
            <div class="row user-left-part">
                <div class="col-md-3 col-sm-3 col-xs-12 user-profil-part pull-left">
                    <div class="row ">
                        <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                            <img src="{{asset('/public/cover_image/' . auth()->user()->profile_image)}}" class="rounded-circle">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                            <h4 class="follow">{{strtoupper(auth()->user()->name)}}</h4>
                            <p>{{auth()->user()->job}}</p>
                            <a href="/profile/{{auth()->user()->id}}"><button id="btn-contact" class="btn btn-primary btn-block">Profile</button></a> 
                        </div>
                        <div class="row user-detail-row">  
                            <div class="col-md-6 col-xs-6 user-detail-section2 pull-left">
                                <div class="border"></div>
                                <p>FOLLOWER</p>
                                <a href="/follower/{{auth()->user()->id}}" class="card-link"><span>{{auth()->user()->followers()->count()}}</span></a>
                            </div>   
                            <div class="col-md-6 col-xs-6 user-detail-section2 pull-right">
                                <div class="border"></div>
                                <p>FOLLOWING</p>
                                <a href="/following/{{auth()->user()->id}}" class="card-link"><span>{{auth()->user()->following()->count()}}</span></a>
                            </div>                         
                        </div>   
                        <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section2 text-center">
                            <div class="border"></div>    
                            <p>VISITOR COUNT</p>
                            <span>{{auth()->user()->page_view}}</span> 
                        </div>
                        
                        @foreach($visitor as $loyal)
                                @if($loyal->view > 10)
                                    <div class="col-md-12 col-sm-12 col-xs-12 parent-chip text-center">
                                        <div class="border"></div>
                                        <p>This Weeks</p>
                                        <div class="card-body no-padding chip w-100">
                                            <img class="card-img-top" style="margin-right:10px" src="{{asset('/public/cover_image/' . $loyal->user->profile_image)}}" alt="Card image cap">
                                            <p class="text-left text-primary"><a href="{{route('profile', [$loyal->user->id])}}">{{$loyal->user->name}}</a> <span class="text-dark">{{$loyal->total}}</span> Visit</p>
                                        </div>
                                    </div>
                               @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-7 col-sm-7 col-xs-12 profile-right-section">
                    @include('inc.alert')
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#poster" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> Your Poster</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#fav" role="tab" data-toggle="tab"><i class="fa fa-star" aria-hidden="true"></i> Favorite</a>
                        </li>  
                        <li class="nav-item">
                            <a class="nav-link" href="#buzz" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i> Album</a>
                        </li>                                       
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="poster">
                            <!--- \\\\\\\Post HEAD-->
                            <div class="card gedf-card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                                                a Poster</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Images</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                            <form method="post" action="{{ route('post') }}" id="post">
                                            @csrf
                                                <div class="form-group">
                                                    <label class="sr-only" for="content">post</label>
                                                    <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?"></textarea>
                                                </div>
                                                <div class="btn-toolbar justify-content-between">
                                                    <div class="btn-group">
                                                        <button type="submit" class="btn btn-primary">Share</button>
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
                                        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                            <form method="post" action="{{ route('upload') }}" id="post" enctype="multipart/form-data">
                                            @csrf
                                                <div class="form-group">
                                                    <label class="sr-only" for="caption"></label>
                                                    <input type="text" class="form-control" name="caption" id="caption" placeholder="Caption/Title">
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-file">
                                                        <label class="custom-file-label" for="customFile">
                                                            <i class="fa fa-cloud-upload"></i> Upload image
                                                        </label>
                                                        <input type="file" class="custom-file-input" id="customFile" name="image">
                                                    </div>
                                                </div>                                                    
                                                <div class="btn-toolbar justify-content-between">
                                                    <div class="btn-group">
                                                        <button type="submit" class="btn btn-primary">Share</button>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button id="btnGroupDrop2" type="button" class="btn btn-link dropdown-toggle pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                            <!-- Post /////-->

                            <!--- \\\\\\\Post BODY-->
                            <div class="infinite-scroll" data-next-page="{{ $poster->nextPageUrl() }}">
                                @foreach($poster as $post)
                                    @if($post->waller_id == null)
                                        <div class="card gedf-card-post">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="mr-2">
                                                            <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $post->profile)}}" alt="">
                                                        </div>
                                                        <div class="ml-2">
                                                            <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->name}}</a></div>
                                                            <div class="h7">@<a href="{{route('profile', [$post->user_id])}}" class="card-link" title="message">{{$post->username}}</a></div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-h"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                                <div class="h6 dropdown-header">Configuration</div>
                                                                @if($post->images == null)
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelpos{{$post->id}}">Delete</a>   
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$post->id}}">Edit</a>
                                                                @else
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDelimg{{$post->id}}">Delete</a>
                                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcaption{{$post->id}}">Edit</a>
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
                                                                    <p style="text-align:center;">Do you want to delete this image?</p>
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

                                                    <!-- Hidden edit modal -->
                                                    <div class="modal fade" id="editcaption{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                                                    <form method="post" action="{{ route('editcaption', [$post->id]) }}" id="editcaption">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label class="sr-only" for="caption">post</label>
                                                                            <textarea class="form-control" name="caption" id="caption" rows="3" placeholder="What are you thinking?">{{$post->caption}}</textarea>
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
                                                        <a href="/posts/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
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
                                                            @if(auth()->user()->id == $post->waller_id)
                                                                <div class="h7">@<a href="/message" class="card-link" title="Inbox">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                                            @elseif(auth()->user()->id == $post->user_id)
                                                                <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->waller_id}}">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="/message" class="card-link" title="Inbox">{{$post->username}}</a></div>
                                                            @else
                                                                <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->waller_id}}">{{$post->waller->username}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="dropdown">
                                                            <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-h"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                                @if(auth()->user()->id == $post->waller_id)
                                                                    <div class="h6 dropdown-header">Configuration</div>
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDel{{$post->id}}">Delete</a>   
                                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$post->id}}">Edit</a>
                                                                @else
                                                                    <div class="h6 dropdown-header">Configuration</div>
                                                                    <a class="dropdown-item" href="/poster/favorite/{{$post->id}}">Save as Favorite</a>   
                                                                    <a class="dropdown-item" href="#">Block</a>
                                                                    <a class="dropdown-item" href="#">Report</a>
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
                                            </div>
                                            <div class="card-footer">        
                                                <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span>
                                                <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                                    <i class="fa fa-gittip"></i> Like
                                                </a>                

                                                <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span>
                                                <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                                                    <i class="fa fa-comment"></i> Comment
                                                </a>
                                
                                                <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i>{{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
                                            </div>

                                            <!-- Comment box -->
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
                                                        <a href="/posts/{{$post->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                                                    </span>
                                                    <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
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
                                {{$poster->links()}}
                            </div>                                
                            <div class="row mx-auto" id="loaderDiv">
                                <a class="text-center mx-auto">
                                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span class="sr-only">Loading...</span>
                                </a>    
                            </div>                                
                            <div class="row mx-auto gedf-card-post" id="endpage">
                                <a class="text-center mx-auto text-muted">
                                    <i class="fa fa-ban" aria-hidden="true"></i> <span>No more post</span>
                                </a>    
                            </div>
                            <div class="row mx-auto" id="backtoTop">
                                <a class="text-center mx-auto" href="#app">
                                    <span>Back to top <i class="fa fa-level-up" aria-hidden="true"></i></span>
                                </a>    
                            </div>
                            <!-- Post /////-->
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="fav">
                            <div class="favorite" id="load-data" data-load-more="{{ $fav->nextPageUrl() }}">
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
                                {!! $fav->links() !!}
                            </div>     

                            <div class="row mx-auto">
                                <a href="#" id="loadMore" class="row mx-auto"><span>Load More</span></a>
                            </div>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane fade" id="buzz">
                            <div class="row">
                            @if(count($album) > 0)
                                @foreach($album->sortByDesc('created_at') as $image)
                                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                                    <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="{{$image->caption}}"
                                    data-image="{{asset('/public/user_album/' . $image->image)}}"
                                    data-target="#image-gallery">
                                        <img class="img-thumbnail zoom"
                                            src="{{asset('/public/user_album/' . $image->image)}}"
                                            alt="{{$image->image}}">
                                    </a>
                                </div>
                                @endforeach
                            @else
                                No Image found!
                            @endif    
                            </div>

                            <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="image-gallery-title"></h4>
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                                            </button>

                                            <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </div>            
                <div class="col-md-2 col-sm-2 col-xs-12 pull-right profile-right-section-add">
                    <div class="card gedf-card">
                        <div class="card-header">
                            <h4 class="text-center text-primary"><strong>VISITOR</strong></h4>
                        </div>
                        <div class="card-body text-center">
                        @if(count($visitor) > 0)
                            @foreach($visitor as $friend)
                            <div class="card-body no-padding">
                                <img class="card-img-top" src="{{asset('/public/cover_image/' . $friend->user->profile_image)}}" alt="Card image cap">
                                <div class="card-body-profile text-center">
                                    <a href="{{route('profile', [$friend->visitor])}}" class="card-link text-primary w-100"><h6>{{$friend->user->name}}</h6></a>
                                    <small>{{$friend->created_at->diffforHumans()}}</small>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        @else
                            <p>No one visiting your profile!</p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contact">Contactarme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <p for="msj">Se enviará este mensaje a la persona que desea contactar, indicando que te quieres comunicar con el. Para esto debes de ingresar tu información personal.</p>
                    </div>
                    <div class="form-group">
                        <label for="txtFullname">Nombre completo</label>
                        <input type="text" id="txtFullname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="txtEmail">Email</label>
                        <input type="text" id="txtEmail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="txtPhone">Teléfono</label>
                        <input type="text" id="txtPhone" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection