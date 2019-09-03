@extends('layouts.app')

@section('content')
    <div class="container emp-profile">
        @include('inc.alert')
        <form method="POST" action="{{route('update', [$user->id])}}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="profile-img">
                        <img src="{{asset('/public/cover_image/' . Auth::user()->profile_image)}}" alt="profile_image" class="w-100" />
                    </div>
                    <div class="profile-work">
                        <div id="image-preview">
                            <label for="image-upload" id="image-label">Change avatar</label>
                            <input type="file" name="pic" id="image-upload" />
                        </div>
                        <small>Max 500kb, jpg, jpeg and png only</small>
                    </div>
                </div>

                <div class="col-md-9">
		            <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Your Profile</h4>
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label for="firstname" class="col-4 col-form-label">First Name*</label> 
                                        <div class="col-8">
                                            <input id="firstname" name="firstname" placeholder="First name" class="form-control here" required="required" type="text" value="{{ old('firstname', $user->fname) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lastname" class="col-4 col-form-label">Last Name*</label> 
                                        <div class="col-8">
                                            <input id="lastname" name="lastname" placeholder="Last Name" class="form-control here" required="required" type="text" value="{{ old('lastname', $user->lname) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Email*</label> 
                                        <div class="col-8">
                                            <input id="email" name="email" placeholder="Email" class="form-control here" required="required" type="text" value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lastname" class="col-4 col-form-label">Birthday*</label> 
                                        <div class="col-8">
                                            <input id="birthday" name="birthday" class="form-control here" type="date" min="1945-01-01" value="{{  old('birthday', $user->bday) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="text" class="col-4 col-form-label">Status</label> 
                                        <div class="col-8">
                                            <select name="status">
                                                <option value="">Select...</option>
                                                <option value="single" name="status" {{$user->status == 'Single' ? 'selected' : ''}} >Single</option>
                                                <option value="in relationship" name="status" {{$user->status == 'In relationship' ? 'selected' : ''}} >In Relationship</option>
                                                <option value="Engage" name="status" {{$user->status == 'Engage' ? 'selected' : ''}} >Engage</option>
                                                <option value="married" name="status" {{$user->status == 'Married' ? 'selected' : ''}} >Married</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="select" class="col-4 col-form-label">Gender</label> 
                                        <div class="col-8">
                                            <select name="gender">
                                                <option value="">Select...</option>
                                                <option value="Male" name="gender" {{$user->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                                <option value="Female" name="gender" {{$user->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="website" class="col-4 col-form-label">Motto</label> 
                                        <div class="col-8">
                                            <input id="motto" name="motto" placeholder="Motto" class="form-control here" type="text" value="{{  old('motto', $user->motto) }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="newpass" class="col-4 col-form-label">Profession</label> 
                                        <div class="col-8">
                                            <input id="job" name="job" placeholder="Your profession" class="form-control here" type="text" value="{{  old('job', $user->job) }}">
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label for="newpass" class="col-4 col-form-label">City</label> 
                                        <div class="col-8">
                                            <input id="city" name="city" placeholder="City" class="form-control here" type="text" value="{{  old('city', $user->city) }}">
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label for="newpass" class="col-4 col-form-label">Nationality</label> 
                                        <div class="col-8">
                                            <input id="country" name="country" placeholder="Country" class="form-control here" type="text" value="{{  old('country', $user->country) }}">
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label for="newpass" class="col-4 col-form-label">Address</label> 
                                        <div class="col-8">
                                            <textarea id="address" name="address" cols="40" rows="4" class="form-control">{{  old('address', $user->address) }}</textarea>
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label for="publicinfo" class="col-4 col-form-label">Public Info</label> 
                                        <div class="col-8">
                                            <textarea id="bio" name="bio" cols="40" rows="4" class="form-control">{{  old('bio', $user->bio) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            {{Form::hidden('_method','PUT')}}
                                            {{Form::submit('Upddate', ['class'=>'btn btn-primary'])}}
                                            <a href="/profile/{{$user->id}}" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>               
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection