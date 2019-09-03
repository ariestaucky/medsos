@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    @include('inc.alert')
        <div class="col-md-3">
            <div class="card">
                <div class="card hovercard">
                    <div class="cardheader">
                        <img src="{{ asset('/public/bg_images/default-background.jpg') }}">
                    </div>
                    <div class="avatar">
                        <img alt="" src="{{asset('/public/cover_image/' . auth()->user()->profile_image)}}">
                    </div>
                </div>

                <div class="card-body">
                    <div class="h5">
                        @<a href="{{route('dashboard')}}" title="Dashboard">{{auth()->user()->username}}</a>
                    </div>
                    <div class="h7 text-muted">
                        Fullname : {{strtoupper(auth()->user()->name)}}
                    </div>
                    <div class="h7">
                        {{Auth()->user()->job}}
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted">Poster</div>
                        <div class="h5">{{$post_count}}</div>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted">Followers</div>
                        <a href="/follower/{{auth()->user()->id}}" class="card-link">
                            <div class="h5">{{auth()->user()->followers()->count()}}</div>
                        </a>
                    </li>
                    <li class="list-group-item">    
                        <div class="h6 text-muted">Following</div>
                        <a href="/following/{{auth()->user()->id}}" class="card-link">
                            <div class="h5">{{auth()->user()->following()->count()}}</div>
                        </a>
                    </li>
                    <li class="list-group-item">medsos @2019</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6 gedf-main">
            <div class="card gedf-card suggestion">
                <div class="container">
                    <div class="row">
                        <div class="slide" style="overflow-x: auto;">
                            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                <ol class='carousel-indicators'>
                                    @foreach($friend as $friends)
                                    <li data-target='#carousel-custom' class='active'>
                                        <a href="{{route('profile', [$friends->id])}}" class="card-link text-primary">
                                            <img src="{{asset('/public/cover_image/' . $friends->profile_image)}}" alt='' />
                                            <br>
                                            <span>{{$friends->name}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--- \\\\\\\Post-->
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

            <!--- \\\\\\\Post-->
            <div class="infinite-scroll" data-next-page="{{ $post->nextPageUrl() }}">
                @foreach($post as $poster)
                    @if($poster->waller_id == null)
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
                                                        @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $poster->id)->where('pos_type', 'App\Post')->first())
                                                            <a class="dropdown-item" href="/poster/unfavorite/{{$poster->id}}">UnFavorite</a> 
                                                        @else
                                                            <a class="dropdown-item" href="/poster/favorite/{{$poster->id}}">Save as Favorite</a>
                                                        @endif   
                                                        
                                                        @if(auth()->user()->isBlocking(App\Post::find($poster->id)))
                                                        <a class="dropdown-item" href="/poster/unblock/{{$poster->id}}">Unblock</a>
                                                        @else
                                                        <a class="dropdown-item" href="/poster/block/{{$poster->id}}">Block</a>
                                                        @endif
                                                        
                                                        @if(auth()->user()->report()->where('reported_id', $poster->id)->where('reported_type', 'App\Post')->first())
                                                        <a class="dropdown-item default-cursor">Reported</a>
                                                        @else
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$poster->id}}">Report</a>     
                                                        @endif
                                                    @else
                                                        @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $poster->id)->where('pos_type', 'App\Image')->first())
                                                            <a class="dropdown-item" href="/image/unfavorite/{{$poster->id}}">UnFavorite</a> 
                                                        @else
                                                            <a class="dropdown-item" href="/image/favorite/{{$poster->id}}">Save as Favorite</a>
                                                        @endif 

                                                        @if(auth()->user()->isBlocking(App\Image::find($poster->id)))
                                                        <a class="dropdown-item" href="/image/unblock/{{$poster->id}}">Unblock</a>
                                                        @else
                                                        <a class="dropdown-item" href="/image/block/{{$poster->id}}">Block</a>
                                                        @endif
                                                        
                                                        @if(auth()->user()->report()->where('reported_id', $poster->id)->where('reported_type', 'App\Image')->first())
                                                        <a class="dropdown-item default-cursor">Reported</a> 
                                                        @else
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$poster->id}}">Report</a>
                                                        @endif
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
                                    
                                    <!-- Hidden del confirmation modal -->
                                    <div class="modal fade" id="confirmDelpos{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Confirmation</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p style="text-align:center;">Do you want to delete this poster?</p> 
                                                    <h4 class="text-primary" style="text-align:center;">{{$poster->content}}</h4>
                                                </div>
                                                <div class="modal-footer">   
                                                    {!!Form::open(['route' => ['post_delete', $poster->id], 'method' => 'POST'])!!}
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
                                    <div class="modal fade" id="editpos{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                                    <form method="post" action="{{ route('editpos', [$poster->id]) }}" id="editpost">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="sr-only" for="content">post</label>
                                                            <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$poster->content}}</textarea>
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
                                    <div class="modal fade" id="report{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
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
                                                    {{Form::hidden('post_id', $poster->id)}}   
                                                    {{Form::submit('Report', ['class' => 'btn btn-primary delete'])}}
                                                    {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                                </div>
                                                {!!Form::close()!!}   
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Hidden modal -->
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

                                    <!-- Hidden confirmation modal -->
                                    <div class="modal fade" id="confirmDel{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Delete Confirmation</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p style="text-align:center;">Do you want to delete this image?</p>
                                                    <br>
                                                    <h3 class="text-primary" style="text-align:center;">{{$poster->caption}}</h3>
                                                </div>
                                                <div class="modal-footer">
                                                    {!!Form::open(['route' => ['img_delete', $poster->id], 'method' => 'POST'])!!}
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
                                    <div class="modal fade" id="editcaption{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
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
                                                    <form method="post" action="{{ route('editcaption', [$poster->id]) }}" id="editcaption">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="sr-only" for="caption">post</label>
                                                            <textarea class="form-control" name="caption" id="caption" rows="3" placeholder="What are you thinking?">{{$poster->caption}}</textarea>
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
                                    <div class="modal fade" id="report{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
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
                                                    {{Form::hidden('post_id', $poster->id)}}   
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
                                @if($poster->images == null)            
                                    <a data-id="{{ $poster->id }}" id="like{{$poster->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($poster->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                        <i class="fa fa-gittip"></i> <span id="like{{$poster->id}}-bs3" class="thumb">{{ App\Post::find($poster->id)->likers()->get()->count() }}</span> Like
                                    </a>                
                                @else
                                    <a data-id="{{ $poster->id }}" id="love{{$poster->id}}" class="card-link text-primary panel-love {{ auth()->user()->hasLiked(App\Image::find($poster->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                        <i class="fa fa-gittip"></i> <span id="love{{$poster->id}}-bs3" class="thumb">{{ App\Image::find($poster->id)->likers()->get()->count() }}</span> Like
                                    </a>
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
                                    <a class="btn btn-link dropdown-toggle card-link text-primary" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                                        <i class="fa fa-comment"></i> Share
                                    </a>
                                    <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                        <div class="h6 dropdown-header">Share with</div>
                                        <a class="btn btn-primary social-facebook dropdown-item share share-button" href="{{route('show', $poster->id)}}" data-pos="{{$poster->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                        <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('share', $poster->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                                    </div>
                                @else
                                    <a class="btn btn-link dropdown-toggle card-link text-primary" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
                                        <i class="fa fa-comment"></i> Share
                                    </a>
                                    <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                        <div class="h6 dropdown-header">Share with</div>
                                        <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $poster->id)}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                        <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('sharing', $poster->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                                    </div>
                                @endif
                                <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($poster->posted)->diffforHumans()}}</div>
                            </div>

                            <!-- Comment box -->
                            @if($poster->images == null) 
                            <div class="card-footer d-none" id="show-{{$poster->id}}">
                                <form method="post" action="{{ route('comment') }}" id="comment-box" class="d-flex add-comment">
                                @csrf
                                    <div class="form-group col-sm-10 padat">
                                        <label class="sr-only" for="content">post</label>
                                        <input class="form-control" style="" name="content" id="content input-{{$poster->id}}" placeholder="What are you thinking?">
                                        <input type="hidden" name="post_id" value="{{ $poster->id }}" />
                                        <input type="hidden" name="user_id" value="{{ $poster->user_id }}" />
                                    </div>
                                    <div class="btn-group col-sm-2 padat segaris">
                                        <button type="submit" class="btn btn-primary segaris">Comment</button>
                                    </div>
                                </form>
                                @if(App\Post::find($poster->id)->comments()->count() > 0)
                                    @foreach(App\Post::find($poster->id)->comments()->get() as $comment)
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
                                                                {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
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
                                    <hr class="narrow-hr">
                                    <span class="text-primary h7">
                                        <a href="/posts/{{$poster->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                                    </span>
                                    <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                                @endif
                            </div>
                            @else
                            <div class="card-footer d-none" id="show-image-{{$poster->id}}">
                                <form method="post" action="{{ route('imagecomment') }}" id="comment" class="d-flex">
                                @csrf
                                    <div class="form-group col-sm-10 padat">
                                        <label class="sr-only" for="content">post</label>
                                        <input class="form-control" style="" name="content" id="content input-{{$poster->id}}" placeholder="What are you thinking?">
                                        <input type="hidden" name="post_id" value="{{ $poster->id }}" />
                                        <input type="hidden" name="user_id" value="{{ $poster->user_id }}" />
                                    </div>
                                    <div class="btn-group col-sm-2 padat segaris">
                                        <button type="submit" class="btn btn-primary img-add-comment" style="display:inline-table; width:inherit">Comment</button>
                                    </div>
                                </form>
                                @if(App\Image::find($poster->id)->comments()->count() > 0)
                                    @foreach(App\Image::find($poster->id)->comments()->get() as $comment)
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
                                                                {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
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
                                <hr class="narrow-hr">
                                <span class="text-primary h7">
                                    <a href="/Image/{{$poster->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                                </span>
                                <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                                @endif
                            </div>
                            @endif
                            <!-- End comment box -->

                            <!-- Hidden message -->
                            <div class="modal fade" id="contact{{$poster->user_id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
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
                                                    {{Form::text('receiver', $poster->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                                                    {{ Form::hidden('receiver_id', $poster->user_id) }}
                                                    {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
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

                            <!-- Hidden share -->
                            @if($poster->images == null) 
                            <div class="modal fade" id="share{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="share" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="contact">Share</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <button id="share-button" type="button" data-ref="{{route('show', $poster->id)}}">Share</button>
                                            <a class="btn btn-primary social-login-btn social-twitter" href=""><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="modal fade" id="share-{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="share" aria-hidden="true">
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
                                                    {{Form::text('receiver', $poster->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                                                    {{ Form::hidden('receiver_id', $poster->user_id) }}
                                                    {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- End hidden message -->
                        </div>
                    @else
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
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDel{{$poster->id}}">Delete</a>   
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editpos{{$poster->id}}">Edit</a>
                                                @else
                                                    <div class="h6 dropdown-header">Configuration</div>
                                                    @if(App\Favorite::where('user_id', auth()->user()->id)->where('pos_id', $poster->id)->where('pos_type', 'App\Post')->first())
                                                        <a class="dropdown-item" href="/poster/unfavorite/{{$poster->id}}">UnFavorite</a> 
                                                    @else
                                                        <a class="dropdown-item" href="/poster/favorite/{{$poster->id}}">Save as Favorite</a>
                                                    @endif
                                                    
                                                    @if(auth()->user()->isBlocking(App\Post::find($poster->id)))
                                                    <a class="dropdown-item" href="/poster/unblock/{{$poster->id}}">Unblock</a>
                                                    @else
                                                    <a class="dropdown-item" href="/poster/block/{{$poster->id}}">Block</a>
                                                    @endif
                                                    
                                                    @if(auth()->user()->report()->where('reported_id', $poster->id)->where('reported_type', 'App\Post')->first())
                                                    <a class="dropdown-item default-cursor">Reported</a>
                                                    @else
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$poster->id}}">Report</a>     
                                                    @endif  
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
                                
                                <!-- Hidden confirmation modal -->
                                <div class="modal fade" id="confirmDel{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p style="text-align:center;">Do you want to delete this?</p> 
                                            </div>
                                            <div class="modal-footer">   
                                                {!!Form::open(['route' => ['post_delete', $poster->id], 'method' => 'POST'])!!}
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
                                    <div class="modal fade" id="editpos{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-sm-6"> 
                                                        <h4 class="modal-title">Edit</h4>
                                                        <div class="h7 text-muted">You <i class="fa fa-angle-double-right" aria-hidden="true"></i> @<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$poster->user_id}}">{{$poster->username}}</a></div>
                                                    </div>
                                                    <div class="col-sm-6">         
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" action="{{ route('editpos', [$poster->id]) }}" id="editpost">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label class="sr-only" for="content">post</label>
                                                            <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$poster->content}}</textarea>
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
                                <div class="modal fade" id="report{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
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
                                                {{Form::hidden('post_id', $poster->id)}}   
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
                                
                                <a data-id="{{ $poster->id }}" id="like{{$poster->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($poster->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                    <i class="fa fa-gittip"></i> <span id="like{{$poster->id}}-bs3" class="thumb">{{ App\Post::find($poster->id)->likers()->get()->count() }}</span> Like
                                </a>                

                                
                                <a data-id="{{ $poster->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                                    <i class="fa fa-comment"></i> <span id="komen{{$poster->id}}-post" class="thumb">{{ App\Post::find($poster->id)->comments()->count() }}</span> Comment
                                </a>
                
                                <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($poster->posted)->diffforHumans()}}</div>
                            </div>

                            <!-- Comment box -->
                            <div class="card-footer d-none" id="show-{{$poster->id}}">
                                <form method="post" action="{{ route('comment') }}" id="comment-box" class="d-flex add-comment">
                                @csrf
                                    <div class="form-group col-sm-10 padat">
                                        <label class="sr-only" for="content">post</label>
                                        <input class="form-control" style="" name="content" id="content input-{{$poster->id}}" placeholder="What are you thinking?">
                                        <input type="hidden" name="post_id" value="{{ $poster->id }}" />
                                        <input type="hidden" name="user_id" value="{{ $poster->user_id }}" />
                                    </div>
                                    <div class="btn-group col-sm-2 padat segaris">
                                        <button type="submit" class="btn btn-primary segaris">Comment</button>
                                    </div>
                                </form>
                                @if(App\Post::find($poster->id)->comments()->count() > 0)
                                    @foreach(App\Post::find($poster->id)->comments()->get() as $comment)
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
                                                                {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
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
                                        <a href="/posts/{{$poster->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
                                    </span>
                                    <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
                                @endif
                            </div>
                            <!-- End comment box -->

                            <!-- Hidden message -->
                            <div class="modal fade" id="contact{{$poster->user_id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
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
                                                    {{Form::text('receiver', $poster->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                                                    {{ Form::hidden('receiver_id', $poster->user_id) }}
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
                            <div class="modal fade" id="contact{{$poster->waller_id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
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
                                                    {{Form::text('receiver', $poster->waller->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                                                    {{ Form::hidden('receiver_id', $poster->waller_id) }}
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

                {!! $post->links() !!}
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

        <div class="col-md-3"> 
            <!-- Theme -->
            <div class="card gedf-card">
                <div class="card-header">
                    <h4 class="h5 text-muted"><i class="fa fa-calendar text-dark" aria-hidden="true"></i> Light / Dark Theme</h4>
                    <div class="toggle-container">
                        <input type="checkbox" id="switch" name="theme" /><label for="switch"> Switch</label>
                    </div>
                </div>
            </div>
            <!-- Date -->
            <div class="card gedf-card">
                <div class="card-header">
                    <h4 class="h5 text-muted"><i class="fa fa-calendar text-dark" aria-hidden="true"></i> Today is</h4>
                </div>
                <div class="card-body text-center">
                    {{date('d-m-Y')}}
                    <hr>
                    @switch($dayofweek = date("w"))
                        @case(1)
                            <span class="text-muted h2"> Monday</span>
                            @break

                        @case(2)
                            <span class="text-muted h2"> Tuesday</span>
                            @break

                        @case(3)
                            <span class="text-muted h2"> Wednesday</span>
                            @break;

                        @case(4)
                            <span class="text-muted h2"> Thrusday</span>
                            @break;

                        @case(5)
                            <span class="text-muted h2"> Friday</span>
                            @break;

                        @case(6)
                            <span class="text-primary h2"> Saturday</span>
                            @break;

                        @case(0)
                            <span class="text-danger h2"> SUNDAY</span>
                            @break;
                    @endswitch
                </div>
            </div>
            <!-- Most follower -->
            <div class="card gedf-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-user-circle"></i> Most Popular User</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    @foreach($all->sortBydesc('follower')->take(3) as $popular)
                        <div class="col-md-12 col-sm-12 col-xs-12 parent-chip text-center">
                            <div class="border"></div>
                            <div class="card-body no-padding chip w-100">
                                <img class="card-img-top" style="margin-right:10px" src="{{asset('/public/cover_image/' . $popular->profile_image)}}" alt="Card image cap">
                                <div class="row">
                                    <p class="text-left text-primary w-100 default-cursor">{{$popular->name}}</p>
                                    <a href="/follower/{{$popular->id}}" class="card-link"><span class="text-dark text-center" id="side-counter-{{$popular->id}}">{{$popular->follower}}</span>&nbsp; Followers
                                </div></a>
                                <hr class="narrow-hr">
                                <a href="{{route('profile', [$popular->id])}}" class="card-link">Profile</a>
                                @if(auth()->user()->id != $popular->id)
                                    <a data-id="{{$popular->id}}" class="text-primary pointer card-link sidebar-follower">{{ auth()->user()->isFollowing($popular) ? 'Following' : 'Follow' }}</a>
                                @else
                                    <a href="/message" class="card-link">Inbox</a> 
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!--  -->
            <!-- <div class="card gedf-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-gittip"></i> Most Favorite Poster</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div> -->
            <!-- footer -->
            <div class="p-3 mb-3 bg-light rounded">
                <small class="mb-0">
                    <ul class="list-inline text-center">
                        <li class="list-inline-item"><a href="/about">About</a></li>
                        <li class="list-inline-item"><a href="/blog">Blog</a></li>
                        <li class="list-inline-item"><a href="/cookie">Cookies</a></li>
                        <li class="list-inline-item"><a href="/ToS">Term of Service</a></li>
                        <li class="list-inline-item"><a href="/policies">Privacy Policy</a></li>
                        <li class="list-inline-item"><a href="/contact-us">Contact Us</a></li>
                    </ul>
                    <p class="text-center">medsos @2019</p>
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
