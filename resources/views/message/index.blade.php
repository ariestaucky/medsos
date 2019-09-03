@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-2">

        </div>
            @isset($inc)
                <div class="col-md-8 card">
                    <div class="card-header">
                        <div class="row">
                            <h2>Message</h2>
                            <hr>
                            <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="msg" style="width:100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:100%"><p class="para">From : <a href="/profile/{{$inc->sender->id}}">{{$inc->sender->name}}</a></p></td>
                                </tr>
                                <tr>
                                    <td style="width:100%"><p>To : You</p></td>
                                </tr>
                                <tr>
                                    <td style="width:100%"><p>Subject : {{$inc->subject}}</p><hr></td>
                                </tr>
                                <tr>
                                    <td style="width:100%"><p>{{$inc->message}}</p></td>
                                </tr>
                            </table>                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('create', [$id = $inc->id])}}">
                            <span class="pull-right">
                                <button class="btn btn-success btn-sm">Reply</button>
                            </span>
                        </a>
                    </div>
                </div>
            @endisset

            @isset($sent)
                <div class="col-md-8 card">
                    <div class="card-header">
                        <div class="row">
                            <h2>Message</h2>
                            <hr>
                            <a href="{{route('back')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="msg" style="width:100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:100%"><p class="para">From : You</p></td>
                                </tr>
                                <tr>
                                    <td style="width:100%"><p>To : <a href="/profile/{{$sent->receiver->id}}">{{$sent->receiver->name}}</a></p></td>
                                </tr>
                                <tr>
                                    <td style="width:100%"><p>Subject : {{$sent->subject}}</p><hr></td>
                                </tr>
                                <tr>
                                    <td style="width:100%"><p>{{$sent->message}}</p></td>
                                </tr>
                            </table>                    
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="pull-right">
                            <button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#msgdel{{$sent->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </div>
                    </div>

                    <!-- Hidden confirmation modal -->
                    <div class="modal fade" id="msgdel{{$sent->id}}" tabindex="-1" role="dialog" aria-labelledby="confirm" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Do you want to delete this?</p>
                                    <h4 class="text-center text-primary">{{$sent->subject}}</h4>
                                </div>
                                <div class="modal-footer">
                                    {!!Form::open(['route' => ['delete', $sent->id], 'method' => 'POST'])!!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                                        {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                                    {!!Form::close()!!}               
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Hidden modal -->
                </div>
            @endisset
        <div class="col-sm-2">

        </div>
    </div>
</div>
@endsection