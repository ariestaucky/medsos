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
                                            @if(count($post) > 0)
                                                <div class="infinite-scroll" data-next-page="{{ $post->nextPageUrl() }}">
                                                    @foreach($post as $poster)
                                                        @if($poster->waller_id == null)
                                                            @if($poster->type == 'public')
                                                                @include('inc._partials.profile.post.public')
                                                            @elseif($poster->type == 'followers')
                                                                @include('inc._partials.profile.post.follower')
                                                            @endif
                                                        @else
                                                            @include('inc._partials.profile.post.waller')
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