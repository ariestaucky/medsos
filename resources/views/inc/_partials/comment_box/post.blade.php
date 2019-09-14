<div class="card-footer d-none" id="show-{{$poster->id}}">
    <form method="post" action="{{ route('comment') }}" id="comment-box" class="d-flex add-comment">
    @csrf
        <div class="form-group col-sm-10 padat">
            <label class="sr-only" for="content">post</label>
            <input class="form-control" style="" name="content" id="content input-{{$poster->id}}" placeholder="What are you thinking?">
            <input type="hidden" name="post_id" value="{{ $poster->id }}" />
            <input type="hidden" name="user_id" value="{{ $poster->user_id }}" />
        </div>
        <div class="btn-group col-sm-2 padat segaris">
            <button type="submit" class="btn btn-primary segaris">Comment</button>
        </div>
    </form>
    @if(App\Post::find($poster->id)->comments()->count() > 0)
        @foreach(App\Post::find($poster->id)->comments()->get() as $comment)
            <div class="d-flex comment-baru">
                <div class="col-sm-2 img padat">
                    <img class="rounded-circle" width="45" src="{{asset('/public/cover_image/' . $comment->user->profile_image)}}" alt="">
                </div>
                <div class="col-sm-10 padat break"> 
                    <div class="h5 m-0">
                        <a href="{{route('profile', [$comment->user->id])}}" class="card-link text-primary" title="profile">{{$comment->user->name}}</a>
                        <span class="mr-2 h6 small"> <small class="text-muted h6 small"> {{$comment->created_at->diffforHumans()}}</small></span>
                        <div class="card-link dropdown pull-right">
                            <button class="btn btn-link dropdown-toggle" style="padding:0 !important" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                @if(auth()->user()->id == $comment->user->id)
                                    <div class="h6 dropdown-header">Configuration</div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#comDel{{$comment->id}}">Delete</a>   
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editcom{{$comment->id}}">Edit</a>
                                @else
                                    <div class="h6 dropdown-header">Configuration</div>  
                                    <a class="dropdown-item card-link" href="#" title="message" data-toggle="modal" data-target="#contact-{{$comment->user->id}}">Message</a>
                                    
                                    @if(auth()->user()->isBlocking($comment))
                                    <a class="dropdown-item" href="/comment/unblock/{{$comment->id}}">Unblock</a>
                                    @else
                                    <a class="dropdown-item" href="/comment/block/{{$comment->id}}">Block</a>
                                    @endif
                                    
                                    @if(auth()->user()->report()->where('reported_id', $comment->id)->where('reported_type', 'App\Comment')->first())
                                    <a class="dropdown-item default-cursor">Reported</a>
                                    @else
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#report{{$comment->id}}">Report</a>     
                                    @endif
                                @endif
                            </div>
                        </div> 
                    </div>  
                    @if(auth()->user()->isBlocking($comment))
                    <P class="text-mute default-cursor"><i class="fa fa-ban" aria-hidden="true"></i> Blocked</P>
                    @else
                    <p> {{$comment->comment}}</p>
                    @endif
                </div>
            </div> 

            @include('inc._partials.comment_box.modal.del')
            @include('inc._partials.comment_box.modal.edit')
            @include('inc._partials.comment_box.modal.msg')
            @include('inc._partials.comment_box.modal.report')

        @endforeach    
        <hr class="narrow-hr">
        <span class="text-primary h7">
            <a href="/posts/{{$poster->id}}" class="card-link pointer"><i class="fa fa-share fa-flip-vertical" aria-hidden="true"></i>&nbsp; view poster</a>
        </span>
        <!-- <span class="text-muted h6 small pull-right" style="margin-bottom:0">2 of 300</span> -->
    @endif
</div>