@extends('layouts.app')

@section('content')
    <article class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="login-main">

                </div>
            </div>
            <div class="col-sm-4">
                <div class="">
                    <h3><i class="fa fa-shield"></i> Register now</h3>
                    <hr>
                    <p class="hint-text text-center">Sign in with your social media account</p>           
                    <p class="text-center">
                        <a class="btn btn-primary social-login-btn social-facebook" href="/auth/facebook"><i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                        <a class="btn btn-primary social-login-btn social-twitter" href="/auth/twitter"><i class="fa fa-twitter"></i>&nbsp; Twitter</a>
                    </p>
                    
                    <div class="or-seperator"><b>or</b></div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" required>
                            @if ($errors->has('fname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fname') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Last Name" name="lname" required>
                            @if ($errors->has('lname'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('lname') }}</strong>
                                </span>
                            @endif
                        </div>

                        <!--<div class="form-group">-->
                        <!--    <p id="username"></p>-->
                        <!--    <input type="hidden" name="username_value" id="username_value">-->
                        <!--</div>-->

                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email Address" name="email" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="password_confirmation"  placeholder="Repeat Password" required>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Gender" style="padding-right:25px">Gender</label>
                            <select name="gender" required>
                                <option value="">Select...</option>
                                <option value="Male" name="gender">Male</option>
                                <option value="Female" name="gender">Female</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="Birthday" style="padding-right:15px">Birthday</label>
                            <input type="date" min="1945-01-01" name="bday" required>
                        </div>
                    
                        <small>
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            By clicking Register, you agree to our <a href="/ToS">Terms</a> and that you have read our <a href="/Privacy">Data Use Policy</a>, including our <a href="/cookie">Cookie</a> Use.
                        </small>	 
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>
@endsection