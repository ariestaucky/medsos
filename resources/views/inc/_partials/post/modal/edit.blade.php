<!-- Hidden edit modal -->
<div class="modal fade" id="editpos{{$poster->id}}" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-6">
                    <h4 class="modal-title">Edit</h4>
                </div>
                <div class="col-sm-6">         
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('editpos', [$poster->id]) }}" id="editpost">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="content">post</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?">{{$poster->content}}</textarea>
                    </div>
                    <div class="btn-toolbar justify-content-between">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Done</button>
                        </div>
                        <div class="btn-group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-globe" title="public"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right pointer" aria-labelledby="btnGroupDrop1" id="choose">
                                <a class="dropdown-item pointer" value="public" title="public"><i class="fa fa-globe"></i> Public</a>
                                <a class="dropdown-item pointer" value="followers" title="followers"><i class="fa fa-users"></i> Followers</a>
                                <a class="dropdown-item pointer" value="me" title="just me"><i class="fa fa-lock"></i> Just me</a>
                            </div>
                            <input type="hidden" name="post_type" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Hidden modal -->