@extends('layouts.app')

@section('content')
    <div class="container main-secction">
        <div class="row">
            @include('inc.alert')
            <div class="col-md-12 col-sm-12 col-xs-12 image-section">
                @if(\auth::check()) 
                    @if(auth()->user()->id == $user->id)
                    <i class="fa fa-camera fa-2x position-absolute pointer corner" data-id="{{auth()->user()->id}}" onclick="document.getElementById('imgupload').click()">
                        <form method="POST" id="upload-form" name="upload-form" enctype="multipart/form-data"action="">
                            <input type="file" name="bg-pic" id="imgupload" class="d-none" />
                        </form>
                    </i>
                    @endif
                @endif
                <img id="background-image" data-image="{{ asset('/public/bg_images/' .$user->bg_image) }}" src="{{ asset('/public/bg_images/' .$user->bg_image) }}" class="">
                <div id="status"></div>
            </div>
            <div class="row user-left-part">
                <div class="col-md-3 col-sm-3 col-xs-12 user-profil-part pull-left">
                    <div class="row ">
                        <div class="col-md-12 col-md-12-sm-12 col-xs-12 user-image text-center">
                            <img src="{{asset('/public/cover_image/' . $user->profile_image)}}" class="rounded-circle">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 user-detail-section1 text-center">
                            @if(\auth::check())
                                @if(auth()->user()->id == $user->id)
                                <a href="/message" class="btn btn-success btn-block follow">Message</a> 
                                @else
                                <button id="btn-contact" data-toggle="modal" data-target="#contact{{$user->id}}" class="btn btn-success btn-block follow">Message</button>
                                @endif
                                <div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
                                    <div class="h6 dropdown-header">Share it</div>
                                    <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('profile', $user->id)}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                                    <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('shareIt', $user->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                                </div>
                            @else
                                <a href="{{route('login')}}" class="btn btn-primary btn-block" style="margin-top: 70px;">Login</a>
                            @endif
                        </div>
                        <div class="row user-detail-row">  
                            <div class="col-md-6 col-xs-6 user-detail-section2 pull-left">
                                <div class="border"></div>
                                <p>FOLLOWER</p>
                                @if(\auth::check())
                                <a href="/follower/{{$user->id}}" class="card-link"><span id="follower-counter">{{$user->followers()->count()}}</span></a>
                                @else
                                <a class="card-link text-muted default-cursor"><span id="follower-counter">{{$user->followers()->count()}}</span></a>
                                @endif
                            </div>   
                            <div class="col-md-6 col-xs-6 user-detail-section2 pull-right">
                                <div class="border"></div>
                                <p>FOLLOWING</p>
                                @if(\auth::check())
                                <a href="/following/{{$user->id}}" clas="card-link"><span>{{$user->following()->count()}}</span></a>
                                @else
                                <a class="card-link text-muted default-cursor"><span>{{$user->following()->count()}}</span></a>
                                @endif
                            </div>                         
                        </div>   
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12 pull-right profile-right-section">
                    <div class="row profile-right-section-row">
                        <div class="col-md-12 profile-header">
                            <div class="row">
                                <div class="col-md-8 col-sm-6 col-xs-6 profile-header-section1 pull-left">
                                    <h1>{{strtoupper($user->name)}}</h1>
                                    @if(($user->address && $user->city && $user->country) == null)
                                        <h5>Unknown location</h5>
                                    @else
                                        <h5>{{$user->address}}, {{$user->city}}, {{$user->country}}</h5>
                                    @endif

                                    @if($user->motto == null)
                                        @if(\auth::check())
                                            @if(auth()->user()->id != $user->id)
                                                <blockquote class="blockquote text-right">
                                                    <p class="mb-0">This user doesn't have motto</p>
                                                    <span class="blockquote-footer">From <cite title="Source Title">Webmaster</cite></span>
                                                </blockquote>
                                            @else
                                                <blockquote class="blockquote text-right">
                                                    <p class="mb-0">Your motto goes here</p>
                                                    <span class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></span>
                                                </blockquote>
                                            @endif
                                        @else
                                            <blockquote class="blockquote text-right">
                                                    <p class="mb-0">Your motto goes here</p>
                                                    <span class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></span>
                                            </blockquote>
                                        @endif
                                    @else
                                        <blockquote class="blockquote text-right">
                                            <p class="mb-0">{{ $user->motto }}</p>
                                            <span class="blockquote-footer">From <cite title="Source Title">{{ $user->name }}</cite></span>
                                        </blockquote>
                                    @endif
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-6 profile-header-section1 text-right pull-rigth">
                                    @if(\auth::check())
                                        @if(auth()->user()->id == $user->id)
                                        <a href="/edit/{{$user->id}}" class="btn btn-primary btn-block">Edit</a>
                                        @else
                                        <a class="btn {{ auth()->user()->isFollowing($user) ? 'btn-success' : 'btn-primary' }} btn-block text-white  action-follow" data-id="{{ $user->id }}"><strong>{{ auth()->user()->isFollowing($user) ? 'Following' : 'Follow' }}</strong></a>
                                        @endif
                                    @else
                                        <a href="{{route('login')}}" class="btn btn-primary btn-block">Login</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-9">
                                    <ul class="nav nav-tabs" role="tablist">
                                        @if(\auth::check())
                                            @if(auth()->user()->id != $user->id)
                                            <li class="nav-item">
                                                <a class="nav-link {{ auth()->user()->id != $user->id ? 'active' : '' }}" href="#poster" role="tab" data-toggle="tab"><i class="fa fa-calendar-o"></i> Poster</a>
                                            </li>
                                            @endif
                                            <li class="nav-item">
                                                <a class="nav-link {{ auth()->user()->id == $user->id ? 'active' : '' }}" href="#profile" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> Personal Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#fav" role="tab" data-toggle="tab"><i class="fa fa-star"></i> Favorite</a>
                                            </li>  
                                            <li class="nav-item">
                                                <a class="nav-link" href="#buzz" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i> Album</a>
                                            </li>  
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#poster" role="tab" data-toggle="tab"><i class="fa fa-calendar-o"></i> Poster</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#profile" role="tab" data-toggle="tab"><i class="fa fa-info-circle"></i> Personal Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#fav" role="tab" data-toggle="tab"><i class="fa fa-star"></i> Favorite</a>
                                            </li>  
                                            <li class="nav-item">
                                                <a class="nav-link" href="#buzz" role="tab" data-toggle="tab"><i class="fa fa-picture-o"></i> Album</a>
                                            </li>  
                                        @endif                                    
                                    </ul>
                                              
                                    <!-- Tab panes -->
                                    <div class="tab-content" style="margin-top:15px;">  
                                    @if(\auth::check())     
                                        <div role="tabpanel" class="tab-pane fade {{ auth()->user()->id != $user->id ? 'show active' : '' }}" id="poster">          
                                    @else
                                        <div role="tabpanel" class="tab-pane fade show active" id="poster">          
                                    @endif
                                        @if(\auth::check())
                                            <!--- \\\\\\\Post-->
                                            <div class="card gedf-card">
                                                <div class="card-header">
                                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                                                                a Wall</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                                            <form method="post" action="{{ route('wall', [$user->id]) }}" id="post">
                                                            @csrf
                                                                <div class="form-group">
                                                                    <label class="sr-only" for="content">post</label>
                                                                    <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?"></textarea>
                                                                </div>
                                                                <div class="btn-toolbar justify-content-between">
                                                                    <div class="btn-group">
                                                                        <button type="submit" class="btn btn-primary">Create</button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            <i class="fa fa-globe"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                                                            <a class="dropdown-item" href="#"><i class="fa fa-globe"></i> Public</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>                    
                                                </div>
                                            </div>
                                            <!-- Post /////-->
                                        @endif    

                                            <!--- \\\\\\\Post-->
                                            @if(count($poster) > 0)
                                                <div class="infinite-scroll" data-next-page="{{ $poster->nextPageUrl() }}">
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
                                                                                        <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted pointer" title="profile">{{$post->name}}</a></div>
                                                                                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact{{$post->user_id}}">{{$post->username}}</a></div>
                                                                                    @else
                                                                                        <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted pointer" title="profile">{{$post->name}}</a></div>
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
                                                                                <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                                                                    <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                                                                                </a>                
                                                                            @else
                                                                                <a data-id="{{ $post->id }}" id="love{{$post->id}}" class="card-link text-primary panel-love {{ auth()->user()->hasLiked(App\Image::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                                                                    <i class="fa fa-gittip"></i> <span id="love{{$post->id}}-bs3" class="thumb">{{ App\Image::find($post->id)->likers()->get()->count() }}</span> Like
                                                                                </a>
                                                                            @endif
                                                                        @else
                                                                            @if($post->images == null)            
                                                                                <a class="card-link text-primary pointer">
                                                                                    <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                                                                                </a>                
                                                                            @else
                                                                                <a class="card-link text-primary pointer">
                                                                                    <i class="fa fa-gittip"></i> <span id="love{{$post->id}}-bs3" class="thumb">{{ App\Image::find($post->id)->likers()->get()->count() }}</span> Like
                                                                                </a>
                                                                            @endif
                                                                        @endif

                                                                        @if($post->images == null) 
                                                                            <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                                                                                <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span> Comment
                                                                            </a>
                                                                        @else
                                                                            <a data-id="{{ $post->id }}" class="card-link text-primary panel-image" style="cursor: pointer;">
                                                                                <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-image" class="thumb">{{ App\Image::find($post->id)->comments()->count() }}</span> Comment
                                                                            </a>
                                                                        @endif
                                                                        <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
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
                                                                                        <div class="h5 m-0"><a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted pointer" title="profile">{{$post->name}}</a></div>
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
                                                                                <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                                                                    <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                                                                                </a>                
                                                                            @else
                                                                                <a data-id="{{ $post->id }}" id="love{{$post->id}}" class="card-link text-primary panel-love {{ auth()->user()->hasLiked(App\Image::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                                                                    <i class="fa fa-gittip"></i> <span id="love{{$post->id}}-bs3" class="thumb">{{ App\Image::find($post->id)->likers()->get()->count() }}</span> Like
                                                                                </a>
                                                                            @endif

                                                                            @if($post->images == null) 
                                                                                <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                                                                                    <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span> Comment
                                                                                </a>
                                                                            @else
                                                                                <a data-id="{{ $post->id }}" class="card-link text-primary panel-image" style="cursor: pointer;">
                                                                                    <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-image" class="thumb">{{ App\Image::find($post->id)->comments()->count() }}</span> Comment
                                                                                </a>
                                                                            @endif
                                                                            <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
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
                                                                                <div class="h5 m-0"><a href="{{route('profile', [$post->waller_id])}}" class="card-link text-muted pointer" title="profile">{{$post->waller->name}}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="{{route('profile', [$post->user_id])}}" class="card-link text-muted" title="profile">{{$post->name}}</a></div>
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
                                                                    <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span>
                                                                    @if(\auth::check())
                                                                        <a data-id="{{ $post->id }}" id="like{{$post->id}}" class="card-link text-primary panel-like {{ auth()->user()->hasLiked(App\Post::find($post->id)) ? 'like-post' : '' }}" style="cursor: pointer;">
                                                                            <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                                                                        </a>  
                                                                    @else
                                                                        <a class="card-link text-primary" style="cursor: pointer;">
                                                                            <i class="fa fa-gittip"></i> <span id="like{{$post->id}}-bs3" class="thumb">{{ App\Post::find($post->id)->likers()->get()->count() }}</span> Like
                                                                        </a>  
                                                                    @endif              
                                                                    
                                                                    <a data-id="{{ $post->id }}" class="card-link text-primary panel-comment" style="cursor: pointer;">
                                                                        <i class="fa fa-comment"></i> <span id="komen{{$post->id}}-post" class="thumb">{{ App\Post::find($post->id)->comments()->count() }}</span> Comment
                                                                    </a>

                                                                    <div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($post->posted)->diffforHumans()}}</div>
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
                                            @else
                                                Poster not found!
                                            @endif
                                            <!-- Post /////-->
                                        </div>   
                                          

                                        @if(\auth::check())
                                            <div role="tabpanel" class="tab-pane fade {{ auth()->user()->id == $user->id ? 'show active' : '' }}" id="profile">
                                        @else
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                                        @endif
                                                <h4>Description</h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <fieldset>
                                                        @if($user->bio == null)
                                                            <p>No description</p>
                                                        @else
                                                            <p>"{{$user->bio}}"</p>
                                                        @endif
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h4>Basic Info</h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Username</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->username}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>First Name</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->fname}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Last Name</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->lname}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Email</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->email}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Nationality</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->country}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Profession</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->job}}</p>
                                                    </div>
                                                </div>
                                                <hr>

                                                <h4>Personal Info</h4>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Gender</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->gender}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Birthday</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->bday}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Status</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->status}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Join date</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->created_at}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Last seen</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>: {{$user->updated_at->diffforHumans()}}</p>
                                                    </div>
                                                </div>
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
                                                                        <div class="h7">@<a href="#" class="card-link" title="message" data-toggle="modal" data-target="#contact_fav{{$favorite->owner->id}}">{{$favorite->owner->username}}</a></div>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-ellipsis-h"></i>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                                                            <div class="h6 dropdown-header">Configuration</div>
                                                                            @if(\auth::check())
                                                                                @if(auth()->user()->id == $favorite->user_id)
                                                                                    @if($favorite->post_type == 'App\Image')
                                                                                        <a class="dropdown-item" href="/image/unfavorite/{{$favorite->pos_id}}">UnFavorite</a> 
                                                                                    @else
                                                                                        <a class="dropdown-item" href="/poster/unfavorite/{{$favorite->pos_id}}">UnFavorite</a> 
                                                                                    @endif
                                                                                @endif
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
                                                            <div class="text-muted h7 mb-2 pull-right"><i class="fa fa-clock-o"></i> {{$favorite->pos->created_at->diffforHumans()}}</div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="contact_fav{{$favorite->owner->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                            {{Form::text('receiver', $favorite->owner->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                                                                            {{ Form::hidden('receiver_id', $favorite->owner->id) }}
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

                                <div class="col-md-3 img-main-rightPart hid">
                                    <div class="card gedf-card">
                                        <div class="card-header">
                                        @if($user->fname)
                                            <h4 class="text-center text-primary">{{ucfirst($user->fname)}}'s Follower</h4> 
                                        @else
                                            <h4 class="text-center text-primary">Follower</h4>
                                        @endif
                                        </div>
                                        <div class="card-body text-center">
                                        @if(count($friends) > 0)
                                            <h6 class="card-subtitle mb-2 text-muted">Most recent follower</h6>
                                            @foreach($friends->sortByDesc('created_at') as $friend)
                                                <div class="card-body">
                                                    <img class="card-img-top" src="{{asset('/public/cover_image/' . $friend->profile_image)}}" alt="Card image cap">
                                                    <div class="card-body-profile text-center">
                                                        <a href="{{route('profile', [$friend->id])}}" class="card-link text-primary w-100"><h6>{{$friend->name}}</h6></a>
                                                        <small>{{$friend->created_at->diffforHumans()}}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No one follow {{$user->name}}</p>
                                        @endif  
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="contact{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            {{Form::text('receiver', $user->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                            {{ Form::hidden('receiver_id', $user->id) }}
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
@endsection