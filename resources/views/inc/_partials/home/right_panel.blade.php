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