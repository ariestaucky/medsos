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
<a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
    <i class="fa fa-share"></i> Share
</a>
<div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
    <div class="h6 dropdown-header">Share with</div>
    {{-- <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $poster->id)}}" data-pos="{{$poster->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a> --}}
    <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('share', $poster->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
</div>
@else
<a class="btn btn-link dropdown-toggle card-link text-primary pointer" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0 !important;">
    <i class="fa fa-share"></i> Share
</a>
<div class="dropdown-menu text-center" aria-labelledby="gedf-drop1">
    <div class="h6 dropdown-header">Share with</div>
    {{-- <a class="btn btn-primary social-facebook dropdown-item share share-button" data-ref="{{route('show', $poster->id)}}" data-pos="{{$poster->content}}"><i class="fa fa-facebook"></i>&nbsp; Facebook</a> --}}
    <a class="btn btn-primary social-twitter dropdown-item share" href="{{route('sharing', $poster->id)}}"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
</div>
@endif
<div class="text-muted h7 mb-2 pull-right"> <i class="fa fa-clock-o"></i> {{Carbon\Carbon::parse($poster->posted)->diffforHumans()}}</div>