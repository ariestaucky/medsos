<!-- Hidden del confirmation modal -->
<div class="modal fade" id="confirmDelpos{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p style="text-align:center;">Do you want to delete this poster?</p> 
                <h4 class="text-primary" style="text-align:center;">{{$poster->content}}</h4>
            </div>
            <div class="modal-footer">   
                {!!Form::open(['route' => ['post_delete', $poster->id], 'method' => 'POST'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete', ['class' => 'btn btn-danger delete'])}}
                    {{Form::button('Cancel', ['class' => 'btn btn-secondary', 'data-dismiss' => 'modal', 'title' => 'close'])}}
                {!!Form::close()!!}          
            </div>
        </div>
    </div>
</div>
<!-- End of Hidden modal -->