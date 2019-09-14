@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    @include('inc.alert')
        @include('inc._partials.home.left_panel')

        <div class="col-md-6 gedf-main">
            <div class="card gedf-card suggestion">
                <div class="container">
                    <div class="row">
                        <div class="slide" style="overflow-x: auto;">
                            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                <ol class='carousel-indicators'>
                                    @foreach($friend as $friends)
                                    <li data-target='#carousel-custom' class='active'>
                                        <a href="{{route('profile', [$friends->id])}}" class="card-link text-primary">
                                            <img src="{{asset('/public/cover_image/' . $friends->profile_image)}}" alt='' />
                                            <br>
                                            <span>{{$friends->name}}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('inc._partials.home.create')

            <!--- \\\\\\\Post-->
            <div class="infinite-scroll" data-next-page="{{ $post->nextPageUrl() }}">
                @foreach($post as $poster)
                    @if($poster->waller_id == null)
                        @include('inc._partials.home.post.body')
                    @else
                        @include('inc._partials.home.post.waller')
                    @endif
                @endforeach

                {!! $post->links() !!}
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

        <div class="col-md-3"> 
            @include('inc._partials.home.right_panel')
        </div>
    </div>
</div>
@endsection
