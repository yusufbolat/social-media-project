@extends('templates.default')

@section('content')
    <div class="row mt-5">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <form action="{{ route('status.post') }}" role="form" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <textarea style="border-bottom-left-radius:0; border-bottom-right-radius:0;" name="status" rows="1" class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" placeholder="What's up {{ Auth::user()->getFirstNameOrUsername() }}?"></textarea>
                    @if ($errors->has('status'))
                        <span class="invalid-feedback">{{ $errors->first('status') }}</span>
                    @endif
                    <input style="border-top-left-radius:0; border-top-right-radius:0;" type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}">
                    @if ($errors->has('image'))
                        <span class="invalid-feedback">{{ $errors->first('image') }}</span>
                    @endif
                </div>
                <button class="btn btn-primary mt-2">Update status</button>
                @csrf
            </form>
            <hr>
        </div>
    </div>
    <div class="row d-flex align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            @if (!$statuses->count())
                <p>There's nothing in your timeline, yet.</p>
            @else
                @foreach ($statuses as $status)
                    <div class="card mb-3">
                        <div class="col g-0">
                            @if ($status->img_url)
                                <div style="padding:0; margin:0;"class="col">
                                    <img style="max-width: 100%; max-height: 600px;" src="{{ asset("storage/images/$status->img_url") }}" class="img-fluid rounded-top" alt="...">
                                </div>        
                            @endif
                            <div class="col">
                                <div class="card-body">
                                    <a style="text-decoration: none;" href="{{ route('profile.index', ['username' => $status->user->username]) }}"><h6 class="card-title">{{ $status->user->getNameOrUsername() }}</h6></a>
                                    <p style="white-space: pre-wrap;" class="card-text">{{ $status->body }}</p>
                                    <hr>
                                    <div class="d-flex align-items-center justify-content-around bd-highlight mb-3" style="margin:0 !important;">
                                        @if ( Auth::user()->hasLikedStatus($status) )
                                            <a href="{{ route('status.like', ['statusId' => $status->id]) }}" style="width:auto;"><i style="color:red; font-size:1.3rem; margin-bottom:0 !important" class="bi bi-heart-fill p-2 bd-highlight"></i></a>
                                        @else
                                            <a href="{{ route('status.like', ['statusId' => $status->id]) }}" style="width:auto;"><i style="color:black; font-size:1.3rem; margin-bottom:0 !important" class="bi bi-heart p-2 bd-highlight"></i></a>    
                                        @endif
                                        <p class="text-start p-2 bd-highlight" style="font-size:0.8rem; font-weight:600; margin-left:1.5rem; margin-bottom:0 !important">{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</p>
                                        <p class="text-end text-muted ms-auto p-2 bd-highlight" style="font-size:0.7rem; margin-bottom:0 !important">Last updated {{ $status->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <form action="{{ route('status.reply', ['statusId' => $status->id]) }}" role="form" method="POST">
                                <div class="form-group d-flex align-items-center justify-content-around bd-highlight mt-2">
                                    <div class="p-2 bd-highlight flex-grow-1">
                                        <textarea name="reply-{{ $status->id }}" class="form-control" rows="1" placeholder="Reply to this status"></textarea>
                                    </div>
                                    <div class="ms-auto p-2 bd-highlight">
                                        <input type="submit" value="Reply" class="btn btn-primary btn-md">
                                        <input type="hidden" name="_token" value="{{ Session::token() }}">
                                    </div>
                                </div>
                            </form>
                            <div class="comments row mt-3">
                                @if (!$status->replies->count())
                                    <p style="font-size: 0.7rem; color: grey;">No comments yet.</p>
                                @endif
                                @foreach ($status->replies as $reply)
                                    <div class="mt-1">
                                        <div class="d-flex">
                                            <img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->getNameOrUsername() }}"
                                                class="flex-shrink-0 rounded-circle" style="width:30px;height:30px;">
                                            <div class="ms-3 mt-1">
                                                <p class="text-primary" style="font-size: 0.8rem;"><a style="text-decoration: none;" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a> <small style="color:black;">{{ $reply->body }}</small></p>
                                                <p style="font-size: 0.7rem; color: grey;">{{ $reply->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                {!! $statuses->render() !!}
            @endif
        </div>
    </div>
@stop