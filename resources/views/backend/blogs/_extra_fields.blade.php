<div>
    <div class="box-body">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12">
                @if($blog->blogComments()->count() > 0)
                    <div class="box no-shadow">
                        @foreach($blog->blogComments as $comment)
                            <!-- Post -->
                            <div class="post">
                                <div class="user-block">
                                    @if(!empty($comment->user_id))
                                        @if($comment->user->image)
                                            <img class="img-bordered-sm rounded-circle"
                                                 src="{{ asset(\Illuminate\Support\Facades\Storage::url($comment->user->image)) }}"
                                                 alt="user image">
                                        @else
                                            <img class="img-bordered-sm rounded-circle"
                                                 src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&size=128&background=random"
                                                 alt="user image">
                                        @endif
                                        <span class="username">
                                            <a href="#">
                                                {{ $comment->user->name }}
                                            </a>
                                        </span>
                                    @else
                                        <img class="img-bordered-sm rounded-circle"
                                             src="https://ui-avatars.com/api/?name={{ urlencode($comment->user_name) }}&size=128&background=random"
                                             alt="user image">
                                        <span class="username">
                                            <a href="#">
                                                {{ $comment->user_name }}
                                            </a>
                                        </span>
                                    @endif
                                    <span
                                        class="description">{{ $comment->created_at->format('M j, Y \a\t g:i a') }}</span>
                                </div>
                                <!-- /.user-block -->
                                <div class="activitytimeline">
                                    <p>
                                        {!! $comment->comment !!}
                                    </p>

                                    @if($comment->status == \App\Enums\CommentStatus::PENDING->value )
                                        <ul class="list-inline">
                                            <li>
                                                <a href="{{ route('admin.comment.approved', [$blog, $comment]) }}"
                                                   class="link-black text-sm text-success">
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i> Approve
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.comment.rejected', [$blog, $comment]) }}"
                                                   class="link-black text-sm text-danger">
                                                    <i class="fa fa-ban text-danger" aria-hidden="true"></i>
                                                    Reject
                                                </a>
                                            </li>
                                        </ul>
                                    @endif

                                    @if($comment->status == \App\Enums\CommentStatus::APPROVED->value )
                                        @if(empty($comment->reply_comment))
                                            <form action="{{ route('admin.comment-reply', [$blog, $comment]) }}"
                                                  method="post"
                                                  class="form-element">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-11">
                                                        <input class="form-control input-sm"
                                                               name="reply_comment"
                                                               type="text"
                                                               placeholder="Type a reply">
                                                    </div>
                                                    <div class="col-1">
                                                        <button type="submit"
                                                                class="waves-effect waves-light btn btn-outline btn-dark btn-sm">
                                                            Reply
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <div class="post">
                                                <div>
                                                    <h5><strong>Comment Reply</strong></h5>
                                                </div>
                                                <div class="user-block">
                                                    @if(!empty($comment->replied->image))
                                                        <img class="img-bordered-sm rounded-circle"
                                                             src="{{ asset(\Illuminate\Support\Facades\Storage::url($comment->replied->image)) }}"
                                                             alt="user image">
                                                    @else
                                                        <img class="img-bordered-sm rounded-circle"
                                                             alt="user image"
                                                             src="https://ui-avatars.com/api/?name={{ urlencode($comment->replied->name) }}&size=128&background=random">
                                                    @endif

                                                    <span class="username">
                                                        <a href="#">
                                                           {{ $comment->replied->name }}
                                                        </a>
                                                     </span>
                                                    <span
                                                        class="description">{{ $comment->reply_at->format('M j, Y \a\t g:i a') }}</span>
                                                </div>
                                                <!-- /.user-block -->
                                                <div class="activitytimeline">
                                                    <p>
                                                        {!! $comment->reply_comment !!}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endif


                                </div>
                            </div>
                            <!-- /.post -->
                        @endforeach
                    </div>
                @else
                    <div class="box no-shadow">
                        No comment found!
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
