@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="card col-md-8 mx-auto">
            <div class="card-header">Linked account setting</div>
            <div class="card-body">
            @include('inc.alert')
                <div class="row">
                    <div class="col-4 mx-auto text-center cover">
                        <img src="{{asset('/public/cover_image/' . auth()->user()->profile_image)}}" class="img-fluid centered-img rounded-circle" alt="Responsive image" style="border-radius:50%">
                    </div>
                </div>
                <br>
                <h5 class="card-title text-center"><strong>{{strtoupper(auth()->user()->name)}}</strong></h5>
                <p class="card-text text-center">All your linked account.</p>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-5  prev-account-item">
                        @if(auth()->user()->provider == 'facebook' or !empty(auth()->user()->fb))
                        <a href="#">
                        @else
                        <a href="/auth/facebook">
                        @endif
                            <div class="row">
                                <div class="col-md-4 ">
                                    @if(auth()->user()->provider == 'facebook' or !empty(auth()->user()->fb))
                                        <i class="fa fa-facebook fb"></i>
                                    @else
                                        <i class="fa fa-facebook"></i>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h3>Facebook</h3>
                                    @if(auth()->user()->provider == 'facebook')
                                        <span class="text-success">Linked with</span> {{auth()->user()->email}}
                                    @elseif(!empty(auth()->user()->fb))
                                        <span class="text-success">Linked with</span> {{auth()->user()->fb}}
                                    @else
                                        <span class="text-muted">Not linked yet</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div> 
                    <div class="col-md-5 prev-account-item">
                        @if(auth()->user()->provider == 'twitter' or !empty(auth()->user()->tw))
                        <a href="#">
                        @else
                        <a href="/auth/twitter">
                        @endif
                            <div class="row">
                                <div class="col-md-4 ">
                                    @if(auth()->user()->provider == 'twitter' or !empty(auth()->user()->tw))
                                        <i class="fa fa-twitter tw"></i>
                                    @else
                                        <i class="fa fa-twitter"></i>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h3>Twitter</h3>
                                    @if(auth()->user()->provider == 'twitter')
                                        <span class="text-success">Linked with</span> {{auth()->user()->email}}
                                    @elseif(!empty(auth()->user()->tw))
                                        <span class="text-success">Linked with</span> {{auth()->user()->tw}}
                                    @else
                                        <span class="text-muted">Not linked yet</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection