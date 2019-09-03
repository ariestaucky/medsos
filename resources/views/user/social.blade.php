<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Artikel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head> 
<body>

<main role="main" class="container">
    <div class="row">
        <div class="card col-md-8 mx-auto">
            <h5 class="card-header">WELCOME</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-4 mx-auto text-center">
                        <img src="{{asset('/public/cover_images/' . auth()->user()->profile_image)}}" class="img-fluid centered-img" alt="Responsive image" style="border-radius:50%">
                    </div>
                </div>
                <br>
                <h5 class="card-title text-center">Hi <strong>{{auth()->user()->name}}!</strong></h5>
                <p class="card-text text-center">To complate your registration, please enter your new password for Artikel!</p>
                <hr>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('complete', auth()->user()->id) }}">
                    @csrf
                    <p class="card-text text-center">Your account detail!</p>
                    <div class="form-group form-inline">
                        <div class="col-sm-6">
                            <label class="col-md-6 control-label" style="justify-content:left !important">Email</label>
                            <div class="col-md-10">
                            <p class="form-control-static">{{auth()->user()->email}}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="col-md-6 control-label" style="justify-content:left !important">Usename</label>
                            <div class="col-md-10">
                            <p class="form-control-static">{{auth()->user()->username}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="inputPassword" class="col-md-6 control-label">Password</label>
                        <div class="col">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="col-md-6 control-label">Confirm</label>
                        <div class="col">
                            <input type="password" class="form-control" id="password-confirm" placeholder="Confirm" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-6" style="text-align: center;max-width: 100% !important;">
                            {{Form::hidden('_method','PUT')}}
                            {{Form::submit('Complete', ['class'=>'btn btn-primary'])}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>

</body>
</html>  