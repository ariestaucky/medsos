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