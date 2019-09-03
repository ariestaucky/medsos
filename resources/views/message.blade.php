@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    @include('inc.alert')
        <div class="col-sm-2">

        </div>

        <div class="col-md-8">
            <div class="card gedf-card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab">
                        <li class="nav-item">
                            <a class="nav-link active" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="true">
                                Inbox
                                @if(count(auth()->user()->unreadNotifications()->where('type', 'App\Notifications\NewMessage')->get()) > 0)
                                    <span class="notif has-notif"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="true">Sent</a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content profile-tab card-body" id="myTabContent">
                    <div class="w-100">
                        <div class="pull-right" style="margin: 10px;">
                            <button type="button" class="btn btn-success btn-sm" title="Create message" data-toggle="modal" data-target="#compose"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Compose Message</button>
                        </div>

                        <!-- Hidden message -->
                            <div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="contact">Message</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['url' => 'message/submit']) !!}
                                                <div class="form-group">
                                                    {{Form::label('receiver', 'Send to')}}
                                                    {{Form::text('receiver', '', ['class' => 'form-control', 'placeholder' => 'Enter Username' ])}}
                                                </div>
                                                <div class="form-group">
                                                    {{Form::label('subject', 'Subject')}}
                                                    {{Form::text('subject', $value = old("subject") , ['class' => 'form-control', 'placeholder' => 'Enter subject' ])}}
                                                </div>
                                                <div class="form-group">
                                                    {{Form::label('message', 'Massage')}}
                                                    {{Form::textarea('message', $value = old("message") , ['class' => 'form-control', 'placeholder' => 'Enter message' ])}}
                                                </div>
                                                <div>
                                                    {{ Form::submit('Send', ['class' => 'btn btn-primary']) }}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End hidden message -->
                    </div>
                    
                    <div class="table-responsive-sm tab-pane fade show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
                        <table class="table table-msg" data-form="deleteForm"> 
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:20%; text-align:center;">Sender</th>
                                    <th style="width:40%">Subject</th>
                                    <th style="width:20%; text-align:center;">Received</th> 
                                    <th style="width:20%; text-align:center;">Action</th>
                                </tr>
                            </thead>
                            @if(count($received) > 0 )
                                @foreach($received as $inbox)
                                    <tr>
                                        <td style="text-align:center;"><a href="/profile/{{$inbox['data']['sender_id']}}">{{$inbox['data']['sender_name']}}</a></td>
                                        <td>{{$inbox['data']['subject']}} 
                                            @if($inbox['read_at'] == null)
                                                <small><span class="notif has-notif"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span></small>
                                            @endif
                                        </td>
                                        <td>{{(Carbon\Carbon::parse($inbox['created_at']))->diffforHumans()}}</td> 
                                        <td style="text-align:center">
                                            <a href="{{route('read', ['id' => $inbox['data']['message_id']])}}" title="View"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                            @if($inbox['read_at'] == null)
                                                {!! Form::open(['route' => ['msg_update', $inbox['data']['message_id']], 'method' => 'PUT', 'style' => 'margin-bottom:0 !important; display:inline;']) !!}
                                                    <button type="submit" class="btn btn-warning btn-sm" title="Mark as Read"><i class="fa fa-check-square-o" aria-hidden="true"></i></button>
                                                {!! Form::close() !!}
                                            @else
                                                <button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#confirm{{$inbox['data']['message_id']}}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                
                                                <!-- Hidden confirmation modal -->
                                                <div class="modal fade" id="confirm{{$inbox['data']['message_id']}}" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Delete Confirmation</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Do you want to delete this?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {!! Form::open(['route' => ['delete', $inbox['data']['message_id']], 'method' => 'DELETE', 'style' => 'margin-bottom:0 !important; display:inline']) !!}
                                                                    <button type="submit" class="btn btn-sm btn-danger" id="delete-btn">Delete</button>
                                                                {!! Form::close() !!}                
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End of Hidden modal -->
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No Massage found!</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="table-responsive-sm tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
                    <table class="table table-msg">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:20%; text-align:center;">Receiver</th>
                                    <th style="width:40%">Subject</th>
                                    <th style="width:20%; text-align:center;">Sent</th> 
                                    <th style="width:20%; text-align:center;">Action</th>
                                </tr> 
                            </thead>
                            @if($sent->count() > 0 )
                                @foreach($sent as $outbox)
                                <tr>
                                    <td style="text-align:center;"><a href="/profile/{{$outbox->receiver_id}}">{{$outbox->receiver->name}}</a></td>
                                    <td>{{$outbox->subject}}</td>
                                    <td>{{$outbox->created_at->diffforHumans()}}</td> 
                                    <td style="text-align:center">
                                        <a href="{{route('read', ['id' => $outbox->id])}}" title="View"><button type="button" class="btn btn-success btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">No data found!</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">

        </div>
    </div>
</div>

@endsection