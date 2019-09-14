<!--- \\\\\\\Post-->
<div class="card gedf-card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                    a Poster</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Images</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                <form method="post" action="{{ route('post') }}" id="post">
                @csrf
                    <div class="form-group">
                        <label class="sr-only" for="content">post</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="What are you thinking?"></textarea>
                    </div>
                    <div class="btn-toolbar justify-content-between">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Share</button>
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
            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                <form method="post" action="{{ route('upload') }}" id="post" enctype="multipart/form-data">
                @csrf
                    <div class="form-group">
                        <label class="sr-only" for="caption"></label>
                        <input type="text" class="form-control" name="caption" id="caption" placeholder="Caption/Title">
                    </div>
                    <div class="form-group">
                        <div class="custom-file">
                            <label class="custom-file-label" for="customFile">
                                <i class="fa fa-cloud-upload"></i> Upload image
                            </label>
                            <input type="file" class="custom-file-input" id="customFile" name="image">
                        </div>
                    </div>                                                    
                    <div class="btn-toolbar justify-content-between">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary">Share</button>
                        </div>
                        <div class="btn-group">
                            <button id="btnGroupDrop2" type="button" class="btn btn-link dropdown-toggle pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
<!-- Post /////-->