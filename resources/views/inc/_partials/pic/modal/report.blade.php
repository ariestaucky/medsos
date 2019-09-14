<!-- Hidden report modal -->
<div class="modal fade" id="report{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        {!!Form::open(['route' => ['image_report'], 'method' => 'POST'])!!}
        <div class="modal-header">
            <h4 class="modal-title">Report Image content</h4>
        </div>
        <div class="modal-body">
            <input type="radio" name="reason" value="abusive" checked> Sexual, hateful or violent content<br>
            <input type="radio" name="reason" value="spam"> Spam or misleading<br>
            <input type="radio" name="reason" value="danger"> Harmfull or dangerous act
        </div>
        <div class="modal-footer">   
            {{Form::hidden('post_id', $poster->id)}}   
            {{Form::submit('Report', ['class' => 'btn btn-primary delete'])}}
            {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
        </div>
        {!!Form::close()!!}   
    </div>
</div>
</div>
<!-- End of Hidden modal -->