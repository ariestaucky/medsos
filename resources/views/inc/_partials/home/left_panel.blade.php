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