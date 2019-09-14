<!-- Hidden message -->
<div class="modal fade" id="contact{{$poster->user_id}}" tabindex="-1" role="dialog" aria-labelledby="contact" aria-hidden="true">
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
                        {{Form::text('receiver', $poster->username, ['class' => 'form-control', 'placeholder' => 'Enter Username', 'disabled' => 'disabled' ])}}
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
                        {{ Form::hidden('receiver_id', $poster->user_id) }}
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