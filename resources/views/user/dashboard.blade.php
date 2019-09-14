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
                            @include('inc._partials.home.create')

                            <!--- \\\\\\\Post BODY-->
                            <div class="infinite-scroll" data-next-page="{{ $post->nextPageUrl() }}">
                                @foreach($post as $poster)
                                    @if($poster->waller_id == null)
                                        @include('inc._partials.home.post.body')
                                    @else
                                        @include('inc._partials.home.post.waller')
                                    @endif
                                @endforeach
                                {{$post->links()}}
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
                            @include('inc._partials.dashboard.fav')  
                            
                            @if(count($fav) > 0)
                            <div class="row mx-auto">
                                <a href="#" id="loadMore" class="row mx-auto"><span>Load More</span></a>
                            </div>
                            @endif
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
@endsection