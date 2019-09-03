@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">

        </div>
        @isset($follower)
            <div class="col-md-8">
                <div class="row">
                    <h2>Follower</h2>
                    <hr>
                    <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
                </div>  
                <small>{{Auth::user()->followers()->get()->count()}} Total followers</small> 
                <hr>          
                <div class="row">
                @if(count($follower) > 0)
                    @foreach($follower as $fol)
                    <div class="col-sm-4 bg-white">
                        <div class="panel bottom-pad">
                            <h4 class="w-100 padat text-center"><a href="/profile/{{$fol->id}}" title="Profile" class="text-muted card-link">{{$fol->name}}</a></h4>
                            <div class="avatar">
                                <img src="{{asset('/public/cover_image/' . $fol->profile_image)}}" alt="" class="card-img-search rounded-circle">
                            </div>
                            <hr>
                            <div class="text-center">
                                <button type="button" data-id="{{$fol->id}}" class="btn {{ auth()->user()->isFollowing($fol) ? 'btn-outline-success' : 'btn-outline-primary' }} sidebar-follower">{{ auth()->user()->isFollowing($fol) ? 'Following' : 'Follow' }}</button>
                            </div>
                        </div>
                    </div> 
                    @endforeach
                    {{$follower->links()}}  
                @else
                    <p>Follower not found</p>
                @endif
                </div>
            </div>
        @endisset

        @isset($following)
            <div class="col-md-8" >
                <div class="row">
                    <h2>Following</h2>
                    <hr>
                    <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
                </div>
                <small>{{Auth::user()->following()->get()->count()}} Total following</small>
                <hr>
                <div class="row">
                @if(count($following) > 0)
                    @foreach($following as $result)
                        <div class="col-sm-4 bg-white">
                            <div class="panel bottom-pad">
                                <h4 class="w-100 padat text-center"><a href="/profile/{{$result->id}}" title="Profile" class="text-muted card-link">{{$result->name}}</a></h4>
                                <div class="avatar">
                                    <img src="{{asset('/public/cover_image/' . $result->profile_image)}}" alt="" class="card-img-search rounded-circle">
                                </div>
                                <hr>
                                <div class="text-center">
                                    <button type="button" data-id="{{$result->id}}" class="btn {{ auth()->user()->isFollowing($result) ? 'btn-outline-success' : 'btn-outline-primary' }} sidebar-follower">{{ auth()->user()->isFollowing($result) ? 'Following' : 'Follow' }}</button>
                                </div>
                            </div>
                        </div> 
                    @endforeach
                    {{$following->links()}}
                @else
                    <p>Following not found</p>
                @endif
                <div>
            </div>
        @endisset
        <div class="col-sm-2">

        </div>
    </div>
</div>
@endsection


