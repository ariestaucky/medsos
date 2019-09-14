@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('inc.alert')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                         <div class="form-group row">
                            <label for="fname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
                            
                            <div class="col-md-6">
                                <input type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" placeholder="First Name" name="fname" id="fname" value="{{ old('fname') }}" required>
                                
                                @if ($errors->has('fname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
                            
                            <div class="col-md-6">                        
                                <input type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" placeholder="Last Name" id= "lname" name="lname" value="{{ old('lname') }}" required>
                                
                                @if ($errors->has('lname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="E-mail Address" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="Gender" style="padding-right:25px">Gender</label>
                            
                            <div class="col-md-6">
                                <select name="gender" required>
                                    <option value="">Select...</option>
                                    <option value="Male" name="gender">Male</option>
                                    <option value="Female" name="gender">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right" for="Birthday" style="padding-right:15px">Birthday</label>
                            
                            <div class="col-md-6">
                                <input type="date" min="1945-01-01" name="bday" required>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right"></div>
                            <div class="col-md-6">
                                <small>
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    By clicking Register, you agree to our <a href="/ToS">Terms</a> and that you have read our <a href="/Privacy">Data Use Policy</a>, including our <a href="/cookie">Cookie</a> Use.
                                </small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right"></div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
