@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
    <div class="col-sm-2">

    </div>

    <div class="col-md-8">
        <div class="row">
            <h2>ACTIVITY</h2>
            <hr>
            <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
        </div>      
        <hr>          
        <div class="row">
        @if(count($notifications) > 0)
            <div class="col">
                <ul class="list-group-striped">
                @foreach($notifications as $notif)
                    <li class="dropdown-header" style="padding: 0.5rem 0.5rem !important; word-break: break-word; width:100%; overflow:hidden; text-overflow:ellipsis;">
                        @if($notif['type'] === 'App\Notifications\NewFollower')
                            <a href="/profile/{{$notif['data']['follower_id']}}"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notif['created_at'])->diffforHumans()}} : <b class="text-primary">{{$notif['data']['follower_name']}}</b> follow you!</a>
                        @elseif($notif['type'] === 'App\Notifications\NewComment')
                            <a href="/posts/{{$notif['data']['post_id']}}"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notif['created_at'])->diffforHumans()}} : <b class="text-primary">{{$notif['data']['commenter_name']}}</b> comment on your poster!</a>
                        @elseif($notif['type'] === 'App\Notifications\ImageComment')
                            <a href="/Image/{{$notif['data']['post_id']}}"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notif['created_at'])->diffforHumans()}} : <b class="text-primary">{{$notif['data']['commenter_name']}}</b> comment on your uploaded image!</a>
                        @elseif($notif['type'] === 'App\Notifications\NewLike')
                            <a href="/posts/{{$notif['data']['post_id']}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notif['created_at'])->diffforHumans()}} : <b class="text-primary">{{$notif['data']['liker_name']}}</b> like your poster!</a>
                        @else($notif['type'] === 'App\Notifications\ImageLike')
                            <a href="/Image/{{$notif['data']['post_id']}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i>&nbsp; {{\Carbon\Carbon::parse($notif['created_at'])->diffforHumans()}} : <b class="text-primary">{{$notif['data']['liker_name']}}</b> like your uploaded image!</a>
                        @endif
                    </li>
                @endforeach
                </ul>
            </div> 
        @else
            <p class="text-center">You aren't doing anything yet!</p> 
        @endif
        </div>
    </div>
    
    <div class="col-sm-2">

    </div>
</div>
@endsection