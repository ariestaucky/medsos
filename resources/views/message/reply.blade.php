@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">

        </div>
        <div class="col-md-8">
            <div class="card gedf-card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab">
                        <li class="nav-item">
                            <a class="nav-link active" id="compose-tab" data-toggle="tab" href="#compose" role="tab" aria-controls="compose" aria-selected="true">Compose</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content profile-tab card-body" id="myTabContent">
                    <div class="tab-pane fade show active" id="compose" role="tabpanel" aria-labelledby="compose-tab">
                        {!! Form::open(['url' => 'reply/submit']) !!}
                            <div class="form-group">
                                {{Form::label('receiver', 'Send to')}}
                                {{Form::text('receiver', $msg->sender->username, ['class' => 'form-control', 'placeholder' => 'Enter Username' ])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('subject', 'Subject')}}
                                {{Form::text('subject', ('re:'.$msg->subject), ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('message', 'Massage')}}
                                {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                            </div>
                            <div>
                                {{ Form::hidden('receiver_id', $msg->sender->id) }}
                                {{Form::submit('Send', ['class' => 'btn btn-primary'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">

        </div>
    </div>
</div>
@endsection