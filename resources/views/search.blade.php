@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8  mx-auto">
            <h3 class="pb-3 mb-4 font-italic border-bottom">
            {{count($search)}} Result for @if($searchTerm == null) {{auth()->user()->name}} @else {{$searchTerm}} @endif
            </h3>
            @if(count($search) > 0)
                @foreach($search as $result)
                <div class="row bg-white">
                    <div class="col-md-3 avatar pull left">
                        <img src="{{asset('/public/cover_image/' . $result->profile_image)}}" class="rounded-circle card-img-top">
                    </div>   
                    <div class="col-md-9 card pull-right">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <a href="{{route('profile', [$result->id])}}" title="Profile" class="card-link"><h2>{{$result->name}}</h2></a>
                            @if($result->id == auth()->user()->id)
                                <a href="{{route('profile', [$result->id])}}"><button type="button" class="btn btn-outline-primary pull-right">Profile</button></a>
                            @else
                                <button type="button" class="btn {{ auth()->user()->isFollowing($result) ? 'btn-outline-success' : 'btn-outline-primary' }} sidebar-follower pull-right" data-id="{{ $result->id }}">{{ auth()->user()->isFollowing($result) ? 'Following' : 'Follow' }}</button>
                            @endif
                        </div>
                        <div class="card-body padat"> 
                            <div class="col-sm-12">
                                <small>Last seen : {{$result->updated_at->diffforHumans()}}</small>
                            </div>
                            <div class="col-sm-6 pull-left">
                                <a href="/follower/{{$result->id}}"><p class="text-primary card-link">Follower: <span id="side-counter-{{$result->id}}">{{$result->followers()->count()}}</span></p></a>
                            </div>
                            <div class="col-sm-6 pull-right">
                                <a href="/following/{{$result->id}}"><p class="text-primary card-link">Following: <span>{{$result->following()->count()}}</span></p></a>
                            </div>
                        </div>
                    </div>
                </div><!-- /.blog-post -->
                <hr>
                @endforeach
                {{$search->links()}}
            @else
                <p>Nothing found</p>
            @endif
        </div><!-- /.blog-main -->
    </div>
</div>
@endsection